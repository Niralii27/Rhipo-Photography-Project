<?php
include('config.php');

if (isset($_POST['id'])) {
    $blogId = $_POST['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM blog WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $blogId); // Bind the blog ID parameter to the query
        if ($stmt->execute()) {
            echo 'Blog deleted successfully!';
            header("Location: blog.php"); // Redirect back to the blog page
        } else {
            echo 'Error: Could not delete the blog.';
        }
        $stmt->close();
    } else {
        echo 'Error: Could not prepare the delete query.';
    }
} else {
    echo 'Error: No blog ID provided.';
}

$conn->close();
?>
