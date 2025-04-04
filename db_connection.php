<?php
$servername = "sql7.freesqldatabase.com";
$username = "sql7771296";  //username (krejt qeto ti jep kru e qel databazen ti gjeneron vete)
$password = "fdHuhExPWl";       // passwordi
$dbname = "sql7771296"; //emri i databazes   

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
