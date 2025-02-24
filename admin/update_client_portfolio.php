<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM client_portfolio WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Client Portfolio not found!");
    }
    $stmt->close();
} else {
    die("Invalid request!");
}

// Split the 'images' field if it contains multiple images
$imageArray = [];
if (!empty($row['images'])) {
    $imageArray = explode(',', $row['images']); // Assuming images are stored as comma-separated filenames
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title']; // No need to escape manually
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $status = $_POST['status']; // No need to escape manually

    $uploads = [];
    $imageFields = [
        'coverImage' => 'cover_image',
        'mainImage' => 'main_image',
    ];

    // Handle single file uploads
    foreach ($imageFields as $inputName => $dbColumn) {
        if (!empty($_FILES[$inputName]['name'])) {
            $filename = basename($_FILES[$inputName]['name']);
            $targetPath = "../uploads/" . $filename;

            // Validate file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                die("Invalid file type for $inputName. Only JPG, JPEG, PNG, and GIF are allowed.");
            }

            // Validate file size (optional)
            if ($_FILES[$inputName]['size'] > 5 * 1024 * 1024) { // 5MB size limit
                die("File size for $inputName exceeds the limit of 5MB.");
            }

            // Move the uploaded file
            if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
                $uploads[$dbColumn] = $filename;
            } else {
                die("Failed to upload $inputName.");
            }
        }
    }

    // Handle multiple file uploads for 'images'
    if (!empty($_FILES['images']['name'][0])) {
        $uploadedFiles = [];
        foreach ($_FILES['images']['name'] as $key => $filename) {
            $fileTmpName = $_FILES['images']['tmp_name'][$key];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

            // Validate file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                die("Invalid file type for $filename. Only JPG, JPEG, PNG, and GIF are allowed.");
            }

            // Validate file size (optional)
            if ($_FILES['images']['size'][$key] > 5 * 1024 * 1024) { // 5MB size limit
                die("File size for $filename exceeds the limit of 5MB.");
            }

            // Create a unique filename and upload
            $uniqueFilename = uniqid() . '_' . basename($filename);
            $targetPath = "../uploads/" . $uniqueFilename;

            if (move_uploaded_file($fileTmpName, $targetPath)) {
                $uploadedFiles[] = $uniqueFilename;
            } else {
                die("Failed to upload $filename.");
            }
        }

        if (!empty($uploadedFiles)) {
            $uploads['images'] = implode(',', $uploadedFiles);
        }
    }

    // Build update query dynamically
    $sql = "UPDATE client_portfolio SET 
            title = ?, 
            status = ?";
    $params = [$title, $status];
    $types = "ss";

    foreach ($uploads as $column => $filename) {
        $sql .= ", $column = ?";
        $params[] = $filename;
        $types .= "s";
    }
    $sql .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    // Prepare and execute the update statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>alert('Client Portfolio updated successfully!');</script>";
        echo "<script>window.location.href = 'update_client_portfolio.php?id=$id';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update Portfolio</title>
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
    <h2>Update Client Portfolio</h2>
    <form id="portfolioform" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="title">Portfolio Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>


        <div class="form-group">
    <label>Cover Image</label><br>
    <img src="../uploads/<?php echo $row['cover_image']; ?>" alt="Cover Image" style="max-width: 30%; margin-top: 10px;">
    <input type="file" class="form-control-file" name="coverImage" accept="image/*">
</div>

<div class="form-group">
    <label>Main Image</label><br>
    <img src="../uploads/<?php echo $row['main_image']; ?>" alt="Main Image" style="max-width: 30%; margin-top: 10px;">
    <input type="file" class="form-control-file" name="mainImage" accept="image/*">
</div>

<div class="form-group">
    <label>Images</label><br>
    <?php foreach ($imageArray as $image): ?>
        <img src="../uploads/<?php echo $image; ?>" alt="Portfolio Image" style="max-width: 30%; margin-top: 10px;">
    <?php endforeach; ?>
    <input type="file" class="form-control-file" name="images[]" accept="image/*" multiple>
</div>


        <div class="form-group">
            <label>Status</label><br>
            <label class="form-radio-label">
                <input class="form-radio-input" type="radio" name="status" value="active" <?php echo ($row['status'] == 'active') ? 'checked' : ''; ?>>
                <span>Active</span>
            </label>
            <label class="form-radio-label">
                <input class="form-radio-input" type="radio" name="status" value="deactive" <?php echo ($row['status'] == 'deactive') ? 'checked' : ''; ?>>
                <span>Deactive</span>
            </label>
        </div>

        <div class="form-group">
            <button class="btn btn-success">Update</button>
            <a href="javascript:void(0);" class="btn btn-danger" onclick="closeParentModal()">Cancel</a>

<script>
    function closeParentModal() {
        // Send a message to the parent window to close the modal
        window.parent.postMessage({ action: 'closeModal' }, '*');
    }
</script>
            </div>
    </form>
</div>

<script>
$(document).ready(function () {
    $('#portfolioform').validate({
        rules: {
            title: { required: true },
            mainDescription: { required: true },
        },
        messages: {
            title: { required: "Please enter a title" },
            mainDescription: { required: "Please enter the main description" },
        }
    });
});
</script>
</body>
</html>
