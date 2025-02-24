<?php

include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    

    // Fetch data for the given ID
    $sql = "SELECT * FROM preferred_vendors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid ID']);
}
?>
