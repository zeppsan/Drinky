<?php
/*
  Author: 
  Max Jonsson

  Description:
  The backend of add_recipe that will add ingredients to the database and the recipe.
*/ 
require_once("../includes/db.inc.php");

//Check if the ingredients from recipe is in the database
foreach($_POST['ingredient'] as $key)
{
  //Check if the ingredient is already in the database
  $stmt = $conn->prepare("SELECT name FROM ingredients WHERE name=?");
  $stmt->bind_param("s", $key['ingredientName']);
  $stmt->execute();
  $result = $stmt->get_result();

  //If ingredient isnt in database add the ingredient
  if (!$result->num_rows) {
    $stmt = $conn->prepare("INSERT INTO ingredients (name) VALUES (?)");
    $stmt->bind_param("s", $key['ingredientName']);
    $stmt->execute();
  }
}

//Insert recipe to the database
$stmt = $conn->prepare("INSERT INTO recipe (name, description, instructions) VALUES (?,?,?)");
$stmt->bind_param("sss", $_POST['drinkName'],$_POST['description'],$_POST['instructions']);
$stmt->execute();

//Get id of recipe from database
$stmt = $conn->prepare("SELECT recipe_id FROM recipe WHERE name=?");
$stmt->bind_param("s", $_POST['drinkName']);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result);
$recipe_id = $row['recipe_id'];

echo "recipe_id = " .$recipe_id;

//Not finished yet. Will add all the ingredients to the reicpe.
foreach($_POST['ingredient'] as $key)
{
  $stmt = $conn->prepare("SELECT ingredient_ID FROM ingredients WHERE name=?");
  $stmt->bind_param("s", $key['ingredientName']);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = mysqli_fetch_array($result);
  $ingredient_id = $row['ingredient_ID'];

  $stmt = $conn->prepare("INSERT INTO recipe_ingredients (recipe_ID, ingredient_ID, amount) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $recipe_id, $ingredient_id, $_POST['amount']);
  $stmt->execute();
}


?>