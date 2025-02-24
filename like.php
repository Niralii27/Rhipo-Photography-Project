<?php

$sql = "SELECT views, likes FROM blog WHERE id = $blog_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $blog = $result->fetch_assoc();
    $viewCount = $blog['views'];
    $likeCount = $blog['likes'];
} else {
    die("Blog post not found.");
}

// Check if the user has already viewed the blog in this session
if (!isset($_SESSION['viewedBlog_' . $blog_id])) {
    // Increment the view count in the database
    $viewCount++;
    $updateSql = "UPDATE blog SET views = $viewCount WHERE id = $blog_id";
    $conn->query($updateSql);

    // Mark this blog as viewed in the session
    $_SESSION['viewedBlog_' . $blog_id] = true;
}
// Check if the user has already liked the blog in this session
if (isset($_POST['like'])) {
    if (!isset($_SESSION['likedBlog_' . $blog_id])) {
        // Increment the like count in the database
        $likeCount++;
        $updateLikeSql = "UPDATE blog SET likes = $likeCount WHERE id = $blog_id";
        $conn->query($updateLikeSql);

        // Mark this blog as liked in the session
        $_SESSION['likedBlog_' . $blog_id] = true;
    }
}
// Close the database connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Interaction</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Global styles */
      

        /* Container for the entire section */
        .social-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
        }

        /* First line with social media icons */
        .social-icons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 15px;
            flex-wrap: wrap; /* Allows icons to wrap in smaller screens */
        }

        .social-icon {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .social-icon:hover {
            background-color: #ddd;
        }

        .social-icon i {
            font-size: 24px;
            color: #333;
        }

        /* Like button style (with initial brown border and white heart) */
        .like-button {
            border: 2px solid #9D8161; /* Initial border color */
            color: #9D8161; /* Initial text color */
            border-radius: 50%;
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white; /* White background initially */
            margin-right: 10px;
            box-sizing: content-box;
        }

        .like-button.liked {
            background-color: #9D8161; /* Background color when liked */
            color: white; /* Text color when liked */
            border-color: #9D8161; /* Same color for border when liked */
        }

        .like-button.liked i {
            color: white; /* White color for the heart icon when liked */
        }

        .like-button i {
            color: #9D8161; /* Brown color for the heart icon initially */
        }

        .like-button:hover {
            background-color: #f0f0f0; /* Light background on hover */
        }

        /* Like count next to the button */
        .like-count {
            font-size: 18px;
            color: #333;
            display: inline-block;
            vertical-align: middle;
        }

        /* View Counter */
        .view-counter {
            font-size: 16px;
            color: #333;
            margin-top: 10px;
            display: flex;
            align-items: center;
        }

        .view-counter i {
            font-size: 18px;
            margin-right: 5px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .social-icon {
                padding: 10px;
                font-size: 20px;
            }

            .like-button {
                padding: 10px 20px;
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .social-icons {
                gap: 10px;
            }

            .social-icon {
                padding: 8px;
                font-size: 18px;
            }

            .like-button {
                padding: 8px 15px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .social-container {
                padding: 10px;
            }

            .social-icons {
                gap: 8px;
            }

            .social-icon {
                padding: 6px;
                font-size: 16px;
            }

            .like-button {
                padding: 6px 12px;
                font-size: 12px;
            }
        }

        @media (max-width: 320px) {
            .social-icon {
                padding: 5px;
                font-size: 14px;
            }

            .like-button {
                padding: 5px 10px;
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="social-container">
        <!-- First Line: Social Media Icons -->
        <div class="social-icons">
         <!-- Facebook -->
         <button class="social-icon facebook" onclick="openFacebookAndCopy()">
            <i class="fab fa-facebook"></i>
        </button>

        <!-- Twitter -->
        <button class="social-icon twitter" onclick="openTwitterAndCopy()">
            <i class="fab fa-twitter"></i>
        </button>

        <!-- Instagram -->
        <button class="social-icon instagram" onclick="openInstagramAndCopy()">
            <i class="fab fa-instagram"></i>
        </button>

            <button class="social-icon copy-link" onclick="copyPageURL()">
            <i class="fas fa-link"></i>
        </button>
        </div>

        <!-- Like Icon with Count (like icon will toggle between filled and outlined) -->
        <form method="POST">
            <button type="submit" name="like" class="like-button <?php if (isset($_SESSION['likedBlog_' . $blog_id])) echo 'liked'; ?>">
                <i class="fas fa-heart"></i>
            </button>
        </form>
        <span class="like-count" id="like-count"><?php echo $likeCount; ?></span> <!-- Display Like Count -->

        <!-- View Counter (without a button) -->
        <div class="view-counter">
            <i class="far fa-eye"></i>
            <span id="view-count"><?php echo $viewCount; ?> views</span>
        </div>
    </div>

    <script>
        let likeCount = <?php echo $likeCount; ?>; // Get the initial like count from PHP
        const likeButton = document.querySelector('#like-button');
        const heartIcon = likeButton.querySelector('i');
        const likeCountDisplay = document.querySelector('.like-count');

        // Toggle like button and update the like count on click
        likeButton.addEventListener('click', function() {
            likeButton.classList.toggle('liked'); // Toggle the 'liked' state

            if (likeButton.classList.contains('liked')) {
                likeCount++; // Increment like count when liked
                heartIcon.classList.remove('far');
                heartIcon.classList.add('fas'); // Filled heart when liked
            } else {
                likeCount--; // Decrement like count when unliked
                heartIcon.classList.remove('fas');
                heartIcon.classList.add('far'); // Outlined heart when unliked
            }
            
            likeCountDisplay.textContent = likeCount; // Update like count display

            // Submit the form (without page refresh)
            document.getElementById('like-form').submit();
        });

        //copy link 
        function copyPageURL() {
        // Get the current page URL
        const pageURL = window.location.href;

        // Copy URL to clipboard
        navigator.clipboard.writeText(pageURL).then(() => {
            // Notify the user that the URL has been copied
            alert("Blog Link copied to clipboard!");
        }).catch(err => {
            console.error("Failed to copy URL: ", err);
        });
    }

    function openFacebookAndCopy() {
        const pageURL = window.location.href;
        navigator.clipboard.writeText(pageURL).then(() => {
            alert("Blog Link copied to clipboard! Opening Facebook...");
            window.open("https://www.facebook.com/", "_blank");
        }).catch(err => {
            console.error("Failed to copy URL: ", err);
        });
    }

    function openTwitterAndCopy() {
        const pageURL = window.location.href;
        navigator.clipboard.writeText(pageURL).then(() => {
            alert("Blog Link copied to clipboard! Opening Twitter...");
            window.open("https://www.twitter.com/", "_blank");
        }).catch(err => {
            console.error("Failed to copy URL: ", err);
        });
    }

    function openInstagramAndCopy() {
        const pageURL = window.location.href;
        navigator.clipboard.writeText(pageURL).then(() => {
            alert("Blog Link copied to clipboard! Opening Instagram...");
            window.open("https://www.instagram.com/", "_blank");
        }).catch(err => {
            console.error("Failed to copy URL: ", err);
        });
    }
    </script>
</body>
</html>
