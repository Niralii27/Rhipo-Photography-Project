<?php
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - RHIPO Photography</title>
    <link href="https://fonts.googleapis.com/css2?family=The+New+Elegance&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>


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
    background: white;
    position: relative;
}

.hero-section {
    width: 100%;
    height: 616px;
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
    height: auto;
    margin-left: -25%;
    position: absolute;
    top: -20px;
}

.content-wrapper {
    width: 1560px;
    height: 300px;
    position: absolute;
    left: 180px;
    top: 296px;
    background: rgba(42.06, 42.06, 42.06, 0.30);
    border-top-left-radius: 150px;
    backdrop-filter: blur(54px);
    padding: 40px 200px;
}

.featured-title {
    color: #CDCDCD;
    font-size: 28px;
    font-family: 'Amsterdam Kindom - Personal use';
    font-weight: 400;
    text-transform: capitalize;
    margin-bottom: 20px;
}

.post-title {
    color: white;
    font-size: 32px;
    font-family: 'The New Elegance';
    font-weight: 400;
    text-transform: capitalize;
    margin-bottom: 10px;
}

.post-description {
    color: #CDCDCD;
    font-size: 16px;
    font-family: Alexandria;
    font-weight: 400;
    line-height: 32px;
    margin-bottom: 20px;
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

.additional-image-wrapper {
    margin-top: 35%; /* Space above the image */
    text-align: center; /* Center the image */
}

.additional-image-wrapper img {
    max-width: 100%; /* Responsive image */
    height: auto; /* Maintain aspect ratio */
}

/* Responsive Styles */
@media (max-width: 1200px) {
    .container {
        width: 100%;
    }

    .content-wrapper {
        width: 100%;
        left: 10px;
        top: 50px;
        padding: 20px 40px;
    }

    .featured-title {
        font-size: 24px;
    }

    .post-title {
        font-size: 28px;
    }

    .post-description {
        font-size: 14px;
    }

    .post-meta {
        font-size: 14px;
    }
}

@media (max-width: 768px) {
    .hero-image {
        width: 120%;
        margin-left: -10%;
        top: 0;
    }

    .content-wrapper {
        width: 90%;
        left: 5%;
        top: 30%;
        padding: 20px 30px;
    }

    .featured-title {
        font-size: 20px;
    }

    .post-title {
        font-size: 24px;
    }

    .post-description {
        font-size: 14px;
    }

    .post-meta {
        font-size: 14px;
        gap: 8px;
    }
}

@media (max-width: 480px) {
    .hero-image {
        width: 100%;
        margin-left: 0;
    }

    .content-wrapper {
        width: 100%;
        left: 0;
        top: 20%;
        padding: 15px;
    }

    .featured-title {
        font-size: 18px;
    }

    .post-title {
        font-size: 20px;
    }

    .post-description {
        font-size: 12px;
    }

    .post-meta {
        font-size: 12px;
        flex-direction: column;
        align-items: flex-start;
    }

    .post-meta img {
        width: 30px;
        height: 30px;
    }

    .additional-image-wrapper img {
        max-width: 100%;
        height: auto;
    }
}

       
/* General Table Styles */
.blog-table {
    width: 70%;
    border-collapse: collapse;
    margin: 50px 0;
    margin-left: 15%;
    
}

.blog-table td {
    padding: 15px;
    vertical-align: top;
}

/* Blog Card Styles */
.blog-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.blog-image img {
    width: 96%;
    height: auto;
    object-fit: cover;
    margin-left:2%;
    margin-right:2%;
    margin-top: 2%;
    border-radius: 15px;
}

.blog-content {
    padding: 15px;
}

.category {
    color: #9D8161;
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 5px;
    font-family: 'Alexandria';
font-weight: 400;
line-height: 20px;
text-align: left;
text-underline-position: from-font;
text-decoration-skip-ink: none;


}

.blog-title {
    font-size: 18px;
    color: #333;
    font-weight: bold;
    margin: 10px 0;
}

.author {
    display: flex;
    align-items: center;
    gap: 8px; /* Controls the space between name and date */
}

.author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.author-name {
    font-size: 16px;
    color: #97989F;
    font-family: 'Alexandria';
    font-weight: 500;
    line-height: 24px;
    text-align: left;
    text-underline-position: from-font;
    text-decoration-skip-ink: none;
}

.date {
    font-size: 12px;
    color: #777;
}


/* Responsive Design */
@media (max-width: 768px) {
    .blog-table td {
        padding: 10px;
    }

    .blog-card {
        margin-top: 20%; /* Space between cards */
    }

    .blog-table tr {
        display: block;
    }

    .blog-table td {
        display: block;
        width: 100%;
        margin-top: 20%; /* Add space between rows */
    }

    .blog-table td:nth-child(3) {
        margin-bottom: 0;
    }
}

@media (max-width: 480px;) {
    .blog-title {
        font-size: 16px;
    }

    .category {
        font-size: 10px;
    }

    .author-name {
        font-size: 12px;
    }

    .date {
        font-size: 10px;
    }
}

.btn-square {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    background-color: #9D8161; /* Background color */
    color: #ffffff; /* Text color - always white */
    font-family: 'Alexandria', sans-serif;
    font-size: 16px;
    font-weight: 700;
    border: 2px solid #9D8161;
    border-radius: 4px;
    gap: 8px;
    text-decoration: none; /* Remove underline if used with anchor tag */
    cursor: pointer; /* Pointer cursor on hover */
    margin-left:45%;
}

.btn-square .btn-arrow {
    color: #ffffff; /* Ensures arrow icon is also white */
}

    </style>
</head>
<body>
    <div class="container">
            <div class="hero-background"></div>
            <img style="margin-top:2%;" class="hero-image" src="images/blog3.png" alt="Rhipo Photography" />
        </div>
        <div class="content-wrapper" style="margin-top:4%;">
            <div class="featured-title">Featured</div>
            <div class="post-title">Celebrating Elegance and Versatility: The Remarkable Sachinmayee Menon</div ><div class="post-description">At RHIPO Photography, we have had the privilege of working with numerous talented individuals, but few have left as profound an impression as the exceptional Sachinmayee Menon.</div>
            <div class="post-meta">
                <img src="images/blog3.png" alt="Author Image" />
                <div>Hitesh Agrawal</div>
                <div>Jul 30</div>
                <div>2 min read</div>
            </div>
        </div>
    </div>
    </div>
    <div class="additional-image-wrapper" >
    <img src="images/latest_blogs1.png" alt="Additional Image" style="max-width: 100%; height: auto;" />
</div>
   
<table class="blog-table">
    <tr>
        <td>
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
        </td>
        <td>
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
        </td>
        <td>
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
        </td>
    </tr>
<tr>
    <td>
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
        </td>

    <td>
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
        </td>

    <td>
            <div class="blog-card"> <a href="blog_Details.php">
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
</a>
            </div>
        </td>
    </tr>
    <!-- Add more rows if needed -->
</table>
<div>
</a>
                <a href="#" class="btn-square"style="color: #ffffff;margin-top:-50%;">VIEW ALL POST
                <img style="color: #ffffff;" src="images/down_Arrow.png" alt="Arrow" class="btn-arrow">

                </a>  
</div>
<br>
</br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
include('footer.php');
?>
</body>
</html>
