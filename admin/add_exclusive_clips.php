<?php
include('config.php');

// Increase limits dynamically
ini_set('upload_max_filesize', '300M');
ini_set('post_max_size', '300M');
ini_set('max_execution_time', '300');
ini_set('max_input_time', '300');

// Maximum allowed file size in bytes (e.g., 300MB = 300 * 1024 * 1024)
$maxFileSize = 300 * 1024 * 1024;

// Handle cases where the file size exceeds `post_max_size`
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST) && $_SERVER['CONTENT_LENGTH'] > $maxFileSize) {
        echo "<script>alert('Error: Your video size is too large. Maximum allowed size is 300MB.'); window.history.back();</script>";
        exit;
    }

   

    // Validate uploaded file
    if ($_FILES['video']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Error: File upload error. Please try again.'); window.history.back();</script>";
        exit;
    }

    if ($_FILES['video']['size'] > $maxFileSize) {
        echo "<script>alert('Error: Your video size is too large. Maximum allowed size is 300MB.'); window.history.back();</script>";
        exit;
    }

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $created_at = date('Y-m-d H:i:s');

    // Handle file upload
    $uploads_dir = '../uploads/videos/';
    $videoFileName = basename($_FILES['video']['name']);
    $videoPath = $uploads_dir . $videoFileName;

    // Ensure uploads directory exists
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES['video']['tmp_name'], $videoPath)) {
        // Insert into database
        $sql = "INSERT INTO exclusive_clips (title, video, status, created_at) 
                VALUES ('$title', '$videoFileName', '$status', '$created_at')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Reel added successfully!'); window.location.href='add_exclusive_clips.php';</script>";
        } else {
            echo "<script>alert('Database Error: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error: Failed to upload video. Please try again.'); window.history.back();</script>";
    }

    $conn->close();
}
?>





<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Rhipo Admin</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="content">
    <div class="container-fluid" style="width:200%;">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form id="portfolioform" method="POST" action="add_exclusive_clips.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title Of Review" required>
                            </div>
                           
                            <div class="form-group">
                                <label for="video">Video</label>
                                <input type="file" class="form-control-file" id="video" name="video" accept="video/*" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-action">
                            <button class="btn btn-success" type="submit">Submit</button>
                            <button class="btn btn-danger" type="button" onclick="window.history.back();">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
