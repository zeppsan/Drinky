<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
</head>
<body>
    <?php include_once 'header.php'; ?>
    <div class="container">
        <div class="row mt-5">
                <div class="col-12 col-md-8 mx-auto">
                    <form action="php/account/register.inc.php" method="POST">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputUsername">Username</label>
                                    <input type="text" class="form-control" id="exampleInputUsername" aria-describedby="usernameHelp" placeholder="Enter username" name="username" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputFirstname">First Name</label>
                                    <input type="text" class="form-control" id="exampleInputFirstname" aria-describedby="firstname" placeholder="Enter First Name" name="fname" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputSurname">Surname</label>
                                    <input type="text" class="form-control" id="exampleInputSurname" aria-describedby="lastname" placeholder="Enter Surname" name="lname" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputAge">Age</label>
                                    <input type="number" class="form-control" id="exampleInputAge" aria-describedby="age" value="18" min="18" max="105" name="age" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Repeat Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password-repeat" required>
                                </div>
                            </div>
                        </div>    
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>