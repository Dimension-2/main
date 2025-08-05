<?php
require_once 'config.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM preorder_requests WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');
if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'Request not found']);
}