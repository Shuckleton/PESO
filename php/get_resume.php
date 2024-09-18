<?php
include 'db.php'; // Include your database connection file

if (isset($_GET['id'])) {
    $applicantId = intval($_GET['id']);
    $query = "SELECT * FROM job_applications WHERE id = $applicantId LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $application = mysqli_fetch_assoc($result);
        $resumePath = htmlspecialchars($application['resume_photo_path']);
        
        // Check if the resume is a PDF file
        if (substr($resumePath, -4) === '.pdf') {
            // Adjust the path for the PDF file
            if (substr($resumePath, 0, 3) === '../') {
                $resumePath = @ltrim($resumePath, '../'); // Suppress any warnings
            }
            $fullPath = 'http://localhost/Peso%20Application/' . $resumePath; // Adjust the base path to your server setup
        
            // Output an iframe to display the PDF
            echo "<div class='resume'>
                    <h1>" . htmlspecialchars($application['applicant_name']) . "'s E-Resume</h1>
                    <iframe src='" . htmlspecialchars($fullPath) . "' style='width: 100%; height: 600px;' frameborder='0'></iframe>
                  </div>";
        } else {
            echo "<div class='resume'>
                    <div class='header' style='background-color: #003366; color: white; padding: 20px; display: flex; align-items: center;'>
                        <div class='photo' style='margin-right: 20px;'>";

            // Add the resume photo if available
            if (!empty($resumePath)) {
                if (substr($resumePath, 0, 3) === '../') {
                    $resumePath = @ltrim($resumePath, '../'); // Suppress any warnings
                }
                $photoPath = 'http://localhost/Peso%20Application/' . $resumePath;
                echo "<img src='$photoPath' alt='Resume Photo' style='max-width: 150px; border-radius: 50%;'>";
            } else {
                echo "<i class='fas fa-user-circle fa-5x' style='color: white;'></i>"; // Placeholder icon
            }

            echo "  </div>
                    <div class='info' style='flex-grow: 1; display: flex; justify-content: space-between; align-items: center;'> 
                        <div> 
                            <h1 class='name' style='margin: 0; font-size: 30px; color: white; font-weight: bold;'>" . htmlspecialchars($application['applicant_name']) . "</h1>
                            <h2 class='job' style='margin: 0; font-size: 20px; color: white;'>" . htmlspecialchars($application['job_title']) . "</h2> 
                        </div>
                        <div class='submission-date' style='font-size: 20px; color: white;'> Date Submitted: ". htmlspecialchars(date('F j, Y', strtotime($application['submission_date']))) . "</div>
                    </div>
                    </div>
                    <hr style='border: 2px solid #000;'>
                    <div class='details' style='padding: 20px;'>";

            // Only display "About Me" section if content exists
            if (!empty(trim($application['about_yourself']))) {
                echo "<div class='about'>
                        <h3 style='color: black;'><strong>About Me</strong></h3>
                        <p style='color: black;'>" . nl2br(htmlspecialchars($application['about_yourself'])) . "</p>
                    </div>
                    <br>
                    <hr style='border: 2px solid #000;'>
                    <br>";
            }

            // Only display "Contact Me" section if content exists
            if (!empty(trim($application['email_address'])) || !empty(trim($application['contact_number'])) || !empty(trim($application['address']))) {
                echo "<div class='contact'>
                 
                           <h3 style='color: black;'><strong>Contact Me</strong></h3>";
                if (!empty(trim($application['email_address']))) {
                    echo "<p><strong>Email:</strong> <a href='mailto:" . htmlspecialchars($application['email_address']) . "' style='color: black;'>" . htmlspecialchars($application['email_address']) . "</a></p>";
                }
                if (!empty(trim($application['contact_number']))) {
                    echo "<p><strong>Phone:</strong> <a href='tel:" . htmlspecialchars($application['contact_number']) . "' style='color: black;'>" . htmlspecialchars($application['contact_number']) . "</a></p>";
                }
                if (!empty(trim($application['address']))) {
                    echo "<p><strong>Address:</strong> <span style='color: black;'>" . htmlspecialchars($application['address']) . "</span></p>";
                }
                echo "</div>
                    <br>
                    <hr style='border: 2px solid #000;'>
                    <br>";
            }

            // Only display "Experience" section if content exists
            $experiencesArray = explode(',', $application['experiences']);
            $experiencesArray = array_map('trim', $experiencesArray); // Trim each experience
            if (array_filter($experiencesArray)) { // Check if there are non-empty values
                echo "<div class='work'>
                        <h3 style='color: black;'><strong>Experience</strong></h3>
                        <ul style='list-style-type: disc; padding-left: 20px;'>";
                foreach ($experiencesArray as $experience) {
                    if (!empty(trim($experience))) {
                        echo "<li style='color: black;'>" . htmlspecialchars(trim($experience)) . "</li>";
                    }
                }
                echo "  </ul>
                      <br><br>
                      <hr style='border: 2px solid #000;'>
                      <br>";
            }

            // Only display "Skills" section if content exists
            $skillsArray = explode(',', $application['skills']);
            $skillsArray = array_map('trim', $skillsArray); // Trim each skill
            if (array_filter($skillsArray)) { // Check if there are non-empty values
                echo "<div class='skills'>
                        <h3 style='color: black;'><strong>Skills</strong></h3>
                        <ul style='list-style-type: disc; padding-left: 20px;'>";
                foreach ($skillsArray as $skill) {
                    if (!empty(trim($skill))) {
                        echo "<li style='color: black;'>" . htmlspecialchars(trim($skill)) . "</li>";
                    }
                }
                echo "  </ul>
                      </div>
                      <br><br>
                      <hr style='border: 2px solid #000;'>
                      <br>";
            }

            // Only display "Education" section if content exists
            $educationDisplayed = false;
            if (!empty(trim($application['college']))) {
                $educationDisplayed = true;
            }
            if (!empty(trim($application['high_school']))) {
                $educationDisplayed = true;
            }
            if ($educationDisplayed) {
                echo "<div class='edu'>
                        <h3 style='color: black;'><strong>Education</strong></h3>
                        <ul style='list-style-type: none; padding-left: 0;'>";
                if (!empty(trim($application['college']))) {
                    echo "<br><strong>College</strong><li style='color: black;'>" . htmlspecialchars($application['college']) . "</li>";
                }
                if (!empty(trim($application['high_school']))) {
                    echo "<br><strong>High School</strong><li style='color: black;'>" . htmlspecialchars($application['high_school']) . "</li>";
                }
                echo "  </ul>
                      </div>";
            }

            echo "</div>
                <br>
                <br>";
        }
    } else {
        echo "<div class='container mx-auto mt-10 p-5 bg-red-200 rounded-lg text-center'>Applicant not found.</div>";
    }
} else {
    echo "<div class='container mx-auto mt-10 p-5 bg-yellow-200 rounded-lg text-center'>No applicant ID provided.</div>";
}

mysqli_close($conn);
?>
