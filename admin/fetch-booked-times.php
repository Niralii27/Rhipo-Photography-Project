<?php
include('config.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_date = $_POST['selected_date']; // Client se aayi date
    
    // Fetch events for the given date
    $query = "SELECT * FROM client_booking WHERE date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $selected_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedTimes = [];
    while ($row = $result->fetch_assoc()) {
        $bookedTimes[] = [
            'start_time' => $row['time'],       // Event start time
            'duration' => $row['hours']         // Event duration (hours)
        ];
    }

    echo json_encode($bookedTimes); // Send data as JSON to frontend
}
?>
