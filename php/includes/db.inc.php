<?php

  /* 
      Author: 
          Eric Qvarnström

      Description:
          Connection to the database. The solution is temporary and will be changed
          to a more secure solution once the project is nearly finished. 

          The future solution should hide the login credentials begin the public www 
          folder to prevent the information to leak.

          Database will be running untill the grade is set for our group.

  */ 

  // Connection Information
  $host = "194.132.68.208";
  $username = "drunky";
  $password = "vodka";
  $database = "Drinky";
  $port = 3306;

  // Connection string
  $conn = new mysqli($host, $username, $password, $database, $port);
  $conn->set_charset("utf8");

  // Check connection for errors
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
