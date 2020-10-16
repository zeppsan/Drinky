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

function Ingredient_To_Input() {

}

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
        "Centiliter nr " + numberOfFields + " <input type='number' id='amount_" + numberOfFields + "' name='ingredient[" + numberOfFields + "][amount]'><br>" +
        "Sprit nr " + numberOfFields + "<input type='text' id='ingredient_" + numberOfFields + "' name='ingredient[" + numberOfFields + "][ingredientName]'><br>";
    numberOfFields++;
}