<?php require_once "controllerUserData.php"; ?>
<?php
if (isset($_SESSION['email']) and isset($_SESSION['password'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    if ($email != false && $password != false) {
        $sql = "SELECT * FROM usertable WHERE email = '$email'";
        $run_Sql = mysqli_query($con, $sql);
        if ($run_Sql) {
            $fetch_info = mysqli_fetch_assoc($run_Sql);
            $status = $fetch_info['status'];
            $code = $fetch_info['code'];
            if ($status == "verified") {
                if ($code != 0) {
                    header('Location: reset-code.php');
                }
            } else {
                header('Location: user-otp.php');
            }
        }
    }
} else {
    header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>

<body>
    <div class="container-login100">
        <div class="row">
            <div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
                <form action="user-profile.php" method="POST" autocomplete="" enctype="multipart/form-data">

                    <span class="login100-form-title p-b-55">
                        <?php echo $fetch_info['name'] ?>

                    </span>

                    <?php
                    if (count($errors) == 1) {
                    ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach ($errors as $showerror) {
                                echo $showerror;
                            }
                            ?>
                        </div>
                    <?php
                    } else if (count($errors) > 1) {
                    ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach ($errors as $showerror) {
                            ?>
                                <li><?php echo $showerror; ?></li>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['update']) and $_SESSION['bool'] == "true") {
                    ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $_SESSION['update']; ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="d-flex justify-content-center mb-3">
                        <img src="<?php echo $fetch_info['image'] ?>" alt="Avatar" style="border-radius: 100%" width="130" height="130">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Full Name" required value="<?php echo $fetch_info['name'] ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo $fetch_info['email'] ?>">
                    </div>
                    <?php
                    $arr = explode("-", $fetch_info['birthday']);
                    ?>
                    <div class="birthday">
                        <div>
                            <label>Birthday</label>
                        </div>
                        <div>
                            <select name="month" class="select">
                                <option value='<?php echo $arr[0] ?>'><?php echo $arr[0] ?></option>
                                <?php
                                $m = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                                foreach ($m as $month) {
                                    echo '<option value=' . $month . '>' . $month . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <select name="day" class="select">
                                <option value='<?php echo $arr[1] ?>'><?php echo $arr[1] ?></option>
                                <?php
                                $d = range(31, 1);
                                foreach ($d as $day) {
                                    echo '<option value=' . $day . '>' . $day . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <select name="year" class="select">
                                <option value='<?php echo $arr[2] ?>'><?php echo $arr[2] ?></option>
                                <?php
                                $years = range(2010, 1900);
                                foreach ($years as $yr) {
                                    echo '<option value=' . $yr . '>' . $yr . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                    if ($fetch_info['gender'] == "Male") {
                        $check = 'checked';
                        $_check = '';
                    } else {
                        $check = '';
                        $_check = 'checked';
                    }
                    ?>
                    <div style="display: flex">
                        <div class="radio-inline" style="margin-right:15px">
                            <label><input type="radio" name="optradio" value="Fmale" <?php echo $_check ?>> Female</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="optradio" value="Male" <?php echo $check ?>> Male</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="Address" placeholder="Address, You can add here or none" value="<?php echo $fetch_info['address'] ?>" required>
                    </div>
                    <div style="display: flex">
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="file1" name="fileup">
                            <label class="custom-file-label" for="customFile">Change your avatar</label>
                        </div>
                        <script>
                            $(".custom-file-input").on("change", function() {
                                var fileName = $(this).val().split("\\").pop();
                                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                            });
                        </script>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="user" value="Save Changed">
                    </div>
                    <div class="form-group text-center"><a href="index.php" class="form-control button">Back Here</a></div>
                    <div class="link login-link text-center">You want change password? <a href="change_password.php">Click here</a></div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>