<!--
    Author: 
        Frida Westerlund

      Description:
      This will be the code to remove a recipe that you have made. 
-->
<?php
    include("../includes/db.inc.php");
    
    $name = $_GET['drinkName']; 

    $stmt = $conn->prepare("SELECT * FROM recipe WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $recipe = $stmt->get_result()->fetch_assoc();

    $recipeID = $recipe['recipe_ID']; 

    $stmt = $conn->prepare("DELETE FROM user_ratings WHERE recipe_ID = $recipeID");
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM user_recipe WHERE recipe_ID = $recipeID");
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM recipe_ingredients WHERE recipe_ID = $recipeID");
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM recipe WHERE name = '$name'");
    $stmt->execute();

    // $stmt = $conn->prepare("SELECT * FROM recipe_ingredients WHERE recipe_ID = $recipeID");
    // $stmt->execute();
    // $ingredients = $stmt->get_result();

    // while($ingredients = $ingredients->fetch_assoc()){
    //     $id = $ingredients['ingredient_ID']; 
    //     $stmt = $conn->prepare("DELETE from ingredients where ingredient_ID = $id");
    //     $stmt->execute();  
    // }

    header("Location: http://localhost/Drinky/profile.php"); 
?>