<?php
    /* 
        Author: 
            Eric Qvarnström - PHP

        Description:
            Destorys the session for the user (logs out).
    */
    session_destroy();

    header('Location: ../../index.php');

?>