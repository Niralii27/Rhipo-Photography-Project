<?php
include('header.php');

include('config.php');

$user_id = $_SESSION['user_id'] ?? null;

// Number of items to show per page (for initial load)
$items_per_page = 9;

// Get the current page number from the URL (default is 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting point for fetching items
$start_from = ($page - 1) * $items_per_page;

// Query to fetch portfolio items for the logged-in user
$portfolio_items = [];
if ($user_id) {
    // Check if "Load More" is clicked
    $load_more = isset($_GET['load_more']) && $_GET['load_more'] == 'true';

    // If "Load More" is clicked, fetch all items
    if ($load_more) {
        $stmt = $conn->prepare("SELECT * FROM client_portfolio WHERE user_id = ? AND status = 'active'");
        $stmt->bind_param("i", $user_id);
    } else {
        // Otherwise, limit to $items_per_page
        $stmt = $conn->prepare("SELECT * FROM client_portfolio WHERE user_id = ? AND status = 'active' LIMIT ?, ?");
        $stmt->bind_param("iii", $user_id, $start_from, $items_per_page);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $portfolio_items = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}

// Total number of portfolio items for the logged-in user
$total_items_query = "SELECT COUNT(*) FROM client_portfolio WHERE user_id = ? AND status = 'active'";
$total_stmt = $conn->prepare($total_items_query);
$total_stmt->bind_param("i", $user_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_items = $total_result->fetch_row()[0];
$total_stmt->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width: device-width, initial-scale=1.0">
    <title>Rhipo Photography</title>
    <link rel="icon" href="images/logo2.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=The+New+Elegance&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;600;700&family=Italiana&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=New+Elegance&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: 'The New Elegance';
            src: url('assets/fonts/TheNewElegance-CondensedRegular.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Royal Wedding';
            src: url('assets/fonts/RoyalWedding-Regular.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
            /* Disable horizontal scrolling */
        }

        .content-wrapper {
            height: auto;
            position: absolute;
            left: 7%;
            right: 5%;
            bottom: 4%;
            background: rgba(42.06, 42.06, 42.06, 0.30);
            border-top-right-radius: 150px;
            backdrop-filter: blur(54px);
            padding: clamp(18px, 2vw, 18px) clamp(40px, 5vw, 75px);
        }

        .featured-title {
            color: #CDCDCD;
            font-size: clamp(40px, 5vw, 70px);
            font-family: 'Royal Wedding';
            font-weight: 400;
            margin-bottom: 10px;
        }

        .post-title {
            color: white;
            font-size: clamp(20px, 2.5vw, 28px);
            font-family: 'The New Elegance';
            font-weight: 400;
            text-transform: capitalize;
            margin-bottom: 10px;
            letter-spacing: .1rem;
        }

        .post-description {
            color: #CDCDCD;
            font-size: clamp(16px, 1.5vw, 20px);
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 20px;
            font-family: 'Alexandria';
        }


        .content-section {
            display: none;
            /* Hide all content sections by default */
        }

        #wednesdays-content {
            display: block;
            /* Make Weddings content visible by default */
        }

        /* Container holding the items */
        /* Container holding the items */
        .container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Each individual item */
        .item {
            width: 30%;
            /* Default: 3 items per row */
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }


        /* Main image styling */
        .main-image {
            width: 100%;
            /* Adjust the width to fill the container */
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        /* Text content (title, subtitle) */
        .text {
            display: flex;
            flex-direction: column;
        }

        /* Title and icon */
        .title {
            display: flex;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
            margin-top: 5%;
            color: rgba(0, 0, 0, 0.81);
            font-family: 'The New Elegance';
        }

        .icon {
            width: 34px;
            /* Adjust size of the icon */
            height: 34px;
            cursor: pointer;
            margin-left: 90%;
            margin-top: -10%;
            /* Space between title and icon */
        }

        /* Subtitle */
        .subtitle {
            font-size: 16px;
            color: #666;
            font-family: 'Alexandria';
            font-weight: 400;
            line-height: 19.5px;
            color: #000000;
        }

        /* Responsive styles */

        /* Medium-sized screens (tablet, small laptops) */
        @media (max-width: 768px) {
            .item {
                width: 45%;
                /* 2 items per row */
            }
        }

        /* Small screens (mobile phones) */
        @media (max-width: 480px) {
            .item {
                width: 100%;
                /* 1 item per row */
            }

            .main-image {
                width: 100%;
                /* Ensure the main image fits within the container */
            }

            .title {
                font-size: 16px;
            }

            .subtitle {
                font-size: 12px;
            }

            .icon {
                width: 20px;
                /* Smaller icons on mobile */
                height: 20px;
            }
        }

        .btn-square {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            background-color: #9D8161;
            /* Background color */
            color: #ffffff;
            /* Text color - always white */
            font-family: 'Alexandria', sans-serif;
            font-size: 16px;
            font-weight: 700;
            border: 2px solid #9D8161;
            border-radius: 4px;
            gap: 8px;
            text-decoration: none;
            /* Remove underline if used with anchor tag */
            cursor: pointer;
            /* Pointer cursor on hover */
            margin-left: 45%;
        }

        .btn-square .btn-arrow {
            color: #ffffff;
            /* Ensures arrow icon is also white */
        }

        #backToTop {
            right: 40px;
            /* Default position for larger screens */
        }

        /* Responsive positioning for smaller screens */
        @media (max-width: 768px) {
            #backToTop {
                left: 450px;
                /* Adjusted position for medium screens */
            }
        }

        @media (max-width: 480px) {
            #backToTop {
                left: 200px;
                /* Further adjust for very small screens */
            }
        }

        .no-portfolio {
            text-align: center;
            font-size: 36px;
            font-family: 'Alexandria';
            color: #666666;
            font-weight: bold;
            background-color: #f8f8f8;
            padding: 30px 40px;
            border-radius: 10px;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
            position: relative;
            left: 1%;
            /* Add left margin */
        }

        /* Responsive Adjustments */
        @media screen and (max-width: 768px) {
            .no-portfolio {
                font-size: 28px;
                /* Reduce font size for tablets */
                padding: 20px 30px;
                /* Reduce padding for smaller screens */
                max-width: 90%;
                /* Set max-width to 90% of screen */
                left: 0;
                /* Remove left margin */
            }
        }

        @media screen and (max-width: 480px) {
            .no-portfolio {
                font-size: 24px;
                /* Further reduce font size for mobile */
                padding: 15px 20px;
                /* Further reduce padding */
                max-width: 85%;
                /* Set max-width to 85% of screen */
                left: 0;
                /* Ensure no left margin on mobile */
            }
        }
        .main {
            background-repeat: no-repeat !important;
            background-position: center !important;
            height: 27rem;
            width: 100%;
            background-size: cover !important;
            position: relative;
        }
    </style>
