<?php
require_once '../config.php';
header('Content-Type: application/json');

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM Main_file_Content WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    
    if($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Media not found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>