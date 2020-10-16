<?php

include("./php/includes/db.inc.php");

session_start();
if(!isset($_SESSION['username']))
    header("Location: login.php");

$drinkName = "Secret Mixture";

// Fetch information about the specified recipe
$stmt = $conn->prepare("SELECT * FROM recipe WHERE name = ?");
$stmt->bind_param("s", $drinkName); //$_GET['drinkName']
$stmt->execute();
$drink = $stmt->get_result()->fetch_assoc();

// Fetch information about the user that created the recipe
//$stmt = $conn->prepare("SELECT username, profile_picture FROM users WHERE ...");
$stmt = $conn->prepare("SELECT username, fname, lname, age, profile_picture 
FROM user_recipe INNER JOIN recipe ON user_recipe.recipe_ID = ? INNER JOIN users ON users.id = user_recipe.user_ID");
$stmt->bind_param("s", $drink['recipe_ID']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$stmt = $conn->preare("SELECT name FROM recepie_ingredients INNER JOIN receipe ON receipe_ingredients.recipe_ID = ? 
INNER JOIN ingredients ON recipe_ingredients.ingredient_ID = ingredients.ingredient_ID");
$stmt->bind_param("s", $drink['recipe_ID']);
$stmt->execute();
$ingredients = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Recepie</title>
    <?php include_once 'header.php'; ?>
</head>

<body>

<!--    Main container  -->
<div class="container"> 

<!--    imgurl, Name of Drink, Drink rating, Description    -->
<div>
    <!--    <img src="<?php //echo $drink['imgurl'] ?>" >        Image of drink  -->
    <h2><?php echo $drink['name']?></h2>
    <!--    Drink Rating    -->
    <h2>Rating: <?php echo $drink['rating_total']/$drink['votes'] ?></h2>
    <p>Number of votes: <?php echo $drink['votes'] ?></p>      
    <!--    Yellow color for stars  -->
    <img src="" >       <!--    Cut out stars image   -->
    <p><?php echo $drink['description'] ?></p>
</div>

<div>
    <h2> Instructions </h2>
    <?php echo $drink['instructions']?>
</div>
<!--    Ingredients... Spirits, Liquer, juice, Soda, Garnish -->
<div>
    <h2>Ingredients</h2>
    <ul>
        <?php foreach($ingredients as $ingredient){
            echo"<li>'$ingredient'</li>";?>   <!--    Listed ingredient from ingredients  -->
        }
    </ul>
</div>

<!--    Drink Creator... Name, rating, link -->
<div>
    <div class="rounded-circle" id="profile_picture">
        <img src="<?php echo $user['profile_picture'] ?>" width="100%">   <!--    User picture    -->
    </div>
    <a href="http://localhost/Drinky/profile.php?user=<?php echo $user['username'] ?>"><?php echo $user['username'] ?></a>
    <p> <?php echo $user['fname'], ' ', $user['lname'], ' ', $user['age'] ?></p>
    <!--    User Rating    -->
    <div></div>     <!--    Yellow color for stars  -->
    <img src="" >   <!--    Cut out for stars   -->
</div>

</div>

<!--    Rating and comment?
<div>
   For each rating in ratings  
                      

</div>
-->

</body>




</html>