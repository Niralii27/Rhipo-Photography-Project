<?php
    include('sidebar.php');
    include('header.php');
	include('config.php');

    $records_per_page = 5;

	// Get the current page number from the URL, default to page 1 if not set
	$page = isset($_GET['page']) ? $_GET['page'] : 1;

	// Get the search query (if any)
	$search_query = isset($_GET['search']) ? $_GET['search'] : '';

	// Calculate the offset for the SQL query
	$offset = ($page - 1) * $records_per_page;
    
	// Modify the SQL query to filter based on search term (Title or User Name)
	$sql = "SELECT * FROM client_portfolio 
            WHERE title LIKE '%$search_query%' OR user_name LIKE '%$search_query%' 
            LIMIT $offset, $records_per_page";
	$result = $conn->query($sql);

    // SQL query to get the total number of records (with search condition)
	$total_records_sql = "SELECT COUNT(*) FROM client_portfolio 
                          WHERE title LIKE '%$search_query%' OR user_name LIKE '%$search_query%'";
	$total_records_result = $conn->query($total_records_sql);
	$total_records = $total_records_result->fetch_row()[0];

	// Calculate the total number of pages
	$total_pages = ceil($total_records / $records_per_page);


?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Forms - Ready Bootstrap Dashboard</title>
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
						<h4 class="page-title">Client Portfolio</h4>
						

						<div class="card">
									<div class="card-header">
										<div class="card-title"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">ADD CLIENT PORTFOLIO</button>

										</div>
                                        <form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Search by Title or Username" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"style="max-width: 300px;">
        <button class="btn btn-primary" type="submit">Search</button>
        <!-- Clear Search Button -->
        <a href="client_portfolio.php" class="btn btn-secondary">Clear Search</a>
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
														<th>User Id</th>
														<th>User Name</th>
														<th>Cover Image</th>
														<th>Main Image</th>
														<th>Images</th>
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
                                        echo "<td>" . $row['title'] . "</td>";
										echo "<td>" . $row['user_id'] . "</td>";
                                        echo "<td>" . $row['user_name'] . "</td>";
                                        echo "<td><img src='../uploads/" . $row['cover_image'] . "' alt='Inner Image1' width='100'></td>";
                                        echo "<td><img src='../uploads/" . $row['main_image'] . "' alt='Inner Image2' width='100'></td>";
										echo "<td><button class='btn btn-info btn-sm' onclick='showGallery(\"" . $row['images'] . "\")'>Show Images</button></td>";
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
										<form method='POST' action='delete_client_portfolio.php' onsubmit='return confirmDelete()'>
											<input type='hidden' name='id' value='" . $row['id'] . "' />
											<button type='submit' class='btn btn-danger btn-sm' title='Delete'>
												<i class='la la-trash'></i>	
											</button>
										</form>
									</td>";


								echo "</tr>";                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No Client Portfolio found</td></tr>";
                                }
                                ?>
												</tbody>
											</table>
										</div>
                                        <nav>
						<ul class="pagination justify-content-center">
							<?php if ($page > 1): ?>
								<li class="page-item"><a class="page-link" href="?page=1">First</a></li>
								<li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
							<?php endif; ?>

							<?php for ($i = 1; $i <= $total_pages; $i++): ?>
								<li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php endfor; ?>

							<?php if ($page < $total_pages): ?>
								<li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
								<li class="page-item"><a class="page-link" href="?page=<?php echo $total_pages; ?>">Last</a></li>
							<?php endif; ?>
						</ul>
					</nav>
										<div id="galleryView" class="mt-4" style="display: none;">
    <h5>Gallery View</h5>
    <div id="galleryImages" class="d-flex flex-wrap"></div>
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
                <h5 class="modal-title" id="addBlogModalLabel">Add Client Portfolio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                    <i class="la la-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Embed add_blog.php page in an iframe -->
                <iframe src="add_client_portfolio.php" width="100%" height="800" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Update Blog Modal -->
<div class="modal fade" id="updateBlogModal" tabindex="-1" aria-labelledby="updateBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBlogModalLabel">Update Portfolio</h5>
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
    window.location.href = 'client_portfolio.php';  // Adjust the URL as needed
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
        alert("New Protfolio Entry created successfully!");

        // Close the modal after the alert
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBlogModal'));
        modal.hide();

        // After closing the modal, redirect to blog.php
        window.location.href = 'client_portfolio.php';  // Adjust the URL as needed
    } else if (message.action === 'error') {
        // Handle error message
        alert("Error: " + message.message);
    }
});

function loadUpdatePage(id) {
        const iframe = document.getElementById('updateBlogIframe');
        iframe.src = `update_client_portfolio.php?id=${id}`;
    }

    // Reload the blog list when the update modal is closed
    document.getElementById('updateBlogModal').addEventListener('hidden.bs.modal', function () {
        window.location.href = 'client_portfolio.php'; // Reload to see updates
    });

	window.addEventListener('message', function(event) {
        if (event.data.action === 'closeModal') {
            // Close the modal (e.g., Bootstrap)
            $('#updateBlogModal').modal('hide'); // Replace #yourModalId with your modal's ID
        }
    });

	function confirmDelete() {
    return confirm("Are you sure you want to delete this Client Portfolio?");
}

//image Gallery
    function showGallery(images) {
        const galleryView = document.getElementById('galleryView');
        const galleryImages = document.getElementById('galleryImages');

        // Clear any previous gallery content
        galleryImages.innerHTML = '';

        // Split the `images` string into an array (assuming comma-separated)
        const imageList = images.split(',');

        // Generate image elements
        imageList.forEach(image => {
            const imgElement = document.createElement('img');
            imgElement.src = '../uploads/' + image.trim();
            imgElement.alt = 'Gallery Image';
            imgElement.style.width = '150px';
            imgElement.style.margin = '10px';
            imgElement.style.border = '1px solid #ddd';
            imgElement.style.padding = '5px';

            galleryImages.appendChild(imgElement);
        });

        // Scroll to the gallery
        galleryView.scrollIntoView({ behavior: 'smooth' });

        // Show the gallery container
        galleryView.style.display = 'block';
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