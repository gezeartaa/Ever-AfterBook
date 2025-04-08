<?php
include('db_connection.php'); 

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

    // Fetch all images for this venue
    $img_sql = "SELECT * FROM venue_images WHERE venue_id = $venue_id";
    $img_result = $conn->query($img_sql);

    $main_image = null;
    $gallery_images = [];

    if ($img_result->num_rows > 0) {
        while ($img = $img_result->fetch_assoc()) {
            if ($img['is_main']) {
                $main_image = $img['image_url'];
            } else {
                $gallery_images[] = $img['image_url'];
            }
        }
    }

    // Use a default image if no main image is found
    if (!$main_image) {
        $main_image = 'images/default_venue.jpg';
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
        a {
            text-decoration: none;
        }

        .main-image-container {
            width: 90%;
            height: 500px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-bottom: 1px solid #ddd;
            border-radius: 10px;
        }


        .venue-details {
            display: flex;
            flex-direction: column;
            align-items: center;
            align-self: center;
            justify-content: center;
            max-width: 90%;
            margin: 20px auto;
            padding: 20px;
            padding-top: 50px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .textbox{
            display: flex;
            flex-direction: column;
            width: 90%;
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

        .formcontainer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .form {
            display: flex;
            flex-direction: column;
            width: 70%;
            max-width: 600px;
            margin: 30px 0;
        }

        .form label, .form input, .form textarea, .form button {
            margin-bottom: 15px;
            font-size: 1em;
        }

        .form button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form button:hover {
            background-color: #0056b3;
        }

        .gallery-container {
            /* margin: 40px auto; */
            max-width: 90%;
            padding: 10px;
        }

        .gallery-container h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .gallery-scroll {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding: 10px;
            scroll-behavior: smooth;
        }

        .gallery-image {
            height: 400px;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <!-- Main image -->
    

    <!-- Venue details -->
    <div class="venue-details">
        <div class="main-image-container" style="background-image: url('<?php echo $main_image; ?>');">
        </div>

        <h1><?php echo htmlspecialchars($venue['name']); ?></h1>
        <div class="textbox">
            <p><strong>Description:</strong> <?php echo htmlspecialchars($venue['description']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($venue['location']); ?></p>
            <p><strong>Price:</strong> $<?php echo htmlspecialchars($venue['price']); ?></p>
        </div>
        <a href="venues.php" class="back-link">← Back to Venues</a>

        <!-- Gallery -->
        <?php if (!empty($gallery_images)): ?>
            <div class="gallery-container">
                <h2>More Photos</h2>
                <div class="gallery-scroll">
                    <?php foreach ($gallery_images as $img): ?>
                        <img src="<?php echo $img; ?>" class="gallery-image" alt="Venue image">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Reservation form -->
    <div class="formcontainer">
        <form class="form" action="submit_reservation.php" method="POST">
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
        </form>
    </div>


</body>
</html>

<?php
$conn->close();
?>
