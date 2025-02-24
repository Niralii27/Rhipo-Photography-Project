<?php
include('config.php'); // Include your database connection file

if (isset($_POST['holiday_date'])) {
    $holidayDate = $_POST['holiday_date'];

    // SQL query to delete the holiday based on the given date
    $sql = "DELETE FROM holidays WHERE holiday_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $holidayDate); // Bind the date to the query
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'success'; // Return success if holiday is deleted
    } else {
        echo 'error'; // Return error if no holiday is found or deletion failed
    }

    $stmt->close();
} else {
    echo 'error';
}

$conn->close();
?>
