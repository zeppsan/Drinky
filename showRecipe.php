<?php

include("./header.php");
include("./php/includes/db.inc.php");

session_start();

// Fetch information about the specified recipe
$stmt = $conn->prepare("SELECT * FROM recipe WHERE 'name' = ?");
$stmt->bind_param("s", $_POST['drinkName']);
$stmt->execute();
$drink = $stmt->get_result()->fetch_assoc();

// Fetch information about the user that created the recipe
$stmt = $conn->prepare("SELECT username , imgurl FROM users WHERE username = ?");
$stmt->bind_param("s", $drink['username']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>
    
</head>

<body>

<!--    Main container  -->
<div class="container"> 

<!--    imgurl, Name of Drink, Drink rating, Description    -->
<div>
    <!--    <img src="<?php //echo $drink['imgurl'] ?>" >        Image of drink  -->
    <h2><?php echo $drink['name']?></h2>
    <!--    Drink Rating    -->
    <p><?php echo $drink['votes'] ?></p>
    <div></div>         <!--    Yellow color for stars  -->
    <img src="" >       <!--    Cut out stars image   -->
    <p><?php echo $drink['description'] ?></p>
</div>

<div>
    <h2> Instructions </h2>
    <?php echo $drink['instructions']?>
</div>
<!--    Ingredients... Spirits, Liquer, juice, Soda, Garnish -->
<div>
    <ul>
        <li></li>   <!--    Listed ingredient from ingredients  -->
    </ul>
</div>

<!--    Drink Creator... Name, rating, link -->
<div>
    <img src="<?php echo $user['profile_picture'] ?>" >   <!--    User picture    -->
    <a href="./profile.php"><?php echo $user['username'] ?></a>

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