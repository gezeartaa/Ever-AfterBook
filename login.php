<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
<<<<<<< HEAD
$host = "localhost"; // Change if needed

$dbname = "everafterbook"; // Change to your database name

$conn = new mysqli($host, $dbname);

// Check connection
=======
$host = "localhost";
$user = "root"; // Change if needed
$pass = ""; // Change if your MySQL user has a password
$dbname = "everafterbook"; // Make sure this matches your database

$conn = new mysqli($host, $user, $pass, $dbname);

// Check for connection errors
>>>>>>> ce371448dd06defa2774f635653c3806b5dccc0a
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

<<<<<<< HEAD
$error = ""; // Variable to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 hashing (not secure, but matches your database)

    // Check credentials
=======
$error = ""; // Store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $hashed_password = md5($password); // Hash password (matches database)

    // Prepare SQL statement
>>>>>>> ce371448dd06defa2774f635653c3806b5dccc0a
    $sql = "SELECT * FROM admin WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("🔥 SQL Error: " . $conn->error); // Debugging SQL errors
    }

    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

<<<<<<< HEAD
    if ($result->num_rows > 0) {
        $_SESSION['admin_username'] = $username;
        header("Location: admin-dashboard.php"); // Redirect after login
=======
    // Check if user exists
    if ($result->num_rows > 0) {
        $_SESSION['admin_username'] = $username;
        header("Location: admin-dashboard.php"); // Redirect to dashboard
>>>>>>> ce371448dd06defa2774f635653c3806b5dccc0a
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
    <style>
        /* Global Styles */
body {
    background: url('images/homepageBackground.jpg') no-repeat center center/cover;
    font-family: 'Cormorant Garamond', serif;
    color: #5e3a2f;
    margin: 0;
    padding: 0;
}

/* Navbar */
.navbar {
    background: rgba(255, 245, 238, 0.9);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    font-size: 24px;
    font-weight: bold;
    color: #d63384 !important;
}

.nav-link {
    color: #5e3a2f !important;
    font-weight: 500;
}

.nav-link:hover {
    color: #d63384 !important;
}

/* Login Container */
.login-container {
    background: rgba(255, 255, 255, 0.9);
    width: 400px;
    padding: 30px;
    margin: 100px auto;
    text-align: center;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

h2 {
    font-size: 30px;
    margin-bottom: 20px;
    color: #b22222;
}

/* Form */
form {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 5px;
    text-align: left;
}

input {
    padding: 10px;
    border: 2px solid #d63384;
    border-radius: 10px;
    outline: none;
    font-size: 16px;
    margin-bottom: 15px;
}

input:focus {
    border-color: #b22222;
}

/* Login Button */
button {
    background: #d63384;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #b22222;
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-container {
        width: 90%;
        margin-top: 50px;
    }
}

    </style>
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
<<<<<<< HEAD
            
            <button type="submit" class="btn-dark-pink">Login</button>
=======

            <button type="submit" class="btn btn-dark">Login</button>
>>>>>>> ce371448dd06defa2774f635653c3806b5dccc0a
        </form>
    </div>
</body>
</html>
