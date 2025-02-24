<?php
    include('sidebar.php');
    include('header.php');
	include('config.php');

	$sql = "SELECT COUNT(*) as total_ids FROM registration";
$result = $conn->query($sql);

// Fetch result
$total_ids = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_ids = $row['total_ids'];
}

$sql = "SELECT COUNT(*) as total_blogs FROM blog";
$result = $conn->query($sql);

// Fetch result
$total_blogs = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_blogs = $row['total_blogs'];
}
	
$sql = "SELECT COUNT(*) as total_booking FROM client_booking";
$result = $conn->query($sql);

// Fetch result
$total_booking = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_booking = $row['total_booking'];
}

$sql = "SELECT COUNT(*) as total_portfolio FROM admin_portfolio";
$result = $conn->query($sql);

// Fetch result
$total_portfolio = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_portfolio = $row['total_portfolio'];
}

$sql = "SELECT COUNT(*) as total_contact FROM contact";
$result = $conn->query($sql);

// Fetch result
$total_contact = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_contact = $row['total_contact'];
}

$sql = "SELECT COUNT(*) as total_comment FROM blog_comment";
$result = $conn->query($sql);

// Fetch result
$total_comment = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_comment = $row['total_comment'];
}

$sql = "SELECT COUNT(*) as total_review FROM review";
$result = $conn->query($sql);

// Fetch result
$total_review = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_review = $row['total_review'];
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
</head>
<body>
	
			
			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Dashboard</h4>
						<div class="row">
							<div class="col-md-3">
								<div class="card card-stats card-warning">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-users"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Users</p>
													<h4 class="card-title"><?php echo $total_ids; ?></h4>
													</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats card-success">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-pencil-square-o"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Blogs</p>
													<h4 class="card-title"><?php echo $total_blogs; ?></h4>
													</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats card-danger">
									<div class="card-body">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-calendar-check-o"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Booking</p>
													<h4 class="card-title"><?php echo $total_booking; ?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-briefcase"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Portfolio</p>
													<h4 class="card-title"><?php echo $total_portfolio; ?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats card-warning">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-tty"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Contacts</p>
													<h4 class="card-title"><?php echo $total_contact; ?></h4>
													</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats card-success">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-comments"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Blogs Comment</p>
													<h4 class="card-title"><?php echo $total_comment; ?></h4>
													</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats card-danger">
									<div class="card-body">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-newspaper-o"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Review</p>
													<h4 class="card-title"><?php echo $total_review; ?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						
</body>
<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chartist/chartist.min.js"></script>
<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
<script src="assets/js/demo.js"></script>
</html>