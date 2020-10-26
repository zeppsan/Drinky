<?php

    include("../includes/db.inc.php");
    session_start();
    // All infromation gathered from rating.js
    $userID = $_SESSION['id'];
    $drinkID = $_POST['drink_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['drinkComment'];

    // Adds the rating with comment to the user_ratings table
    $stmt = $conn->prepare("INSERT INTO user_ratings (user_ratings.user_id, user_ratings.recipe_id, user_ratings.rating, user_ratings.comment) 
    VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $userID, $drinkID, $rating, $comment);
    $stmt->execute();

    // Updates the rated recipe
    $stmt = $conn->prepare("UPDATE recipe SET recipe.rating_total = recipe.rating_total + ?, recipe.votes = recipe.votes + 1 WHERE recipe.recipe_ID = ?");
    $stmt->bind_param("ii", $rating, $drinkID);
    $stmt->execute();


    $stmt = $conn->prepare("SELECT recipe.name FROM recipe WHERE recipe.recipe_ID = ?");
    $stmt->bind_param("i", $drinkID);
    $stmt->execute();
    $drink = $stmt->get_result()->fetch_assoc();



    header("Location: ../../showRecipe.php?drinkName=".$drink['name']."");



?>