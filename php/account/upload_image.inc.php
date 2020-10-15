<?php

    /* 
        Author: 
            Eric Qvarnström - PHP

        Description:
            Script to allow users to upload a profile picture.
            This includes saving the image to the server and uploading the path
            to the database.
        
        Variables in:
            image           - File to be uploaded

    */ 

    // Check so that the image-upload button was pressed.
    if(!isset($_POST['submit-image'])){
        header('Location: ../../profile.php?error=imageupload');
    }

    require_once '../includes/db.inc.php';
    
    session_start();
    if(!isset($_SESSION['username']))
        header("../../profile.php?error=session");


    // Initiate variables that will be used during this process.
    $targetDir = "../../media/profilepictures/";
    $profilepic = $targetDir . basename($_FILES['profilePicture']['name']);
    $imageType = strtolower(pathinfo($profilepic, PATHINFO_EXTENSION));

    // The image name will be set to the current timestamp so that no collisions
    // will be made in another user uploads a file with the same name.
    $imagename = time() .".". $imageType;
    $dbPathToImage = "media/profilepictures/".$imagename;

    // Check if the uploaded file is actually an image: 
    if($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jpeg' && $imageType != 'gif' && $imageType != 'svg'){
        // this is not an image
        header("Location: ../../profile.php?error=imageinvalidtype");
    }

    // Put the uploaded image in the correct folder and set the name of the image

    if(move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetDir . $imagename)){
        // Image was successfully uploaded to the server. Let's update the profilepic of the user.
        $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE username = ?");
        $stmt->bind_param('ss', $dbPathToImage, $_SESSION['username']);
        $stmt->execute();
        // Image is now successfully uploaded. 
        header("Location: ../../profile.php?status=imageUploaded");
    } else {
        header("Location: ../../profile.php?error=notuploaded");
    }

?>