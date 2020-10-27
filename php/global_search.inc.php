<?php

    /* 
        Author: 
            Eric Qvarnström - PHP,

        Description:
            backend script to manage the post request from the global search bar
        
        Variables in:
            searchString    - the string to search for



    */ 

    $contentType = $_SERVER["CONTENT_TYPE"];

    require_once 'includes/db.inc.php';


    function getUsers($queryString){
        global $conn;
        $stmt = $conn->prepare("SELECT username FROM users WHERE username LIKE ? LIMIT 5");
        $stmt->bind_param("s", $queryString);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all();
    }

    function getRecipes($queryString){
        global $conn;
        $stmt = $conn->prepare("SELECT name FROM recipe WHERE name LIKE ? LIMIT 5");
        $stmt->bind_param("s", $queryString);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all();
    }

    //Receive the RAW post data.
    $content = file_get_contents("php://input");
    $decoded = json_decode($content, true);

    // Convert the string to a database friendly search-string
    $searchString = "%".$decoded['searchString']."%";

    $users = getUsers($searchString);

    $recipes = getRecipes($searchString);

    $final = [
        "users" => $users,
        "recipe" => $recipes
    ];

    echo json_encode($final);