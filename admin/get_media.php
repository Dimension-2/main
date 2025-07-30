<?php
require_once '../config.php';

header('Content-Type: application/json');
ob_start();

// Enhanced error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

try {
    // Strict ID validation
    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT, ['min_range' => 1])) {
        throw new InvalidArgumentException("Invalid media ID", 400);
    }

    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT 
        id, content_type,
        COALESCE(NULLIF(TRIM(file_path), ''), NULL) AS file_path,
        COALESCE(NULLIF(TRIM(description), ''), NULL) AS description,
        COALESCE(NULLIF(TRIM(section), ''), NULL) AS section,
        COALESCE(NULLIF(TRIM(alt_text), ''), NULL) AS alt_text,
        COALESCE(NULLIF(TRIM(content_text), ''), NULL) AS content_text,
        last_updated
        FROM Main_file_Content WHERE id = ?");

    if (!$stmt) throw new RuntimeException("Database error", 500);
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if (!$result = $stmt->get_result()) {
        throw new RuntimeException("Database error", 500);
    }

    if ($result->num_rows === 0) {
        throw new RuntimeException("Media not found", 404);
    }

    $data = $result->fetch_assoc();

    // Secure output
    $data = array_map(function($value) {
        return is_string($value) 
            ? htmlspecialchars(preg_replace('/[^\x20-\x7E]/', '', $value), ENT_QUOTES, 'UTF-8')
            : $value;
    }, $data);

    ob_end_clean();
    echo json_encode($data, JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR);

} catch (InvalidArgumentException $e) {
    http_response_code(400);
    exit(json_encode(['error' => $e->getMessage()]));
} catch (RuntimeException $e) {
    http_response_code($e->getCode() ?: 404);
    exit(json_encode(['error' => $e->getMessage()]));
} catch (Throwable $e) {
    error_log("Critical Error: " . $e->getMessage());
    http_response_code(500);
    exit(json_encode(['error' => 'System error']));
}
?>