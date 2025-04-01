<?php
// Include the database connection
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    include('db_local.php'); // Use local connection for local testing
} else {
    include('db_config.php'); // Use remote connection for live site
}

// SQL query to fetch all venues
$sql = "SELECT * FROM venues";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Loop through the results and display them
    while ($row = $result->fetch_assoc()) {
        echo "<div class='venues'>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . $row['description'] . "</p>";
        echo "<p>Location: " . $row['location'] . "</p>";
        echo "<p>Price: $" . $row['price'] . "</p>";
        echo "</div>";
    }
} else {
    echo "No venues found.";
}

// Close the database connection
$conn->close();
?>
