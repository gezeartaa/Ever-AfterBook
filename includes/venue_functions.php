<?php
function addVenue($conn, $data, $files) {
    $venue_name = $conn->real_escape_string($data['name']);
    $location = $conn->real_escape_string($data['location']);
    $description = $conn->real_escape_string($data['description']);
    $capacity = intval($data['capacity']);
    $price = floatval($data['price']);
    $main_image_index = isset($data['main_image']) ? intval($data['main_image']) : -1;

    $stmt = $conn->prepare("INSERT INTO venues (name, location, description, capacity, price)
    VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssid", $venue_name, $location, $description, $capacity, $price);

    if (!$stmt->execute()) {
        return ['success' => false, 'error' => $stmt->error];
    }

    $venue_id = $conn->insert_id;
    $target_dir = "images/venue images/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $stmt_img = $conn->prepare("INSERT INTO venue_images (venue_id, image_url, is_main) VALUES (?, ?, ?)");
    if (!$stmt_img) {
        return ['success' => false, 'error' => $conn->error];
    }

    foreach ($files['images']['tmp_name'] as $index => $tmp_name) {
        if ($files['images']['error'][$index] === 0) {
            $original_name = basename($files['images']['name'][$index]);

            $file_type = mime_content_type($tmp_name);
            if (!in_array($file_type, ['image/jpeg', 'image/png', 'image/webp'])) {
                continue;
            }

            $image_name = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "", $original_name);
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $is_main = ($index === $main_image_index) ? 1 : 0;
                $stmt_img->bind_param("isi", $venue_id, $target_file, $is_main);
                $stmt_img->execute();
            }
        }
    }

    $stmt_img->close();
    return ['success' => true];
}


function deleteVenue($conn, $venue_id) {
    // echo "Running query to check active reservations for venue ID $venue_id\n";
    
    // Simulate a query to check if there are active reservation applications for this venue
    $reservation_application_check = $conn->query("SELECT COUNT(*) AS count FROM Reservation_Application WHERE venue_id = $venue_id AND status != 'Denied'");
    $application_count = 0;  // Default to no active reservations

    // Check if the result is valid
    if ($reservation_application_check && $result = $reservation_application_check->fetch_assoc()) {
        $application_count = (int)$result['count'];
        // echo "Found $application_count active reservations\n";
    } else {
        // echo "No result or invalid result from reservation application check\n";
    }

    if ($application_count > 0) {
        return ['success' => false, 'error' => 'This venue cannot be deleted because there are active reservation applications.'];
    }

    // Simulate the deletion of venue images
    // echo "Running query to check and delete images for venue ID $venue_id\n";
    $result = $conn->query("SELECT image_url FROM venue_images WHERE venue_id = $venue_id");
    while ($row = $result->fetch_assoc()) {
        if (file_exists($row['image_url'])) {
            // echo "Deleting image: " . $row['image_url'] . "\n";
            unlink($row['image_url']);
        }
    }

    // Simulate the deletion of the venue
    // echo "Running query to delete venue ID $venue_id\n";
    if ($conn->query("DELETE FROM venues WHERE venue_id = $venue_id")) {
        // echo "Venue $venue_id deleted successfully.\n";
        return ['success' => true];
    } else {
        // echo "Error deleting venue $venue_id\n";
        return ['success' => false, 'error' => 'Error deleting venue.'];
    }
}




function updateVenue($conn, $venue_id, $data, $files, $testMode = false) {
    $name = $conn->real_escape_string($data['name']);
    $location = $conn->real_escape_string($data['location']);
    $capacity = intval($data['capacity']);
    $price = floatval($data['price']);
    $description = $conn->real_escape_string($data['description']);

    $update = $conn->query("
        UPDATE venues SET
        name = '$name',
        location = '$location',
        capacity = $capacity,
        price = $price,
        description = '$description'
        WHERE venue_id = $venue_id
    ");

    if (!$update) {
        return ['success' => false, 'error' => $conn->error];
    }

    $target_dir = "images/venue images/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($files['main_image']) && $files['main_image']['error'] === 0) {
        $main_image_name = time() . '_' . basename($files['main_image']['name']);
        $main_image_path = $target_dir . $main_image_name;

        $uploadSuccess = $testMode
            ? copy($files['main_image']['tmp_name'], $main_image_path)
            : move_uploaded_file($files['main_image']['tmp_name'], $main_image_path);

        if ($uploadSuccess) {
            $conn->query("UPDATE venue_images SET is_main = 0 WHERE venue_id = $venue_id");
            $conn->query("
                INSERT INTO venue_images (venue_id, image_url, is_main)
                VALUES ($venue_id, '$main_image_path', TRUE)
            ");
        }
    }

    if (!empty($files['extra_images']['name'][0])) {
        foreach ($files['extra_images']['tmp_name'] as $index => $tmp_name) {
            if ($files['extra_images']['error'][$index] === 0) {
                $filename = time() . '_' . basename($files['extra_images']['name'][$index]);
                $targetPath = $target_dir . $filename;

                $uploadSuccess = $testMode
                    ? copy($tmp_name, $targetPath)
                    : move_uploaded_file($tmp_name, $targetPath);

                if ($uploadSuccess) {
                    $conn->query("
                        INSERT INTO venue_images (venue_id, image_url)
                        VALUES ($venue_id, '$targetPath')
                    ");
                }
            }
        }
    }

    return ['success' => true];
}