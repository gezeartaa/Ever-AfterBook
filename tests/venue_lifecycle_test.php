<?php
require_once(__DIR__ . '/../db_connection.php');
require_once(__DIR__ . '/../includes/venue_functions.php');

echo "Running venue lifecycle integration test...\n";

// ----- Setup test data -----
$testData = [
    'name' => 'Test Venue',
    'location' => 'Test City',
    'description' => 'Test description for the venue.',
    'capacity' => 100,
    'price' => 2500.50,
    'main_image' => 0 // index of the main image
];

$testFiles = [
    'images' => [
        'name' => ['test_image.jpg'],
        'type' => ['image/jpeg'],
        'tmp_name' => [__DIR__ . '/test_assets/test_image.jpg'],
        'error' => [0],
        'size' => [12345]
    ]
];

// ----- Add venue -----
$addResult = addVenue($conn, $testData, $testFiles);
if (!$addResult['success']) {
    die("Add venue failed: " . $addResult['error'] . "\n");
}

$venueId = mysqli_insert_id($conn);
echo "Venue added with ID: $venueId\n";

// ----- Update venue -----
$updateData = [
    'name' => 'Updated Venue Name',
    'location' => 'Updated City',
    'description' => 'Updated description.',
    'capacity' => 150,
    'price' => 3000.75
];

$updateFiles = [
    'main_image' => [
        'name' => 'testimg1.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => __DIR__ . '/test_assets/testimg1.jpg',
        'error' => 0,
        'size' => 12345
    ],
    'extra_images' => [
        'name' => ['extra1.jpg'],
        'type' => ['image/jpeg'],
        'tmp_name' => [__DIR__ . '/test_assets/testimg2.jpg'],
        'error' => [0],
        'size' => [12345]
    ]
];

$updateResult = updateVenue($conn, $venueId, $updateData, $updateFiles, true);
if (!$updateResult['success']) {
    die("Update venue failed: " . $updateResult['error'] . "\n");
}
echo "Venue updated successfully.\n";

// ----- Delete venue -----
$deleteResult = deleteVenue($conn, $venueId);
if (!$deleteResult['success']) {
    die("Delete venue failed: " . $deleteResult['error'] . "\n");
}
echo "Venue deleted successfully.\n";

// ----- All passed -----
echo "✅ Integration test passed.\n";
?>