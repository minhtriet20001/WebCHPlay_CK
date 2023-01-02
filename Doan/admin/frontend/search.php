<?php
require_once('../../db/dbhelper.php');
require_once "controllerUserData.php";
if (isset($_SESSION['email']) and isset($_SESSION['password'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    if ($email != false && $password != false) {
        $sql = "SELECT * FROM usertable WHERE email = '$email'";
        $run_Sql = mysqli_query($con, $sql);
        $_SESSION['bool'] = 'false';
        if ($run_Sql) {
            $fetch_info = mysqli_fetch_assoc($run_Sql);
            $status = $fetch_info['status'];
            $code = $fetch_info['code'];
            if ($status == "verified") {
                $hide = "";
                $show = "display: none";
                if ($code != 0) {
                    header('Location: reset-code.php');
                }
            } else {
                header('Location: user-otp.php');
            }
        }
    }
} else {
    $show = "";
    $hide = "display: none";
}
$id = '';
if (isset($_GET['id'])) {
    $id       = $_GET['id'];
    $sql      = 'select * from category where id = ' . $id;
    $category = executeSingleResult($sql);
    if ($category != null) {
        $name = $category['name'];
    }
}

if (isset($_POST['title'])) {
    $_SESSION['info'] = "";
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $check_code = "SELECT * FROM product WHERE title like '%$title%'";
    $code_res = mysqli_query($con, $check_code);
} else {
    header('location: index.php');
}

?>



<!DOCTYPE html>
<html>

<head>

    <title>CH PLAY</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylec.css">
</head>

<body style="background-color: RGB(238, 238, 238)">

    <?php require('./navbar.php') ?>


    <div id="cards_landscape_wrap-2">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-2 mt-5">
                    <?php

                    $sql          = 'select * from product_p';
                    $categoryList = executeResult($sql);
                    foreach ($categoryList as $item) {
                    ?>

                        <a class="list-group-item list-group-item-action text-monospace font-weight-bold" href="#'<?php echo $item['id'] ?>'"><?php echo $item['name'] ?></a>
                    <?php
                    }
                    ?>

                </div>
                <div class="col-md-10 mt-5">
                    <div class="row">

                        <?php
                        while ($res = mysqli_fetch_assoc($code_res)) {
                        ?>
                            <div class=" col-md-2 mr-4 ml-3 ">
                                <a href="detail.php?id='<?php echo $res['id'] ?>'">
                                    <div class="card-flyer">
                                        <div class="text-box">
                                            <div class="image-box">
                                                <img src=" <?php echo  $res['thumbnail'] ?>" alt="" />
                                            </div>
                                            <div class="text-container">
                                                <h6><?php echo $res['title'] ?></h6>
                                                <p>
                                                    <i class="fa fa-star" style="color:darkorange"></i>
                                                    <i class="fa fa-star" style="color:darkorange"></i>
                                                    <i class="fa fa-star" style="color:darkorange"></i>
                                                    <i class="fa fa-star" style="color:darkorange"></i>
                                                    <i class="fa fa-star" style="color:darkorange"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>



                    </div>
                </div>
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</body>

</html>