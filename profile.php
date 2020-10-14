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
        $numRows = 
        $row = $stmt->get_result()->fetch_assoc();
    } else {
        // If no user is specified, get the logged in user instead
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
    }

    // Checks if user has set an profile-image, else, display the stock one.
    if($row['profile_picture'] != null){  
        $profilepic = $row['profile_picture'];
    }else{ 
        $profilepic = "profilestock.jpg";
    }  
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <title>Profile</title>
    <?php include_once 'header.php'; ?>
</head>
<body>
    <div class="container">

    <a href="php/account/logout.inc.php" class="btn btn-info">Logout</a><br>
    Endast slängt in lite data som vi kommer att använda. Var god och designa xD 

        <!-- If the row'username' is not set, then the searched user is not found.
             So let's print that out and end the script afterward. -->
        <?php if ($row['username'] == null): ?>
       
            <div class="row mt-5">
                <div class="col text-center">
                    <h2>User could not be found...</h2>
                    <p>Bad Luck... The user you were trying to access could not be found...</p>
                </div>
            </div>

        <?php die(); endif;?>


        <div class="row">

            <!-- Profile Picture -->
            <div class="col-6 col-md-3 mt-3">
                <img src="media/profilepictures/<?php echo $profilepic?>" class="img" width="100%">
            </div>

            <!-- Profile Attributes -->
            <div class="col mt-3">
            <b>User: </b><h3 class="d-inline"><?php echo $row['username'] ?></h3><br>
            <b>Name: </b><p class="d-inline"><?php echo $row['fname']." ".$row['lname']?></p><br>
            <b>Age: </b><p class="d-inline"><?php echo $row['age']?></p>
            </div>

            <!-- Profile Presentation -->
            <div class="col-6 mt-3">
                <b>Presentation:</b>
                <p><?php echo $row['presentation']?></p>
            </div>
        </div>

        <!-- Top Recipes Box -->
        <div class="row">
            <div class="col-12 col-md-4 bg-info text-light m-3 mt-5 mx-auto">Top Recipes</div>
        </div>

        <!-- Top Recipes -->
        <div class="row">
            <div class="col text-center p-3">
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