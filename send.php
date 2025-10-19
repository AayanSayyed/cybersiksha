<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // ✅ Corrected table name here
    $sql = "INSERT INTO chat_messages (username, message) VALUES ('$username', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "Message sent successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
