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
      echo "<script>alert('Invalid file type for $fieldName. Allowed: JPG, PNG, GIF.');</script>";
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
    $mainDescription = mysqli_real_escape_string($conn, $_POST['mainDescription']);
    $innerDescription = mysqli_real_escape_string($conn, $_POST['innerDescription']);
    $status = mysqli_real_escape_string($conn, $_POST['optionsRadios']);

    // Handle file uploads
    $uploads_dir = '../uploads/';
    $coverImage = uploadFile('coverImage', $uploads_dir);
    $mainImage = uploadFile('mainImage', $uploads_dir);
    $innerImage1 = uploadFile('innerImage1', $uploads_dir);
    $innerImage2 = uploadFile('innerImage2', $uploads_dir);
    $innerImage3 = uploadFile('innerImage3', $uploads_dir);
    $innerImage4 = uploadFile('innerImage4', $uploads_dir);

    // Insert data into the database
    $sql = "INSERT INTO blog (title, description, cover_image, main_image, inner_image1, inner_image2, inner_image3, inner_image4, inner_description, status, created_at) 
            VALUES ('$title', '$mainDescription', '$coverImage', '$mainImage', '$innerImage1', '$innerImage2', '$innerImage3', '$innerImage4', '$innerDescription', '$status', NOW())";

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
                <form id="blogForm" method="POST" action="add_blog.php" enctype="multipart/form-data">

									<div class="card-body">
										<div class="form-group">
											<label for="text">Blog Title</label>
											<input type="text" class="form-control" id="title" name="title" placeholder="Enter Title Of Blog">
										</div>
										<div class="form-group">
												<label for="comment">Main Description</label>
												<textarea class="form-control" id="mainDescription" name="mainDescription" rows="5" required>

												</textarea>
											</div>										
						
											<div class="form-group">  
                    <label for="coverImage">Cover Image</label>
                    <input type="file" class="form-control-file" id="coverImage" name="coverImage" accept="image/*">
                    <div id="coverImagePreview" style="margin-top: 10px;"></div>
                  </div>

                  <div class="form-group">
                    <label for="mainImage">Main Image</label>
                    <input type="file" class="form-control-file" id="mainImage" name="mainImage" accept="image/*">
                    <div id="mainImagePreview" style="margin-top: 10px;"></div>
                  </div>

                  <div class="form-group">
                    <label for="innerImage1">Inner Image1</label>
                    <input type="file" class="form-control-file" id="innerImage1" name="innerImage1" accept="image/*">
                    <div id="innerImage1Preview" style="margin-top: 10px;"></div>
                  </div>

                  <div class="form-group">
                    <label for="innerImage2">Inner Image2</label>
                    <input type="file" class="form-control-file" id="innerImage2" name="innerImage2" accept="image/*">
                    <div id="innerImage2Preview" style="margin-top: 10px;"></div>
                  </div>

                  <div class="form-group">
                    <label for="innerImage3">Inner Image3</label>
                    <input type="file" class="form-control-file" id="innerImage3" name="innerImage3" accept="image/*">
                    <div id="innerImage3Preview" style="margin-top: 10px;"></div>
                  </div>

                  <div class="form-group">
                    <label for="innerImage4">Inner Image4</label>
                    <input type="file" class="form-control-file" id="innerImage4" name="innerImage4" accept="image/*">
                    <div id="innerImage4Preview" style="margin-top: 10px;"></div>
                  </div>

											<div class="form-group">
												<label for="comment">Inner Description</label>
												<textarea class="form-control" id="innerDescription" name="innerDescription" rows="5">

												</textarea>
											</div>
											<div class="form-check">
											<label>Status</label><br/>
											<label class="form-radio-label">
												<input class="form-radio-input" type="radio" id="optionsRadios" name="optionsRadios" value="active"  checked="">
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
  setupImagePreview("coverImage", "coverImagePreview");
  setupImagePreview("mainImage", "mainImagePreview");
  setupImagePreview("innerImage1", "innerImage1Preview");
  setupImagePreview("innerImage2", "innerImage2Preview");
  setupImagePreview("innerImage3", "innerImage3Preview");
  setupImagePreview("innerImage4", "innerImage4Preview");
  </script>

<script>
  $(document).ready(function () {
  $('#blogForm').validate({
    rules: {
      title: {
        required: true,
        pattern: /^[A-Za-z\s]+$/,
      },
     
     
    },
    messages: {
      title: {
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