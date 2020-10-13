<?php

    /* 
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


    // Checks if the entered email is taken or not. If the email is taken, return true. Else, return false;
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

    // Checks if the submit button was not pressed. If not, do not continue with script
    if(!isset($_POST['submit']))
        header('Location: ../../register.php?error=linkerror');
    
    // Check if all fields are filled in
    // Safety measure if someone mixes with the JS that are supposed to catch these things.. 
    if(empty($_POST['email']) || 
        empty($_POST['username']) || 
        empty($_POST['password']) || 
        empty($_POST['password-repeat']) || 
        empty($_POST['fname']) || 
        empty($_POST['lname']) || 
        empty($_POST['age'])){
            header('Location: ../../register.php?error=notfilled');
    }

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

    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (email, username, fname, lname, age, pwd) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssis", $_POST['email'],$_POST['username'], $_POST['fname'], $_POST['lname'], $_POST['age'], $hashedPassword);
    if($stmt->execute()){
        header("Location: ../../index.php?account-created");
    } else {
        header("Location: ../../register.php?error=dbfail");
    }

    

