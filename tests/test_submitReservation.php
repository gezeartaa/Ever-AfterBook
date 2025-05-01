<?php
// Include the fake_db.php file
require_once(__DIR__ . '/../tests/fake_db.php'); // Adjust path as necessary
require_once __DIR__ . '/../includes/reservation_functions.php';

function assertEqual($expected, $actual, $testName) {
    if ($expected === $actual) {
        echo "[PASS] $testName\n";
    } else {
        echo "[FAIL] $testName\nExpected: ";
        var_export($expected);
        echo "\nGot: ";
        var_export($actual);
        echo "\n";
    }
}

// Run the test using the FakeDB class from fake_db.php
$fakeDb = new FakeDB();

// Assuming the function submitReservation is something like:
// function submitReservation($conn, $user_id, $name, $email, $reservation_date, $special_requests) { ... }
$result = submitReservation($fakeDb, 1, "Alice", "alice@example.com", "2025-12-01", "No special requests");

if ($result['success']) {
    echo "✅ Reservation submitted successfully.\n";
} else {
    echo "❌ Reservation submission failed.\n";
    echo "Error: " . $result['error'] . "\n";
}
?>
