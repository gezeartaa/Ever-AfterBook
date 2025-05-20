<?php
$servername = "sql7.freesqldatabase.com";
$username = "sql7780151";  //username (krejt qeto ti jep kru e qel databazen ti gjeneron vete)
$password = "Ubl1tuhM8h";       // passwordi
$dbname = "sql7780151"; //emri i databazes   

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>

<?php
// $servername = "localhost"; // Use "localhost" for local MySQL server
// $username = "root";        // XAMPP default MySQL username
// $password = "";            // Default MySQL password is empty ("" in XAMPP)
// $dbname = "everafterbook"; // Your database name (same as in phpMyAdmin)

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
?>
