<?php
include('db_connection.php'); 

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
