<?php
include('config.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $eventName = $_POST['event_name'];
    $userName = $_POST['user_name'];
    $email = $_POST['email'];
    $timeZone = $_POST['time_zone'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $created_at = date('Y-m-d H:i:s'); // Current date and time in 'YYYY-MM-DD HH:MM:SS' format

    // Insert into the database
    $sql = "INSERT INTO client_booking (event_name, user_name, email, date, time, time_zone, address,created_at)
            VALUES ('$eventName', '$userName', '$email', '$date', '$time', '$timeZone', '$address', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'Error: ' . $conn->error;
    }

    $conn->close();
} else {
    echo 'Invalid request method.';
}
