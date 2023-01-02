<?php
require_once('../../db/dbhelper.php');
require_once('../category/controll.php');
if (!isset($_SESSION['admin'])) {
  header('location: ../category/admin.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Overview</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>

  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" href="#">Overview</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../product_portfolio/">List Management</a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="#">Category Management</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../product/">Product Management</a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="../addcard">Generate Card Code</a>
    </li>
  </ul>
  <br>
  <br>
  <a href="../category/logout.php">
    <button class="btn btn-dark ml-5 " style="margin-bottom: 15px;">Logout</button>
  </a>
  <br>
  <br>
  <div class="container">
    <h2>Overview</h2>
    <p>This is the total of users, categories, categories: </p>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name list</th>
          <th></th>
          <th>Total</th>
        </tr>
      </thead>
      <?php
      $check = "SELECT * FROM usertable";
      $_sql = mysqli_query($con, $check);
      $num = mysqli_num_rows($_sql);
      $check1 = "SELECT * FROM product_p";
      $_sql1 = mysqli_query($con, $check1);
      $num1 = mysqli_num_rows($_sql1);
      $check2 = "SELECT * FROM category";
      $_sql2 = mysqli_query($con, $check2);
      $num2 = mysqli_num_rows($_sql2);
      ?>
      <tbody>
        <tr>
          <td>User</td>
          <td></td>
          <td><?php echo $num ?></td>
        </tr>
        <tr>
          <td>product_portfolio</td>
          <td></td>
          <td><?php echo $num1 ?></td>
        </tr>
        <tr>
          <td>Category</td>
          <td></td>
          <td><?php echo $num2 ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <br>
  <div class="container">
    <h2>Overview</h2>
    <p>Here is a detailed overview of the number of applications for each category:</p>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name list</th>
          <th></th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $check = "SELECT * FROM product_p";
        $_sql = mysqli_query($con, $check);
        while ($fecth = mysqli_fetch_assoc($_sql)) {
          $id_product = $fecth['id'];
          $select = "SELECT * FROM product where id_product = $id_product";
          $result = mysqli_query($con, $select);
          $num = mysqli_num_rows($result);
        ?>
          <tr>
            <td><?php echo $fecth['name'] ?></td>
            <td></td>
            <td><?php echo $num ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <br>
  <div class="container">
    <h2>Overview</h2>
    <p>Here is the total number of apps for each category:</p>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name list</th>
          <th></th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $check = "SELECT * FROM category";
        $_sql = mysqli_query($con, $check);
        while ($fecth = mysqli_fetch_assoc($_sql)) {
          $id_category = $fecth['id'];
          $select = "SELECT * FROM product where id_category = $id_category";
          $result = mysqli_query($con, $select);
          $num = mysqli_num_rows($result);
        ?>
          <tr>
            <td><?php echo $fecth['name'] ?></td>
            <td></td>
            <td><?php echo $num ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>