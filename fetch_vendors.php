<?php
include('header.php');
// Database connection
include('config.php');

// Fetch all vendors from the database
$queryVendors = "SELECT * FROM preferred_vendors";
$vendorsResult = $conn->query($queryVendors);

$vendors = [];
if ($vendorsResult->num_rows > 0) {
    while ($row = $vendorsResult->fetch_assoc()) {
        $vendors[] = $row;
    }
}

// Total number of vendors
$totalVendors = count($vendors);

// Define items per page
$itemsPerPage = 3;

// Calculate the total number of pages
$totalPages = ceil($totalVendors / $itemsPerPage);

// Get current page number from query parameters or default to 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset based on the current page
$offset = ($currentPage - 1) * $itemsPerPage;

// Slice the vendors array to get only the items for the current page
$currentVendors = array_slice($vendors, $offset, $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Pagination</title>
    <style>
        .vendor-item {
            margin: 10px;
            text-align: center;
            flex: 0 0 30%;
            max-width: 30%;
        }
        .vendor-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        #slider-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .hidden-vendor-data {
            display: none;
        }
    </style>
</head>
<body>
<section class="image-text-section">
    <div class="container">
        <div class="row" style="display: flex; justify-content: center; align-items: center; position: relative;">
            <!-- Left Arrow -->
            <button id="left-arrow" class="arrow-icon left-arrow" style="background: none; border: none;">
                <img src="images/left_vector.png" alt="Left Arrow">
            </button>

            <!-- Dynamic Slider Content -->
            <div id="slider-container" class="slider-container">
                <!-- Vendor items will be populated here by JavaScript -->
            </div>

            <!-- Right Arrow -->
            <button id="right-arrow" class="arrow-icon right-arrow" style="background: none; border: none;">
                <img src="images/right_vector.png" alt="Right Arrow">
            </button>
        </div>
    </div>
</section>

<!-- Hidden vendor data as JSON (for JavaScript usage) -->
<script>
    const vendors = <?php echo json_encode($vendors); ?>;
    const itemsPerPage = <?php echo $itemsPerPage; ?>;
    let currentPage = 1; // Start from the first page

    // Function to display the vendors based on the current page
    function displayVendors() {
        // Calculate the start index and end index for the current page
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const currentVendors = vendors.slice(startIndex, endIndex);

        // Clear the slider content
        const sliderContainer = document.getElementById('slider-container');
        sliderContainer.innerHTML = '';

        // Append the vendor items to the slider container
        currentVendors.forEach(vendor => {
            const vendorElement = document.createElement('div');
            vendorElement.classList.add('vendor-item');
            vendorElement.innerHTML = `
                <img src="uploads/${vendor.image}" alt="${vendor.title}">
                <h2>${vendor.name}</h2>
                <h3>${vendor.title}</h3>
            `;
            sliderContainer.appendChild(vendorElement);
        });
    }

    // Function to handle the left arrow click (previous page)
    document.getElementById('left-arrow').addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            displayVendors(); // Update the vendor list
        }
    });

    // Function to handle the right arrow click (next page)
    document.getElementById('right-arrow').addEventListener('click', function () {
        if (currentPage * itemsPerPage < vendors.length) {
            currentPage++;
            displayVendors(); // Update the vendor list
        }
    });

    // Initialize the vendor display
    displayVendors();
</script>
</body>
</html>
