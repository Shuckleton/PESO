<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto p-4 my-8 bg-red-100 rounded-lg">
        <h1 class="text-red-600 font-bold">Error!</h1>
        <p class="text-red-800"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : 'Unknown error occurred.'; ?></p>
        <a href="start-job-application.php" class="text-blue-600">Go back to application</a>
    </div>
</body>
</html>

<?php
// Clear the error message after displaying it
unset($_SESSION['error']);
?>
