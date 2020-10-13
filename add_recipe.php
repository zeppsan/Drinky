<!--
    This document will handle the html of adding recpies to the database
-->

<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <script>
        var numberOfFields = 1;
        function addIngredient() {
            document.getElementById('add_recipe_form').innerHTML += `
                <input type='number' name='amount_" + numberOfFields++ + "'><br>
                <input type='text' name='ingredient_" + numberOfFields++ + "'><br>
                `;
            console.log("hejsan");
        }
    </script>

    <form id="add_recipe_form" name="recipe_form" action="add_recipe.php" method="POST">
        <input type="number" name="amount_1"><br>
        <input type="text" name="ingredient_1"><br>
    </form>
    <input type="button" value="Add Ingredient" onclick="addIngredient()">


</body>

</html>