<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rhipo Photography</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .floating-button,
        .review-button {
            position: fixed; /* Keeps buttons floating on the screen */
            left: 1%; /* Aligns the buttons to the left side */
            transform-origin: left center; /* Keeps rotation point consistent */
            background-color: #9D8161; /* Button color */
            color: #fff; /* Text color */
            border: none; /* No border */
            border-radius: 5px 0 0 5px; /* Rounded corners on the right side */
            padding: 15px 22px; /* Button padding */
            font-size: 18px; /* Font size */
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Adds a slight shadow */
            text-align: center; /* Centers the text */
            transition: background-color 0.3s ease; /* Smooth hover effect */
        }

        .floating-button:hover,
        .review-button:hover {
            background-color: #7D6B53; /* Darker color on hover */
        }

        /* Book Now Button Position */
        .floating-button {
            top: 50%; /* Vertical position for the first button */
            transform: translateY(-50%) rotate(-90deg); /* Rotates the text */
        }

        /* Review Button Position */
        .review-button {
            top: calc(50% + 120px); /* Adds more space between buttons */
            transform: translateY(-50%) rotate(-90deg); /* Rotates the text */
        }

        /* For screens 768px and larger */
        @media screen and (max-width: 768px) {
            .floating-button,
            .review-button {
                padding: 12px 18px; /* Smaller padding for smaller screens */
                font-size: 14px; /* Smaller font size */
                left: 0.5%; /* Reduce left margin */
            }

            /* Adjust position and space for smaller screens */
            .floating-button {
                top: 50%; /* Adjust position for better fit */
            }

            .review-button {
                top: calc(50% + 100px); /* Increase space between buttons */
            }
        }

        /* For extra small mobile screens (below 480px) */
        @media screen and (max-width: 480px) {
            .floating-button,
            .review-button {
                padding: 10px 15px; /* Further reduce padding */
                font-size: 12px; /* Smaller font size */
                left: 0.5%; /* Reduce left margin */
            }

            /* Adjust vertical positioning to ensure space between buttons */
            .floating-button {
                top: 51%; /* Adjust vertical positioning */
            }

            .review-button {
                top: calc(51% + 80px); /* Adjust space for better fit */
            }
        }

        /* For ultra-small screens (very small phones or very low resolutions, below 320px) */
        @media screen and (max-width: 320px) {
            .floating-button,
            .review-button {
                padding: 8px 12px; /* Minimal padding */
                font-size: 10px; /* Smallest font size */
                left: 0.5%; /* Keep the left margin */
            }

            /* Adjust vertical positioning for very small screens */
            .floating-button {
                top: 50%; /* Adjust vertical positioning */
            }

            .review-button {
                top: calc(50% + 60px); /* Increase space between buttons */
            }
        }
    </style>
</head>
<body>
    <!-- Floating Buttons -->
    <button class="floating-button" onclick="redirectToBook()">Book Now</button>
    <button class="review-button" onclick="openReviewPopup()">Review</button>

    <script>
    function redirectToBook() {
        // Redirect to booking page
        window.location.href = "book.php";
    }

    function openReviewPopup() {
        // Open the Google Reviews page in a pop-up window centered on the screen
        const width = 600;
        const height = 500;
        const left = (window.innerWidth - width) / 2; // Centering the window
        const top = (window.innerHeight - height) / 2; // Centering the window

        const options = `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes,status=yes`;
        window.open("google_review.php", "Google Reviews", options);

        // Ensure the URL is correct
        // window.open("https://search.google.com/local/reviews?placeid=ChIJ5SFjE8NiHEARr8EXC8aBZws", "Google Reviews", options);
    }

</script>
</body>
</html>
