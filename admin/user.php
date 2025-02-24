<?php
    include('sidebar.php');
    include('header.php');
    include('config.php');

    // Define how many results per page
    $results_per_page = 10;

    // Check for search query
    $search_query = "";
    if (isset($_GET['search'])) {
        $search_query = mysqli_real_escape_string($conn, $_GET['search']);
    }

    // Find the total number of records with or without search query
    $sql = "SELECT COUNT(id) AS total FROM registration";
    if (!empty($search_query)) {
        $sql .= " WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%' OR number LIKE '%$search_query%'";
    }

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];

    // Calculate the total pages required
    $total_pages = ceil($total_records / $results_per_page);

    // Get the current page number from the URL, if not set, default to 1
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current_page = $_GET['page'];
    } else {
        $current_page = 1;
    }

    // Calculate the starting row for the SQL query
    $start_from = ($current_page - 1) * $results_per_page;

    // Fetch the user data for the current page with or without search query
    $sql = "SELECT id, name, email, password, number, profile_image FROM registration";
    if (!empty($search_query)) {
        $sql .= " WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%' OR number LIKE '%$search_query%'";
    }
    $sql .= " LIMIT $start_from, $results_per_page";
    $result = mysqli_query($conn, $sql);
    $path = "../uploads/";
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Components - Ready Bootstrap Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/css/ready.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/demo.css">
</head>
<style>
    .search-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>

<body>
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Users</h4>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Users Data</div>
                    <form method="GET" action="" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Search by Name, Email, or Number" value="<?php echo htmlspecialchars($search_query); ?>"style="max-width: 300px;">
                            <button type="submit" class="btn btn-primary ms-2" style="margin-right:10px;">Search</button>
                            <a href="?" class="btn btn-secondary ms-2">Clear</a>
                        </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Number</th>
                                    <th>Image</th>
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
                                    echo '<td>' . htmlspecialchars($row['password']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['number']) . '</td>';

                                    // Dynamic image path with a fallback image
                                    $imagePath = !empty($row['profile_image']) ? $path . $row['profile_image'] : 'https://i.imgur.com/wvxPV9S.png';
                                    echo '<td><img src="' . htmlspecialchars($imagePath) . '" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%;"></td>';
                                    echo '<td>';
                                    echo '<a href="delete_user.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(\'Are you sure you want to delete this user?\')"><i class="fas fa-trash-alt"></i></a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php
                            // Previous button
                            if ($current_page > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '&search=' . urlencode($search_query) . '">Previous</a></li>';
                            }

                            // Links to pages
                            for ($page = 1; $page <= $total_pages; $page++) {
                                if ($page == $current_page) {
                                    echo '<li class="page-item active"><a class="page-link" href="#">' . $page . '</a></li>';
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . $page . '&search=' . urlencode($search_query) . '">' . $page . '</a></li>';
                                }
                            }

                            // Next button
                            if ($current_page < $total_pages) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '&search=' . urlencode($search_query) . '">Next</a></li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

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
</html>
