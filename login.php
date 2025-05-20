<?php
session_start();
include('db_connection.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_user = mysqli_real_escape_string($conn, $_POST['username']);
    $admin_pass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$admin_user'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($admin_pass, $row['password'])) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_username'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Wedding Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Georgia', serif;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Wedding Icon / Logo -->
        <img src="images/logo2.jpg" alt="Wedding Logo" class="logo">
        <h2>Admin Login</h2>
        <form method="post" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <?php if (!empty($error)) { echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>"; } ?>
    </div>
    
</body>
</html>
