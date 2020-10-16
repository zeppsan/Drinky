<?php

    /* 
        Author: 
            Eric Qvarnström - PHP
            Frida Westerlund

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


    <?php if ($row['username'] == null): ?>
    
        <div class="row mt-5">
            <div class="col text-center">
                <h2>User could not be found...</h2>
                <p>Bad Luck... The user you were trying to access could not be found...</p>
            </div>
        </div>

    <?php die(); endif;?>

    <div class="container profile">
        <a href="updateProfile.php" id="EditProfile" class="btn btn-gray"><img src="media/pen.png" width="40px" height="40px"></a>
        <br>
        <div class="row">
            <div class="col-6 col-md-3 px-5">
                <img src="<?php echo $profilepic?>" class="img rounded-circle" width="100%;">
            </div>
            <div class="col-6">
                <h3 class="title"><?php echo ucfirst($row['username'])?></h3>
                <h4 class="sub-title"><?php echo ucfirst($row['fname'])." ".ucfirst($row['lname']).", ". $row['age']?></h4>
                <p class="text mt-2"><?php echo $row['presentation']?></p>
            </div>
            <div class="col-12 col-md-3 text-center">
                <h1 class="text-info"><?php echo round($drink_ratings['rating'], 1) ?> / 5</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Top Recipes Box -->
        <div class="row">
            <div class="col-12 col-md-4 bg-info text-light m-3 mt-5">Top Recipes</div>
        </div>

        <!-- Top Recipes -->
        <div class="row">
            <div class="col p-3">
                <p>This is drink one</p>
                <p>This is drink two</p>
                <p>This is drink three</p>
                <p>Ja du fattar :)</p>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>