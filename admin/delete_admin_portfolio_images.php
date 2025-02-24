<?php
include('config.php');

if (isset($_POST['id'])) {
    $blogId = $_POST['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM admin_portfolio_images WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $blogId); // Bind the blog ID parameter to the query
        if ($stmt->execute()) {
            echo 'Portfolio Album deleted successfully!';
            header("Location: admin_portfolio_images.php"); // Redirect back to the blog page
        } else {
            echo 'Error: Could not delete the portfolio Album.';
        }
        $stmt->close();
    } else {
        echo 'Error: Could not prepare the delete query.';
    }
} else {
    echo 'Error: No Protfolio Album ID provided.';
}

$conn->close();
?>
