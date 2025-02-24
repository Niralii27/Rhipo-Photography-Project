<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Right-Side Floating Icons</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .floating-icons {
            position: fixed; /* Keeps the container floating */
            top: 50%; /* Vertically centers the container */
            right: 1%; /* Aligns it to the right side */
            transform: translateY(-50%); /* Centers exactly */
            display: flex;
            flex-direction: column; /* Arranges icons vertically */
            gap: 15px; /* Space between icons */
        }

        .floating-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px; /* Icon container width */
            height: 60px; /* Icon container height */
            background-color: #9D8161; /* Background color */
            color: white; /* Icon color */
            border-radius: 50%; /* Makes icons circular */
            text-decoration: none; /* Removes underline */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Slight shadow */
            transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth hover effect */
            font-size: 24px; /* Icon size */
        }

        .floating-icons a:hover {
            background-color: #7C664D; /* Darker shade on hover */
            transform: scale(1.1); /* Slightly enlarges on hover */
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
    .floating-icons a {
        width: 50px; /* Smaller icon size for tablets */
        height: 50px;
        font-size: 20px;
        left: 200px; /* Keep the icons within the screen */
    }
}

@media screen and (max-width: 480px) {
    .floating-icons a {
        width: 40px; /* Smallest size for mobile */
        height: 40px;
        font-size: 18px;
        right: 1%; /* Adjust to prevent overflow */
    }
}
    </style>
    <!-- Importing Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Floating Icons -->
    <div class="floating-icons">
        <a href="https://www.instagram.com" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.facebook.com" target="_blank">
            <i class="fab fa-facebook"></i>
        </a>
    </div>
</body>
</html>
