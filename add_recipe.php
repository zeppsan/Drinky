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
                <form id="add_recipe_form" name="recipe_form" action="./php/recipe/add_recipe_to_db.php" method="POST">
                <h3 class="title">Make Recipe</h3>
                    <!-- Drink name -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Drink name</span>
                        </div>
                        <input type="text" name="drinkname" class="form-control" id="name" placeholder="ex. Rum and coke" required><br>
                    </div>
                    <!-- Short decription -->
                    <p class="mt-3 mb-0">Short description</p>
                    <p class="text mt-2">
                        <textarea id="description" name="description" rows="3" cols="30"></textarea>
                    </p>
                    <!-- Instructions -->
                    <p class="mt-3 mb-0">Instructions</p>
                    <p class="text mt-2">
                        <textarea id="instructions" name="instructions" rows="10" cols="30"></textarea>
                    </p>

                    <div id="Make_Recipe_Ingredients">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Spirit</span>
                            </div>
                            <input list="list1" type="text" name="beverage[0][name]" class="form-control ingredientInput" placeholder="ex. Vodka" autocomplete="off" required>
                            <datalist id="list1">
                            
                            </datalist>

                            <div class="input-group-prepend">
                                <span class="input-group-text">Centiliter</span>
                            </div>
                            <input type="number" name="beverage[0][amount]" id="amount_0" class="form-control" required>
                        </div>

                        
                    </div>

                    <div class="row">
                        <div class="col text-center">
                            <a href="#" onclick="addIngerdient()"><img src="media/plus_icon.png" width="32px"></a>
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





<!--
<!DOCTYPE html>
<html>

<head>

</head>

<body id="addRecipeBody">
-->    <!-- Div for the AJAX serach results -->
<!--    <div id="Ingredient_Lookup_Div"></div>
-->
    <!-- Temp form for adding data to the database. 
        In future changes the name property on every input/textbox needs to stay the same for the backend to work -->
<!--    <form id="add_recipe_form" name="recipe_form" action="./php/recipe/add_recipe_to_db.php" method="POST">
        Name of drink <input type="text" name="drinkName" id="name" required><br>
        Short description <textarea id="description" name="description" rows="2" cols="30" required></textarea><br>
        Instructions <textarea id="instructions" name="instructions" rows="4" cols="50" required></textarea><br>
        Centiliter <input type="number" name="ingredient[0][amount]" id="amount_0" required><br>
        Sprit <input list="list_ingredient_0" type="text" name="ingredient[0][ingredientName]" id="ingredient_0"
            onkeyup="Ingredient_Lookup(this.value, this.id)" autocomplete="off" required><br>
    </form>
    <button type="submit" form="add_recipe_form" value="Submit">Submit</button>   
    <input type="button" value="Add Ingredient" onclick="addIngredient()">

    <script src="./js/add_recipe.js"></script>
    </body>

</html>-->