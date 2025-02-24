<?php
    include('sidebar.php');
    include('header.php');
	include('config.php');
    $records_per_page = 5;

    // Get current page from query string (default to 1)
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Get search query
    $search_query = isset($_GET['search']) ? $_GET['search'] : '';

    // Calculate offset for the SQL query
    $offset = ($current_page - 1) * $records_per_page;

    // Modify SQL query to include search filter if applicable
    if (!empty($search_query)) {
        $sql_count = "SELECT COUNT(*) AS total FROM preferred_vendors WHERE title LIKE '%$search_query%' OR name LIKE '%$search_query%'";
        $sql = "SELECT * FROM preferred_vendors WHERE title LIKE '%$search_query%' OR name LIKE '%$search_query%' LIMIT $records_per_page OFFSET $offset";
    } else {
        $sql_count = "SELECT COUNT(*) AS total FROM preferred_vendors";
        $sql = "SELECT * FROM preferred_vendors LIMIT $records_per_page OFFSET $offset";
    }

    $result_count = $conn->query($sql_count);
    $total_records = $result_count->fetch_assoc()['total'];

    // Calculate total pages
    $total_pages = ceil($total_records / $records_per_page);

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
						<h4 class="page-title">Preferred Vendors</h4>
						

						<div class="card">
									<div class="card-header">
										<div class="card-title"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">ADD PREFERRED VENDOR</button>

										</div><br>
                                        <form method="GET" action="preferred_vendor.php" class="d-flex mb-3">
                                            <input type="text" name="search" class="form-control" placeholder="Search by Title or Name" value="<?php echo htmlspecialchars($search_query); ?>" style="max-width: 300px;"/>
                                            <button type="submit" class="btn btn-primary ms-2" style="margin-right:10px;">Search</button>
                                            <a href="preferred_vendor.php" class="btn btn-secondary ms-2">Clear</a>
                                        </form>
									</div>
									<div class="card-body">

										<div class="table-responsive">
											<table class="table table-bordered table table-striped mt-3">
												<thead>
													<tr>
														<th>Id</th>
														<th>Title</th>
														<th>Name</th>
														<th>Descritpion</th>
                                                        <th>Instagram</th>
                                                        <th>Facebook</th>
														<th>Image</th>
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
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>" . $row['instagram'] . "</td>";
                                        echo "<td>" . $row['facebook'] . "</td>";
                                        echo "<td><img src='../uploads/" . $row['image'] . "' alt='Inner Image1' width='100'></td>";
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
										<form method='POST' action='delete_preferred_vendor.php' onsubmit='return confirmDelete()'>
											<input type='hidden' name='id' value='" . $row['id'] . "' />
											<button type='submit' class='btn btn-danger btn-sm' title='Delete'>
												<i class='la la-trash'></i>	
											</button>
										</form>
									</td>";


								echo "</tr>";                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No Preferred Vendor found</td></tr>";
                                }
                                ?>
												</tbody>
											</table>
										</div>
                                        <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=1" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $total_pages ?>" aria-label="Last">
                                        <span aria-hidden="true">&raquo;&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
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
                <h5 class="modal-title" id="addBlogModalLabel">Add Preferred Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                    <i class="la la-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Embed add_blog.php page in an iframe -->
                <iframe src="add_preferred_vendor.php" width="100%" height="800" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Update Blog Modal -->
<div class="modal fade" id="updateBlogModal" tabindex="-1" aria-labelledby="updateBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBlogModalLabel">Update Preferred Vendor</h5>
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
    window.location.href = 'preferred_vendor.php';  // Adjust the URL as needed
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
        alert("New Preferred Vendor Entry created successfully!");

        // Close the modal after the alert
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBlogModal'));
        modal.hide();

        // After closing the modal, redirect to blog.php
        window.location.href = 'preferred_vendor.php';  // Adjust the URL as needed
    } else if (message.action === 'error') {
        // Handle error message
        alert("Error: " + message.message);
    }
});

function loadUpdatePage(id) {
        const iframe = document.getElementById('updateBlogIframe');
        iframe.src = `update_preferred_vendor.php?id=${id}`;
    }

    // Reload the blog list when the update modal is closed
    document.getElementById('updateBlogModal').addEventListener('hidden.bs.modal', function () {
        window.location.href = 'preferred_vendor.php'; // Reload to see updates
    });

	window.addEventListener('message', function(event) {
        if (event.data.action === 'closeModal') {
            // Close the modal (e.g., Bootstrap)
            $('#updateBlogModal').modal('hide'); // Replace #yourModalId with your modal's ID
        }
    });


	function confirmDelete() {
    return confirm("Are you sure you want to delete this Preferred Vendor?");
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