<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("No venue ID provided.");
}

$venue_id = intval($_GET['id']);

// Optionally delete image files from server
$result = mysqli_query($conn, "SELECT image_url FROM venue_images WHERE venue_id = $venue_id");
while ($row = mysqli_fetch_assoc($result)) {
    if (file_exists($row['image_url'])) {
        unlink($row['image_url']);
    }
}

// Delete venue (cascades to images, applications, reservations)
mysqli_query($conn, "DELETE FROM venues WHERE venue_id = $venue_id");

header("Location: manage_venues.php");
exit();
?>
