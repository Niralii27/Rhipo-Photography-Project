<?php
include('config.php');

if (isset($_POST['id'])) {
    $blogId = $_POST['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM exclusive_clips WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $blogId); 
        if ($stmt->execute()) {
            echo 'Exclusive Clips deleted successfully!';
            header("Location: exclusive_clips.php"); 
        } else {
            echo 'Error: Could not delete the Exclusive Clips.';
        }
        $stmt->close();
    } else {
        echo 'Error: Could not prepare the delete query.';
    }
} else {
    echo 'Error: No Exclusive Clips ID provided.';
}

$conn->close();
?>
