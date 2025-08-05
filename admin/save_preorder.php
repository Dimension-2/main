<?php
require_once 'config.php';

// Get form data
$data = [
    'first_name' => $_POST['firstName'],
    'last_name' => $_POST['lastName'],
    // Add all other fields...
];

// Insert into database
$stmt = $conn->prepare("INSERT INTO preorder_requests (...) VALUES (...)");
$stmt->bind_param(...);
$stmt->execute();

echo json_encode(['success' => true]);