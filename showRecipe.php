<?php

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
    //$stmt = $conn->prepare("SELECT username, profile_picture FROM users WHERE ...");
    $stmt = $conn->prepare("SELECT id, username, fname, lname, age, profile_picture 
    FROM user_recipe INNER JOIN recipe ON user_recipe.recipe_ID = ? INNER JOIN users ON users.id = user_recipe.user_ID");
    $stmt->bind_param("i", $drink['recipe_ID']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    $stmt = $conn->prepare("SELECT ingredients.name, recipe_ingredients.amount FROM recipe_ingredients 
    INNER JOIN recipe ON recipe_ingredients.recipe_ID = recipe.recipe_ID 
    INNER JOIN ingredients ON recipe_ingredients.ingredient_ID = ingredients.ingredient_ID WHERE recipe.recipe_ID = ?");
    $stmt->bind_param("i", $drink['recipe_ID']);
    $stmt->execute();
    $ingredients = $stmt->get_result();
 
    $stmt = $conn->prepare("SELECT user_recipe.user_ID, sum(recipe.rating_total) / sum(recipe.votes) AS 'rating' FROM user_recipe INNER JOIN recipe on recipe.recipe_ID = user_recipe.recipe_ID WHERE user_recipe.user_ID = ?");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $drink_ratings = $stmt->get_result()->fetch_assoc();

    if($drink_ratings['rating'] == null)
        $drink_ratings['rating'] = 0;

?>

<!DOCTYPE html>
    <html>

    <head>
        <title>Recepie</title>
        <?php include_once 'header.php'; ?>
    </head>

    <body  class="bg-bluegradient">

        <!--    Main container  -->
        <div class="container">

            <div class="row justify-content-center align-items-center">
            <!--    imgurl, Name of Drink, Drink rating, Description    -->
                <div class="col-2 text-center">
                    <img src="./media/coctail.png" width="120em" >    <!--  Image of drink  -->
                </div>
                <div class="col-6 col-md-4 text-center">     
                    <h2><?php echo $drink['name']?></h2>
                    <p><?php echo $drink['description'] ?></p>
                    </div>
                    <!--    Drink Rating    -->
                    <div class="col-2"> 
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
            <div class="row justify-content-center align-items-center">
                <div class="col-6 col-md-4 text-center">
                    <h2> Instructions </h2>
                    <?php echo $drink['instructions']?>
                </div>
            <!--    Ingredients... Spirits, Liquer, juice, Soda, Garnish -->
            
                <div class="col-6 col-md-4 text-center">
                    <h2>Ingredients</h2>
                    <!--    Listed ingredient from ingredients  -->
                    <ul class="list-unstyled">
                        <?php
                            while($ingredient = $ingredients->fetch_assoc()){
                                echo"<li>".$ingredient['name'],' ', $ingredient['amount']." cl </li>";
                            };
                        ?>
                    </ul>

                </div>
            </div>

            <!--    Drink Creator... Name, rating, link -->
            <div class="row justify-content-center align-items-center ">
                <div class="col-2">
                    <h2>Recipe by </h2>
                    <div class="rounded-circle " id="profile_picture">
                       <a href="http://localhost/Drinky/profile.php?user=<?php echo $user['username'] ?>"> <img src="<?php echo $user['profile_picture'] ?>"  width="100%">></a>   <!--    User picture    -->
                    </div>
                </div>

                <div class="col-2 text-center">
                    <p> <?php echo $user['username'] ?></p>
                    <p> <?php echo $user['fname'], ' ', $user['lname'], ', ', $user['age'] ?></p>
                    <!--    User Rating    -->
                    <p class="small my-0">Average Drink Score</p>
                    <h3 class="small my-0"><?php echo round($drink_ratings['rating'], 1) ?> / 5</h3>
                </div>

            </div>
        
        </div>

        <!--    Rating and comment?
        <div>
        For each rating in ratings  
                            

        </div>
        -->

    </body>




</html>