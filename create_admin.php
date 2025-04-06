<?php
$servername = "sql7.freesqldatabase.com";
$username = "sql7771296";
$password = "fdHuhExPWl";
$dbname = "sql7771296";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define admin credentials
$new_user = 'admin123';
$new_pass = password_hash('admin123', PASSWORD_DEFAULT); // Hash the password

// Insert into DB
$sql = "INSERT INTO admin (username, password) VALUES ('$new_user', '$new_pass')";

if (mysqli_query($conn, $sql)) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
