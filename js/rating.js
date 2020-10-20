/* 
    Author: 
        Casper Kärrström

    Description:
        Javascript for the rating system on recipes

*/

const stars = document.querySelectorAll('.ratingStars');
let voted;
let commentFieldOutput = false;

stars.forEach(element => {              //  måste lägga till en if sats som kollar om man redan har klickat en gång,
                                        //  då ska man inte få upp en till textarea att skriva i.

    element.addEventListener("click", (e) => {
        if(commentFieldOutput == false){
            document.getElementById("commentField").innerHTML += `
                    <div class="form-group">
                        <input type="number" name="rating" value="${voted}" hidden>
                        <label>Drink Comment</label>
                        <textarea class="form-control" name="drinkComment" rows="3"></textarea>
                        <button type="submit" class="btn btn-gray">Submit</button>
                    </div>
            `;
        }
    });

    element.addEventListener("mouseover", (e) => {
        resetStars();
        switch (e.target.id) {
            case "s1":
                voted = 1;
                setStars(voted);
                break;
            case "s2":
                voted = 2;
                setStars(voted);
                break;
            case "s3":
                voted = 3;
                setStars(voted);
                break;
            case "s4":
                voted = 4;
                setStars(voted);
                break;
            case "s5":
                voted = 5;
                setStars(voted);
                break;
            default:
                break;
        }
    });
});

function setStars(amount){
    for(let i = 0 ; i < amount; i++){
        stars[i].style.color = "gold";
    }
}

function resetStars(){
    stars.forEach(element => {
        element.style.color = "black";
    });
}
