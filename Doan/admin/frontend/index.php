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
?>



<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CH Play</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="stylec.css">
</head>

<body style="background-color: RGB(238, 238, 238)">
	<?php require('./navbar.php') ?>

	<div id="cards_landscape_wrap-2">
		<div class="container-fluid">
			<div class="row ">
				<div class="col-md-2 col-sm-12 mt-5 ">
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
					<?php
					$sql         = "SELECT * FROM category";
					$categoryList = executeResult($sql);
					foreach ($categoryList as $category) {
					?><div class="category mt-5">
							<div class="col-12 d-flex justify-content-start">
								<?php
								$currentCategoryId1 = $category['id'];
								$check_id = "SELECT * FROM product WHERE id_category = '$currentCategoryId1'";
								$res = mysqli_query($con, $check_id);
								if (mysqli_num_rows($res) > 0) {
								?>
									<h2><?php echo $category['name'] ?></h2>
									<a href=" information.php?id=<?php echo $category['id'] ?>" class="btn btn-outline-danger mt-1 ml-3 h-100" role="button">More</a>
								<?php

								}
								?>


							</div>

							<div class="row row">
								<?php
								$currentCategoryId = $category['id'];
								$sql         = "SELECT * FROM product WHERE id_category = '$currentCategoryId' ORDER BY id DESC";
								$productList = executeResult($sql);
								if (sizeof($productList) >= 5) {
									$length = 5;
								} else {
									$length = sizeof($productList);
								}
								for ($num = 0; $num < $length; $num++) {
									if ($productList[$num]['status'] == '1') {
								?>

										<div class="col-md-2 col-sm-5 mr-4 ml-3 my-col">
											<a href="detail.php?id='<?php echo $productList[$num]['id'] ?>'">
												<div class="card-flyer">
													<div class="text-box">
														<div class="image-box">
															<i class="bi bi-cash"></i><img src=" <?php echo $productList[$num]['thumbnail'] ?>" alt="" />
														</div>
														<div class="text-container">
															<h6><?php echo $productList[$num]['title'] ?></h6>
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
								}
								?>
							</div>
						</div> <?php
							}
								?>
				</div>

			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</body>

</html>