<?php
    include('sidebar.php');
    include('header.php');
	include('config.php');

    $results_per_page = 5;

    // Initialize search query and filter
    $search_query = "";
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        $search_query = "WHERE title LIKE '%$search%' OR hours LIKE '%$search%' OR fees LIKE '%$search%'";
    } else {
        $search = "";
    }
    
    // Get total results count for pagination
    $sql = "SELECT COUNT(id) AS total FROM booking $search_query";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_results = $row['total'];
    
    // Calculate total pages
    $total_pages = ceil($total_results / $results_per_page);
    
    // Get the current page number, default to 1
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    
    // Calculate the starting limit for the results
    $start_limit = ($page - 1) * $results_per_page;
    
    // Fetch the bookings with pagination and search filter
    $sql = "SELECT * FROM booking $search_query LIMIT $start_limit, $results_per_page";
    $result = $conn->query($sql);
    
    // Function to highlight the search term in results
    function highlight($text, $word) {
        return preg_replace("/($word)/i", "<span style='background-color:yellow;'>$1</span>", $text);
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
	
<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
						<h4 class="page-title">Booking</h4>
						

						<div class="card">
									<div class="card-header">
										<div class="card-title"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">ADD Booking</button>

										</div><br>
                                        <form method="GET" action="" class="mb-3">
                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control" placeholder="Search by Title, Hours, or Fees" 
                                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"style="max-width: 300px;">
                                                <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Search</button>
                                                <a href="booking.php" class="btn btn-secondary">Clear Search</a>
                                            </div>
                                        </form>

									</div>
									<div class="card-body">

										<div class="table-responsive">
											<table class="table table-bordered table table-striped mt-3">
												<thead>
													<tr>
														<th>Id</th>
														<th>Title</th>
                                                        <th>Description</th>
														<th>Image</th>
                                                        <th>Hours</th>
														<th>Fees</th>
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
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td><img src='../uploads/" . $row['image'] . "' alt='Inner Image1' width='100'></td>";
                                        echo "<td>" . $row['hours'] . "</td>";
										echo "<td>" . $row['fees'] . "</td>";
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
										<form method='POST' action='delete_booking.php' onsubmit='return confirmDelete()'>
											<input type='hidden' name='id' value='" . $row['id'] . "' />
											<button type='submit' class='btn btn-danger btn-sm' title='Delete'>
												<i class='la la-trash'></i>	
											</button>
										</form>
									</td>";


								echo "</tr>";                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No Booking found</td></tr>";
                                }
                                ?>
												</tbody>
											</table>
                                      <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=1&search=<?php echo urlencode($search); ?>">First</a>
                            </li>
                            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                            </li>
                            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>">Last</a>
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
                <h5 class="modal-title" id="addBlogModalLabel">Add Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                    <i class="la la-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Embed add_blog.php page in an iframe -->
                <iframe src="add_booking.php" width="100%" height="800" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Update Blog Modal -->
<div class="modal fade" id="updateBlogModal" tabindex="-1" aria-labelledby="updateBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBlogModalLabel">Update Booking</h5>
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


<script>
    // Listen for the form submission inside the iframe
	document.getElementById('addBlogModal').addEventListener('hidden.bs.modal', function () {
    // Redirect the user to blog.php after the modal is hidden
    window.location.href = 'booking.php';  // Adjust the URL as needed
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
        alert("New Booking Entry created successfully!");

        // Close the modal after the alert
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBlogModal'));
        modal.hide();

        // After closing the modal, redirect to blog.php
        window.location.href = 'booking.php';  // Adjust the URL as needed
    } else if (message.action === 'error') {
        // Handle error message
        alert("Error: " + message.message);
    }
});

function loadUpdatePage(id) {
        const iframe = document.getElementById('updateBlogIframe');
        iframe.src = `update_booking.php?id=${id}`;
    }

    // Reload the blog list when the update modal is closed
    document.getElementById('updateBlogModal').addEventListener('hidden.bs.modal', function () {
        window.location.href = 'booking.php'; // Reload to see updates
    });

	window.addEventListener('message', function(event) {
        if (event.data.action === 'closeModal') {
            // Close the modal (e.g., Bootstrap)
            $('#updateBlogModal').modal('hide'); // Replace #yourModalId with your modal's ID
        }
    });


	function confirmDelete() {
    return confirm("Are you sure you want to delete this Booking?");
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