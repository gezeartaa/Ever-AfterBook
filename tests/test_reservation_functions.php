<?php
// test_reservation_functions.php

require_once(__DIR__ . '/../db_connection.php');
require_once(__DIR__ . '/../includes/reservation_functions.php');

echo "Testing Reservation Approval and Denial \n";

// Replace with a valid application_id from your DB for testing
$test_application_id = 1; // Make sure this exists and is 'Pending'
$admin_id = 1; // Make sure this is a valid admin ID in your session/db

echo "Testing approveReservation()...\n";
$result = approveReservation($conn, $test_application_id, $admin_id);

if ($result['success']) {
    echo "approveReservation() succeeded. \n";
} else {
    echo "approveReservation() failed: \n" . $result['error'] ;
}

// Optional: Reset the status to 'Pending' in DB manually if you want to re-test
// You can also use a different application ID below

echo "Testing denyReservation()...<\n";

// This assumes you've reset or chosen a fresh pending application
$result = denyReservation($conn, $test_application_id);

if ($result['success']) {
    echo "denyReservation() succeeded.\n";
} else {
    echo "denyReservation() failed: \n" . $result['error'] ;
}

$conn->close();
?>
