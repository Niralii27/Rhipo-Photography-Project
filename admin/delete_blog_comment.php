<?php
include('config.php');

if (isset($_POST['id'])) {
    $blogId = $_POST['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM blog_comment WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $blogId); 
        if ($stmt->execute()) {
            echo 'Contact deleted successfully!';
            header("Location: blog_comment.php"); 
        } else {
            echo 'Error: Could not delete the Blog Comment.';
        }
        $stmt->close();
    } else {
        echo 'Error: Could not prepare the delete query.';
    }
} else {
    echo 'Error: No Blog Comment ID provided.';
}

$conn->close();
?>
