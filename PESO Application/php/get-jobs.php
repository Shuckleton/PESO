<?php
include_once 'db.php'; // Database connection

$sql = "SELECT * FROM job_postings ORDER BY company_name ASC";
$result = mysqli_query($conn, $sql);

$jobsByCompany = [];

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $companyName = $row['company_name'];
        $jobsByCompany[$companyName][] = $row;
    }
}

mysqli_close($conn);
?>
