<?php
// Include your database connection file
include('config.php');

// Fetch the current month and year if not set by the user
$currentMonth = date('m');
$currentYear = date('Y');

// Check if form is submitted and get selected month and year
if (isset($_POST['month']) && isset($_POST['year'])) {
    $selectedMonth = $_POST['month'];
    $selectedYear = $_POST['year'];
} else {
    $selectedMonth = $currentMonth;
    $selectedYear = $currentYear;
}

// Query to fetch data based on selected month and year
$sql = "SELECT * FROM client_booking WHERE MONTH(date) = ? AND YEAR(date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $selectedMonth, $selectedYear); // Bind month and year parameters
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/core/jquery.3.2.1.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h4 class="text-center">Booking Calendar</h4>

    <!-- Form to select month and year -->
    <form method="POST" action="show_calendar.php" class="mb-4">
        <div class="form-row">
            <div class="col">
                <label for="month">Select Month</label>
                <select class="form-control" id="month" name="month">
                    <?php
                    // Create month dropdown options
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = ($i == $selectedMonth) ? "selected" : "";
                        echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="year">Select Year</label>
                <select class="form-control" id="year" name="year">
                    <?php
                    // Create year dropdown options for the last 5 years and next 5 years
                    for ($i = 2020; $i <= 2030; $i++) {
                        $selected = ($i == $selectedYear) ? "selected" : "";
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Show Data</button>
    </form>

    <!-- Table to display booking data -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Time Zone</th>
                    <th>Booking Date</th>
                    <th>Booking Time</th>
                    <th>Event Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if data exists
                if ($result->num_rows > 0) {
                    // Output the data in a table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['time_zone'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['time'] . "</td>";
                        echo "<td>" . $row['event_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No bookings found for the selected month and year.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
