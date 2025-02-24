<?php
include('header.php');

include('config.php');

$query = "SELECT * FROM admin_portfolio WHERE status='active'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width: device-width, initial-scale=1.0">
    <title>Rhipo Photography</title>
    <link rel="icon" href="images/logo2.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=The+New+Elegance&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;600;700&family=Italiana&display=swap"
        rel="stylesheet">
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
            /* width: 100%; */
            /* background: white; */
            /* position: relative; */
        }

        .container {
            padding: 2rem 4rem !important;
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

        .list-container {
            /* margin-top: 20px; */
            /* margin-left: 12%; */
            width: 100%;
            max-width: 420px;
            border: 2px solid #9D8161;
            /* border-radius: 2px; */
            background-color: #fff;
            padding: 1.5rem;
            border-top-right-radius: 50px;
        }

        .list-container ul {
            list-style-type: none;
            padding: 0;
        }

        .list-container li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: clamp(16px, 1.5vw, 20px);
            font-weight: 400;
            cursor: pointer;
            border-bottom: 1px solid #ccc;
            font-family: 'Alexandria';
            line-height: 1.7;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
        }

        .list-container li:hover {
            color: #9D8161;
            background-color: #f0f0f0;
        }

        .list-container li .icon {
            font-size: clamp(16px, 1.5vw, 20px);
            color: #000000;
            transition: transform 0.3s ease;
        }

        .list-container li:hover .icon {
            color: #9D8161;
            transform: scale(1.2);
        }

        /* .right-content {
            flex: 1;
            min-width: 300px;
            padding: 15px;
        } */

        .right-content h2 {
            /* font-size: clamp(28px, 3vw, 40px); */
            font-weight: 700;
            padding-top: .5rem;
            letter-spacing: .1rem;
            /* margin-right: 5%; */
            color: rgba(0, 0, 0, 0.81);
            font-family: 'The New Elegance';
            line-height: 1.7;
            /* text-align: left; */
            /* text-underline-position: from-font; */
            /* text-decoration-skip-ink: none; */
        }

        .right-content p {
            /* font-size: clamp(16px, 1.5vw, 20px); */
            /* margin-right: 20%; */
            color: #555;
            font-size: 1.2rem;
            /* font-family: 'Alexandria';
            font-weight: 400;
            line-height: 1.6;
            text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none; */
        }
