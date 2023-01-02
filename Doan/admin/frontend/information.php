<?php
require_once('../../db/dbhelper.php');
$id = '';
if (isset($_GET['id'])) {
    // $id      = $_GET['id'];
    // $sql     = 'select * from product where id_category = ' . $id;
    // $product = executeSingleResult($sql);
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>Category</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
                <div class="col-md-2 col-sm-12 mt-5">
                    <?php
                    $sql          = 'select * from product_p';
                    $categoryList = executeResult($sql);
                    foreach ($categoryList as $item) {
                    ?>
                        <a class=" list-group-item list-group-item-action text-monospace font-weight-bold" href=" in_category.php?id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?>
                        </a>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-lg-10 col-sm-12 mt-5">

                    <div class="row">
                        <?php
                        $id = $_GET['id'];
                        $sql         = "SELECT * FROM product where id_category= '$id'";
                        $productList = executeResult($sql);


                        foreach ($productList as $item) {
                        ?>
                            <div class="col-md-2 col-sm-5 mr-4 ml-3 ">
                                <a href="detail.php?id='<?php echo $item['id'] ?>'">
                                    <div class="card-flyer">
                                        <div class="text-box">
                                            <div class="image-box">
                                                <img src=" <?php echo $item['thumbnail'] ?>" alt="" />
                                            </div>
                                            <div class="text-container">
                                                <h6><?php echo $item['title'] ?></h6>
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



</body>

</html>