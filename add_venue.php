<?php
include('db_connection.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

        include('includes/venue_functions.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $result = addVenue($conn, $_POST, $_FILES);
            if ($result['success']) {
                $success = "Venue and images uploaded successfully!";
            } else {
                $error = "Error adding venue: " . $result['error'];
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
            color: #be97b3ff;
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
            background-color: #be97b3ff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            transition: color .15s ease-in-out;
        }

        button:hover {
            background-color: #b87c91ff;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .success { color: #2e7d32; }
        .error { color: #c62828; }

        a{
            text-decoration: none;
            transition: color 0.15s ease-in-out;
            color: black;
        }
        .exit{
            display: flex;
            align-items: end;
            flex-direction: column;
            
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="exit">
            <a href="manage_venues.php">X</a>
        </div>
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

            <label>Price:</label>
            <input type="number" name="price" step="0.01" max="99999999.99">

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
