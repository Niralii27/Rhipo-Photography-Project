<?php
include('header.php');

include('config.php');
$clientId = isset($_GET['clientId']) ? (int)$_GET['clientId'] : 0;


    // Query to get the portfolio data for the given clientId
    $sql = "SELECT * FROM client_portfolio WHERE id = $clientId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the portfolio data
        $portfolio = $result->fetch_assoc();
        $title = $portfolio['title'];  // Assuming 'title' column exists in the 'client_portfolio' table
        $mainImage = $portfolio['main_image'];
        $galleryImages = explode(',', $portfolio['images']);
        
    } else {
        echo "No portfolio found for this client.";
        exit;
    }

    $conn->close();



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
            overflow-x: hidden; /* Disable horizontal scrolling */
        }

        .container {
            width: 100%;
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


/* Main Container */
.main-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Main Image */
.main-image img {
    width: 75%;
    height: 550px;
    border-radius: 10px;
    margin-left:15%;
    margin-bottom: 20px;
    object-fit: cover;
}

/* Gallery */
/* Pinterest-style Masonry layout for gallery */
.gallery1 {
    column-count: 4; /* Number of columns in the grid */
    column-gap: 20px; /* Space between columns */
    margin-left: 15%;
    margin-right: 10%;
}

.gallery1 .gallery-item {
    break-inside: avoid; /* Prevent items from breaking inside the columns */
    margin-bottom: 20px; /* Space between items */
}

.gallery1 img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 5px;
    object-fit: cover;
    transition: transform 0.3s, box-shadow 0.3s;
}

.gallery1 img:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* For mobile screens */
@media (max-width: 600px) {
    .gallery1 {
        column-count: 1; /* 1 column on smaller screens */
    }
}

/* For tablets */
@media (max-width: 900px) {
    .gallery1 {
        column-count: 2; /* 2 columns on medium-sized screens */
    }
}



/* For large devices (desktop) */
@media (min-width: 1200px) {
    .gallery1 {
        grid-template-columns: repeat(4, 1fr); /* Fixed columns for large screens */
        gap: 5px; /* Consistent spacing */
    }
}
.btn-square {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    background-color: #9D8161; /* Background color */
    color: #ffffff; /* Text color - always white */
    font-family: 'Alexandria', sans-serif;
    font-size: 16px;
    font-weight: 700;
    border: 2px solid #9D8161;
    border-radius: 4px;
    gap: 8px;
    text-decoration: none; /* Remove underline if used with anchor tag */
    cursor: pointer; /* Pointer cursor on hover */
    margin-left:45%;
}

.btn-square .btn-arrow {
    color: #ffffff; /* Ensures arrow icon is also white */
}

.contact-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    flex-wrap: wrap;
}

.contact-text {
    flex: 1;
    text-align: left;
}

.contact-text h3 {
    font-size: 40px;
    color: #c0966b;
    margin-bottom: 10px;
}

.contact-text h2 {
    font-size: 30px;
    margin-bottom: 20px;
}

.contact-btn {
    background-color: #c0966b;
    color: #fff;
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.contact-btn:hover {
    background-color: #a6794e;
}

.contact-image img {
    width: 100%;
    max-width: 700px;
    border-radius: 8px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .testimonial-content, .contact-content {
        flex-direction: column;
        text-align: center;
    }

    .testimonial-box {
        text-align: center;
    }

    .contact-text {
        text-align: center;
    }
}

@media (max-width: 480px) {
    .section-title {
        font-size: 2rem;
    }

    .contact-btn {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
}
.image-container {
    text-align: center;
    margin-top: 20px;
}

.responsive-image {
    width: 120%;
    max-width: 1200px; /* Adjust based on your image size */
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Modal Styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8);
    padding-top: 60px;
}

/* Modal Styles */
.modal-content {
    position: relative;
    margin: auto;
    max-width: 80%;
    max-height: 80%;
    height: 80%; /* Fixed height for the modal */
}

#fullscreenImage {
    width: 100%;
    height: 100%; /* Ensure the image height fits the modal height */
    object-fit: contain; /* This ensures the image retains its quality and fits within the modal without distortion */
    display: block;
    margin: 0 auto;
}


.modal-footer {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    gap: 20px;
}

.arrow-btn {
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    font-size: 24px;
    padding: 10px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.arrow-btn:hover {
    background-color: rgba(0, 0, 0, 0.7);
}

#downloadBtn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 18px;
    cursor: pointer;
    border: none;
}

#downloadBtn:hover {
    background-color: #45a049;
}

