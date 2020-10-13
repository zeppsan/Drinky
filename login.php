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
                    <form action="php/account/login.inc.php" method="POST">
                        <div class="row">
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
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
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