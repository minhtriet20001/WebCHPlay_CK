<?php require_once "controll.php"; ?>
<?php
    if(isset($_SESSION['admin'])){
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../frontend/style1.css">
</head>
<body>
    <?php
        if(count($errors) > 0){
            ?>
            <div class="alert alert-danger text-center">
                <?php
                    foreach($errors as $showerror){
                        echo $showerror;
                    }
                ?>
            </div>
        <?php
        }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form action="admin.php" method="POST" autocomplete="">
                    <h2 class="text-center">Admin</h2>
                    <p class="text-center">Login with your name and password.</p>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Admin User" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="link forget-pass text-left"><a href="forgot-password.php">Forgot password?</a></div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="admin" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>