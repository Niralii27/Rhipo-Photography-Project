<?php
include('config.php');

if (isset($_POST['id'])) {
    $blogId = $_POST['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM review WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $blogId); 
        if ($stmt->execute()) {
            echo 'Review deleted successfully!';
            header("Location: review.php"); 
        } else {
            echo 'Error: Could not delete the Review.';
        }
        $stmt->close();
    } else {
        echo 'Error: Could not prepare the delete query.';
    }
} else {
    echo 'Error: No Review ID provided.';
}

$conn->close();
?>
