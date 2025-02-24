<?php
session_start();
require 'config.php'; // Include your DB connection file

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM registration WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $number = $_POST['number']; // Capture the phone number from the form
    $image_name = $user['profile_image']; // Default to current image if no new image is uploaded

    // Handle image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $image = $_FILES['profile_image'];
        $upload_dir = 'uploads/';
        $image_name = basename($image['name']); // Extract only the filename
        $image_path = $upload_dir . basename($image['name']);

        if (!move_uploaded_file($image['tmp_name'], $image_path)) {
            $error = "Failed to upload image.";
        }
    }

    // Update user data
    $update_query = "UPDATE registration SET name = ?, profile_image = ?, number = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssi", $name, $image_name, $number, $user_id); // Correct binding

    if ($update_stmt->execute()) {
        // Update session with new profile image and other details
        $_SESSION['name'] = $name;
        $_SESSION['profile_image'] = $image_name; 
        $_SESSION['number'] = $number; 

        header("Location: profile.php"); // Redirect to profile page to see changes
        exit;
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #ffffff;
        }
        .card {
            width: 350px;
            background-color: #efefef;
            border: none;
        }
        .image {
            position: relative;
        }
        #profileImage {
            border-radius: 50%;
            height: 100px;
            width: 100px;
        }
        .change-image-btn {
            position: absolute;
            bottom: 175px; /* Adjust placement */
            right: 85px;  /* Adjust placement */
            background-color: #9D8161;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .change-image-btn:hover {
            background-color: #9D8161;
            color: #ffffff;
            border-color: #9D8161;
        }
        .form-control {
            width: 100%;
            font-size: 16px;
        }
        .change-password-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .change-password-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
    <div class="card p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="image d-flex flex-column justify-content-center align-items-center">
                <img src="<?php echo !empty($_SESSION['profile_image']) ? htmlspecialchars($_SESSION['profile_image']) : 'https://i.imgur.com/wvxPV9S.png'; ?>" id="profileImage" />
                <button type="button" class="change-image-btn" onclick="triggerImageUpload()">
                    <i class="fas fa-camera"></i>
                </button>
                <!-- Editable Name -->
                <input type="text" name="name" class="form-control mt-3 text-center" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" placeholder="Enter your name" />
                <!-- Editable Phone Number -->
                <input type="text" name="number" class="form-control mt-3 text-center" value="<?php echo htmlspecialchars($_SESSION['number']); ?>" placeholder="Enter your phone number" />

                <span class="idd mt-2"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                <!-- Change Password Link -->
                <a href="change_password.php" class="change-password-link mt-3">Change Password</a>
            </div>

            <!-- Hidden file input for image upload -->
            <input type="file" id="profileImageInput" name="profile_image" class="d-none" onchange="previewImage(event)">
            
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-4 w-50" style="background-color: #9D8161;margin-left: 27%;">Save Changes</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to trigger the file input
    function triggerImageUpload() {
        document.getElementById('profileImageInput').click();
    }

    // Function to preview the selected image
    function previewImage(event) {
        const image = document.getElementById('profileImage');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                image.src = e.target.result; // Set the image preview
            };
            reader.readAsDataURL(file);
        }
    }
</script>
</body>
</html>
