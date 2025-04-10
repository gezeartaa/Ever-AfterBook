<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Venue ID is required.");
}

$venue_id = intval($_GET['id']);

// Fetch venue details
$venue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM venues WHERE venue_id = $venue_id"));
if (!$venue) {
    die("Venue not found.");
}

// Fetch images
$images = mysqli_query($conn, "SELECT * FROM venue_images WHERE venue_id = $venue_id");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $capacity = intval($_POST['capacity']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update = mysqli_query($conn, "
        UPDATE venues SET
        name = '$name',
        location = '$location',
        capacity = $capacity,
        price = $price,
        description = '$description'
        WHERE venue_id = $venue_id
    ");

    // Upload new main image
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $filePath = 'uploads/' . time() . '_' . basename($_FILES['main_image']['name']);
        move_uploaded_file($_FILES['main_image']['tmp_name'], $filePath);

        // Set current main to false
        mysqli_query($conn, "UPDATE venue_images SET is_main = 0 WHERE venue_id = $venue_id");

        // Insert new image as main
        mysqli_query($conn, "
            INSERT INTO venue_images (venue_id, image_url, is_main)
            VALUES ($venue_id, '$filePath', TRUE)
        ");
    }

    // Upload additional images
    if (!empty($_FILES['extra_images']['name'][0])) {
        foreach ($_FILES['extra_images']['tmp_name'] as $index => $tmp_name) {
            $filename = basename($_FILES['extra_images']['name'][$index]);
            $targetPath = 'uploads/' . time() . '_' . $filename;
            move_uploaded_file($tmp_name, $targetPath);

            mysqli_query($conn, "
                INSERT INTO venue_images (venue_id, image_url)
                VALUES ($venue_id, '$targetPath')
            ");
        }
    }

    header("Location: manage_venues.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Venue</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            margin: 0;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        h2 {
            color: #B76E79;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            background-color: #B76E79;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #9a5b65;
        }

        .image-preview {
            margin-top: 10px;
        }

        .image-preview img {
            height: 80px;
            margin-right: 10px;
            border-radius: 6px;
        }

        .image-preview a {
            display: inline-block;
            color: #cc0000;
            margin-top: 6px;
            font-size: 14px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Venue</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($venue['name']); ?>" required>

        <label>Location:</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($venue['location']); ?>" required>

        <label>Capacity:</label>
        <input type="number" name="capacity" value="<?php echo htmlspecialchars($venue['capacity']); ?>" required>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($venue['price']); ?>" required>

        <label>Description:</label>
        <textarea name="description" rows="5"><?php echo htmlspecialchars($venue['description']); ?></textarea>

        <label>Main Image:</label>
        <input type="file" name="main_image">
        <div class="image-preview">
            <?php
            mysqli_data_seek($images, 0);
            while ($img = mysqli_fetch_assoc($images)) {
                if ($img['is_main']) {
                    echo '<img src="' . htmlspecialchars($img['image_url']) . '" alt="Main">';
                }
            }
            ?>
        </div>

        <label>Additional Images:</label>
        <input type="file" name="extra_images[]" multiple>
        <div class="image-preview">
            <?php
            mysqli_data_seek($images, 0);
            while ($img = mysqli_fetch_assoc($images)) {
                if (!$img['is_main']) {
                    echo '<div style="display:inline-block;text-align:center;">';
                    echo '<img src="' . htmlspecialchars($img['image_url']) . '" alt="Image">';
                    echo '<br><a href="delete_image.php?id=' . $img['id'] . '&venue_id=' . $venue_id . '" onclick="return confirm(\'Delete this image?\')">Delete</a>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <button type="submit">Save Changes</button>
    </form>
</div>

</body>
</html>
