<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM review WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Review not found!");
    }
    $stmt->close();
} else {
    die("Invalid request!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    // Validate and sanitize inputs
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

    // Handle file upload (if any)
    $uploads = [];
    $imageField = 'image'; // Only one image field
    if (!empty($_FILES[$imageField]['name'])) {
        $filename = basename($_FILES[$imageField]['name']);
        $targetPath = "../uploads/" . $filename;

        // Validate file type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        if (move_uploaded_file($_FILES[$imageField]['tmp_name'], $targetPath)) {
            $uploads['image'] = $filename;
        } else {
            die("Failed to upload image.");
        }
    }

    // Build update query
    $sql = "UPDATE review SET name = ?, title = ?, description = ?";
    $params = [$name, $title, $description];
    $types = "sss";

    // Add image field to the query if an image is uploaded
    if (isset($uploads['image'])) {
        $sql .= ", image = ?";
        $params[] = $uploads['image'];
        $types .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>alert('Review updated successfully!');</script>";
        echo "<script>window.location.href = 'update_review.php?id=$id';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Review</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</head>
<style>
    .error {
        color: red;
        font-size: 0.875em;
        margin-top: 0.25em;
    }
</style>
<body>
<div class="container">
    <h2>Update Review</h2>
    <form id="reviewForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="title">Review Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required><?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="form-group">
            <label>Client Image</label>
            <img src="../uploads/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image" style="max-width: 30%; margin-top: 10px;">
            <input type="file" class="form-control-file" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <button class="btn btn-success">Update</button>
            <a href="javascript:void(0);" class="btn btn-danger" onclick="closeParentModal()">Cancel</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#reviewForm').validate({
            rules: {
                name: { required: true },
                title: { required: true },
                description: { required: true },
            },
            messages: {
                name: { required: "Please enter a name" },
                title: { required: "Please enter a title" },
                description: { required: "Please enter a description" },
            }
        });
    });

    function closeParentModal() {
        // Close modal in parent window
        window.parent.postMessage({ action: 'closeModal' }, '*');
    }
</script>
</body>
</html>
