<?php
session_start();
include('db_connection.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>This is the admin dashboard.</p>

    <a href="approved_reservations.php">View Approved Reservations</a>

    <a href="logout.php">Logout</a>
</body>
</html>
