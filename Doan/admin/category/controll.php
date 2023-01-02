<?php
    session_start();
    require "../frontend/connection.php";
    $errors = array();

    if(isset($_POST['admin'])){
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $check_name = "SELECT * FROM admin WHERE name = '$name'";
        $res = mysqli_query($con, $check_name);
        if(mysqli_num_rows($res) > 0){
            $fetch = mysqli_fetch_assoc($res);
            if($fetch['password'] == $password){
                $_SESSION['admin'] = $name;
                header('location: index.php');
            }
            else{
                $errors['admin'] = 'Please enter the correct password';
            }
        }
        else{
            $errors['admin'] = 'Invalid username';
        }
    }
    if (isset($_POST['action'])) {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $check = "SELECT * FROM product WHERE id_category = $id";
            $_sql = mysqli_query($con,$check);
            if(mysqli_num_rows($_sql) > 0){
                $_SESSION['cate'] = 'true';
            }
            else{
                $sql = "DELETE FROM category WHERE id = $id";
                mysqli_query($con,$sql);
            }
        }
    }
    if (isset($_POST['action1'])) {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $check = "SELECT * FROM product WHERE id_product = $id";
            $_sql = mysqli_query($con,$check);
            if(mysqli_num_rows($_sql) > 0){
                $_SESSION['cate'] = 'true';
            }
            else{
                $sql = "DELETE FROM product_p WHERE id = $id";
                mysqli_query($con,$sql);
            }
        }
    }

    if (isset($_POST['action2'])) {
        $action = $_POST['action2'];
    
        switch ($action) {
            case 'delete':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
    
                    $sql = "DELETE FROM product WHERE id = '.$id";
                    mysqli_query($con,$sql);
                }
            case 'update':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $mess = "1";
                    $sql = "UPDATE product SET status = '$mess' where id = $id";
                    mysqli_query($con,$sql);
                    $_SESSION['status'] = 'true';
                }
            }
    }
?>