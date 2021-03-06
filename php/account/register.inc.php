<?php

    /* 
        Author: 
            Eric Qvarnström

        Description:
            Script to register a new user, check if the information is valid
            and then send it to the Database.
        
        Variables in:
            email           - Prefered Email
            username        - Prefered Username
            password        - Password
            password-repeat - Password Match
            fname           - First name
            lname           - Surname   
            age             - Users age

    */ 
    
    include_once '../includes/db.inc.php';

    /** Checks if email is already taken
     * 
     * @param $email - user email
     * @return bool - returns true if email is taken
    */
    function EmailTaken($email){
        global $conn;
        $stmt = $conn->prepare('SELECT count(email) FROM users WHERE email=?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->fetch_assoc();
        if($num['count(email)'] == 1){
            return true;
        } else {
            return false;
        }
    }

    /** Checks if username is already taken
     * 
     * @param $username - user username
     * @return bool - returns true if username is taken
    */
    function UsernameTaken($username){
        global $conn;
        $stmt = $conn->prepare('SELECT count(username) FROM users WHERE username=?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->fetch_assoc();
        if($num['count(username)'] == 1){
            return true;
        } else {
            return false;
        }
    }

    /** Checks if all the field is set, else, return to register.php
     * 
     * @param _POST - the post varaibles from register.php
     * @return redirect user to register.php if all fields are not fileld
    */
    function fieldsFilled($postArray){
        if(!isset($postArray['email']) || 
        !isset($postArray['username']) || 
        !isset($postArray['password']) || 
        !isset($postArray['password-repeat']) || 
        !isset($postArray['fname']) || 
        !isset($postArray['lname']) || 
        !isset($postArray['age'])){
            header('Location: ../../register.php?error=notfilled');
        }
    }

    /** Completes the registration
     * 
     * @param _POST - the post varaibles from register.php
     * @return redirect user to login.php if the registration can be completed else, redirect to register.phpp for error handlig
    */
    function compelteRegistration($postData){
        global $conn;
        $hashedPassword = password_hash($postData['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (email, username, fname, lname, age, pwd) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssis", $postData['email'],$postData['username'], $postData['fname'], $postData['lname'], $postData['age'], $hashedPassword);
        if($stmt->execute()){
            header("Location: ../../index.php?account-created");
        } else {
            header("Location: ../../register.php?error=dbfail");
        }
    }

    // Checks if the submit button was not pressed. If not, do not continue with script
    if(!isset($_POST['submit']))
        header('Location: ../../register.php?error=linkerror');
    
    
    fieldsFilled($_POST);
    

    // Checks if the email-address is valid or not
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // Email is not vaild
        header("Location: ../../register.php?error=unvalidemail");
    }      

    // Check if email is taken or not
    if(EmailTaken($_POST['email'])){
        header('Location: ../../register.php?error=emailtaken');
    }

    // Checks if the username is taken or not 
    if(UsernameTaken($_POST['username'])){
        header('Location: ../../register.php?error=usernametaken');
    }

    // checks if the 2 entered passwords are matching
    if($_POST['password'] !== $_POST['password-repeat']){
        header('Location: ../../register.php?error=pwdmissmatch');
    }

    // If age is lower than 18, return error.
    if($_POST['age'] < 18){
        header('Location: ../../register.php?error=agelimit');
    }

    compelteRegistration($_POST);