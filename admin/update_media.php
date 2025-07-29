<?php
require_once '../config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $section = $_POST['section'];
    $description = $_POST['description'];
    $alt_text = $_POST['alt_text'] ?? null;
    $content_text = $_POST['content_text'] ?? null;
    
    // Handle file upload if a new file was provided
    if(!empty($_FILES['file']['name'])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        $file_path = "uploads/" . basename($_FILES["file"]["name"]);
        
        $query = "UPDATE Main_file_Content SET section=?, description=?, file_path=?, alt_text=?, content_text=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $section, $description, $file_path, $alt_text, $content_text, $id);
    } else {
        $query = "UPDATE Main_file_Content SET section=?, description=?, alt_text=?, content_text=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $section, $description, $alt_text, $content_text, $id);
    }
    
    mysqli_stmt_execute($stmt);
    echo "success";
}
?>  