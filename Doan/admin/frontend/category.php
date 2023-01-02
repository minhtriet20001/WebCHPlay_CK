<?php
require_once('../../db/dbhelper.php');
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
	<style>
		.my-container {
			border: 1px solid green;
		}

		.my-row {
			border: 3px solid red;
			height: 300px;
		}

		.my-col {
			border: 3px dotted blue;
			height: auto;
		}
	</style>
	<title>Category Page - <?= $name ?></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body class="bg-light">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center mt-2"><?= $name ?></h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<?php
					$sql         = 'select product.id, product.title, product.price, product.thumbnail, product.updated_at, category.name category_name from product left join category on product.id_category = category.id where category.id = ' . $id;
					$productList = executeResult($sql);

					foreach ($productList as $item) {
					?>
						<div class="card card-product shadow-lg p-3 mb-5 bg-white rounded ml-5 mt-3">
							<a href="detail.php?id='<?php echo $item['id'] ?>'"><img class="card-img-top" src=" <?php echo $item['thumbnail'] ?>"></a>
							<div class="card-body">
								<a href="detail.php?id='<?php echo $item['id'] ?>' " style=" color:black">
									<p class="d-flex justify-content-center"><?php echo $item['title'] ?></p>
								</a>
								<p style=" font-weight: bold;" class="d-flex justify-content-center">$<?php echo $item['price'] ?> </p>
							</div>
						</div>
					<?php

					}
					?>
				</div>
			</div>
		</div>
	</div>
</body>

</html>