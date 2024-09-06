<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Average&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/start-job-application.css">
    <link rel="icon" type="image/x-icon" href="img/peso_logo.png">
    <title>P.E.S.O | Start Job Application</title>
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
                <input type="text" id="searchInput" class="search-input" placeholder="Search for jobs at P.E.S.O...">
                <button type="submit" class="search-button">
                    <img src="img/search.png" alt="Search" class="search-icon">
                </button>
            </form>
        </div>
    </header>
    
    <div class="title-header">
        <h1>Do you need a job? </h1>
        <p>Choose the job that fits you from the vacancies listed below!</p>
    </div>

    <!-- Include PHP file to fetch jobs -->
    <?php include 'php/get-jobs.php'; ?>

    <?php if (!empty($jobsByCompany)): ?>
    <!-- Loop through job postings -->
    <?php foreach ($jobsByCompany as $companyName => $jobs): ?>
        <div class="company-container" data-company="<?php echo $companyName; ?>">
            <div class="container-title">
                <img src="<?php echo $jobs[0]['company_logo']; ?>" alt="Logo" class="container-logo">
                <h1><?php echo $companyName; ?></h1>
            </div>

            <div class="container">
                <?php foreach ($jobs as $job): ?>
                    <div class="flexbox job-posting" data-job-position="<?php echo $job['job_position']; ?>">
                        <img src="<?php echo $job['job_image']; ?>" alt="Job Image" class="flexbox-image">
                        <div class="flexbox-content">
                            <h2 class="flexbox-title"><?php echo $job['job_position']; ?></h2>
                            <p class="flexbox-text"><?php echo $job['job_description']; ?></p>
                            <a href="job-details.php?id=<?php echo $job['id']; ?>" class="flexbox-button">See Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <!-- No jobs available message -->
    <div class="no-jobs-message" style="display: flex; justify-content: center; align-items: center; height: 70vh; text-align: center; flex-direction: column;">
    <h2>Currently, there are no job vacancies available.</h2>
    <p>Please check back later or visit our Facebook page for updates.</p>
</div>

<?php endif; ?>

    <a id="fb-button" href="https://www.facebook.com/peso.laspinas" target="_blank" title="Visit PESO on Facebook">
        <img src="img/fb-button.png" alt="Facebook">
    </a>
    <button id="backToTopBtn" title="Go to top">
        <img src="img/scroll.png" alt="Back to Top">
    </button>

    <script src="js/button-script.js"></script>
    <script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const jobPostings = document.querySelectorAll('.job-posting');
        const companyContainers = document.querySelectorAll('.company-container');

        let companyVisible = false;

        companyContainers.forEach(company => {
            const postings = company.querySelectorAll('.job-posting');
            let showCompany = false;

            postings.forEach(posting => {
                const jobTitle = posting.querySelector('.flexbox-title').textContent.toLowerCase();
                const jobDescription = posting.querySelector('.flexbox-text').textContent.toLowerCase();
                
                if (jobTitle.includes(searchValue) || jobDescription.includes(searchValue)) {
                    posting.style.display = '';
                    showCompany = true;
                } else {
                    posting.style.display = 'none';
                }
            });

            company.style.display = showCompany ? '' : 'none';
        });
    });
    </script>

    <footer id="footer">
        <div class="footer-container">
            <!-- Logo -->
            <div class="logo">
                <img src="img/footer-logo.png" alt="Website Logo">
            </div>

            <!-- Links -->
            <div class="footer-links">
                <a href="https://www.facebook.com/cityoflaspinasofficial">Visit City of Las Piñas on Facebook</a>
                <a href="https://maps.app.goo.gl/R8zUnsXLHmcmZUHr7">Visit Las Piñas City Hall</a>
            </div>

            <!-- Sponsors -->
            <div class="sponsors">
                <img src="img/sponsor1.png" alt="Sponsor 1">
                <img src="img/sponsor2.png" alt="Sponsor 2">
                <img src="img/sponsor3.png" alt="Sponsor 3">
                <img src="img/sponsor4.png" alt="Sponsor 4">
            </div>
        </div>
    </footer>
</body>
</html>
