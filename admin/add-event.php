<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $time_zone = $_POST['time_zone'];
    $address = $_POST['address'];
    $date = $_POST['date']; // Ensure this is in YYYY-MM-DD format
    $time = $_POST['time']; // Ensure this is in hh:mm AM/PM format (time in 12-hour format)

    // Fetch the 'hours' for the selected event_name
    $hours_sql = "SELECT hours FROM booking WHERE title = ?";
    $hours_stmt = $conn->prepare($hours_sql);
    $hours_stmt->bind_param("s", $event_name);
    $hours_stmt->execute();
    $hours_result = $hours_stmt->get_result();
    $hours_row = $hours_result->fetch_assoc();

    if (!$hours_row) {
        echo "Invalid event name.";
        exit;
    }

    $hours = $hours_row['hours'];
    $created_at = date('Y-m-d H:i:s'); // Current timestamp in MySQL compatible format

    // First, check if this time slot is already booked
    $check_sql = "SELECT COUNT(*) as count FROM client_booking WHERE date = ? AND time = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $date, $time);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo "This time slot is already booked. Please choose another time.";
        exit;
    }

    // If the time slot is available, proceed with booking
    $sql = "INSERT INTO client_booking (event_name, user_name, email, time_zone, address, date, time, hours, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssis", $event_name, $user_name, $email, $time_zone, $address, $date, $time, $hours, $created_at);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $hours_stmt->close();
    $check_stmt->close();
}

$conn->close();
?>
