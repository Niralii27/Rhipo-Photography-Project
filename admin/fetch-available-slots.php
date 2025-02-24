<?php
include('config.php');

if (isset($_POST['selected_date'])) {
    $selectedDate = $_POST['selected_date'];

    // Fetch all booked slots for the selected date
    $sql = "SELECT time, hours FROM booking WHERE date = '$selectedDate'";
    $result = $conn->query($sql);

    $bookedSlots = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $start = strtotime($row['time']);
            $duration = intval($row['hours']);
            for ($i = 0; $i < $duration; $i++) {
                $bookedSlots[] = date('h:i A', strtotime("+$i hours", $start));
            }
        }
    }

    // Define all available time slots
    $allSlots = [
        "08:00 AM", "09:00 AM", "10:00 AM", "11:00 AM", "12:00 PM",
        "01:00 PM", "02:00 PM", "03:00 PM", "04:00 PM", "05:00 PM",
        "06:00 PM", "07:00 PM"
    ];

    // Find available slots
    $availableSlots = array_diff($allSlots, $bookedSlots);

    // Return available slots as JSON
    echo json_encode(array_values($availableSlots));
}

$conn->close();
?>
