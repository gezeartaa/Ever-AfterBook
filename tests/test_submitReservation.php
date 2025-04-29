<?php
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

// Create a dummy DB object with a fake prepare method
class FakeStmt {
    public function bind_param($types, ...$vars) {}
    public function execute() { return true; }
    public function close() {}
}

class FakeDB {
    public $error = "fake error";
    public function prepare($query) {
        return new FakeStmt();
    }
}

// Run the test
$fakeDb = new FakeDB();
$result = submitReservation($fakeDb, 1, "Alice", "alice@example.com", "2025-12-01", "No special requests");

assertEqual(['success' => true], $result, "Test successful reservation submission");
