<?php

include('config.php');

// Default item id (for initial load)
$item_id = isset($_POST['item_id']) ? (int) $_POST['item_id'] : 1;  // Default item id is 1

// Fetch item details
$sql = "SELECT * FROM review WHERE id = $item_id";
$result = $conn->query($sql);
$item = null;
if ($result->num_rows > 0) {
    $item = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Review</title>
</head>

<body>

    <div id="item-container">
        <h3 id="item-name"><?php echo isset($item['name']) ? $item['name'] : 'No item found'; ?></h3>
        <p id="item-description"><?php echo isset($item['description']) ? $item['description'] : ''; ?></p>
        <button id="left-arrow" onclick="changeItem('left')">←</button>
        <button id="right-arrow" onclick="changeItem('right')">→</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // JavaScript to handle item change without page refresh
        let currentItemId = <?php echo isset($item['id']) ? $item['id'] : 1; ?>;

        function loadItem(itemId) {
            $.ajax({
                url: '', // Same file, POST request
                type: 'POST',
                data: {
                    item_id: itemId
                },
                success: function(response) {
                    // We are expecting the response to contain HTML content for the item
                    $('#item-container').html(response); // Replace content inside item-container
                }
            });
        }

        function changeItem(direction) {
            // Change item based on left or right arrow click
            if (direction === 'right') {
                currentItemId++;
            } else if (direction === 'left') {
                currentItemId--;
            }

            // Fetch the next item, ensuring the ID stays within valid range
            loadItem(currentItemId);
        }
    </script>

</body>

</html>