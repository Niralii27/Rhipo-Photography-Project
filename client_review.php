<?php
include('header.php');
include('config.php');

$initial_items = 6;

// Check if "Load More" button is clicked
$load_more = isset($_GET['load_more']) && $_GET['load_more'] === 'true';

// SQL query to fetch items
if ($load_more) {
    // Fetch all items if Load More is clicked
    $sql = "SELECT * FROM review";
} else {
    // Fetch only initial items
    $sql = "SELECT * FROM review LIMIT $initial_items";
}

$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Store reviews in an array
$reviews = $result->fetch_all(MYSQLI_ASSOC);

// Total number of reviews
$total_reviews_query = "SELECT COUNT(*) AS total FROM review";
$total_result = $conn->query($total_reviews_query);
$total_reviews = $total_result->fetch_assoc()['total'];
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
        }

        .container {
            width: 100%;
            /* background: white; */
            position: relative;
        }

        /* .hero-section {
            width: 100%;
            height: min(616px, 80vh);
            position: relative;
        }

        .hero-background {
            width: 100%;
            height: 150%;
            background: #D9D9D9;
            position: absolute;
        }

        .hero-image {
            width: 150%;
            font-family: 'italic';
            height: auto;
            margin-left: -25%;
            position: absolute;
            top: -20px;
        } */

        .content-wrapper {
            /* width: 90%; */
            /* max-width: 1560px; */
            height: auto;
            /* min-height: 300px; */
            position: absolute;
            left: 7%;
            right: 5%;
            /* transform: translate(-33%,); */
            /* top: 195px; */
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
            text-transform: capitalize;
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

        .post-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #CDCDCD;
            font-size: 16px;
            font-family: Alexandria;
            font-weight: 400;
        }

        .post-meta img {
            width: 36px;
            height: 36px;
            border-radius: 28px;
        }

        /* .additional-image-wrapper {
            margin-top: calc(min(616px, 80vh) + 50px);
            text-align: center;
        } */
