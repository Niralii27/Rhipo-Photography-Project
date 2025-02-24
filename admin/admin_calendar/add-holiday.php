<?php
include('config.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $holidayDate = $_POST['holiday_date']; // The holiday date to add

    // Check if the holiday already exists
    $checkSql = "SELECT * FROM holidays WHERE holiday_date = '$holidayDate'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "Holiday already exists!";
    } else {
        // SQL query to insert a new holiday
        $sql = "INSERT INTO holidays (holiday_date) VALUES ('$holidayDate')";

        if ($conn->query($sql) === TRUE) {
            echo "Holiday added successfully!";
        } else {
            echo "Error adding holiday: " . $conn->error;
        }
    }
    $conn->close();
}
?>
