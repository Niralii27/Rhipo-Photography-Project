<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rhipo Photography</title>
    <link rel="icon" href="images/logo2.png" type="image/png">    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
    .header {
        
    display: flex;
    margin-top: 10px;
    justify-content: space-between;
    align-items: center;
    width: 100%; /* Ensures the header spans the full width */
    overflow: hidden;
    padding: 10px 30px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.logo {
    flex: 1;
    display: flex;
    justify-content: center;
}

.logo img {
    height: 50px; /* Adjust logo height */
}

.nav-links {
    display: flex;
    gap: 20px;
    list-style: none;
    padding: 10;
    margin: 0;
    flex-wrap: wrap; /* Wrap navigation items if they exceed screen width */
}

.nav-links a {
    text-decoration: none;
    color: #9D8161;
    font-weight: 700;
    font-size: 14px;
    margin-left: 5px;
    line-height: 24px;
    text-align: left;
    text-underline-position: from-font;
    text-decoration-skip-ink: none;
}

.nav-links a:hover {
    color: #423629;
    font-weight: bold; /* Hover color */
}

/* Log In Button Styling */
a.btn-login {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #9D8161;
    color: #ffffff;
    font-family: 'Alexandria', sans-serif;
    font-size: 14px;
    margin-top: -10px;
    font-weight: 700;
    text-decoration: none;
    padding: 6px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

a.btn-login .arrow-icon {
    margin-left: 8px; /* Space between text and arrow */
    height: 16px; /* Adjust size */
    width: 16px; /* Adjust size */
}

a.btn-login:hover {
    background-color: #715834;
}


.burger-menu {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .burger-icon {
            width: 25px;
            height: 4px;
            background-color: #9D8161;
        }
        .burger-dropdown {
    display: none;
    justify-content: center; 
    align-items: center;
    list-style: none;
    padding: 0; 
    margin: 0;
}
.burger-dropdown .btn-user {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    font-size: 16px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #ddd;
}

.burger-dropdown .btn-user img {
    margin-right: 10px;
}

.burger-dropdown .btn-user:hover {
    background-color: #f4f4f4;
}
.header .burger-menu {
    position: absolute;
    left: 20px; /* Keeps burger menu on the left */
    top: 4%; /* Aligns vertically */
    transform: translateY(-50%);
    z-index: 10; /* Ensures it is visible on top */
}

/* Center the logo across all pages */
.header .logo {
    margin: 0 auto; /* Centers the logo */
    display: flex;
    width: 200px;
    justify-content: center;
    align-items: center;
}
body.index-page .header .burger-menu {
    left: 20px; 
}

        /* Responsive Styles */
        @media (max-width: 768px) {
    /* Hide Left and Right Nav Links */
    .nav-links {
        display: none;
    }

    .burger-menu {
        display: flex;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
    }

    .burger-icon {
        width: 25px;
        height: 4px;
        background-color: #9D8161;
    }

    /* Show Burger Dropdown */
    .burger-dropdown {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background-color: white;
        z-index: 1000;
        padding: 20px 0;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .burger-dropdown.active {
        display: flex;
    }
}

    </style>
 
</head>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const burgerMenu = document.querySelector('.burger-menu');
    const burgerDropdown = document.querySelector('.burger-dropdown');

    burgerMenu.addEventListener('click', () => {
        burgerDropdown.classList.toggle('active');
    });
});

</script>
<body>
    <!-- Header Section -->
    <header class="header">

    <div class="burger-menu">
            <div class="burger-icon"></div>
            <div class="burger-icon"></div>
            <div class="burger-icon"></div>
        </div>
        <!-- Left Navigation Links -->
        <ul class="nav-links"style="margin-left:8%;">
            <li><a href="index.php">HOME</a></li>
            <li><a href="privacy_policy.php">PRIVACY POLICY</a></li>
            <li><a href="portfolio.php">PORTFOLIO</a></li>
            <li>
        <?php
        // Check if user is logged in
        if (isset($_SESSION['name'])) {
            echo '<a href="client.php">CLIENTS</a>';
        } else {
            echo '<a href="login.php" data-bs-toggle="modal" data-bs-target="#loginModal">CLIENTS</a>'; // Redirect to login page
        }
        ?>
    </li>        </ul>

        <!-- Center Logo -->
        <div class="logo">
            <img style="width:30%;" src="logo.png" alt="Logo">
        </div>


         
        <!-- Right Navigation Links -->
        <ul class="nav-links"style="margin-right:10%;;">
            <li><a href="book.php">BOOK ONLINE</a></li>
            <li><a href="client_review.php">REVIEWS</a></li>
            <li><a href="blog.php">BLOG</a></li>
            <li><a href="contact.php">CONTACT</a></li>
            <!-- <li><a href="#" class="btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">LOG IN</a></li> -->
            <li>
    <?php
    
    if (isset($_SESSION['name'])) {
        // User is logged in, show their name
        echo '<a href="#" class="btn-user" style="display: flex; align-items: center;" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas">';
        echo '<img src="' . (isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image']) ? htmlspecialchars($_SESSION['profile_image']) : 'images/user.png') . '" alt="User Icon" style="width: 28px; height: 28px; border-radius: 50%; margin-right: 8px;">';
       
        echo htmlspecialchars($_SESSION['name']); // Safely display the name
        echo '</a>';
    } else {
        // User is not logged in, show the login button
        echo '<a href="#" class="btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">LOG IN</a>';
    }
    ?>
</li>
</ul>


    <!-- <img src="images/arrow.png" alt="Arrow" class="arrow-icon" /> -->
    <ul class="burger-dropdown nav-links">
        <li><a href="index.php">HOME</a></li>
        <li><a href="privacy_policy.php">PRIVACY POLICY</a></li>
        <li><a href="portfolio.php">PORTFOLIO</a></li>
        <li><a href="client.php">CLIENTS</a></li>
        <li><a href="book.php">BOOK ONLINE</a></li>
        <li><a href="client_review.php">REVIEWS</a></li>
        <li><a href="blog.php">BLOG</a></li>
        <li><a href="contact.php">CONTACT</a></li>
        <li>
            <?php if (isset($_SESSION['name'])): ?>
                <a href="#" class="btn-user" style="display: flex; align-items: center;" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas">
                    <img src="<?php echo isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image']) ? htmlspecialchars($_SESSION['profile_image']) : 'images/user.png'; ?>" 
                         alt="User Icon" 
                         style="width: 28px; height: 28px; border-radius: 50%; margin-right: 8px;">
                    <?php echo htmlspecialchars($_SESSION['name']); ?>
                </a>
            <?php else: ?>
                <a href="#" class="btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">LOG IN</a>
            <?php endif; ?>
        </li>
    </ul>
</header>
    

    <!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-height: 90vh;"> <!-- Larger modal and custom height -->
        <div class="modal-content" style="height: 90vh;"> <!-- Full modal height -->
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Log In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow-y: auto;"> <!-- Allows scrolling if content exceeds height -->
                <!-- Embed login.php -->
                <iframe src="login.php" style="width: 100%; height: 85vh; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Profile Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="profileOffcanvas" aria-labelledby="profileOffcanvasLabel" style="height:55%; background-color: #ffffff;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title d-flex justify-content-between align-items-center" id="profileOffcanvasLabel">
            Profile
            <!-- Edit Icon -->
            <a href="javascript:void(0);" class="edit-icon" style="  font-size: 18px;   
                color: #007bff;   
                text-decoration: none;
                cursor: pointer;
                margin-left: 10px;" title="Edit Profile" onclick="openEditProfile()">
                <i class="fas fa-edit"></i>
            </a>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Profile content is embedded here -->
        <iframe id="profileIframe" src="profile.php" style="width: 100%; height: 100%; border: none;"></iframe>
    </div>
</div>



<script>
   window.addEventListener("message", function (event) {
    if (event.data === "logout-success") {
        // Close modal and offcanvas
        const modalElement = document.getElementById('loginModal');
        const offcanvasElement = document.getElementById('profileOffcanvas');

        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) modal.hide(); // Close modal
        }

        if (offcanvasElement) {
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
            if (offcanvas) offcanvas.hide(); // Close offcanvas
        }

        // Replace profile button with login button
        const userButton = document.querySelector(".btn-user");
        if (userButton) {
            userButton.outerHTML = `
                <a href="#" class="btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                    LOG IN
                </a>`;
        }

        // Allow a brief moment for pop-up closures, then redirect
        setTimeout(function () {
            window.location.href = "index.php";
        }, 300); // 300ms delay to ensure UI changes are applied before redirect
    }
});


    function openEditProfile() {
        document.getElementById('profileIframe').src = 'update_profile.php';
    }

    
</script>

<!-- <script>
    // Listen for a message from the iframe
    window.addEventListener("message", function(event) {
        if (event.data === "login-success") {
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('profileOffcanvas'));

            // modal.hide();
            if (modal) modal.hide(); // Close login modal
            if (offcanvas) offcanvas.hide(); // Close profile offcanvas


            // const loginButton = document.querySelector(".btn-login");
            // if (loginButton) {
            //     loginButton.outerHTML = `
            //         <a href="user_profile.php" class="btn-user" style="display: flex; align-items: center;">
            //             <img src="user-icon.png" alt="User Icon" style="width: 24px; height: 24px; border-radius: 50%; margin-right: 8px;">
            //             Profile
            //         </a>`;
            // }
            const userButton = document.querySelector(".btn-user");
            if (userButton) {
                userButton.outerHTML = `
                    <a href="#" class="btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                        LOG IN
                    </a>`;
            }

            // Redirect to the index.php page
            window.location.href = "index.php";
        }
    });

   

</script> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
