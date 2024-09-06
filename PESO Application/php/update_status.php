<?php
include_once 'db.php'; // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit();
}

$applicantId = $data['id'];
$newStatus = $data['status'];

// Validate the status
$validStatuses = ['hired', 'pending', 'rejected'];
if (!in_array($newStatus, $validStatuses)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'Invalid status']);
    exit();
}

// Update the applicant's status in the database
$query = "UPDATE job_applications SET status = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'si', $newStatus, $applicantId);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to prepare SQL statement']);
}

mysqli_close($conn);
?>