*/

        .content-section {
            display: none;
            /* Hide all content sections by default */
        }

        #wednesdays-content {
            display: block;
            /* Make Weddings content visible by default */
        }

    
        .left-side2 h2 {
            /* font-size: 44px; */
            /* font-weight: 400; */
            color: #333333;
            font-family: 'The New Elegance';
            /* line-height: 80px; */
            letter-spacing: 0.02em;
            /* text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none; */

        }

        .left-side2 p {
            font-size: 16px;
            color: #666666;
            line-height: 32px;
            letter-spacing: 0.02em;
         

        }
        

        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }


        .slider img {
            width: 100%;
            height: 32vmax;
            overflow: hidden;
            border-top-left-radius: 150px;
        }

        .slider2 img {
            width: 100%;
            height: 32vmax;
            overflow: hidden;
            border-top-right-radius: 150px;
        }

        .main-container2 .slider2 img {
           
            width: 100%;
            height: 32vmax;
            overflow: hidden;
            /* border-top-right-radius: 150px !important; */
        }

        /* Square Slider for main-container3 */
        .main-container3 .slider img {
            width: 100%;
            height: 32vmax;
            overflow: hidden;
            border-top-right-radius: 150px;
        }

        /* Navigation Buttons */
        .slider-nav {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-nav button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .slider-nav button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Dot Navigation */
        /* .dots {
            display: flex;
            justify-content: center;
            position: absolute;
            bottom: 10px;
            left: -10%;
            width: 100%;
        }

        .dot {
            height: 10px;
            width: 10px;
            margin: 0 5px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .dot.active {
            background-color: #f1f1f1;
        } */



        /* Responsive Styles */
        @media (max-width: 1024px) {
            /* .main-container2 {
                flex-direction: column; */
            /* Stack content vertically on medium screens */
            /* padding: 20px;
            } */

            /* .left-side2,
            .right-side2 {
                margin: 0; */
            /* Remove side margins */
            /* width: 100%; */
            /* Make sections take full width */
            /* } */

            .left-side2 h2 {
                font-size: 22px;
                /* Adjust font size for smaller screens */
            }

            .left-side2 p {
                font-size: 14px;
                /* Adjust font size for smaller screens */
            }

            .slider-container {
                margin-bottom: 20px;
                /* Add spacing below the image */
            }

        }

        @media (max-width: 768px) {
            /* .main-container2 {
                flex-direction: column-reverse; */
            /* Image on top, text below */
            /* padding: 10px;
            } */

            .left-side2 {
                text-align: center;
                /* Center align content */
            }

            .left-side2 h2 {
                font-size: 24px;
                /* Smaller heading */
                line-height: 36px;
                margin-bottom: 10px;
            }

            .left-side2 p {
                font-size: 12px;
                line-height: 20px;
                margin: 0 auto;
                /* Center text block */
                width: 90%;
            }

            .slider-container {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            /* .main-container2 {
                flex-direction: column-reverse; */
            /* Reverse order: image above content */

            /* padding: 10px; */
            /* } */

            .left-side2 h2 {
                font-size: 18px;
            }

            .left-side2 p {
                font-size: 12px;
            }

            .slider-container {
                margin-bottom: 20px;
                /* Add space between image and text */
            }

        }

        /* .main-container3 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 50px auto;
            padding: 20px;
            margin-top: -5%;
            max-width: 1200px;
        } */

        /* Left Side: Slider */
        /* .left-side3 {
            flex: 1; */
        /* Take 50% width */
        /* margin-left: -13%;
        } */



        /* Right Side: Content */
        /* .right-side3 {
            flex: 1; */
        /* Take 50% width */
        /* margin-right: -10%;
            background-color: #fafafa;

        } */

        .right-side3 h2 {
            /* margin-bottom: 15px; */
            /* font-size: 44px; */
            /* font-weight: 400; */
            color: #000000;
            font-family: 'The New Elegance';
            /* line-height: 80px; */
            letter-spacing: 0.02em;
            /* padding-top: .8rem; */
            /* text-align: left; */
            /* text-underline-position: from-font;
            text-decoration-skip-ink: none; */
        }

        .right-side3 p {
            /* font-size: 16px; */
            color: #666666;
            /* font-family: 'Alexandria'; */
            /* font-weight: 400; */
            line-height: 32px;
            letter-spacing: 0.02em;
            /* text-align: left;
            text-underline-position: from-font;
            text-decoration-skip-ink: none; */
        }

        /* @media (max-width: 768px) {
            .main-container3 {
                flex-direction: column;
                text-align: center;
            } */

        /* .left-side3,
            .right-side3 {
                width: 100%;
                margin: 10px 0;
            } */


        /* .right-side3 {
                padding: 0;
            } */
        /* } */

        .btn-square {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            background-color: #ffffff;
            color: #9D8161;
            /* font-family: 'Alexandria'; */
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid #9D8161;
            /* border-radius: 4px; */
            transition: all 0.3s ease;
            cursor: pointer;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-square:hover {
            background-color: #9D8161;
            color: #ffffff;
            border-color: #9D8161;
        }

        .btn-square:hover .btn-arrow {
            filter: brightness(0) invert(1);
            /* Inverts brown to white */
        }

        /* Contact Section */
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

            .testimonial-content,
            .contact-content {
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

        @media (max-width:500px) {
            .container {
                padding: 1rem !important;
            }
        }

        @media (max-width:767px) {

            .slider img {
                width: 100%;
                height: 54vmax;
                overflow: hidden;
                border-top-left-radius: 150px;
            }

            .slider2 img {
                width: 100%;
                height: 54vmax;
                overflow: hidden;
                border-top-right-radius: 150px;
            }

            .slider-img-for-responsive,
            .slider-img-for-responsive2 {
                display: flex;
                justify-content: center !important;
                align-items: center;
            }
        }

        /* .image-container {
            text-align: center;
            margin-top: 20px;
        } */

        .responsive-image {
            width: 100%;
            /* max-width: 1250px; */
            /* Adjust based on your image size */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .slider-img-for-responsive {
            display: flex;
            justify-content: end;
            align-items: center;
        }

        .slider-img-for-responsive2 {
            display: flex;
            justify-content: start;
            align-items: center;
        }

        .main {
            background-repeat: no-repeat !important;
            background-position: center !important;
            height: 27rem;
            width: 100%;
            background-size: cover !important;
            position: relative;
        }

        /* .mainContent {
            display: flex;
            background-size: 100% 100%;
            background-repeat: no-repeat; */
        /* position: relative; */
        /* justify-content: center;
            flex-direction: column;
            align-items: center;
        } */
    </style>
</head>

<body>

    <!-- -------------------------------------------------------------------------------------------------------- -->
    <div class="main" style="background:url(images/portfolio1.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Rhipo Photography</div>
                <div class="post-title" style="margin-top:-2%;">Home > Portfolio</div>
                <div class="post-description" style="font-family: 'Alexandria';">
                    At RHIPO Photography, we have had the privilege of working with numerous talented individuals,
                    but few have
                    left as profound an impression as the exceptional Sachinmayee Menon.
                </div>
            </div>
        </div>
    </div>

<br></br>

    <!-- Additional Image Section -->
    <div style="padding:2rem 0 0 0;" class="d-flex justify-content-center">
        <img src="images/portfolio2.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div>
<br></br>

    <!-- New List Section inside a square container with plus icons -->
    <div class="container">
        <div class="row justify-content-center">
            <!-- New List Section inside a square container with plus icons -->
            <div class="col-md-5 p-2">
                <div class=" d-flex justify-content-center align-items-center">
                    <div class="list-container">
                        <ul>
                            <li onclick="toggleContent('weddings')">WEDDINGS <span class="icon"><i
                                        class="fas fa-plus"></i></span>
                            </li>
                            <li onclick="toggleContent('personal-events')">PERSONAL EVENTS <span class="icon"><i
                                        class="fas fa-plus"></i></span></li>
                            <li onclick="toggleContent('corporate-events')">CORPORATE EVENTS <span class="icon"><i
                                        class="fas fa-plus"></i></span></li>
                            <li onclick="toggleContent('commercial-events')">COMMERCIAL EVENTS <span class="icon"><i
                                        class="fas fa-plus"></i></span></li>
                            <li onclick="toggleContent('product-photography')">PRODUCT PHOTOGRAPHY <span class="icon"><i
                                        class="fas fa-plus"></i></span></li>
                            <li onclick="toggleContent('family-portraits')">FAMILY PORTRAITS <span class="icon"><i
                                        class="fas fa-plus"></i></span></li>
                            <li onclick="toggleContent('fashion-portraits')">FASHION PORTRAITS <span class="icon"><i
                                        class="fas fa-plus"></i></span></li>
                            <li onclick="toggleContent('boudoir')">BOUDOIR <span class="icon"><i
                                        class="fas fa-plus"></i></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right-Side Content -->
            <div class="col-md-7 p-2">
                <div class=" d-flex justify-content-center align-items-center">
                    <div class="right-content">
                        <div id="weddings-content" class="content-section">
                            <h2>Weddings Event Photographer</h2>
                            <p>Welcome to RHIPO Photography’s event portfolio! Here, you’ll find a collection of stunning
                                photographs from both personal and corporate events we’ve captured across Seattle and the
                                surrounding areas. Whether it’s an intimate family celebration, a large-scale corporate
                                event,
                                or a
                                private gathering, our photography captures every moment with precision and
                                creativity.<br></br>

                                From weddings to corporate conferences, and milestone celebrations to private parties, RHIPO
                                Photography delivers professional, high-quality images that showcase the essence of your
                                special
                                event. Our Seattle-based event photography services are tailored to meet the unique needs of
                                each
                                occasion, ensuring that every important moment is beautifully preserved.<br></br>

                                Explore our gallery and see why we are among the top choices for Seattle event photography.
                                Let
                                us
                                help you capture memories that last a lifetime.</p>
                        </div>
                        <div id="personal-events-content" class="content-section">
                            <h2>Personal Event Photographer</h2>
                            <p>Welcome to RHIPO Photography’s event portfolio! Here, you’ll find a collection of stunning
                                photographs from both personal and corporate events we’ve captured across Seattle and the
                                surrounding areas. Whether it’s an intimate family celebration, a large-scale corporate
                                event,
                                or a
                                private gathering, our photography captures every moment with precision and
                                creativity.<br></br>

                                From weddings to corporate conferences, and milestone celebrations to private parties, RHIPO
                                Photography delivers professional, high-quality images that showcase the essence of your
                                special
                                event. Our Seattle-based event photography services are tailored to meet the unique needs of
                                each
                                occasion, ensuring that every important moment is beautifully preserved.<br></br>

                                Explore our gallery and see why we are among the top choices for Seattle event photography.
                                Let
                                us
                                help you capture memories that last a lifetime.</p>
                        </div>
                        <div id="corporate-events-content" class="content-section">
                            <h2>Corporate Event Photographer</h2>
                            <p>Welcome to RHIPO Photography’s event portfolio! Here, you’ll find a collection of stunning
                                photographs from both personal and corporate events we’ve captured across Seattle and the
                                surrounding areas. Whether it’s an intimate family celebration, a large-scale corporate
                                event,
                                or a
                                private gathering, our photography captures every moment with precision and
                                creativity.<br></br>

                                From weddings to corporate conferences, and milestone celebrations to private parties, RHIPO
                                Photography delivers professional, high-quality images that showcase the essence of your
                                special
                                event. Our Seattle-based event photography services are tailored to meet the unique needs of
                                each
                                occasion, ensuring that every important moment is beautifully preserved.<br></br>

                                Explore our gallery and see why we are among the top choices for Seattle event photography.
                                Let
                                us
                                help you capture memories that last a lifetime.</p>
                        </div>
                        <div id="commercial-events-content" class="content-section">
                            <h2>Commercial Event Photographer</h2>
                            <p>Welcome to RHIPO Photography’s event portfolio! Here, you’ll find a collection of stunning
                                photographs from both personal and corporate events we’ve captured across Seattle and the
                                surrounding areas. Whether it’s an intimate family celebration, a large-scale corporate
                                event,
                                or a
                                private gathering, our photography captures every moment with precision and
                                creativity.<br></br>

                                From weddings to corporate conferences, and milestone celebrations to private parties, RHIPO
                                Photography delivers professional, high-quality images that showcase the essence of your
                                special
                                event. Our Seattle-based event photography services are tailored to meet the unique needs of
                                each
                                occasion, ensuring that every important moment is beautifully preserved.<br></br>

                                Explore our gallery and see why we are among the top choices for Seattle event photography.
                                Let
                                us
                                help you capture memories that last a lifetime.</p>
                        </div>
                        <div id="product-photography-content" class="content-section">
                            <h2>Product Event Photographer</h2>
                            <p>Welcome to RHIPO Photography’s event portfolio! Here, you’ll find a collection of stunning
                                photographs from both personal and corporate events we’ve captured across Seattle and the
                                surrounding areas. Whether it’s an intimate family celebration, a large-scale corporate
                                event,
                                or a
                                private gathering, our photography captures every moment with precision and
                                creativity.<br></br>

                                From weddings to corporate conferences, and milestone celebrations to private parties, RHIPO
                                Photography delivers professional, high-quality images that showcase the essence of your
                                special
                                event. Our Seattle-based event photography services are tailored to meet the unique needs of
                                each
                                occasion, ensuring that every important moment is beautifully preserved.<br></br>

                                Explore our gallery and see why we are among the top choices for Seattle event photography.
                                Let
                                us
                                help you capture memories that last a lifetime.</p>
                        </div>
                        <div id="family-portraits-content" class="content-section">
                            <h2>Family Event Photographer</h2>
                            <p>Welcome to RHIPO Photography’s event portfolio! Here, you’ll find a collection of stunning
                                photographs from both personal and corporate events we’ve captured across Seattle and the
                                surrounding areas. Whether it’s an intimate family celebration, a large-scale corporate
                                event,
                                or a
                                private gathering, our photography captures every moment with precision and
                                creativity.<br></br>

                                From weddings to corporate conferences, and milestone celebrations to private parties, RHIPO
                                Photography delivers professional, high-quality images that showcase the essence of your
                                special
                                event. Our Seattle-based event photography services are tailored to meet the unique needs of
                                each
                                occasion, ensuring that every important moment is beautifully preserved.<br></br>

                                Explore our gallery and see why we are among the top choices for Seattle event photography.
                                Let
                                us
                                help you capture memories that last a lifetime.</p>
                        </div>
                        <div id="fashion-portraits-content" class="content-section">
                            <h2>Fashion Event Photographer</h2>
                            <p>Welcome to RHIPO Photography’s event portfolio! Here, you’ll find a collection of stunning
                                photographs from both personal and corporate events we’ve captured across Seattle and the
                                surrounding areas. Whether it’s an intimate family celebration, a large-scale corporate
                                event,
                                or a
                                private gathering, our photography captures every moment with precision and
                                creativity.<br></br>

                                From weddings to corporate conferences, and milestone celebrations to private parties, RHIPO
                                Photography delivers professional, high-quality images that showcase the essence of your
                                special
                                event. Our Seattle-based event photography services are tailored to meet the unique needs of
                                each
                                occasion, ensuring that every important moment is beautifully preserved.<br></br>

                                Explore our gallery and see why we are among the top choices for Seattle event photography.
                                Let
                                us
                                help you capture memories that last a lifetime.</p>
                        </div>
                        <div id="boudoir-content" class="content-section">
                            <h2>Boudoir Event Photographer</h2>
                            <p>Welcome to RHIPO Photography’s event portfolio! Here, you’ll find a collection of stunning
                                photographs from both personal and corporate events we’ve captured across Seattle and the
                                surrounding areas. Whether it’s an intimate family celebration, a large-scale corporate
                                event,
                                or a
                                private gathering, our photography captures every moment with precision and
                                creativity.<br></br>

                                From weddings to corporate conferences, and milestone celebrations to private parties, RHIPO
                                Photography delivers professional, high-quality images that showcase the essence of your
                                special
                                event. Our Seattle-based event photography services are tailored to meet the unique needs of
                                each
                                occasion, ensuring that every important moment is beautifully preserved.<br></br>

                                Explore our gallery and see why we are among the top choices for Seattle event photography.
                                Let
                                us
                                help you capture memories that last a lifetime.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- slider -->
    <?php
    if (mysqli_num_rows($result) > 0) {
        // Loop through each item and dynamically generate the content
        $counter = 0; // This will help us alternate between main-container2 and main-container3
        while ($item = mysqli_fetch_assoc($result)) {
            // Check if the counter is even or odd to alternate between container 2 and container 3
            if ($counter % 2 == 0) {
                // main-container2
                echo '
                <div class="container p-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-7 col-md-7 p-2">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="main-container2">
                               <!-- Left Side Content -->
                                <div class="left-side2">
                                    <h2>' . htmlspecialchars($item['title']) . '</h2>
                                    <p>' . nl2br(htmlspecialchars($item['description'])) . '</p>
                                    <div>
                                       <a href="portfolio_inner.php?id=' . htmlspecialchars($item['id']) . '" class="btn-square" style="margin-bottom: 10px;">VIEW ALBUM
                                         <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                       </a>
                                       <a href="book.php" class="btn-square">BOOK NOW
                                       <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                       </a>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                          <!-- Right Side Image Slider -->
                        <div class="col-lg-5 col-md-5 p-2">
                        <div class="slider-img-for-responsive h-100">
                            <div class="right-side2">
                                <div class="slider-container">
                                    <div class="slider">
                                        <div class="slide"><img src="images/' . htmlspecialchars($item['slider_image1']) . '" alt="Slide 1"></div>
                                        <div class="slide"><img src="images/' . htmlspecialchars($item['slider_image2']) . '" alt="Slide 2"></div>
                                        <div class="slide"><img src="images/' . htmlspecialchars($item['slider_image3']) . '" alt="Slide 3"></div>
                                    </div>
                                    <div class="dots">
                                        <span class="dot" data-slide="0"></span>
                                        <span class="dot" data-slide="1"></span>
                                        <span class="dot" data-slide="2"></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            } else {
                // main-container3
                echo '
                <div class="container p-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-5 p-2">
                        <div class="slider-img-for-responsive2 h-100">
                           <div class="main-container3">
                             <!-- Left Side Image Slider -->
                               <div class="left-side3">
                                    <div class="slider-container" id="slider2">
                                        <div class="slider2">
                                            <div class="slide"><img src="images/' . htmlspecialchars($item['slider_image1']) . '" alt="Slide 1"></div>
                                            <div class="slide"><img src="images/' . htmlspecialchars($item['slider_image2']) . '" alt="Slide 2"></div>
                                            <div class="slide"><img src="images/' . htmlspecialchars($item['slider_image3']) . '" alt="Slide 3"></div>
                                        </div>
                                        <div class="dots">
                                            <span class="dot" data-slider="slider2" data-slide="0"></span>
                                            <span class="dot" data-slider="slider2" data-slide="1"></span>
                                            <span class="dot" data-slider="slider2" data-slide="2"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>


                        <div class="col-lg-7 col-md-7 p-2">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <!-- Right Side Content -->
                            <div class="right-side3">
                                <h2>' . htmlspecialchars($item['title']) . '</h2>
                                <p>' . htmlspecialchars($item['description']) . '</p>
                                <a href="portfolio_inner.php?id=' . htmlspecialchars($item['id']) . '" class="btn-square" style="margin-bottom: 10px;">VIEW ALBUM
                                <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>

                                <a href="book.php" class="btn-square">BOOK NOW
                                <img src="images/arrow1.png" alt="Arrow" class="btn-arrow">
                                </a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            $counter++;
        }
    } else {
        echo "No data found.";
    }
    ?>


    <div style="background: #ffffff;">
        <!-- Diversity Section -->
        <section class="diversity-section">
            <div class="container">
                <div class="image-container">
                    <img src="images/welcome.png" alt="Diversity Section" class="responsive-image">
                </div>
            </div>
        </section>

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
        <script>
            // Function to toggle content and icon
            /// Function to toggle content and icon
            function toggleContent(section) {
                var icon = event.target.closest('li').querySelector('.icon i');
                var content = document.getElementById(section + '-content');

                // Get all icons and set them to 'plus' state
                var allIcons = document.querySelectorAll('.list-container .icon i');
                allIcons.forEach(function(iconElement) {
                    if (!iconElement.classList.contains('fa-plus')) {
                        iconElement.classList.remove('fa-minus');
                        iconElement.classList.add('fa-plus');
                    }
                });

                // Get all content sections and hide them
                var allContent = document.querySelectorAll('.content-section');
                allContent.forEach(function(contentElement) {
                    contentElement.style.display = 'none';
                });

                // Toggle the clicked icon between plus and minus
                if (icon.classList.contains('fa-plus')) {
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                } else {
                    icon.classList.remove('fa-minus');
                    icon.classList.add('fa-plus');
                }

                // Show the clicked content section
                content.style.display = 'block';
            }

            // Initially show the Weddings content by default
            document.addEventListener('DOMContentLoaded', function() {
                var allContent = document.querySelectorAll('.content-section');
                allContent.forEach(function(contentElement) {
                    contentElement.style.display = 'none'; // Hide all content sections by default
                });

                // Show the Weddings content by default
                document.getElementById('weddings-content').style.display = 'block';

                // Set Weddings icon to minus by default
                var weddingsIcon = document.querySelector('.list-container li:first-child .icon i');
                weddingsIcon.classList.remove('fa-plus');
                weddingsIcon.classList.add('fa-minus');
            });

            /* slider */
            // let slideIndex = 0;
            // let slides = document.querySelectorAll('.slide');
            // let dots = document.querySelectorAll('.dot');

            // // Function to show a specific slide
            // function showSlide(index) {
            //     if (index >= slides.length) slideIndex = 0;
            //     if (index < 0) slideIndex = slides.length - 1;

            //     // Hide all slides
            //     slides.forEach(slide => slide.style.display = 'none');

            //     // Remove active class from all dots
            //     dots.forEach(dot => dot.classList.remove('active'));

            //     // Show the current slide
            //     slides[slideIndex].style.display = 'block';

            //     // Add active class to the current dot
            //     dots[slideIndex].classList.add('active');
            // }

            // // Function for automatic slide change
            // function autoSlide() {
            //     slideIndex++;
            //     showSlide(slideIndex);
            // }

            // // Event listener for dot navigation
            // dots.forEach(dot => {
            //     dot.addEventListener('click', function() {
            //         let index = parseInt(dot.getAttribute('data-slide'));
            //         slideIndex = index;
            //         showSlide(slideIndex);
            //     });
            // });

            // Event listeners for manual navigation buttons
            /* document.querySelector('.prev').addEventListener('click', function() {
                slideIndex--;
                showSlide(slideIndex);
            });
            
            document.querySelector('.next').addEventListener('click', function() {
                slideIndex++;
                showSlide(slideIndex);
            }); */

            // Start automatic slideshow
            // setInterval(autoSlide, 3000); // Change slide every 3 seconds

            // Initial slide setup
            // showSlide(slideIndex);

            document.querySelectorAll('.slider-container').forEach((sliderContainer) => {
                let slideIndex = 0;
                let slides = sliderContainer.querySelectorAll('.slide');
                let dots = sliderContainer.querySelectorAll('.dot');

                // Function to show a specific slide
                function showSlide(index) {
                    if (index >= slides.length) slideIndex = 0;
                    if (index < 0) slideIndex = slides.length - 1;

                    // Hide all slides
                    slides.forEach(slide => slide.style.display = 'none');

                    // Remove active class from all dots
                    dots.forEach(dot => dot.classList.remove('active'));

                    // Show the current slide
                    slides[slideIndex].style.display = 'block';

                    // Add active class to the current dot
                    dots[slideIndex].classList.add('active');
                }

                // Function for automatic slide change
                function autoSlide() {
                    slideIndex++;
                    showSlide(slideIndex);
                }

                // Event listener for dot navigation
                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        slideIndex = i;
                        showSlide(slideIndex);
                    });
                });

                setInterval(autoSlide, 3000); // Change slide every 3 seconds

                // Initial slide setup
                showSlide(slideIndex);
            });
        </script>

        <?php
        include_once('footer.php');
        include('left_sidenav.php');
        include('right_sidebar.php');
        ?>

</body>

</html>