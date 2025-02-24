<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $time_zone = mysqli_real_escape_string($conn, $_POST['time_zone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Insert data into the database
    $sql = "INSERT INTO client_booking (user_name, event_name, date, time, time_zone, address, created_at) 
            VALUES ('$user_name', '$event_name', '$date', '$time', '$time_zone', '$address', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Success message returned to JavaScript
        echo "<script>window.parent.postMessage({action: 'success'}, '*');</script>";
    } else {
        // Error message returned to JavaScript
        echo "<script>window.parent.postMessage({action: 'error', message: '" . $conn->error . "'}, '*');</script>";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Rhipo Admin</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<link rel="stylesheet" href="assets/css/demo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Load jQuery -->
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
<div class="content">
					<div class="container-fluid" style="width:200%;">
						<div class="row">
							<div class="col-md-6">
								<div class="card">
                                <form id="portfolioform" method="POST" action="add_client_booking.php" enctype="multipart/form-data">
  <div class="card-body">
    <div class="form-group">
      <label for="text">Client Name</label>
      <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Name Of Client" required>
    </div>
    <div class="form-group">
      <label for="text">Event Name</label>
      <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Enter Event Name" required>
    </div>
    <div class="form-group">
      <label for="text">Date</label>
      <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="form-group">
      <label for="text">Time</label>
      <input type="time" class="form-control" id="time" name="time" required>
    </div>
    <div class="form-group">
  <label for="time_zone">Time Zone</label>
  <select class="form-control" id="time_zone" name="time_zone" required>
    <option value="">Select Time Zone</option>
    <option value="PST">Pacific Standard Time(PST)</option>
    <option value="IST">Indian Standard Time(IST)</option>
  </select>
</div>

    <div class="form-group">
      <label for="text">Address</label>
      <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required>
    </div>
  </div>
  <div class="card-action">
    <button type="submit" class="btn btn-success">Submit</button>
    <button type="reset" class="btn btn-danger">Cancel</button>
  </div>
</form>


					</div>
				</div>
            </div>
		</div>
</div>


<script>
  $(document).ready(function () {
  $('#portfolioform').validate({
    rules: {
      user_name: {
        required: true,
        pattern: /^[A-Za-z\s]+$/,
      },
      address: {
        required: true,
        pattern: /^[A-Za-z\s]+$/,
      },
     
    },
    messages: {
      user_name: {
        required: "Please enter a valid user_name with only letters.",
        pattern: "user_name should only contain letters.",
      },
      address: {
        required: "Please enter a valid address with only letters.",
        pattern: "address should only contain letters.",
      },
     
    },
    errorPlacement: function (error, element) {
      error.insertAfter(element);
    },
    highlight: function (element) {
      $(element).addClass('error');
    },
    unhighlight: function (element) {
      $(element).removeClass('error');
    },
  });
});


  
</script>
</body>


<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chartist/chartist.min.js"></script>
<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
</html>