<?php

    /* 
        Author: 
            Eric Qvarnström - PHP

        Description:
            Script to login a user. Makes username & password checks against the database records. 
            If user is not authorised, return back to login screen.
            Each functions has a full description.
        
        Variables in:
            username        - Username
            password        - Password

    */ 
    
    include_once '../includes/db.inc.php';
    

    /** Selects the row from the database where the username is = $username. 
     * 
     * @param username - Username of the user
     * @return result - Returns mysqli result
    */
    function getUserResult($username){
        global $conn;
        $stmt = $conn->prepare("SELECT id, username, pwd FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result();
    }


    /** Checks the mysqli result if any rows were returned 
     * 
     * @param result - mysqli result
     * @return bool - returns true if user exist
    */
    function userFound($result){
        if($result->num_rows == 1)
            return true;
        else    
            return false;
    }


    /** Verifies a users password agains the mysqli result
     * 
     * @param $result - mysqli result
     * @param $password - user password
     * @return bool - returns true if user password is correct
    */
    function verifyPassword($result, $password){
        $row = $result->fetch_assoc();

        if(password_verify($password, $row['pwd']))
            return true;
        else
            return false;
    }


    /** Funcion starts a session and assigns session variables for the specified row 
     * 
     * @param $row - mysqli row
     * @return redirect - profile.php
    */
    function loginSuccess($row){
        session_start();
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['id'] = $row['id'];
        header("location: ../../profile.php?");
    }

    /** Login was failed. redirects user the login page with error.
     * 
     * @return redirect - login.php
    */
    function loginFailed(){
        header("Location: ../../login.php?error=wrongcredentials");
    }


    /*## Start of script ##*/ 

    if(!isset($_POST['username']) || !isset($_POST['password'])){
        header('Location: ../../login.php?error=notfilled');
    }

    $result = getUserResult($_POST['username']);

    if(!userFound($result)){
        header('Location: ../../login.php?error=wrongcredentials');
    }

    if(verifyPassword($result, $_POST['password']))
        loginSuccess($row);
    else
        loginFailed();

    
?>