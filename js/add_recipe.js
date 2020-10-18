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

function addIngredient() {
    document.getElementById('add_recipe_form').innerHTML +=
        "Centiliter nr " + numberOfFields + " <input type='number' id='amount_" + numberOfFields + "' name='ingredient[" + numberOfFields + "][amount]' required><br>" +
        "Sprit nr " + numberOfFields + "<input list='list_ingredient_" + numberOfFields + "'type='text' id='ingredient_" + numberOfFields + "' name='ingredient[" + numberOfFields + "][ingredientName]' autocomplete=off required><br>";
    Ingredient_Lookup("", "ingredient_" + numberOfFields);
    numberOfFields++;
}


//Test
/*
const fieldHolder = document.getElementById("fieldHolder");

function addField() {
    let col = document.createElement("div");
    col.className = "col-12";
    col.id = "input" + fieldCounter;

    let inputGroup = document.createElement("div");
    inputGroup.className = "input-group mb-3";

    let prepend = document.createElement("div");
    prepend.className = "input-group-prepend";

    let span = document.createElement("span");
    span.className = "input-group-text";
    span.innerText = "Beverage " + (fieldCounter + 1);

    let input = document.createElement("input");
    input.type = "text";
    input.name = "drink[" + fieldCounter + "][beverage]";
    input.className = "form-control alcoInput";
    input.placeholder = "ex: vodka";

    let removeBtn = document.createElement('button');
    removeBtn.className = "btn btn-warning remove";
    removeBtn.innerText = "Del";
    removeBtn.id = "remove" + fieldCounter;

    prepend.appendChild(span);
    inputGroup.appendChild(prepend);
    inputGroup.appendChild(input);
    inputGroup.appendChild(removeBtn);
    col.appendChild(inputGroup);
    fieldHolder.appendChild(col);

    fieldCounter++;
}

document.addEventListener('click', (e) => {
    if (e.target.classList == "btn btn-warning remove")
        removeInputField(e.target.id);
});

function removeInputField(inputNumber) {
    let numToRemove = inputNumber.slice(6, 10);
    document.getElementById("input" + numToRemove).remove();
}
*/