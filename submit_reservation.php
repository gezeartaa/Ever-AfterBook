<?php
include('db_connection.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venue_id = isset($_POST["venue_id"]) ? intval($_POST["venue_id"]) : NULL;
    $client_name = trim($_POST["client_name"]);
    $client_email = trim($_POST["client_email"]);
    $event_date = trim($_POST["event_date"]);
    $others = trim($_POST["others"]);

    // Validate required fields
    if (empty($venue_id) || empty($client_name) || empty($client_email) || empty($event_date)) {
        die("<p>Error: Required fields are missing.</p><a href='index.php'>Back</a>");
    }

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO reservation_application 
        (venue_id, client_name, client_email, event_date, others, status) 
        VALUES (?, ?, ?, ?, ?, 'Pending')");
    
    $stmt->bind_param("issss", $venue_id, $client_name, $client_email, $event_date, $others);

    if ($stmt->execute()) {
        header("Location: reservation_success.php"); // Redirect to success page
        exit();
    } else {
        echo "<p>Error submitting reservation: " . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid request.</p>";
}
?>
