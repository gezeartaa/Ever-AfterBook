<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost"; // Change if needed

$dbname = "everafterbook"; // Change to your database name

$conn = new mysqli($host, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ""; // Variable to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 hashing (not secure, but matches your database)

    // Check credentials
    $sql = "SELECT * FROM admin WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['admin_username'] = $username;
        header("Location: admin-dashboard.php"); // Redirect after login
        exit();
    } else {
        $error = "Invalid username or password!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        
        <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" class="btn-dark-pink">Login</button>
        </form>
    </div>
</body>
</html>
