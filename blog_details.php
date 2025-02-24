<?php
include('header.php');

include('config.php');

$searchQuery = ''; 
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
}

if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    

    // Fetch blog details from the database
    $query = "SELECT * FROM blog WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $blog_id); // Use prepared statements to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
   
    } else {
        echo "Blog not found!";
        exit;
    }
} else {
    echo "No blog ID provided!";
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=rhipo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Search functionality for blogs
    if (!empty($searchQuery)) {
        $query = "SELECT * FROM blog WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query);
        $searchTerm = "%" . $searchQuery . "%";
        $stmt->execute([$searchTerm, $searchTerm]);
    } else {
        // Default query to fetch latest 3 blogs if no search term is provided
        $query = "SELECT * FROM blog ORDER BY created_at DESC LIMIT 3";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }

    $latestBlogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    // Get form data
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $comment = $conn->real_escape_string($_POST['comment']);
    $blog_title = $blog['title']; // Fetch the title of the current blog

    // Insert into database
    $sql = "INSERT INTO blog_comment (first_name, last_name, email, comment, blog_title, created_at) 
            VALUES ('$first_name', '$last_name', '$email', '$comment', '$blog_title', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Your blog comment has been submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $conn->close();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rhipo Photography</title>
    <link rel="icon" href="images/logo2.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=The+New+Elegance&display=swap" rel="stylesheet">

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
            overflow-x: hidden; /* Disable horizontal scrolling */
        }

        .container {
            width: 100%;
            position: relative;
            
        }

        /* .hero-section {
            width: 100%;
            height: min(616px, 80vh);
            position: relative;
        }

        .hero-background {
            width: 100%;
            height: 150%;
            background: #D9D9D9;
            position: absolute;
        }

        .hero-image {
            width: 150%;
            font-family: 'italic';
            height: auto;
            margin-left: -25%;
            position: absolute;
            top: -20px;
        } */

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
            text-transform: capitalize;
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

        .post-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #CDCDCD;
            font-size: 16px;
            font-family: Alexandria;
            font-weight: 400;
        }

        .post-meta img {
            width: 36px;
            height: 36px;
            border-radius: 28px;
        }

        /* .additional-image-wrapper {
            margin-top: calc(min(616px, 80vh) + 50px);
            text-align: center;
        } */
