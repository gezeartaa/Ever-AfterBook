<?php
    function submitReservation($conn, $venue_id, $client_name, $client_email, $event_date, $others, $music_id = null, $menu_id = null, $decor_id = null) {
        if (empty($venue_id) || empty($client_name) || empty($client_email) || empty($event_date)) {
            return ['success' => false, 'error' => 'Required fields are missing'];
        }

        $stmt = $conn->prepare("
            INSERT INTO reservation_application 
            (venue_id, client_name, client_email, event_date, others, music_id, menu_id, decor_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("isssssii", 
            $venue_id, $client_name, $client_email, $event_date, $others, 
            $music_id, $menu_id, $decor_id
        );

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => $stmt->error];
        }
    }

    // In reservation_functions.php
    function approveReservation($conn, $application_id, $admin_id) {
        $stmt = $conn->prepare("UPDATE reservation_application SET status = 'Approved' WHERE application_id = ?");
        if (!$stmt) return ['success' => false, 'error' => $conn->error];
        $stmt->bind_param("i", $application_id);
        if (!$stmt->execute()) return ['success' => false, 'error' => $conn->error];
    
        $confirmed_date = date("Y-m-d");
        $stmt = $conn->prepare("INSERT INTO reservation (application_id, admin_id, confirmed_date) VALUES (?, ?, ?)");
        if (!$stmt) return ['success' => false, 'error' => $conn->error];
        $stmt->bind_param("iis", $application_id, $admin_id, $confirmed_date);
        if (!$stmt->execute()) return ['success' => false, 'error' => $conn->error];
    
        return ['success' => true];
    }
    
    function denyReservation($conn, $application_id) {
        $stmt = $conn->prepare("UPDATE reservation_application SET status = 'Denied' WHERE application_id = ?");
        if (!$stmt) return ['success' => false, 'error' => $conn->error];
        $stmt->bind_param("i", $application_id);
        if (!$stmt->execute()) return ['success' => false, 'error' => $conn->error];
    
        return ['success' => true];
    }    

?>
