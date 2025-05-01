<?php
require_once(__DIR__ . '/../db_connection.php');
require_once(__DIR__ . '/../includes/venue_functions.php'); // Include the file with the deleteVenue function

echo "Test Case 1: Try to delete a venue with active reservations \n";
$venue_id_with_reservation = 1; // Adjust this to a venue ID with active reservations
$result = deleteVenue($conn, $venue_id_with_reservation);

if (!$result['success']) {
    echo "Test Case 1 Passed: " . $result['error'] . "\n"; // Expect failure
} else {
    echo "Test Case 1 Failed: Venue should not be deleted with active reservations.\n";
}

echo "Test Case 2: Try to delete a venue with no active reservations \n";
$venue_id_without_reservation = 29; // Adjust this to a venue ID with no active reservations
$result = deleteVenue($conn, $venue_id_without_reservation);

if ($result['success']) {
    echo "Test Case 2 Passed: Venue deleted successfully.\n"; // Expect success
} else {
    echo "Test Case 2 Failed: Venue should be deleted without active reservations.\n";
}
?>
