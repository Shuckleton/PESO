<?php
session_start();

// Initialize error variable
$error = "";

// Function to create the users table if it doesn't exist
function createUsersTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    if ($conn->query($sql) !== TRUE) {
        return "Error creating table: " . $conn->error;
    }
    return "";
}

// Function to check if a default admin user exists and create if not
function createDefaultAdminUser($conn) {
    $sql = "SELECT * FROM users WHERE username='admin'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 0) {
        // Insert a default admin user with a hashed password
        $hashedPassword = md5('adminpass'); // Replace 'adminpass' with the desired password
        $insertSql = "INSERT INTO users (username, password) VALUES ('admin', '$hashedPassword')";
        if ($conn->query($insertSql) !== TRUE) {
            return "Error creating default admin user: " . $conn->error;
        }
    }
    return "";
}

// Database connection
$conn = new mysqli('localhost', 'root', '');

// Check connection
if ($conn->connect_error) {
    $_SESSION['error'] = "Connection failed: " . $conn->connect_error;
    header("Location: ../admin-login.php");
    exit();
}

// Create database if it doesn't exist
$dbName = 'admin_login';
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) !== TRUE) {
    $_SESSION['error'] = "Error creating database: " . $conn->error;
    header("Location: ../admin-login.php");
    exit();
}

// Select the database
$conn->select_db($dbName);

// Create users table if it doesn't exist
$error = createUsersTable($conn);
if (!empty($error)) {
    $_SESSION['error'] = $error;
    header("Location: ../admin-login.php");
    exit();
}

// Create default admin user if not already created
$error = createDefaultAdminUser($conn);
if (!empty($error)) {
    $_SESSION['error'] = $error;
    header("Location: ../admin-login.php");
    exit();
}

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($conn->real_escape_string($_POST['password']));

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../admin-dashboard-job-posting.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: ../admin-login.php");
        exit();
    }
}

// Close connection
$conn->close();
?>
