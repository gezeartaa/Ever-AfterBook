<?php
session_start();
include('db_connection.php');

$allowed_categories = ['music', 'menu', 'decor'];
$allowed_actions = ['add', 'edit', 'delete'];

// Get category and action from POST or GET
$category = '';
$action = '';

if (isset($_POST['category'])) {
    $category = $_POST['category'];
} elseif (isset($_GET['category'])) {
    $category = $_GET['category'];
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if (!in_array($category, $allowed_categories)) {
    die("Invalid category.");
}

if (!in_array($action, $allowed_actions)) {
    die("Invalid action.");
}

// Helper function to get ID column for category
function getIdColumn($category) {
    return match($category) {
        'music' => 'music_id',
        'menu' => 'menu_id',
        'decor' => 'decor_id',
        default => '',
    };
}

$idColumn = getIdColumn($category);

if (!$idColumn) {
    die("Invalid category ID column.");
}

// Handle delete action
if ($action === 'delete') {
    if (!isset($_POST['id'])) {
        die("Missing ID for delete.");
    }
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM $category WHERE $idColumn = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_optional_picks.php?category=$category");
    exit();
}

// Handle add and edit actions
if ($action === 'add' || $action === 'edit') {
    $name = $_POST['name'] ?? '';
    $style = $_POST['style'] ?? '';
    $price = floatval($_POST['price'] ?? 0);
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Validate required fields
    if (!$name || !$style || !$price) {
        die("Please fill all required fields.");
    }

    // Handle image upload if exists
    $picture_path = '';
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/optional_picks/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $tmp_name = $_FILES['picture']['tmp_name'];
        $filename = basename($_FILES['picture']['name']);
        $target_file = $upload_dir . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

        if (move_uploaded_file($tmp_name, $target_file)) {
            $picture_path = $target_file;
        }
    }

    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO $category (name, style, price, picture) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $style, $price, $picture_path);
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'edit') {
        if ($id <= 0) {
            die("Invalid ID for edit.");
        }

        if ($picture_path) {
            // Update including picture
            $stmt = $conn->prepare("UPDATE $category SET name = ?, style = ?, price = ?, picture = ? WHERE $idColumn = ?");
            $stmt->bind_param("ssdsi", $name, $style, $price, $picture_path, $id);
        } else {
            // Update without changing picture
            $stmt = $conn->prepare("UPDATE $category SET name = ?, style = ?, price = ? WHERE $idColumn = ?");
            $stmt->bind_param("ssdi", $name, $style, $price, $id);
        }
        $stmt->execute();
        $stmt->close();
    }

    header("Location: admin_optional_picks.php?category=$category");
    exit();
}

// If no valid action found, redirect back safely
header("Location: admin_optional_picks.php");
exit();
