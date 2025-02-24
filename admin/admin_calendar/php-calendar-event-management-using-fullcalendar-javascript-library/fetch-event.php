<?php
// Database configuration
include('config.php');

// Fetch events
$sql = "SELECT * FROM client_booking";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],  // Include `id`
            'title' => $row['event_name'],  // Event title
            'start' => $row['date']         // Event date (start date)
        ];
    }
}

// Return events as JSON
echo json_encode($events);

$conn->close();
?>
