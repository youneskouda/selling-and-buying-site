<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "commercial_listings";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
