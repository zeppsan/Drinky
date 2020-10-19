<?php
/*
  Author: 
  Max Jonsson

  Description:
  The backend of add_recipe that will add ingredients to the database and the recipe.
*/ 
require_once("../includes/db.inc.php");

session_start();
if(!isset($_SESSION['username']))
        header("Location: login.php?error=notloggedin");

//Check if the ingredients from recipe is in the database
foreach($_POST['beverage'] as $key)
{
  //Check if the ingredient is already in the database
  $stmt = $conn->prepare("SELECT name FROM ingredients WHERE name=?");
  $stmt->bind_param("s", $key['name']);
  $stmt->execute();
  $result = $stmt->get_result();

  //If ingredient isnt in database add the ingredient
  if (!$result->num_rows) {
    $stmt = $conn->prepare("INSERT INTO ingredients (name) VALUES (?)");
    $stmt->bind_param("s", $key['name']);
    $stmt->execute();
  }
}

//Insert recipe to the database
$stmt = $conn->prepare("INSERT INTO recipe (name, description, instructions) VALUES (?,?,?)");
$stmt->bind_param("sss", $_POST['drinkname'],$_POST['description'],$_POST['instructions']);
$stmt->execute();

//Get id of recipe from database
$stmt = $conn->prepare("SELECT recipe_id FROM recipe WHERE name=?");
$stmt->bind_param("s", $_POST['drinkname']);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result);
$recipe_id = $row['recipe_id'];

echo "recipe_id = " .$recipe_id;

//Not finished yet. Will add all the ingredients to the reicpe.
foreach($_POST['beverage'] as $key)
{
  $stmt = $conn->prepare("SELECT ingredient_ID FROM ingredients WHERE name=?");
  $stmt->bind_param("s", $key['name']);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = mysqli_fetch_array($result);
  $ingredient_id = $row['ingredient_ID'];

  $stmt = $conn->prepare("INSERT INTO recipe_ingredients (recipe_ID, ingredient_ID, amount) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $recipe_id, $ingredient_id, $key['amount'], $key['unit']);
  $stmt->execute();
}

//Get the ID of the user
$stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result);
$user_id = $row['id'];

//Add the recipe to the user
$stmt = $conn->prepare("INSERT INTO user_recipe (recipe_ID, user_ID) VALUES (?, ?)");
$stmt->bind_param("ii", $recipe_id, $user_id);
$stmt->execute();






/*
  Author: 
    Eric Qvarnström 

  Description:
    The script below will add an eventual image to the recipe. 
*/ 
if($_FILES['drinkImage']['name'] != ""){
  $targetDir = "../../media/drinkImages/";
  $dbPathToImage = "media/drinkImages/";
  
  /** Checks if the entered file is an image or not 
   * @param file The file that should be checked
   * @return bool returns true if file is an image.
  */
  function isImage($file){
      $imageType =  pathinfo($file['name'], PATHINFO_EXTENSION);
      if($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jpeg' && $imageType != 'gif' && $imageType != 'svg')
          return false;
      else
          return true;
  }
  
  /** Uploads an image to the specified drink.
   * 
   * @param file image file
   * 
   */
  function uploadImage($image){
      global $conn, $dbPathToImage, $targetDir, $recipe_id;
      $imageType = pathinfo($image['name'], PATHINFO_EXTENSION);
      $imagename = time() .".". $imageType;
      $imageFullName = $dbPathToImage . $imagename;

  
      move_uploaded_file($_FILES['drinkImage']['tmp_name'], $targetDir . $imagename);
      $stmt = $conn->prepare("UPDATE recipe SET image = ? WHERE recipe_ID = ?");
      $stmt->bind_param('ss', $imageFullName, $recipe_id);
      $stmt->execute();
  }
  
  uploadImage($_FILES['drinkImage']);
}

header("Location: ../../showRecipe.php?drinkName=" .$_POST['drinkname']);
?>