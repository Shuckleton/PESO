<?php
session_start();
include_once 'php/db.php'; // Include your database connection file

// Get the job ID from the query string
$jobId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($jobId <= 0) {
    die("Invalid job ID.");
}

// Fetch job details from the database
$sql = "SELECT * FROM job_postings WHERE id = $jobId";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

$job = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Average&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="css/job-details.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/peso_logo.png">
    <title>P.E.S.O | Start Job Application</title>
    <style>
        .photo-preview {
            width: 120px; /* Adjust as needed for a 2x2 photo */
            height: 120px; /* Adjust as needed for a 2x2 photo */
            border: 2px solid #3b82f6;
            border-radius: 4px;
            margin-right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9fafb; /* Light background for visibility */
            overflow: hidden;
            position: relative;
        }
        .photo-preview img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 4px;
        }
        /* Tab styles */
        .tab {
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #3b82f6;
            border-radius: 5px 5px 0 0;
            margin-right: 2px;
            color: white;
        }
        .tab.active {
            background-color: #f3f4f6;
            color: black;
        }
        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
<header>
    <div class="header-left">
        <a href="start-job-application.php">
            <img src="img/peso_logo.png" alt="Logo" class="header-logo">
        </a>
        <span class="header-text">PUBLIC EMPLOYMENT SERVICE OFFICE</span>
    </div>
    <div class="header-right">
        <form class="search-form" action="#" method="get">
            <input type="text" class="search-input" placeholder="Search for jobs at P.E.S.O...">
            <button type="submit" class="search-button">
                <img src="img/search.png" alt="Search" class="search-icon">
            </button>
        </form>
    </div>
</header>

<div class="container mx-auto p-4 my-8 bg-white shadow-lg rounded-lg">
    <div class="flex flex-col md:flex-row">
        <div class="md:w-1/2 p-4">
            <img src="<?php echo htmlspecialchars($job['job_image']); ?>" alt="Company Photo" class="w-full h-auto rounded-lg">
        </div>
        <div class="md:w-1/2 p-4">
            <h2 class="text-xl font-bold"><strong>Company:</strong> <?php echo htmlspecialchars($job['company_name']); ?></h2>
            <h3 class="text-lg font-semibold"><strong>Looking for:</strong> <?php echo htmlspecialchars($job['job_position']); ?></h3>
            <p>____________________________________________________________</p>
            <p class="mt-2"><strong>Job Location:</strong> <?php echo htmlspecialchars($job['job_location']); ?></p>
            <p class="mt-2"><strong>Contact Details:</strong> <?php echo htmlspecialchars($job['contact_details']); ?></p>
            <p>____________________________________________________________</p>
            <p class="mt-2"><strong>Job Description:</strong><br><?php echo nl2br(htmlspecialchars($job['job_description'])); ?></p>
            <p class="mt-2"><strong>Job Qualifications:</strong><br><br><?php echo nl2br(htmlspecialchars($job['job_qualifications'])); ?></p>
            <br>
            <h4 class="text-lg font-semibold"><strong>Required Skills:</strong></h4>
          
            <ul class="list-disc pl-5">
                <?php 
                $skills = explode(',', $job['required_skills']); // Assuming skills are comma-separated
                foreach ($skills as $skill) {
                    echo "<li>" . htmlspecialchars(trim($skill)) . "</li>";
                }
                ?>
