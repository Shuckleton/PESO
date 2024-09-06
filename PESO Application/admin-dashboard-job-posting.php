<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESO | Post A New Job</title>
    <link rel="stylesheet" href="css/admin-dashboard-job-posting.css">
    <link href="https://fonts.googleapis.com/css2?family=Average&family=Inter&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/peso_logo.png">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="img/sidebar-logo.png" alt="Logo">
            </div>
            <div class="menu">
                <a href="admin-dashboard-applicant-status.php" class="icon-button">
                    <img src="img/icon-employee-status.png" alt="Home">
                </a>
                <a href="admin-dashboard-job-posting.php" class="icon-button">
                    <img src="img/icon-job-posting.png" alt="Profile">
                </a>
                <a href="admin-login.php" class="icon-button">
                    <img src="img/icon-logout.png" alt="Logout">
                </a>
            </div>
        </div>
        <div class="main-content">
            <h1>Post a New Job</h1>
            <h2>The details of the job openings will display on the main page of PESO Website</h2>
            <form class="job-form" action="php/post-job.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="company-logo">Company Logo:</label>
                        <div class="upload-logo-wrapper">
                            <input type="file" id="company-logo" name="company-logo" class="upload-logo-input" accept="image/*" onchange="displayImage(event, 'company-logo-preview', '.upload-logo-wrapper .upload-logo-text')">
                            <span class="upload-logo-text">Upload Logo</span>
                            <img id="company-logo-preview" class="image-preview" src="" alt="Company Logo Preview">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company-name">Company Name:</label>
                        <input type="text" id="company-name" name="company-name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="job-position">Job Position:</label>
                    <input type="text" id="job-position" name="job-position" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="job-image">Job Image:</label>
                        <div class="upload-logo-wrapper upload-job-image-wrapper">
                            <input type="file" id="job-image" name="job-image" class="upload-logo-input" accept="image/*" onchange="displayImage(event, 'job-image-preview', '.upload-job-image-wrapper .upload-logo-text')">
                            <span class="upload-logo-text">Upload Job Image Here</span>
                            <img id="job-image-preview" class="image-preview job-image-preview" src="" alt="Job Image Preview">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="job-description">Job Description:</label>
                        <textarea id="job-description" name="job-description" maxlength="150" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="job-location">Job Location:</label>
                        <textarea id="job-location" name="job-location" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="contact-details">Contact Details:</label>
                        <textarea id="contact-details" name="contact-details" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="job-qualifications">Job Qualifications:</label>
                    <textarea id="job-qualifications" name="job-qualifications" required></textarea>
                </div>
                <div class="form-group">
                    <label for="required-skills">Required Skills (comma-separated):</label>
                    <input type="text" id="required-skills" name="required-skills" placeholder="Skill 1, Skill 2, Skill 3" required>
                </div>
                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/posting-image.js"></script>
</body>
</html>
