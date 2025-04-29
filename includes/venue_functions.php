<?php
function addVenue($conn, $data, $files) {
    $venue_name = mysqli_real_escape_string($conn, $data['name']);
    $location = mysqli_real_escape_string($conn, $data['location']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $capacity = intval($data['capacity']);
    $price = floatval($_POST['price']);
    $main_image_index = isset($data['main_image']) ? intval($data['main_image']) : -1;

    $stmt = $conn->prepare("INSERT INTO venues (name, location, description, capacity, price)
    VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssid", $venue_name, $location, $description, $capacity, $price); 
    // Types: s = string, i = int, d = double (float), s = string again (if needed)

    if (!$stmt->execute()) {
        return ['success' => false, 'error' => $stmt->error];
    }

    $venue_id = mysqli_insert_id($conn);
    $target_dir = "images/venue images/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Prepare image insert statement
    $stmt_img = $conn->prepare("INSERT INTO venue_images (venue_id, image_url, is_main) VALUES (?, ?, ?)");
    if (!$stmt_img) {
        return ['success' => false, 'error' => $conn->error];
    }
    
    foreach ($files['images']['tmp_name'] as $index => $tmp_name) {
        if ($files['images']['error'][$index] === 0) {
            $original_name = basename($files['images']['name'][$index]);
    
            // Optional: validate file type
            $file_type = mime_content_type($tmp_name);
            if (!in_array($file_type, ['image/jpeg', 'image/png', 'image/webp'])) {
                continue; // skip invalid file types
            }
    
            // Rename file to avoid conflicts
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
    // Check if there are any active reservation applications for this venue
    $reservation_application_check = mysqli_query($conn, "SELECT COUNT(*) AS count FROM Reservation_Application WHERE venue_id = $venue_id AND status != 'Denied'");
    $application_count = mysqli_fetch_assoc($reservation_application_check)['count'];

    if ($application_count > 0) {
        return ['success' => false, 'error' => 'This venue cannot be deleted because there are active reservation applications.'];
    }

    // Optionally delete image files from server
    $result = mysqli_query($conn, "SELECT image_url FROM venue_images WHERE venue_id = $venue_id");
    while ($row = mysqli_fetch_assoc($result)) {
        if (file_exists($row['image_url'])) {
            unlink($row['image_url']);
        }
    }

    // Delete venue (cascades to images, applications, reservations)
    if (mysqli_query($conn, "DELETE FROM venues WHERE venue_id = $venue_id")) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => mysqli_error($conn)];
    }
}


function updateVenue($conn, $venue_id, $data, $files) {
    $name = mysqli_real_escape_string($conn, $data['name']);
    $location = mysqli_real_escape_string($conn, $data['location']);
    $capacity = intval($data['capacity']);
    $price = floatval($data['price']);
    $description = mysqli_real_escape_string($conn, $data['description']);

    $update = mysqli_query($conn, "
        UPDATE venues SET
        name = '$name',
        location = '$location',
        capacity = $capacity,
        price = $price,
        description = '$description'
        WHERE venue_id = $venue_id
    ");

    if (!$update) {
        return ['success' => false, 'error' => mysqli_error($conn)];
    }

    $target_dir = "images/venue images/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Upload new main image
    if (isset($files['main_image']) && $files['main_image']['error'] === 0) {
        $main_image_name = time() . '_' . basename($files['main_image']['name']);
        $main_image_path = $target_dir . $main_image_name;

        if (move_uploaded_file($files['main_image']['tmp_name'], $main_image_path)) {
            mysqli_query($conn, "UPDATE venue_images SET is_main = 0 WHERE venue_id = $venue_id");
            mysqli_query($conn, "
                INSERT INTO venue_images (venue_id, image_url, is_main)
                VALUES ($venue_id, '$main_image_path', TRUE)
            ");
        }
    }

    // Upload additional images
    if (!empty($files['extra_images']['name'][0])) {
        foreach ($files['extra_images']['tmp_name'] as $index => $tmp_name) {
            if ($files['extra_images']['error'][$index] === 0) {
                $filename = time() . '_' . basename($files['extra_images']['name'][$index]);
                $targetPath = $target_dir . $filename;

                if (move_uploaded_file($tmp_name, $targetPath)) {
                    mysqli_query($conn, "
                        INSERT INTO venue_images (venue_id, image_url)
                        VALUES ($venue_id, '$targetPath')
                    ");
                }
            }
        }
    }

    return ['success' => true];
}



?>