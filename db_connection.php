<?php
$servername = "localhost"; // Database server
$username = "root"; // Default MySQL username for XAMPP
$password = ""; // Default password for MySQL in XAMPP is empty
$dbname = "everafterbook"; // Replace with the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
