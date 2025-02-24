<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>Photography Footer</title>
    <style>
        /* General Reset */
        @font-face {
            font-family: 'The New Elegance';
            src: url('assets/fonts/TheNewElegance-CondensedRegular.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            /* background-color: #F8F4EC; */
        }

        /* Footer Container */
        .footer-container {
            background-color: #E8E3D6;
            /* padding: 30px 20px; */
            padding: 30px 0 0 0;
            color: #333;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }

        /* Footer Sections */
        .footer-section {
            flex: 1;
            min-width: 200px;
            margin: 10px;
        }

        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #9D8161;
        }

        .footer-section p,
        .footer-section a {
            font-size: 14px;
            color: #666666;
            text-decoration: none;
            /* margin-bottom: 5px; */
            /* font-family: 'Alexandria'; */
            /* font-weight: 400; */
            line-height: 24px;
            letter-spacing: 0.05em;
            /* text-align: left; */
            /* text-underline-position: from-font; */
            /* text-decoration-skip-ink: none; */

        }

        .footer-section a:hover {
            text-decoration: underline;
        }

        /* Logo and About */
        /* .logo {
            font-family: 'Times New Roman', serif;
            font-size: 22px;
            margin-right: 60px;
            color: #9D8161;
        } */

        /* .social-icons img {
            width: 20px;
            margin-right: 10px;
            cursor: pointer;
        } */

        .footeri {
            display: flex;
            gap: 12px !important;
            font-size: 1.5rem;
        }

        /* Quick Links */
        /* .footer-section ul {
            list-style: none;
        } */

        .footer-section ul li {
            /* margin: 5px 0; */
        }

        /* Inquire Now */
        .book-now {
            background-color: #9D8161;
            color: #FFF;
            border: none;
            /* padding: 8px 16px; */
            font-size: 14px;
            /* cursor: pointer; */
            /* margin-top: 10px; */
        }

        .book-now:hover {
            background-color: #84684a;
        }

        /* Gallery */
        .gallery-images {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
        }

        .gallery-images img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        /* @media (max-width: 768px) {
            .gallery-images {
                margin-left: 25%;
                grid-template-columns: repeat(3, 1fr); */
        /* 2 columns */
        /* }
        } */

        /* For small screens (phones)  */
        /*  @media (max-width: 480px) { */
        /* .gallery-images {
                grid-template-columns: 3fr; */
        /* 1 column */
        /* }
        } */

        /* Footer Bottom */
        .footer-bottom {
            /* text-align: center; */
            /* padding: 10px 0;
            margin-bottom: -30px; */
            /* margin-left: -30px;
            margin-right: -20px; */
            /* background-color: #B89B7D;
            color: #FFF; */
            /* font-size: 14px; */
            background-color: #9D8161;
            color: white;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }


        .btn-square1 {
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
        }

        .btn-square .btn-arrow {
            color: #ffffff;
            /* Ensures arrow icon is also white */
        }
    </style>
</head>

<body>

    <!-- ----------------------------------------------------<NIRALI>--------------------------------------------------------- -->
    <!-- Footer Section -->
    <!-- <footer class="footer-container">
        <div class="footer-content"> -->

    <!-- Logo and About -->
    <!-- <div class="footer-section about" style="margin-right:-100px; margin-left:100px;">
                <div class="logo">
                    <img src="logo.png" alt="Hitesh Agrawal RHIPO Photography"
                        style="max-width: 65%; height: auto; margin-left:-35%;">
                </div>

                <p
                    style="font-family: 'Alexandria';font-size: 16px;font-weight: 400;line-height: 24px;letter-spacing: 0.05em;">
                    Your Trusted Wedding and <br> Portrait Photographer Seattle - <br> RHIPO Photography</p>
                <div class="social-icons">
                    <br>
                    <a href="#"><img src="images/insta.png" alt="Instagram"></a>
                    <a href="#"><img src="images/facebook.png" alt="Instagram"></a>
                    <a href="#"><img src="images/youTube.png" alt="YouTube"></a>
                    <a href="#"><img src="images/linkedIn.png" alt="LinkedIn"></a>
                </div>
            </div> -->

    <!-- Quick Links -->
    <!-- <div class="footer-section links" style="margin-right:-90px; margin-left:90px;">
                <h3 style="font-family: 'The New Elegance';font-size: 16px;font-weight: 400;">QUICK LINKS</h3>
                <ul>
                    <li><a href="portfolio.php">Portfolio</a></li>
                    <li><a href="client.php">Clients</a></li>
                    <li><a href="book.php">Book Online</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div> -->

    <!-- Get In Touch -->
    <!-- <div class="footer-section contact">
                <h3 style="font-family: 'The New Elegance';font-size: 16px;font-weight: 400;">GET IN TOUCH</h3>
                <p>
                    <img src="images/person.png" alt="Location Icon"
                        style="width: 24px; height: 24px; vertical-align: middle; margin-right: 8px;">
                    Hitesh Agrawal
                </p>
                <p>
                    <img src="images/location.png" alt="Location Icon"
                        style="width: 24px; height: 24px; vertical-align: middle; margin-right: 8px;">
                    Redmond, Washington 98052 USA
                </p>
                <p>
                    <img src="images/phone.png" alt="Phone Icon"
                        style="width: 24px; height: 24px; vertical-align: middle; margin-right: 8px;">
                    +1 (425) 494 9582
                </p>
                <p>
                    <img src="images/email.png" alt="Email Icon"
                        style="width: 24px; height: 24px; vertical-align: middle; margin-right: 8px;">
                    rhipo.photog@gmail.com
                </p>
            </div> -->


    <!-- Inquire Now -->
    <!-- <div class="footer-section inquire">
                <h3 style="font-family: 'The New Elegance';font-size: 16px;font-weight: 400;">INQUIRE NOW</h3>
                <img src="images/capture.png" alt="Email Icon"
                    style="width: 224px; height: 104px; vertical-align: middle; margin-right: 8px;">
                <br>
                </br>
                </a>
                <a href="book.php" class="btn-square1" style="color: #ffffff;">BOOK NOW
                    <img style="color: #ffffff;" src="images/white_Arrow.png" alt="Arrow" class="btn-arrow">

                </a>
            </div> -->

    <!-- Gallery -->
    <!-- <div class="footer-section gallery" style="margin-right:100px; margin-left:-100px;">
                <h3 style="font-family: 'The New Elegance';font-size: 16px;font-weight: 400;">GALLERY</h3>
                <div class="gallery-images">
                    <img src="images/gallery1.png" alt="Photo 1">
                    <img src="images/gallery2.png" alt="Photo 2">
                    <img src="images/gallery3.png" alt="Photo 3">
                    <img src="images/gallery4.png" alt="Photo 4">
                    <img src="images/gallery5.png" alt="Photo 5">
                    <img src="images/gallery6.png" alt="Photo 6">
                </div>
            </div>

        </div>
        <br>
        </br>
        <div class="footer-bottom">
            <p style="font-family: 'Montserrat';
font-size: 18px;
font-weight: 500;
line-height: 32px;
text-underline-position: from-font;
text-decoration-skip-ink: none;
">Copyright 2024, Rhipo Photography. All Rights Reserved</p>
        </div>
    </footer> -->

    <!-- ----------------------------------------------------<POOJAA>--------------------------------------------------------- -->
    <!-- Footer Section -->
    <section class="footer-container">
        <div class="footer-content">
            <div class="container">
                <div class="row">

                    <!-- Logo and About -->
                    <div class="col-lg-2 col-md-6">
                        <div>
                            <img src="logo.png" alt="Hitesh Agrawal RHIPO Photography" class="navbar-logo mb-3"
                                style="height: 3rem;">
                        </div>
                        <p style="color:#666666">Your Trusted Wedding and Portrait
                            Photographer Seattle -
                            RHIPO
                            Photography</p>
                        <div class="footeri mb-3">
                            <a href="#"><img src="images/insta.png" alt="Instagram"></a>
                            <a href="#"><img src="images/facebook.png" alt="Instagram"></a>
                            <a href="#"><img src="images/youTube.png" alt="YouTube"></a>
                            <a href="#"><img src="images/linkedIn.png" alt="LinkedIn"></a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-section links">
                            <h3 style="font-family: 'The New Elegance';font-size: 16px;font-weight: 400;">QUICK
                                LINKS
                            </h3>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="portfolio.php">Portfolio</a></li>
                                <li class="nav-item mb-2"><a href="client.php">Clients</a></li>
                                <li class="nav-item mb-2"><a href="book.php">Book Online</a></li>
                                <li class="nav-item mb-2"><a href="blog.php">Blog</a></li>
                                <li class="nav-item mb-2"><a href=" contact.php">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Get In Touch -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-section contact">
                            <h3 style="font-family: 'The New Elegance';font-size: 16px;font-weight: 400;">GET IN TOUCH
                            </h3>
                            <p>
                                <img src="images/person.png" alt="Location Icon" style="margin-right: 8px;">
                                Hitesh Agrawal
                            </p>
                            <p>
                                <img src="images/location.png" alt="Location Icon" style=" margin-right: 8px;">
                                Redmond, Washington 98052 USA
                            </p>
                            <p>
                                <img src="images/phone.png" alt="Phone Icon" style="middle; margin-right: 8px;">
                                +1 (425) 494 9582
                            </p>
                            <p>
                                <img src="images/email.png" alt="Email Icon" style="margin-right: 8px;">
                                rhipo.photog@gmail.com
                            </p>
                        </div>
                    </div>

                    <!-- Inquire Now -->
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-section inquire">
                            <h3 style="font-family: 'The New Elegance';font-size: 16px;margin-bottom: 39px;">
                                INQUIRE NOW
                            </h3>
                            <p style="font-family:'Royal Wedding'; font-size: 86px; color:#9D8161;">Capture</p>
                            <p style="color:black;">Your Moments Now</p>
                            <a href="book.php" class="btn-square1" style="color: #ffffff;">BOOK NOW
                                <img style="color: #ffffff;" src="images/white_Arrow.png" alt="Arrow" class="btn-arrow">

                            </a>
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-section gallery">
                            <h3 style="font-family: 'The New Elegance';font-size: 16px;font-weight: 400;">GALLERY</h3>
                            <div class="gallery-images">
                                <img src="images/gallery1.png" alt="Photo 1">
                                <img src="images/gallery2.png" alt="Photo 2">
                                <img src="images/gallery3.png" alt="Photo 3">
                                <img src="images/gallery4.png" alt="Photo 4">
                                <img src="images/gallery5.png" alt="Photo 5">
                                <img src="images/gallery6.png" alt="Photo 6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom mt-2">
            <p style="font-family: 'Montserrat'; font-size: 18px; font-weight: 600; line-height: 32px; margin-bottom: 0;
    padding: 1rem 0.5rem 1rem 0.5rem;">
                Copyright 2024, Rhipo Photography. All Rights Reserved</p>
        </div>
    </section>
</body>

</html>