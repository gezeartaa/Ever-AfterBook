<?php
require_once(__DIR__ . '/fake_db.php');
require_once(__DIR__ . '/../includes/venue_functions.php');

// Initialize the fake DB
$fakeDb = new FakeDB();

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

// Call the function
$result = addVenue($fakeDb, $_POST, $testFiles);

// Output result
if ($result['success']) {
    echo "✅ Test passed: Venue added successfully.\n";
} else {
    echo "❌ Test failed: " . $result['error'] . "\n";
}
