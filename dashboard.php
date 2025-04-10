<?php
session_start();
include('db_connection.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include('db_connection.php');

// Protect dashboard (require login)
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Reservation application stats
$res_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM reservation_application"))['count'];
$res_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM reservation_application WHERE status='Pending'"))['count'];
$res_approved = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM reservation_application WHERE status='Approved'"))['count'];
$res_denied = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM reservation_application WHERE status='Denied'"))['count'];

$venue_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM venues"))['count'];
$admin_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM admin"))['count'];

// Recent reservation applications
$recent_reservations = mysqli_query($conn, "
    SELECT ra.*, v.name AS venue_name
    FROM reservation_application ra
    LEFT JOIN venues v ON ra.venue_id = v.venue_id
    ORDER BY ra.application_id DESC
    LIMIT 5
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 30px;
            max-width: 1100px;
            margin: auto;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h3 {
            color: #B76E79;
            margin-bottom: 10px;
        }

        .recent-section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .recent-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-section th,
        .recent-section td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

       
    </style>
</head>
<body>


<?php include('header_admin.php'); ?>


    <div class="container">
        <div class="summary-cards">
            <div class="card">
                <h3>Total Reservations</h3>
                <p><?php echo $res_total; ?></p>
            </div>
            <div class="card">
                <h3>Pending</h3>
                <p><?php echo $res_pending; ?></p>
            </div>
            <div class="card">
                <h3>Approved</h3>
                <p><?php echo $res_approved; ?></p>
            </div>
            <div class="card">
                <h3>Denied</h3>
                <p><?php echo $res_denied; ?></p>
            </div>
            <div class="card">
                <h3>Total Venues</h3>
                <p><?php echo $venue_count; ?></p>
            </div>
            <div class="card">
                <h3>Total Admins</h3>
                <p><?php echo $admin_count; ?></p>
            </div>
        </div>

        <div class="recent-section">
            <h2>Recent Reservation Requests</h2>
            <table>
                <tr>
                    <th>Client Name</th>
                    <th>Venue</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($recent_reservations)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['venue_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        
    </div>

    <?php include('footer.php'); ?>

</body>
</html>

