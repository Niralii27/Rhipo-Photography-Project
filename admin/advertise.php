<?php
    include('sidebar.php');
    include('header.php');
	include('config.php');

    $limit = 5; // Number of records per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page, default to 1
    $start_from = ($page - 1) * $limit; // Calculate offset

    // Handle search query
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search_query = $search ? " WHERE image LIKE '%$search%' OR status LIKE '%$search%'" : '';

    // Get total number of records for pagination
    $sql_total = "SELECT COUNT(*) FROM advertise $search_query";
    $result_total = $conn->query($sql_total);
    $row_total = $result_total->fetch_row();
    $total_records = $row_total[0];
    $total_pages = ceil($total_records / $limit); // Calculate total pages

    // SQL query to get records for the current page
    $sql = "SELECT * FROM advertise $search_query LIMIT $start_from, $limit";
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
						<h4 class="page-title">Advertise</h4>
						

						<div class="card">
									<div class="card-header">
										<div class="card-title"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">ADD ADVERTISE</button>

										</div><br>
                                        <form method="GET" action="advertise.php" class="d-flex">
							<input type="text" name="search" class="form-control me-2" placeholder="Search by Image or Status" value="<?php echo htmlspecialchars($search); ?>"style="max-width: 300px;">
							<button type="submit" class="btn btn-primary"style="margin-right:10px;">Search</button>
							<a href="advertise.php" class="btn btn-secondary ms-2">Clear</a>
						</form>
									</div>
									<div class="card-body">

										<div class="table-responsive">
											<table class="table table-bordered table table-striped mt-3">
												<thead>
													<tr>
														<th>Id</th>								
														<th>Image</th>
                                                        <th>Status</th>
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
                                        echo "<td><img src='../uploads/" . $row['image'] . "' alt='Inner Image1' width='100'></td>";
                                        echo "<td>" . $row['status'] . "</td>";										
                                        echo "<td>" . $row['created_at'] . "</td>";
                                        echo "<td>
                                        <input type='checkbox'" . ($row['status'] == 'active' ? 'checked' : '') . "
                                               data-toggle='toggle' data-onstyle='primary' data-style='btn-round'
                                               data-bs-toggle='modal' data-bs-target='#toggleStatusModal'
                                               data-id='" . $row['id'] . "' data-status='" . $row['status'] . "'></td>";

									echo "<td>
										<button class='btn btn-warning btn-sm' title='Update' 
										data-bs-toggle='modal' 
										data-bs-target='#updateBlogModal' 
										data-id='" . $row['id'] . "' onclick='loadUpdatePage(" . $row['id'] . ")'>
										<i class='la la-edit'></i>
										</button>
										</td>";
									echo "<td>
										<form method='POST' action='delete_advertise.php' onsubmit='return confirmDelete()'>
											<input type='hidden' name='id' value='" . $row['id'] . "' />
											<button type='submit' class='btn btn-danger btn-sm' title='Delete'>
												<i class='la la-trash'></i>	
											</button>
										</form>
									</td>";


								echo "</tr>";                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No Advertise found</td></tr>";
                                }
                                ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
                                <div class="pagination">
				<ul class="pagination justify-content-center">
					<?php if ($page > 1): ?>
						<li class="page-item"><a class="page-link" href="advertise.php?page=1&search=<?php echo $search; ?>">First</a></li>
						<li class="page-item"><a class="page-link" href="advertise.php?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">Previous</a></li>
					<?php endif; ?>
					<?php for ($i = 1; $i <= $total_pages; $i++): ?>
						<li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
							<a class="page-link" href="advertise.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
						</li>
					<?php endfor; ?>
					<?php if ($page < $total_pages): ?>
						<li class="page-item"><a class="page-link" href="advertise.php?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next</a></li>
						<li class="page-item"><a class="page-link" href="advertise.php?page=<?php echo $total_pages; ?>&search=<?php echo $search; ?>">Last</a></li>
					<?php endif; ?>
				</ul>
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
                <h5 class="modal-title" id="addBlogModalLabel">Add Advertise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                    <i class="la la-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Embed add_blog.php page in an iframe -->
                <iframe src="add_advertise.php" width="100%" height="800" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Update Blog Modal -->
<div class="modal fade" id="updateBlogModal" tabindex="-1" aria-labelledby="updateBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBlogModalLabel">Update Advertise</h5>
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
    window.location.href = 'advertise.php';  // Adjust the URL as needed
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
        alert("New Advertise Entry created successfully!");

        // Close the modal after the alert
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBlogModal'));
        modal.hide();

        // After closing the modal, redirect to blog.php
        window.location.href = 'advertise.php';  // Adjust the URL as needed
    } else if (message.action === 'error') {
        // Handle error message
        alert("Error: " + message.message);
    }
});

function loadUpdatePage(id) {
        const iframe = document.getElementById('updateBlogIframe');
        iframe.src = `update_advertise.php?id=${id}`;
    }

    // Reload the blog list when the update modal is closed
    document.getElementById('updateBlogModal').addEventListener('hidden.bs.modal', function () {
        window.location.href = 'advertise.php'; // Reload to see updates
    });

	window.addEventListener('message', function(event) {
        if (event.data.action === 'closeModal') {
            // Close the modal (e.g., Bootstrap)
            $('#updateBlogModal').modal('hide'); // Replace #yourModalId with your modal's ID
        }
    });


	function confirmDelete() {
    return confirm("Are you sure you want to delete this Advertise?");
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