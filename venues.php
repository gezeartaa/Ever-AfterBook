<?php
// Include the database connection
// if ($_SERVER['SERVER_NAME'] == 'localhost') {
//     include('db_local.php'); // Use local connection for local testing
// } else {
    include('db_connection.php'); // Use remote connection for live site
// }

// SQL query to fetch all venues
$sql = "SELECT venues.*, venue_images.image_url 
        FROM venues 
        LEFT JOIN venue_images ON venues.venue_id = venue_images.venue_id 
        AND venue_images.is_main = TRUE";
$result = $conn->query($sql); ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venues</title>
    <style>
        /* CSS for the grid layout */
        a{
            text-decoration: none;
        }
        .title{
            text-align: center;
        }
        .venue-grid {
            position: relative;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            background: #fafafa;
            padding: 20px;
        }

        .venue-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .venue-card h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #333;
        }

        .venue-card p {
            font-size: 1em;
            color: #666;
            margin: 5px 0;
        }

        .venue-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .venue-card p:last-child {
            font-weight: bold;
        }
        .venue-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>

    <?php include('header.php'); ?>


    <h1 class="title">Our Venues</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<div class='venue-grid'>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<a href='venue_details.php?id=" . $row['venue_id'] . "' class='venue-card'>";
            
            // Display the main image if it exists
            // Use default image if main image is missing
            $image_url = !empty($row['image_url']) ? $row['image_url'] : 'images/default_venue.jpg';
            echo "<img src='" . $image_url . "' alt='Main image of " . htmlspecialchars($row['name']) . "' class='venue-image'>";


            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<p>Location: " . htmlspecialchars($row['location']) . "</p>";
            echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
            echo "</a>";
        }
        echo "</div>";
    } else {
        echo "No venues found.";
    }
    ?>

        
    
</body>
</html>

<?php
// Close the database connection
$conn->close();
?> 