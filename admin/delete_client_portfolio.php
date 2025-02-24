<?php
include('config.php');

if (isset($_POST['id'])) {
    $blogId = $_POST['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM client_portfolio WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $blogId); // Bind the blog ID parameter to the query
        if ($stmt->execute()) {
            echo 'Client Portfolio deleted successfully!';
            header("Location: client_portfolio.php"); // Redirect back to the blog page
        } else {
            echo 'Error: Could not delete the Client portfolio.';
        }
        $stmt->close();
    } else {
        echo 'Error: Could not prepare the delete query.';
    }
} else {
    echo 'Error: No Client Protfolio ID provided.';
}

$conn->close();
?>
