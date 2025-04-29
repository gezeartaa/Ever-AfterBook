<?php
include('db_connection.php');
include('includes/reservation_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venue_id = isset($_POST["venue_id"]) ? intval($_POST["venue_id"]) : NULL;
    $client_name = trim($_POST["client_name"]);
    $client_email = trim($_POST["client_email"]);
    $event_date = trim($_POST["event_date"]);
    $others = trim($_POST["others"]);

    $result = submitReservation($conn, $venue_id, $client_name, $client_email, $event_date, $others);

    if ($result['success']) {
        header("Location: reservation_success.php");
        exit();
    } else {
        echo "<p>Error submitting reservation: " . $result['error'] . "</p><a href='index.php'>Back</a>";
    }

    $conn->close();
} else {
    echo "<p>Invalid request.</p>";
}
?>
