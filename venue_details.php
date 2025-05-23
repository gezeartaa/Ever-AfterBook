<?php
include('db_connection.php');

// Check if 'id' is present in the URL
if (isset($_GET['id'])) {
    $venue_id = intval($_GET['id']);

    // Fetch venue details
    $sql = "SELECT * FROM venues WHERE venue_id = $venue_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $venue = $result->fetch_assoc();
    } else {
        echo "<p>Venue not found.</p>";
        exit;
    }

    // Fetch venue images
    $img_sql = "SELECT * FROM venue_images WHERE venue_id = $venue_id";
    $img_result = $conn->query($img_sql);
    $main_image = 'images/default_venue.jpg';
    $gallery_images = [];

    while ($img = $img_result->fetch_assoc()) {
        if ($img['is_main']) {
            $main_image = $img['image_url'];
        } else {
            $gallery_images[] = $img['image_url'];
        }
    }

    // Fetch booked dates
    $booked_sql = "
        SELECT A.event_date
        FROM reservation R
        JOIN reservation_application A ON R.application_id = A.application_id
        WHERE A.venue_id = $venue_id
    ";
    $booked_result = $conn->query($booked_sql);
    $booked_dates = [];
    while ($row = $booked_result->fetch_assoc()) {
        $booked_dates[] = $row['event_date'];
    }

    // Fetch optional picks
    $music_options = $conn->query("SELECT * FROM music");
    $menu_options = $conn->query("SELECT * FROM menu");
    $decor_options = $conn->query("SELECT * FROM decor");


} else {
    echo "<p>Invalid request.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

        .form {
            display: flex;
            flex-direction: column;
            width: 90%;
            /* max-width: 600px; */
            margin: 30px 0;
        }

        .form label, .form input, .form textarea, .form button {
            margin-bottom: 15px;
            font-size: 1em;
        }

        .form button {
            padding: 10px;
            background-color:rgba(206, 122, 161, 0.93);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form button:hover {
            background-color:rgba(151, 80, 113, 0.93);
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


/* RADIO BUTTONS */
        .option-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .option-card {
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            width: 200px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .option-card:hover {
            border-color: #ca6997;
        }

        .option-card input[type="radio"] {
            display: none;
        }

        .option-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .option-card .option-info h4 {
            margin: 5px 0;
            font-size: 1.1em;
        }

        .option-card input[type="radio"]:checked + img,
        .option-card input[type="radio"]:checked ~ .option-info {
            outline: 2px solid #ca6997;
            outline-offset: 4px;
        }

        .option-card input[type="radio"]:checked ~ .option-info h4 {
            color: #ca6997;
            font-weight: bold;
        }

    </style>
</head>
<body>

<?php include('header.php'); ?>

<!-- Main image and venue info -->
<div class="venue-details">
    <div class="main-image-container" style="background-image: url('<?php echo $main_image; ?>');"></div>

    <h1><?php echo htmlspecialchars($venue['name']); ?></h1>
    <div class="textbox">
        <p><strong>Description:</strong> <?php echo htmlspecialchars($venue['description']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($venue['location']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($venue['price']); ?></p>
    </div>
    <a href="venues.php" class="back-link">← Back to Venues</a>

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
    <form class="form" action="submit_reservation.php" method="POST" onsubmit="return validateDate();">
        <input type="hidden" name="venue_id" value="<?php echo $venue['venue_id']; ?>">

        <label for="client_name">Your Name:</label>
        <input type="text" id="client_name" name="client_name" required>

        <label for="client_email">Your Email:</label>
        <input type="email" id="client_email" name="client_email" required>

        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required>

        <label for="others">Additional Requests (Optional):</label>
        <textarea id="others" name="others"></textarea>

        <!-- Music Options -->
        <?php if ($music_options->num_rows > 0): ?>
            <label>Choose Music:</label>
            <div class="option-group">
                <?php while ($music = $music_options->fetch_assoc()): ?>
                    <label class="option-card">
                        <input type="radio" name="music_id" value="<?php echo $music['music_id']; ?>">
                        <img src="<?php echo !empty($music['picture']) ? $music['picture'] : 'images/default_venue.jpg'; ?>" alt="Music Option">
                        <div class="option-info">
                            <h4><?php echo htmlspecialchars($music['name']); ?></h4>
                            <p><?php echo htmlspecialchars($music['style']); ?></p>
                            <p><strong>$<?php echo $music['price']; ?></strong></p>
                        </div>
                    </label>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <!-- Menu Options -->
        <?php if ($menu_options->num_rows > 0): ?>
            <label>Choose Menu:</label>
            <div class="option-group">
                <?php while ($menu = $menu_options->fetch_assoc()): ?>
                    <label class="option-card">
                        <input type="radio" name="menu_id" value="<?php echo $menu['menu_id']; ?>">
                        <img src="<?php echo !empty($menu['picture']) ? $menu['picture'] : 'images/default_venue.jpg'; ?>" alt="Menu Option">
                        <div class="option-info">
                            <h4><?php echo htmlspecialchars($menu['name']); ?></h4>
                            <p><?php echo htmlspecialchars($menu['style']); ?></p>
                            <p><strong>$<?php echo $menu['price']; ?></strong></p>
                        </div>
                    </label>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <!-- Decor Options -->
    <?php if ($decor_options->num_rows > 0): ?>
            <label>Choose Decor:</label>
            <div class="option-group">
                <?php while ($decor = $decor_options->fetch_assoc()): ?>
                    <label class="option-card">
                        <input type="radio" name="decor_id" value="<?php echo $decor['decor_id']; ?>">
                        <img src="<?php echo !empty($decor['picture']) ? $decor['picture'] : 'images/default_venue.jpg'; ?>" alt="Decor Option">
                        <div class="option-info">
                            <h4><?php echo htmlspecialchars($decor['name']); ?></h4>
                            <p><?php echo htmlspecialchars($decor['style']); ?></p>
                            <p><strong>$<?php echo $decor['price']; ?></strong></p>
                        </div>
                    </label>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>





        <button type="submit">Request Reservation</button>
    </form>
</div>

<script>
    const bookedDates = <?php echo json_encode($booked_dates); ?>;
    const eventDateInput = document.getElementById("event_date");

    function validateDate() {
        const selected = eventDateInput.value;
        if (bookedDates.includes(selected)) {
            alert("This date is already reserved. Please choose another date.");
            return false;
        }
        return true;
    }

    // Optional: visually disable booked dates (works better with custom date pickers)
    eventDateInput.addEventListener("input", () => {
        const selected = eventDateInput.value;
        if (bookedDates.includes(selected)) {
            alert("This date is already reserved.");
            eventDateInput.value = "";
        }
    });
</script>

<?php include('footer.php'); ?>

</body>
</html>

<?php $conn->close(); ?>
