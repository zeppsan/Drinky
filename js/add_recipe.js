/*
    Author: Max Jonsson

    Description:
    Javascript for adding more ingredients and handeling AJAX for easier search in ingredients. 

    Variables:
    search_str - The input from the user
*/

let fieldCounter = 1;

document.addEventListener('keyup', (e) => {
    console.log(e);
    if (e.target.classList.contains("ingredientInput"))
        IngredientSearch(e.target);
});

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
            console.log(target.list);
            clearResult(target.list.id);
            applySearch(data, target.list.id);
        })
}

function applySearch(data, targetId) {
    let target = document.getElementById(targetId);

    data.forEach(element => {
        target.innerHTML += `<option value="${element}">`;
    });
}

function clearResult(targetId) {
    document.getElementById(targetId).innerHTML = "";
}

var inputList = document.getElementById('Recipe_Ingredients');

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
                    <span class="input-group-text">Centiliter</span>
                </div>
                <input type="number" name="beverage[${fieldCounter}][amount]" class="form-control" required>
                <button class="btn btn-warning remove" id="remove${fieldCounter}">Del</button>
        </div>`;
    console.log("addField recipe");
    inputList.insertAdjacentHTML("beforeEnd", fields);
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