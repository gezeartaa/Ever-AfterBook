<?php
// Include the database connection
// if ($_SERVER['SERVER_NAME'] == 'localhost') {
//     include('db_local.php'); // Use local connection for local testing
// } else {
    include('db_connection.php'); // Use remote connection for live site
// }

// SQL query to fetch all venues
$sql = "SELECT * FROM venues";
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
    </style>
</head>
<body>

<?php include('header.php'); ?>


    <h1 class="title">Our Venues</h1>

    
        <?php
        // Check if there are results from the query
        if ($result->num_rows > 0) {
    
            echo "<div class='venue-grid'>"; 
            while ($row = $result->fetch_assoc()) {
                echo "<a href='venue_details.php?id=" . $row['venue_id'] . "' class='venue-card'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p>Location: " . $row['location'] . "</p>";
                echo "<p>Price: $" . $row['price'] . "</p>";
                echo "</a>";
            }
            echo("</div");
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