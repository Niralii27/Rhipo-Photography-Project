<?php

if (isset($_POST['action']) && $_POST['action'] == 'insert_event') {
    include('config.php');

    // Sanitize and prepare form data
    $user_name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $event_name = $conn->real_escape_string($_POST['title']);
    $date = $conn->real_escape_string($_POST['start_date']);
    $time = $conn->real_escape_string($_POST['start_time']);
    $time_zone = $conn->real_escape_string($_POST['timezone']);
    $address = $conn->real_escape_string($_POST['address']);
    $created_at = date('Y-m-d H:i:s'); // Automatically set the current timestamp for the created_at field

    // Log the received data for debugging
    error_log("Received data: user_name=$user_name, email=$email, event_name=$event_name, date=$date, time=$time, time_zone=$time_zone, address=$address");

    // Insert event into client_booking table
    $sql = "INSERT INTO client_booking (user_name, email, event_name, date, time, time_zone, address, created_at) 
            VALUES ('$user_name', '$email', '$event_name', '$date', '$time', '$time_zone', '$address', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "New event added successfully";
    } else {
        // Log the error if the insert fails
        error_log("SQL Error: " . $conn->error);
        echo "Error: " . $conn->error;
    }

    $conn->close();
    exit();
}
?>
