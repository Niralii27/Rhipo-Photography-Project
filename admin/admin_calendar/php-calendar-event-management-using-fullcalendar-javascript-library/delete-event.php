<?php
include('config.php');  // Include your database configuration

// Check if the 'id' is set in the POST request
if (isset($_POST['id'])) {
    $event_id = $_POST['id'];

    // Debugging: Check what ID is received
    // echo "Received ID: " . $event_id . "<br>"; // Uncomment for debugging

    // Prepare and execute the SQL query to delete the event
    $sql = "DELETE FROM client_booking WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);  // Use 'i' for integers

    // Debugging: Log the query execution
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Successfully deleted
            echo json_encode(['success' => true, 'message' => 'Event deleted successfully.']);
        } else {
            // No rows affected, event ID not found
            echo json_encode(['success' => false, 'message' => 'Event ID not found in the database.']);
        }
    } else {
        // Log any errors executing the query
        echo json_encode(['success' => false, 'message' => 'Failed to execute the delete query: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Event ID is missing.']);
}

$conn->close();
?>
