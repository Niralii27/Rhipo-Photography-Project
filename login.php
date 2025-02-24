<?php

session_start(); // Start the session for both registration and login

include('config.php'); // Include database connection

// Initialize error and success variables
$signup_error = "";
$signup_success = "";
$signin_error = "";

// Handle Sign Up form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password1']; // No hashing, store as plain text
    $confirm_password = $_POST['confirm_password'];
    $number = $_POST['number'];

    // Check if email already exists in the database
    $email_check = "SELECT * FROM registration WHERE email = ?";
    $stmt = $conn->prepare($email_check);
    $stmt->bind_param("s", $email); // Bind email as a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $signup_error = "Your email is already registered.";
    } else {
        // Check if passwords match
        if ($password === $confirm_password) {
            // Insert user into database using prepared statements
            $sql = "INSERT INTO registration (name, email, number, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $number, $password); // Insert plain password

            if ($stmt->execute()) {
                $signup_success = "Registration successful! You can now log in.";
            } else {
                $signup_error = "Error: " . $stmt->error;
            }
        } else {
            $signup_error = "Passwords do not match.";
        }
    }
}

// Handle Sign In form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = !empty($_POST['remember']) && $_POST['remember'] === 'on'; // Updated logic for "remember"


    // Prepare the SQL query to prevent SQL injection
    $sql = "SELECT * FROM registration WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // Bind the email parameter to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        if ($email === 'rhipo@gmail.com' && $password === 'RhipoAdmin@2772') {
            // Redirect to the admin page
            echo "<script>
                window.top.location.href = 'admin';
            </script>";
 $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['email'] = $user['email'];
            $_SESSION['number'] = $user['number'];
            $_SESSION['name'] = $user['name']; // Save user's name
            $_SESSION['profile_image'] = $user['profile_image']; // Save user's name
            exit;
        }

        // Verify the password
        if ($password === $user['password']) { // Assuming no hashing for simplicity
            // Store user info in session
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['email'] = $user['email'];
            $_SESSION['number'] = $user['number'];
            $_SESSION['name'] = $user['name']; // Save user's name
            $_SESSION['profile_image'] = $user['profile_image']; // Save user's name

            // Store email in session

            if ($remember) {
                $token = bin2hex(random_bytes(16)); // Generate a random token
                $expiry = time() + (30 * 24 * 60 * 60); // 30 days expiry
                $token_expiry = date("Y-m-d H:i:s", $expiry); // Compute expiry date and time
            
                // Store the token in the database
                $updateTokenSql = "UPDATE registration SET token = ?, token_expiry = ? WHERE id = ?";
                $stmt = $conn->prepare($updateTokenSql);
                $stmt->bind_param("ssi", $token, $token_expiry, $user['id']); // Bind the parameters
                $stmt->execute();
            
                // Set a cookie with the token
                setcookie("auth_token", $token, $expiry, "/", "", true, true);
            }
            

            echo "<script>
            window.top.location.href = 'index.php'; // Redirect the parent page
          </script>";
    exit;
} else {
    $signin_error = "Incorrect password.";
}
} else {
$signin_error = "Email not registered.";
}
}



function show_alert($message) {
    if (!empty($message)) {
        echo "<script>alert('$message');</script>";
    }
}

// Show alerts for specific messages
show_alert($signin_error);
show_alert($signup_error);
show_alert($signup_success);
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and SignUp</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


</head>
<style>
    body{
	margin:0;
	color:#6a6f8c;
	background:#c8c8c8;
	font:600 16px/18px 'Open Sans',sans-serif;
}
*,:after,:before{box-sizing:border-box}
.clearfix:after,.clearfix:before{content:'';display:table}
.clearfix:after{clear:both;display:block}
a{color:inherit;text-decoration:none}

.login-wrap{
	width:100%;
	margin:auto;
	max-width:525px;
	min-height:670px;
	position:relative;
	background:url(images/logo2.png) no-repeat center;
	box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
}
.login-html{
	width:100%;
	height:100%;
	position:absolute;
	padding:90px 70px 50px 70px;
	background:rgba(40,57,101,.9);
}
.login-html .sign-in-htm,
.login-html .sign-up-htm{
	top:0;
	left:0;
	right:0;
	bottom:0;
	position:absolute;
	transform:rotateY(180deg);
	backface-visibility:hidden;
	transition:all .4s linear;
}
.login-html .sign-in,
.login-html .sign-up,
.login-form .group .check{
	display:none;
}
.login-html .tab,
.login-form .group .label,
.login-form .group .button{
	text-transform:uppercase;
	cursor: pointer;
}
.login-html .tab{
	font-size:22px;
	margin-right:15px;
	padding-bottom:5px;
	margin:0 15px 10px 0;
	display:inline-block;
	border-bottom:2px solid transparent;
}
.login-html .sign-in:checked + .tab,
.login-html .sign-up:checked + .tab{
	color:#fff;
	border-color:#1161ee;
}
.login-form{
	min-height:345px;
	position:relative;
	perspective:1000px;
	transform-style:preserve-3d;
}
.login-form .group{
	margin-bottom:15px;
}
.login-form .group .label,
.login-form .group .input,
.login-form .group .button{
	width:100%;
	color:#fff;
	display:block;
}
.login-form .group .input,
.login-form .group .button{
	border:none;
	padding:15px 20px;
	border-radius:25px;
	background:rgba(255,255,255,.1);
}
.login-form .group input[data-type="password"]{
	text-security:circle;
	-webkit-text-security:circle;
}
.login-form .group .label{
	color:#aaa;
	font-size:12px;
}
.login-form .group .button{
	background:#1161ee;
}
.login-form .group label .icon{
	width:15px;
	height:15px;
	border-radius:2px;
	position:relative;
	display:inline-block;
	background:rgba(255,255,255,.1);
}
.login-form .group label .icon:before,
.login-form .group label .icon:after{
	content:'';
	width:10px;
	height:2px;
	background:#fff;
	position:absolute;
	transition:all .2s ease-in-out 0s;
}
.login-form .group label .icon:before{
	left:3px;
	width:5px;
	bottom:6px;
	transform:scale(0) rotate(0);
}
.login-form .group label .icon:after{
	top:6px;
	right:0;
	transform:scale(0) rotate(0);
}
.login-form .group .check:checked + label{
	color:#fff;
	cursor: pointer;
}
.login-form .group .check:checked + label .icon{
	background:#1161ee;
}
.login-form .group .check:checked + label .icon:before{
	transform:scale(1) rotate(45deg);
}
.login-form .group .check:checked + label .icon:after{
	transform:scale(1) rotate(-45deg);
}
.login-html .sign-in:checked + .tab + .sign-up + .tab + .login-form .sign-in-htm{
	transform:rotate(0);
}
.login-html .sign-up:checked + .tab + .login-form .sign-up-htm{
	transform:rotate(0);
}