/* 
        .additional-image-wrapper img {
            max-width: 100%;
            height: auto;
        } */

        @media screen and (max-width: 1680px) {
            /* .content-wrapper {
                left: 5%;
                width: 90%;
                padding: 40px 100px;
                top: 27%;
            } */

            /* .additional-image-wrapper {
                margin-top: 40%;
            } */
        }

        @media screen and (max-width: 1600px) {
            /* .content-wrapper {
                left: 5%;
                width: 90%;
                padding: 40px 100px;
                top: 25%;
            } */

            /* .additional-image-wrapper {
                margin-top: 43%;
            } */
        }

        @media screen and (max-width: 1200px) {
            /* .content-wrapper {
                left: 5%;
                width: 90%;
                top: 20%;
                padding: 40px 100px;
            } */

            /* .additional-image-wrapper {
                margin-top: 50%;
            } */
        }

        @media screen and (max-width: 768px) {
            /* .hero-image {
                width: 200%;
                margin-left: -50%;
            } */
/* 
            .content-wrapper {
                padding: 30px 50px;
                border-top-left-radius: 80px;
                top: 17%;
            } */

            /* .additional-image-wrapper {
                margin-top: 60%;
            } */
        }

        @media screen and (max-width: 480px) {
            /* .hero-image {
                width: 250%;
                margin-left: -75%;
            } */

            /* .content-wrapper {
                padding: 20px 25px;
                border-top-left-radius: 50px;
                top: 10%;
                width: 80vw;
            } */

            /* .additional-image-wrapper {
                margin-top: 80%;
            } */

            .post-meta {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .content-section {
            display: none;
            /* Hide all content sections by default */
        }

        #wednesdays-content {
            display: block;
            /* Make Weddings content visible by default */
        }

        /* Container holding the table */
        .table-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 0 auto;
            margin-left: 20%;
            margin-right: 20%;
        }



        /* Row to hold two items */
        .table-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        /* Individual table item */
        .table-item {
            /* width: 48%; */
            /* Adjust width to fit 2 items per row */
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            /* Prevents overflow */
            position: relative;
        }
        

        /* Main image styling */
        .main-image {
            width: 100%;
            height: 300px;
            /* Set height for the main image */
            object-fit: cover;
            /* Ensures image covers the container */
            transition: transform 0.3s ease, filter 0.3s ease;
            /* Smooth hover effect */
        }

        .main-image:hover {
            transform: scale(1.1);
            /* Zoom effect */
            filter: blur(3px);
            /* Blur effect */
        }

        .table-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            /* Adjust the height of the gradient */
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
            z-index: 1;
            /* Ensures the gradient is above the image */
            pointer-events: none;
            /* Prevents interaction with the overlay */
        }
       

        /* Text container over the main image */
        .text {
            position: absolute;
            z-index: 2;
            /* Ensure text appears above the gradient */
            bottom: 10px;
            left: 10px;
            right: 10px;
            color: #fff;
            /* Text color for contrast */
        }

        /* Title and icon styling */
        .title {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 2000;
            margin-bottom: 10px;
            cursor: pointer;
            font-family: 'The New Elegance';
            line-height: 33px;
            letter-spacing: 0.02em;
        }

        .icon {
            width: 40px;
            /* Icon size */
            height: 40px;
            margin-left: 10px;
            /* Space between title and icon */
        }

        /* Subtitle and date text */
        .subtitle,
        .date {
            font-size: 18px;
            margin-bottom: -5px;
            font-family: 'Alexandria';
            font-weight: 50%;
        }

        /* Responsive styling for small screens */

        /* Medium screens (tablets) */
       
        /* Small screens (mobile phones) */
        @media (max-width: 480px) {

            .title {
                font-size: 16px;
            }

            .subtitle {
                font-size: 12px;
            }

            .date {
                font-size: 10px;
            }

            .icon {
                width: 18px;
                height: 18px;
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

        @media (max-width: 768px) {
            #backToTop {
                left: 450px;
                /* Closer to the edge on smaller screens */
                bottom: 30px;
                /* Slightly higher from the bottom */
            }
        }

        @media (max-width: 480px) {
            #backToTop {
                left: 250px;
                /* Even closer to the edge on very small screens */
                bottom: 40px;
                /* Slightly higher to avoid overlapping with other elements */
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
    <!-- <div class="container">
        <div class="hero-background"></div>
        <img style="margin-top:2%;" class="hero-image" src="images/client_review.png" alt="Rhipo Photography" />
    </div>
    <div class="content-wrapper" style="margin-top:4%;">
        <div class="featured-title" style="margin-left:-1%;">Rhipo Photography</div>
        <div class="post-title" style="margin-top:-2%;">Home > Testimonials</div>
        <div class="post-description" style="font-family: 'Alexandria';">
            At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as
            the exceptional Sachinmayee Menon. </div>
    </div> -->

    <!-- ----------------------------------------------------------------------------- -->
    <div class="main" style="background:url(images/client_review.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Rhipo Photography</div>
                <div class="post-title" style="margin-top:-2%;">Home > Testimonials</div>
                <div class="post-description" style="font-family: 'Alexandria';">
                    At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as
                    the exceptional Sachinmayee Menon.
                </div>
            </div>
        </div>
    </div>
<br></br>

    <!-- Additional Image Section -->
    <div style="padding: 1rem 0 1rem 0;" class="d-flex justify-content-center">
        <img src="images/client_review_title.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div><br></br>
    <!-- <div class="row"> -->
    <div class="container">
        <?php if (!empty($reviews)): ?>
            <?php
            // Start a counter for the rows
            $counter = 0;
            foreach ($reviews as $row):
            ?>
                <?php if ($counter % 2 == 0): ?>
                    <!-- <div class="col-6"> -->
                    <div class="row">
                    <!-- <div class="table-row"> -->
                    <?php endif; ?>

                    <div class="col-md-6  p-1">
                    <div class="table-item">
                        <img src="uploads/<?= htmlspecialchars($row['image']); ?>" alt="Main Image" class="main-image">
                        <div class="text">
                            <h3 class="title">
                                <?= htmlspecialchars($row['name']); ?>
                                <img src="images/button2.png" alt="Icon" class="icon" onclick="window.location.href='client_review_details.php?id=<?= $row['id']; ?>';">
                            </h3>
                            <p class="subtitle"><?= htmlspecialchars($row['title']); ?></p>
                            <p class="date"><?= date('F d, Y', strtotime($row['created_at'])); ?></p>
                        </div>
                    </div>
                    </div>

                    <?php if ($counter % 2 == 1): ?>
                    </div> <!-- Close the row -->
                <?php endif; ?>

                <?php $counter++; ?>
            <?php endforeach; ?>

            <?php if ($counter % 2 == 1): ?>
    </div> <!-- Close the last row if needed -->
<?php endif; ?>
<?php else: ?>
    <p>No reviews found.</p>
<?php endif; ?>
</div>
<br></br>
<!-- "Load More" Button -->
<?php if (!$load_more && count($reviews) < $total_reviews): ?>
    <div>
        <a href="?load_more=true" class="btn-square" style="color: #ffffff;">
            Load More...
            <img style="color: #ffffff;" src="images/down_arrow.png" alt="Arrow" class="btn-arrow">
        </a>
    </div>
<?php endif; ?>
<!-- Back to Top Button -->
<div id="backToTop" style="display: none; position: fixed; bottom: 20px; right: 40px; z-index: 1000;">
    <a href="#" class="btn-square" style="color: #ffffff; text-decoration: none;">
        <img src="images/up_arrow.png" alt="Back to Top" style="width: 30px; height: 30px;">
    </a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');

        // Show "Back to Top" button when the user scrolls down
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) { // Adjust the value as needed
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        // Scroll to the top when the button is clicked
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>

<br></br>
<?php
include('left_sidenav.php');
include('right_sidebar.php');
include('footer.php');
?>
</body>

</html>