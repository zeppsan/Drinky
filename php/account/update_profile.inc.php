<?php

    /* 
        Author: 
            Eric Qvarnström - PHP

        Description:
            Script will manage the update requests regarding the profile
        
        Variables in:
            fname           - 
            lname           - 
            age             - 
            presentation    - 

        How to call this script: 
            <form action="php/account/upload_image.inc.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="profilePicture">
                <input type="submit" name="submit-image">
            </form>

    */ 


    // Check if the button was pressed
    if(!isset($_POST['update-profile'])){
        header("Location: ../../updateProfile.php?error=link");
    }

    require_once '../includes/db.inc.php';
    session_start();



    // Update the database with the new information
    $stmt = $conn->prepare("UPDATE users SET fname = ?, lname = ?, age = ?, presentation = ? WHERE username = ?");
    $stmt->bind_param("ssiss", $_POST['fname'], $_POST['lname'], $_POST['age'], $_POST['presentation'], $_SESSION['username']);
    $stmt->execute();
    
    header('Location: ../../profile.php?success');
    die();