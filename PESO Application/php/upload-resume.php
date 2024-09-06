<?php
session_start();
include_once 'db.php'; // Include your database connection file

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and get the job ID and other data
    $jobId = isset($_POST['job_id']) ? intval($_POST['job_id']) : 0;
    $companyName = isset($_POST['company_name']) ? mysqli_real_escape_string($conn, $_POST['company_name']) : '';
    $jobTitle = isset($_POST['job_title']) ? mysqli_real_escape_string($conn, $_POST['job_title']) : '';

    // Check if the uploaded file is a valid PDF
    if (isset($_FILES['pdfResume']) && $_FILES['pdfResume']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pdfResume']['tmp_name'];
        $fileName = $_FILES['pdfResume']['name'];
        $fileSize = $_FILES['pdfResume']['size'];
        $fileType = $_FILES['pdfResume']['type'];

        // Ensure it's a PDF file
        if ($fileType === 'application/pdf') {
            // Define the target directory
            $uploadFileDir = '../uploads/';
            $dest_path = $uploadFileDir . $fileName;

            // Move the file to the uploads directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Prepare the SQL statement to insert the application
                $sql = "INSERT INTO job_applications (job_id, company_name, applicant_name, email_address, resume_photo_path, submission_date, status)
                        VALUES ('$jobId', '$companyName', '', '', '$dest_path', NOW(), 'pending')"; // Empty name and email for now

                if (mysqli_query($conn, $sql)) {
                    // Optionally delete the uploaded file after processing
                    // unlink($dest_path); 
                    header("Location: success.php"); // Redirect to a success page
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Uploaded file is not a PDF.";
        }
    } else {
        echo "Error uploading the file.";
    }
} else {
    die("Invalid request method.");
}
?>
