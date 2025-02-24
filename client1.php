<?php
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width: device-width, initial-scale=1.0">
    <title>Privacy Policy - RHIPO Photography</title>
    <link href="https://fonts.googleapis.com/css2?family=The+New+Elegance&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;600;700&family=Italiana&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=New+Elegance&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
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
            background: white;
            position: relative;
        }

        .hero-section {
            width: 100%;
            height: 616px;
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
        }

        .content-wrapper {
            width: 1560px;
            height: 300px;
            position: absolute;
            left: 180px;
            top: 296px;
            background: rgba(42.06, 42.06, 42.06, 0.30);
            border-top-left-radius: 150px;
            backdrop-filter: blur(54px);
            padding: 40px 200px;
        }

        .featured-title {
            color: #CDCDCD;
            font-size: 28px;
            font-family: 'Italiana', serif;
            font-weight: 400;
            text-transform: capitalize;
            margin-bottom: 20px;
        }

        .post-title {
            color: white;
            font-size: 32px;
            font-family: 'The New Elegance';
            font-weight: 400;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        .post-description {
            color: #CDCDCD;
            font-size: 16px;
            font-weight: 400;
            line-height: 32px;
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

        .additional-image-wrapper {
            margin-top: 35%; /* Space above the image */
            text-align: center; /* Center the image */
        }

        .additional-image-wrapper img {
            max-width: 100%; /* Responsive image */
            height: auto; /* Maintain aspect ratio */
        }

        @media (max-width: 1200px) {
            .container {
                width: 100%;
            }

            .content-wrapper {
                width: 100%;
                left: 10px;
                top: 50px;
                padding: 20px 40px;
            }

            .featured-title {
                font-size: 24px;
            }

            .post-title {
                font-size: 28px;
            }

            .post-description {
                font-size: 14px;
            }

            .post-meta {
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .hero-image {
                width: 120%;
                margin-top: 20%;
                margin-left: -10%;
                top: 0;
            }

            .content-wrapper {
                width: 90%;
                left: 5%;
                top: 30%;
                padding: 20px 30px;
            }

            .featured-title {
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
        }

        @media (max-width: 480px) {
            .hero-image {
                width: 100%;
                margin-left: 0;
            }

            .content-wrapper {
                width: 100%;
                left: 0;
                top: 20%;
                padding: 15px;
            }

            .featured-title {
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
            }
        }

        .content-section {
    display: none; /* Hide all content sections by default */
}

# wednesdays-content {
    display: block; /* Make Weddings content visible by default */
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
    width: 30%; /* Default: 3 items per row */
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-sizing: border-box;
}

/* Main image styling */
.main-image {
    width: 100%; /* Adjust the width to fill the container */
    height: auto;
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
    font-size: 28px;
    font-weight: bold;
    margin: 5px 0;
    color : #000000;
    font-family: 'The New Elegance';
}

.icon {
    width: 34px; /* Adjust size of the icon */
    height: 34px;
    margin-left: 90%; 
    margin-top: -10%;/* Space between title and icon */
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
        width: 45%; /* 2 items per row */
    }
}

/* Small screens (mobile phones) */
@media (max-width: 480px) {
    .item {
        width: 100%; /* 1 item per row */
    }

    .main-image {
        width: 100%; /* Ensure the main image fits within the container */
    }

    .title {
        font-size: 16px;
    }

    .subtitle {
        font-size: 12px;
    }

    .icon {
        width: 20px; /* Smaller icons on mobile */
        height: 20px;
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

</style>
</head>
<body>
    <div class="container">
        <div class="hero-background"></div>
        <img style="margin-top:2%;" class="hero-image" src="images/client2.png" alt="Rhipo Photography" />
    </div>
    <div class="content-wrapper" style="margin-top:4%;">
        <div class="featured-title">Rhipo Photography</div>
        <div class="post-title">Home > Client Portfolio</div>
        <div class="post-description" style="font-family: 'Alexandria';">
        At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as
the exceptional Sachinmayee Menon.         </div>
    </div>
<br></br>
    <!-- Additional Image Section -->
    <div class="additional-image-wrapper">
        <img src="images/client_Showcase.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div>

    <div class="container">
    <div class="item">
        <img src="images/client_Showcase1.png" alt="Main Image" class="main-image">
        <div class="text">
            <h3 class="title">
            Zayn Birthday 2023
            </h3>
            <img src="images/button1.png" alt="Icon" class="icon">

            <p class="subtitle">Zayn Birthday 2023</p>
        </div>
    </div>
    <div class="item">
        <img src="images/client_Showcase2.png" alt="Main Image" class="main-image">
        <div class="text">
            <h3 class="title">
            Yogini Birthday 2023
            </h3>
            <img src="images/button1.png" alt="Icon" class="icon">

            <p class="subtitle">January 2nd 2023</p>
        </div>
    </div>
    <div class="item">
        <img src="images/client_Showcase3.png" alt="Main Image" class="main-image">
        <div class="text">
            <h3 class="title">
            Marcus & Erika  </h3>
            <img src="images/button1.png" alt="Icon" class="icon">

            <p class="subtitle">October 22, 2022</p>
        </div>
    </div>
</div>
<div><br></br>
<a href="#" class="btn-square" style="color: #ffffff;">Load More....
                <img style="color: #ffffff;" src="images/down_arrow.png" alt="Arrow" class="btn-arrow">
            </a>  
</div> <br></br>
<?php
    include('footer.php');
    ?>
</body>
</html>
