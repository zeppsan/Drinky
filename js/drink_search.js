/* 
Author: 
    Eric Qvarnström

Description:
    Javascript for managing the search recipe function.


*/

// Variables
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

// Looks for klicks on the remove buttons
document.addEventListener('click', (e) => {
    if (e.target.classList == "btn btn-warning remove")
        removeInputField(e.target.id);
});

// Removes the input field that was targeted (from delete button)
function removeInputField(inputNumber) {
    let numToRemove = inputNumber.slice(6, 10);
    document.getElementById("input" + numToRemove).remove();
}

// Fetches drinks from the database when the user presses search
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

// Prints the database result to the document.
function applySearch(data) {

    // if data exist, print title. Else, print that no drinks were found.
    if (data.length > 0) {
        searchResultContainer.innerHTML += `<div class="row px-3 mt-3">
        <div class="col"><b>Drink Image</b></div>
        <div class="col"><b>Drink Name</b></div>
        <div class="col"><b>Description</b></div>
        <div class="col"><b>Drink Rating</b></div>
    </div>`;
    } else {
        searchResultContainer.innerHTML += `
            <h2>No drinks were found...</h2>
        `;
    }
    data.forEach(element => {
        let image = element.image;

        if (element.image === null)
            image = "media/drinkImages/default.png";

        let rating = Math.round(element.rating * 100) / 100;
        document.getElementById("searchResult").innerHTML += `<a href="showRecipe.php?drinkName=${element.name}">
        <div class="row px-2">
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

// Clears the search result
function clearResult() {
    document.getElementById("searchResult").innerHTML = "";
}