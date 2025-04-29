<?php
session_start();
include('db_connection.php');
include('includes/reservation_functions.php');

if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    exit("Access denied");
}

$admin_id = $_SESSION['admin_id'];
$application_id = isset($_POST['application_id']) ? (int)$_POST['application_id'] : null;
$action = $_POST['action'] ?? '';

if (!$application_id || !in_array($action, ['approve', 'deny'])) {
    http_response_code(400);
    exit("Invalid request");
}

if ($action === 'approve') {
    $result = approveReservation($conn, $application_id, $admin_id);
} else {
    $result = denyReservation($conn, $application_id);
}

if ($result['success']) {
    echo ($action === 'approve') ? 'approved' : 'denied'; // match JS exactly
} else {
    http_response_code(500);
    echo "Error: " . $result['error'];
}
