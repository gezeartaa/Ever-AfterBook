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
