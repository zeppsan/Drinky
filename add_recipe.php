<!--
    Author: 
        Max Jonsson

      Description:
        This document will handle the html for adding recpies to the database.
-->
<?php 
    include("./header.php");
    require_once("./php/includes/db.inc.php");
    /*if(isset($_SESSION['username']))
        header("location: ./login.php");
        */
?>
<!DOCTYPE html>
<html>

<head>

</head>

<<<<<<< HEAD <body>
    <!--<script>
=======
<body id="addRecipeBody">
    <script>
>>>>>>> 471eec207b848c2d1654eee12f388c5b3f948841
        var numberOfFields = 1;
        function addIngredient() {
            /*
            var node1 = document.createElement("input");
            var textnode1 = document.createTextNode("Centiliter nr" + numberOfFields);
            node1.appendChild(textnode1);

            var node2 = document.createElement("input");
            var textnode2 = document.createTextNode("Sprit nr" + numberOfFields);
            node2.appendChild(textnode2);

            document.getElementById("add_recipe_form").appendChild(node1);
            document.getElementById("add_recipe_form").appendChild(node2);
            */
            document.getElementById('add_recipe_form').innerHTML +=
                "Centiliter nr " + numberOfFields + " <input type='number' name='amount_" + numberOfFields + "'><br>" +
                "Sprit nr " + numberOfFields + "<input type='text' name='ingredient_" + numberOfFields + "'><br>";
            numberOfFields++;
        }
    </script>-->
    <div id="Ingredient_Lookup_Div"></div>

    <form id="add_recipe_form" name="recipe_form" action="./php/recipe/add_recipe_to_db.php" method="POST">
        Name of drink <input type="text" name="drinkName" id="name"><br>
        Short description <textarea id="description" name="description" rows="2" cols="30"></textarea><br>
        Instructions <textarea id="instructions" name="instructions" rows="4" cols="50"></textarea><br>
        Centiliter <input type="number" name="ingredient[0][amount]" id="amount_0"><br>
        Sprit <input type="text" name="ingredient[0][ingredientName]" id="ingredient_0"
            onkeyup="Ingredient_Lookup(this.value, this.id)" autocomplete="off"><br>
        <input type="submit" value="Submit"><br>
    </form>

    <input type="button" value="Add Ingredient" onclick="addIngredient()">

    <script src="./js/add_recipe.js"></script>
    </body>

</html>