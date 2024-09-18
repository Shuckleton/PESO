<?php
include_once 'db.php'; // Include your database connection file

// Get the company name from the GET request
$company = $_GET['company'] ?? '';

// Prepare the SQL query to fetch job positions based on the selected company
$query = "SELECT DISTINCT job_position FROM job_postings WHERE company_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $company);
$stmt->execute();
$result = $stmt->get_result();

$jobPositions = [];
while ($row = $result->fetch_assoc()) {
    $jobPositions[] = $row['job_position'];
}

$stmt->close();
$conn->close();

// Return the job positions as a JSON response
header('Content-Type: application/json');
echo json_encode($jobPositions);
?>
