<?php
// Start error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Corrected database credentials
$servername = "localhost"; // Correct host name
$dbUsername = "root";             // No leading space
$dbPassword = "";           // Your password
$dbName = "if0_39527538_cyber";

// Create a connection to the database
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Input validation
    if (empty($username) || empty($password)) {
        echo "<script>alert('Username and password are required.'); window.history.back();</script>";
        exit();
    }

    // Check if the username exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check for matching username
    if ($result->num_rows === 0) {
        echo "<script>alert('Username not found. Please register first.'); window.history.back();</script>";
        $stmt->close();
        $conn->close();
        exit();
    }

    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $user['username'];
        echo "<script>alert('Login successful!'); window.location.href='main.html';</script>";
    } else {
        echo "<script>alert('Incorrect password.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