/* Close button */
.close {
    position: absolute;
    top: 10px;
    right: 25px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
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
        <img style="margin-top:2%;" class="hero-image" src="images/portfolio1.png" alt="Rhipo Photography" />
    </div>
    <div class="content-wrapper" style="margin-top:4%;">
        <div class="featured-title"style="margin-left:-1%;">Rhipo Photography</div>
        <div class="post-title" style="margin-top:-2%;">
        Portfolio > <?php echo !empty($title) ? htmlspecialchars($title) : "Client Portfolio"; ?>
        </div>        <div class="post-description" style="font-family: 'Alexandria';">
        Capture the grace, beauty, and significance of your Arangetram ceremony with RHIPO Photography.        </div>
    </div>
<br></br>
    <div class="additional-image-wrapper">
        <img src="images/portfolio_inner2.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div> -->
    <div class="main" style="background:url(images/portfolio1.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Rhipo Photography</div>
                <div class="post-title" style="margin-top:-2%;">Client > <?php echo !empty($title) ? htmlspecialchars($title) : "Client Portfolio"; ?></div>
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
        <img src="images/client_Showcase.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div>
<br></br>
                <div class="main-image">
                    <?php if (!empty($mainImage)): ?>
                        <img src="uploads/<?php echo htmlspecialchars($mainImage); ?>" alt="Main Image">
                    <?php else: ?>
                        <p>No main image available.</p>
                    <?php endif; ?>
                </div>

                <div id="fullscreenModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        <img id="fullscreenImage" src="" alt="Full-Screen Image" />
        <div class="modal-footer">
            <!-- Updated download button with href and download attribute -->
            <a id="downloadBtn" class="download-btn" href="" download style="display: none;">Download</a>
            <button class="arrow-btn" id="prevBtn" onclick="changeImage(-1)">&#10094;</button>
            <button class="arrow-btn" id="nextBtn" onclick="changeImage(1)">&#10095;</button>
        </div>
    </div>
</div>

<!-- Gallery -->
<div class="gallery1">
    <?php if (!empty($galleryImages)): ?>
        <?php foreach ($galleryImages as $index => $image): ?>
            <div class="gallery-item" onclick="openModal(<?php echo $index; ?>)">
                <img src="uploads/<?php echo htmlspecialchars(trim($image)); ?>" alt="Gallery Image">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No gallery images available.</p>
    <?php endif; ?>
</div>
<script>
    let currentImageIndex = -1; // Keep track of the current image index
    let galleryImages = <?php echo json_encode($galleryImages); ?>; // Convert PHP array to JavaScript array

    // Open the modal and set the image
function openModal(index) {
    currentImageIndex = index;
    const modal = document.getElementById('fullscreenModal');
    const img = document.getElementById('fullscreenImage');
    const downloadBtn = document.getElementById('downloadBtn');

    // Set the image source to the clicked image
    img.src = 'uploads/' + galleryImages[index].trim();

    // Show the download button
    downloadBtn.style.display = 'block'; 

    // Set the download link dynamically
    const imageUrl = 'uploads/' + galleryImages[index].trim();
    downloadBtn.setAttribute('href', imageUrl); // Set the image URL for downloading
    downloadBtn.setAttribute('download', galleryImages[index].trim()); // Add the download attribute with the image name

    // Show the modal
    modal.style.display = "block";
}

    // Close the modal
    function closeModal() {
        const modal = document.getElementById('fullscreenModal');
        modal.style.display = "none";
    }

    // Change image when user clicks next or previous
    function changeImage(direction) {
        currentImageIndex += direction;
        if (currentImageIndex < 0) currentImageIndex = galleryImages.length - 1;
        if (currentImageIndex >= galleryImages.length) currentImageIndex = 0;

        const img = document.getElementById('fullscreenImage');
        const downloadBtn = document.getElementById('downloadBtn');
        
        img.src = 'uploads/' + galleryImages[currentImageIndex].trim();
        downloadBtn.setAttribute('href', 'uploads/' + galleryImages[currentImageIndex].trim());
        downloadBtn.setAttribute('download', galleryImages[currentImageIndex].trim()); // Add the download attribute
    }

    // Close modal when clicking outside of the modal content
    window.onclick = function(event) {
        const modal = document.getElementById('fullscreenModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>




    </div>
<br></br>
    <div>
</a>
                <a href="book.php" class="btn-square"style="color: #ffffff;margin-top:-50%;">BOOK NOW
                <img style="color: #ffffff;" src="images/right_arrow.png" alt="Arrow" class="btn-arrow">
                </a>  
</div>
<br></br>
<!-- <div style="background: #ffffff;">
    <section class="diversity-section">
    <div class="container">
        <div class="image-container">
            <img src="images/welcome.png" alt="Diversity Section" class="responsive-image">
        </div>
    </div>
</section>


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
</a>            </div>
            <div class="contact-image">
                <img src="images/moment1.png" alt="Contact Image">
            </div>
        </div>
    </section> -->
</div>
<br></br>
<?php
include('left_sidenav.php');
include('right_sidebar.php');
    include('footer.php');
?>
</body>
</html>