<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM advertise WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Advertise not found!");
    }
    $stmt->close();
} else {
    die("Invalid request!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = trim($_POST['status']);
   

    
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
    $sql = "UPDATE advertise SET status = ?";
    $params = [$status];
    $types = "s";

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
        echo "<script>alert('Advertise updated successfully!');</script>";
        echo "<script>window.location.href = 'update_advertise.php?id=$id';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Advertise</title>
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
    <h2>Update Advertise</h2>
    <form id="reviewForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        
        <div class="form-group">
            <label>Advertise Image</label>
            <img src="../uploads/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image" style="max-width: 30%; margin-top: 10px;">
            <input type="file" class="form-control-file" name="image" accept="image/*">
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
        </div>
    </form>
</div>

<script>
    
    function closeParentModal() {
        // Close modal in parent window
        window.parent.postMessage({ action: 'closeModal' }, '*');
    }
</script>
</body>
</html>
