<?php
include('config.php');

// Function to handle single file upload
function uploadFile($fieldName, $uploads_dir) {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] != UPLOAD_ERR_OK) {
        echo "<script>alert('No file uploaded or an error occurred for $fieldName.');</script>";
        return null;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $tmp_name = $_FILES[$fieldName]['tmp_name'];
    $fileType = mime_content_type($tmp_name);

    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>alert('Invalid file type for $fieldName. Allowed: JPG, JPEG, PNG, GIF.');</script>";
        return null;
    }

    $originalName = $_FILES[$fieldName]['name'];
    $name = basename($originalName);
    $targetPath = $uploads_dir . $name;

    // Ensure the uploads directory exists
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    if (move_uploaded_file($tmp_name, $targetPath)) {
        return $name; // Return the file name
    } else {
        echo "<script>alert('Failed to upload $fieldName.');</script>";
        return null;
    }
}

// Function to handle multiple file uploads (already defined correctly)
function uploadFiles($fieldName, $uploads_dir) {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'][0] != UPLOAD_ERR_OK) {
        echo "<script>alert('No files uploaded or an error occurred.');</script>";
        return null;
    }

    $uploadedFiles = [];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

    // Loop through all files and upload them
    foreach ($_FILES[$fieldName]['tmp_name'] as $key => $tmp_name) {
        $fileType = mime_content_type($tmp_name);
        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>alert('Invalid file type. Allowed: JPG, JPEG, PNG, GIF.');</script>";
            return null;
        }

        $originalName = $_FILES[$fieldName]['name'][$key];
        $name = basename($originalName);
        $targetPath = $uploads_dir . $name;

        // Ensure the uploads directory exists
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        if (move_uploaded_file($tmp_name, $targetPath)) {
            $uploadedFiles[] = $name; // Add the file name to the list
        }
    }

    return $uploadedFiles ? implode(',', $uploadedFiles) : null; // Return as a comma-separated string
}

$userOptions = [];
$result = $conn->query("SELECT id, name FROM registration");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userOptions[] = $row;
    }
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $status = mysqli_real_escape_string($conn, $_POST['optionsRadios']);
    $userId = intval($_POST['user_id']); // Fetch the selected user's ID
    $userName = ''; 

    // Get the user name based on user_id
    $userResult = $conn->query("SELECT name FROM registration WHERE id = $userId");
    if ($userResult && $userResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();
        $userName = $userRow['name'];
    }

    // Define upload directory
    $uploads_dir = '../uploads/';
    
    // Handle file uploads
    $coverImage = uploadFile('coverImage', $uploads_dir);   // Handle cover image upload
    $mainImage = uploadFile('mainImage', $uploads_dir);     // Handle main image upload
    $images = uploadFiles('images', $uploads_dir);          // Handle multiple images upload

    // Insert data into the database
    $sql = "INSERT INTO client_portfolio (title, cover_image, main_image, images, status, user_id, user_name, created_at) 
            VALUES ('$title', '$coverImage', '$mainImage', '$images', '$status', $userId, '$userName', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<script>window.parent.postMessage({action: 'success'}, '*');</script>";
    } else {
        echo "<script>window.parent.postMessage({action: 'error', message: '" . $conn->error . "'}, '*');</script>";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Forms - Ready Bootstrap Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/css/ready.css">
    <link rel="stylesheet" href="assets/css/demo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Load jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</head>
<body>
<div class="content">
    <div class="container-fluid" style="width:200%;">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form id="portfolioform" method="POST" action="add_client_portfolio.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="text">Portfolio Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title Of Portfolio">
                            </div>
                            <div class="form-group">
                                <label for="user_id">Select User</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">-- Select a User --</option>
                                    <?php foreach ($userOptions as $user) : ?>
                                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <!-- Cover Image Upload -->
                            <div class="form-group">
                                <label for="coverImage">Cover Image</label>
                                <input type="file" class="form-control-file" id="coverImage" name="coverImage" accept="image/*">
                                <div id="coverImagePreview" style="margin-top: 10px;"></div>
                            </div>

                            <!-- Main Image Upload -->
                            <div class="form-group">
                                <label for="mainImage">Main Image</label>
                                <input type="file" class="form-control-file" id="mainImage" name="mainImage" accept="image/*">
                                <div id="mainImagePreview" style="margin-top: 10px;"></div>
                            </div>

                            <!-- Multiple Images Upload -->
                            <!-- <div class="form-group">
                                <label for="images">Additional Images (Multiple)</label>
                                <input type="file" class="form-control-file" id="images" name="images[]" accept="image/*" multiple>
                                <div id="imagesPreview" style="margin-top: 10px;"></div>
                            </div> -->
                            <div class="form-group">
    <label for="images">Additional Images (Multiple)</label>
    <input type="file" class="form-control-file" id="images" name="images[]" accept="image/*" multiple webkitdirectory>
    <div id="imagesPreview" style="margin-top: 10px;"></div>
</div>

<script>
    document.getElementById('images').addEventListener('change', function(event) {
        const files = event.target.files;
        const imagesPreview = document.getElementById('imagesPreview');
        imagesPreview.innerHTML = '';  // Clear previous previews
        
        // Loop through the files and display previews for images
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.style.width = '100px';  // Adjust size for preview
                imgElement.style.margin = '5px';
                imagesPreview.appendChild(imgElement);
            };
            reader.readAsDataURL(file);
        }
    });
</script>


                            <!-- Status -->
                            <div class="form-check">
                                <label>Status</label><br/>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" id="optionsRadios" name="optionsRadios" value="active" checked="">
                                    <span class="form-radio-sign">Active</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" type="radio" id="optionsRadios" name="optionsRadios" value="deactive">
                                    <span class="form-radio-sign">Deactive</span>
                                </label>
                            </div>

                        </div>
                        <div class="card-action">
                            <button class="btn btn-success">Submit</button>
                            <button class="btn btn-danger">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to handle image preview for single and multiple images
    function setupImagePreview(inputId, previewId, isMultiple = false) {
        const fileInput = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewId);

        fileInput.addEventListener("change", function (event) {
            const files = event.target.files;
            previewContainer.innerHTML = ""; // Clear existing preview

            if (isMultiple) {
                // For multiple files
                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.style.maxWidth = "30%";
                        img.style.height = "30%";
                        img.alt = "Preview Image";
                        img.style.border = "1px solid #ddd";
                        img.style.padding = "5px";
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(files[i]);
                }
            } else {
                // For single file
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.maxWidth = "30%";
                    img.style.height = "30%";
                    img.alt = "Preview Image";
                    img.style.border = "1px solid #ddd";
                    img.style.padding = "5px";
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(files[0]);
            }
        });
    }

    // Setup previews for all inputs
    setupImagePreview("coverImage", "coverImagePreview");
    setupImagePreview("mainImage", "mainImagePreview");
    setupImagePreview("images", "imagesPreview", true);  // Multiple images
</script>

<script>
    $(document).ready(function () {
        $('#portfolioform').validate({
            rules: {
                title: {
                    required: true,
                    pattern: /^[A-Za-z\s]+$/,
                },
            },
            messages: {
                title: {
                    required: "Please enter a valid title.",
                    pattern: "Title should only contain letters.",
                },
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            highlight: function (element) {
                $(element).addClass('error');
            },
            unhighlight: function (element) {
                $(element).removeClass('error');
            },
        });
    });
</script>
</body>
</html>
