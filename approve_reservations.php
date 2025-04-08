<?php
include('db_connection.php');

// Fetch all approved reservations with client info and admin username
$query = "SELECT r.*, 
                 ra.client_name, 
                 ra.event_date, 
                 a.username AS admin_name
          FROM reservation r
          LEFT JOIN reservation_application ra ON r.application_id = ra.application_id
          LEFT JOIN admin a ON r.admin_id = a.admin_id";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

echo "<h2>Approved Reservations</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>Reservation ID</th>
                <th>Application ID</th>
                <th>Client Name</th>
                <th>Event Date</th>
                <th>Approved By</th>
                <th>Confirmed Date</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        $client_name = $row['client_name'] ?? 'Unknown';
        $event_date = $row['event_date'] ?? 'Unknown';
        $admin_name = $row['admin_name'] ?? 'Unknown';

        echo "<tr>
                <td>{$row['reservation_id']}</td>
                <td>{$row['application_id']}</td>
                <td>{$client_name}</td>
                <td>{$event_date}</td>
                <td>{$admin_name}</td>
                <td>{$row['confirmed_date']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No approved reservations yet.</p>";
}

$conn->close();
?>
