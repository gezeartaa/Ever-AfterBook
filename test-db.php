<?php
$host = "localhost"; // Your database host
$user = "root"; // Your database username
$pass = ""; // Your database password
$dbname = "everafterbook"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>
