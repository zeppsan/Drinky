<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body id="loginBody">
    <?php include_once 'header.php'; ?>

    <div class="container-fluid" id="login-container">
        <div class="row">
            <div class="col-12 col-md-6 text-center">
                <h2>Drinky Login</h1>
                <h3>Welcome back you alcoholic!</h3>
            </div>
            <div class="col-12 col-md-6 col-lg-4 registration-form py-5 loginform-form">
                <form action="php/account/login.inc.php" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputUsername">Username</label>
                                <input type="text" class="form-control" id="exampleInputUsername" aria-describedby="usernameHelp" placeholder="Enter username" name="username" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" name="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>