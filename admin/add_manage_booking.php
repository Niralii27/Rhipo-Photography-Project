<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['time_zone'], $_POST['calendar_date'], $_POST['time'], $_POST['booking_status'])) {
        $timeZone = $_POST['time_zone'];
        $calendarDate = $_POST['calendar_date'];
        $time = $_POST['time'];
        $bookingStatus = $_POST['booking_status'];
        $additionalDetails = isset($_POST['additional_details']) ? $_POST['additional_details'] : null;

        // SQL query with NOW() for created_at
        $sql = "INSERT INTO booking_calendar (time_zone, booking_date, booking_time, status, reason, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Prepare failed: " . $conn->error;
            exit;
        }

        $stmt->bind_param("sssss", $timeZone, $calendarDate, $time, $bookingStatus, $additionalDetails);

        if ($stmt->execute()) {
            echo "Booking successfully added!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid form submission!";
    }

    $conn->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Booking Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            box-sizing: border-box;
            transition: all 0.3s ease-in-out;
        }
        .form-group input:focus {
            background-color: #fff;
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
        }
        #additional-info {
            margin-top: 10px;
            display: none;
        }
        .btn {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Booking Form</div>
        <form id="booking-form">
            <!-- Time Zone Selection -->
            <div class="form-group">
                <label for="time-zone">Select Time Zone:</label>
                <select id="time-zone" name="time_zone" onchange="updateTimeZone()">
                    <option value="IST">India Standard Time (IST)</option>
                    <option value="PST">Pacific Standard Time (PST)</option>
                </select>
            </div>

            <!-- Date Selection -->
            <div class="form-group">
                <label for="calendar">Select Date:</label>
                <input type="text" id="calendar" name="calendar_date" placeholder="Select a date" />
            </div>

            <!-- Time Selection -->
            <div class="form-group">
                <label for="time">Select Time:</label>
                <input type="text" id="time" name="time" placeholder="Select a time" />
            </div>

            <!-- Booking Status -->
            <div class="form-group">
                <label for="booking-status">Booking Status:</label>
                <select id="booking-status" name="booking_status" onchange="toggleAdditionalInfo()">
                    <option value="available">Available</option>
                    <option value="not-available">Not Available</option>
                </select>
            </div>

            <!-- Additional Information -->
            <div class="form-group" id="additional-info">
                <label for="additional-details">Reason for Unavailability:</label>
                <input type="text" id="additional-details" name="additional_details" placeholder="Enter reason for unavailability" />
            </div>

            <button type="submit" class="btn">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize Flatpickr for Date
        const calendarPicker = flatpickr("#calendar", {
            minDate: "today",
            dateFormat: "Y-m-d", // Database-compatible format
        });

        // Initialize Flatpickr for Time
        const timePicker = flatpickr("#time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K", // AM/PM format
            time_24hr: false, // Ensure 12-hour format
        });

        // Update the timezone offset
        function updateTimeZone() {
            const timeZone = document.getElementById('time-zone').value;
            alert(`Timezone updated to ${timeZone}.`);
        }

        // Toggle visibility of the additional info input
        function toggleAdditionalInfo() {
            const bookingStatus = document.getElementById('booking-status').value;
            const additionalInfo = document.getElementById('additional-info');
            additionalInfo.style.display = bookingStatus === "not-available" ? "block" : "none";
        }

        // Handle form submission via AJAX
        document.getElementById('booking-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent page refresh

    const formData = new FormData(this);

    fetch('add_manage_booking.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        alert(data.trim()); // Show success or error message
        if (data.trim() === "Booking successfully added!") {
            location.reload(); // Refresh the form after successful submission
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the form.');
    });
});

    </script>
</body>
</html>
