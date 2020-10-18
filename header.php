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
    <div class="appName">
      <a href="index.php">
        <h1>DRINK</h1>
        <img id="cocktail" src="media/coctail.png" width="45px" height="40px">
      </a>
    </div> 
    
    <nav class="navbar nav justify-content-center"> 

      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Start</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Search Recipe</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add_recipe.php">Make Recipe</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Random Recipe</a> 
        </li>
        <?php if(isset($_SESSION['username'])):?>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" >
              <img src="media/myprofile.png" width="25px" height="25px">
            </a>
            <div class="dropdown-menu"> 
              <a class="dropdown-item" href="profile.php">My Profile</a>
              <a class="dropdown-item" href="php/account/logout.inc.php">Log Out</a>
            </div>
          </li>
          
        <?php else: ?> 

          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>

        <?php endif;?>
      </ul>
    </nav> 
    <!-- sökrutan -->
    <div class="input-group mb-3"> 
      <input list="searchField" id="searchBar" type="text" class="form-control" placeholder="Recipes.. , Users.."> 
      <div id="searchField">

      </div>
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button">Search</button>
      </div>
    </div>
  </header>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="js/header-search.js"></script>
</html> 