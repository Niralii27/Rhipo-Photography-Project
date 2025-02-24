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
<div class="sidebar">
				<div class="scrollbar-inner sidebar-wrapper">
					<div class="user">
						
						<div class="info">
							
							<div class="clearfix"></div>

							
						</div>
					</div>
					<ul class="nav">
					<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
					<a href="index.php">
								<i class="la la-dashboard"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'user.php') ? 'active' : ''; ?>">
						<a href="user.php">
								<i class="la la-user"></i>
								<p>Users</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'blog.php') ? 'active' : ''; ?>">
						<a href="blog.php">
								<i class="la la-pencil-square-o"></i>
								<p>Blogs</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'admin_portfolio.php') ? 'active' : ''; ?>">
						<a href="admin_portfolio.php">
								<i class="la la-briefcase"></i>
								<p>Admin Portfolio</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'client_portfolio.php') ? 'active' : ''; ?>">
						<a href="client_portfolio.php">
								<i class="la la-clipboard"></i>
								<p>Client Portfolio</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'review.php') ? 'active' : ''; ?>">
						<a href="review.php">
								<i class="la la-comment"></i>
								<p>Review</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>">
						<a href="contact.php">
								<i class="la la-tty"></i>
								<p>Contact</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'booking.php') ? 'active' : ''; ?>">
						<a href="booking.php">
								<i class="la la-calendar-check-o"></i>
								<p>Booking</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_booking.php') ? 'active' : ''; ?>">
						<a href="manage_booking.php">
								<i class="la la-calendar"></i>
								<p>Manage Booking</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'blog_comment.php') ? 'active' : ''; ?>">
						<a href="blog_comment.php">
								<i class="la la-comments"></i>
								<p>Blog Comment</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'exclusive_clips.php') ? 'active' : ''; ?>">
						<a href="exclusive_clips.php">
								<i class="la la-camera"></i>
								<p>Exclusive Clips</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'exclusive_clips_reel.php') ? 'active' : ''; ?>">
						<a href="exclusive_clips_reel.php">
								<i class="la la-video-camera"></i>
								<p>Exclusive Clips Reels</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'preferred_vendor.php') ? 'active' : ''; ?>">
						<a href="preferred_vendor.php">
								<i class="la la-male"></i>
								<p>Preferred Vendor</p>
							</a>
						</li>
						<li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'advertise.php') ? 'active' : ''; ?>">
						<a href="advertise.php">
								<i class="la la-newspaper-o"></i>
								<p>Advertise</p>
							</a>
						</li>
						
						<li class="nav-item update-pro">
    <a href="../logout.php">
        <button>
            <i class="la la-power-off"></i>
            <p>Logout</p>
        </button>
    </a>
</li>
					</ul>
				</div>
			</div>
</body>
</html>