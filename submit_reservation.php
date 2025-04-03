<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    include('db_local.php'); // Use local connection for local testing
} else {
    include('db_config.php'); // Use remote connection for live site
}

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
    $stmt = $conn->prepare("INSERT INTO Reservation_Application 
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
