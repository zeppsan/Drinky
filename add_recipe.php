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
<html>

<head>

</head>

<body id="addRecipeBody">
    <script>
        var numberOfFields = 1;
        function addIngredient() {
            document.getElementById('add_recipe_form').innerHTML +=
                "Centiliter nr " + numberOfFields + " <input type='number' name='amount_" + numberOfFields + "'><br>" +
                "Sprit nr " + numberOfFields + "<input type='text' name='ingredient_" + numberOfFields + "'><br>";
            numberOfFields++;
        }
    </script>
    <!-- Div for the AJAX serach results -->
    <div id="Ingredient_Lookup_Div"></div>

    <!-- Temp form for adding data to the database. 
        In future changes the name property on every input/textbox needs to stay the same for the backend to work -->
    <form id="add_recipe_form" name="recipe_form" action="./php/recipe/add_recipe_to_db.php" method="POST">
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

</html>