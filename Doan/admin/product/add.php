<?php
require_once('../../db/dbhelper.php');
require_once('../category/controll.php');
if (!isset($_SESSION['admin'])) {
	header('location: ../category/admin.php');
}
$allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');
$id = $price = $title = $thumbnail = $content = $id_category = '';
if (!empty($_POST)) {
	if (isset($_POST['title'])) {
		$title = $_POST['title'];
		$title = str_replace('"', '\\"', $title);
	}
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	if (isset($_POST['price'])) {
		$price = $_POST['price'];
		$price = str_replace('"', '\\"', $price);
	}
	if (!empty($_FILES['thumbnail']['name'])) {
		$targetDir = "../../image/";
		$fileName = basename($_FILES['thumbnail']['name']);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
		if ($_FILES['thumbnail']['size'] > 2097152) {
			$errors['thumbnail'] = 'File size should not be larger than 2MB.';
		}
		if (!in_array($fileType, $allowTypes)) {
			$errors['thumbnail'] = 'Please upload JPG, PNG, JPEG, GIF, PDF formats';
		} else if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFilePath)) {
			$errors['fileup'] = 'Photo upload failed';
		} else {
			move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFilePath);
		}
	} else if (empty($_FILES['thumbnail']['name']) and $id != '') {
		$image = "SELECT * FROM product WHERE id = $id";
		$res = mysqli_query($con, $image);
		$fetch = mysqli_fetch_assoc($res);
		$targetFilePath = $fetch['thumbnail'];
	} else {
		$errors['image'] = "Please choose a photo";
	}
	if (isset($_POST['content'])) {
		$content = $_POST['content'];
		$content = str_replace('"', '\\"', $content);
	}
	if (isset($_POST['id_category'])) {
		if ($_POST['id_category'] == "The Loai")
			$errors['id_category'] = 'Please choose a genre';
		else
			$id_category = $_POST['id_category'];
	}
	if (isset($_POST['id_product'])) {
		if ($_POST['id_product'] == "Danh Muc") {
			$errors['id_product'] = 'Please choose a product_portfolio';
		} else {
			$id_product = $_POST['id_product'];
			$id_product = str_replace('"', '\\"', $id_product);
		}
	}

	if (count($errors) == 0) {
		if (!empty($title)) {
			$created_at = $updated_at = date('Y-m-d H:s:i');
			$status = "0";
			//Luu vao database
			if ($id == '') {
				$sql = 'insert into product(title, thumbnail, price, content, id_category, id_product, created_at, updated_at, status) values ("' . $title . '", "' . $targetFilePath . '", "' . $price . '", "' . $content . '", "' . $id_category . '", "' . $id_product . '", "' . $created_at . '", "' . $updated_at . '", "' . $status . '")';
			} else {
				$sql = 'update product set title = "' . $title . '", updated_at = "' . $updated_at . '", thumbnail = "' . $targetFilePath . '", price = "' . $price . '", content = "' . $content . '", id_category = "' . $id_category . '", id_product = "' . $id_product . '" where id = ' . $id;
			}

			execute($sql);

			header('Location: index.php');
			die();
		}
	}
}

if (isset($_GET['id'])) {
	$id      = $_GET['id'];
	$sql     = 'select * from product where id = ' . $id;
	$product = executeSingleResult($sql);
	if ($product != null) {
		$title       = $product['title'];
		$price       = $product['price'];
		$thumbnail   = $product['thumbnail'];
		$id_category = $product['id_category'];
		$id_product  = $product['id_product'];
		$content     = $product['content'];
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Add product</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<!-- summernote -->
	<!-- include summernote css/js -->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
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
			<a class="nav-link" href="index.php">Product Management</a>
		</li>
		<li class="nav-item">
			<a class="nav-link " href="../addcard">Generate Card Code</a>
		</li>
	</ul>
	<?php
	if (count($errors) == 1) {
	?>
		<div class="alert alert-danger text-center">
			<?php
			foreach ($errors as $showerror) {
				echo $showerror;
			}
			?>
		</div>
	<?php
	} else if (count($errors) > 1) {
	?>
		<div class="alert alert-danger text-center">
			<?php
			foreach ($errors as $showerror) {
			?>
				<li><?php echo $showerror; ?></li>
			<?php
			}
			?>
		</div>
	<?php
	}
	?>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Add Product</h2>
			</div>
			<div class="panel-body">
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="name">Name Product</label>
						<input type="text" name="id" value="<?= $id ?>" hidden="true">
						<input required="true" type="text" class="form-control" id="title" name="title" value="<?= $title ?>">
					</div>
					<div class="form-group">
						<label for="price">Choose List</label>
						<select class="form-control" name="id_product" id="id_product">
							<option value="Danh Muc">--Choose List --</option>
							<?php
							$sql          = 'select * from product_p';
							$categoryList = executeResult($sql);

							foreach ($categoryList as $item) {
								if ($item['id'] == $id_product) {
									echo '<option selected value="' . $item['id'] . '">' . $item['name'] . '</option>';
								} else {
									echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="price">Choose categories</label>
						<select class="form-control" name="id_category" id="id_category">
							<option value="The Loai">-- Choose categories --</option>
							<?php
							$sql          = 'select * from category';
							$categoryList = executeResult($sql);

							foreach ($categoryList as $item) {
								if ($item['id'] == $id_category) {
									echo '<option selected value="' . $item['id'] . '">' . $item['name'] . '</option>';
								} else {
									echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="price">Price</label>
						<input required="true" type="number" class="form-control" id="price" name="price" value="<?= $price ?>">
					</div>
					<div class="form-group">
						<label for="thumbnail">Thumbnail:</label>
						<input type="file" class="form-control" id="thumbnail" name="thumbnail" value="<?= $thumbnail ?>" require>
						<img src="<?= $thumbnail ?>" style="max-width: 200px" id="img_thumbnail">
						<script>
							$(".custom-file-input").on("change", function() {
								var fileName = $(this).val().split("\\").pop();
								$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
							});
						</script>
					</div>
					<div class="form-group">
						<label for="content">Content:</label>
						<textarea class="form-control" rows="5" name="content" id="content"> <?= $content ?></textarea>
					</div>
					<button class="btn btn-success">Save</button>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			//doi website load noi dung => xu ly phan js
			$('#content').summernote({
				height: 350
			});
		})
	</script>
</body>

</html>