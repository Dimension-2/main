<?php
declare(strict_types=1);
session_start();
require_once '../config.php';

// Enable detailed error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException("Method not allowed", 405);
    }

    // Validate session
    if (empty($_SESSION['username'])) {
        throw new RuntimeException("Unauthorized", 401);
    }

    // Validate ID
    if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
        throw new InvalidArgumentException("Invalid ID", 400);
    }

    $id = (int)$_POST['id'];
    $section = sanitize($_POST['section'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $alt_text = sanitize($_POST['alt_text'] ?? '');
    $content_text = sanitize($_POST['content_text'] ?? '');
    $content_type = in_array($_POST['content_type'] ?? '', ['image', 'video', 'text'], true) 
        ? $_POST['content_type'] 
        : 'image';

    $conn->begin_transaction();
    $oldData = fetchMedia($conn, $id);
    $file_path = processUpload($oldData['file_path'] ?? null);
    
    updateMedia(
        $conn, 
        $id, 
        $section, 
        $description, 
        $file_path, 
        $alt_text, 
        $content_text, 
        $content_type
    );
    
    logHistory(
        $conn, 
        $id, 
        $oldData, 
        compact('section', 'description', 'file_path', 'alt_text', 'content_text'),
        $_SESSION['username']
    );

    $conn->commit();
    echo json_encode(['status' => 'success']);

} catch (InvalidArgumentException $e) {
    http_response_code(400);
    exit(json_encode(['error' => $e->getMessage()]));
} catch (RuntimeException $e) {
    http_response_code($e->getCode() ?: 400);
    exit(json_encode(['error' => $e->getMessage()]));
} catch (Throwable $e) {
    $conn->rollback();
    error_log("CRITICAL: " . $e->getMessage());
    http_response_code(500);
    exit(json_encode(['error' => 'System error: ' . $e->getMessage()])); // Show actual error to client for debugging
}

// Helper functions
function sanitize(string $value): string {
    return htmlspecialchars(trim(strip_tags($value)), ENT_QUOTES, 'UTF-8');
}

function fetchMedia(mysqli $conn, int $id): array {
    $stmt = $conn->prepare("SELECT * FROM Main_file_Content WHERE id = ?");
    if (!$stmt) {
        throw new RuntimeException("Database preparation failed: " . $conn->error, 500);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        throw new RuntimeException("Database query failed", 500);
    }
    $data = $result->fetch_assoc();
    if (!$data) {
        throw new RuntimeException("Media record not found", 404);
    }
    return $data;
}

function processUpload(?string $current_path): ?string {
    if (empty($_FILES['file']['name'])) {
        return $current_path;
    }

    // Convert relative path to absolute path for Windows
    $target_dir = realpath(__DIR__ . '/../uploads') . DIRECTORY_SEPARATOR;
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0755, true)) {
            throw new RuntimeException("Failed to create upload directory: " . error_get_last()['message'], 500);
        }
    }

    // Verify directory is writable
    if (!is_writable($target_dir)) {
        throw new RuntimeException("Upload directory is not writable", 500);
    }

    $file = $_FILES['file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Validate upload
    validateUpload($file, $ext);
    
    // Generate unique filename
    $new_filename = uniqid('', true) . '.' . $ext;
    $target_path = $target_dir . $new_filename;

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $target_path)) {
        $error = error_get_last();
        throw new RuntimeException("Failed to move uploaded file: " . ($error['message'] ?? 'Unknown error'), 500);
    }

    // Delete old file if it exists
    if ($current_path) {
        $old_file_path = realpath(__DIR__ . '/../' . $current_path);
        if ($old_file_path && file_exists($old_file_path)) {
            unlink($old_file_path);
        }
    }

    return "uploads/" . $new_filename;
}

function validateUpload(array $file, string $ext): void {
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($ext, $allowed_types, true)) {
        throw new InvalidArgumentException("Only JPG, JPEG, PNG & GIF files are allowed", 400);
    }
    
    if ($file['size'] > 5_000_000) { // 5MB
        throw new InvalidArgumentException("File too large (max 5MB)", 400);
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("Upload error code: " . $file['error'], 500);
    }
}

function updateMedia(
    mysqli $conn,
    int $id,
    string $section,
    string $description,
    ?string $file_path,
    string $alt_text,
    string $content_text,
    string $content_type
): void {
    $query = match($content_type) {
        'text' => "UPDATE Main_file_Content SET 
                  section=?, description=?, content_text=?, file_path=NULL 
                  WHERE id=?",
        default => "UPDATE Main_file_Content SET 
                  section=?, description=?, file_path=?, alt_text=? 
                  WHERE id=?"
    };

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new RuntimeException("Database preparation failed: " . $conn->error, 500);
    }
    
    $params = $content_type === 'text'
        ? [$section, $description, $content_text, $id]
        : [$section, $description, $file_path, $alt_text, $id];
    
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
    
    if (!$stmt->execute()) {
        throw new RuntimeException("Database update failed: " . $stmt->error, 500);
    }
}

function logHistory(
    mysqli $conn,
    int $id,
    array $oldData,
    array $newData,
    string $username
): void {
    $stmt = $conn->prepare("INSERT INTO media_history 
                          (media_id, old_data, new_data, changed_by) 
                          VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new RuntimeException("History log preparation failed: " . $conn->error, 500);
    }
    
    try {
        $jsonOld = json_encode($oldData, JSON_THROW_ON_ERROR);
        $jsonNew = json_encode($newData, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        throw new RuntimeException("Failed to encode history data", 500);
    }
    
    $stmt->bind_param("isss", $id, $jsonOld, $jsonNew, $username);
    
    if (!$stmt->execute()) {
        throw new RuntimeException("History log failed: " . $stmt->error, 500);
    }
}
?>