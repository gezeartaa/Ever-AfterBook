<?php
session_start(); // Start session to access admin_id
include('db_connection.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    die("Access denied. Please log in as admin.");
}

$admin_id = $_SESSION['admin_id'];

// Ensure application_id and action are set and valid
if (!isset($_POST['application_id']) || !isset($_POST['action'])) {
    die("Invalid request.");
}

$application_id = (int)$_POST['application_id']; // Casting to int for safety
$action = $_POST['action'];

// Validate the action to ensure it's either 'approve' or 'deny'
if (!in_array($action, ['approve', 'deny'])) {
    die("Invalid action.");
}

// Handle the 'approve' action
if ($action === 'approve') {
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE reservation_application SET status = ? WHERE application_id = ?");
    $status = 'Approved';
    $stmt->bind_param("si", $status, $application_id);
    if (!$stmt->execute()) {
        die("Error updating status: " . $conn->error);
    }

    // Insert the confirmed reservation into the reservation table
    $confirmed_date = date("Y-m-d");
    $stmt = $conn->prepare("INSERT INTO reservation (application_id, admin_id, confirmed_date)
                            VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $application_id, $admin_id, $confirmed_date);
    if (!$stmt->execute()) {
        die("Error inserting reservation: " . $conn->error);
    }

    echo "approved"; // Send response to AJAX
} elseif ($action === 'deny') {
    // Handle the 'deny' action
    $stmt = $conn->prepare("UPDATE reservation_application SET status = ? WHERE application_id = ?");
    $status = 'Denied';
    $stmt->bind_param("si", $status, $application_id);
    if (!$stmt->execute()) {
        die("Error denying application: " . $conn->error);
    }

    echo "denied"; // Send response to AJAX
}
?>
