<?php
include('config.php');
session_start();
$userName = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';


// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract data from the JSON input
    $userName = $data['user_name'] ?? $userName;  // अगर JSON डेटा में नाम नहीं है तो सत्र से यूज़र नाम लेंगे
    $eventName = $data['event_name'] ?? '';
    $date = $data['date'] ?? '';
    $time = $data['time'] ?? '';
    $timeZone = $data['time_zone'] ?? '';
    $address = $data['address'] ?? '';

    // Sanitize inputs
    $userName = $conn->real_escape_string($userName);
    $eventName = $conn->real_escape_string($eventName);
    $date = $conn->real_escape_string($date);
    $time = $conn->real_escape_string($time);
    $timeZone = $conn->real_escape_string($timeZone);
    $address = $conn->real_escape_string($address);

    // Insert into the client_booking table
    $sql = "INSERT INTO client_booking (user_name, event_name, date, time, time_zone, address, created_at)
            VALUES ('$userName', '$eventName', '$date', '$time', '$timeZone', '$address', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Your Booking successfully created!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $conn->close();
}
?>
