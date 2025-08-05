<?php
require_once 'config.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get all form data
$data = [
    'firstName' => $_POST['firstName'] ?? '',
    'lastName' => $_POST['lastName'] ?? '',
    'jobTitle' => $_POST['jobTitle'] ?? '',
    'companyName' => $_POST['companyName'] ?? '',
    'phoneNumber' => $_POST['phoneNumber'] ?? '',
    'email' => $_POST['email'] ?? '',
    'industry' => $_POST['industry'] ?? '',
    'numEmployees' => $_POST['numEmployees'] ?? 0,
    'helpOptions' => $_POST['helpOptions'] ?? '',
    'additionalDetails' => $_POST['additionalDetails'] ?? ''
];

// Insert into database
$stmt = $conn->prepare("INSERT INTO preorder_requests (
    first_name, last_name, job_title, company_name, phone_number, 
    email, industry, num_employees, help_option, additional_details
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssssssiss",
    $data['firstName'],
    $data['lastName'],
    $data['jobTitle'],
    $data['companyName'],
    $data['phoneNumber'],
    $data['email'],
    $data['industry'],
    $data['numEmployees'],
    $data['helpOptions'],
    $data['additionalDetails']
);

header('Content-Type: application/json');
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}