<?php
require_once '../config.php';
header('Content-Type: application/json');

$mediaId = (int)$_GET['media_id'];
$result = $conn->query("SELECT * FROM media_history WHERE media_id = $mediaId ORDER BY changed_at DESC");
$data = [];

while ($row = $result->fetch_assoc()) {
    $row['old_data'] = json_decode($row['old_data'], true);
    $row['new_data'] = json_decode($row['new_data'], true);
    $data[] = $row;
}

echo json_encode($data);
?>