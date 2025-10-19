<?php
// Secret key for access
$secret_key = "kali";

// Verify the key from the URL
if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    // Unauthorized access
    header("HTTP/1.0 403 Forbidden");
    echo "Unauthorized access.";
    exit();
}

// Database connection details
$servername = "localhost";
$username = "ivwifxxu_cybersiksha";
$password = "8HQcAeLeQNr2s5JQWUpm";
$dbname = "ivwifxxu_cybersiksha";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the `users` table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Check if there is data
if ($result->num_rows > 0) {
    // Set the headers to make the browser download the file as an Excel sheet
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=data.xls");

    // Output column names
    echo "ID\tEmail\tPassword\n";

    // Output rows
    while ($row = $result->fetch_assoc()) {
        echo $row['id'] . "\t" . $row['email'] . "\t" . $row['password'] . "\n";
    }
} else {
    echo "No records found.";
}

$conn->close();
?>
