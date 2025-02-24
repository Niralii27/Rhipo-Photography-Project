<?php
include('header.php');

include('config.php');
$sql = "SELECT * FROM booking";
$result = $conn->query($sql);
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




/* Card Container */
/* General Reset */

.card-container {
    display: flex;
    justify-content: space-between; /* Space out the cards */
    flex-wrap: wrap; /* Wrap cards to the next line if needed */
    gap: 20px;
    margin-left:17%;
    margin-right:15%; /* Space between the cards */
}

/* Card Styling */
.card {
    width: 350px;
    border: 1px solid #ddd;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    background-color: #F1EFE8;

}

.card::before {
    content: "";
    position: absolute;
    top: 73%; /* Position the line in the center vertically */
    left: 0;
    width: 100%;
    height: 2px; /* Line height */
    background-color: #DCDCDC; /* Black color for the line */
    transform: translateY(-50%); /* Adjust the position to center the line */
}

.card::after {
    content: "";
    position: absolute;
    top: 87%; /* Position the line in the center vertically */
    left: 0;
    width: 100%;
    height: 2px; /* Line height */
    background-color: #DCDCDC; /* Black color for the line */
    transform: translateY(-50%); /* Adjust the position to center the line */
}

/* Main Image Styling */
.card-header {
    position: relative;
    width: 100%;
}

.main-image {
    width: 100%;
    height: 250px;
    display: block;
    object-fit: cover;
}

.thumbnail-image {
    width: 100px;
    height: 130px;
    position: absolute;
    bottom: -100px; /* Overlaps the main image */
    left: 20px;
    border: 2px solid #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Card Body Styling */
.card-body {
    padding: 20px;
    padding-top: 5px; /* Adjusted for thumbnail overlap */
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #090A0A;
    margin-left:35%;
    margin-bottom: 10px;
    font-family: 'The New Elegance';
    font-weight: 400;
    line-height: 32px;

}

.card-description {
    font-size: 0.9rem;
    color: #6C7072;
    margin-bottom: 20px;
    margin-left:35%;
    line-height: 1.5;
    font-family: 'Alexandria';
    font-weight: 400;
    line-height: 20px;


}

/* Card Details */
.card-details {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: #6C7072;
    font-family: 'Alexandria';
    font-weight: 400;
    line-height: 20px;


}

.detail-item span:last-child {
    font-weight: bold;
    color: #090A0A;
    font-family: 'Alexandria';
    font-size: 16px;
    line-height: 20px;
}

/* Button */
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
    width:100%;
    margin-bottom: -10%;
    text-decoration: none; /* Remove underline if used with anchor tag */
    cursor: pointer; /* Pointer cursor on hover */
}

.btn-square .btn-arrow {
    color: #ffffff; /* Ensures arrow icon is also white */
}

/* Responsive Design */
/* For screens 480px or smaller */
@media (max-width: 480px) {
    .card {
        width: 90%;
        position: relative; /* Enable relative positioning */
        top: 10px; /* Move the card down */
    }

    .thumbnail-image {
        width: 60px;
        height: 60px;
        bottom: -30px;
    }

    .card-title {
        font-size: 1.2rem;
    }
}

/* For screens between 481px and 768px */
@media (max-width: 768px) {
    .card {
        width: 80%;
        position: relative; /* Enable relative positioning */
        margin-top: 30%; /* Move the card down */
    }

    .thumbnail-image {
        width: 70px;
        height: 70px;
        bottom: -35px;
    }

    .card-title {
        font-size: 1.3rem;
    }
}

/* For screens between 769px and 1200px */
@media (max-width: 1200px) {
    .card {
        width: 70%;
        position: relative; /* Enable relative positioning */
        top: 40px; /* Move the card down */
    }

    .thumbnail-image {
        width: 75px;
        height: 75px;
        bottom: -40px;
    }

    .card-title {
        font-size: 1.4rem;
    }
}
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;  /* Initially hidden */
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
    z-index: 9999;
}

