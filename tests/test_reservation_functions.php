<?php
// test_reservation_functions.php

// Include the fake_db.php file to use FakeDB
require_once(__DIR__ . '/../tests/fake_db.php'); // Adjust the path if necessary
require_once(__DIR__ . '/../includes/reservation_functions.php');

echo "Testing Reservation Approval and Denial \n";

// Set up a fake DB object from the FakeDB class
$fakeDb = new FakeDB();

// Replace with a valid application_id for testing (this is for simulating purposes)
$test_application_id = 1; // You can use a different ID to simulate different cases
$admin_id = 1; // Assuming a valid admin ID for testing

echo "Testing approveReservation()...\n";
$result = approveReservation($fakeDb, $test_application_id, $admin_id);

if ($result['success']) {
    echo "approveReservation() succeeded. \n";
} else {
    echo "approveReservation() failed: \n" . $result['error'];
}

echo "Testing denyReservation()...\n";
$result = denyReservation($fakeDb, $test_application_id);

if ($result['success']) {
    echo "denyReservation() succeeded.\n";
} else {
    echo "denyReservation() failed: \n" . $result['error'];
}
?>
