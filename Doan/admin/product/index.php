<?php
require_once('../../db/dbhelper.php');
require_once('../../common/utility.php');
require_once('../category/controll.php');
if (!isset($_SESSION['admin'])) {
	header('location: ../category/admin.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Management</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link" href="../overview/">Overview</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../product_portfolio/">List Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../category/">Catagory Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" href="#">Product Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../addcard">Generate Card Code</a>
		</li>
	</ul>

	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Product Management</h2>
			</div>
			<div class="panel-body">
				<a href="add.php">
					<button class="btn btn-success" style="margin-bottom: 15px;">Add Product</button>
				</a>
				<a href="../category/logout.php">
					<button class="btn btn-dark" style="margin-bottom: 15px;">Logout</button>
				</a>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="50px">STT</th>
							<th>Image</th>
							<th>Name application</th>
							<th>Price</th>
							<th>Category</th>
							<th>List</th>
							<th>Date update</th>
							<th width="50px"></th>
							<th width="50px"></th>
							<th width="50px"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//Lay danh sach danh muc tu database
						$limit = 4;
						$page  = 1;
						if (isset($_GET['page'])) {
							$page = $_GET['page'];
						}
						if ($page <= 0) {
							$page = 1;
						}
						$firstIndex = ($page - 1) * $limit;

						$sql         = 'select product.id, product.title, product.price, product.thumbnail, product.id_product, product.updated_at, product.status, category.name category_name from product left join category on product.id_category = category.id ' . ' limit ' . $firstIndex . ', ' . $limit;
						$productList = executeResult($sql);

						$sql         = 'select count(id) as total from product where 1 ';
						$countResult = executeSingleResult($sql);
						$number      = 0;
						if ($countResult != null) {
							$count  = $countResult['total'];
							$number = ceil($count / $limit);
						}

						$index = 1;
						foreach ($productList as $item) {
							$_item = $item['id_product'];
							$check_name = "SELECT * FROM product_p WHERE id = '$_item'";
							$res = mysqli_query($con, $check_name);
							$fetch = mysqli_fetch_assoc($res);
						?>
							<tr>
								<td> <?php echo (++$firstIndex) ?></td>
								<td><img src="<?php echo $item['thumbnail'] ?>" style="max-width: 100px"></td>
								<td><?php echo  $item['title'] ?></td>
								<td><?php echo  $item['price'] ?></td>
								<td><?php echo  $item['category_name'] ?></td>
								<td><?php echo  $fetch['name'] ?></td>
								<td><?php echo  $item['updated_at'] ?></td>
								<?php if ($item['status'] == "0") {
								?>
									<td>
										<button class="btn btn-success" onclick="browseProduct(<?php echo $item['id'] ?>)">Confirm</button>
									</td>
								<?php
								} else {
								?>
									<td>
										<button class="btn btn-success">Approved</button>
									</td>
								<?php
								}
								?>
								<td>
									<a href="add.php?id='<?php echo $item['id'] ?>'"><button class="btn btn-warning">Edit</button></a>
								</td>
								<td>
									<button class="btn btn-danger" onclick="deleteProduct(<?php echo $item['id'] ?>)">Delete</button>
								</td>
							</tr>
						<?php

						}
						?>
					</tbody>
				</table>
				<!-- Bai toan phan trang -->
				<?= paginarion($number, $page, '') ?>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function deleteProduct(id) {
			var option = confirm('Are you sure you want to delete this product?')
			if (!option) {
				return;
			}

			console.log(id)
			//ajax - lenh post
			$.post('ajax.php', {
				'id': id,
				'action': 'delete'
			}, function(data) {
				location.reload()
			})
		}

		function browseProduct(id) {
			var option = confirm('Are you sure you want to browse this product?')
			if (!option) {
				return;
			}

			console.log(id)
			//ajax - lenh post
			$.post('ajax.php', {
				'id': id,
				'action': 'update'
			}, function(data) {
				location.reload()
			})
		}
	</script>
</body>

</html>