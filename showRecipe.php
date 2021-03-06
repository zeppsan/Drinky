<?php
/* 
    Author: 
        Casper Kärrström

    Description:
        Shows the recipe

*/ 
    include("./php/includes/db.inc.php");

    session_start();
    if(!isset($_SESSION['username']))
        header("Location: login.php");

    // Fetch information about the specified recipe
    $stmt = $conn->prepare("SELECT * FROM recipe WHERE name = ?");
    $stmt->bind_param("s", $_GET['drinkName']);
    $stmt->execute();
    $drink = $stmt->get_result()->fetch_assoc();
    // Fetch information about the user that created the recipe
    $stmt = $conn->prepare("SELECT id, username, fname, lname, age, profile_picture FROM user_recipe 
    INNER JOIN recipe ON user_recipe.recipe_ID = ? INNER JOIN users ON users.id = user_recipe.user_ID");
    $stmt->bind_param("i", $drink['recipe_ID']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    //  Array of all ingredients and thier amount
    $stmt = $conn->prepare("SELECT ingredients.name, recipe_ingredients.amount, recipe_ingredients.unit FROM recipe_ingredients 
    INNER JOIN recipe ON recipe_ingredients.recipe_ID = recipe.recipe_ID 
    INNER JOIN ingredients ON recipe_ingredients.ingredient_ID = ingredients.ingredient_ID WHERE recipe.recipe_ID = ?");
    $stmt->bind_param("i", $drink['recipe_ID']);
    $stmt->execute();
    $ingredients = $stmt->get_result();
    // Users avarage drink rating
    $stmt = $conn->prepare("SELECT user_recipe.user_ID, sum(recipe.rating_total) / sum(recipe.votes) AS 'rating' FROM user_recipe 
    INNER JOIN recipe on recipe.recipe_ID = user_recipe.recipe_ID WHERE user_recipe.user_ID = ?");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $drink_ratings = $stmt->get_result()->fetch_assoc();
    // Division with 0
    if($drink_ratings['rating'] == null)
        $drink_ratings['rating'] = 0;
    // Ratings and comments from other users
    $stmt = $conn->prepare("SELECT users.profile_picture, users.username, user_ratings.rating, user_ratings.comment FROM user_ratings JOIN users ON users.id = user_ratings.user_id WHERE user_ratings.recipe_id = ?");
    $stmt->bind_param("i", $drink['recipe_ID']);
    $stmt->execute();
    $userRatings = $stmt->get_result();

    $stmt = $conn->prepare("SELECT user_ratings.user_id FROM user_ratings WHERE user_ratings.recipe_id = ? AND user_ratings.user_id = ?");
    $stmt->bind_param("ii", $drink['recipe_ID'], $_SESSION['id']);
    $stmt->execute();
    $AlreadyRated = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
    <html>

    <head>
        <title>Recepie</title>
        <?php include_once 'header.php'; ?>
    </head>

    <body class="bg-bluegradient">

        <!--    Main container  -->
        <div class="container profile" >
            <div class="row justify-content-center align-items-center p-4">
                <!-- Checking if the drink exists -->
            <?php    if(!isset($drink['name'])){
                echo 'Drink does not exist';
                die();
                } ?>

            <!--    imgurl, Name of Drink, Drink rating, Description    -->
                <div class="col-12 col-sm-12 col-md-3 text-center">
                    <img src="<?php 
                    if(isset($drink['image'])){     // Image of drink  
                    echo $drink['image'];} else{ echo "./media/coctail.png";}
                    ?>" width="100%" >
                </div>
                <div class="col-12 col-sm-6 col-md-6 text-center">     
                    <h2><?php echo $drink['name']?></h2>
                    <p class="description"><?php echo $drink['description'] ?></p>
                    </div>
                    <!--    Drink Rating    -->
                    <div class="col-12 col-sm-6 col-md-3"> 
                    <h4>Rating: <?php 
                    if($drink['votes'] == null){
                        echo "0";
                    } else{
                    echo round($drink['rating_total']/$drink['votes'], 1);
                    }   ?> / 5</h4>

                    <p>Rated <?php echo $drink['votes'] ?> Times</p> 
            </div>
        </div>

            <!--    Instructions    -->
            <div class="row justify-content-center align-items-center mt-5 p-4">
                <div class="col-6 col-md-4 text-center">
                    <h2> Instructions </h2>
                    <?php echo $drink['instructions']?>
                </div>

            <!--    Ingredients... Spirits, Liquer, juice, Soda, Garnish -->
                <div class="col-6 col-md-4 text-center">
                    <h2>Ingredients</h2>
                    <!--    Lists ingredient from ingredients  -->
                    <ul class="list-unstyled">
                        <?php
                            while($ingredient = $ingredients->fetch_assoc()){
                                echo"<li>".$ingredient['name'],' ', $ingredient['amount'], $ingredient['unit']." </li>";
                            };
                        ?>
                    </ul>

                </div>
            </div>

            <!--    Drink Creator... Name, rating, link -->
            <div class="row justify-content-center align-items-center mt-5 p-4">
                <div class="col-12 col-sm-6 col-md-3">
                    <h2>Recipe by </h2>
                     <!--    User picture    -->
                    <div class="rounded-circle" id="profile_picture">
                        <a href="http://localhost/Drinky/profile.php?user=<?php echo $user['username'] ?>"> 
                        <img src="<?php if(isset($user['profile_picture'])){
                            echo $user['profile_picture']; 
                        } else { echo "./media/profilepictures/profilestock.jpg";}
                         ?>"  width="100%"></a>
                    </div>
                </div>
                    <!--    Username, firstname, lastname and age    -->
                <div class="col-12 col-sm-6 col-md-3">
                    <p> <?php echo $user['username'] ?></p>
                    <p> <?php echo $user['fname'], ' ', $user['lname'], ', ', $user['age'] ?></p>
                    <!--    User Rating    -->
                    <p class="small my-0">Average Drink Score</p>
                    <h3 class="small my-0"><?php echo round($drink_ratings['rating'], 1) ?> / 5</h3>
                </div>

            </div>
                <!--    Rating system   -->
            <div class="row justify-content-center align-items-center mt-5 p-4">
                <div class="col-6 text-center">
                  <?php if(!isset($AlreadyRated['user_id'])): ?>
                        <h2>Rate The Drink</h2>
                                <div class="rating">
                                    <span class="ratingStars" id="s1">
                                        ☆
                                    </span>
                                    <span class="ratingStars" id="s2">
                                        ☆
                                    </span>
                                    <span class="ratingStars" id="s3">
                                        ☆
                                    </span>
                                    <span class="ratingStars" id="s4">
                                        ☆
                                    </span>
                                    <span class="ratingStars" id="s5">
                                        ☆
                                    </span>
                                </div>
                  <?php else: ?>
                    <p><?php echo $_SESSION['username']?> have already rated this drink.<br>Look for your rating below</p>
                  <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 mx-auto mb-4">  
                    <form action="php/recipe/rate_drink.inc.php" method="POST" id="commentField">
                        <input type="number" name="drink_id" value="<?php echo $drink['recipe_ID'] ?>" hidden>
                    </form>
                </div>
            </div>

                        <!--    Users rating    -->
            <?php

                while($ratingByUser = $userRatings->fetch_assoc()):?>

                    <div class="row border-top border-secondary align-items-center">
                        <div class="col-6 col-md-4 mx-auto mb-3 text-center">
                            <div class="rounded-circle mt-5 margin-rating" id="profile_picture">
                                <a href="http://localhost/Drinky/profile.php?user=<?php echo $ratingByUser['username'] ?>"> 
                                <img src="<?php if(isset($ratingByUser['profile_picture'])){
                                    echo $ratingByUser['profile_picture']; 
                                } else { echo "./media/profilepictures/profilestock.jpg";}
                                ?>" width="100%"></a>
                            </div>
                            <p> <?php echo $ratingByUser['username']; ?><p>
                        </div>
                        <div class="col-6 col-md-4 mx-auto mb-3">
                                <label><?php echo $ratingByUser['rating'];?> / 5</label>
                                <p><?php echo $ratingByUser['comment']; ?><p>
                        </div>
                    </div>
    
                 <?php endwhile; ?>

        </div>

    </body> 

    <script src="js/rating.js"></script>
    
</html>