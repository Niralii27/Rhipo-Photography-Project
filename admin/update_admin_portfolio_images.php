<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('config.php'); // Database connection

// Check if the ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the portfolio details from the database
    $query = "SELECT * FROM admin_portfolio_images WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $portfolio = $result->fetch_assoc();

    if (!$portfolio) {
        die("Portfolio not found.");
    }
} else {
    die("Invalid request. No ID provided.");
}

// Update portfolio logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file uploads for the main image
    if (!empty($_FILES['main_image']['name'])) {
        $target_dir = "../uploads/";
        $main_image = basename($_FILES['main_image']['name']);
        $target_file = $target_dir . $main_image;

        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file)) {
            // Update the main image in the database
            $update_main_image = "UPDATE admin_portfolio_images SET main_image = ? WHERE id = ?";
            $stmt = $conn->prepare($update_main_image);
            $stmt->bind_param("si", $main_image, $id);
            $stmt->execute();
        }
    }

    // Handle file uploads for multiple images
    if (!empty($_FILES['images']['name'][0])) {
        $images = [];
        $target_dir = "../uploads/";

        foreach ($_FILES['images']['name'] as $key => $image_name) {
            $target_file = $target_dir . basename($image_name);
            if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
                $images[] = basename($image_name);
            }
        }

        if (!empty($images)) {
            $images_json = json_encode($images);
            $update_images = "UPDATE admin_portfolio_images SET images = ? WHERE id = ?";
            $stmt = $conn->prepare($update_images);
            $stmt->bind_param("si", $images_json, $id);
            $stmt->execute();
        }
    }

    echo "<script>alert('Portfolio images updated successfully!');</script>";
    echo "<script>window.top.location.reload();</script>"; // Refresh parent page
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rhipo Admin</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3>Update Portfolio Album</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="main_image" class="form-label">Main Image</label>
            <div class="mb-2">
                <?php if (!empty($portfolio['main_image'])): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($portfolio['main_image']); ?>" alt="Main Image" width="100">
                <?php else: ?>
                    <p>No image uploaded.</p>
                <?php endif; ?>
            </div>
            <input type="file" class="form-control" id="main_image" name="main_image">
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Additional Images</label>
            <div class="mb-2">
                <?php 
                $images = json_decode($portfolio['images'], true);
                if (!empty($images) && is_array($images)) {
                    foreach ($images as $img) {
                        echo "<img src='../uploads/" . htmlspecialchars($img) . "' alt='Image' width='100' style='margin-right: 10px;'>";
                    }
                } else {
                    echo "<p>No additional images uploaded.</p>";
                }
                ?>
            </div>
            <input type="file" class="form-control" id="images" name="images[]" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Update Images</button>
    </form>
</div>
</body>
</html>