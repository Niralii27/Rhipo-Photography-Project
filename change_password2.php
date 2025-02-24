<?php	
// Start Generation Here
session_start(); 
include('config.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-image: url('images/logo2.png'); /* Replace with your background image URL */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background:rgba(40,57,101,.9);
            border: none; /* Remove border */
            border-radius: 10px; /* Round the corners */
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5); /* Shadow for depth */
        }

        .btn-orange {
            background-color: blue; /* Set background color to orange */
            border: none; /* Remove border */
            color: white; /* Set text color to white */
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#form1").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    password: {
                        required: "Please enter a password",
                        minlength: "Password must be at least 8 characters long"
                    },
                    confirm_password: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                }
            });
        });
    </script>
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
                        <div class="col-12  text-white p-1 align-center" style="margin-left: 20%;">
                <h1>Reset Password</h1>
            </div>
                            <label for="password"><b>Password:</b></label>
                            <input type="password" class="form-control" id="password" placeholder="Enter new password" name="password" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="confirm_password"><b>Confirm Password:</b></label>
                            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm new password" name="confirm_password" required>
                        </div>
                        <br>
                        <input type="submit" class="btn  btn-orange" value="Submit" name="reset_pwd_btn" />
                    </form>
                </div>
            </div>
        </div>
        <br>
    </div>

    <?php
    if (isset($_POST['reset_pwd_btn'])) {
        if (isset($_SESSION['forgot_email'])) {
            $email = $_SESSION['forgot_email'];
            $password = $_POST['password'];

            // Update the user's password in the users table (assuming the table is named 'users')
            $update_query = "UPDATE registration SET password = '$password' WHERE email = '$email'";
            if (mysqli_query($conn, $update_query)) {
                // Delete the token from the password_token table
                $delete_query = "DELETE FROM password_token WHERE email = '$email'";
                mysqli_query($conn, $delete_query);
                unset($_SESSION['forgot_email']);

                setcookie('success', 'Password has been reset successfully.', time() + 5, '/');
                echo "<script>window.location.href = 'login.php';</script>";
            } else {
                setcookie('error', 'Error in resetting Password.', time() + 5, '/');
                echo "<script>window.location.href = 'otp_form.php';</script>";
            }
        }
    }
    ?>
</body>
</html>
