<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM client_booking WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Booking not found!");
    }
    $stmt->close();
} else {
    die("Invalid request!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $user_name = htmlspecialchars(trim($_POST['user_name']), ENT_QUOTES, 'UTF-8');
    $event_name = htmlspecialchars(trim($_POST['event_name']), ENT_QUOTES, 'UTF-8');
    $date = htmlspecialchars(trim($_POST['date']), ENT_QUOTES, 'UTF-8');
    $time = htmlspecialchars(trim($_POST['time']), ENT_QUOTES, 'UTF-8');
    $time_zone = htmlspecialchars(trim($_POST['time_zone']), ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8');

    // Update query
    $sql = "UPDATE client_booking SET 
                user_name = ?, 
                event_name = ?, 
                date = ?, 
                time = ?, 
                time_zone = ?, 
                address = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $user_name, $event_name, $date, $time, $time_zone, $address, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Client Booking updated successfully!');</script>";
        echo "<script>window.location.href = 'update_manage_booking.php?id=$id';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Booking</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</head>
<style>
    .error {
        color: red;
        font-size: 0.875em;
        margin-top: 0.25em;
    }
</style>
<body>
<div class="container">
    <h2>Update Booking</h2>
    <form id="bookingForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="user_name">Client Name</label>
            <input type="text" class="form-control" id="user_name" name="user_name" 
                   value="<?php echo htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="event_name">Event Name</label>
            <input type="text" class="form-control" id="event_name" name="event_name" 
                   value="<?php echo htmlspecialchars($row['event_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" 
                   value="<?php echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" class="form-control" id="time" name="time" 
                   value="<?php echo htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="time_zone">Time Zone</label>
            <select class="form-control" id="time_zone" name="time_zone" required>
                <option value="">Select Time Zone</option>
                <option value="PST" <?php echo $row['time_zone'] === 'PST' ? 'selected' : ''; ?>>PST</option>
                <option value="IST" <?php echo $row['time_zone'] === 'IST' ? 'selected' : ''; ?>>IST</option>
            </select>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>


        <div class="form-group">
            <button class="btn btn-success">Update</button>
            <a href="javascript:void(0);" class="btn btn-danger" onclick="closeParentModal()">Cancel</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#bookingForm').validate({
            rules: {
                user_name: { required: true },
                event_name: { required: true },
                date: { required: true },
                time: { required: true },
                time_zone: { required: true },
                address: { required: true }
            },
            messages: {
                user_name: { required: "Please enter the client name" },
                event_name: { required: "Please enter the event name" },
                date: { required: "Please select a date" },
                time: { required: "Please select a time" },
                time_zone: { required: "Please select a time zone" },
                address: { required: "Please enter the address" }
            }
        });
    });

    function closeParentModal() {
        window.parent.postMessage({ action: 'closeModal' }, '*');
    }
</script>
</body>
</html>
