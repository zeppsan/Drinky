<?php

    session_start();

    if(!isset($_SESSION['username']))
        header("Location: login.php?error=notloggedin");

    require_once 'php/includes/db.inc.php';
    








?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <title>Profile</title>
    <?php include_once 'header.php'; ?>
</head>
<body class="bg-bluegradient">


    <div class="container">
        <div class="row">
            <div class="col">
            <h3>Search for Recipe</h3>
            <p>Get a drink suggestion depending on what beverages you have accessable:</p>
            </div>
        </div>

        <!-- First row -->
        <div class="row" id="fieldHolder">
            <div class="col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Beverage 1</span>
                    </div>
                    <input type="text" name="drink[0][beverage]" class="form-control alcoInput" placeholder="ex: vodka">
                </div>
            </div>
            
        </div>
        
        <!-- Add Icon -->
        <div class="row">
            <div class="col text-center">
                <a href="#" onclick="addField()"><img src="media/plus_icon.png" width="32px"></a>
            </div>
        </div>

        <div class="row">
            <div class="col text-center mt-2">
                <button class="btn btn-gray" onclick="searchDrinks()">search</button>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-12" id="searchResult">

            

            </div>


        </div>
    </div>




    
    <script src="js/drink_search.js"></script>
</body>
</html>