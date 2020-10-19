<?php

    /* 
        Author: 
            Eric Qvarnström - PHP

        Description:
            Script will manage the update requests regarding the profile
        
        Variables in:
            fname           - First Name
            lname           - Last Name
            age             - Age
            presentation    - User Presentation

    */ 

    require_once '../includes/db.inc.php';

    /** Updates the database with the new user information.
     * 
     * @param dataArray Array with data from the $_POST
     * @return redirect Redirects user back to profile with success or fail message
     */
    function updateUserData($dataArray){
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET fname = ?, lname = ?, age = ?, presentation = ? WHERE username = ?");
        $stmt->bind_param("ssiss", $dataArray['fname'], $dataArray['lname'], $dataArray['age'], $dataArray['presentation'], $_SESSION['username']);
        
        if($stmt->execute())
            header('Location: ../../profile.php?updateSuccess');
        else
            header('Location: ../../profile.php?updateFailed');
    }


    // Check if the button was pressed
    if(!isset($_POST['update-profile'])){
        header("Location: ../../updateProfile.php?error=link");
    }

    // Starts session to get access to the username
    session_start();

    updateUserData($_POST);