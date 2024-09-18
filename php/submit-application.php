<?php
// Include the database connection file
include 'db.php';

// Create the table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS job_applications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    job_id INT(11) NOT NULL,
    job_title VARCHAR(255) NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    applicant_name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    contact_number VARCHAR(50) NOT NULL,
    email_address VARCHAR(255) NOT NULL,
    resume_photo_path VARCHAR(255) NOT NULL,
    about_yourself TEXT NOT NULL,
    high_school VARCHAR(255) NOT NULL,
    college VARCHAR(255) NOT NULL,
    skills TEXT NOT NULL,
    experiences TEXT NOT NULL,
    metrics_score INT DEFAULT 0,
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP
)";

mysqli_query($conn, $sql);

// Handle file upload
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $fileName = $_FILES['photo']['name'];
    
    // Specify the upload directory
    $uploadFileDir = '../uploads/'; // Update to the correct path
    $dest_path = $uploadFileDir . $fileName;

    // Move the file to the desired directory
    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        // Prepare variables from POST data
        $jobId = $_POST['job_id'];
        $companyName = $_POST['company_name'];
        $applicantName = $_POST['field1'];
        $emailAddress = $_POST['field4'];
        $address = $_POST['field2'];
        $contactNumber = $_POST['field3'];
        $aboutYourself = $_POST['largeField1'];
        $highSchool = $_POST['largeField2'];
        $college = $_POST['largeField3'];
        $skills = implode(', ', $_POST['skills']); // Assuming skills is an array
        $experiences = implode(' | ', $_POST['experiences']); // Join experiences with a separator
        $jobTitle = $_POST['job_title'];

        // Calculate the metrics score and log computations
        $metricsScore = calculateMetricsScore($jobId, $skills, $experiences, $college, $highSchool);

        // Insert query
        $sql = "INSERT INTO job_applications (job_id, job_title, company_name, applicant_name, address, contact_number, email_address, resume_photo_path, about_yourself, high_school, college, skills, experiences, metrics_score) 
                VALUES ('$jobId', '$jobTitle', '$companyName', '$applicantName', '$address', '$contactNumber', '$emailAddress', '$dest_path', '$aboutYourself', '$highSchool', '$college', '$skills', '$experiences', '$metricsScore')";
        
        if (mysqli_query($conn, $sql)) {
            // Redirect or display a success message
            header("Location: success.php");
            exit;
        } else {
            die("Error executing query: " . mysqli_error($conn));
        }
    } else {
        echo "There was an error moving the uploaded file.";
    }
} else {
    echo "No photo uploaded or there was an upload error.";
}

mysqli_close($conn);

function calculateMetricsScore($jobId, $skills, $experiences, $college, $highSchool) {
    global $conn; // Access the database connection
    $logFile = 'metrics_score_log.txt'; // Log file path

    // Fetch job qualifications and their importance levels
    $query = "SELECT job_qualifications FROM job_postings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $jobId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $logContent = "Calculation Log - Job ID: $jobId\n";

    if ($result && mysqli_num_rows($result) > 0) {
        $jobPosting = mysqli_fetch_assoc($result);
        $jobQualifications = explode(',', $jobPosting['job_qualifications']);

        // Initialize score and computation details
        $score = 0;

        // Score for education with weight for relevance
        $educationScore = 0;
        if (!empty(trim($college))) { 
            $educationScore += 30; 
        }
        if (!empty(trim($highSchool))) { 
            $educationScore += 15; 
        }
        $score += $educationScore;
        $logContent .= "Education Score: $educationScore\n";

        // Score based on skills with weight for relevance
        $skillsArray = explode(',', $skills);
        $skillsScore = 0;
        if (!empty($skillsArray)) {
            $skillsScore = count($skillsArray) * 2; 
        }
        $score += $skillsScore;
        $logContent .= "Skills Score: $skillsScore\n";

        // Score based on relevant skills to the job qualifications with higher weight
        $relevantSkillsScore = 0;
        foreach ($jobQualifications as $qualification) {
            if (in_array(trim($qualification), array_map('trim', $skillsArray))) {
                $relevantSkillsScore += 10; 
            }
        }
        $score += $relevantSkillsScore;
        $logContent .= "Relevant Skills Score: $relevantSkillsScore\n";

        // Score based on experience with weight for relevance
        $experiencesArray = explode(',', $experiences);
        $experienceScore = 0;
        if (!empty($experiencesArray)) {
            $experienceScore = count($experiencesArray) * 3; 
        }
        $score += $experienceScore;
        $logContent .= "Experience Score: $experienceScore\n";

        // Score based on relevant experiences to the job qualifications with higher weight
        $relevantExperienceScore = 0;
        foreach ($jobQualifications as $qualification) {
            if (in_array(trim($qualification), array_map('trim', $experiencesArray))) {
                $relevantExperienceScore += 10; 
            }
        }
        $score += $relevantExperienceScore;
        $logContent .= "Relevant Experience Score: $relevantExperienceScore\n";

        $logContent .= "Total Score: $score\n";
    } else {
        $logContent .= "No job qualifications found.\n";
        $score = 0; 
    }

    // Write log to file
    file_put_contents($logFile, $logContent, FILE_APPEND);

    return $score;
}
?>
