<?php

include('header.php');
include('config.php');

//fetch blog
$sql = "SELECT * FROM blog ORDER BY created_at DESC LIMIT 2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each row of the result set and display the blogs
    $blogs = [];
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
} else {
    echo "No blogs found.";
}

//review
$sql = "SELECT * FROM review ORDER BY id ASC";
$result = $conn->query($sql);

// Fetch reviews into an array
$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

// Encode the reviews into a JSON object
echo "<script>const reviews = " . json_encode($reviews) . ";</script>";

//latest shoots
$sql = "SELECT * FROM admin_portfolio ORDER BY id DESC LIMIT 3";
$result = $conn->query($sql);

// Fetch the rows into an array
$latestShoots = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $latestShoots[] = $row;
    }
} else {
    echo "No data found!";
}

//exclusive clips
$reel_offset = isset($_GET['reel_offset']) ? (int) $_GET['reel_offset'] : 0;
$full_offset = isset($_GET['full_offset']) ? (int) $_GET['full_offset'] : 0;

// Fetching Reel Videos
$reelQuery = "SELECT * FROM exclusive_clips_reel";
$reelResult = mysqli_query($conn, $reelQuery);
$reelVideos = mysqli_fetch_all($reelResult, MYSQLI_ASSOC);
$total_reels = count($reelVideos);

// Fetching Full Videos
$fullQuery = "SELECT * FROM exclusive_clips";
$fullResult = mysqli_query($conn, $fullQuery);
$fullVideos = mysqli_fetch_all($fullResult, MYSQLI_ASSOC);
$total_full_videos = count($fullVideos);

// Reel Navigation Logic
$current_reel_index = ($reel_offset + $total_reels) % $total_reels;

// Full Navigation Logic
$current_full_index = ($full_offset + $total_full_videos) % $total_full_videos;

