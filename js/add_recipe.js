/*
    Author: Max Jonsson

    Description:
    Javascript for adding more ingredients and handeling AJAX for easier search in ingredients. 

*/

let fieldCounter = 1;
addUnits();
//Event listner to check if the user is typing in the inputbox
document.addEventListener('keyup', (e) => {
    console.log(e);
    if (e.target.classList.contains("ingredientInput"))
        IngredientSearch(e.target);
});

//AJAX search for the ingredients
function IngredientSearch(target) {
    fetch("php/recipe/ingredient_lookup.php", {
        method: "POST",
        mode: "same-origin",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "searchString": target.value
        })
    })
        .then(response => response.json())
        .then(data => {
            clearResult(target.list.id);
            console.log();
            applySearch(data, target.list.id);
        })
}

//If the user is typing add the ajax result to the datalist
function applySearch(data, targetId) {
    let target = document.getElementById(targetId);

    data.forEach(element => {
        target.innerHTML += `<option value="${element}">`;
    });
}

//Clears the search results so the user dont get duplicate suggestions
//When the box is empty there should not be any sugesstions 
function clearResult(targetId) {
    document.getElementById(targetId).innerHTML = "";
}

var inputList = document.getElementById('Recipe_Ingredients');

//When the user clicks the green plus add more fields to the document
function addField() {
    var fields = `
        <div class="input-group mb-3" id="input${fieldCounter}">
            <div class="input-group-prepend">
                <span class="input-group-text">Spirit</span>
            </div>
            <input list="list${fieldCounter + 1}" type="text" name="beverage[${fieldCounter}][name]" class="form-control ingredientInput" placeholder="ex. Vodka" autocomplete="off" required>
                <datalist id="list${fieldCounter + 1}">

                </datalist>

                <div class="input-group-prepend">
                    <select name="beverage[${fieldCounter}][unit]" class="input-group-text">
                        <option value="cl">cl</option>
                        <option value="dl">dl</option>
                        <option value="pcs">pcs</option>
                    </select>
                </div>
                <input type="number" name="beverage[${fieldCounter}][amount]" class="form-control" required>
                <button class="btn btn-warning remove" id="remove${fieldCounter}">Del</button>
        </div>`;
    inputList.insertAdjacentHTML("beforeEnd", fields);

    fieldCounter++;
}

//Event listner for the delete input button
document.addEventListener('click', (e) => {
    if (e.target.classList == "btn btn-warning remove")
        removeInputField(e.target.id);
});

//Function to remove the inputfield
function removeInputField(inputNumber) {
    let numToRemove = inputNumber.slice(6, 10);
    document.getElementById("input" + numToRemove).remove();
}

function addUnits(units) {
    document.getElementsByName('unit0').innerHTML +=
        `
    <option value="cl">cl</option>
    <option value="dl">dl</option>
    <option value="pcs">pcs</option>
    `
}