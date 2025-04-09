<?php
include('db_connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venue_name = mysqli_real_escape_string($conn, $_POST['name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $capacity = intval($_POST['capacity']);

    // 1. Insert venue
    $venue_sql = "INSERT INTO venues (name, location, description, capacity) 
                  VALUES ('$venue_name', '$location', '$description', $capacity)";
    
    if (mysqli_query($conn, $venue_sql)) {
        $venue_id = mysqli_insert_id($conn); // get the new venue ID

        // 2. Handle image uploads
        $main_image_index = isset($_POST['main_image']) ? intval($_POST['main_image']) : -1;

        foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
            if ($_FILES['images']['error'][$index] === 0) {
                $image_name = time() . "_" . basename($_FILES['images']['name'][$index]);
                $target_dir = "uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $target_file = $target_dir . $image_name;
                move_uploaded_file($tmp_name, $target_file);

                $is_main = ($index === $main_image_index) ? 1 : 0;

                // Insert into venue_images
                $img_sql = "INSERT INTO venue_images (venue_id, image_url, is_main) 
                            VALUES ($venue_id, '$target_file', $is_main)";
                mysqli_query($conn, $img_sql);
            }
        }

        $success = "Venue and images uploaded successfully!";
    } else {
        $error = "Error adding venue: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add New Venue</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f8f8;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #B76E79;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            margin-top: 25px;
            background-color: #B76E79;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        button:hover {
            background-color: #9a5b65;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .success { color: #2e7d32; }
        .error { color: #c62828; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Venue</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Venue Name:</label>
            <input type="text" name="name" required>

            <label>Location:</label>
            <input type="text" name="location" required>

            <label>Description:</label>
            <textarea name="description" rows="4" required></textarea>

            <label>Capacity:</label>
            <input type="number" name="capacity" min="1" required>

            <label>Upload Images (you can select multiple):</label>
            <input type="file" name="images[]" multiple accept="image/*" required>

            <label>Select the main image (0 = first image, 1 = second, etc.):</label>
            <input type="number" name="main_image" min="0" placeholder="Enter index of main image">

            <button type="submit">Add Venue</button>
        </form>

        <?php if (!empty($success)) echo "<p class='message success'>$success</p>"; ?>
        <?php if (!empty($error)) echo "<p class='message error'>$error</p>"; ?>
    </div>
</body>
</html>
