<?php
include('header.php');

include('config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch all reviews from the database
$query = "SELECT * FROM review ORDER BY id ASC";
$result = $conn->query($query);

// Check if we have reviews
if ($result->num_rows > 0) {
    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
} else {
    // Fallback if no reviews are found
    $reviews = [];
}


// Find the current review index
$currentIndex = 0;
foreach ($reviews as $index => $review) {
    if ($review['id'] == $id) {
        $currentIndex = $index;
        break;
    }
}

// Handle edge cases: If no ID is provided or the ID is invalid, default to the first review
if ($id == 0 || !isset($reviews[$currentIndex])) {
    $currentIndex = 0;
}

$prevId = $reviews[($currentIndex - 1 + count($reviews)) % count($reviews)]['id'];
$nextId = $reviews[($currentIndex + 1) % count($reviews)]['id'];
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

        /* 
        .testimonial-container {
            display: flex;
            align-items: center;
            max-width: 1000px;
            margin: 0 auto;
            gap: 20px;
            margin-left: 30%;
            margin-top: 40%;
            flex-wrap: wrap;
        } */

        .description {
            flex: 1;
            position: relative;
            font-size: 20px;
            line-height: 1.6;
            color: #666666;
            font-family: 'Alexandria';
            font-weight: 400;
            line-height: 32px;
            letter-spacing: 0.02em;
        }

        .description .left-icon {
            position: absolute;
            top: 50%;
            left: -140px;
            transform: translateY(-50%);
            width: 50px;
            cursor: pointer;
        }

        .image-container {
            position: relative;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            /* width: 400px; */
            height: 400px;
            width: 100%;
            object-fit: cover;
            border-radius: 0 0 0 50%;
            /* Bottom-right corner rounded */
            /* border: 5px solid #fff; */
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); */
        }




        .right-icon {
            width: 60px;
            height: 60px;
            object-fit: cover;
            clip-path: circle(50%);
            margin-left: 25%;
            border: 5px solid #fff;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .testimonial-container {
                flex-direction: column;
                text-align: center;
            }

            .description .left-icon {
                left: 44%;
                top: -40px;
            }

            .image-container .right-icon {
                right: 10px;
                top: -40px;
            }

            .image-container img {
                width: 100%;
                height: 300px;
                /* min-height: 200px;
                max-height: 350px; */
                /* height: 250px; */
            }

            /* .description {
                margin-top: 50%;
            } */
        }

        @media (max-width: 480px) {

            .description .left-icon,
            .image-container .right-icon {
                width: 20px;
            }

            .image-container img {
                width: 100%;
                height: 100%;
                min-height: 180px;
                max-height: 250px;
                /* height: 250px; */
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

    <div class="main" style="background:url(images/client_review.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Rhipo Photography</div>
                <div class="post-title" style="margin-top:-2%;">Home > <?php echo htmlspecialchars($review['title']); ?></div>
                <div class="post-description" style="font-family: 'Alexandria';">
                    At RHIPO Photography, we have had the privilege of working with numerous talented individuals,
                    but few have
                    left as profound an impression as the exceptional Sachinmayee Menon.
                </div>
            </div>
        </div>
    </div>
<br></br>
    <div class="container p-lg-5 p-3 py-5 position-relative">

        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 px-md-2 px-5">
                <div class="description">
                    <p id="reviewDescription"><?php echo nl2br(htmlspecialchars($reviews[$currentIndex]['description'])); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="image-container">
                    <img id="reviewImage" src="uploads/<?php echo htmlspecialchars($reviews[$currentIndex]['image']); ?>" alt="Client Picture">
                </div>
            </div>
        </div>
        <div style="position:absolute; top:50%;width:3rem; margin-left:-6%">
            <a href="javascript:void(0);" id="prevReviewLink">
                <img src="images/left_vector.png" alt="Previous" class="img-fluid">
            </a>
        </div>
        <div style="position:absolute; top:50%;right:0%;width:3rem; margin-right:-1%">
            <a href="javascript:void(0);" id="nextReviewLink">
                <img src="images/right_vector.png" alt="Next" class="img-fluid">
            </a>
        </div>
    </div>

    <script>
        let currentReviewIndex = <?php echo $currentIndex; ?>; // Current review index passed from PHP
        const reviews = <?php echo json_encode($reviews); ?>;

        // Function to update the review content dynamically
        function updateReviewContent(index) {
            // Get the new review
            const review = reviews[index];

            // Update the review content dynamically
            document.getElementById('reviewDescription').innerHTML = review.description.replace(/\n/g, '<br>');
            document.getElementById('reviewImage').src = 'uploads/' + review.image;

            // Update the previous and next review links (circular)
            const prevIndex = (index - 1 + reviews.length) % reviews.length;
            const nextIndex = (index + 1) % reviews.length;

            // Update the ID for the previous and next review links
            document.getElementById('prevReviewLink').setAttribute('href', `?id=${reviews[prevIndex].id}`);
            document.getElementById('nextReviewLink').setAttribute('href', `?id=${reviews[nextIndex].id}`);

            // Update the browser history state without reloading the page
            history.pushState({}, '', `?id=${reviews[index].id}`);
            currentReviewIndex = index; // Update current review index
        }

        // Handle previous review click
        document.getElementById('prevReviewLink').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            currentReviewIndex = (currentReviewIndex - 1 + reviews.length) % reviews.length;
            updateReviewContent(currentReviewIndex); // Update review content
        });

        // Handle next review click
        document.getElementById('nextReviewLink').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            currentReviewIndex = (currentReviewIndex + 1) % reviews.length;
            updateReviewContent(currentReviewIndex); // Update review content
        });

        // Initialize the first review
        updateReviewContent(currentReviewIndex);
    </script>
    <br></br>
    <?php
    include('left_sidenav.php');
    include('right_sidebar.php');
    include('footer.php');
    ?>
</body>

</html>