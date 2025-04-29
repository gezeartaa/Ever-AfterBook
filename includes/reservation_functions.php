<?php
    function submitReservation($conn, $venue_id, $client_name, $client_email, $event_date, $others) {
        if (empty($venue_id) || empty($client_name) || empty($client_email) || empty($event_date)) {
            return ['success' => false, 'error' => 'Required fields are missing'];
        }

        $stmt = $conn->prepare("INSERT INTO reservation_application 
            (venue_id, client_name, client_email, event_date, others, status) 
            VALUES (?, ?, ?, ?, ?, 'Pending')");
        
        if (!$stmt) {
            return ['success' => false, 'error' => $conn->error];
        }

        $stmt->bind_param("issss", $venue_id, $client_name, $client_email, $event_date, $others);

        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true];
        } else {
            $stmt->close();
            return ['success' => false, 'error' => $conn->error];
        }
    }

    // In reservation_functions.php
    function approveReservationAction($conn, $application_id, $admin_id) {
        // Approve the reservation
        $stmt = $conn->prepare("UPDATE reservation_application SET status = ? WHERE application_id = ?");
        $status = 'Approved';
        $stmt->bind_param("si", $status, $application_id);
        if (!$stmt->execute()) {
            return ['success' => false, 'error' => $conn->error];
        }

        // Insert into the reservation table
        $confirmed_date = date("Y-m-d");
        $stmt = $conn->prepare("INSERT INTO reservation (application_id, admin_id, confirmed_date)
                                VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $application_id, $admin_id, $confirmed_date);
        if (!$stmt->execute()) {
            return ['success' => false, 'error' => $conn->error];
        }

        return ['success' => true];
    }

    function denyReservationAction($conn, $application_id) {
        // Deny the reservation
        $stmt = $conn->prepare("UPDATE reservation_application SET status = ? WHERE application_id = ?");
        $status = 'Denied';
        $stmt->bind_param("si", $status, $application_id);
        if (!$stmt->execute()) {
            return ['success' => false, 'error' => $conn->error];
        }

        return ['success' => true];
    }

?>
