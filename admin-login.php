<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']); // Clear the error after displaying
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Average&family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin-login.css">
    <link rel="icon" type="image/x-icon" href="img/peso_logo.png">
    <title>PESO | Admin Login</title>
    <style>
      .error {
            color: red;
            margin: 10px auto;
            padding: 10px;
            border: 1px solid red;
            border-radius: 4px;
            background-color: #fdd;
            width: 100%; /* Full width within container */
            text-align: center; /* Center the text */
            width: 250px;
        }

    </style>
</head>
<body>
    <div class="left-container">
        <p class="greeting">Hello, Admin!</p>
        <p class="welcome">Welcome!</p>
     
        <form action="php/login.php" method="POST">
            <input type="text" placeholder="Enter username" name="username" required>
            <input type="password" placeholder="Enter password" name="password" required>
            <button type="submit">LOG IN</button>
        </form>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <div class="bottom-text">
            <p>© 2024 Public Employment Service Office</p>
            <p><a href="peso-official-website.html" class="back-to-website"> << &nbsp; Back to Website</a></p>
        </div>
    </div>
    <div class="right-container">
        <img src="img/peso_logo.png" alt="Big Logo" class="big-logo">
        <div class="small-logos">
            <img src="img/sponsor1.png" alt="Small Logo 1">
            <img src="img/sponsor2.png" alt="Small Logo 2">
            <img src="img/sponsor3.png" alt="Small Logo 3">
            <img src="img/sponsor4.png" alt="Small Logo 4">
        </div>
    </div>
</body>
</html>
