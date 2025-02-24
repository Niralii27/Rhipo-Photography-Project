<?php
    include('sidebar.php');
    include('header.php');

	include('config.php');


    // Pagination settings
	$limit = 10; // Number of records per page
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$offset = ($page - 1) * $limit;
	
	// Search handling
	$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
	
	// Fetch data based on search or fetch all data with pagination
	if (!empty($search)) {
		$sql = "SELECT * FROM blog_comment 
				WHERE first_name LIKE '%$search%' 
				   OR last_name LIKE '%$search%' 
				   OR email LIKE '%$search%' 
				   OR comment LIKE '%$search%' 
				   OR blog_title LIKE '%$search%' 
				LIMIT $limit OFFSET $offset";
		$total_sql = "SELECT COUNT(*) as total FROM blog_comment 
					  WHERE first_name LIKE '%$search%' 
						 OR last_name LIKE '%$search%' 
						 OR email LIKE '%$search%' 
						 OR comment LIKE '%$search%' 
						 OR blog_title LIKE '%$search%'";
	} else {
		$sql = "SELECT * FROM blog_comment LIMIT $limit OFFSET $offset";
		$total_sql = "SELECT COUNT(*) as total FROM blog_comment";
	}
	
	$result = mysqli_query($conn, $sql);
	$total_result = mysqli_query($conn, $total_sql);
	$total_row = mysqli_fetch_assoc($total_result);
	$total_records = $total_row['total'];
	$total_pages = ceil($total_records / $limit);

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
	<!-- Bootstrap CSS -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/demo.css">
</head>
<body>
	
			
<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Blog Comments</h4>
						
								
								<div class="card">
									<div class="card-header">
										<div class="card-title">Blog Comments Data</div>
									</div><br>
									<form method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>"style="max-width: 300px;">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <?php if (!empty($search)): ?>
                                <a href="blog_comment.php" class="btn btn-secondary">Clear Search</a>
                            <?php endif; ?>
                        </div>
                    </form>
									<div class="card-body">
										
										<div class="table-responsive">
											<table class="table table-bordered table table-striped mt-3">
												<thead>
													<tr>
														<th>Id</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Email</th>
														<th>Comment</th>
														<th>Blog Title</th>
														<th>Created At</th>
													</tr>
												</thead>
												<tbody>
												<?php
                    // Loop through each row in the result set
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row['id'] . '</th>';
                        echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['comment']) . '</td>';
						echo '<td>' . htmlspecialchars($row['blog_title']) . '</td>';
						echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                       

						 echo '<td>';
						 echo "<td>
						 <form method='POST' action='delete_blog_comment.php' onsubmit='return confirmDelete()'>
							 <input type='hidden' name='id' value='" . $row['id'] . "' />
							 <button type='submit' class='btn btn-danger btn-sm' title='Delete'>
								 <i class='la la-trash'></i>	
							 </button>
						 </form>
					 </td>";
echo '</td>';

                        echo '</tr>';
                    }
                    ?>
												</tbody>
											</table>
										</div>
										<div class="pagination">
                        <ul class="pagination justify-content-center">
                            <?php
                            if ($page > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '">&laquo; Previous</a></li>';
                            }
                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
                            }
                            if ($page < $total_pages) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '">Next &raquo;</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
									</div>
								</div>
							</div>
														</div>
					</div>
				</div>





<script>
	function confirmDelete() {
    return confirm("Are you sure you want to delete this Blog Comment?");
}

	</script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script src="assets/js/core/jquery.3.2.1.min.js"></script>
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
<script>
	$( function() {
		$( "#slider" ).slider({
			range: "min",
			max: 100,
			value: 40,
		});
		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 500,
			values: [ 75, 300 ]
		});
	} );
</script>
</html>