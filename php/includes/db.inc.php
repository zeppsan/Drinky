<?php

  $conn = new mysqli('194.132.68.208','drunky','vodka','Drinky', 3306);

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
