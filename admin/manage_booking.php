<?php
    include('sidebar.php');
    include('header.php');
	include('config.php');
    $results_per_page = 10;
    $search_query = "";
    
    // Check if the search form is submitted
    if (isset($_GET['search'])) {
        $search_query = trim($_GET['search']);
    }
    
    // Find the total number of results based on the search query
    $sql = "SELECT COUNT(id) AS total FROM client_booking";
    if (!empty($search_query)) {
        $sql .= " WHERE user_name LIKE '%$search_query%' 
        OR event_name LIKE '%$search_query%' 
        OR address LIKE '%$search_query%' 
        OR date LIKE '%$search_query%'";
        }
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_results = $row['total'];
    
    // Calculate the total number of pages
    $total_pages = ceil($total_results / $results_per_page);
    
    // Get the current page number from the URL, default to 1 if not set
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    
    // Calculate the starting limit for the results
    $start_limit = ($page - 1) * $results_per_page;
    
    // Fetch the data with pagination and optional search
    $sql = "SELECT * FROM client_booking";
    if (!empty($search_query)) {
        $sql .= " WHERE user_name LIKE '%$search_query%' 
        OR event_name LIKE '%$search_query%' 
        OR address LIKE '%$search_query%' 
        OR date LIKE '%$search_query%'";
        }
    $sql .= " ORDER BY id DESC LIMIT $start_limit, $results_per_page";
    $result = $conn->query($sql);
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
	
<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Manage Client Booking</h4>
						
                        <div class="card">
    <div class="card-header">
        <div class="card-title d-flex align-items-center gap-2">
            <button class="btn btn-primary" style="margin-right:10px;" onclick="window.location.href='calc.php'">MANAGE CALENDAR</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showCalendarModal">SHOW MY CALENDAR</button>
        </div>
    </div>
</div>
<br>
                                        <form method="GET" class="form-inline mb-3">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>" />
                        <button type="submit" class="btn btn-primary me-2" style="margin-right: 10px;">Search</button>
                        <a href="manage_booking.php" class="btn btn-secondary">Clear</a>
                    </form>

									</div>
									<div class="card-body">

										<div class="table-responsive">
											<table class="table table-bordered table table-striped mt-3">
												<thead>
													<tr>
														<th>Id</th>
														<th>Name</th>
														<th>Event Name</th>
														<th>Date</th>
														<th>Time</th>
                                                        <th>Address</th>
														<th>Created At</th>
													</tr>
												</thead>
												<tbody>
												<?php
                                if ($result->num_rows > 0) {
                                    // Loop through each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
										echo "<td>" . $row['user_name'] . "</td>";
                                        echo "<td>" . $row['event_name'] . "</td>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        echo "<td>" . $row['time'] . "</td>";
                                        echo "<td>" . $row['address'] . "</td>";
                                        echo "<td>" . $row['created_at'] . "</td>";
									
									echo "<td>
										<button class='btn btn-warning btn-sm' title='Update' 
										data-bs-toggle='modal' 
										data-bs-target='#updateBlogModal' 
										data-id='" . $row['id'] . "' onclick='loadUpdatePage(" . $row['id'] . ")'>
										<i class='la la-edit'></i>
										</button>
										</td>";
									echo "<td>
										<form method='POST' action='delete_client_booking.php' onsubmit='return confirmDelete()'>
											<input type='hidden' name='id' value='" . $row['id'] . "' />
											<button type='submit' class='btn btn-danger btn-sm' title='Delete'>
												<i class='la la-trash'></i>	
											</button>
										</form>
									</td>";


								echo "</tr>";                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No Client Booking found</td></tr>";
                                }
                                ?>
												</tbody>
											</table>
                                            <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=1&search=<?php echo urlencode($search_query); ?>" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search_query); ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search_query); ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search_query); ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search_query); ?>" aria-label="Last">
                                        <span aria-hidden="true">&raquo;&raquo;</span>
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

		<!-- Modal HTML -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBlogModalLabel">Add Client Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                    <i class="la la-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Embed add_blog.php page in an iframe -->
                <iframe src="calc.php" width="100%" height="800" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Update Blog Modal -->
<div class="modal fade" id="updateBlogModal" tabindex="-1" aria-labelledby="updateBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBlogModalLabel">Update Client Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
					<i class="la la-close"></i>
				</button>
            </div>
            <div class="modal-body">
                <!-- Embed update_blog.php page in an iframe -->
                <iframe id="updateBlogIframe" src="" width="100%" height="800" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Show Calendar Modal -->
<div class="modal fade" id="showCalendarModal" tabindex="-1" aria-labelledby="showCalendarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showCalendarModalLabel">My Calendar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor:pointer">
        <i class="la la-close"></i>

        </button>
      </div>
      <div class="modal-body">
        <!-- Embed the show_calendar.php page in an iframe -->
        <iframe src="show_calendar.php" width="100%" height="500" style="border: none;"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Manage Client Booking Calendar Modal -->
<div class="modal fade" id="addManageBookingModal" tabindex="-1" aria-labelledby="addManageBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addManageBookingModalLabel">Manage Client Booking Calendar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor:pointer">                 
               <i class="la la-close"></i>
        </button>
      </div>
      <div class="modal-body" style="height: 600px;">
        <!-- Add your manage booking content here -->
        <iframe src="add_manage_booking.php" width="100%" height="100%" style="border:none;"></iframe>
      </div>
    </div>
  </div>
</div>


<script>
    // Listen for the form submission inside the iframe
	document.getElementById('addBlogModal').addEventListener('hidden.bs.modal', function () {
    // Redirect the user to blog.php after the modal is hidden
    window.location.href = 'manage_booking.php';  // Adjust the URL as needed
});

// Listen for messages from the iframe (parent page)
window.addEventListener('message', function(event) {
    // Only process messages from the iframe containing the blog submission form
    if (event.origin !== window.location.origin) {
        return; // Ignore messages from unknown sources
    }

    const message = event.data;

    if (message.action === 'success') {
        // Show the alert for success
        alert("New Client Booking Entry created successfully!");

        // Close the modal after the alert
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBlogModal'));
        modal.hide();

        // After closing the modal, redirect to blog.php
        window.location.href = 'manage_booking.php';  // Adjust the URL as needed
    } else if (message.action === 'error') {
        // Handle error message
        alert("Error: " + message.message);
    }
});

function loadUpdatePage(id) {
        const iframe = document.getElementById('updateBlogIframe');
        iframe.src = `update_manage_booking.php?id=${id}`;
    }

    // Reload the blog list when the update modal is closed
    document.getElementById('updateBlogModal').addEventListener('hidden.bs.modal', function () {
        window.location.href = 'manage_booking.php'; // Reload to see updates
    });

	window.addEventListener('message', function(event) {
        if (event.data.action === 'closeModal') {
            // Close the modal (e.g., Bootstrap)
            $('#updateBlogModal').modal('hide'); // Replace #yourModalId with your modal's ID
        }
    });


	function confirmDelete() {
    return confirm("Are you sure you want to delete this Client Booking?");
}


</script>


</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
</html>