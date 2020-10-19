<?php
/*
    Author: Max Jonsson

    Description:
    Helps AJAX for inserting recipe.
    Gets all the ingredients that matches the user input and returns an JSON.accordion
*/ 
require_once("../includes/db.inc.php");

$input = trim(file_get_contents("php://input"));
$decoded = json_decode($input, true);

$cstr = "%".$decoded['searchString'].'%';

$stmt = $conn->prepare("SELECT name FROM ingredients WHERE name LIKE ? LIMIT 5");
$stmt->bind_param("s", $cstr);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_all());

?>