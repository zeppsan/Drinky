<?php



    $contentType = $_SERVER["CONTENT_TYPE"];

    require_once 'includes/db.inc.php';


    //Receive the RAW post data.
    $content = file_get_contents("php://input");

    $decoded = json_decode($content, true);

    $searchString = "%".$decoded['searchString']."%";


    $stmt = $conn->prepare("SELECT username FROM users WHERE username LIKE ? LIMIT 5");
    $stmt->bind_param("s", $searchString);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all();

    $stmt = $conn->prepare("SELECT name FROM recipe WHERE name LIKE ? LIMIT 5");
    $stmt->bind_param("s", $searchString);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_all();

    $final = [
        "users" => $users,
        "recipe" => $recipe
    ];

    echo json_encode($final);