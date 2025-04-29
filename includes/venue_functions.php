<?php
function addVenue($conn, $data, $files) {
    $venue_name = mysqli_real_escape_string($conn, $data['name']);
    $location = mysqli_real_escape_string($conn, $data['location']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $capacity = intval($data['capacity']);
    $main_image_index = isset($data['main_image']) ? intval($data['main_image']) : -1;

    $venue_sql = "INSERT INTO venues (name, location, description, capacity) 
                  VALUES ('$venue_name', '$location', '$description', $capacity)";

    if (!mysqli_query($conn, $venue_sql)) {
        return ['success' => false, 'error' => mysqli_error($conn)];
    }

    $venue_id = mysqli_insert_id($conn);
    $target_dir = "images/venue images/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    foreach ($files['images']['tmp_name'] as $index => $tmp_name) {
        if ($files['images']['error'][$index] === 0) {
            $image_name = time() . "_" . basename($files['images']['name'][$index]);
            $target_file = $target_dir . $image_name;
            move_uploaded_file($tmp_name, $target_file);
            $is_main = ($index === $main_image_index) ? 1 : 0;

            $img_sql = "INSERT INTO venue_images (venue_id, image_url, is_main) 
                        VALUES ($venue_id, '$target_file', $is_main)";
            mysqli_query($conn, $img_sql);
        }
    }

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


?>