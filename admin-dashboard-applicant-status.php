<?php
include_once 'php/db.php'; // Include your database connection file

// Fetch unique companies from job_postings
$companyQuery = "SELECT DISTINCT company_name FROM job_postings";
$companyResult = mysqli_query($conn, $companyQuery);
$companies = [];
while ($row = mysqli_fetch_assoc($companyResult)) {
    $companies[] = $row['company_name'];
}

// Fetch job applications from the database, including the company name and metrics score
$query = "SELECT ja.*, jp.company_name, jp.job_position FROM job_applications ja JOIN job_postings jp ON ja.job_id = jp.id ORDER BY ja.submission_date DESC";
$result = mysqli_query($conn, $query);

$applications = [];
while ($row = mysqli_fetch_assoc($result)) {
    $applications[] = $row;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESO | Applicant Status</title>
    <link rel="stylesheet" href="css/admin-dashboard-applicant-status.css">
    <link href="https://fonts.googleapis.com/css2?family=Average&family=Inter&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/peso_logo.png">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* Add your custom styles here */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            position: relative; /* Set position to relative for absolute positioning of close button */
            padding: 0; /* Remove padding */
        }
        .close {
            color: #aaa;
            float: right; /* Align to the right */
            font-size: 28px;
            font-weight: bold;
            position: absolute; /* Position it absolutely */
            top: 10px; /* Distance from the top */
            right: 20px; /* Distance from the right */
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Hide scrollbars but still allow scrolling */
        body {
            overflow: auto;
            scrollbar-width: none; /* For Firefox */
            -ms-overflow-style: none;  /* For Internet Explorer and Edge */
        }

        body::-webkit-scrollbar {
            display: none; /* For Chrome, Safari, and Opera */
        }

        .container, .main-content, .sidebar, .table-container, .modal-content {
            overflow: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .container::-webkit-scrollbar, 
        .main-content::-webkit-scrollbar,
        .sidebar::-webkit-scrollbar,
        .table-container::-webkit-scrollbar,
        .modal-content::-webkit-scrollbar {
            display: none;
        }
        .sorting-buttons {
    flex-wrap: wrap; /* Allows the buttons to wrap onto the next line if necessary */
    gap: 10px; /* Adjusts spacing between buttons */
}

.sorting-buttons button {
    font-size: 14px; /* Smaller font size */
    padding: 8px 12px; /* Reduced padding */
    height: 32px; /* Adjust height as needed */
}

.sorting-buttons button i {
    font-size: 16px; /* Adjust icon size */
}

#companyFilter,
#jobPositionFilter {
    font-size: 14px; /* Smaller font size */
    padding: 6px; /* Reduced padding */
    height: 32px; /* Adjust height as needed */
}

/* Optional: Adjust the width of the select elements if needed */
#companyFilter,
#jobPositionFilter {
    width: auto; /* Adjust width if needed */
}


        
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="img/sidebar-logo.png" alt="Logo">
            </div>
            <div class="menu">
                <a href="#home" class="icon-button">
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
            <h1>Applicants' Status and E-Resumes</h1>

            <div class="sorting-buttons flex flex-wrap gap-4 mb-4">
    <input type="text" id="searchBar" class="block w-full md:w-1/3 p-2 text-sm border border-gray-300 rounded-md shadow-sm" placeholder="Search by name">
    
    <select id="companyFilter" class="block w-full md:w-1/4 p-2 border border-gray-300 rounded-md shadow-sm">
        <option value="">All Companies</option>
        <?php foreach ($companies as $company): ?>
            <option value="<?= htmlspecialchars($company); ?>"><?= htmlspecialchars($company); ?></option>
        <?php endforeach; ?>
    </select>

    <select id="jobPositionFilter" class="block w-full md:w-1/4 p-2 border border-gray-300 rounded-md shadow-sm">
        <option value="">All Positions</option>
    </select>

    <div class="flex flex-wrap gap-2 w-full md:w-auto">
    <button onclick="sortTableBy('name')" class="flex items-center bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs">
        <i class="fas fa-sort-alpha-up mr-1"></i>
        Sort by Name
    </button>
    <button onclick="sortTableBy('date')" class="flex items-center bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">
        <i class="fas fa-calendar-alt mr-1"></i>
        Sort by Date
    </button>
    <button onclick="sortTableBy('status')" class="flex items-center bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-600 text-xs">
        <i class="fas fa-list-alt mr-1"></i>
        Sort by Status
    </button>
    <button onclick="sortTableBy('metrics')" class="flex items-center bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600 text-xs">
        <i class="fas fa-chart-bar mr-1"></i>
        Sort by Metrics Score
    </button>
    <select id="statusFilter" class="block w-full md:w-auto p-1 border border-gray-300 rounded-md shadow-sm text-xs">
        <option value="">All Statuses</option>
        <option value="hired">Hired</option>
        <option value="pending">Pending</option>
        <option value="rejected">Rejected</option>
    </select>
</div>