// Fetch data from the preferred_vendors table
$sql = "SELECT * FROM preferred_vendors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rhipo Photography</title>
    <link rel="icon" href="images/logo2.png" type="image/png">

    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Add this in your HTML file in the <head> section -->
    <link href="https://fonts.googleapis.com/css2?family=The+New+Elegance&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (Optional, for interactive components like modals, dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <div id="ad-popup-container"></div>
    <script>
        window.onload = function() {
            // Check if the 'ad_shown' flag exists in sessionStorage
            const adShown = sessionStorage.getItem('ad_shown');

            // If the 'ad_shown' flag is not set, fetch the advertisement
            if (!adShown) {
                // Fetch the advertisement content directly from the PHP file
                fetch('advertise.php')
                    .then(response => response.text())
                    .then(data => {
                        if (data.includes('<div id="ad-popup"')) {
                            document.getElementById('ad-popup-container').innerHTML = data;
                            document.getElementById('ad-popup').style.display = 'block'; // Show the pop-up
                        }
                    });

                // Set the 'ad_shown' flag in sessionStorage
                sessionStorage.setItem('ad_shown', 'true');
            }

            // Close the advertisement when the close button is clicked
            document.addEventListener('click', function(event) {
                if (event.target && event.target.id === 'close-btn') {
                    document.getElementById('ad-popup').style.display = 'none'; // Hide the pop-up
                }
            });
        };
    </script>
    <!-- Navigation Bar -->
    <div id="ad-popup">
        <div class="popup-content">
            <span class="close-btn" id="close-btn">&times;</span>
            <img src="advertisement.jpg" alt="Advertisement" />
        </div>
    </div>

    <!-- --------------------------------------------------HERO SECTION---------------------------------------------- -->

    <section>
        <div class="position-relative">
            <div
                style="background:url(images/home.png); width: 100%;background-repeat: no-repeat;background-size: cover;object-fit: cover;background-position: center;">
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <div style="padding: 3rem 1rem 3rem 1rem;">
                            <p class="mb-0" style="color:#9d8161; font-size: 1.3rem;font-weight: 600;">WELCOME TO RHIPO
                                PHOTOGRAPHY
                            </p>
                            <p class="mb-0" style="font-family: 'Royal Wedding';color:#9d8161;font-size: 6rem;">
                                Capturing The Best Moment in</p>
                            <p class="mb-0"
                                style="font-family: 'The New Elegance';letter-spacing: 0.1rem;font-size: 3rem;">Your
                                Life
                                - Make Your Wedding Beautiful.</p>
                            <p style="font-size: 1.3rem;">Wedding and Portrait Photographer Seattle - RHIPO Photography
                            </p>
                            <a href="portfolio.php" style="margin: 0 0 1rem 0; width:fit-content;" class="btn-square">DISCOVER MORE
                                <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                            </a>
                            <a href="book.php" class="btn-square" style="width:fit-content;">BOOK NOW
                                <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <!-- Associated with -->
    <section>
        <div class="d-flex align-items-center mb-3">
            <img src="images/Services.png" alt="Additional Image" class="additional-image">
        </div>
    </Section>

    <!-- About us -->

    <section class="about-us-section">
        <div class="container">
            <div class="row align-items-center" style="padding-bottom: 63px;">
                <!-- Image Section -->
                <div class="col-md-6">
                    <img src="images/about_intro.png" alt="About" class="about-us-image">
                </div>
                <!-- Content Section -->
                <div class="col-md-6 py-3">
                    <div class=" d-flex align-items-center pb-2">
                        <img src="images/about.png" alt="Icon" class="img-fluid">
                    </div>
                    <h3 class="about-us-subtitle">The guy behind Rhipo Photography</h3>

                    <p class="about-us-text">
                        Personally, I've been a wedding & elopement photographer now for over 10 years (that's pretty
                        bananas)! I reside in the Pacific Northwest with my wife, Haley, after having worked in places
                        like Los Angeles, Portland, Vancouver BC, and Scottsdale, Hawaii & New York. And because I've
                        worked destination weddings all over the world, just know that wherever your wedding is, you're
                        in good hands! Now, it's all about having an awesome time with awesome couples like you. I am
                        dedicated to your beautiful, big day and committed to craft your wedding story through
                        photography </p>
                    <p class="about-us-text">
                        My photography has been seen around the world in places like Harpers Bazaar, Coach, Conde Nast,
                        Brides, Style Me Pretty, The Knot, Martha Stewart Weddings, Vogue, Esquire, and so many other
                        amazingly respected brands. And over the past decade, I've photographed more than 1,000 clients,
                        taken more than a million photographs, and have truly dedicated my professional life to being
                        the best I can be. </p>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Serives -->
    <section class="">
        <div class="container">
            <div class="row align-items-center">
                <!-- Content Section -->
                <div class="col-md-6">
                    <div class=" d-flex align-items-center mb-3">
                        <img src="images/service.png" alt="Icon" class="img-fluid">
                    </div>
                    <h3 class="features-subtitle" style="font-family:'The New Elegance;'">We Serve You With Love And
                        Experience</h3>
                    <ul class="features-list">
                        <li>
                            <img src="images/back_arrow.png" alt="Arrow" class="feature-icon"
                                onclick="showContent(this)"> WEDDINGS
                            <div class="description" style="display: none;">
                                <p>Wedding photography with attention to detail, capturing the essence of your big day.
                                </p>
                                <a href="portfolio.php" class="btn-square">LEARN MORE WEDDINGS
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                                </a>
                                <a href="book.php" class="btn-square">BOOK NOW
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">

                                </a>
                            </div>
                        </li>
                        <li>
                            <img src="images/back_arrow.png" alt="Arrow" class="feature-icon"
                                onclick="showContent(this)"> PERSONAL EVENTS
                            <div class="description" style="display: none;">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <a href="portfolio.php" class="btn-square">LEARN MORE PERSONAL EVENTS
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                                </a>
                                <a href="book.php" class="btn-square">BOOK NOW
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">

                                </a>
                            </div>
                        </li>
                        <li>
                            <img src="images/back_arrow.png" alt="Arrow" class="feature-icon"
                                onclick="showContent(this)"> CORPORATE EVENTS
                            <div class="description" style="display: none;">
                                <p>Professional photography for corporate events, conferences, and more.</p>
                                <a href="portfolio.php" class="btn-square">LEARN MORE CORPORATE EVENTS
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                                <a href="book.php" class="btn-square">BOOK NOW
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">

                                </a>
                            </div>
                        </li>
                        <li>
                            <img src="images/back_arrow.png" alt="Arrow" class="feature-icon"
                                onclick="showContent(this)"> COMMERCIAL EVENTS
                            <div class="description" style="display: none;">
                                <p>Documenting your commercial events with creativity and style.</p>
                                <a href="portfolio.php" class="btn-square">LEARN MORE COMMERCIAL EVENTS
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                                </a>
                                <a href="book.php" class="btn-square">BOOK NOW
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">

                                </a>
                            </div>
                        </li>
                        <li>
                            <img src="images/back_arrow.png" alt="Arrow" class="feature-icon"
                                onclick="showContent(this)"> FAMILY PORTRAITS
                            <div class="description" style="display: none;">
                                <p>Family portrait sessions to capture your loved ones in beautiful settings.</p>
                                <a href="portfolio.php" class="btn-square">LEARN MORE FAMILY PORTRAITS
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                                </a>
                                <a href="book.php" class="btn-square">BOOK NOW
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">

                                </a>
                            </div>
                        </li>
                        <li>
                            <img src="images/back_arrow.png" alt="Arrow" class="feature-icon"
                                onclick="showContent(this)"> FASHION PORTRAITS
                            <div class="description" style="display: none;">
                                <p>Stylish and glamorous fashion portraits that tell a unique story.</p>
                                <a href="portfolio.php" class="btn-square">LEARN MORE FASHION PORTRAITS
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                                </a>
                                <a href="book.php" class="btn-square">BOOK NOW
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">

                                </a>
                            </div>
                        </li>
                        <li>
                            <img src="images/back_arrow.png" alt="Arrow" class="feature-icon"
                                onclick="showContent(this)"> BOUDOIR
                            <div class="description" style="display: none;">
                                <p>Stylish and glamorous fashion portraits that tell a unique story.</p>
                                <a href="portfolio.php" class="btn-square">LEARN MORE FASHION PORTRAITS
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                                </a>
                                <a href="book.php" class="btn-square">BOOK NOW
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">

                                </a>
                            </div>
                        </li>
                        <li>
                            <img src="images/back_arrow.png" alt="Arrow" class="feature-icon"
                                onclick="showContent(this)"> ADD ON SERVICES
                            <div class="description" style="display: none;">
                                <p>Sensual and empowering boudoir photography sessions.</p>
                                <div class="button-container">
                                    <a href="portfolio.php" class="btn-square">LEARN MORE BOUDOIR
                                        <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                    </a>
                                    </a>
                                    <a href="book.php" class="btn-square">BOOK NOW
                                        <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">

                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Image Section -->
                <div class="col-md-6 mt-5">
                    <img src="images/service1.png" alt="Features" class="features-image">
                </div>
            </div>
        </div>
    </section>
    <!-- Slider -->

    <div style="padding:2rem 0 2rem 0;" class="d-flex justify-content-center mt-3">
        <img src="images/exclusive_content.png" alt="Exclusive Clips" style="max-width: 100%; height: auto;" />
    </div>

    <section class="video-section">
    <div class="container">
        <div class="row align-items-center position-relative">
            <!-- Reel Video Section -->
            <div class="col-lg-3 col-md-4 pb-1">
                <div style="position: relative; max-height: 33rem; overflow: hidden;">
                    <!-- Title and Overlay -->
                    <div 
                        class="position-absolute text-center w-100" 
                        style="bottom: 10px; z-index: 2; color: white; pointer-events: none;">
                        <h3 id="reel-title">Reel Title</h3>
                        <p>REEL</p>
                    </div>

                    <!-- Video -->
                    <div class="video-thumbnail">
                        <video id="reel-video" controls style="width: 100%; height: 100%; z-index: 1;">
                            <!-- Reel Video Source -->
                        </video>
                    </div>
                </div>
            </div>

            <!-- Full Video Section -->
            <div class="col-lg-9 col-md-8 pb-1">
                <div style="position: relative; max-height: 33rem; overflow: hidden;">
                    <!-- Title and Overlay -->
                    <div 
                        class="position-absolute text-center w-100" 
                        style="bottom: 10px; z-index: 2; color: white; pointer-events: none;">
                        <h3 id="full-title">Full Title</h3>
                        <p>FULL VIDEO</p>
                    </div>

                    <!-- Video -->
                    <div class="video-thumbnail">
                        <video id="full-video" controls style="width: 100%; height: 100%; z-index: 1;">
                            <!-- Full Video Source -->
                        </video>
                    </div>
                </div>
            </div>

            <!-- Left Arrow -->
            <a href="#" id="left-arrow" 
               style="position: absolute; top: 50%; left: -7%; transform: translateY(-50%); width: 50px; height: 50px; z-index: 3;">
                <img src="images/left_vector.png" alt="Left Arrow" class="arrow-icon left-arrow">
            </a>

            <!-- Right Arrow -->
            <a href="#" id="right-arrow" 
               style="position: absolute; top: 50%; right: -5%; transform: translateY(-50%); width: 50px; height: 50px; z-index: 3;">
                <img src="images/right_vector.png" alt="Right Arrow" class="arrow-icon right-arrow">
            </a>
        </div>
    </div>
