<?php

include('config.php');

function uploadFile($fieldName, $uploads_dir) {
  if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] != UPLOAD_ERR_OK) {
      echo "<script>alert('File not uploaded for $fieldName or an error occurred.');</script>";
      return null;
  }

  $tmp_name = $_FILES[$fieldName]['tmp_name'];
  $originalName = $_FILES[$fieldName]['name'];
  $name = basename($originalName);
  $targetPath = $uploads_dir . $name;

  // Ensure the uploads directory exists
  if (!is_dir($uploads_dir)) {
      mkdir($uploads_dir, 0777, true);
  }

  // Validate file type
  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
  $fileType = mime_content_type($tmp_name);

  if (!in_array($fileType, $allowedTypes)) {
      echo "<script>alert('Invalid file type for $fieldName. Allowed: JPG,JPEG, PNG, GIF.');</script>";
      return null;
  }

  if (!move_uploaded_file($tmp_name, $targetPath)) {
      echo "<script>alert('Failed to move uploaded file: $originalName');</script>";
      return null;
  }

  return $name; // Return file name for database storage
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
    $facebook = mysqli_real_escape_string($conn, $_POST['facebook']);


    // Handle file uploads
    $uploads_dir = '../uploads/';
    $image = uploadFile('image', $uploads_dir);
   

    // Insert data into the database
    $sql = "INSERT INTO preferred_vendors (title, name, description, instagram, facebook, image, created_at) 
            VALUES ('$title','$name', '$description', '$instagram','$facebook', '$image', NOW())";

if ($conn->query($sql) === TRUE) {
  // Success message returned to JavaScript
  echo "<script>window.parent.postMessage({action: 'success'}, '*');</script>";
} else {
  echo "<script>window.parent.postMessage({action: 'error', message: '" . $conn->error . "'}, '*');</script>";
}

    $conn->close();
}

// Function to handle file uploads
// function uploadFile($inputName, $uploads_dir) {
//     if (!empty($_FILES[$inputName]['name'])) {
//         $fileName = basename($_FILES[$inputName]['name']);
//         $targetFilePath = $uploads_dir . $fileName;

//         if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetFilePath)) {
//             return $targetFilePath;
//         } else {
//             return null;
//         }
//     }
//     return null;
// }
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Rhipo Admin</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<link rel="stylesheet" href="assets/css/demo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Load jQuery -->
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
<div class="content">
					<div class="container-fluid" style="width:200%;">
						<div class="row">
							<div class="col-md-6">
								<div class="card">
                <form id="portfolioform" method="POST" action="add_preferred_vendor.php" enctype="multipart/form-data">

									<div class="card-body">
                                  
										<div class="form-group">
											<label for="text">Title</label>
											<input type="text" class="form-control" id="title" name="title" placeholder="Enter Title Of Vendor">
										</div>
                      <div class="form-group">
											<label for="text">Vendor Name</label>
											<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name Of Vendor">
										</div>
										<div class="form-group">
												<label for="comment">Description</label>
												<textarea class="form-control" id="description" name="description" rows="5" required>

												</textarea>
											</div>										
                      <div class="form-group">
											<label for="text">Instagram Link</label>
											<input type="text" class="form-control" id="instagram" name="instagram" placeholder="Enter Instagram Link">
										</div>

                    <div class="form-group">
											<label for="text">Facebook Link</label>
											<input type="text" class="form-control" id="facebook" name="facebook" placeholder="Enter Facebook Link">
										</div>
                  <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                    <div id="ImagePreview" style="margin-top: 10px;"></div>
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
  // Function to handle image preview
  function setupImagePreview(inputId, previewId) {
    const fileInput = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewId);

    fileInput.addEventListener("change", function (event) {
      const file = event.target.files[0];
      previewContainer.innerHTML = ""; // Clear existing preview

      if (file) {
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
        reader.readAsDataURL(file);
      }
    });
  }

  // Setup previews for all inputs
  
  setupImagePreview("image", "ImagePreview");
 
  </script>

<script>
  $(document).ready(function () {
  $('#portfolioform').validate({
    rules: {
      title: {
        required: true,
        pattern: /^[A-Za-z\s]+$/,
      },
      name: {
        required: true,
        pattern: /^[A-Za-z\s]+$/,
      },
     
    },
    messages: {
      title: {
        required: "Please enter a valid title with only letters.",
        pattern: "title should only contain letters.",
      },
      name: {
        required: "Please enter a valid name with only letters.",
        pattern: "Name should only contain letters.",
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


<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chartist/chartist.min.js"></script>
<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
</html>