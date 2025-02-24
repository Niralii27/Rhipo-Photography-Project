<?php
include('header.php');

include('config.php');
$initial_items_to_show = 9;

// Query to fetch blog posts with active status
$sql = "SELECT * FROM blog WHERE status = 'active'";
$result = $conn->query($sql);

// Get all blog items in an array
$blogs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

// Total number of blog items
$total_items = count($blogs);

// Determine the number of items to show based on load more action
$items_to_show = $initial_items_to_show;
if (isset($_GET['load_more'])) {
    $items_to_show = $total_items;
}

// Slice the array to show only the required number of items
$shown_blogs = array_slice($blogs, 0, $items_to_show);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - RHIPO Photography</title>
    <link href="https://fonts.googleapis.com/css2?family=The+New+Elegance&display=swap" rel="stylesheet">

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

        /* .container { */
        /* width: 100%; */
        /* background: white; */
        /* position: relative; */
        /* } */

        /* .hero-section {
    width: 100%;
    height: 616px;
    position: relative;
} */

        /* .hero-background {
            width: 100%;
            height: 150%;
            background: #D9D9D9;
            position: absolute;
        } */

        /* .hero-image {
            width: 150%;
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
            font-size: 1.5rem;
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

        /* .post-meta {
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
        } */

        /* Responsive Styles */
        /* @media (max-width: 1200px) { */
        /* .container {
                width: 100%;
            } */

        /* .content-wrapper {
                width: 98%;
                left: 10px;
                height: 50%;
                top: 240px;
            } */

        /* .featured-title {
                font-size: 54px;
            }

            .post-title {
                font-size: 18px;
            }

            .post-description {
                font-size: 14px;
            } */
        /* 
            .post-meta {
                font-size: 14px;
            } */
        /* 
            .additional-image-wrapper img {
                max-width: 100%;
                height: auto;
                margin-top: 10%;
            } */
        /* } */


        @media (max-width: 768px) {
            /* .hero-image {
                width: 120%;
                height: 300px;
                margin-left: -10%;
                top: 0;
            } */

            /* .content-wrapper {
                width: 90%;
                height: 200px;
                left: 5%;
                top: 15%;
                padding: 20px 30px;
            } */

            /* .featured-title {
                font-size: 20px;
            }

            .post-title {
                font-size: 24px;
            }

            .post-description {
                font-size: 14px;
            }

            .post-meta {
                font-size: 14px;
                gap: 8px;
            }

            .additional-image-wrapper img {
                max-width: 100%;
                height: auto;
                margin-top: 15%;
            } */

        }

        @media (max-width: 480px) {
            /* .hero-image {
                width: 100%;
                margin-left: 0;
            } */

            /* .content-wrapper {
                width: 100%;
                left: 0;
                top: 20%;
                padding: 15px;
            } */

            /* .featured-title {
                font-size: 18px;
            }

            .post-title {
                font-size: 20px;
            }

            .post-description {
                font-size: 12px;
            }

            .post-meta {
                font-size: 12px;
                flex-direction: column;
                align-items: flex-start;
            }

            .post-meta img {
                width: 30px;
                height: 30px;
            }

            .additional-image-wrapper img {
                max-width: 100%;
                height: auto;
            } */
        }


        /* .blog-table {
            width: 70%;
            border-collapse: collapse;
            margin: 50px 0;
            margin-left: 15%;
        } */


        .blog-table td {
            width: 33.33%;
            /* Each cell takes up 1/3rd of the row */
            padding: 15px;
            vertical-align: top;
        }

        /* Blog Card Styles */
        .blog-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            /* overflow: hidden; */
            /* background: #fff; */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* display: flex; */
            /* width: 100%; */
            /* cursor: pointer; */
            flex-direction: column;
        }


        .blog-image img {
            width: 96%;
            height: 250px;
            object-fit: cover;
            margin-left: 2%;
            margin-right: 2%;
            margin-top: 2%;
            border-radius: 15px;
        }

        .blog-content {
            padding: 15px;
        }

        .category {
            color: #9D8161;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
            font-family: 'Alexandria';
            font-weight: 400;
            line-height: 20px;
            text-align: left;
        }

        .blog-title {
            font-size: 18px;
            color: #333;
            font-weight: bold;
            margin: 10px 0;
            max-width: 350px;
            /* Set the max-width to the desired value */
            word-wrap: break-word;
            /* Ensures long words wrap to the next line */
            overflow-wrap: break-word;

            display: -webkit-box;
            /* Create a flexible box layout for text */
            -webkit-line-clamp: 2;
            /* Limit text to 2 lines (1.5 lines might not be possible directly) */
            -webkit-box-orient: vertical;
            /* Align the text vertically */
            overflow: hidden;
            /* Hide the text that overflows */
            text-overflow: ellipsis;
            /* Show '...' when text overflows */
        }


        .author {
            display: flex;
            align-items: center;
            gap: 8px;
            /* Controls the space between name and date */
        }

        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-name {
            font-size: 16px;
            color: #97989F;
            font-family: 'Alexandria';
            font-weight: 500;
            line-height: 24px;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
        }

        .date {
            font-size: 12px;
            color: #777;
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .blog-table td {
                padding: 10px;
            }

            /* .blog-card {
                margin-top: -5%;
                /* Space between cards */
            /* } */

            .blog-table tr {
                display: block;
            }

            .blog-table td {
                display: block;
                width: 100%;
                margin-top: 20%;
                /* Add space between rows */
            }

            .blog-table td:nth-child(3) {
                margin-bottom: 0;
            }
        }

        @media (max-width: 480px) {
            .blog-title {
                font-size: 16px;
            }

            .category {
                font-size: 10px;
            }

            .author-name {
                font-size: 12px;
            }

            .date {
                font-size: 10px;
            }
        }

        .btn-square {
            /* display: inline-flex; */
            /* align-items: center; */
            /* justify-content: center; */
            padding: 10px 20px;
            background-color: #9D8161;
            /* Background color */
            color: #ffffff;
            /* Text color - always white */
            /* font-family: 'Alexandria', sans-serif; */
            font-size: 16px;
            font-weight: 700;
            border: 2px solid #9D8161;
            border-radius: 4px;
            gap: 8px;
            text-decoration: none;
            /* Remove underline if used with anchor tag */
            cursor: pointer;
            /* Pointer cursor on hover */
            /* margin-left: 45%; */
            width: fit-content;
        }

        .btn-square .btn-arrow {
            color: #ffffff;
            /* Ensures arrow icon is also white */
        }

        @media (max-width: 768px) {
            #backToTop {
                left: 670px;
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

        @media (max-width:500px) {
            .main {
                background-repeat: no-repeat !important;
                background-position: center !important;
                height: 40rem;
                width: 100%;
                background-size: cover !important;
                position: relative;
            }
        }
    </style>
</head>

<body>
    <!-- <div class="container">
        <div class="hero-background"></div>
        <img style="margin-top:2%;" class="hero-image" src="images/blog3.png" alt="Rhipo Photography" />
    </div>
    <div class="content-wrapper" style="margin-top:4%;">
        <div class="featured-title" style="margin-left:-1%;">Featured</div>
        <div class="post-title" style="margin-top:-2%;">Celebrating Elegance and Versatility: The Remarkable Sachinmayee Menon</div>
        <div class="post-description">At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as the exceptional Sachinmayee Menon.</div>
        <div class="post-meta"> -->
    <!-- <img src="images/logo2.png" alt="Author Image"/>
                <div>Hitesh Agrawal</div> -->
    <!-- <div>Jul 30</div>
                <div>2 min read</div> -->
    <!-- </div>
    </div> -->

    <!-- --------------------------------------------------------------------------------------------------------------------- -->
    <div class="main" style="background:url(images/blog3.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Featured</div>
                <div class="post-title" style="margin-top:-2%;">Celebrating Elegance and Versatility: The Remarkable Sachinmayee Menon</div>
                <div class="post-description" style="font-family: 'Alexandria';">
                    At RHIPO Photography, we have had the privilege of working with numerous talented individuals,
                    but few have
                    left as profound an impression as the exceptional Sachinmayee Menon.
                </div>
            </div>
        </div>
    </div>

<br></br>


    <div style="padding:2rem 0 2rem 0;" class="d-flex justify-content-center">
        <img src="images/latest_blogs1.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div>
<br></br>
    <div class="container">
        <div class="row">
            <?php
            $counter = 0; // Counter to track 3 blogs per row
            foreach ($shown_blogs as $row) {
                if ($counter % 3 == 0) {
                    echo "<tr>"; // Start a new row after every 3 blogs
                }
            ?>
                <div class="col-lg-4 col-md-6 p-2">
                    <a href="blog_details.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: inherit;">
                        <div class="blog-card">
                            <div class="blog-image">
                                <img src="uploads/<?php echo $row['cover_image']; ?>" alt="Blog Image">
                            </div>
                            <div class="blog-content">
                                <span class="category"><?php echo $row['title']; ?></span>
                                <h2 class="blog-title"><?php echo $row['description']; ?></h2>
                                <div class="author">
                                    <img src="images/logo2.png" alt="Author" class="author-avatar">
                                    <span class="author-name">Hitesh Agarwal</span>
                                </div>
                                <span class="date"><?php echo $row['created_at']; ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
                $counter++;
                if ($counter % 3 == 0) {
                    echo "</tr>"; // Close the row after every 3 blogs
                }
            }
            ?>
        </div>
    </div>
<br></br>
    <div>
        </a>
        <?php if ($items_to_show < $total_items): ?>
            <div class="d-flex justify-content-center p-2">
                <a href="?load_more=true" class="btn-square" >
                    View All Post
                    <img style="color: #ffffff;" src="images/down_Arrow.png" alt="Arrow" class="btn-arrow">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<br></br>
    <?php
    include('left_sidenav.php');
    include('right_sidebar.php');
    include('footer.php');
    ?>
</body>

</html>