</section>




    <!-- ---------------------------<POOJAA>------------------------------------------------------------------------------ -->
    <!-- <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="position-relative">
                        <div>
                            <video id="reel-video" controls style="width: 100%;height:29.7rem">
                        </div>
                        <div class="simgd">
                            <p class="stitle mb-0">Wedding Shoots</p>
                            <p class="stitle mb-4" style="font-size: 1rem; font-weight: 200;">REEL</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="position-relative">
                        <div>
                            <video id="full-video" controls style="width: 100%; height: 100%;">
                        </div>
                        <div class="simgd">
                            <p class="stitle mb-0">New Year Eve</p>
                            <p class="stitle mb-4" style="font-size: 1rem; font-weight: 200;">REEL</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- --------------------------------------------------------------------------------------------------------------------- -->



    <script>
        // Assuming you have the video data for the reel and full videos
        const reelVideos = <?php echo json_encode($reelVideos); ?>;
        const fullVideos = <?php echo json_encode($fullVideos); ?>;
        let currentReelIndex = <?php echo $current_reel_index; ?>;
        let currentFullIndex = <?php echo $current_full_index; ?>;

        // Function to load and display the video details dynamically
        function updateVideos() {
            // Update Reel Video Section
            const reelTitle = document.getElementById('reel-title');
            const reelVideo = document.getElementById('reel-video');
            reelTitle.textContent = reelVideos[currentReelIndex].title;
            reelVideo.src = "uploads/videos/" + reelVideos[currentReelIndex].video;

            // Update Full Video Section
            const fullTitle = document.getElementById('full-title');
            const fullVideo = document.getElementById('full-video');
            fullTitle.textContent = fullVideos[currentFullIndex].title;
            fullVideo.src = "uploads/videos/" + fullVideos[currentFullIndex].video;
        }

        // Handle Left Arrow for both Reel and Full Video
        document.getElementById('left-arrow').addEventListener('click', function(e) {
            e.preventDefault();

            // For Reel Video
            if (currentReelIndex > 0) {
                currentReelIndex--; // Go to previous reel
            } else {
                currentReelIndex = reelVideos.length - 1; // Loop back to the last reel
            }

            // For Full Video
            if (currentFullIndex > 0) {
                currentFullIndex--; // Go to previous full video
            } else {
                currentFullIndex = fullVideos.length - 1; // Loop back to the last full video
            }

            // Update the videos and the URL
            updateVideos();
            updateURL();
        });

        // Handle Right Arrow for both Reel and Full Video
        document.getElementById('right-arrow').addEventListener('click', function(e) {
            e.preventDefault();

            // For Reel Video
            if (currentReelIndex < reelVideos.length - 1) {
                currentReelIndex++; // Go to next reel
            } else {
                currentReelIndex = 0; // Loop back to the first reel
            }

            // For Full Video
            if (currentFullIndex < fullVideos.length - 1) {
                currentFullIndex++; // Go to next full video
            } else {
                currentFullIndex = 0; // Loop back to the first full video
            }

            // Update the videos and the URL
            updateVideos();
            updateURL();
        });

        // Function to update the URL without page refresh
        function updateURL() {
            const newURL = window.location.origin + window.location.pathname + "?reel_offset=" + currentReelIndex + "&full_offset=" + currentFullIndex;
            history.pushState({
                path: newURL
            }, '', newURL); // Change URL without refreshing the page
        }

        // Initialize video display
        updateVideos();
    </script>


    <div style="padding:2rem 0 2rem 0;" class="d-flex justify-content-center mt-3">
        <img src="images/prefered.png" alt="Exclusive Clips" style="max-width: 100%; height: auto;" />
    </div>
    <!-- ------------------------------------------------------------POOJA------------------------------------------- -->
    <section>
    <div class="container">
        <div class="slide-container swiper">
            <div class="slide-content">
                <div class="card-wrapper swiper-wrapper">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                            <div class="swiper-slide">
                                <div class="image-content position-relative best-selling">
                                    <img src="uploads/' . htmlspecialchars($row["image"]) . '" class="img-fluid" alt="' . htmlspecialchars($row["title"]) . '">
                                </div>
                                <div class="card-content text-center">
                                    <p class="mb-0"><b>' . htmlspecialchars($row["name"]) . '</b></p>
                                    <p>' . htmlspecialchars($row["title"]) . '</p>
                                   <div class="button-container">
                                        <a href="javascript:void(0);" 
                                        class="btn-square openVendorModal" 
                                        data-id="' . htmlspecialchars($row["id"]) . '" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#vendorModal">
                                        Learn More About ' . htmlspecialchars($row["title"]) . '
                                        <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                        </a>
                                    </div>

                                </div>
                            </div>';
                        }
                    } else {
                        echo '<p>No vendors found.</p>';
                    }
                    ?>
                </div>
            </div>
            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
        </div>
    </div>
