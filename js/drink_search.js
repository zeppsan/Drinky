/* 
Author: 
    Eric Qvarnström

Description:
    Javascript for handling drink_search

*/

const fieldHolder = document.getElementById("fieldHolder");
const searchResultContainer = document.getElementById("searchResult");
let fieldCounter = 1;


// Add a field
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

function searchDrinks() {
    let inputs = document.querySelectorAll('.alcoInput');
    let data = [];
    inputs.forEach(element => {
        data.push(element.value);
    });

    console.log(JSON.stringify(data));

    fetch("php/recipe/search_recipe.inc.php", {
            method: "POST",
            mode: "same-origin",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            clearResult();
            applySearch(data);
        })
}



function applySearch(data) {

    if (data.length) {
        searchResultContainer.innerHTML += `<div class="row px-3 mt-3">
        <div class="col"><b>Drink Image</b></div>
        <div class="col"><b>Drink Name</b></div>
        <div class="col"><b>Description</b></div>
        <div class="col"><b>Drink Rating</b></div>
    </div>`;
    }


    data.forEach(element => {
        let image = element.image;

        if (element.image === null)
            image = "media/drinkImages/default.png";

        let rating = Math.round(element.rating * 100) / 100;
        document.getElementById("searchResult").innerHTML += `<a href="showRecipe.php?drinkName=${element.name}">
        <div class="row">
            <div class="col-12">
                <div class="row my-2 drink-container p-3">
                    <div class="col">
                        <img src="${image}" height="64px">
                    </div>
                    <div class="col">
                        <p class="drink-name">
                            ${element.name}
                        </p>
                    </div>
                    <div class="col">
                        <p class="description">
                            ${element.description}
                        </p>
                    </div>
                    <div class="col">
                        <p class="profileDrinkRating">
                            ${rating}
                        </p>    
                    </div>
                </div>
            </div>
        </div>
    </a>`;
    });
}

function clearResult() {
    document.getElementById("searchResult").innerHTML = "";
}