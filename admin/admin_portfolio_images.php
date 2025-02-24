<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('sidebar.php');
include('header.php');
include('config.php'); // Ensure this file contains your database connection setup

// Fetch data from the database
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Fetch data from the database with an optional search query
$query = "SELECT * FROM admin_portfolio_images WHERE portfolio_title LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%$search%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Admin Portfolio Album</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/css/ready.css">
    <link rel="stylesheet" href="assets/css/demo.css">
    <!-- FontAwesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Table styling */
        table img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }

        /* Gallery container styling */
        #galleryContainer {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }

        /* Gallery item styling */
        #galleryContainer img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        #galleryContainer img:hover {
            transform: scale(1.05);
        }

        /* Placeholder message */
        #galleryContainer p {
            font-size: 18px;
            text-align: center;
            color: #555;
            grid-column: span 3;
        }  
        #searchInput {
            width: 300px;
            margin-right: 10px;
        }

        #clearSearch {
            margin-left: 10px;
        }      
    </style>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Admin Portfolio Album</h4>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">ADD ADMIN PORTFOLIO IMAGES</button>
                    </div><br>
                    <form method="POST" class="mb-3 d-flex">
                        <input type="text" id="searchInput" class="form-control me-2" name="search" placeholder="Search by Portfolio Title" value="<?php echo htmlspecialchars($search); ?>" style="max-width: 300px;">
                        <button type="submit" class="btn btn-primary mt-1">Search</button>
                        <button type="submit" name="search" value="" class="btn btn-secondary mt-1 ms-2">Clear Search</button>
                    </form>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Portfolio Title</th>
                                    <th>Portfolio ID</th>
                                    <th>Main Image</th>
                                    <th>Multiple Images</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Decode images JSON field
                                        $images = json_decode($row['images'], true);
                                        $images = is_array($images) ? $images : [];
                                        // Append "../uploads/" to all image paths
                                        $images = array_map(fn($img) => "../uploads/" . $img, $images);
                                        $imageData = htmlspecialchars(json_encode($images));

                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['portfolio_title']}</td>
                                                <td>{$row['portfolio_id']}</td>
                                                <td>";
                                        if (!empty($row['main_image'])) {
                                            echo "<img src='../uploads/{$row['main_image']}' alt='Main Image'>";
                                        } else {
                                            echo "No image available";
                                        }
                                        echo "</td>
                                                <td>
                                                    <button class='btn btn-info btn-sm show-images' data-images='$imageData'>Show</button>
                                                </td>
                                                <td>{$row['created_at']}</td>
                                                <td>
                    <!-- Update Icon (FontAwesome) -->
                    <button class='btn btn-warning btn-sm edit-btn' data-id='{$row['id']}'>
                        <i class='fas fa-edit'></i>
                    </button><td>
                    <!-- Delete Icon (FontAwesome) -->
										<form method='POST' action='delete_admin_portfolio_images.php' onsubmit='return confirmDelete()'>
											<input type='hidden' name='id' value='" . $row['id'] . "' />
											<button type='submit' class='btn btn-danger btn-sm' title='Delete'>
												<i class='la la-trash'></i>	
											</button>
										</form>
									</td>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No records found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Gallery View -->
                    <div id="galleryContainer">
                        <p>Click "Show" to view portfolio Album here.</p>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBlogModalLabel">Add Admin Portfolio Images</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                            <i class="la la-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Embed the form from add_admin_portfolio_images.php -->
                            <iframe src="add_admin_portfolio_images.php" style="width: 100%; height: 600px; border: none;"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
<!-- update modal -->
            <div class="modal fade" id="updatePortfolioModal" tabindex="-1" aria-labelledby="updatePortfolioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePortfolioModalLabel">Update Admin Portfolio Album</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor:pointer;">
                <i class="la la-close"></i>

                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded dynamically -->
                <iframe id="updateIframe" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="cursor:pointer;">Close</button>
            </div>
        </div>
    </div>
</div>
            
            <script src="assets/js/core/popper.min.js"></script>
            <script src="assets/js/core/bootstrap.bundle.min.js"></script>
            <script>
               document.addEventListener("DOMContentLoaded", () => {
    // Add event listeners to all "Show" buttons
    document.querySelectorAll('.show-images').forEach(button => {
        button.addEventListener('click', function () {
            try {
                const images = JSON.parse(this.getAttribute('data-images')); // Get images
                const galleryContainer = document.getElementById('galleryContainer');
                galleryContainer.innerHTML = ""; // Clear existing images
                if (images.length > 0) {
                    images.forEach(image => {
                        const imgElement = document.createElement('img');
                        imgElement.src = image;
                        imgElement.alt = "Gallery Image";
                        galleryContainer.appendChild(imgElement);
                    });
                } else {
                    galleryContainer.innerHTML = "<p>No images available for this portfolio.</p>";
                }
            } catch (error) {
                console.error("Error parsing images:", error);
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", () => {
    // Add event listener for all "Update" buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id'); // Get the portfolio ID
            const iframe = document.getElementById('updateIframe');
            iframe.src = `update_admin_portfolio_images.php?id=${id}`; // Load update page with ID as a query parameter
            const modal = new bootstrap.Modal(document.getElementById('updatePortfolioModal'));
            modal.show(); // Show the modal
        });
    });
});

//delete portfolio Images 

function confirmDelete() {
    return confirm("Are you sure you want to delete this Portfolio Album?");
}



            </script>
        </div>
    </div>
</div>
</body>
</html>
