<?php
require_once '../config.php';
header('Content-Type: application/json');

// Force clean output
ob_clean();

// Add strict error checking
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable on-screen errors
ini_set('log_errors', 1);

try {
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception("Invalid ID");
    }

    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT 
        id,
        content_type, 
        TRIM(BOTH '\"' FROM file_path) AS file_path,
        TRIM(BOTH '\"' FROM description) AS description,
        TRIM(BOTH '\"' FROM section) AS section,
        TRIM(BOTH '\"' FROM alt_text) AS alt_text,
        content_text,
        last_updated
        FROM Main_file_Content WHERE id = ?");
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 0) {
        throw new Exception("No record found");
    }

    $data = $result->fetch_assoc();
    
    // Clean all string fields
    foreach ($data as $key => $value) {
        if(is_string($value)) {
            $data[$key] = preg_replace('/[^\x20-\x7E]/', '', $value); // Remove non-ASCII
            $data[$key] = str_replace(['"',"'",'\\'], '', $value); // Remove quotes
        }
    }

    echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

// Ensure no extra output
exit();
?>