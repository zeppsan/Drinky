<!--
    Author: 
        Frida Westerlund

      Description:
        This is the header for our webpage. That will be included in every page. 
-->

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
    <div class="appName"><a href="index.php"><h1>DRINK</h1><img id="cocktail" src="media/coctail.png" width="45px" height="40px"></a></div> 
    
    <nav class="nav justify-content-center"> 
      <!-- <a class="nav-link active" href="index.php">Start</a> -->
      <a class="nav-link active" href="#">Search Recipe</a>
      <a class="nav-link" href="add_recipe.php">Make Recipe</a>
      <a class="nav-link" href="#">Random Recipe</a> 
      <?php 
        if(isset($_SESSION['username'])){ 
          echo '<ul class="nav nav-tabs"><li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" ><img src="media/myprofile.png" width="25px" height="25px"></a>
          <div class="dropdown-menu"> 
          <a class="dropdown-item" href="profile.php">My Profile</a>
          <a class="dropdown-item" href="php/account/logout.inc.php">Log Out</a>
          </div></li></ul>';
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
      <input id="searchBar" type="text" class="form-control" placeholder="Recipes.. , Users.."> 
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button">Search</button>
      </div>
    </div>
  </header>
</html> 