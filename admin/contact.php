<?php
    include('sidebar.php');
    include('header.php');

	include('config.php');

	$results_per_page = 10;

    // Initialize search variables
    $search_term = '';
    $search_query = '';

    // Check if search form is submitted
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_term = mysqli_real_escape_string($conn, $_GET['search']);
        $search_query = " WHERE name LIKE '%$search_term%' OR email LIKE '%$search_term%' OR phone LIKE '%$search_term%' OR service LIKE '%$search_term%' OR location LIKE '%$search_term%' OR referred LIKE '%$search_term%' OR comment LIKE '%$search_term%'";
    }

    // Fetch users data from the registration table with search query if applicable
    $sql = "SELECT COUNT(id) AS total FROM contact" . $search_query;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_results = $row['total'];

    // Calculate the total number of pages
    $total_pages = ceil($total_results / $results_per_page);

    // Get the current page number from the URL, default to 1 if not set
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    // Calculate the starting limit for the results
    $start_limit = ($page - 1) * $results_per_page;

    // Fetch the users data from the contact table with pagination and search query
    $sql = "SELECT * FROM contact" . $search_query . " LIMIT $start_limit, $results_per_page";
    $result = mysqli_query($conn, $sql);
    $path = "../uploads/";


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
						<h4 class="page-title">Contacts</h4>
						
								
								<div class="card">
									<div class="card-header">
										<div class="card-title">Contacts Data</div>
									</div>
									<form method="GET" action="" class="d-flex mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($search_term); ?>"style="max-width: 300px;">
                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                            <?php if ($search_term) { ?>
                                <a href="contact.php" class="btn btn-secondary ms-2">Clear</a>
                            <?php } ?>
                        </form>
									<div class="card-body">
										
										<div class="table-responsive">
											<table class="table table-bordered table table-striped mt-3">
												<thead>
													<tr>
														<th>Id</th>
														<th>Name</th>
														<th>Email</th>
														<th>Phone</th>
														<th>Service</th>
														<th>Date</th>
														<th>Location</th>
														<th>Referred By</th>
														<th>Comment</th>
														<th>Created At</th>
													</tr>
												</thead>
												<tbody>
												<?php
                    // Loop through each row in the result set
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row['id'] . '</th>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['service']) . '</td>';
						echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['location']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['referred']) . '</td>';
						echo '<td>' . htmlspecialchars($row['comment']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';

						 echo '<td>';
						 echo "<td>
						 <form method='POST' action='delete_contact.php' onsubmit='return confirmDelete()'>
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
											<nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                    <a class="page-link" href="?page=<?php echo $page-1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                    <li class="page-item <?php if($i == $page) { echo 'active'; } ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item <?php if($page >= $total_pages) { echo 'disabled'; } ?>">
                                    <a class="page-link" href="?page=<?php echo $page+1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
										</div>
									</div>
								</div>
							</div>
														</div>
					</div>
				</div>





<script>
	function confirmDelete() {
    return confirm("Are you sure you want to delete this Contact?");
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