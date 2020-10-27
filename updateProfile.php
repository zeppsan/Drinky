<?php
    /* 
        Author: 
            Eric Qvarnström - PHP, Layout, HTML - Page in general
            Frida Westerlund - HTML

        Description:
            Script to login a user. Checks credentials agains database
        
        Variables in:
            username        - Username
            password        - Password

        Variables that can be used in this document:
            profilepicture:     <?php echo $profilepic?>
            first name:         <?php echo ucfirst($row['fname']) ?>
            last name:          <?php echo ucfirst($row['lname']) ?>
            age:                <?php echo $row['age'] ?>
            presentation:       <?php echo $row['presentation']?>
            rating:             <?php echo round($drink_ratings['rating'], 1) ?>


    */ 

    session_start();

    if(!isset($_SESSION['username']))
        header("Location: login.php?error=notloggedin");

    require_once 'php/includes/db.inc.php';
    
    /** Gets userdata from the specified user [Eric]
     * 
     * @param string username Users username
     * @return mysqli::result Returns mysqli result
     * 
     */
    function getUserData($username){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    $result = getUserData($_SESSION['username']);
    $row = $result->fetch_assoc();

    // Checks if user has set an profile-image, else, display the stock one.
    if($row['profile_picture'] != null){  
        $profilepic = $row['profile_picture'];
    }else{ 
        $profilepic = "media/profilepictures/profilestock.jpg";
    }  
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <title>Profile</title>
    <?php include_once 'header.php'; ?>
</head>
<body class="bg-bluegradient">

    <div class="container profile">
        <div class="row p-3">

            <!-- Profile picture & edit Profile picture [Eric]--> 
            <div class="col-12 col-md-6 col-lg-3 pl-3">
                <img src="<?php echo $profilepic?>" class="img" width="100%;">
                <form action="php/account/upload_image.inc.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="profilePicture">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                    <button class="btn btn-gray" type="submit" name="submit-image">Upload</button>
                </form>
            </div>

            <!-- update profile information [Eric] --> 
            <div class="col-12 col-md-6 col-lg-9 my-auto">
                <form action="php/account/update_profile.inc.php" method="POST">
                    
                    <h3 class="title"><?php echo ucfirst($row['username'])?></h3>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Presentation</label>
                        <textarea id ="presentation" name="presentation" class="form-control" rows="5" id="editProfilePres"><?php echo $row['presentation'] ?></textarea>
                    </div>
                    <!-- First Name -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">First Name</span>
                        </div>
                        <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo $row['fname']?>" required>
                    </div>

                    <!-- Last Name -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Last Name</span>
                        </div>
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $row['lname']?>" required>
                    </div>

                    <!-- Age  -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Age</span>
                        </div>
                        <input type="number" name="age" class="form-control" placeholder="Age" value="<?php echo $row['age']?>" required>
                    </div>

                    <button type="submit" class="btn btn-gray">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>