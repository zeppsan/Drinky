const searchBar = document.getElementById("searchBar");
const result_container = document.getElementById("searchField");

result_container.style.top = searchBar.offsetTop + 2.5 + "em";

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
        listItem.innerText = element;
        listItem.classList.add("searchLink");
        result_container.appendChild(listItem);
    });
    Show();
}

function Hide() {
    result_container.style.display = "none";
}

function Show() {
    result_container.style.display = "block";
}