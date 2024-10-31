<?php
$servername = "localhost";
$username = "instagrampro_webcon";
$password = "instagrampro_webcon"; // Your database password
$dbname = "instagrampro_webcontroll";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
