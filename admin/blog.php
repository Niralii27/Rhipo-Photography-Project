<?php
    include('sidebar.php');
    include('header.php');
    include('config.php');

    // Define how many records you want per page
    $records_per_page = 5; 

    // Get the current page number from the URL, default to 1 if not set
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Calculate the starting record of the page
    $offset = ($page - 1) * $records_per_page;

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';


   if (!empty($search)) {
        $sql = "SELECT * FROM blog WHERE title LIKE ? OR description LIKE ? LIMIT $offset, $records_per_page";
        $stmt = $conn->prepare($sql);
        $search_param = "%$search%";
        $stmt->bind_param("ss", $search_param, $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $sql = "SELECT * FROM blog LIMIT $offset, $records_per_page";
        $result = $conn->query($sql);
    }

    // Query to get the total number of records
    if (!empty($search)) {
        $total_sql = "SELECT COUNT(*) FROM blog WHERE title LIKE ? OR description LIKE ?";
        $stmt_total = $conn->prepare($total_sql);
        $stmt_total->bind_param("ss", $search_param, $search_param);
        $stmt_total->execute();
        $total_result = $stmt_total->get_result();
        $total_rows = $total_result->fetch_row()[0];
    } else {
        $total_sql = "SELECT COUNT(*) FROM blog";
        $total_result = $conn->query($total_sql);
        $total_rows = $total_result->fetch_row()[0];
    }

    // Calculate the total number of pages
    $total_pages = ceil($total_rows / $records_per_page);
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
            <h4 class="page-title">Blog</h4>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">ADD BLOG</button>
                    </div><br>
                    <form method="GET" action="blog.php" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search Blogs..." value="<?php echo htmlspecialchars($search); ?>" style="max-width: 300px;">
                        <button type="submit" class="btn btn-success">Search</button>
                        <?php if (!empty($search)) { ?>
                            <a href="blog.php" class="btn btn-secondary ms-2">Clear Search</a>
                        <?php } ?>
                    </form>
                </div>
                <div class="card-body">
                    <!-- Apply custom scrollable wrapper -->
                    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                        <table class="table table-bordered table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th style="min-width: 500px;">Main Description</th>
                                    <th>Cover Image</th>
                                    <th>Main Image</th>
                                    <th>Inner Image1</th>
                                    <th>Inner Image2</th>
                                    <th>Inner Image3</th>
                                    <th>Inner Image4</th>
                                    <th style="min-width: 500px;">Inner Description</th>
                                    <th>Status</th>
                                    <th style="min-width: 110px;">Created At</th>
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
                                        echo "<td><img src='../uploads/" . $row['cover_image'] . "' alt='Cover Image' width='100'></td>";
                                        echo "<td><img src='../uploads/" . $row['main_image'] . "' alt='Main Image' width='100'></td>";
                                        echo "<td><img src='../uploads/" . $row['inner_image1'] . "' alt='Inner Image1' width='100'></td>";
                                        echo "<td><img src='../uploads/" . $row['inner_image2'] . "' alt='Inner Image2' width='100'></td>";
                                        echo "<td><img src='../uploads/" . $row['inner_image3'] . "' alt='Inner Image3' width='100'></td>";
                                        echo "<td><img src='../uploads/" . $row['inner_image4'] . "' alt='Inner Image4' width='100'></td>";
                                        echo "<td>" . $row['inner_description'] . "</td>";
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
                                        <form method='POST' action='delete_blog.php' onsubmit='return confirmDelete()'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "' />
                                            <button type='submit' class='btn btn-danger btn-sm' title='Delete'>
                                                <i class='la la-trash'></i>    
                                            </button>
                                        </form>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No blogs found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="blog.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>

                            <?php if ($page < $total_pages) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="blog.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>

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
                <h5 class="modal-title" id="addBlogModalLabel">Add Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                    <i class="la la-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Embed add_blog.php page in an iframe -->
                <iframe src="add_blog.php" width="100%" height="800" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Update Blog Modal -->
<div class="modal fade" id="updateBlogModal" tabindex="-1" aria-labelledby="updateBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBlogModalLabel">Update Blog</h5>
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
    window.location.href = 'blog.php';  // Adjust the URL as needed
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
        alert("New Blog Entry created successfully!");

        // Close the modal after the alert
        const modal = bootstrap.Modal.getInstance(document.getElementById('addBlogModal'));
        modal.hide();

        // After closing the modal, redirect to blog.php
        window.location.href = 'blog.php';  // Adjust the URL as needed
    } else if (message.action === 'error') {
        // Handle error message
        alert("Error: " + message.message);
    }
});

function loadUpdatePage(id) {
        const iframe = document.getElementById('updateBlogIframe');
        iframe.src = `update_blog.php?id=${id}`;
    }

    // Reload the blog list when the update modal is closed
    document.getElementById('updateBlogModal').addEventListener('hidden.bs.modal', function () {
        window.location.href = 'blog.php'; // Reload to see updates
    });

	window.addEventListener('message', function(event) {
        if (event.data.action === 'closeModal') {
            // Close the modal (e.g., Bootstrap)
            $('#updateBlogModal').modal('hide'); // Replace #yourModalId with your modal's ID
        }
    });


	function confirmDelete() {
    return confirm("Are you sure you want to delete this blog?");
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