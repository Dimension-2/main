<?php
declare(strict_types=1);
session_start();
require_once '../config.php';

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

    // Validate required fields
    if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
        throw new InvalidArgumentException("Invalid ID", 400);
    }

    $id = (int) $_POST['id'];
    $section = htmlspecialchars(trim($_POST['section'] ?? ''));
    $description = htmlspecialchars(trim($_POST['description'] ?? ''));
    $alt_text = htmlspecialchars(trim($_POST['alt_text'] ?? ''));
    $content_text = htmlspecialchars(trim($_POST['content_text'] ?? ''));
    $content_type = $_POST['content_type']; // Get the exact content type

    // Process file upload if exists
    $file_path = null;
    if (!empty($_FILES['file']['name'])) {
        $target_dir = realpath(__DIR__ . '/../uploads') . DIRECTORY_SEPARATOR;

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $file = $_FILES['file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Allowed formats
        $allowed_extensions = [
            // Images
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp',
            'tiff',
            'bmp',
            'heif',
            'heic',
            'svg',
            'eps',
            'ai',
            'pdf',
            'cr2',
            'nef',
            'arw',
            'psd',
            'indd',
            'avif',
            'ico',
            'mng',
            'bpg',
            'flif',
            'jfif',
            'jxr',
            'pgf',

            // Videos
            'mp4',
            'mov',
            'avi',
            'wmv',
            'flv',
            'webm',
            'mkv',
            'mts',
            'm2ts',
            'mpg',
            'mpeg',
            '3gp',
            '3g2',
            'vob',
            'ogg',
            'rm',
            'rmvb',
            'asf',
            'amv',
            'svi',
            'mxf',
            'roq',
            'nsv',
            'f4v',
            'drc',
            'prores',
            'dnxhr',
            'cineform',
            'hevc',
            'h265'
        ];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Validate extension
        if (!in_array($ext, $allowed_extensions)) {
            throw new InvalidArgumentException("Unsupported file format", 400);
        }

        // Basic MIME type check
        if (
            !str_starts_with($file['type'], 'image/') &&
            !str_starts_with($file['type'], 'video/') &&
            !str_starts_with($file['type'], 'application/')
        ) {
            throw new InvalidArgumentException("Invalid file type", 400);
        }

        // Set size limits
        // $max_size = in_array($ext, ['mp4', 'mov', 'avi']) ? 50_000_000 : 5_000_000;
        // if ($file['size'] > $max_size) {
        //     throw new InvalidArgumentException("File too large", 400);
        // }

        $new_filename = uniqid('', true) . '.' . $ext;
        $target_path = $target_dir . $new_filename;

        if (!move_uploaded_file($file['tmp_name'], $target_path)) {
            throw new RuntimeException("Failed to upload file", 500);
        }

        $file_path = "uploads/" . $new_filename;
    }

    // Update database
    // Update database
    $conn->begin_transaction();

    if ($content_type === 'text') {
        // Handle text content updates
        $sql = "UPDATE Main_file_Content SET 
            section = ?, 
            description = ?, 
            content_text = ?
            WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Database error", 500);
        }

        $stmt->bind_param("sssi", $section, $description, $content_text, $id);
    } else {
        // Handle image/video updates
        $sql = "UPDATE Main_file_Content SET 
            section = ?, 
            description = ?, 
            " . ($file_path ? "file_path = ?, " : "") . "
            alt_text = ?,
            content_type = ?
            WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Database error", 500);
        }

        $params = [$section, $description];
        if ($file_path)
            $params[] = $file_path;
        $params = array_merge($params, [$alt_text, $content_type, $id]);

        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        throw new RuntimeException("Update failed", 500);
    }

    $conn->commit();
    echo json_encode(['status' => 'success']);

} catch (InvalidArgumentException $e) {
    http_response_code(400);
    exit(json_encode(['error' => $e->getMessage()]));
} catch (RuntimeException $e) {
    $conn->rollback();
    http_response_code($e->getCode() ?: 500);
    exit(json_encode(['error' => $e->getMessage()]));
} catch (Throwable $e) {
    $conn->rollback();
    error_log("Error: " . $e->getMessage());
    http_response_code(500);
    exit(json_encode(['error' => 'System error']));
}
?>