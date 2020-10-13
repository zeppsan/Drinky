<?php

    /* 
        Author: 
            Eric Qvarnström - PHP

        Description:
            Script to login a user. Checks credentials agains database
        
        Variables in:
            username        - Username
            password        - Password

    */ 
    
    function StartSession($row){
        session_start();
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['id'] = $row['id'];
        header("location: ../../index.php?loggedin");
    }

    include_once '../includes/db.inc.php';

    // Checks so that username and password is set
    if(!isset($_POST['username']) || !isset($_POST['password'])){
        header('Location: ../../login.php?error=notfilled');
    }

    // Select id, username and password from database where username is = to the input 
    $stmt = $conn->prepare("SELECT id, username, pwd FROM users WHERE username=?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // check if the query returned any rows
    if($result->num_rows != 1){
        header('Location: ../../login.php?error=wrongcredentials');
    } else {

        // Fetch the query result to an named array
        $row = $result->fetch_assoc();

        // Check if the password matches
        if(password_verify($_POST['password'], $row['pwd'])){
            StartSession($row);
        } else {
            header("Location: ../../login.php?error=wrongcredentials");
        }
    }
?>