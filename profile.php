<?php

    /* 
        Author: 
            Eric Qvarnström - PHP, Layout, HTML - The profile in general
            Frida Westerlund - HTML
            Max Jonsson - Tabs for showing top recipes and rated recipes

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
    
    /** Gets userdata from the specified user [Eric]
     * 
     * @param string username Users username
     * @return mysqli::result Returns mysqli result
     * 
     */
    function getUserData($username){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /** Gets the users average drink-rating [Eric]
     * 
     * @param int id Users id
     * @return int The users average Score
     * 
     */
    function getUserAverageScore($userid){
        global $conn;
        $stmt = $conn->prepare("SELECT user_recipe.user_ID, sum(recipe.rating_total) / sum(recipe.votes) AS 'rating' FROM user_recipe INNER JOIN recipe on recipe.recipe_ID = user_recipe.recipe_ID WHERE user_recipe.user_ID = ?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if($result != null)
            return $result;
        else 
            return 0;
    }

    /** Gets the users recipies [Eric]
     * 
     * @param int userid Users id
     * @return mysqli::result Returns mysqli result of users drinks
     * 
     */
    function getUserDrinks($userid){
        global $conn;
        $stmt = $conn->prepare("SELECT name, image, description, instructions, rating_total / votes AS 'rating' FROM user_recipe JOIN recipe on user_recipe.recipe_ID = recipe.recipe_ID WHERE user_recipe.user_ID = ? ORDER BY rating DESC LIMIT 5");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        return $stmt->get_result();
    }

    /** Checks if user was found. [Eric]
     * 
     * @param mysqli::result user-result The mysqli result from user query
     * @return bool True or False depending of the users existence
     * 
     */
    function hasValidUser($result){
        if($result->num_rows > 0)
            return true;
        return false;
    }

    // Get userinformation from the database. Either from get $_GET['name'] or current session. [Eric]
    if(isset($_GET['user'])){
        $result = getUserData($_GET['user']);
        $row = $result->fetch_assoc();
    } else {
        // If no user is specified, get the logged in user instead
        $result = getUserData($_SESSION['username']);
        $row = $result->fetch_assoc();
    }

    $userFound = hasValidUser($result);

    if($userFound){

        $drink_ratings = getUserAverageScore($row['id']);
        $top_drinks_result = getUserDrinks($row['id']);
        $top_drinks_amount = $top_drinks_result->num_rows;

        // Checks if user has set an profile-image, else, display the stock one.
        if($row['profile_picture'] != null){  
            $profilepic = $row['profile_picture'];
        }else{ 
            $profilepic = "media/profilepictures/profilestock.jpg";
        }  



        //Sql for the My top rated recipes [Max]
        if(!isset($_GET['user'])){
            // Get the logged in user
            $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
            $stmt->bind_param("s", $_SESSION['username']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc(); 
        }

        if ($result->num_rows > 0) {
            // Get the recipes and the rating for the user 
            $stmt = $conn->prepare("SELECT name, description, instructions, image, rating FROM user_ratings INNER JOIN recipe on recipe.recipe_ID=user_ratings.recipe_id WHERE user_ratings.user_id = ? ORDER BY rating DESC LIMIT 5");
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();
            $rated_result = $stmt->get_result();
            $top_rated_amount = $rated_result->num_rows;
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

    <!-- Checks if user was found, else, kill script [Eric] -->
    <?php if(!$userFound): ?>

        <div class="contianer">
            <div class="row">
                <div class="col text-center">
                    <h1>user was not found...</h1>
                </div>
            </div>
        </div>

    <?php die(); endif;?>

    <!-- Beginning of profile [Eric] -->
    <div class="container profile">
        <div class="row p-3">
            <div class="col-12 col-md-6 col-lg-3 pl-3">
                <img src="<?php echo $profilepic?>" class="img" width="100%;">
            </div>
            <div class="col-12 col-md-6 my-auto">
                <h3 class="title"><?php echo ucfirst($row['username'])?></h3>
                <h4 class="sub-title"><?php echo ucfirst($row['fname'])." ".ucfirst($row['lname']).", ". $row['age']?></h4>
                <p class="text mt-2"><?php echo $row['presentation']?></p>

                <!-- Adds edit-button if this is a session user -->
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

        <div class="row px-3">
        <!-- Tabs for the page [Max]-->
            <?php if($_SESSION['username'] == $row['username']): ?>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="top-recipe-tab" data-toggle="tab" href="#top-recipes" role="tab" aria-controls="top-recipe" aria-selected="true">My Top Recipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rated-tab" data-toggle="tab" href="#rated-recipes" role="tab" aria-controls="rated" aria-selected="false">My Rated Recipes</a>
                    </li>
                </ul>
            <?php endif;?>
            <div class="tab-content" id="tabsProfile">

                <!-- My top recipes [Eric] -->
                <div class="tab-pane fade show active" id="top-recipes" role="tabpanel" aria-labelledby="top-recipe-tab">
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
                                    <div class="col"></div>
                                </div>

                                <!-- Fetches another row for every recipe that the user has [Eric] -->
                                <?php while($drinkrow = $top_drinks_result->fetch_assoc()): ?> 

                                    <div class="row">
                                        <div class="col-10">
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
                                        </div>
                                        <div class="col-2 text-center my-auto"> 
                                            <?php if($_SESSION['username'] == $row['username']): ?>
                                            <a href="php/recipe/remove_recipe.php?drinkName=<?php echo $drinkrow['name']?>" class="btn btn-gray mt-3">Delete</a>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                        
                            <p><?php echo $row['username']?> Has not drinks to show :(</p>
                            <?php endif;?> 
                        </div>
                    </div>
                </div>
                
                <!-- My rated recipes [Max] -->
                <?php if($_SESSION['username'] == $row['username']): ?>
                <div class="tab-pane fade" id="rated-recipes" role="tabpanel" aria-labelledby="rated-tab">
                    <div class="row mt-2 p-3">
                        <div class="col-12">
                            <h3><?php echo ucfirst($row['username']);?>'s Rated Recipes</h3>
                        </div>
                        <div class="col-12">
                            <?php 
                            if($top_rated_amount > 0): ?>
                                <div class="row px-3 mt-3">
                                    <div class="col"><b>Image</b></div>
                                    <div class="col"><b>Drink Name</b></div>
                                    <div class="col"><b>Description</b></div>
                                    <div class="col"><b>Drink Rating</b></div>
                                </div>
                                <?php while($drinkrow = $rated_result->fetch_assoc()): ?> 

                                    <div class="row">
                                        <div class="col-12">
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
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                            <p><?php echo $row['username']?> Has not rated any drinks to show :(</p>
                            <?php endif;?> 
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</body>
</html>