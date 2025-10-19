<?php
$host = "sql100.infinityfree.com";
$username = "if0_39527538";
$password = "Ayan4321Sayyad";
$database = "if0_39527538_cyber";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
