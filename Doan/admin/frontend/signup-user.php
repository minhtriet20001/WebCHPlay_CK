<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style1.css">
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

</head>

<body>
    <div class="container-login100">
        <div class="row">
            <div class="wrap-login100 p-l-50 p-r-50 p-t-77  form ">
                <form action="signup-user.php" method="POST" autocomplete="" enctype="multipart/form-data">

                    <span class="login100-form-title p-b-55">
                        Signup Form
                        <p>It's quick and easy.</p>
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
                    <div class="form-group wrap-input100 validate-input m-b-16">
                        <input class="form-control" type="text" name="name" placeholder="Full Name" required value="<?php echo $name ?>">
                    </div>
                    <div class="form-group wrap-input100 validate-input m-b-16">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group wrap-input100 validate-input m-b-16">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group wrap-input100 validate-input m-b-16">
                        <input class="form-control" type="password" name="cpassword" placeholder="Confirm password" required>
                    </div>
                    <div class="birthday wrap-input100 validate-input m-b-16">
                        <div>
                            <label>Birthday</label>
                        </div>
                        <div>
                            <select name="month" class="select">
                                <option value='month'>Month</option>
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
                                <option value='day'>Day</option>
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
                                <option value='year'>Year</option>
                                <?php
                                $years = range(2010, 1900);
                                foreach ($years as $yr) {
                                    echo '<option value=' . $yr . '>' . $yr . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex">
                        <div class="radio-inline" style="margin-right:15px">
                            <label><input type="radio" name="optradio" value="Fmale"> Female</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="optradio" value="Male"> Male</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-control wrap-input100 validate-input m-b-16 " type="text" name="Address" placeholder="Address, You can add here" required>
                    </div>
                    <div style="display: flex">
                        <div class="custom-file mb-3 wrap-input100 validate-input m-b-16">
                            <input type="file" class="custom-file-input" id="file1" name="fileup">
                            <label class="custom-file-label" for="customFile">Choose an image Avatar</label>
                        </div>
                        <script>
                            $(".custom-file-input").on("change", function() {
                                var fileName = $(this).val().split("\\").pop();
                                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                            });
                        </script>
                    </div>
                    <div class="form-group">
                        <input class="login100-form-btn" type="submit" name="signup" value="Signup">
                    </div>
                    <div class="link login-link text-center wrap-input100 validate-input m-b-16">Already a member? <a href="login-user.php">Login here</a></div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>