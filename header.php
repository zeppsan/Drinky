<?php

  if(session_status() != PHP_SESSION_ACTIVE)
    session_start();


?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drinky</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

</head>
  <header>
    <div class="appName"><h1>DRINKY</h1></div> 

    <nav class="nav justify-content-center"> 
        <a class="nav-link active" href="index.php">Start</a>
        <a class="nav-link active" href="#">Recept</a>
        <a class="nav-link" href="#">Skapa Eget</a>
        <a class="nav-link" href="#"> Slumpa Recept</a> 
        <?php 
          if(isset($_SESSION['username'])){ 
            echo '<a class="nav-link" href="profile.php">My Profile</a>';
          }
        ?>
        <?php 
          if(!isset($_SESSION['username'])){ 
            echo '<a class="nav-link" href="login.php">Login</a>';
          }
        ?>
    </nav> 
    <!-- sökrutan -->
    <div class="input-group mb-3"> 
      <input type="text" class="form-control" placeholder="Recept.. , Profiler.."> 
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button">SÖK</button>
      </div>
    </div>
</header>
</html> 