.hr{
	height:2px;
	margin:60px 0 50px 0;
	background:rgba(255,255,255,.2);
}
.foot-lnk{
	text-align:center;
    color: #ffffff;
}

.error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
<body>

<div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
        <label for="tab-1" class="tab">Sign In</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up">
        <label for="tab-2" class="tab">Sign Up</label>
        <div class="login-form">
            <!-- Sign In Form -->
            <form id="signInForm" action="" method="post">
           
                <div class="sign-in-htm">
                    <div class="group">
                        <label for="signin_email" class="label">Email</label>
                        <input id="email" type="text" name="email" class="input">
                    </div>
                    <div class="group">
                        <label for="signin_password" class="label">Password</label>
                        <input id="password" name="password" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <input id="check" type="checkbox" name="remember" class="check" checked>
                        <label for="check"><span class="icon"></span> Keep me Signed in</label>
                    </div>
                    <div class="group">
                        <input type="submit" name="signin" class="button" value="Sign In">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="change_password1.php">Forgot Password?</a>
                    </div>
                </div>
                <!-- <?php if ($signin_error): ?>
    <p class="error"><?= $signin_error; ?></p>
<?php endif; ?> -->
            </form>
			<script>
  <?php if ($signup_error): ?>
                <p class="error"><?= $signup_error; ?></p>
            <?php endif; ?>
            <?php if ($signup_success): ?>
                <p class="success"><?= $signup_success; ?></p>
            <?php endif; ?>
</script>
            <!-- Sign Up Form -->
            <form id="signUpForm" action="" method="post">
			<!-- <?php if ($signup_error): ?>
    <p class="error"><?= $signup_error; ?></p>
<?php endif; ?>
<?php if ($signup_success): ?>
    <p class="success"><?= $signup_success; ?></p>
<?php endif; ?> -->
                <div class="sign-up-htm">
                    <div class="group">
                        <label for="signup_username" class="label">Username</label>
                        <input id="username" type="text" name="username" class="input">
                    </div>
                    <div class="group">
                        <label for="signup_password" class="label">Password</label>
                        <input id="password1" type="password" name="password1" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <label for="signup_confirm_password" class="label">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <label for="signup_email" class="label">Email Address</label>
                        <input id="email" name="email" type="text" class="input">
                    </div>
                    <div class="group">
                        <label for="signup_number" class="label">Number</label>
                        <input id="number" name="number" type="text" class="input">
                    </div>
                    <div class="group">
                        <input type="submit" class="button" name="signup" value="Sign Up">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">Already Member?</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
        $(document).ready(function() {
			
            $('#signInForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email.",
                        email: "Please enter a valid email address."
                    },
                    password: {
                        required: "Please enter your password.",
                        minlength: "Your password must be at least 8 characters long."
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


		$('#signUpForm').validate({
      rules: {
        name: {
          required: true,
          pattern: /^[A-Za-z\s]+$/
        },
        email: {
          required: true,
          email: true
        },
        number: {
          required: true,
          digits: true,
          minlength: 10
        },
       
        password1: {
          required: true,
          minlength: 8
        },
		confirm_password: {
			required: true,
			equalTo: '#password1'
		}
      },
      messages: {
        name: {
          required: "Please enter your name.",
          pattern: "Name should only contain letters."
        },
        email: {
          required: "Please enter your email address.",
          email: "Please enter a valid email address."
        },
        number: {
          required: "Please enter your phone number.",
          digits: "Please enter a valid phone number.",
          minlength: "Phone number must be at least 10 digits long."
        },
       
        password1: {
          required: "Please enter a password.",
          minlength: "Password must be at least 8 characters long."
        },
        confirm_password: {
          required: "Please confirm your password.",
          equalTo: "Passwords do not match."
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

    </script>


</body>
</html>