.modal-content {
    width: 90%;  /* Default width */
    max-width: 1200px;  /* Max width */
    height: 80%;  /* Default height */
    background-color: #fff;
    border-radius: 8px;
    position: relative;
    display: flex;
    flex-direction: column;
    overflow: hidden; /* Prevent scrolling outside the modal */
    max-height: 90vh;  /* Limit modal height to 90% of viewport height */
    box-sizing: border-box; /* Include padding in the height and width calculation */
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #aaa;
    font-size: 36px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10;
}

.close:hover, .close:focus {
    color: black;
    text-decoration: none;
}

iframe {
    width: 100%;
    height: 100%; /* Fill the remaining space inside the modal */
    border: none;
    box-sizing: border-box; /* Ensure iframe takes full height and width */
    padding-top: 10px; /* Small padding to prevent clipping with close button */
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
        <img style="margin-top:2%;" class="hero-image" src="images/book_online1.png" alt="Rhipo Photography" />
    </div>
    <div class="content-wrapper" style="margin-top:4%;">
        <div class="featured-title"style="margin-left:-1%;">Rhipo Photography</div>
        <div class="post-title" style="margin-top: -2%;">Home > Book Online</div>
        <div class="post-description" style="font-family: 'Alexandria';">
        At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as
        the exceptional Sachinmayee Menon.      </div>
    </div>
<br></br>
    <div class="additional-image-wrapper">
        <img src="images/book_online2.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div> -->

    <div class="main" style="background:url(images/book_online1.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Rhipo Photography</div>
                <div class="post-title" style="margin-top:-2%;">Home > Book Online</div>
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
    </div>
<br></br>
    <div class="card-container">
    <?php
        if ($result->num_rows > 0) {
            // Loop through each row in the database
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card">
                    <div class="card-header">
                        <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="main-image">
                        <img src="images/<?php echo $row['image']; ?>" alt="Thumbnail" class="thumbnail-image">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $row['title']; ?></h2>
                        <p class="card-description">
                            - Videography<br>
                            - Reel<br>
                            - Photography<br>
                            - PersonalShoot
                            <!-- Check out our availability and book the date and time that works for you. -->
                            <!-- <?php echo $row['description']; ?> -->
                        </p>
                        <div class="card-details">
                            <div class="detail-item">
                                <span>Hours</span>
                                <span><?php echo $row['hours']; ?></span>
                            </div>
                            <div class="detail-item">
                                <span>Fees</span>
                                <span><?php echo $row['fees']; ?></span>
                            </div>
                        </div>
                        <a href="book_online.php?id=<?php echo $row['id']; ?>" 
                           class="btn-square" 
                           style="color: #ffffff;" 
                           onclick="openPopup(this.href); return false;">
                            Request To Book
                            <img style="color: #ffffff;" src="images/right_arrow.png" alt="Arrow" class="btn-arrow">
                        </a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No bookings available</p>";
        }
        ?>
    </div>

    <!-- Modal -->
   <div id="popupModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <iframe id="popupIframe" src=""></iframe>
    </div>
</div>

    <script>
       function openPopup(url) {
    const modal = document.getElementById("popupModal");
    const iframe = document.getElementById("popupIframe");

    // Set the iframe's source to the URL
    iframe.src = url;

    // Show the modal by changing display to block
    modal.style.display = "flex";
}

function closeModal() {
    const modal = document.getElementById("popupModal");
    const iframe = document.getElementById("popupIframe");

    // Hide the modal and reset the iframe
    modal.style.display = "none";
    iframe.src = "";
}

// Close the modal if the user clicks outside the content
window.onclick = function (event) {
    const modal = document.getElementById("popupModal");
    if (event.target === modal) {
        closeModal();
    }
};

    </script>
<br></br>
<?php
include('left_sidenav.php');
include('right_sidebar.php');
    include('footer.php');
?>
</body>

</html>