<?php
// Include the database connection
include 'db.php';

// SQL query to fetch distinct company names and logos from job_postings table
$sql = "SELECT DISTINCT company_name, company_logo FROM job_postings";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Fetching data and preparing JSON response
    $companies = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $companies[] = array(
            'company_name' => $row['company_name'],
            'company_logo' => $row['company_logo']
        );
    }
    // Sending JSON response
    header('Content-Type: application/json');
    echo json_encode($companies);
} else {
    // No companies found
    echo json_encode(array());
}

mysqli_close($conn);
?>
