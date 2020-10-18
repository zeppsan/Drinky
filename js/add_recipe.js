/*
    Author: Max Jonsson

    Description:
    Javascript for adding more ingredients and handeling AJAX for easier search in ingredients. 

    Variables:
    search_str - The input from the user
    input_name - The ID of the input tag that the user is writing in.
*/

//AJAX serach with Fetch to help the user with ingredients.
function Ingredient_Lookup(search_str, input_name) {
    if (search_str.length == 0) {
        document.getElementsByName(input_name).innerHTML = "";
        return;
    }

    Ingredient_Lookup_Container(input_name);

    fetch('./php/recipe/ingredient_lookup.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(
            {
                "search": search_str
            }
        ),
    })
        .then(response => response.json())
        .then(data => {
            var datalist = document.createElement("div");
            data.forEach(element => {
                var temp_div = document.createTextNode(element);

                datalist.appendChild(temp_div);
                console.log(element);
            });
            console.log(datalist);
            document.getElementById("Ingredient_Lookup_Div").appendChild(datalist);
            console.log("hejsan");
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

//Set the position of the DIV with the AJAX results 
function Ingredient_Lookup_Container(input_name) {
    var rect = document.getElementById(input_name).getBoundingClientRect();
    var searchHelp = document.getElementById('Ingredient_Lookup_Div');
    searchHelp.style.position = "absolute";
    searchHelp.style.left = rect.left + "px";
    searchHelp.style.right = rect.right + "px";
    searchHelp.style.top = rect.top + rect.height + "px";
    searchHelp.style.width = rect.width + "px";
    searchHelp.style.zIndex = 1;

}

//Appending input fields if the user wants to add more ingredients
var numberOfFields = 1;

function addIngredient() {
    document.getElementById('add_recipe_form').innerHTML +=
        "Centiliter nr " + numberOfFields + " <input type='number' id='amount_" + numberOfFields + "' name='ingredient[" + numberOfFields + "][amount]' required><br>" +
        "Sprit nr " + numberOfFields + "<input type='text' id='ingredient_" + numberOfFields + "' name='ingredient[" + numberOfFields + "][ingredientName]' required><br>";
    numberOfFields++;
}