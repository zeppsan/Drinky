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
        document.getElementById('Ingredient_Lookup_Div').innerHTML = "";
        return;
    }

    //Resets the serach results everytime.
    document.getElementById('Ingredient_Lookup_Div').innerHTML = "";

    //Set the position of the container for search results
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
            var datalist = document.createElement("datalist");
            datalist.setAttribute("id", "list_" + input_name);
            data.forEach(element => {
                var option = document.createElement("option");
                option.value = element;
                //option.setAttribute("value", element);
                datalist.appendChild(option);
                console.log("input " + input_name + "serach = " + search_str)
                /*
                var temp_div = document.createElement("div");
                temp_div.setAttribute("id", element);
                /* temp_div.addEventListener('click', function () {
                     document.getElementById(input_name).innerHTML = element;
                 })
                 
                temp_div.setAttribute("onclick", "Add_To_Input(this.id, " + input_name + ")");
                var name = document.createTextNode(element);
                temp_div.appendChild(name);
                document.getElementById("Ingredient_Lookup_Div").appendChild(temp_div);
                console.log(element);
                */
            })
            document.getElementById(input_name).appendChild(datalist);
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
const ingredientsContainer = document.getElementById('Make_Recipe_Ingredients');

function addIngredient() {

    //Add spirit
    let spirit = document.createElement("div");
    spirit.className = "input-group mb-3";

    let spirit_prepend = document.createElement("div");
    spirit_prepend.className = "input-group-prepend";

    let spirit_span = document.createElement("span");
    spirit_span.className = "input-group-text";
    span.innerText = "Spirit " + (numberOfFields);

    let spirit_input = document.createElement("input");
    spirit_input.type = "text";
    spirit_input.name = "ingredient[" + numberOfFields + "][ingredientName]";
    spirit_input.className = "form-control alcoInput";
    spirit_input.id = "ingredient_" + numberOfFields + "";
    spirit_input.placeholder = "ex: vodka";
    spirit_input.autocomplete = "off";
    /*
            let removeBtn = document.createElement('button');
            removeBtn.className = "btn btn-warning remove";
            removeBtn.innerText = "Del";
            removeBtn.id = "remove" + fieldCounter;
    */
    spirit_prepend.appendChild(spirit_span);
    spirit.appendChild(spirit_prepend);
    spirit.appendChild(spirit_input);
    ingredientsContainer.appendChild(spirit);

    //Add amount
    let amount = document.createElement("div");
    amount.className = "input-group mb-3";

    let amount_prepend = document.createElement("div");
    amount_prepend.className = "input-group-prepend";

    let amount_span = document.createElement("span");
    amount_span.className = "input-group-text";
    amount.innerText = "Cl " + (numberOfFields);

    let amount_input = document.createElement("input");
    amount_input.type = "number";
    amount_input.name = "ingredient[" + numberOfFields + "][amount]";
    amount_input.className = "form-control alcoInput";
    amount_input.id = "ingredient_" + numberOfFields + "";
    /*
            let removeBtn = document.createElement('button');
            removeBtn.className = "btn btn-warning remove";
            removeBtn.innerText = "Del";
            removeBtn.id = "remove" + fieldCounter;
    */
    amount_prepend.appendChild(amount_span);
    amount.appendChild(amount_prepend);
    amount.appendChild(amount_input);
    ingredientsContainer.appendChild(amount);


    numberOfFields++;
    /*
    inputGroup.appendChild(removeBtn);
    col.appendChild(inputGroup);
    fieldHolder.appendChild(col);
    */
    /*
        document.getElementById('Make_Recipe_Ingredients').innerHTML +=
            "Centiliter nr " + numberOfFields + " <input type='number' id='amount_" + numberOfFields + "' class='form-control' name='ingredient[" + numberOfFields + "][amount]' required><br>" +
            "Sprit nr " + numberOfFields + "<input list='list_ingredient_" + numberOfFields + "' type='text' id='ingredient_" + numberOfFields + "' class='form-control' name='ingredient[" + numberOfFields + "][ingredientName]' autocomplete=off required><br>";
                    Ingredient_Lookup("", "ingredient_" + numberOfFields);
                    numberOfFields++;
            }
    */
}
