<?php
require_once('../../db/dbhelper.php');
require_once('controll.php');
if (!isset($_SESSION['admin'])) {
	header('location: admin.php');
}
$id = $name = '';
if (!empty($_POST)) {
	if (isset($_POST['name'])) {
		$name = $_POST['name'];
		$name = str_replace('"', '\\"', $name);
	}
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$check_name = "SELECT * FROM category WHERE name = '$name'";
	$res = mysqli_query($con, $check_name);
	if (mysqli_num_rows($res) == 0) {
		if (!empty($name)) {
			if (1 === preg_match('~[0-9]~', $name)) {
				$errors['id'] = 'Please enter the correct category structure : Is a letter';
			} else {
				$created_at = $updated_at = date('Y-m-d H:s:i');
				//Luu vao database
				if ($id == '') {
					$sql = 'insert into category(name, created_at, updated_at) values ("' . $name . '", "' . $created_at . '", "' . $updated_at . '")';
				} else {
					$sql = 'update category set name = "' . $name . '", updated_at = "' . $updated_at . '" where id = ' . $id;
				}

				execute($sql);

				header('Location: index.php');
				die();
			}
		}
	} else {
		$errors['id'] = 'Category name already exists, please enter another';
	}
}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sql = 'select * from category where id = ' . $id;
	$category = executeSingleResult($sql);
	if ($category != null) {
		$name = $category['name'];
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Edit</title>
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
			<a class="nav-link active" href="index.php">Category Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../product/">Product Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../addcard">Generate Card Code</a>
		</li>
	</ul>
	<?php
	if (count($errors) > 0) {
	?>
		<div class="alert alert-danger text-center">
			<?php
			foreach ($errors as $showerror) {
				echo $showerror;
			}
			?>
		</div>
	<?php
	}
	?>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Add catagories</h2>
			</div>
			<div class="panel-body">
				<form method="post">
					<div class="form-group">
						<label for="name">Name catagories:</label>
						<input type="text" name="id" value="<?= $id ?>" hidden="true">
						<input required="true" type="text" class="form-control" id="name" name="name" value="<?= $name ?>">
					</div>
					<button class="btn btn-success">Save</button>
				</form>
			</div>
		</div>
	</div>
</body>

</html>