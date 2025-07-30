<?php
require_once '../config.php';

$historyId = (int)$_POST['history_id'];
$history = $conn->query("SELECT * FROM media_history WHERE id = $historyId")->fetch_assoc();
$oldData = json_decode($history['old_data'], true);

// Update media with old data
$conn->query("UPDATE Main_file_Content SET 
    section = '{$oldData['section']}',
    description = '{$oldData['description']}',
    file_path = '{$oldData['file_path']}'
    WHERE id = {$history['media_id']}");

echo "success";
?>