<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $application_id = intval($_GET['id']);

    // Delete from reservation_application
    $stmt = $conn->prepare("DELETE FROM reservation_application WHERE application_id = ?");
    $stmt->bind_param("i", $application_id);

    if ($stmt->execute()) {
        header("Location: reservation_list.php?message=denied");
        exit();
    } else {
        echo "<p>Error denying reservation: " . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid request.</p>";
}
?>
