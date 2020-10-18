<!--
    Author: 
        Frida Westerlund

      Description:
      This will take a random recipe from the database and show it when you click 
      on Random Recipe in the header. 
-->

<?php
include("./php/includes/db.inc.php");

$stmt = $conn->prepare("SELECT * from recipe order by rand() limit 1 "); 
$stmt->execute(); 
$recipeName = $stmt->get_result()->fetch_assoc(); 
$name = $recipeName['name'];
header("Location: http://localhost/Drinky/showRecipe.php?drinkName=$name"); 
?>