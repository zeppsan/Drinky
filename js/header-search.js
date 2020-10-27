/* 
Author: 
    Eric Qvarnström

Description:
    Javascript for handling the general search-bar

*/

const searchBar = document.getElementById("searchBar");
const result_container = document.getElementById("searchField");

result_container.style.top = searchBar.offsetTop + 2.5 + "em";

// If the user clicks outside of the search-result container, the container will hide.
document.addEventListener("click", (e) => {
    switch (e.target.className) {
        case "form-control":
            break;
        case "searchLink":
            break;
        default:
            Hide();
            break;
    }
});

// Sends a fetch whenever a key is pressed in the searchfield.
searchBar.addEventListener("keydown", (e) => {
    setTimeout(() => {
        fetch("php/global_search.inc.php", {
                method: "POST",
                mode: "same-origin",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "searchString": searchBar.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data['users'] == null && data['recipe'] == null)
                    Hide();
                else
                    SetDatalist(data);
            })
    }, 10);
});

// Fills the datalist with result from the fetch
function SetDatalist(data) {
    result_container.innerHTML = "";
    data['users'].forEach(element => {
        let listItem = document.createElement("a");
        listItem.innerText = element;
        listItem.classList.add("searchLink");
        listItem.href = "profile.php?user=" + element;
        result_container.appendChild(listItem);
    });

    if (data['recipe'].length > 0 && data['users'].length > 0) {
        result_container.innerHTML += "<hr>";
    }

    data['recipe'].forEach(element => {
        let listItem = document.createElement("a");
        listItem.value = element;
        listItem.href = "showRecipe.php?drinkName=" + element;
        listItem.innerText = element;
        listItem.classList.add("searchLink");
        result_container.appendChild(listItem);
    });
    Show();
}

// Hides the result-cointainer
function Hide() {
    result_container.style.display = "none";
}

// Shows the result-cointainer
function Show() {
    result_container.style.display = "block";
}