</div>

            <div class="table-container">
            
                <table id="applicantTable">
                    <thead>
                        <tr>
                            <th style="width: 250px;">Applicant's Name</th>
                            <th>Date Applied</th>
                            <th>Company</th>
                            <th>Job Position</th>
                            <th>E-Resume</th>
                            <th>Metrics Score</th> <!-- Metrics score column -->
                            <th>Applicant Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $application): ?>
                        <tr>
                            <td class="applicant-name"><?= htmlspecialchars($application['applicant_name']); ?></td>
                            <td><?= htmlspecialchars($application['submission_date']); ?></td>
                            <td><?= htmlspecialchars($application['company_name']); ?></td>
                            <td><?= htmlspecialchars($application['job_position']); ?></td>
                            <td><a href="#" onclick="openResumeModal(<?= $application['id']; ?>)">View E-Resume</a></td>
                            <td><?= htmlspecialchars($application['metrics_score']); ?></td> <!-- Display metrics score -->
                            <td>
                                <select name="applicant-status" data-id="<?= $application['id']; ?>">
                                    <option value="hired" <?= $application['status'] === 'hired' ? 'selected' : ''; ?>>Hired</option>
                                    <option value="pending" <?= $application['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="rejected" <?= $application['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>        
                            </td>


                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>


    <!-- Modal Structure -->
    <div id="resumeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeResumeModal()">&times;</span>
            <div id="resumeContent"></div>
        </div>
    </div>

    <script>
// Initialize an array to store all rows for sorting
const allRows = Array.from(document.querySelectorAll('#applicantTable tbody tr'));

// Filter by company
document.getElementById('companyFilter').addEventListener('change', function() {
    const selectedCompany = this.value;

    // Fetch job positions based on selected company
    fetch('php/get_job_positions.php?company=' + encodeURIComponent(selectedCompany))
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const jobPositionFilter = document.getElementById('jobPositionFilter');
            jobPositionFilter.innerHTML = '<option value="">All Positions</option>';

            data.forEach(jobPosition => {
                const option = document.createElement('option');
                option.value = jobPosition;
                option.textContent = jobPosition;
                jobPositionFilter.appendChild(option);
            });

            filterTable();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });

    filterTable();
});

// Filter by job position
document.getElementById('jobPositionFilter').addEventListener('change', filterTable);

// Filter by search bar
document.getElementById('searchBar').addEventListener('input', filterTableBySearch);
// Add event listener for status filter
document.getElementById('statusFilter').addEventListener('change', filterTable);

function filterTable() {
    const selectedCompany = document.getElementById('companyFilter').value;
    const selectedJobPosition = document.getElementById('jobPositionFilter').value;
    const selectedStatus = document.getElementById('statusFilter').value;

    allRows.forEach(row => {
        const companyCell = row.cells[2].textContent;
        const jobPositionCell = row.cells[3].textContent;
        const statusCell = row.cells[6].querySelector('select').value; // Get status from the select element

        const companyMatch = selectedCompany === '' || companyCell === selectedCompany;
        const positionMatch = selectedJobPosition === '' || jobPositionCell === selectedJobPosition;
        const statusMatch = selectedStatus === '' || statusCell === selectedStatus;

        row.style.display = companyMatch && positionMatch && statusMatch ? '' : 'none';
    });
}

// Open the resume modal
function openResumeModal(applicantId) {
    const modal = document.getElementById('resumeModal');
    const resumeContent = document.getElementById('resumeContent');

    // Fetch the resume content based on the applicant ID
    fetch('php/get_resume.php?id=' + applicantId)
        .then(response => response.text())
        .then(data => {
            resumeContent.innerHTML = data; // Set the fetched resume content
            modal.style.display = 'block'; // Show the modal
        })
        .catch(error => console.error('Error fetching resume:', error));
}

// Close the resume modal
function closeResumeModal() {
    const modal = document.getElementById('resumeModal');
    modal.style.display = 'none';
}

// Sort the table by specified column
function sortTableBy(criteria) {
    const tbody = document.querySelector('#applicantTable tbody');
    const rows = Array.from(tbody.rows);

    // Sort rows based on the selected criteria
    rows.sort((a, b) => {
        let aText, bText;

        if (criteria === 'name') {
            aText = a.cells[0].textContent.toLowerCase(); // Ensure case-insensitive sorting
            bText = b.cells[0].textContent.toLowerCase();
        } else if (criteria === 'date') {
            aText = new Date(a.cells[1].textContent);
            bText = new Date(b.cells[1].textContent);
        } else if (criteria === 'status') {
            aText = a.cells[6].querySelector('select').value;
            bText = b.cells[6].querySelector('select').value;
        } else if (criteria === 'metrics') {
            aText = parseFloat(a.cells[5].textContent); // Ensure we parse as a float
            bText = parseFloat(b.cells[5].textContent);
        }

        // Compare values based on criteria
        if (typeof aText === 'number' && typeof bText === 'number') {
            return bText - aText; // For numbers, return difference for descending order
        }
        return aText < bText ? -1 : aText > bText ? 1 : 0; // For other types (string), return standard comparison
    });

    // Re-append sorted rows to the tbody
    rows.forEach(row => tbody.appendChild(row));
}

// Update applicant status
document.querySelectorAll('select[name="applicant-status"]').forEach(select => {
    select.addEventListener('change', function() {
        const applicantId = this.getAttribute('data-id');
        const newStatus = this.value;

        fetch('php/update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: applicantId,
                status: newStatus
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Network response was not ok: ${text}`);
                });
            }
            return response.text();
        })
        .then(data => {
            try {
                const json = JSON.parse(data); // Attempt to parse JSON
                if (json.success) {
                    console.log('Status updated successfully!');
                } else {
                    console.error('Failed to update status:', json.error);
                }
            } catch (e) {
                console.error('Error parsing response as JSON:', data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

function filterTableBySearch() {
    const searchValue = document.getElementById('searchBar').value.toLowerCase();
    const rows = document.querySelectorAll('#applicantTable tbody tr');

    rows.forEach(row => {
        const nameCell = row.cells[0].textContent.toLowerCase(); // Assuming the name is in the first column

        if (nameCell.includes(searchValue)) {
            row.style.display = ''; // Show row if it matches
        } else {
            row.style.display = 'none'; // Hide row if it doesn't match
        }
    });
}
</script>

</body>
</html>
