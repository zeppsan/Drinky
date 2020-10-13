<?php
    /* 
        Author: 
            Eric Qvarnström

        Description:
            Script to log out user
    */
    session_destroy();

    header('Location: ../../index.php');

?>