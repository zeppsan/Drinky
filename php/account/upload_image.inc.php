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

    require_once '../includes/db.inc.php';

    $targetDir = "../../media/profilepictures/";
    $dbPathToImage = "media/profilepictures/";

    /** Removes the users previous profile picture (if there is one).*/
    function removeCurrentImage(){
        global $conn;
        $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE username = ?");
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        if($row['profile_picture'] != null){
            unlink('../../'.$row['profile_picture']);
        }
    }

    /** Checks if the entered file is an image or not 
     * @param file The file that should be checked
     * @return bool returns true if file is an image.
    */
    function isImage($file){
        $imageType =  pathinfo($file['name'], PATHINFO_EXTENSION);
        if($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jpeg' && $imageType != 'gif' && $imageType != 'svg')
            return false;
        else
            return true;
    }

    /** Uploads image to the database and sets in to profilepicture for the logged in user
     * 
     * @param file image file
     * @return redirect Redirects the user to the profile with either success or fail message
     * 
     */
    function uploadImage($image){
        global $conn, $dbPathToImage, $targetDir;
        $imageType = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imagename = time() .".". $imageType;
        $imageFullName = $dbPathToImage . $imagename;

        if(move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetDir . $imagename)){
            // Image was successfully uploaded to the server. Let's update the profilepic of the user.
            $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE username = ?");
            $stmt->bind_param('ss', $imageFullName, $_SESSION['username']);
            $stmt->execute();
            // Image successfully uploaded
            header("Location: ../../profile.php?status=imageUploaded");
        } else {
            // Image upload failed
            header("Location: ../../profile.php?error=notuploaded");
        }
    }

    // Check so that the image-upload button was pressed.
    if(!isset($_POST['submit-image'])){
        header('Location: ../../profile.php?error=imageupload');
    }

    session_start();

    // Checks if the user is logged in
    if(!isset($_SESSION['username']))
        header("../../profile.php?error=session");

    // checks so that a profilePicture has been submitted
    if(!isImage($_FILES['profilePicture'])){
        header("Location: ../../profile.php?error=imageinvalidtype");
    }

    removeCurrentImage();

    // Uploads new image
    uploadImage($_FILES['profilePicture']);


?>