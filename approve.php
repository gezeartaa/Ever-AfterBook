<?php
session_start(); // Start session to access admin_id
include('db_connection.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    die("Access denied. Please log in as admin.");
}

// Fetch applications from the database
$applications = $conn->query("SELECT * FROM reservation_application");
?>
<?php include('header_admin.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Reservations</title>
    <link href="https://fonts.googleapis.com/css2?family=Georgia:wght@400;700&family=Times+New+Roman&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #f8f0f2; /* Soft pink background */
            /* padding: 20px; */
            margin: 0;
            color: #3a3a3a;
        }

        .container{
            display: flex;
            flex-direction: column;
            width: 90%;
            align-self: center;
            /* align-items: center; */

        }

        h2 {
            color: #B76E79; /* Elegant pinkish hue for heading */
            text-align: center;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 30px;
            font-family: 'Times New Roman', serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            border: 1px solid #e3e3e3;
            text-align: left;
        }

        th {
            background-color: #B76E79; /* Soft pink */
            color: white;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            background-color: #fafafa;
            font-size: 16px;
        }

        td.status {
            font-weight: bold;
            color: #2d4d76;
        }

        td button {
            padding: 8px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        td button[name="action"][value="approve"] {
            background-color: #77b300; /* Soft green */
            color: white;
        }

        td button[name="action"][value="deny"] {
            background-color: #e74c3c; /* Soft red */
            color: white;
        }

        td button:hover {
            opacity: 0.8;
        }

        td span {
            font-style: italic;
            color: #888;
        }

        table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        table tr:hover td {
            background-color: #fff0f5; /* Very light pink on hover */
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            td button {
                padding: 6px 16px;
                font-size: 12px;
            }

            h2 {
                font-size: 28px;
            }
        }

        .back {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #B76E79;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .back:hover {
            background-color: #9b4f60;
        }

        .approved {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #B76E79;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .approved:hover {
            background-color: #9b4f60;
        }
        .button_wrapper{
            display: flex;
            flex-direction: row;
            gap: 10px;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

<h2>Pending Wedding Reservations</h2>

<div class="container">
<table>
    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Email</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $applications->fetch_assoc()): ?>
        <tr>
            <td><?= $row['application_id'] ?></td>
            <td><?= htmlspecialchars($row['client_name']) ?></td>
            <td><?= htmlspecialchars($row['client_email']) ?></td>
            <td><?= $row['event_date'] ?></td>
            
            <!-- Display the status -->
            <td class="status" id="status-<?= $row['application_id'] ?>">
                <?= htmlspecialchars($row['status']) ?>
            </td>

            <td id="actions-<?= $row['application_id'] ?>">
                <?php if ($row['status'] == 'Pending'): ?>
                    <button onclick="handleAction(<?= $row['application_id'] ?>, 'approve')">Approve</button>
                    <button onclick="handleAction(<?= $row['application_id'] ?>, 'deny')">Deny</button>
                <?php else: ?>
                    <!-- Hide buttons if already approved or denied -->
                    <span>No action needed</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<div class="button_wrapper">
<a class="approved" href="approved_reservations.php">View Approved Reservations</a>
<a class="back" href="dashboard.php">← Back to Dashboard</a>
</div>

<script>
    function handleAction(application_id, action) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "handle_action.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("application_id=" + application_id + "&action=" + action);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                var statusCell = document.getElementById("status-" + application_id);
                var actionsCell = document.getElementById("actions-" + application_id);

                if (response === "approved") {
                    statusCell.innerHTML = "Approved";
                    actionsCell.innerHTML = "<span>No action needed</span>";
                } else if (response === "denied") {
                    statusCell.innerHTML = "Denied";
                    actionsCell.innerHTML = "<span>No action needed</span>";
                }
            }
        };
    }
</script>
</div>

<?php include('footer.php'); ?>

</body>
</html>
