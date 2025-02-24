<?php
include('config.php');

// Fetch portfolio titles and IDs for the dropdown
$portfolioQuery = "SELECT id, title FROM admin_portfolio";
$portfolioResult = $conn->query($portfolioQuery);

function uploadFile($fieldName, $uploads_dir) {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] != UPLOAD_ERR_OK) {
        echo "<script>alert('File not uploaded for $fieldName or an error occurred.');</script>";
        return null;
    }

    $tmp_name = $_FILES[$fieldName]['tmp_name'];
    $originalName = $_FILES[$fieldName]['name'];
    $name = basename($originalName);
    $targetPath = $uploads_dir . $name;

    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $fileType = mime_content_type($tmp_name);

    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>alert('Invalid file type for $fieldName. Allowed: JPG, PNG, GIF.');</script>";
        return null;
    }

    if (!move_uploaded_file($tmp_name, $targetPath)) {
        echo "<script>alert('Failed to move uploaded file: $originalName');</script>";
        return null;
    }

    return $name;
}

function uploadMultipleFiles($fieldName, $uploads_dir) {
    $uploadedFiles = [];
    if (!isset($_FILES[$fieldName]) || empty($_FILES[$fieldName]['name'][0])) {
        echo "<script>alert('No files uploaded for $fieldName.');</script>";
        return $uploadedFiles;
    }

    foreach ($_FILES[$fieldName]['tmp_name'] as $key => $tmp_name) {
        $originalName = $_FILES[$fieldName]['name'][$key];
        $name = basename($originalName);
        $targetPath = $uploads_dir . $name;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $fileType = mime_content_type($tmp_name);

        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>alert('Invalid file type for $originalName. Allowed: JPG, PNG, GIF.');</script>";
            continue;
        }

        if (move_uploaded_file($tmp_name, $targetPath)) {
            $uploadedFiles[] = $name;
        } else {
            echo "<script>alert('Failed to upload file: $originalName');</script>";
        }
    }

    return $uploadedFiles;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $portfolioID = $_POST['portfolioID'];
    $portfolioTitle = $_POST['portfolioTitle'];

    $uploads_dir = '../uploads/';
    $mainImage = uploadFile('mainImage', $uploads_dir);
    $uploadedImages = uploadMultipleFiles('Images', $uploads_dir);
    $imagesJson = json_encode($uploadedImages);

    $sql = "INSERT INTO admin_portfolio_images (portfolio_id, portfolio_title, main_image, images, created_at) 
            VALUES ('$portfolioID', '$portfolioTitle', '$mainImage', '$imagesJson', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Portfolio Album Images inserted successfully.');
    window.location.href = 'add_admin_portfolio_images.php?status=success'; // Add a status query parameter
        </script>";
        exit; // Ensure the script stops after redirect

    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Portfolio</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form id="portfolioform" method="POST" action="add_admin_portfolio_images.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="portfolioID">Select Portfolio Title</label>
                            <select id="portfolioID" name="portfolioID" class="form-control" required>
                                <option value="" selected disabled>Select Portfolio</option>
                                <?php
                                if ($portfolioResult->num_rows > 0) {
                                    while ($row = $portfolioResult->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "' data-title='" . $row['title'] . "'>" . $row['title'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No portfolios available</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" id="portfolioTitle" name="portfolioTitle">
                        </div>

                        <div class="form-group">
                            <label for="mainImage">Main Image</label>
                            <input type="file" class="form-control-file" id="mainImage" name="mainImage" accept="image/*" required>
                            <div id="mainImagePreview" style="margin-top: 10px;"></div>
                        </div>

                        <div class="form-group">
                            <label for="Images">Images</label>
                            <input type="file" class="form-control-file" id="Images" name="Images[]" accept="image/*" multiple>
                            <div id="ImagesPreview" style="margin-top: 10px;"></div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("portfolioID").addEventListener("change", function() {
    const selectedOption = this.options[this.selectedIndex];
    document.getElementById("portfolioTitle").value = selectedOption.getAttribute("data-title");
});

function setupImagePreview(inputId, previewId) {
    const fileInput = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewId);

    fileInput.addEventListener("change", function (event) {
        const files = event.target.files;
        previewContainer.innerHTML = "";

        Array.from(files).forEach(file => {
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.maxWidth = "30%";
                    img.style.height = "30%";
                    img.alt = "Preview Image";
                    img.style.marginRight = "10px";
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
}

setupImagePreview("mainImage", "mainImagePreview");
setupImagePreview("Images", "ImagesPreview");
</script>
</body>
</html>
