<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM exclusive_clips_reel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Exclusive Clips not found!");
    }
    $stmt->close();
} else {
    die("Invalid request!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $status = trim($_POST['status']);

    // Validate and sanitize inputs
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

    // Handle video file upload (if any)
    $uploadedVideo = $row['video']; // Default to existing video
    $uploadDir = "../uploads/videos/";

    // Ensure the directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES['video']['name'])) {
        $filename = basename($_FILES['video']['name']);
        $targetPath = $uploadDir . $filename;

        // Validate file type
        $allowedExtensions = ['mp4', 'mkv', 'avi', 'mov'];
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            die("Invalid file type. Only MP4, MKV, AVI, and MOV are allowed.");
        }

        if (move_uploaded_file($_FILES['video']['tmp_name'], $targetPath)) {
            $uploadedVideo = $filename;
        } else {
            die("Failed to upload video.");
        }
    }

    // Update query
    $stmt = $conn->prepare("UPDATE exclusive_clips_reel SET title = ?, video = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $uploadedVideo, $status, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Exclusive Clips updated successfully!');</script>";
        echo "<script>window.location.href = 'update_exclusive_clips_reel.php?id=$id';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Exclusive Clips</title>
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
    <h2>Update Exclusive Clips</h2>
    <form id="exclusiveClipsForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

       
        <div class="form-group">
            <label>Current Video</label>
            <video width="320" height="240" controls style="display: block; margin-top: 10px;">
                <source src="../uploads/videos/<?php echo htmlspecialchars($row['video'], ENT_QUOTES, 'UTF-8'); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="form-group">
            <label for="video">Update Video</label>
            <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="active" <?php echo ($row['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="deactive" <?php echo ($row['status'] === 'deactive') ? 'selected' : ''; ?>>Deactive</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <button class="btn btn-success">Update</button>
            <a href="javascript:void(0);" class="btn btn-danger" onclick="closeParentModal()">Cancel</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#exclusiveClipsForm').validate({
            rules: {
                title: { required: true },
                status: { required: true },
            },
            messages: {
                title: { required: "Please enter a title" },
                status: { required: "Please select a status" },
            }
        });
    });

    function closeParentModal() {
        // Notify the parent window to close the modal
        window.parent.postMessage({ action: 'closeModal' }, '*');
    }
</script>
</body>
</html>
