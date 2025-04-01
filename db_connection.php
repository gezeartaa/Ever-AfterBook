<?php
$servername = "sql103.infinityfree.com";
$username = "if0_38648351";
$password = "8c3Ygw1f2phuy2s";
$dbname = "if0_38648351_everafterbook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>
