<?php
$servername = "localhost"; // Use "localhost" for local MySQL server
$username = "root";        // XAMPP default MySQL username
$password = "";            // Default MySQL password is empty ("" in XAMPP)
$dbname = "everafterbook"; // Your database name (same as in phpMyAdmin)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
