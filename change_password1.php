<?php
session_start();
// Include PHPMailer classes
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include database connection
include('config.php');

if (isset($_POST['get_otp'])) {
    $email = $_POST['email'];
    $_SESSION['forgot_email'] = $email;
    // Check if the email exists in the registration table
    $check_query = "SELECT * FROM registration WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $query = "SELECT * FROM password_token WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $current_time = date("Y-m-d H:i:s");

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $created_at = $row['created_at'];
            $expiry_time = date("Y-m-d H:i:s", strtotime($created_at . ' +1 minute'));

            if ($current_time < $expiry_time) {
                setcookie('error', "OTP is already sent to email address. Please wait for 60 seconds to generate a new OTP.", time() + 5, "/");
                echo "<script>window.location.href = 'otp_form.php';</script>";
                exit;
            } else {
                // Delete the old OTP if it has expired
                $delete_query = "DELETE FROM password_token WHERE email = '$email'";
                mysqli_query($conn, $delete_query);
            }
        }

        // Generate a new OTP
        $otp = rand(100000, 999999);

        // Use PHPMailer to send the OTP
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'akbarinirali27@gmail.com'; // Your email
            $mail->Password = 'byey uwbv ebys fnlr'; // Your email password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('akbarinirali27@gmail.com', 'akbari nirali'); // Sender details
            $mail->addAddress($email); // Recipient email

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body = "
                <html>
                <body>
                    <h1>Forgot Your Password?</h1>
                    <p>Your OTP is: <strong>$otp</strong></p>
                    <p>Please use this OTP to reset your password. This OTP will expire in 1 minutes.</p>
                </body>
                </html>
            ";

            $mail->send();

            // Insert OTP details into the database
            $email_time = date("Y-m-d H:i:s");
            $expiry_time = date("Y-m-d H:i:s", strtotime('+1 minutes'));
            $query = "INSERT INTO password_token (email, otp, created_at, expires_at) VALUES ('$email', '$otp', '$email_time', '$expiry_time')";
            mysqli_query($conn, $query);

            setcookie('success', "OTP has been sent to your email.", time() + 2, "/");
            echo "<script>window.location.href = 'otp_form.php';</script>";
            exit;
        } catch (Exception $e) {
            setcookie('error', "Failed to send OTP. Please try again.", time() + 2, "/");
            echo "<script>window.location.href = 'change_password1.php';</script>";
            exit;
        }
    } else {
        setcookie('error', "Email is not registered.", time() + 5, "/");
        echo "<script>window.location.href = 'change_password1.php';</script>";
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transparent Form - Get OTP</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #c8c8c8;
      margin: 0;
    }

    .form-container {
	  background:rgba(40,57,101,.9);
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
      background-position: center; /* Center the background image */
      background-size: cover; /* Cover the entire background */
      backdrop-filter: blur(18px); /* Apply blur effect */
      width: 550px;
      border-radius: 10px; /* Round the corners */
      height: 380px;
    }

    h1 {
      text-align: center;
      color: #ffffff;
      margin-bottom: 20px;
      margin-top: 15%;
    }

    .grid-row {
      display: flex;
      flex-direction: column;
    }

    .grid-item {
      margin-bottom: 15px;
      width: 310px;
    }

    input[type="email"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-top: 5%;
      margin-left: 35%;
      background: rgba(255, 255, 255, 0.8);
      color: #333;
      font-size: 16px;
    }

    button {
      width: 60%;
      padding: 10px;
      background-color: #1161ee; /* Button background color */
      color: #fff;
      border: none;
      margin-left: 55%;
      border-radius: 5px;
      margin-top: 5%;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color:rgb(31, 20, 102); /* Darker shade of orange on hover */
    }

    #message-container {
      text-align: center;
      color: red;
      margin-top: 10px;
    }
  </style>
  <!-- Include jQuery and jQuery Validation Plugin -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#transparent-form").validate({
        rules: {
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          email: {
            required: "Please enter your email address.",
            email: "Please enter a valid email address."
          }
        },
        submitHandler: function (form) {
          form.submit();
        }
      });
    });
  </script>
</head>
<body>
  <div class="form-container">
    <form id="transparent-form" method="POST">
      <h1>Change Password</h1>
      <br>
      <div class="grid-row">
        <div class="grid-item">
          <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
          
        </div>
        <br>
        <div class="grid-item">
          <button type="submit" name="get_otp">GET OTP</button>
        </div>
        <div id="message-container">
          <?php
          if (isset($_COOKIE['error'])) {
              echo $_COOKIE['error'];
          }
          ?>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
