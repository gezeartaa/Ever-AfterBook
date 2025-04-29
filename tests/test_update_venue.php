<?php
require_once(__DIR__ . '/../db_connection.php');
require_once(__DIR__ . '/../includes/venue_functions.php');

// Start the session to test session management
session_start();

// Create a test venue first
$venue_data = [
    'name' => 'Test Venue',
    'location' => 'Test Location',
    'description' => 'Test Description',
    'capacity' => 200,
    'price' => 5000.00,
    'main_image' => 0,  // The first image uploaded should be the main image
];

// Setup mock files for testing image upload
$_FILES = [
    'images' => [
        'name' => ['test_image.jpg'],
        'type' => ['image/jpeg'],
        'tmp_name' => [__DIR__ . '/test_assets/test_image.jpg'],  // Make sure this path exists!
        'error' => [0],
    ]
];

// Add the venue to the database
$response = addVenue($conn, $venue_data, $_FILES);

if ($response['success']) {
    // Fetch the last inserted venue ID for further testing
    $venue_id = mysqli_insert_id($conn);
    
    // Now we will attempt to update the venue
    $update_data = [
        'name' => 'Updated Test Venue',
        'location' => 'Updated Location',
        'description' => 'Updated Description',
        'capacity' => 250,
        'price' => 5500.00,
    ];

    // Mock the image upload for the update
    $_FILES['images']['tmp_name'] = [__DIR__ . '/test_assets/test_image.jpg'];
    $_FILES['images']['name'] = ['test_image.jpg'];
    
    // Call the updateVenue function (assuming it's defined in your functions)
    $update_response = updateVenue($conn, $update_data, $_FILES, $venue_id);
    
    // Check if the venue update was successful
    if ($update_response['success']) {
        echo "Venue updated successfully!";
    } else {
        echo "Failed to update venue: " . $update_response['error'];
    }
} else {
    echo "Failed to add venue: " . $response['error'];
}
?>
