<?php
include('db_connection.php');

// Fetch pending reservations
$query = "SELECT * FROM reservation_application";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Pending Reservations</h2>";
    echo "<table border='1'>
            <tr>
                <th>Application ID</th>
                <th> Venue ID</th>
                <th>Decor ID</th>
                <th>Menu ID</th>
                <th>Music ID</th>
                <th>Client Name</th>
                <th>Client Email</th>
                <thEvent Date</th>
                <th>Others</th>
                <th>Status</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['application_id'] . "</td>
                <td>" . $row['venue_id'] . "</td>
                <td>" . $row['decor_id'] . "</td>
                <td>" . $row['menu_id'] . "</td>
                <td>" . $row['music_id'] . "</td>
                <td>" . $row['client_name'] . "</td>
                <td>" . $row['client_email'] . "</td>
                <td>" . $row['event_date'] . "</td>
                <td>" . $row['others'] . "</td>
                <td>" . $row['status'] . "</td>
                <td>
                    <a href='approve_reservation.php?id=" . $row['application_id'] . "'>Approve</a> | 
                    <a href='deny_reservation.php?id=" . $row['application_id'] . "'>Deny</a>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No pending reservations.</p>";
}

$conn->close();
?>
