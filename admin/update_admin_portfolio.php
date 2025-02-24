<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM admin_portfolio WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Portfolio not found!");
    }
    $stmt->close();
} else {
    die("Invalid request!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $description = ($_POST['description']);
    $status = $conn->real_escape_string($_POST['status']);

    // Handle file uploads
    $uploads = [];
    $imageFields = [
        'sliderImage1' => 'slider_image1',
        'sliderImage2' => 'slider_image2',
        'sliderImage3' => 'slider_image3',
    ];

    foreach ($imageFields as $inputName => $dbColumn) {
        if (!empty($_FILES[$inputName]['name'])) {
            $filename = basename($_FILES[$inputName]['name']);
            $targetPath = "../uploads/" . $filename;
            
            // Validate file type
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                die("Invalid file type for $inputName. Only JPG, JPEG, PNG, and GIF are allowed.");
            }

            if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
                $uploads[$dbColumn] = $filename;
            } else {
                die("Failed to upload $inputName.");
            }
        }
    }

    // Build update query
    $sql = "UPDATE admin_portfolio SET 
            title = ?, 
            description = ?, 
            status = ?";
    $params = [$title, $description, $status];
    $types = "sss";

    // Add image fields to the query if they are uploaded
    foreach ($uploads as $column => $filename) {
        $sql .= ", $column = ?";
        $params[] = $filename;
        $types .= "s";
    }
    $sql .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>alert('Portfoio updated successfully!');</script>";
        echo "<script>window.location.href = 'update_admin_portfolio.php?id=$id';</script>";
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
    <h2>Update Portfolio</h2>
    <form id="portfolioform" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="title">Portfolio Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required><?php echo ($row['description']); ?></textarea>
        </div>

        <!-- Repeat for other images -->
        <?php for ($i = 1; $i <= 3; $i++) { ?>
            <div class="form-group">
                <label>Slider Image <?php echo $i; ?></label>
                <img src="../uploads/<?php echo $row['slider_image' . $i]; ?>" alt="Slider Image <?php echo $i; ?>" style="max-width: 30%; margin-top: 10px;">
                <input type="file" class="form-control-file" name="sliderImage<?php echo $i; ?>" accept="image/*">
            </div>
        <?php } ?>

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
</script>        </div>
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
