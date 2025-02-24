<?php
session_start();
include('config.php');

if (isset($_POST['otp_btn'])) {
    
    if (isset($_SESSION['forgot_email'])) {

       $email = $_SESSION['forgot_email'];
        $otp = $_POST['otp'];

        // Fetch the OTP from the database for the given email
        $query = "SELECT otp FROM password_token WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_otp = $row['otp'];

            // Compare the OTPs
            if (trim($otp) == $db_otp) {
                // Redirect to new password page
                ?>
                <script>
                    window.location.href = 'change_password2.php';
                </script>
                <?php
                exit; // Always add exit after a redirect
            } else {
                setcookie('error', 'Incorrect OTP', time() + 5, '/');
                ?>
                <script>
                    window.location.href = 'otp_form.php';
                </script>
                <?php
                exit;
            }
        } else {
            setcookie('error', 'OTP has expired. Regenerate New OTP', time() + 2, '/');
            ?>
            <script>
                window.location.href = 'change_password1.php';
            </script>
            <?php
            exit;
        }
    }
    else {
        echo 'session not defined';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            display: flex;
            background: #c8c8c8;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background:rgba(40,57,101,.9);
            background-position: center; /* Center the background image */
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .form-group label {
            font-weight: bold;
        }

        #message-container {
            text-align: center;
            color: red;
            margin-top: 10px;
        }
        .btn-orange {
            background-color: #1161ee; /* Set background color to orange */
            border: none; /* Remove border */
            color: white; /* Set text color to white */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row text-center">
            
        </div>
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2"></div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-xs-12 col-sm-12">
                <br>
                <div class="card p-4">
                    <form method="post" id="form1">
                        <div class="form-group">
                        <div class="col-12  text-white p-5 align-center" style="margin-left:10%;">
                <h1>OTP Verification</h1>
            </div>
                            <label for="userotp"><b>OTP:</b></label>
                            <input type="text" class="form-control" id="otp1" name="otp" placeholder="Enter OTP" required>
                        </div>
                        <br>
                        <div id="timer" class="text-danger"></div>
                        <br>
                        <input type="button" id="resend_otp" class="btn btn-warning " style="display:none; background-color: #1161ee;" value="Resend OTP">
                        <script>
                            let timeLeft = 60; // 1 minute timer
                            const timerDisplay = document.getElementById('timer');
                            const resendButton = document.getElementById('resend_otp');

                            // Function to start the countdown
                            function startCountdown() {
                                const countdown = setInterval(() => {
                                    if (timeLeft <= 0) {
                                        clearInterval(countdown);
                                        timerDisplay.innerHTML = "You can now resend the OTP.";
                                        resendButton.style.display = "inline";
                                        timeLeft = 60;
                                    } else {
                                        timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;
                                    }
                                    timeLeft -= 1;
                                }, 1000);
                            }

                            // Check if there's a remaining time in sessionStorage
                            if (sessionStorage.getItem('otpTimer')) {
                                timeLeft = parseInt(sessionStorage.getItem('otpTimer'));
                                startCountdown();
                            } else {
                                startCountdown();
                            }

                            // Update sessionStorage every second
                            setInterval(() => {
                                sessionStorage.setItem('otpTimer', timeLeft);
                            }, 1000);

                            resendButton.onclick = function(event) {
                                event.preventDefault(); // Prevent the default form submission
                                window.location.href = 'resend_otp_forgot_password.php';
                            };
                        </script>
                        <input type="submit" class="btn btn-orange" value="Submit" name="otp_btn" />
                    </form>
                </div>
                <div id="message-container">
                    <?php
                    if (isset($_COOKIE['error'])) {
                        echo $_COOKIE['error'];
                    }
                    ?>
                </div>
            </div>
        </div>
        <br>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
