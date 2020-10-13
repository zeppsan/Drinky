<?php
    session_start();

    require_once 'php/includes/db.inc.php';

    // Fetch information about the user from the database
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    // Checks if user has set an profile-image, else, display the stock one.
    if($row['profile_picture'] != null){  
        $profilepic = $row['profile_picture'];
    }else{ 
        $profilepic = "profilestock.jpg";
    }  
?>


<!DOCTYPE html>
<html lang="en">
<body>
    <?php include_once 'header.php'; ?>
    <div class="container">
        
        Endast slängt in lite data som vi kommer att använda. Var god och designa xD 

        <div class="row">

            <!-- Profile Picture -->
            <div class="col-6 col-md-3 mt-3">
                <img src="media/profilepictures/<?php echo $profilepic?>" class="img" width="100%">
            </div>

            <!-- Profile Attributes -->
            <div class="col mt-3">
            <b>User: </b><h3 class="d-inline"><?php echo $_SESSION['username'] ?></h3><br>
            <b>Name: </b><p class="d-inline"><?php echo $row['fname']." ".$row['lname']?></p><br>
            <b>Age: </b><p class="d-inline"><?php echo $row['age']?></p>
            </div>

            <!-- Profile Presentation -->
            <div class="col-6 mt-3">
                <b>Presentation:</b>
                <p><?php echo $row['presentation']?></p>
            </div>
        </div>

        <!-- Top Recipes Box -->
        <div class="row">
            <div class="col-12 col-md-4 bg-info text-light m-3 mt-5 mx-auto">Top Recipes</div>
        </div>

        <!-- Top Recipes -->
        <div class="row">
            <div class="col text-center p-3">
                <p>This is drink one</p>
                <p>This is drink two</p>
                <p>This is drink three</p>
                <p>Ja du fattar :)</p>
            </div>
        </div>
    </div>


    <script src="js/bootstrap.min.js"></script>
</body>
</html>