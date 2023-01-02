<?php
require_once ('../../db/dbhelper.php');

if (!empty($_POST)) {
	if (isset($_POST['action'])) {
		$action = $_POST['action'];

		switch ($action) {
			case 'delete':
				if (isset($_POST['id'])) {
					$id = $_POST['id'];

					$sql = 'delete from product where id = '.$id;
					execute($sql);
				}
			case 'update':
				if (isset($_POST['id'])) {
					$id = $_POST['id'];
					$mess = "1";
					$sql = 'update product set status = "' . $mess . '" where id = ' . $id;
					execute($sql);
				}
				
			break;
		}
	}
}
?>