</head>

<body>

    <div class="main" style="background:url(images/client2.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Rhipo Photography</div>
                <div class="post-title" style="margin-top:-2%;">Home > Client Portfolio</div>
                <div class="post-description" style="font-family: 'Alexandria';">
                    At RHIPO Photography, we have had the privilege of working with numerous talented individuals,
                    but few have
                    left as profound an impression as the exceptional Sachinmayee Menon.
                </div>
            </div>
        </div>
    </div>



    <!-- Additional Image Section -->
    <div style="padding:2rem 0 0 0;" class="d-flex justify-content-center">
        <img src="images/client_Showcase.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div>

    <div class="container">
        <?php if (!empty($portfolio_items)): ?>
            <?php foreach ($portfolio_items as $item): ?>
                <div class="item">
                    <img src="uploads/<?= htmlspecialchars($item['cover_image']); ?>" alt="Portfolio Image" class="main-image">
                    <div class="text">
                        <h3 class="title"><?= htmlspecialchars($item['title']); ?></h3>
                        <img src="images/button1.png" alt="Icon" class="icon" id="icon"
                            onclick="openClientPage(<?= $item['id']; ?>)">
                        <script>
                            function openClientPage(clientId) {
                                // Replace 'client_inner.php' with the actual URL of your inner page
                                window.location.href = `client_inner.php?clientId=${clientId}`;
                            }
                        </script>
                        <p class="subtitle"><?= date("F j, Y", strtotime($item['created_at'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-portfolio">
                <p>
                    Currently, no portfolio is available for you. Once the admin creates your portfolio, you will be able to view it here. </p>
            </div>

    </div>

<?php endif; ?>
</div>
<?php if (isset($user_id) && $user_id && !$load_more && $page < ceil($total_items / $items_per_page)): ?>
    <div><br>
        <a href="?page=<?= $page + 1; ?>&load_more=true" class="btn-square" style="color: #ffffff;">
            Load More...
            <img style="color: #ffffff;" src="images/down_arrow.png" alt="Arrow" class="btn-arrow">
        </a>
    </div>
<?php endif; ?>
<!-- "Back to Top" Button -->
<div id="backToTop" style="display: none; position: fixed; bottom: 20px; right: 40px;">
    <a href="#" class="btn-square" style="color: #ffffff;">
        <img style="color: #ffffff;" src="images/up_arrow.png" alt="Arrow" class="btn-arrow">
    </a>
</div>
<script>
    // When the "Load More" button is clicked, show the "Back to Top" button
    window.addEventListener('scroll', function() {
        var backToTopButton = document.getElementById('backToTop');
        if (window.scrollY > 300) { // Show button after scrolling down 300px
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });

    // Smooth scroll to top when the "Back to Top" button is clicked
    document.getElementById('backToTop').addEventListener('click', function(event) {
        event.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>

<br></br>
<script>
</script>
<?php
include('left_sidenav.php');
include('right_sidebar.php');
include('footer.php');
?>
</body>

</html>