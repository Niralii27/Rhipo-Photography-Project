<?php
session_start();

include('config.php');

if (!isset($_SESSION['name']) || $_SESSION['name'] === 'Guest') {
    // Stop rendering the page and display a blank screen
	header("Location: ../index.php");

    exit;
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
<div class="wrapper">
		<div class="main-header"> 
			<div class="logo-header">
				<a href="index.php" class="logo">
					Admin Dashboard
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg">
				<div class="container-fluid">
					
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						
					
						<li class="nav-item dropdown">
						<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
    <img src="uploads/about_intro.png" alt="user-img" width="36" class="img-circle">
    <span>
        <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest'; ?>
    </span>
</a>


							<ul class="dropdown-menu dropdown-user">
								<li>
									<div class="user-box">
										<div class="u-img"><img src="uploads/about_intro.png" alt="user"></div>
										<div class="u-text">
											<h4><?php echo ($_SESSION['name']);?></h4>
											<p class="text-muted"><?php echo ($_SESSION['email']);?></p><a href="../logout.php" class="btn btn-rounded btn-danger btn-sm">Logout</a></div>
										</div>
									</li>
									
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</div>
</body>
</html>