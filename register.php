<!--
        Author: 
            Eric Qvarnström - Full page

        Description:
            Page for user registration
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
</head>
<body id="registerBody">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid" id="register-container">
        <div class="row">
            <div class="col-12 col-md-6 text-center">
                <h2>Drinky Registration</h1>
                <h3>Soon you'll be making drinks like Chuck Norris himself</h3>
            </div>
            <div class="col-12 col-md-6 col-lg-4 registration-form py-5">
                <form action="php/account/register.inc.php" method="POST">
                    <div class="row">
                        <!-- Email -->
                        <div class="col-12">
                            <div class="form-group input-group-sm">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
                            </div>
                        </div>
                        <!-- Username -->
                        <div class="col-6">
                            <div class="form-group input-group-sm">
                                <label for="exampleInputUsername">Username</label>
                                <input type="text" class="form-control" id="exampleInputUsername" aria-describedby="usernameHelp" placeholder="Enter username" name="username" required>
                            </div>
                        </div>
                        <!-- Age -->
                        <div class="col-6">
                            <div class="form-group input-group-sm">
                                <label for="exampleInputAge">Age</label>
                                <input type="number" class="form-control" id="exampleInputAge" aria-describedby="age" value="18" min="18" max="105" name="age" required>
                            </div>
                        </div>
                        <!-- First Name -->
                        <div class="col-6">
                            <div class="form-group input-group-sm">
                                <label for="exampleInputFirstname">First Name</label>
                                <input type="text" class="form-control" id="exampleInputFirstname" aria-describedby="firstname" placeholder="Enter first name" name="fname" required>
                            </div>
                        </div>
                        <!-- Surname -->
                        <div class="col-6">
                            <div class="form-group input-group-sm">
                                <label for="exampleInputSurname">Surname</label>
                                <input type="text" class="form-control" id="exampleInputSurname" aria-describedby="lastname" placeholder="Enter surname" name="lname" required>
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="col-6">
                            <div class="form-group input-group-sm">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                            </div>
                        </div>
                        <!-- Repeat Password -->
                        <div class="col-6">
                            <div class="form-group input-group-sm">
                                <label for="exampleInputPassword2">Repeat Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password-repeat" required>
                            </div>
                        </div>
                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-gray">Register Account</button>
                        </div>
                    </div>
                </form>
                <small>Already have an account? <a href="login.php" class="text-info">Login Here!</a></small>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>