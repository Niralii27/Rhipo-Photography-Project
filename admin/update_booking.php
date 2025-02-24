<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM booking WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Booking not found!");
    }
    $stmt->close();
} else {
    die("Invalid request!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $hours = trim($_POST['hours']);
    $fees = trim($_POST['fees']);
    $description = trim($_POST['description']);

    // Sanitize inputs
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $hours = htmlspecialchars($hours, ENT_QUOTES, 'UTF-8');
    $fees =  htmlspecialchars($fees, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($description), ENT_QUOTES, 'UTF-8');

    // Convert description to bullet points (HTML format)
    $description_lines = explode("\n", $description);
    $description_html = '<ul>';
    foreach ($description_lines as $line) {
        if (!empty(trim($line))) {
            $description_html .= '<li>' . htmlspecialchars($line) . '</li>';
        }
    }
    $description_html .= '</ul>';

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
    $sql = "UPDATE booking SET title = ?, hours = ?, fees = ?, description = ?";
    $params = [$title, $hours, $fees, $description_html];
    $types = "ssss";

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
        echo "<script>alert('Booking updated successfully!');</script>";
        echo "<script>window.location.href = 'update_booking.php?id=$id';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Booking</title>
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
    <h2>Update Booking</h2>
    <form id="reviewForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="hours">Hours</label>
            <input type="text" class="form-control" id="hours" name="hours" value="<?php echo htmlspecialchars($row['hours'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="fees">Fees</label>
            <input type="text" class="form-control" id="fees" name="fees" value="<?php echo htmlspecialchars($row['fees'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter Description (one line per bullet point)"><?php echo htmlspecialchars_decode(strip_tags($row['description']), ENT_QUOTES); ?></textarea>
            </div>

        <div class="form-group">
            <label>Client Image</label>
            <img src="../uploads/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image" style="max-width: 30%; margin-top: 10px;">
            <input type="file" class="form-control-file" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <button class="btn btn-success">Update</button>
            <a href="javascript:void(0);" class="btn btn-danger" onclick="closeParentModal()">Cancel</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#reviewForm').validate({
            rules: {
                hours: { required: true },
                title: { required: true },
                fees: { required: true },
                description: { required: true },
            },
            messages: {
                hours: { required: "Please enter hours" },
                title: { required: "Please enter a title" },
                fees: { required: "Please enter fees" },
                description: { required: "Please enter a description" },
            }
        });
    });

    function closeParentModal() {
        // Close modal in parent window
        window.parent.postMessage({ action: 'closeModal' }, '*');
    }
</script>
</body>
</html>
