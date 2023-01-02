<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";
require "connection.php";
$email = "";
$name = "";
$errors = array();



//commnent
if (isset($_POST['comment1'])) {
    $name = mysqli_real_escape_string($con, $_POST['comment']);
    $id = $_POST['id'];
    $email = $_SESSION['email'];
    $email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);
    $fetch_data = mysqli_fetch_assoc($res);
    $thumbnail = $fetch_data['image'];
    $username = $fetch_data['name'];
    $insert_data = "INSERT INTO comment (id,name,thumbnail,content)
    values('$id','$username','$thumbnail','$name')";
    $data_check = mysqli_query($con, $insert_data);
    $_SESSION['comment'] = $id;
}




//if user signup button
if (isset($_POST['signup'])) {
    $month = mysqli_real_escape_string($con, $_POST['month']);
    $day = mysqli_real_escape_string($con, $_POST['day']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    $address = mysqli_real_escape_string($con, $_POST['Address']);
    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    }
    $email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);
    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = "Email that you have entered is already exist!";
    }
    if ($year == 'year' or $day == 'day' or $month == 'month') {
        $errors['day'] = 'Please enter full data date month year';
    }
    if (!isset($_POST['optradio'])) {
        $errors['optradio'] = 'Please choose gender';
    } else {
        $gender = mysqli_real_escape_string($con, $_POST['optradio']);
    }
    if (empty($_FILES['fileup']['name'])) {
        $errors['fileup'] = 'Please select a file to upload.';
    }
    if (!empty($_FILES['fileup']['name'])) {
        $targetDir = "../../image/";
        $fileName = basename($_FILES['fileup']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        if ($_FILES['fileup']['size'] > 2097152) {
            $errors['fileup'] = 'File size should not be larger than 2MB.';
        }
        if (!in_array($fileType, $allowTypes)) {
            $errors['fileup'] = 'Please upload JPG, PNG, JPEG, GIF, PDF formats';
        } else if (!move_uploaded_file($_FILES['fileup']['tmp_name'], $targetFilePath)) {
            $errors['fileup'] = 'Photo upload failed';
        } else {
            move_uploaded_file($_FILES['fileup']['tmp_name'], $targetFilePath);
        }
    }


    if (count($errors) === 0) {
        $birthdate = $month . "-" . $day . "-" . $year;
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";
        $insert_data = "INSERT INTO usertable (name, email, password, code, status, birthday, gender, address, image, account_balance)
                        values('$name', '$email', '$encpass', '$code', '$status', '$birthdate', '$gender', '$address', '$targetFilePath','0')";
        $data_check = mysqli_query($con, $insert_data);
        if ($data_check) {
            $subject = "Email Verification Code";
            $message = "Your verification code is $code";
            if (Send_Mail($email, $subject, $message)) {
                $info = "We've sent a verification code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Failed while inserting data into database!";
        }
    }
}
//if user click verification code submit button
if (isset($_POST['check'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
    $code_res = mysqli_query($con, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = 'verified';
        $update_otp = "UPDATE usertable SET code = $code, status = '$status' WHERE code = $fetch_code";
        $update_res = mysqli_query($con, $update_otp);
        if ($update_res) {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['info'] = 'You have successfully registered';
            header('location: new.php');
            exit();
        } else {
            $errors['otp-error'] = "Failed while updating code!";
        }
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

//if user click login button
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $check_email = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $check_email);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        if (password_verify($password, $fetch_pass)) {
            $_SESSION['email'] = $email;
            $status = $fetch['status'];
            if ($status == 'verified') {
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: index.php');
            } else {
                $info = "It's look like you haven't still verify your email - $email";
                $_SESSION['info'] = $info;
                header('location: user-otp.php');
            }
        } else {
            $errors['email'] = "Incorrect email or password!";
        }
    } else {
        $errors['email'] = "It's look like you're not yet a member! Click on the bottom link to signup.";
    }
}

//if user click continue button in forgot password form
if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $check_email = "SELECT * FROM usertable WHERE email='$email'";
    $run_sql = mysqli_query($con, $check_email);
    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE usertable SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($con, $insert_code);
        if ($run_query) {
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";
            if (Send_Mail($email, $subject, $message)) {
                $info = "We've sent a passwrod reset otp to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
    }
}

//if user click check reset otp button
if (isset($_POST['check-reset-otp'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
    $code_res = mysqli_query($con, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

//if user click change password button
if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    } else {
        $code = 0;
        $email = $_SESSION['email']; //getting this email using session
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE usertable SET code = $code, password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($con, $update_pass);
        if ($run_query) {
            $info = "Your password changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}

// if click save changed button
if (isset($_POST['user'])) {
    $_email = $_SESSION['email'];
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $day = mysqli_real_escape_string($con, $_POST['day']);
    $month = mysqli_real_escape_string($con, $_POST['month']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $address = mysqli_real_escape_string($con, $_POST['Address']);
    $check_email = "SELECT * FROM usertable WHERE email = '$_email'";
    $gender = mysqli_real_escape_string($con, $_POST['optradio']);
    $res = mysqli_query($con, $check_email);
    $birthdate = $month . "-" . $day . "-" . $year;
    $email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res1 = mysqli_query($con, $email_check);
    if (mysqli_num_rows($res1) > 0 and $email != $_email) {
        $errors['update'] = "Email that you have entered is already exist!";
    }
    if (!empty($_FILES['fileup']['name'])) {
        $targetDir = "../../image/";
        $fileName = basename($_FILES['fileup']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        if ($_FILES['fileup']['size'] > 2097152) {
            $errors['fileup'] = 'File size should not be larger than 2MB.';
        }
        if (!in_array($fileType, $allowTypes)) {
            $errors['fileup'] = 'Please upload JPG, PNG, JPEG, GIF, PDF formats';
        } else if (!move_uploaded_file($_FILES['fileup']['tmp_name'], $targetFilePath)) {
            $errors['fileup'] = 'Photo upload failed';
        } else {
            move_uploaded_file($_FILES['fileup']['tmp_name'], $targetFilePath);
        }
    }
    if (count($errors) === 0) {
        if (mysqli_num_rows($res) > 0) {
            $fetch = mysqli_fetch_assoc($res);
            $fetch_email = $fetch['email'];
            if ($fetch_email != $email) {
                $update_email = "UPDATE usertable SET email = '$email' WHERE email = '$fetch_email'";
                mysqli_query($con, $update_email);
                $_SESSION['email'] = $email;
                $fetch_email = $email;
            }
            if ($name != $fetch['name']) {
                $update_name = "UPDATE usertable SET name = '$name' WHERE email = '$fetch_email'";
                mysqli_query($con, $update_name);
            }
            if ($birthdate != $fetch['birthday']) {
                $update_day = "UPDATE usertable SET birthday = '$birthdate' WHERE email = '$fetch_email'";
                mysqli_query($con, $update_day);
            }
            if ($gender != $fetch['gender']) {
                $update_gender = "UPDATE usertable SET gender = '$gender' WHERE email = '$fetch_email'";
                mysqli_query($con, $update_gender);
            }
            if (isset($_POST['Address'])) {
                $update_address = "UPDATE usertable SET address = '$address' WHERE email = '$fetch_email'";
                mysqli_query($con, $update_address);
            }
            if (!empty($_FILES['fileup']['name'])) {
                $update_image = "UPDATE usertable SET image = '$targetFilePath' WHERE email = '$fetch_email'";
                mysqli_query($con, $update_image);
            }
            $_SESSION['update'] = 'Update successful';
            $_SESSION['bool'] = 'true';
            header('Location: user-profile.php');
        } else {
            $errors['update'] = "Update failed.";
        }
    }
}
if (isset($_POST['Change'])) {
    $email = $_SESSION['email'];
    $check_email = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $check_email);
    $old_password = mysqli_real_escape_string($con, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $enter_password = mysqli_real_escape_string($con, $_POST['enter_password']);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_email = $fetch['email'];
        if (password_verify($old_password, $fetch['password'])) {
            if ($new_password == $enter_password) {
                $_SESSION['info'] = "Password has been changed";
                $encpass = password_hash($new_password, PASSWORD_BCRYPT);
                $update_password = "UPDATE usertable SET password = '$encpass' WHERE email = '$fetch_email'";
                mysqli_query($con, $update_password);
                header('location: new.php');
            } else {
                $errors['change'] = 'Password does not match';
            }
        } else {
            $errors['change'] = 'Current password is incorrect';
        }
    }
}
if (isset($_POST['account'])) {
    $email = $_SESSION['email'];
    $check_email = "SELECT * FROM usertable WHERE email = '$email'";
    $res1 = mysqli_query($con, $check_email);
    $code = mysqli_real_escape_string($con, $_POST['cardNumber']);
    $check_code =  "SELECT * FROM account WHERE card_number = '$code'";
    $res = mysqli_query($con, $check_code);
    $date = date_default_timezone_set('Asia/Bangkok');
    $today = date("F j, Y, g:i a");
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch1 = mysqli_fetch_assoc($res1);
        if ($fetch['status'] == "none") {
            $price = $fetch['denominations'];
            $subject = "Notice of balance";
            $message = "Your balance has just been + $price";
            if (Send_Mail($email, $subject, $message)) {
                $convert = intval($price);
                $sum = $convert + intval($fetch1['account_balance']);
                $info = "You have successfully loaded $price, see details at email: $email";
                $_SESSION['info'] = $info;
                $update_balance = "UPDATE account SET status = 'yup' WHERE card_number = '$code'";
                mysqli_query($con, $update_balance);
                $update_email = "UPDATE account SET email = '$email' WHERE card_number = '$code'";
                mysqli_query($con, $update_email);
                $update_password = "UPDATE usertable SET account_balance = '$sum' WHERE email = '$email'";
                mysqli_query($con, $update_password);
                $update_date = "UPDATE account SET day = '$today' WHERE card_number = '$code'";
                mysqli_query($con, $update_date);
                header('location: check.php');
            } else {
                $errors['money'] = 'Email confirmation failed';
            }
        } else {
            $errors['money'] = 'Card code already used';
        }
    } else {
        $errors['money'] = "Incorrect card code";
    }
}
if (isset($_POST['admin'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $check_name = "SELECT * FROM admin WHERE name = '$name'";
    $res = mysqli_query($con, $check_name);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        if ($fetch['password'] == $password) {
            $_SESSION['admin'] = $name;
            header('location: ../admin/category/index.php');
        } else {
            $errors['admin'] = 'Please enter the correct password';
        }
    } else {
        $errors['admin'] = 'Invalid username';
    }
}
//if login now button click
if (isset($_POST['login-now'])) {
    header('Location: login-user.php');
}

function Send_Mail($to, $subject, $body)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'nhock3073@gmail.com';                 // SMTP username
        $mail->Password = 'HUYNHnhan3073';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('nhock3073@gmail.com', 'Admin');
        $mail->addAddress($to, 'User');     // Add a recipient
        /*$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body   = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
