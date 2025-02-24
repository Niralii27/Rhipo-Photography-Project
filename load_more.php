<?php
include 'config.php'; // Include your DB connection here

// Fetch data sent via AJAX
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
$limit = 9;

// Query to fetch portfolio items
$query = "SELECT * FROM client_portfolio ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

header('Content-Type: application/json');
echo json_encode($items);
?>
