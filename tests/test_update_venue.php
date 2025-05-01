<?php
// Include your DB connection and function files
require_once(__DIR__ . '/../db_connection.php');
require_once(__DIR__ . '/../includes/venue_functions.php');

// Choose an existing venue ID in your database
$venue_id = 22; // Replace with a valid venue ID

// Prepare POST-like data
$data = [
    'name' => 'Test Venue Updated',
    'location' => 'Updated Location',
    'capacity' => 500,
    'price' => 1500.00,
    'description' => 'Updated description for test venue.',
];

// Paths to test images (ensure these files exist)
$main_image_path = __DIR__ . '/test_assets/testimg3.jpg';
$extra1 = __DIR__ . '/test_assets/testimg1.jpg';
$extra2 = __DIR__ . '/test_assets/testimg2.jpg';

// Simulate $_FILES array structure
$files = [
    'main_image' => [
        'name' => basename($main_image_path),
        'type' => mime_content_type($main_image_path),
        'tmp_name' => $main_image_path,
        'error' => 0,
        'size' => filesize($main_image_path),
    ],
    'extra_images' => [
        'name' => [basename($extra1), basename($extra2)],
        'type' => [mime_content_type($extra1), mime_content_type($extra2)],
        'tmp_name' => [$extra1, $extra2],
        'error' => [0, 0],
        'size' => [filesize($extra1), filesize($extra2)],
    ]
];

// Run the update function in test mode
$result = updateVenue($conn, $venue_id, $data, $files, true);

// Output result
if ($result['success']) {
    echo "✅ Venue updated successfully.\n";
} else {
    echo "❌ Venue update failed.\n";
    echo "Error: " . $result['error'] . "\n";
}
?>
