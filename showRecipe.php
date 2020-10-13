<?php

include("./header.php");
include("./php/includes/db.inc.php");

session_start();
$drinkName = $_POST['drinkName'];

$recipe = $conn->query("SELECT * FROM recepies WHERE drinkName = $drinkName");
$recipe = $recipe->fetch_assoc();

$user = $conn->query("SELECT username , imgurl, rating FROM users WHERE username = $recipe['username']");
$user = $user->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    
</head>

<body>

<!--    Main container  -->
<div class="Some Container"> 

<!--    imgurl, Name of Drink, Drink rating, Description    -->
<div>
    <img src="<?php echo $recipe['imgurl'] ?>" >       <!--  Image of drink  -->
    <h2><?php echo $recipe['drinkName']?></h2>
    <!--    Drink Rating    -->
    <p><?php echo $recipe['numberOfRatings'] ?></p>
    <div></div>         <!--    Yellow color for stars  -->
    <img src="" >       <!--    Cut out stars image   -->
    <p><?php echo $recipe['description'] ?></p>
</div>

<!--    Ingredients... Spirits, Liquer, juice, Soda, Garnish -->
<div>
    <ul>
        <li></li>   <!--    Listed ingredient from ingredients  -->
    </ul>
</div>

<!--    Drink Creator... Name, rating, link -->
<div>
    <img src="<?php echo $user['imgurl'] ?>" >   <!--    User picture    -->
    <a href="./profile.php"><?php echo $user['username'] ?></a>
    <!--    User Rating    -->
    <div></div>     <!--    Yellow color for stars  -->
    <img src="" >   <!--    Cut out for stars   -->
</div>

</div>

<!--    Ratings 
<div>
   For each rating in ratings  
                      

</div>
-->

</body>




</html>