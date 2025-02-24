<?php
include('config.php');

if (isset($_POST['id'])) {
    $blogId = $_POST['id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM contact WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $blogId); 
        if ($stmt->execute()) {
            echo 'Contact deleted successfully!';
            header("Location: contact.php"); 
        } else {
            echo 'Error: Could not delete the Contact.';
        }
        $stmt->close();
    } else {
        echo 'Error: Could not prepare the delete query.';
    }
} else {
    echo 'Error: No Contact ID provided.';
}

$conn->close();
?>
