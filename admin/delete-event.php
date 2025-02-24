<?php

include('config.php'); // Include your database connection file

if (isset($_POST['id'])) {
    $eventId = $_POST['id'];

    // SQL query to delete the event by ID
    $sql = "DELETE FROM client_booking WHERE id = ?";
    
    // Prepare and bind the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $eventId); // "i" indicates integer type
        if ($stmt->execute()) {
            echo 'success'; // Return success response
        } else {
            echo 'Failed to delete the event.';
        }
        $stmt->close();
    } else {
        echo 'Error in preparing the SQL query.';
    }
} else {
    echo 'No event ID provided.';
}

$conn->close(); // Close the database connection
?>
