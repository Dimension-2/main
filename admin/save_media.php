<?php
require_once '../config.php';
header('Content-Type: application/json');

if(isset($_POST['save_media'])) {
    $id = intval($_POST['id']);
    $content_type = $_POST['content_type'];
    $section = $_POST['section'];
    $description = $_POST['description'];
    
    if($content_type === 'text') {
        $content_text = $_POST['content_text'];
        $query = $conn->prepare("UPDATE Main_file_Content SET section=?, description=?, content_text=? WHERE id=?");
        $query->bind_param("sssi", $section, $description, $content_text, $id);
    } 
    else {
        $alt_text = ($content_type === 'image') ? $_POST['alt_text'] : '';
        
        // Handle file upload if a new file was provided
        if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../' . ($content_type === 'image' ? 'image/' : 'video/');
            $file_name = basename($_FILES['file']['name']);
            $target_path = $upload_dir . $file_name;
            
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
                $query = $conn->prepare("UPDATE Main_file_Content SET section=?, description=?, file_path=?, alt_text=? WHERE id=?");
                $query->bind_param("ssssi", $section, $description, $target_path, $alt_text, $id);
            } else {
                echo json_encode(['success' => false, 'message' => 'File upload failed']);
                exit;
            }
        } else {
            // No new file, just update other fields
            $query = $conn->prepare("UPDATE Main_file_Content SET section=?, description=?, alt_text=? WHERE id=?");
            $query->bind_param("sssi", $section, $description, $alt_text, $id);
        }
    }
    
    if($query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>