/* 
        .additional-image-wrapper img {
            max-width: 100%;
            height: auto;
        } */

        @media screen and (max-width: 1680px) {
            /* .content-wrapper {
                left: 5%;
                width: 90%;
                padding: 40px 100px;
                top: 27%;
            } */

            /* .additional-image-wrapper {
                margin-top: 40%;
            } */
        }

        @media screen and (max-width: 1600px) {
            /* .content-wrapper {
                left: 5%;
                width: 90%;
                padding: 40px 100px;
                top: 25%;
            } */

            /* .additional-image-wrapper {
                margin-top: 43%;
            } */
        }

        @media screen and (max-width: 1200px) {
            /* .content-wrapper {
                left: 5%;
                width: 90%;
                top: 20%;
                padding: 40px 100px;
            } */

            /* .additional-image-wrapper {
                margin-top: 50%;
            } */
        }

        @media screen and (max-width: 768px) {
            /* .hero-image {
                width: 200%;
                margin-left: -50%;
            } */
/* 
            .content-wrapper {
                padding: 30px 50px;
                border-top-left-radius: 80px;
                top: 17%;
            } */

            /* .additional-image-wrapper {
                margin-top: 60%;
            } */
        }

        @media screen and (max-width: 480px) {
            /* .hero-image {
                width: 250%;
                margin-left: -75%;
            } */

            /* .content-wrapper {
                padding: 20px 25px;
                border-top-left-radius: 50px;
                top: 10%;
                width: 80vw;
            } */

            /* .additional-image-wrapper {
                margin-top: 80%;
            } */

            .post-meta {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .content-section {
            display: none;
            /* Hide all content sections by default */
        }

        #wednesdays-content {
            display: block;
            /* Make Weddings content visible by default */
        }


        .main-container {
            display: flex;
            justify-content: space-between;
            padding: 40px;
            max-width: 1200px;
            margin: auto;
        }

        .image-container {
            width: 50%;
            position: relative;
        }

        .image-container img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .image-container .caption {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 36px;
            margin-top:-20%;
            color: #9D8161
            font-family: 'The New Elegance'
            font-weight: bold;
        }

        .text-container {
            width: 50%;
            padding-left: 30px;
        }

        .text-container .title {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }

        .text-container .description {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .text-container .author-info {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #777;
        }

        .text-container .author-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .text-container .date {
            margin-left: auto;
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                align-items: center;
            }

            .image-container, .text-container {
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }
           
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 30px;
            margin: auto;
            max-width: 1200px;
        }

        /* Left side - Large Image */
        .image-container {
            position: relative;
            width: 50%;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .image-container .caption {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 40px;
            color: #9D8161
            font-family: 'The New Elegance';
            font-weight: bold;
        }

        .text-below-image {
            font-size: 16px;
            color: #666666;
            margin-top: 20px;
            font-family: 'Alexandria';
font-weight: 400;
line-height: 32px;
letter-spacing: 0.05em;
text-align: left;
text-underline-position: from-font;
text-decoration-skip-ink: none;

        }

        /* Right side - Table of cards */
       /* Blog Table Styling */

       
.blog-table {
    width: 40%;
    padding: 10px;
    display: flex;
    margin-right:-20%;
    flex-direction: column;
    gap: 20px; /* Gap between cards */
}

.blog-card {
    display: flex;
    cursor: pointer;        
    flex-direction: column;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.blog-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
}

.blog-content {
    padding: 20px;
}

.category {
    font-size: 14px;
    color: #6c757d;
    font-weight: bold;
}

.blog-title {
    font-size: 18px;
    color: #333;
    font-weight: bold;
    margin: 10px 0;
    max-width: 350px; /* Set the max-width to the desired value */
    word-wrap: break-word; /* Ensures long words wrap to the next line */
    overflow-wrap: break-word;
    
    display: -webkit-box; /* Create a flexible box layout for text */
    -webkit-line-clamp: 2; /* Limit text to 2 lines (1.5 lines might not be possible directly) */
    -webkit-box-orient: vertical; /* Align the text vertically */
    overflow: hidden; /* Hide the text that overflows */
    text-overflow: ellipsis; /* Show '...' when text overflows */
}

.author {
    display: flex;
    align-items: center;
}

.author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
}

.author-name {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

.date {
    font-size: 12px;
    color: #777;
    margin-left: auto;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .container {
        flex-direction: column; /* Stack content vertically on smaller screens */
        align-items: center;
    }

    .blog-table {
        width: 100%;
    }

    .blog-card {
        margin-top: 20px;
    }
}


/* Image gallery layout */
.image-gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    max-width: 1000px;
    margin: auto;
    align-items: stretch; /* Ensures both panels have the same height */

}

/* Left panel styling */
.left-panel {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 20%;
    justify-content: space-between; /* Spaces the images evenly */
}

.left-panel .small-img {
    width: 100%;
    height: auto;
    flex: 1; /* Ensures all images take equal height */
    object-fit: cover;
    border-radius: 5px;
    transition: transform 0.3s ease;
}

.left-panel .small-img:not(:last-child) {
    margin-bottom: 10px; /* Adds spacing between images */
}
.left-panel .small-img:hover {
    transform: scale(1.05);
}

/* Right panel styling */
.right-panel {
    width: 75%;
}

.right-panel .main-img {
    width: 100%;
    height: 100%;
    border-radius: 5px;
    object-fit: cover;
}


/* Title Styling */
h2 {
    font-family: Alexandria, sans-serif;
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 15px;
}

/* Search Bar Styling */
input[type="text"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 20px;
}
.form-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            margin-top: 3%;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            pointer-events: auto;
        }

        .form-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            font-family: 'Amsterdam Kindom - Personal use';
            line-height: 44px;
            letter-spacing: -0.02em;
            color : #333333

        }

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
            font-family: 'Alexandria';
            line-height: 20px;
            color:#9D8161;

        }

        input, textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }
        button{
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none; 
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
            margin-top: 15px;
        }

        button:hover {
            background-color: #8c6848;
        }

        .error {
            color:rgb(230, 31, 31);
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
            <img style="margin-top:2%;" class="hero-image" src="images/blog3.png" alt="Rhipo Photography" />
        </div>
        <div class="content-wrapper" style="margin-top:4%;">
            <div class="featured-title" margin-left: -1%;>Featured</div>
            <div class="post-title" style="margin-top: -2%;"></div >
            <div class="post-description">At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as the exceptional Sachinmayee Menon.</div>
           
        </div>
    </div>
    </div>
    <div class="additional-image-wrapper" >
</div> -->
<div class="main" style="background:url(images/blog3.png);">
        <div>
            <div class="content-wrapper">
                <div class="featured-title">Rhipo Photography</div>
                <div class="post-title" style="margin-top:-2%;"><?php echo $blog['title']; ?></div>
                <div class="post-description" style="font-family: 'Alexandria';">
                    At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as
                    the exceptional Sachinmayee Menon.
                </div>
            </div>
        </div>
    </div>

<br></br>
   

<div class="container">
    <!-- Left Side: Image and Text -->
    <div class="image-container">
        <!-- <div class="caption" style="color: #9D8161; font-family:'The New Elegance'; font-size:35px;margin-top:-15%;"><?php echo $blog['title']; ?></div> -->

        <img src="uploads/<?php echo $blog['main_image']; ?>" alt="Model Image">
        <div class="text-below-image">
        <p><?php echo nl2br(htmlspecialchars($blog['description'])); ?></p>
        </div>
        <div class="image-gallery">
            <div class="left-panel">
                <img src="uploads/<?php echo $blog['inner_image1']; ?>" alt="Small Image 1" class="small-img">
                <img src="uploads/<?php echo $blog['inner_image2']; ?>" alt="Small Image 2" class="small-img">
                <img src="uploads/<?php echo $blog['inner_image3']; ?>" alt="Small Image 3" class="small-img">
            </div>
            <div class="right-panel">
                <img src="uploads/<?php echo $blog['inner_image4']; ?>" alt="Main Image" class="main-img">
            </div>
            <div class="text-below-image">
            <?php echo nl2br(htmlspecialchars($blog['inner_description'])); ?>            </div>
        </div>
      
    </div>
    
    

   
    <!-- <div class="blog-table">
    <div class="recent-posts">
        <h2 class="recent-posts-title">Recent Posts</h2>
        <div class="search-bar">
            <input type="text" placeholder="Search blog posts..." class="search-input">
        </div>
    </div>
    
        <div class="blog-card">
            <div class="blog-image">
                <img src="images/latest_blogs2.png" alt="Blog Image">
            </div>
            <div class="blog-content">
                <span class="category">Technology</span>
                <h2 class="blog-title">The Impact of Technology on the Workplace: How Technology is...</h2>
                <div class="author">
                    <img src="images/latest_blogs2.png" alt="Author" class="author-avatar">
                    <span class="author-name">Tracey Wilson</span>
                </div>
                <span class="date">August 20, 2022</span>
            </div>
        </div>

        <div class="blog-card">
            <div class="blog-image">
                <img src="images/latest_blogs2.png" alt="Blog Image">
            </div>
            <div class="blog-content">
                <span class="category">Technology</span>
                <h2 class="blog-title">The Impact of Technology on the Workplace: How Technology is...</h2>
                <div class="author">
                    <img src="images/latest_blogs2.png" alt="Author" class="author-avatar">
                    <span class="author-name">Tracey Wilson</span>
                </div>
                <span class="date">August 20, 2022</span>
            </div>
        </div>

        <div class="blog-card">
            <div class="blog-image">
                <img src="images/latest_blogs2.png" alt="Blog Image">
            </div>
            <div class="blog-content">
                <span class="category">Technology</span>
                <h2 class="blog-title">The Impact of Technology on the Workplace: How Technology is...</h2>
                <div class="author">
                    <img src="images/latest_blogs2.png" alt="Author" class="author-avatar">
                    <span class="author-name">Tracey Wilson</span>
                </div>
                <span class="date">August 20, 2022</span>
            </div>
        </div>
    </div>
</div> -->

<div class="blog-table" style="margin-right: -7%;">
<div class="recent-posts">
        <h2 class="recent-posts-title">Recent Posts</h2>
        <form method="POST" action="" id="searchForm">
            <div class="search-bar">
                <input type="text" name="search" placeholder="Search blog posts..." class="search-input" value="<?php echo htmlspecialchars($searchQuery); ?>" id="searchInput">
                <button type="submit">Search</button>
            </div>
        </form>
    </div>
    <?php if (count($latestBlogs) > 0): ?>
        <?php foreach ($latestBlogs as $blog): ?>

        <div class="blog-card">
        <a href="blog_details.php?id=<?php echo $blog['id']; ?>" style="text-decoration: none; color: inherit;">

            <div class="blog-image">
                <img src="uploads/<?php echo $blog['cover_image']; ?>" alt="Blog Image">
            </div>
            <div class="blog-content">
                <span class="category"><?php echo $blog['title']; ?></span>
                <h2 class="blog-title"><?php echo $blog['description']; ?></h2>
                <div class="author">
                    <img src="images/latest_blogs2.png" alt="Author" class="author-avatar">
                    <span class="author-name"><?php echo $blog['title']; ?></span>
                </div>
                <span class="date"><?php echo $blog['created_at']; ?></span>
                
            </div>
        </div>
        </a>
        <?php endforeach; ?>
        <?php else: ?>
        <p>No blog posts found matching your search.</p>
    <?php endif; ?>
    </div>
</div>

<?php
        include('like.php');
        ?>
<!-- Comment Form -->
<div class="form-container" style="margin-left: 19%;">
    <div class="form-title">Leave a Comment</div>
    <form id="blogComment" method="POST" onsubmit="return handleFormSubmit(event)">
        <div class="form-row">
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="First name">
            </div>
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last_name" name="last_name" placeholder="Last name">
            </div>
        </div>

        <div class="form-row full">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@company.com">
            </div>
        </div>

        <div class="form-row full">
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea id="comment" name="comment" rows="4" placeholder="Type your message / comment here..."></textarea>
            </div>
        </div>

        <button type="submit" style="width:100%;">Post Comment</button>
    </form>
</div>

<script>
    // Prevent form submission on pressing "Enter" in the search input
document.getElementById('searchInput').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();  // Prevent form submission on "Enter"
        document.getElementById("searchForm").submit(); // Manually submit the search form
    }
});

// Prevent form submission on pressing "Enter" in the comment form
document.getElementById('blogComment').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();  // Prevent form submission on Enter key in comment form
    }
});



</script>



</div>

<br></br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
  


        $(document).ready(function() {
            $('#blogComment').validate({
                rules: {
                    first_name: {
                        required: true,
                        pattern: /^[A-Za-z]+$/ 
                    },
                    last_name: {
                        required: true,
                        pattern: /^[A-Za-z]+$/ 
                    },
                    email: {
                        required: true,
                        email: true
                    },               
                    comment: {
                        required: true
                    }
                },
                messages: {
                    first_name: {
                        required: "Please enter your first name.",
                        pattern: "Name must only contain letters (A-Z, a-z)"
                    },
                    last_name: {
                        required: "Please enter your last name.",
                        pattern: "Name must only contain letters (A-Z, a-z)"
                    },
                    email: {
                        required: "Please enter your email.",
                        email: "Your enter a valid email address."
                    },                   
                    comment: {
                        required: "Please enter your comment"
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