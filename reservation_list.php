<?php
include('db_connection.php');

// Flash message handler
if (isset($_GET['message'])) {
    if ($_GET['message'] == 'approved') {
        echo "<p style='color: green;'>Reservation approved successfully!</p>";
    } elseif ($_GET['message'] == 'denied') {
        echo "<p style='color: red;'>Reservation denied successfully!</p>";
    }
}

// Fetch pending reservations
$query = "SELECT * FROM reservation_application WHERE status = 'Pending'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Pending Reservations</h2>";
    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>Application ID</th>
                <th>Venue ID</th>
                <th>Decor ID</th>
                <th>Menu ID</th>
                <th>Music ID</th>
                <th>Client Name</th>
                <th>Client Email</th>
                <th>Event Date</th>
                <th>Others</th>
                <th>Status</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['application_id']}</td>
                <td>{$row['venue_id']}</td>
                <td>{$row['decor_id']}</td>
                <td>{$row['menu_id']}</td>
                <td>{$row['music_id']}</td>
                <td>{$row['client_name']}</td>
                <td>{$row['client_email']}</td>
                <td>{$row['event_date']}</td>
                <td>{$row['others']}</td>
                <td>{$row['status']}</td>
                <td>
                    <a href='approve_reservations.php?id={$row['application_id']}'>Approve</a> | 
                    <a href='deny_reservation.php?id={$row['application_id']}'>Deny</a>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No pending reservations.</p>";
}

$conn->close();
?>
