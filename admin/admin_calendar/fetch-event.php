<?php

include('config.php'); // Ensure this connects to your database

header('Content-Type: application/json'); // Return JSON response

// Fetch events from the client_booking table
$sql = "SELECT id, event_name AS title, date AS start FROM client_booking"; // Adjust table/field names as needed
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['start'],
            'type' => 'event', // Mark this as an event
        ];
    }
}

// Fetch holidays from the holidays table
$holidaySql = "SELECT holiday_date AS start FROM holidays"; // Adjust table/field names as needed
$holidayResult = $conn->query($holidaySql);

$holidays = [];

if ($holidayResult->num_rows > 0) {
    while ($row = $holidayResult->fetch_assoc()) {
        $holidays[] = [
            'start' => $row['start'],
            'title' => 'Holiday', // Label holidays as 'Holiday'
            'type' => 'holiday', // Mark this as a holiday
            'backgroundColor' => '#FF0000', // Optional: Highlight holidays in red
            'editable' => false, // Disable interaction with holiday events
        ];
    }
}

// Merge events and holidays into a single array
$allEvents = array_merge($events, $holidays);

echo json_encode($allEvents); // Return the events and holidays as JSON

$conn->close();

?>
