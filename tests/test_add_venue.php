<?php
require_once(__DIR__ . '/../db_connection.php');
require_once(__DIR__ . '/../includes/venue_functions.php');

// Mock POST data
$_POST = [
    'name' => 'Test Venue',
    'location' => 'Test Location',
    'description' => 'This is a test venue for testing.',
    'capacity' => 100,
    'price' => 2000.9,
    'main_image' => 0
];

// Mock FILES data - simulate image uploads
$testFiles = [
    'images' => [
        'name' => ['test_image.jpg'],
        'type' => ['image/jpeg'],
        'tmp_name' => [__DIR__ . '/test_assets/test_image.jpg'],
        'error' => [0],
        'size' => [filesize(__DIR__ . '/test_assets/test_image.jpg')]
    ]
];

// Debug output for $_POST
var_dump($_POST); // This will show you the contents of the $_POST array

// Call the function
$result = addVenue($conn, $_POST, $testFiles);

// Output result
if ($result['success']) {
    echo "✅ Test passed: Venue added successfully.\n";
} else {
    echo "❌ Test failed: " . $result['error'] . "\n";
}
?>
