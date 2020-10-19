/* 
    Author: 
        Casper Kärrström

    Description:
        Javascript for the rating system on recipes

*/


document.addEventListener("click", (e) => {

    switch (e.target.id) {
        case "s1":
            rate(1);
            break;
        case "s2":
            rate(2);
            break;
        case "s3":
            rate(3);
            break;
        case "s4":
            rate(4);
            break;
        case "s5":
            rate(5);
            break;
        default:
            break;
    }

});

function rate(ratedIndex){

    for(var i=0; i <=ratedIndex; i++){
        //pissråtta assåååå
    }

}