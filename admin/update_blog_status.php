<?php
include('config.php'); // Include database configuration

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']); // Sanitize Blog ID
    $status = $_POST['status']; // Get status (active/deactive)

    // Update query
    $sql = "UPDATE blog SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id); // Bind parameters

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'invalid';
}
?>
