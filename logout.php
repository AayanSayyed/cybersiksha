<?php
session_start();                  // Start or resume the session
$_SESSION = [];                   // Clear all session variables
session_unset();                  // Optional: Unset global session variables
session_destroy();                // Destroy the session on the server
header("Location: index.html");  // Redirect to the login/home page
exit();                           // Stop further script execution
?>
