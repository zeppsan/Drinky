<!--
    Author: 
        Max Jonsson

      Description:
        This document will handle the html for adding recpies to the database.
-->
<?php 
    include("./header.php");
    include("./php/includes/db.inc.php");
?>
<!DOCTYPE html>
<html>

<head>

</head>

<body id="addRecipeBody">
    <script>
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
        }
    </script>

    <form id="add_recipe_form" name="recipe_form" action="./php/recipe/add_recipe_to_db.php" method="POST">
        <input class = "btn btn-gray" type="submit" value="Submit"><br>
        Centiliter <input class="form-control" type="number" name="amount_0"><br>
        Sprit <input class="form-control" type="text" name="ingredient_0"><br>
    </form>
    <input class="btn btn-gray" type="button" value="Add Ingredient" onclick="addIngredient()">




</body>

</html>