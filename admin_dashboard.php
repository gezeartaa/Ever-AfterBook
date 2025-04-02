<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
