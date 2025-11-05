<?php
// Database configuration
$servername = "localhost";   // or 127.0.0.1
$username   = "root";        // your MySQL username
$password   = "";            // your MySQL password (keep empty if none)
$dbname     = "farm_logger"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<h3 style='color:red;'>Database Connection Failed: " . $conn->connect_error . "</h3>");
}
?>
