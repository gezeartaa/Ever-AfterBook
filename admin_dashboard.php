<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: index.html"); // Redirect if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['admin_email']; ?>!</h2>
    <a href="logout.php">Logout</a>
</body>
</html>
