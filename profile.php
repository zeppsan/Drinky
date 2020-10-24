<?php

    /* 
        Author: 
            Eric Qvarnström - PHP, Layout, HTML
            Frida Westerlund - HTML

        Description:
            Script to login a user. Checks credentials agains database
        
        Variables in:
            username        - Username
            password        - Password

        Variables that can be used in this document:
            profilepicture:     <?php echo $profilepic?>
            first name:         <?php echo ucfirst($row['fname']) ?>
            last name:          <?php echo ucfirst($row['lname']) ?>
            age:                <?php echo $row['age'] ?>
            presentation:       <?php echo $row['presentation']?>
            rating:             <?php echo round($drink_ratings['rating'], 1) ?>


    */ 

    session_start();

    if(!isset($_SESSION['username']))
        header("Location: login.php?error=notloggedin");

    require_once 'php/includes/db.inc.php';
    
    // Check if there is a specific profile that we should visit
    // Fetch information about the user from the database
    if(isset($_GET['user'])){
        // If a specific user is specified
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $_GET['user']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    } else {
        // If no user is specified, get the logged in user instead
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }

    if($result->num_rows > 0){
        // Gets the user average drink rating
        $stmt = $conn->prepare("SELECT user_recipe.user_ID, sum(recipe.rating_total) / sum(recipe.votes) AS 'rating' FROM user_recipe INNER JOIN recipe on recipe.recipe_ID = user_recipe.recipe_ID WHERE user_recipe.user_ID = ?");
        $stmt->bind_param("i", $row['id']);
        $stmt->execute();
        $drink_ratings = $stmt->get_result()->fetch_assoc();

        if($drink_ratings['rating'] == null)
            $drink_ratings['rating'] = 0;


        // fetch user drinks 
        $stmt = $conn->prepare("SELECT name, image, description, instructions, rating_total / votes AS 'rating' FROM user_recipe JOIN recipe on user_recipe.recipe_ID = recipe.recipe_ID WHERE user_recipe.user_ID = ? ORDER BY rating DESC LIMIT 5");
        $stmt->bind_param("i", $row['id']);
        $stmt->execute();
        $top_drinks_result = $stmt->get_result();
        $top_drinks_amount = $top_drinks_result->num_rows;

        // Checks if user has set an profile-image, else, display the stock one.
        if($row['profile_picture'] != null){  
            $profilepic = $row['profile_picture'];
        }else{ 
            $profilepic = "media/profilepictures/profilestock.jpg";
        }  
    } 
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <title>Profile</title>
    <?php include_once 'header.php'; ?>
</head>
<body class="bg-bluegradient">

    <div class="container profile">
        <div class="row p-3">
            <div class="col-12 col-md-6 col-lg-3 pl-3">
                <img src="<?php echo $profilepic?>" class="img" width="100%;">
            </div>
            <div class="col-12 col-md-6 my-auto">
                <h3 class="title"><?php echo ucfirst($row['username'])?></h3>
                <h4 class="sub-title"><?php echo ucfirst($row['fname'])." ".ucfirst($row['lname']).", ". $row['age']?></h4>
                <p class="text mt-2"><?php echo $row['presentation']?></p>
                <?php if($_SESSION['username'] == $row['username']): ?>
                    <a href="updateProfile.php" class="btn btn-gray mt-3">Edit
                        <img src="media/pen.png" width="40px" height="40px">
                    </a>
                <?php endif;?>
            </div>
            <div  class="col-12 col-md-3 text-center my-auto ">
                <p class="small my-0">Average Drink Score</p>
                <h1 style="color:red;"><?php echo round($drink_ratings['rating'], 1) ?> / 5</h1>
            </div>
        </div>
        <hr>

        <div class="row mt-2 p-3">
            <div class="col-12">
                <h3><?php echo ucfirst($row['username']);?>'s Top Recipes</h3>
            </div>
            <div class="col-12">
                <?php 
                if($top_drinks_amount > 0): ?>
                    <div class="row px-3 mt-3">
                        <div class="col"><b>Image</b></div>
                        <div class="col"><b>Drink Name</b></div>
                        <div class="col"><b>Description</b></div>
                        <div class="col"><b>Drink Rating</b></div>
                    </div>
                    <?php while($drinkrow = $top_drinks_result->fetch_assoc()): ?> 


                        <a href="showRecipe.php?drinkName=<?php echo $drinkrow['name']?>">
                            <div class="row my-2 drink-container p-3">
                            <div class="col">
                                    <img src="<?php if($drinkrow['image'] == NULL)
                                    echo "media/coctail.png"; else echo $drinkrow['image']?>" height="64px">
                                </div>
                                <div class="col">
                                    <p class="drink-name">
                                        <?php echo $drinkrow['name']?>
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="description">
                                        <?php echo $drinkrow['description']?>
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="profileDrinkRating">
                                        <?php echo round($drinkrow['rating'], 1)?>
                                    </p>    
                                </div>
                            </div>
                        </a>
                        <div class="col"> 
                            <?php if($_SESSION['username'] == $row['username']): ?>
                            <a href="php/recipe/remove_recipe.php?drinkName=<?php echo $drinkrow['name']?>" class="btn btn-gray mt-3">Delete</a>
                            <?php endif;?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
            
                <p><?php echo $row['username']?> Has not drinks to show :(</p>
                <?php endif;?>

                    
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>