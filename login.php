<?php
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
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Georgia', serif;
            color: #333;
        }

        .login-container {
            width: 350px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container img.logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 2px solid #B76E79;
        }

        .login-container h2 {
            font-family: 'Cursive', sans-serif;
            color: #B76E79;
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #B76E79;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        button:hover {
            background-color: #9a5b65;
        }

        .error-message {
            color: #b30000;
            margin-top: 15px;
            font-style: italic;
        }

        @media (max-width: 400px) {
            .login-container {
                width: 90%;
                padding: 20px;
            }
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
