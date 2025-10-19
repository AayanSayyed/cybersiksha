<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$sql = "SELECT * FROM chat_messages ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Escape to avoid XSS issues
        $username = htmlspecialchars($row['username']);
        $message = htmlspecialchars($row['message']);
        echo "<div class='msg'><strong>{$username}:</strong> {$message}</div>";
    }
} else {
    echo "<div class='msg'>No messages yet.</div>";
}
?>
