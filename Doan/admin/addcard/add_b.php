<?php
require_once('../../db/dbhelper.php');
require_once('../category/controll.php');
if (!isset($_SESSION['admin'])) {
	header('location: ../category/admin.php');
}
$id = $name = '';
if (!empty($_POST)) {
	if (isset($_POST['name'])) {
		$name = $_POST['name'];
		$name = str_replace('"', '\\"', $name);
	}
	if (isset($_POST['value'])) {
		$id = $_POST['value'];
	}
	$permitted_chars = '0123456789';
	$name = mysqli_real_escape_string($con, $_POST['name']);
	if ($id != "0") {
		if (!empty($name)) {
			$status = "none";
			$day = "";
			for ($i = 0; $i < intval($name); $i++) {
				$number = random_int(12, 16);
				$data = generate_string($permitted_chars, $number);
				$email = "";
				$sql = 'insert into account(card_number, denominations, status, day, email ) values ("' . $data . '", "' . $id . '", "' . $status . '", "' . $day . '", "' . $email . '")';
				execute($sql);
			}
			header('Location: index.php');
			die();
		}
	} else {
		$errors['value'] = "Please select card value";
	}
}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sql = 'select * from product_p where id = ' . $id;
	$category = executeSingleResult($sql);
	if ($category != null) {
		$name = $category['name'];
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Thêm/Sửa Danh Mục</title>
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
			<a class="nav-link" href="../category/">Category Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="../product/">Product Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" href="index.php">Generate Card Code</a>
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
				<h2 class="text-center">Create Number Card</h2>
			</div>
			<div class="panel-body">
				<form method="post">
					<div class="form-group">
						<label for="name">Amount</label>
						<input required="true" type="number" class="form-control" id="name" name="name">
					</div>
					<div class="form-group">
						<select name="value" class="form-control">
							<option value="0">Choose value</option>
							<?php
							$m = array("10000", "20000", "50000", "100000", "200000", "500000");
							foreach ($m as $month) {
								echo '<option value=' . $month . '>' . $month . '</option>';
							}
							?>
						</select>
					</div>
					<button class="btn btn-success">Save</button>
				</form>
			</div>
		</div>
	</div>
</body>

</html>