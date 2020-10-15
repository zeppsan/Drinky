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

    require_once 'php/includes/db.inc.php';
    session_start();

    if(!isset($_SESSION['username']))
        header("Location: login.php");

    // If no user is specified, get the logged in user instead
    $stmt = $conn->prepare("SELECT username, fname, lname, age, presentation, profile_picture FROM users WHERE username=?");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();


    // Checks if user has set an profile-image, else, display the stock one.
    if($row['profile_picture'] != null){  
        $profilepic = $row['profile_picture'];
    }else{ 
        $profilepic = "media/profilepictures/profilestock.jpg";
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
        <a href="php/account/logout.inc.php" class="btn btn-info text-right">Logout</a><br>
        <div class="row">
            <div class="col-6 col-md-3 px-5">
                <img src="<?php echo $profilepic?>" class="img rounded-circle" width="100%;">
                <div class="form-group">
                    <form action="php/account/upload_image.inc.php" method="POST" enctype="multipart/form-data">
                        <input type="file" class="" name="profilePicture">
                        <button type="submit" class="btn btn-success" name="submit-image">apply</button>
                    </form>
                </div>
            </div>
            <div class="col-6">
                <form action="php/account/update_profile.inc.php" method="POST">
                    <h3 class="title"><?php echo ucfirst($row['username'])?></h3>
                    <h4 class="sub-title">
                        First name<input type="text" name="fname" placeholder="first name" value="<?php echo $row['fname']?>">
                        <br>
                        Last name<input type="text" name="lname" placeholder="last name" value="<?php echo $row['lname']?>">
                    </h4>
                    <p class="mt-3 mb-0">Presentation</p>
                    <p class="text mt-2">
                        <textarea name="presentation" cols="30" rows="5"><?php echo $row['presentation'] ?></textarea>
                    </p>
                    <button type="submit" class="btn btn-gray">Update Profile</button>
                </form>
            </div>
            <div class="col-12 col-md-3 text-center">
                <h1 class="text-info">Score 4.3 / 5</h1>
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