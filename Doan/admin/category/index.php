<?php
require_once('../../db/dbhelper.php');
require_once('../../common/utility.php');
require_once('controll.php');
if (!isset($_SESSION['admin'])) {
	header('location: admin.php');
}
if (isset($_SESSION['cate'])) {
	unset($_SESSION['cate']);
?>
	<script type="text/javascript">
		alert("There are apps that exist in this Category, you can't delete them!!")
	</script>
<?php
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Quản Lý Thể Loại</title>
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
			<a class="nav-link active" href="#">Category Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../product/">Product Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../addcard">Generate Card Code</a>
		</li>
	</ul>

	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Category Management</h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<a href="add.php">
							<button class="btn btn-success" style="margin-bottom: 15px;">Add categories</button>
						</a>
						<a href="logout.php">
							<button class="btn btn-dark" style="margin-bottom: 15px;">Logout</button>
						</a>
					</div>
				</div>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="50px">STT</th>
							<th>Name categories</th>
							<th width="50px"></th>
							<th width="50px"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//Lay danh sach danh muc tu database
						$limit = 3;
						$page  = 1;
						if (isset($_GET['page'])) {
							$page = $_GET['page'];
						}
						if ($page <= 0) {
							$page = 1;
						}
						$firstIndex = ($page - 1) * $limit;

						$s = '';
						if (isset($_GET['s'])) {
							$s = $_GET['s'];
						}

						//trang can lay san pham, so phan tu tren 1 trang: $limit
						$additional = '';

						if (!empty($s)) {
							$additional = ' and name like "%' . $s . '%" ';
						}
						$sql = 'select * from category where 1 ' . $additional . ' limit ' . $firstIndex . ', ' . $limit;

						$categoryList = executeResult($sql);

						$sql         = 'select count(id) as total from category where 1 ' . $additional;
						$countResult = executeSingleResult($sql);
						$number      = 0;
						if ($countResult != null) {
							$count  = $countResult['total'];
							$number = ceil($count / $limit);
						}

						foreach ($categoryList as $item) {
							echo '<tr>
				<td>' . (++$firstIndex) . '</td>
				<td>' . $item['name'] . '</td>
				<td>
					<a href="add.php?id=' . $item['id'] . '"><button class="btn btn-warning">Edit</button></a>
				</td>
				<td>
					<button class="btn btn-danger" onclick="deleteCategory(' . $item['id'] . ')">Delete</button>
				</td>
			</tr>';
						}
						?>
					</tbody>
				</table>
				<!-- Bai toan phan trang -->
				<?= paginarion($number, $page, '&s=' . $s) ?>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function deleteCategory(id) {
			var option = confirm('Are you sure you want to delete this category?')
			if (!option) {
				return;
			}

			console.log(id)
			//ajax - lenh post
			$.post('controll.php', {
				'id': id,
				'action': 'delete'
			}, function(data) {
				location.reload()
			})
		}
	</script>
</body>

</html>