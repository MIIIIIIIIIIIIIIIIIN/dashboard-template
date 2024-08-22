<?php
session_start();
if(!isset($_SESSION["user"])){
  header("location: ../login/login.php");
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/index.css">
  <style>
    img{
      animation:scale 1s 1 ease-in-out forwards;
    }
    @keyframes scale {
      0%{
        
          transform: scale(0);
        
      }
      100%{
        
        transform: scale(1);
    
      }
    }
  </style>
</head>
<body class=".body h100vh d-flex align-items-center justify-content-center">
<div class="container text-center ">
  <div class="my-4 mb-5">
    <h1 class="text-center  fw-bold"><i class="fa-solid fa-chart-line me-1 text-warning"></i>後台系統</h1>
    <span class="position-absolute top-25 start-75 translate-middle badge rounded-pill text-bg-secondary">
      <?=$_SESSION["user"]["id"]?></span>
  </div>
  <div class=" w150px text-center d-flex justify-content-center w-100">
    <img class="w150px border border-3 w-250 rounded-circle mb-2  " src="../membersystem/php_image/<?=$_SESSION["user"]["img"]?>" alt="">
    
</button>

  </div>
  
  <h2 class="mb-4">HELLO<span class="ms-3">"<?=$_SESSION["user"]["name"]?>"</span></h2>
  <a href="../membersystem/memberSys.php"><button class="btn btn-outline-dark p-2 rounded-2">進入</button></a>
    

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>