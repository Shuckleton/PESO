


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/peso_logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Average&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="img/peso_logo.png">
    <title>Application Submitted | P.E.S.O</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .loading img {
            max-width: 100px; /* Adjust size of loading icon */
            margin-bottom: 20px;
        }

        .success-container {
            text-align: center;
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: none; /* Hide success container initially */
        }

        .success-container h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #28a745;
        }

        .success-container p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .success-container .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .success-container .btn:hover {
            background-color: #0056b3;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Black with opacity */
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px; /* Set a max width for larger screens */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>



<body>


    <div id="loading" class="loading">
        <img src="../img/loading.gif" alt="Loading" style="max-width: 80%; height: 100px; margin: 20px 0;">
        <h1>Submitting resume...</h1>
    </div>

    <div class="success-container">
        <img src="../img/success.gif" alt="Success" class="success-gif" style="max-width: 80%; height: 1s00px; margin: 20px 0;">
        <h1>Application Submitted!</h1>
        <p>Your application has been successfully submitted.</p>
        <p>We will review your application and get back to you soon.</p>
        
        <a href="../start-job-application.php" class="btn">Back to Job Listings</a>
     
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <?php if (isset($resume)): ?>
            <h2><?php echo htmlspecialchars($resume['applicant_name']); ?></h2>
            <p>Email: <?php echo htmlspecialchars($resume['email_address']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($resume['contact_number']); ?></p>

            <h3>Skills</h3>
            <p><?php echo nl2br(htmlspecialchars($resume['skills'])); ?></p>

            <h3>Experience</h3>
            <p><?php echo nl2br(htmlspecialchars($resume['experiences'])); ?></p>

            <h3>Education</h3>
            <p><?php echo nl2br(htmlspecialchars($resume['high_school'] . ', ' . $resume['college'])); ?></p>
            <?php else: ?>
            <p>No resume data available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Wait for a short delay before hiding the loading screen
            setTimeout(function() {
                document.getElementById("loading").style.display = "none"; // Hide loading screen
                document.querySelector(".success-container").style.display = "block"; // Show success container
            }, 2000); // Adjust the delay as necessary (2000ms = 2 seconds)
        });

        // Modal functionality
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("resumeBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    
</body>
</html>
