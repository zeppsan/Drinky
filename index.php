<!--
    Author: 
        Frida Westerlund

      Description:
      This is the start page. It's main purpose is to inform the user about our webpage
      and what it is for. If you are not logged in you should only get information on what 
      Drinky is all about, but are you logged in as a user then it should also show top-recipes. 
      It doesn't show top-recipes from the start because we don't want underage users to 
      be informed or guided into underaged drinking. 
-->
<!DOCTYPE html>
<?php

  if(session_status() != PHP_SESSION_ACTIVE)
    session_start();
    include("php/includes/db.inc.php");


    $stmt =$conn->prepare("SELECT * from recipe order by rating_total DESC limit 3"); 
    $stmt->execute(); 
    $topRecipes = $stmt->get_result(); 
    $topArray = []; 
    $i = 0; 

    while($row = mysqli_fetch_row($topRecipes)){
        $topArray[$i++] = array("name"=>$row[1], "rating_total"=>$row[4], "votes"=>$row[5], "image"=>$row[6]); 
    }
    $defaultImage = "media/drinkImages/default.png"; 
?>

<html lang="en">
<body class ="bg-bluegradient">
    <?php include_once 'header.php'; ?>
    <div class="container">
        <div id="index" class="row justify-content-center">
            <div class="col-6 col-md-3">
                <img src="media/coctail.png" width="200em">
            </div>
            <div class="col-12 col-md-3 ">
                <div class="infoArea"><h4>Drinky is the platform for you that want to share your best drinks and to experiment by testing others! <hr> 
                You can also rate others recipes and see what the best recipes of the site is in the TOP-Ratings!
                </h4></div>
            </div>
        </div>
        <?php if(isset($_SESSION['username'])):?>
            <hr id="index">
            <h3 style="text-align:center;">TOP-Recipes!</h3>
        <div class="row justify-content-center">
            <div class="col-12 col-md-3">
            <a href="showRecipe.php?drinkName=<?php echo $topArray[0]['name']; ?>">
                <h4><?php echo round($topArray[0]['rating_total']/$topArray[0]['votes'],1); ?>
                <i><?php echo $topArray[0]['name']; ?></i></h4>
                <img src="<?php if($topArray[0]['image'] == NULL)
                echo $defaultImage; else echo $topArray[0]['image'];?>" width="200em"height="200em"></a>
            </div>
            <div class="col-12 col-md-3">
            <a href="showRecipe.php?drinkName=<?php echo $topArray[1]['name']; ?>">
                <h4><?php echo round($topArray[1]['rating_total']/$topArray[1]['votes'],1); ?>
                <i><?php echo $topArray[1]['name']; ?></i></h4>
                <img src="<?php if($topArray[1]['image'] == NULL)
                echo $defaultImage; else echo $topArray[1]['image'];?>"width="200em"height="200em"></a>
            </div>
            <div class="col-12 col-md-3 mb-2">
                <a href="showRecipe.php?drinkName=<?php echo $topArray[2]['name']; ?>">
                <h4><?php echo round($topArray[2]['rating_total']/$topArray[2]['votes'],1); ?>
                <i><?php echo $topArray[2]['name']; ?></i></h4>
                <img src="<?php if($topArray[2]['image'] == NULL)
                echo $defaultImage; else echo $topArray[2]['image'];?>"width="200em"height="200em"></a>
            </div>
        </div>
        <div class="row justify-content-center" id="index"></div>
        
         <?php endif;?>
    </div>
</body>
</html>