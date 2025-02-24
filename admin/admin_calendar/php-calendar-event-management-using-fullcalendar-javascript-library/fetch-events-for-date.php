<?php
if (isset($_GET['date'])) {
    include('config.php'); // Include your database connection

    $selectedDate = $_GET['date'];
    echo "Selected Date: " . $selectedDate;  // Debugging line to check the received date

    // Fetch events for the selected date from the 'client_booking' table
    $sql = "SELECT time FROM client_booking WHERE date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any events were found
    if ($result->num_rows > 0) {
        $events = [];
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }

        // Return events in JSON format
        echo json_encode($events);
    } else {
        echo json_encode([]);  // Return empty array if no events found
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No date parameter provided";  // Debugging if the 'date' parameter is not passed
}
?>
