<?php
// Include PHPMailer classes
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include database connection
include('config.php');
session_start();

if (isset($_SESSION['forgot_email'])) {
    $email = $_SESSION['forgot_email'];
    
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
        $mail->Subject = 'Your New OTP for Password Reset';
        $mail->Body = "
            <html>
            <body>
                <h1>Forgot Your Password?</h1>
                <p>Your new OTP is: <strong>$otp</strong></p>
                <p>Please use this OTP to reset your password. This OTP will expire in 1 minutes.</p>
            </body>
            </html>
        ";

        // Send the email
        if (!$mail->send()) {
            throw new Exception("Mailer Error: " . $mail->ErrorInfo);
        }

        // Update OTP details in the database
        $email_time = date("Y-m-d H:i:s");
        $expiry_time = date("Y-m-d H:i:s", strtotime('+10 minutes'));

        // Prepare and execute the update statement
        $stmt = $conn->prepare("UPDATE password_token SET otp = ?, created_at = ?, expires_at = ? WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("ssss", $otp, $email_time, $expiry_time, $email);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                setcookie('success', "A new OTP has been sent to your email.", time() + 2, "/");
            } else {
                setcookie('error', "Failed to update the OTP in the database.", time() + 2, "/");
            }
            $stmt->close();
        } else {
            setcookie('error', "Failed to prepare the SQL statement.", time() + 2, "/");
        }

        echo "<script>window.location.href = 'otp_form.php';</script>";
        exit;

    } catch (Exception $e) {
        setcookie('error', "Failed to send OTP. Please try again. Error: " . $e->getMessage(), time() + 2, "/");
        echo "<script>window.location.href = 'otp_form.php';</script>";
        exit;
    }
} else {
    setcookie('error', "Session expired. Please try again.", time() + 2, "/");
    echo "<script>window.location.href = 'otp_form.php';</script>";
    exit;
}
?>
