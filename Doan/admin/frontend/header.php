<div class="container-fluid ">
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href=""><img src="https://www.gstatic.com/android/market_images/web/play_prism_hlock_2x.png" width="40%"></a>
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="text" placeholder="Search" name="search">
                    <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
                </form>
            </div>
        </nav>
        <nav class="nav-item">
            <div class="btn btn-outline-success my-2 my-sm-0" style="<?php echo $show ?>"><a href="login-user.php">Đăng nhập</a></div>
            <div class="dropdown show" style="<?php echo $hide ?>">
                <a class="btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $fetch_info['image'] ?>" class="rounded-circle" alt="Cinque Terre" width="50" height="50">
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="user-profile.php"><?php echo $fetch_info['name'] ?></a>
                    <a class="dropdown-item" href="account.php">Recharge</a>
                    <a class="dropdown-item" href="history.php">Transaction history</a>
                    <hr>
                    <a class="dropdown-item" href="logout-user.php">Logout</a>
                </div>
            </div>
        </nav>