<?php
include('config.php');
session_start();

// Get offset and limit from request
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 9;

// Fetch user_id from session
$user_id = $_SESSION['user_id'] ?? null;

$response = [];
if ($user_id) {
    $stmt = $conn->prepare("SELECT * FROM client_portfolio WHERE user_id = ? AND status = 'active' LIMIT ?, ?");
    $stmt->bind_param("iii", $user_id, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
