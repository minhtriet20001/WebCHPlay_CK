<?php 
$server = "localhost";
$username = "root";
$password = "";
$database = "project";
 
// Create connection and Check connection
$con = mysqli_connect($server, $username, $password) or die("Error in connection!");
mysqli_select_db($con, $database ) or die("Could not select database");
