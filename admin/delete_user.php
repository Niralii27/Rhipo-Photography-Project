<?php
include('config.php'); 

// Check if the ID is set
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $userId = mysqli_real_escape_string($conn, $userId);

    // Write the DELETE query
    $sql = "DELETE FROM registration WHERE id = '$userId'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect with a success message
        echo "<script>
                alert('User deleted successfully!');
                window.location.href = 'user.php'; // Replace with your current page's URL
              </script>";
    } else {
        // Handle error if query fails
        echo "<script>
                alert('Error deleting user!');
                window.location.href = 'user.php'; // Replace with your current page's URL
              </script>";
    }
}
?>
