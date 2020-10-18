<?php

    /* 
        Author: 
            Eric Qvarnström

        Description:
            Handles requests from the search_recipe page

    */ 

    $contentType = $_SERVER["CONTENT_TYPE"];

    require_once '../includes/db.inc.php';
    $conn->set_charset("utf8");

    //Receive the RAW post data.
    $content = file_get_contents("php://input");

    $decoded = json_decode($content, true);

    $prepareString = 'SELECT DISTINCT recipe.name, recipe.description, recipe.rating_total / recipe.votes AS "rating" FROM (recipe_ingredients INNER JOIN ingredients ON recipe_ingredients.ingredient_ID = ingredients.ingredient_ID) INNER JOIN recipe on recipe.recipe_ID = recipe_ingredients.recipe_ID WHERE ingredients.name = "" ';

    $arr = [];

    foreach($decoded as $drink){
        array_push($arr, $drink);
        $prepareString .= "OR ingredients.name = ? ";
    }


    $stmt = $conn->prepare($prepareString);

    switch (count($arr)) {
        case 1:
            $stmt->bind_param("s", $arr[0]);
            break;
        case 2:
            $stmt->bind_param("ss", $arr[0], $arr[1]);
            break;
        case 3:
            $stmt->bind_param("sss", $arr[0], $arr[1], $arr[2]);
            break;
        case 4:
            $stmt->bind_param("ssss", $arr[0], $arr[1], $arr[2], $arr[3]);
            break;
        case 5:
            $stmt->bind_param("sssss", $arr[0], $arr[1], $arr[2], $arr[3], $arr[4]);
            break;
        case 6:
            $stmt->bind_param("ssssss", $arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5]);
            break;
        case 7:
            $stmt->bind_param("sssssss", $arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6]);
            break;
        case 8:
            $stmt->bind_param("ssssssss", $arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7]);
            break;
        case 9:
            $stmt->bind_param("sssssssss", $arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7], $arr[8]);
            break;
        default:
            break;
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $resultArray = [];

    while($row = $result->fetch_assoc()){
        array_push($resultArray, $row);
    }

    echo  json_encode($resultArray);
?>