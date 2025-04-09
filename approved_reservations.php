<?php
session_start();
include('db_connection.php');

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "
    SELECT ra.application_id, ra.event_date, 
           r.confirmed_date, a.username AS approved_by
    FROM reservation_application ra
    JOIN reservation r ON ra.application_id = r.application_id
    JOIN admin a ON r.admin_id = a.admin_id
    WHERE ra.status = 'Approved'
    ORDER BY ra.event_date DESC
";

$result = mysqli_query($conn, $sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Reservations</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #B76E79;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #B76E79;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .back {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #B76E79;
            font-weight: bold;
        }

        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Approved Reservations</h2>
    <table>
        <tr>
            <th>Application ID</th>
            <th>Event Date</th>
            <th>Approved By</th>
            <th>Confirmed Date</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['application_id']) ?></td>
                    <td><?= htmlspecialchars($row['event_date']) ?></td>
                    <td><?= htmlspecialchars($row['approved_by']) ?></td>
                    <td><?= htmlspecialchars($row['confirmed_date']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No approved reservations found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a class="back" href="dashboard.php">← Back to Dashboard</a>
</body>
</html>
