<?php

  $conn = new mysqli('zepptech.se.mysql','zepptech_sedrinky','Drinky123','zepptech_sedrinky');

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