</section>


    <!-- ---------------------------------------------------------------------------------------------------------- -->
    <!-- New Section for Image and Text Side by Side -->
    <!-- <section class="image-text-section"> -->
    <!-- <div class="container">
            <div class="row" style="display: flex; justify-content: center; align-items: center; position: relative;"> -->
    <!-- Left Arrow Icon -->
    <!-- <button id="vendor-left-arrow" class="arrow-icon left-arrow"
                    style="background: none; border: none; position: absolute; top: 40%; left: -60px; transform: translateY(-50%); width: 50px; height: 50px;">
                    <img src="images/left_vector.png" alt="Left Arrow">
                </button> -->

    <!-- Slider Container -->
    <!-- <div id="slider-container" class="slider-container"
                    style="display: flex; transition: transform 0.5s ease-in-out;"> -->
    <!-- Vendor items will be populated here by JavaScript -->
    <!-- </div> -->

    <!-- Right Arrow Icon -->
    <!-- <button id="vendor-right-arrow" class="arrow-icon right-arrow"
                    style="background: none; border: none; position: absolute; top: 40%; right: -20px; transform: translateY(-50%); width: 50px; height: 50px;">
                    <img src="images/right_vector.png" alt="Right Arrow">
                </button>
            </div>
        </div> -->
    <!-- </section> -->
    <!-- --------------------------------------------------------------------------------------------------------------------------- -->

   
  
  <div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vendorModalLabel">Vendor Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="vendorName"></h4>
                <h6 id="vendorTitle" style="color: gray; font-style: italic;"></h6>
                <img id="vendorImage" src="uploads/" alt="Vendor Image" style="width: 100%; height: auto;"><br><br>
                <p id="vendorDescription"></p>

                <!-- Social Media Links -->
                <div class="social-media-links" style="text-align: center; margin-top: 15px;">
                    <a href="#" id="vendorInstagram" target="_blank" style="font-size: 24px; margin-right: 15px;">
                        <i class="fab fa-instagram" style="color: brown;"></i>
                    </a>
                    <a href="#" id="vendorFacebook" target="_blank" style="font-size: 24px;">
                        <i class="fab fa-facebook-f" style="color: brown;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = new bootstrap.Modal(document.getElementById('vendorModal'));
        const vendorName = document.getElementById('vendorName');
        const vendorTitle = document.getElementById('vendorTitle');
        const vendorImage = document.getElementById('vendorImage');
        const vendorDescription = document.getElementById('vendorDescription');
        const vendorInstagram = document.getElementById('vendorInstagram');
        const vendorFacebook = document.getElementById('vendorFacebook');

        // Attach event listeners to buttons with the class "openVendorModal"
        document.querySelectorAll('.openVendorModal').forEach(button => {
            button.addEventListener('click', function () {
                const vendorId = this.getAttribute('data-id');
                fetchVendorDetails(vendorId);
            });
        });

        function fetchVendorDetails(vendorId) {
            // Fetch vendor data via AJAX
            fetch('get_vendor_data.php?id=' + vendorId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching data:', data.error);
                        alert('Vendor data not found.');
                        return;
                    }

                    // Populate modal fields with fetched data
                    vendorName.textContent = data.name || 'N/A';
                    vendorTitle.textContent = data.title || 'N/A';
                    vendorImage.src = data.image ? 'uploads/' + data.image : 'default_image.jpg';
                    vendorDescription.textContent = data.description || 'No description available.';

                    // Ensure URLs include http:// or https://
                    vendorInstagram.href = ensureProtocol(data.instagram);
                    vendorFacebook.href = ensureProtocol(data.facebook);

                    // Set links to open in a new tab
                    vendorInstagram.target = "_blank";
                    vendorFacebook.target = "_blank";

                    // Show the modal
                    modal.show();
                })
                .catch(error => {
                    console.error('Error fetching vendor details:', error);
                    alert('Failed to fetch vendor details.');
                });
        }

        // Function to ensure URLs include the protocol
        function ensureProtocol(url) {
            if (!url) return '#'; // If no URL, return '#'
            if (!/^https?:\/\//i.test(url)) {
                return `https://${url}`; // Add https:// if missing
            }
            return url; // Return valid URL as is
        }
    });
