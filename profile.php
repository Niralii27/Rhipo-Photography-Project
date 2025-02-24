<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rhipo</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<style>
    * {
    margin: 0;
    padding: 0
}

body {
    background-color: #ffffff;
}

.card {
    width: 350px;
    background-color: #efefef;
    border: none;
    cursor: pointer;
    transition: all 0.5s;
}

.image img {
    transition: all 0.5s
}

.card:hover .image img {
    transform: scale(1.5)
}

.btn {
    height: 140px;
    width: 140px;
    border-radius: 50%
}

.name {
    font-size: 22px;
    font-weight: bold
}

.idd {
    font-size: 14px;
    font-weight: 600
}

.idd1 {
    font-size: 12px
}

.number {
    font-size: 22px;
    font-weight: bold
}

.follow {
    font-size: 12px;
    font-weight: 500;
    color: #444444
}

.btn1 {
    height: 40px;
    width: 150px;
    border: none;
    background-color: #000;
    color: #aeaeae;
    font-size: 15px
}

.text span {
    font-size: 13px;
    color: #545454;
    font-weight: 500
}

.icons i {
    font-size: 19px
}

hr .new1 {
    border: 1px solid
}

.join {
    font-size: 14px;
    color: #a0a0a0;
    font-weight: bold
}

.date {
    background-color: #ccc
}
.btn-square {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    background-color: #ffffff;
    color: #9D8161;
    font-family: 'The New Elegance', sans-serif;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    border: 2px solid #9D8161;
    border-radius: 4px;
    transition: all 0.3s ease;
    cursor: pointer;
    gap: 8px;
    white-space: nowrap;
}

.btn-square:hover {
    background-color: #9D8161;
    color: #ffffff;
    border-color: #9D8161;
}

.change-password-link {
    text-decoration: none;
    color: #007bff; /* Blue color */
    font-weight: bold;
}

.change-password-link:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    
<div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
    
     <div class="card p-4"> <div class=" image d-flex flex-column justify-content-center align-items-center"> 
        
        <button class="btn btn-secondary">  <img src="<?php echo !empty($_SESSION['profile_image']) ? htmlspecialchars($_SESSION['profile_image']) : 'https://i.imgur.com/wvxPV9S.png'; ?>" 
         height="120" 
         width="120" 
         id="profileImage"
         style="border-radius: 50%;" /></button>
         <span class="name mt-3"><?php echo ($_SESSION['name'])?></span>
          <span class="idd"><?php echo ($_SESSION['email']) ?></span>
          <span class="idd"><?php echo ($_SESSION['number']) ?></span>

           <div class="d-flex flex-row justify-content-center align-items-center gap-2"> 
           <span class="idd1">
           <div class="d-flex flex-column mt-2">
    <!-- Change Password Link -->
    <span class="idd1">
        <a href="change_password.php" class="change-password-link">Change Password</a>
    <i class="fa fa-lock"></i></span>
   
    <!-- Logout Button -->
    <button id="logoutBtn" class="btn-square mt-2">Logout</button>
</div>

    </div>
    </div>
    </div>
    <script>
    document.getElementById('logoutBtn').addEventListener('click', function () {
        // Notify parent window about logout success
        window.parent.postMessage('logout-success', '*');

        // Redirect to logout.php to destroy session
        window.location.href = 'logout.php';
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>