<?php
// advertise.php

session_start();
include 'config.php'; // Include your database connection

// Get the last shown ad ID from the session
$lastShownAdId = isset($_SESSION['last_shown_ad_id']) ? $_SESSION['last_shown_ad_id'] : 0;

// Fetch the next active advertisement
$sql = "SELECT id, image FROM advertise WHERE status = 'active' AND id > ? ORDER BY id ASC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lastShownAdId);
$stmt->execute();
$result = $stmt->get_result();

// Check if there is a next ad
if ($row = $result->fetch_assoc()) {
    // Save the current ad ID in the session
    $_SESSION['last_shown_ad_id'] = $row['id'];

    // Display the advertisement
    echo '
    <div id="ad-popup" class="popup">
        <div class="popup-content">
            <span class="close-btn" id="close-btn">&times;</span>
            <img src="uploads/' . htmlspecialchars($row['image']) . '" alt="Advertisement" />
        </div>
    </div>
    ';
} else {
    // No more ads to show
    $_SESSION['last_shown_ad_id'] = 0; // Reset for next cycle
    exit();
}

$stmt->close();
$conn->close();
?>
