<?php
require_once '../config.php';

$mediaId = (int)$_POST['media_id'];
$conn->query("DELETE FROM media_history WHERE media_id = $mediaId");
echo "cleared";
?>