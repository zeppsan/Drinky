<!--
    Author: 
        Max Jonsson

      Description:
        This document will handle the html for adding recpies to the database.
-->
<?php 
    include("./header.php");
    require_once("./php/includes/db.inc.php");
    if(!isset($_SESSION['username']))
        header("location: ./login.php");
    
    //Get the units from the database
    $stmt = $conn->prepare("SELECT unit FROM units");
    $stmt->execute();
    $result = $stmt->get_result();
    
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <title>Profile</title>
    <?php include_once 'header.php'; ?>
</head>
<body class="bg-bluegradient">

    <div class="container profile">
        <div class="row p-3">
            <!-- Create recipe -->
            <div class="col-12 col-md-6 my-auto">
                <form id="add_recipe_form" name="recipe_form" action="./php/recipe/add_recipe_to_db.php" method="POST" enctype="multipart/form-data">
                    <h3 class="title">Make Recipe</h3>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Add image</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="drinkImage">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                    <!-- Drink name -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Drink name</span>
                        </div>
                        <input type="text" name="drinkname" class="form-control" id="name" placeholder="ex. Rum and coke" maxlength="50" required>
                    </div>
                    <!-- Short decription -->
                    <p class="mt-3 mb-0">Short description</p>
                    <p class="text mt-2">
                        <textarea id="description" name="description" rows="3" cols="30" maxlength="255"></textarea>
                    </p>
                    <!-- Instructions -->
                    <p class="mt-3 mb-0">Instructions</p>
                    <p class="text mt-2">
                        <textarea id="instructions" name="instructions" rows="10" cols="30" maxlength="1000"></textarea>
                    </p>

                    <div id="Recipe_Ingredients">

                        <div class="input-group mb-3" id="ingredient-group-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Spirit</span>
                            </div>
                            <input list="list1" type="text" name="beverage[0][name]" class="form-control ingredientInput" placeholder="ex. Vodka" maxlength="50" autocomplete="off" required>
                            <datalist id="list1">
                            
                            </datalist>

                            <div class="input-group-prepend">
                                <select name="beverage[0][unit]" class="input-group-text">
                                    <?php
                                        //Create options for every unit from the database
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            echo '<option value=' .$row['unit']. '>' .$row['unit']. '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="number" step="0.1" name="beverage[0][amount]" id="amount_0" class="form-control" maxlength="11" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-center">
                            <a href="#" onclick="addField()"><img src="media/plus_icon.png" width="32px"></a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gray">Submit recipe</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/add_recipe.js"></script>
</body>
</html>