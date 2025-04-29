<?php
include('db_connection.php');
include('includes/venue_functions.php');
session_start();

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Ensure a venue ID is provided
if (!isset($_GET['id'])) {
    die("No venue ID provided.");
}

$venue_id = intval($_GET['id']);

// Call the deleteVenue function
$result = deleteVenue($conn, $venue_id);

// Check the result and handle success or failure
if ($result['success']) {
    header("Location: manage_venues.php?success=Venue+deleted+successfully.");
} else {
    // If there's an error, return to the previous page with an error message
    header("Location: manage_venues.php?error=" . urlencode($result['error']));
}
exit();
?>
