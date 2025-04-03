<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    include('db_local.php'); // Use local connection for local testing
} else {
    include('db_config.php'); // Use remote connection for live site
}

// Check if 'id' is present in the URL
if (isset($_GET['id'])) {
    $venue_id = intval($_GET['id']); // Sanitize input

    // Query to fetch venue details
    $sql = "SELECT * FROM venues WHERE venue_id = $venue_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $venue = $result->fetch_assoc();
    } else {
        echo "<p>Venue not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid request.</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($venue['name']); ?></title>
    <style>
        a{
            text-decoration: none;
        }
        .formcontainer{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .form{
            display: flex;
            flex-direction: column;
            width: 70%
            
        }

        .venue-details {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .venue-details h1 {
            text-align: center;
        }

        .venue-details p {
            font-size: 1.2em;
            color: #555;
            margin: 10px 0;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="venue-details">
        <h1><?php echo htmlspecialchars($venue['name']); ?></h1>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($venue['description']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($venue['location']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($venue['price']); ?></p>
        <a href="venues.php" class="back-link">← Back to Venues</a>
    </div>

    <div class="formcontainer">
        <form class="form"action="submit_reservation.php" method="POST">
        <input type="hidden" name="venue_id" value="<?php echo $venue['venue_id']; ?>">

        <label for="client_name">Your Name:</label>
        <input type="text" id="client_name" name="client_name" required>

        <label for="client_email">Your Email:</label>
        <input type="email" id="client_email" name="client_email" required>

        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required>

        <label for="others">Additional Requests (Optional):</label>
        <textarea id="others" name="others"></textarea>

        <button type="submit">Request Reservation</button>

    </div>
</body>
</html>

<?php
$conn->close();
?>
