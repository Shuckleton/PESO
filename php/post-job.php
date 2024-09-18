<?php
session_start();
include_once 'db.php'; // Include your database connection file

// Create the table if it doesn't exist
$createTableSQL = "
CREATE TABLE IF NOT EXISTS job_postings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    job_position VARCHAR(100) NOT NULL,
    company_logo VARCHAR(255) NOT NULL,
    job_image VARCHAR(255) NOT NULL,
    job_description TEXT NOT NULL,
    job_location TEXT NOT NULL,
    contact_details TEXT NOT NULL,
    job_qualifications TEXT NOT NULL,
    required_skills TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $createTableSQL)) {
    echo "Table created or already exists.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyName = $_POST['company-name'];
    $jobPosition = $_POST['job-position'];
    $jobDescription = $_POST['job-description'];
    $jobLocation = $_POST['job-location'];
    $contactDetails = $_POST['contact-details'];
    $jobQualifications = $_POST['job-qualifications'];
    $requiredSkills = $_POST['required-skills']; // Get the required skills from the form

    // Handle file upload for company logo
    $companyLogoDir = '../uploads/';
    $companyLogoPath = $companyLogoDir . basename($_FILES['company-logo']['name']);
    $companyLogoDBPath = 'uploads/' . basename($_FILES['company-logo']['name']); // Path to store in DB without '../'
    move_uploaded_file($_FILES['company-logo']['tmp_name'], $companyLogoPath);

    // Handle file upload for job image
    $jobImageDir = '../uploads/';
    $jobImagePath = $jobImageDir . basename($_FILES['job-image']['name']);
    $jobImageDBPath = 'uploads/' . basename($_FILES['job-image']['name']); // Path to store in DB without '../'
    move_uploaded_file($_FILES['job-image']['tmp_name'], $jobImagePath);

    // Insert data into database
    $sql = "INSERT INTO job_postings (company_name, job_position, company_logo, job_image, job_description, job_location, contact_details, job_qualifications, required_skills)
            VALUES ('$companyName', '$jobPosition', '$companyLogoDBPath', '$jobImageDBPath', '$jobDescription', '$jobLocation', '$contactDetails', '$jobQualifications', '$requiredSkills')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the success page
        header("Location: ../job-added-success.html");
        exit(); // Make sure to exit after the redirect
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
