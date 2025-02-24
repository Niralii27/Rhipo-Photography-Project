<?php
include('header.php');

include('config.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $referred = mysqli_real_escape_string($conn, $_POST['referred']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $created_at = date('Y-m-d H:i:s'); // Current timestamp for created_at

    // Insert data into the database
    $sql = "INSERT INTO contact (name, email, phone, service, date, location, referred, comment, created_at) 
            VALUES ('$name', '$email', '$phone', '$service', '$date', '$location', '$referred', '$comment', '$created_at')";

    if (mysqli_query($conn, $sql)) {
        // If insertion is successful, display an alert
        echo "<script>alert('Your contact query submitted successfully!');</script>";
        echo "<script>window.location.href = 'contact.php';</script>"; // Redirect to the contact page
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn); // Close the database connection
}

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

        /* General Reset */


        /* Top Section (Image + Form) */
        /* .top-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            margin-left: 10%;
            margin-right: 10%;
        } */

        /* .image-container {
            flex: 1;
            max-width: 55%;
            margin-left: 1%;
            margin-right: -5%;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        } */

        /* .form-container {
            width: 80%;
            background: #fff;
            margin-top: 1%;
            padding: 20px;
            margin-right: -20%;
            border-radius: 8px;
        } */

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-row.full {
            flex-direction: column;
        }

        .form-group {
            flex: 1;
            margin-right: 10px;
        }

        .form-group:last-child {
            margin-right: 0;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
            color: #9D8161;

        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            color: #667085;

        }

        button {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            color: #667085;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #a77e58;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button:hover {
            background-color: #8c6848;
        }

        .button-icon {
            margin-left: 8px;
        }

        /* Bottom Section (Map + Info) */
        /* .bottom-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            margin-left: 12%;
            gap: 40px;
        } */

        .map-view {
            flex: 1;
            max-width: 45%;
            margin-left: -20%;
            position: relative;
            /* Needed for the clickable overlay */
        }

        /* Responsive Adjustments */
        @media screen and (max-width: 768px) {
            .map-view {
                max-width: 90%;
                /* Adjust width for tablets */
                margin-left: 0;
                /* Center-align the map */
            }
        }

        @media screen and (max-width: 480px) {
            .map-view {
                max-width: 100%;
                /* Use full width for mobile */
                margin-left: 0;
                /* Remove negative margin */
            }
        }


        .map-view img {
            width: 120%;
            height: auto;
            margin-left: -20%;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        /* .info-container {
            flex: 1;
            max-width: 65%;
            margin-top: 5%;
            margin-right: -60%;
        } */
        /* 
        .info-container h2 {
            font-size: 40px;
            color: rgba(0, 0, 0, 0.78);
            font-family: 'The New Elegance';
            font-weight: bold;
        } */

        /* .info-container p {
            font-size: 28px;
            color: #000000;
            margin: 5px 0;
            font-family: 'Alexandria';
            font-weight: 400;
            line-height: 34.13px;
        } */

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            /* .top-section {
                flex-direction: column;
                align-items: center;
            } */
            /* 
            .image-container,
            .form-container {
                width: 112%;
                margin-bottom: 20px;
                margin-left: -10%;
            } */

            .form-group input,
            .form-group select {
                width: 100%;
            }

            /* .bottom-section {
                flex-direction: column;
                align-items: center;
            } */

            /* .map-view {
                max-width: 60%;
                margin-left: -75%;
            }

            .info-container {
                max-width: 100%;
                margin-left: -75%;
            }

            .info-container h2 {
                text-align: center;
            }

            .info-container p {
                text-align: center;
            } */
        }

        @media (max-width: 480px) {
            /* .form-container h1 {
                font-size: 28px;
                text-align: center;
            } */

            button {
                width: 100%;
                text-align: center;
            }
        }

        .error {
            color: rgb(230, 31, 31);
            font-size: 0.875em;
            margin-top: 0.25em;
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
        <img style="margin-top:2%;" class="hero-image" src="images/contact1.png" alt="Rhipo Photography" />
    </div>
    <div class="content-wrapper" style="margin-top:4%;">
        <div class="featured-title" style="margin-left: -1%;">Rhipo Photography</div>
        <div class="post-title" style="margin-top: -2%;">Home > Contact Us</div>
        <div class="post-description" style="font-family: 'Alexandria';">
            At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as
            the exceptional Sachinmayee Menon. </div>
    </div> -->
    <!-- ------------------------------------------------------------------------------------------------------------ -->
    <div class="main" style="background:url(images/contact1.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Rhipo Photography</div>
                <div class="post-title" style="margin-top:-2%;">Home > Contact Us</div>
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
        <img src="images/get_in_touch.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
    </div>
    <br></br>

    <div class="container">
        <div class="row">
            <div class="col-md-5 p-2">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="images/logo2.png" alt="Logo" style="width: 100%;">
                </div>
            </div>

            <div class="col-md-7 p-2">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div>
                        <form id="serviceForm" action="contact.php" method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" placeholder="lorem@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="service">Type Service Required</label>
                                    <select id="service" name="service">
                                        <option value="">Choose an option</option>
                                        <option value="photography">Photography</option>
                                        <option value="videography">Videography</option>
                                        <option value="editing">Editing</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date of Service</label>
                                    <input type="date" id="date" name="date">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="location">Event/Shoot Location</label>
                                    <input type="text" id="location" name="location" placeholder="Address">
                                </div>
                                <div class="form-group">
                                    <label for="referred">Referred By</label>
                                    <input type="text" id="referred" name="referred" placeholder="Referred by">
                                </div>
                            </div>

                            <div class="form-row full">
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea id="comment" name="comment" rows="4" placeholder="Type your message / comment here..."></textarea>
                                </div>
                            </div>

                            <button type="submit" style="width:100%;">
                                Submit <span class="button-icon"><img src="images/submit_vector.png" alter="image1"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="container">
        <div class="row">
        <div class="col-md-7 p-2">
            <div class="d-flex justify-content-center align-items-center" style="flex-direction: column; position: relative;">
                <a 
                    href="https://maps.app.goo.gl/6UPXgFsJc8cAcL418" 
                    target="_blank" 
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; cursor: pointer; text-decoration: none;">
                    <!-- Invisible link area -->
                </a>
                
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2687.158218357818!2d-122.09987732329772!3d47.66192268415512!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x401c62c3136321e5%3A0xb6781c60b17c1af!2sRHIPO%20Photography!5e0!3m2!1sen!2sin!4v1737200820598!5m2!1sen!2sin"
                    height="300"
                    width="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

                    </div>
                </div>

                <div class="col-md-5 p-2 ps-lg-5 ps-md-2 ps-1 pt-mb-0 pt-3">
                    <div style="display: flex;align-items: center;height: 100%;">
                        <div>
                            <p class="mb-1" style="font-family: 'The New Elegance';font-size: 1.6rem;letter-spacing: .02em;">Hitesh Agrawal</p>
                            <p class="mb-1"><b>Redmond, Washington 98052 USA</b></p>
                            <p class="mb-1"><b>T +1 (425) 494 9582</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br></br>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#serviceForm').validate({
                rules: {
                    name: {
                        required: true,
                        pattern: /^[A-Za-z]+$/ // Only allows letters (A-Z, a-z)
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    service: {
                        required: true
                    },
                    date: {
                        required: true
                    },
                    location: {
                        required: true
                    },
                    referred: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name.",
                        pattern: "Name must only contain letters (A-Z, a-z)"
                    },
                    email: {
                        required: "Please enter your email.",
                        email: "Your enter a valid email address."
                    },
                    phone: {
                        required: "Please enter your phone number",
                        digits: "Please enter only digits",
                        minlength: "Phone number must be at least 10 digits",
                        maxlength: "Phone number must not exceed 15 digits"
                    },
                    service: {
                        required: "Please select a service"
                    },
                    date: {
                        required: "Please Enter a Date"
                    },
                    location: {
                        required: "Please Enter a Location"
                    },
                    referred: {
                        required: "Please Enter a Referred By"
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('error');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('error');
                }
            });
        });
    </script>

    <?php
    include('left_sidenav.php');
    include('right_sidebar.php');
    include('footer.php');
    ?>
</body>

</html>