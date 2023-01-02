<?php
require_once('../../db/dbhelper.php');
require_once "controllerUserData.php";

$id = '';
if (isset($_GET['id'])) {
  $id      = $_GET['id'];
  $sql     = 'select * from product where id = ' . $id;
  $product = executeSingleResult($sql);
  $str = $product['id'];
} else if (isset($_SESSION['comment'])) {
  $str = $_SESSION['comment'];
  $id      = $_SESSION['comment'];
  $sql     = 'select * from product where id = ' . $id;
  $product = executeSingleResult($sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <link rel="stylesheet" href="style2.css" />
  <link rel="stylesheet" href="stylec.css" />
  <title>Detail</title>
</head>

<body style="background-color: RGB(238, 238, 238)">
  <?php require('./navbar.php') ?>

  <div class="container mt-5">

  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="<?= $product['thumbnail'] ?> " alt="Card image cap">
        </div>

      </div>

      <div class="col-md-6">
        <div class="row">
          <h2><?= $product['title'] ?></h2>
        </div>
        <div class="row">
        </div>
        <div class="row">
          <h3 class="text-warning">
            <i class="fa fa-star" style="color:darkorange"></i>
            <i class="fa fa-star" style="color:darkorange"></i>
            <i class="fa fa-star" style="color:darkorange"></i>
            <i class="fa fa-star" style="color:darkorange"></i>
            <i class="fa fa-star" style="color:darkorange"></i>
          </h3>


        </div>
        <h4>
          <?php
          $sql = "select * from category where id= " . $product['id_category'];
          $product1 = executeSingleResult($sql);

          ?>

          <a style="text-decoration: none;" href=" information.php?id=<?php echo $product1['id'] ?>"><?php echo $product1['name'] ?></a>

        </h4>
        <div class="row">
          <p>
            <i class="text-success fa fa-check-square-o" aria-hidden="true"></i>
            <?= $product['content'] ?>
          </p>

        </div>
        <div class="row mt-4">
        </div>
        <div class="row mt-4">
        </div>
        <div class="row mt-4">
        </div>
        <div class="row mt-4">
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row mt-5">
        <h2>Similar Application</h2>
      </div>


      <?php
      $currentId = $id;
      $sql         = "SELECT * FROM product WHERE id != $currentId order by rand() DESC limit 1  ";
      $categoryList = executeResult($sql);
      foreach ($categoryList as $item) {
      ?>
        <a href="detail.php?id=<?php echo $item['id'] ?>" style="text-decoration: none; color:black ">
          <div class="row mt-5">
            <div class="col-md-3 ">
              <div class="card ">
                <img class="card-img-top img-fluid" src="<?php echo $item['thumbnail'] ?>">
                <div class="card-title">
                  <br>
                  <h4><?php echo $item['title'] ?></h4>
                </div>
                <div class="card-text mb-3 ">
                  <i class="fa fa-star" style="color:darkorange"></i>
                  <i class="fa fa-star" style="color:darkorange"></i>
                  <i class="fa fa-star" style="color:darkorange"></i>
                  <i class="fa fa-star" style="color:darkorange"></i>
                  <i class="fa fa-star" style="color:darkorange"></i>

                </div>
              </div>
            </div>
          </div>
        </a>
      <?php
      }
      ?>



      <div class="container mt-5 mb-5">
        <div class="row">
          <h2>Comments</h2>
        </div>

        <?php

        $cmt = "SELECT * FROM comment ";
        $res1 = mysqli_query($con, $cmt);
        while ($res = mysqli_fetch_assoc($res1)) {
          if ($str == $res['id']) {
        ?>
            <div class="row mb-5">
              <div class="media "> <img class="mr-3 rounded-circle" src="<?php echo $res['thumbnail'] ?>" width="70px" height="70px">
                <div class="media-body">
                  <h5 class="mt-0"><?php echo $res['name'] ?></h5>
                  <?php echo $res['content'] ?>
                </div>
              </div>
            </div>

        <?php
          }
        }
        ?>





        <div class="row mb-5">
          <h2>Post Comments</h2>
        </div>


        <form action="detail.php" method="POST">

          <div class="form-group">
            <input type="text" name="id" value="<?php echo $str ?>" hidden="true">
            <textarea type="text" class="form-control" name="comment" id="comment" placeholder="Write here " rows="3"></textarea>
          </div>

          <button type="submit" name="comment1" class="btn btn-primary">Submit</button>
        </form>
      </div>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>