</ul>

        </div>
    </div>

    <!-- Tab Menu -->
    <div class="mt-8">
        <div class="tab-menu">
            <div class="tab active" data-tab="formTab">Apply for this Job!</div>
            <div class="tab" data-tab="uploadTab">Upload PDF Resume</div>
        </div>

        <!-- Tab Content -->
        <div id="formTab" class="tab-content active">
            <form action="php/submit-application.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>"> <!-- Assuming you're pulling this from the job details -->
                <input type="hidden" name="company_name" value="<?php echo htmlspecialchars($job['company_name']); ?>"> <!-- Pulling company name -->
                <input type="hidden" name="job_title" value="<?php echo htmlspecialchars($job['job_position']); ?>"> <!-- Set this dynamically -->

                <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                    <div class="flex mb-4">
                        <div class="photo-preview" id="photoPreview">
                            <img id="photoImage" src="" alt="Photo Preview" class="hidden" />
                        </div>
                        <div class="flex-1">
                            <label for="photo" class="block mb-2">Upload 2x2 Photo:</label>
                            <input type="file" id="photo" name="photo" accept="image/*" class="border border-gray-300 p-2 mb-4 w-full" onchange="previewPhoto(event)">
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/2 mb-4 mr-4">
                            <label class="block mb-2">Name:</label>
                            <input type="text" id="field1" name="field1" required class="border border-gray-300 p-2 w-full" placeholder="Enter your name">
                        </div>
                        <div class="md:w-1/2 mb-4">
                            <label class="block mb-2 ">Email:</label>
                            <input type="email" id="field4" name="field4" required class="border border-gray-300 p-2 w-full" placeholder="Enter your email">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/2 mb-4  mr-4">
                            <label class="block mb-2">Address:</label>
                            <input type="text" id="field2" name="field2" required class="border border-gray-300 p-2 w-full" placeholder="Enter your address">
                        </div>
                        <div class="md:w-1/2 mb-4">
                            <label class="block mb-2">Contact Number:</label>
                            <input type="text" id="field3" name="field3" required class="border border-gray-300 p-2 w-full" placeholder="Enter your contact number">
                        </div>
                    </div>

                    <div class="mb-4">
                    <label class="block mb-2">About Yourself</label>
                        <textarea id="largeField1" name="largeField1" required class="border border-gray-300 p-2 w-full" placeholder="Describe yourself"></textarea>
                    </div>

                    <div class="mb-4">
                        <p class="mt-2"><strong>Education:</strong><br>
                        
                        <div class="mb-4">
                            <label class="block mb-2">High School:</label>
                            <input type="text" id="largeField2" name="largeField2" class="border border-gray-300 p-2 w-full" placeholder="Enter your high school">
                        </div>
                        <div>
                            <label class="block mb-2">College:</label>
                            <input type="text" id="largeField3" name="largeField3" class="border border-gray-300 p-2 w-full" placeholder="Enter your college">
                        </div>
                    </div>

                    <div class="mb-4">
                    <label class="block mb-2">Skills</label>
                        <div id="skillsContainer">
                            <div class="flex items-center mb-2">
                                <input type="text" id="skill1" name="skills[]" class="border border-gray-300 p-2 w-full mr-2" placeholder="Enter a skill">
                                <button type="button" class="bg-red-500 text-white py-1 px-2 rounded" onclick="removeSkill(this)">−</button>
                            </div>
                        </div>
                        <button type="button" id="addSkill" class="bg-blue-500 text-white py-2 px-4 rounded flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add
                        </button>
                    </div>

                    <div class="mb-4">
                    <label class="block mb-2">Experience </label>
                        <div id="experienceContainer">
                            <div class="flex items-center mb-2">
                            <textarea id="experience1" name="experiences[]" class="border border-gray-300 p-2 w-full mr-2" placeholder="Describe your experience"></textarea>
                                <button type="button" class="bg-red-500 text-white py-1 px-2 rounded" onclick="removeExperience(this)">−</button>
                            </div>
                        </div>
                        <button type="button" id="addExperience" class="bg-blue-500 text-white py-2 px-4 rounded">Add</button>
                    </div>


                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit Application</button>
                </div>
            </form>
        </div>

        <div id="uploadTab" class="tab-content">
            <form action="php/upload-resume.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                <input type="hidden" name="company_name" value="<?php echo htmlspecialchars($job['company_name']); ?>">
                <input type="hidden" name="job_title" value="<?php echo htmlspecialchars($job['job_position']); ?>">

                <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                    <div class="mb-4">
                        <label for="pdfResume" class="block mb-2">Upload PDF Resume:</label>
                        <input type="file" id="pdfResume" name="pdfResume" accept="application/pdf" required class="border border-gray-300 p-2 w-full">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit PDF Resume</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Tab switching logic
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const target = tab.getAttribute('data-tab');

            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === target) {
                    content.classList.add('active');
                }
            });
        });
    });

    // Preview photo before upload
    function previewPhoto(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const photoImage = document.getElementById('photoImage');
            const photoPreview = document.getElementById('photoPreview');
            photoImage.src = reader.result;
            photoImage.classList.remove('hidden');
            photoPreview.style.backgroundColor = 'transparent';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Add skill functionality
document.getElementById('addSkill').addEventListener('click', () => {
    const container = document.getElementById('skillsContainer');
    const skillDiv = document.createElement('div');
    skillDiv.className = 'flex items-center mb-2';
    
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'skills[]';
    input.className = 'border border-gray-300 p-2 w-full mr-2';
    input.placeholder = 'Enter a skill';
    
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'bg-red-500 text-white py-1 px-2 rounded';
    removeButton.textContent = '−'; // Minus sign
    removeButton.addEventListener('click', () => {
        container.removeChild(skillDiv); // Remove the skill input
    });

    skillDiv.appendChild(input);
    skillDiv.appendChild(removeButton);
    container.appendChild(skillDiv);
});

// Add experience functionality
document.getElementById('addExperience').addEventListener('click', () => {
    const container = document.getElementById('experienceContainer');
    const experienceDiv = document.createElement('div');
    experienceDiv.className = 'flex items-center mb-2';
    
    const textarea = document.createElement('textarea');
    textarea.name = 'experiences[]';
    textarea.className = 'border border-gray-300 p-2 w-full mr-2';
    textarea.placeholder = 'Describe your experience';
    
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'bg-red-500 text-white py-1 px-2 rounded';
    removeButton.textContent = '−'; // Minus sign
    removeButton.addEventListener('click', () => {
        container.removeChild(experienceDiv); // Remove the experience textarea
    });

    experienceDiv.appendChild(textarea);
    experienceDiv.appendChild(removeButton);
    container.appendChild(experienceDiv);
});

</script>

<footer class="bg-gray-200 text-center py-4 mt-8">
    <p>&copy; 2024 PUBLIC EMPLOYMENT SERVICE OFFICE. All rights reserved.</p>
</footer>

</body>
</html>