</script>



    <!-- WEDDING PHOTGRAPHY SEATTLE -->
    <!-- <section class="">
        <div class="container">
            <img src="images/Wedding_photography_seattle.png" alt="Exclusive Clips" class="middle-title-image">
        </div>
    </section> -->

    <div style="padding:2rem 0 2rem 0;" class="d-flex justify-content-center mt-5">
        <img src="images/Wedding_photography_seattle.png" alt="Exclusive Clips" style="max-width: 100%; height: auto;" />
    </div>

    <section>
        <div class="container">
            <img src="images/Wedding_photography_seattle1.png" alt="Exclusive Clips" class="middle-title-image mt-5">

            <!-- Content Section -->
            <div class="content-container">
                <div class="content-left">
                    <p style="font-family:'Alexandria'; font-size: 20px;color: #666666;letter-spacing: 2px;">On your
                        wedding day, you want everything to be perfect. That includes having the right photographer to
                        capture your special day's memories. That's where we come in. We're professional wedding
                        photographers with years of experience capturing all the details of a wedding, from the bride
                        getting ready to the first dance. We know how to work with any lighting situation and can
                        provide a beautiful record of your wedding day that you'll treasure for years. 
                    </p>

                    <p
                        style="font-family:'Alexandria'; font-size: 20px;color: #666666;letter-spacing: 2px;">
                        So if you're looking for a Wedding Photographer, please don't hesitate to Contact Us. We'd be
                        more than happy to discuss your needs and provide you with a quote.</p>
                </div>
                <div class="content-right">
                    <!-- Image Above Text -->
                    <img src="images/thank_you.png" alt="Wedding Photographer" class="content-image">
                    <br></br>
                    <!-- Button Below Text -->
                    <div class="button-container" style="margin-right: 20%" ;>
                        <a href="contact.php" class="btn-square">CONTACT US NOW
                            <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                        </a>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="middle-title-section py-5">
        <div class="container">

            <div class=" d-flex align-items-center mb-5">
                <!-- <img src="images/blog.png" alt="Exclusive Clips" class="middle-title-image" style="width: 50%; margin-right: 50%;"> -->
                <!-- <h2 class="about-us-title img-fluid" style="text-align: left;">Blog</h2> -->
                <img src="images/blog.png" alt="Icon" class="img-fluid">
            </div>
            <h3
                style="font-family: 'The New Elegance';letter-spacing: .1rem; font-size: 28px;text-align: left;color: #333333;">
                Our Latest Blog</h3>

            <div class="row py-3">
                <div class="col-lg-6 col-md-6">
                    <div class="blog-card">
                        <div>
                            <img src="uploads/<?php echo $blogs[0]['cover_image']; ?>" alt="Video Thumbnail" class="image"
                                style="width: 100%; border-radius: 30px;">
                        </div>
                        <div class="position-relative px-3 mt-4" style="text-align:start;">
                            <!-- Title -->
                            <h2 class="pb-1" style="font-family: 'The New Elegance'; font-size: 18px; color: #333333;letter-spacing: 0.04em;">
                                <?php echo htmlspecialchars($blogs[0]['title']); ?>
                            </h2>
                            <!-- Subtitle -->
                            <h3 class="pb-1"
                                style="font-family: 'Alexandria'; font-size: 20px; letter-spacing: 0.05em; color: #666666;
                    max-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; ">
                                <?php echo htmlspecialchars($blogs[0]['description']); ?>
                            </h3>
                            <!-- Button -->
                            <div class="button-container">
                                <a href="blog_details.php?id=<?php echo $blogs[0]['id']; ?>" class="btn-square">Read More
                                    <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Second Blog -->
                <div class="col-lg-6 col-md-6">
                    <div>
                        <img src="uploads/<?php echo $blogs[1]['cover_image']; ?>" alt="Video Thumbnail" class="image"
                            style="width: 100%; border-radius: 30px;">
                    </div>
                    <div class="position-relative px-3 mt-4" style="text-align:start;">
                        <!-- Title -->
                        <h2 class="pb-1" style="font-family: 'The New Elegance'; font-size: 18px; color: #333333;letter-spacing: 0.04em;">
                            <?php echo htmlspecialchars($blogs[1]['title']); ?>
                        </h2>
                        <!-- Subtitle -->
                        <h3 class="pb-1"
                            style="font-family: 'Alexandria'; font-size: 20px; letter-spacing: 0.05em; color: #666666;
                    max-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; ">
                            <?php echo htmlspecialchars($blogs[1]['description']); ?>
                        </h3>
                        <!-- Button -->
                        <div class="button-container">
                            <a href="blog_details.php?id=<?php echo $blogs[1]['id']; ?>" class="btn-square">Read More
                                <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- --------------------------------------------------------------------------------------------------------- -->

    <section>
        <div class="position-relative">
            <div
                style="background:url(images/wedding_image1.png); width: 100%;background-repeat: no-repeat;background-size: cover;object-fit: cover;background-position: center;">
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <div style="padding: 8rem 0 6rem 0;text-align: center;">
                            <p class="mb-0"
                                style="font-family: 'The New Elegance';letter-spacing: 0.1rem;font-size: 2rem;">No Distance is Too Far</p>
                            <p class="mb-0"
                                style="font-family: 'The New Elegance';letter-spacing: 0.1rem;font-size: 2.5rem;">For
                                Your
                                <span style="font-family: 'Royal Wedding';color:#9d8161;font-size: 6rem;">Dream</span>
                                Wedding
                            </p>
                            <p style="font-size: 1.2rem;">Local or across the world, I want to be your wedding or
                                Elopement photographer.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div style="padding:2rem 0 2rem 0;" class="d-flex justify-content-center">
        <img src="images/latest_shoots.png" alt="Exclusive Clips" style="max-width: 100%; height: auto;" />
    </div>
    <!-- 
    <section class="middle-title-section">
        <div class="container">
            <img src="images/latest_shoots.png" alt="Exclusive Clips" class="middle-title-image">
        </div>
    </section> -->
    <section class="latest-shoots-section">
        <div class="container">
            <!-- <div class="shoots-gallery"> -->
            <div class="row">
                <div class="col-lg-4 col-md-4 p-2">
                    <!-- Left Image -->
                    <div class="shoot-item overlay-item">
                        <?php if (isset($latestShoots[0])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($latestShoots[0]['slider_image1']); ?>"
                                alt="Shoot 1" class="shoot-image" style="height: 540px;border-radius: 12rem 0 0 0;">
                            <div class="overlay" style="border-radius: 12rem 0 0 0;">
                                <button class="view-project-btn"
                                    onclick="window.location.href='portfolio_inner.php?id=<?php echo $latestShoots[0]['id']; ?>'">View
                                    Project <img src="images/arrow2.png">
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Center Image with Overlay -->
                <div class="col-lg-4 col-md-4 p-2">
                    <div class="shoot-item overlay-item">
                        <?php if (isset($latestShoots[1])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($latestShoots[1]['slider_image1']); ?>"
                                alt="Shoot 2" class="shoot-image" style="height: 540px;">
                            <div class="overlay">
                                <button class="view-project-btn"
                                    onclick="window.location.href='portfolio_inner.php?id=<?php echo $latestShoots[1]['id']; ?>'">View
                                    Project <img src="images/arrow2.png"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="col-lg-4 col-md-4 p-2">
                    <div class="shoot-item overlay-item">
                        <?php if (isset($latestShoots[2])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($latestShoots[2]['slider_image1']); ?>"
                                alt="Shoot 3" class="shoot-image" style="height: 540px;border-radius: 0 0 12rem 0;">
                            <div class="overlay" style="border-radius: 0 0 12rem 0;">
                                <button class="view-project-btn"
                                    onclick="window.location.href='portfolio_inner.php?id=<?php echo $latestShoots[2]['id']; ?>'">View
                                    Project <img src="images/arrow2.png"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </section>


    <section class="middle-title-section">
        <div class="container">
            <img src="images/happy_clients.png" alt="Exclusive Clips" class="middle-title-image">
        </div>
    </section>
    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="container">
            <div class="testimonial-content">
                <!-- Left Navigation -->
                <div class="nav-arrow left-arrow" onclick="changeReview(-1)">❮</div>

                <!-- Testimonial Text -->
                <div class="testimonial-box">
                    <blockquote id="testimonial-text">
                        <strong id="testimonial-title"></strong><br><br>
                        <span id="testimonial-description"></span>
                    </blockquote>
                    <div class="client-info">
                        <img id="testimonial-avatar" src="" alt="Client" class="client-avatar">
                        <p><strong id="testimonial-name"></strong></p>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="testimonial-image">
                    <img id="testimonial-image" src="" alt="Happy Client"
                        style="height: 400px; width: 100%; object-fit: cover; object-position: center;">
                </div>

                <!-- Right Navigation -->
                <div class="nav-arrow right-arrow" onclick="changeReview(1)">❯</div>
            </div>
        </div>
    </section>


    <script>
        // JavaScript to handle review navigation
        document.addEventListener('DOMContentLoaded', function() {
            let currentReviewIndex = 0; // Start with the first review

            // Function to update the testimonial content
            function updateTestimonial() {
                const review = reviews[currentReviewIndex];

                // Update the testimonial box
                document.getElementById('testimonial-title').textContent = `'${review.title}'`;
                document.getElementById('testimonial-description').textContent = review.description;
                document.getElementById('testimonial-avatar').src = `uploads/${review.image}`;
                document.getElementById('testimonial-name').textContent = review.name;

                // Update the right-side image
                document.getElementById('testimonial-image').src = `uploads/${review.image}`;
            }

            // Function to change the review
            function changeReview(direction) {
                currentReviewIndex += direction;

                // Handle circular navigation
                if (currentReviewIndex < 0) {
                    currentReviewIndex = reviews.length - 1; // Go to the last review
                } else if (currentReviewIndex >= reviews.length) {
                    currentReviewIndex = 0; // Go to the first review
                }

                // Update the testimonial content
                updateTestimonial();
            }

            // Initialize the first review
            updateTestimonial();

            // Expose the changeReview function globally for arrow navigation
            window.changeReview = changeReview;
        });
    </script>

    <br></br><br></br>
    <!-- Diversity Section -->
    <section class="diversity-section">
        <div class="container">
            <div class="image-container">
                <img src="images/welcome.png" alt="Diversity Section" class="responsive-image">
            </div>
        </div>
    </section>
    <br></br>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container contact-content">
            <div class="contact-text">
                <h3>Get in Touch</h3>
                <h2>Let's make your moment special with us</h2>
                <a href="contact.php">
                    <button class="contact-btn">
                        CONTACT US
                        <img src="images/arrow2.png" alt="Arrow" class="btn-arrow">
                    </button>
                </a>

            </div>
            <div class="contact-image">
                <img src="images/moment1.png" alt="Contact Image">
            </div>
        </div>
    </section>
</body>

</html>

<script>
    function showContent(element) {
        // Find the <li> that the arrow is in
        var li = element.closest('li');
        var description = li.querySelector('.description');
        var arrow = li.querySelector('.feature-icon');

        // Toggle the visibility of the description
        if (description.style.display === 'none' || description.style.display === '') {
            description.style.display = 'block';
            arrow.src = 'images/top_arrow.png'; // Change to another image when clicked
        } else {
            description.style.display = 'none';
            arrow.src = 'images/back_arrow.png'; // Restore the original back arrow image
        }
    }


    let currentSlide = 0;

    // Function to move slider left or right
    function moveSlider(direction) {
        const slides = document.querySelectorAll('.video-container');
        const totalSlides = slides.length;

        // Move the slider to the left or right based on the direction
        if (direction === 'right') {
            currentSlide = (currentSlide + 1) % totalSlides;
        } else if (direction === 'left') {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        }

        // Move the slider by changing the transform property
        const sliderContainer = document.querySelector('.row');
        sliderContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="js/swiper-bundle.min.js"></script>

<!-- JavaScript -->
<script src="js/script.js"></script>

</html>
<?php
include('left_sidenav.php');
include('right_sidebar.php');
include('footer.php');
?>