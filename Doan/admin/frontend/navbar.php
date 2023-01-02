<?php

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

?>

<nav class="navbar navbar-expand-lg navbar-light bg-info sticky-top ">
    <a class="navbar-brand" href="index.php"><img src="https://www.gstatic.com/android/market_images/web/play_prism_hlock_2x.png" width="40%"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline" method="post" action="search.php">
            <input type="text" name="title" class="form-control" placeholder="Search ">
            <button type="submit" name="save" class="btn btn-success">Search</button>
        </form>

        <nav class="nav-item mr-5 ml-auto ">
            <div class="btn btn-success my-2" style="<?php echo $show ?>"><a href="login-user.php" style="text-decoration: none; color:ghostwhite">Đăng nhập</a></div>
            <div class="dropdown show dropleft" style="<?php echo $hide ?>">
                <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $fetch_info['image'] ?>" class="rounded-circle" alt="Cinque Terre" width="50" height="50">
                </a>
                <?php echo $fetch_info['account_balance'] ?> VND
                <div class="dropdown-menu dropleft " aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="user-profile.php"><i class="fa fa-address-card" style="margin-right: 10px;"></i><?php echo $fetch_info['name'] ?></a>
                    <a class="dropdown-item " href="account.php"><i class="fa fa-credit-card" style="margin-right: 10px;"></i>Recharge</a>
                    <a class="dropdown-item" href="history.php"><i class="fa fa-history" style="margin-right: 10px;"></i>Transaction history</a>
                    <hr>
                    <a class="dropdown-item" href="logout-user.php"><i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i>Logout</a>
                </div>
            </div>
        </nav>

    </div>

</nav>