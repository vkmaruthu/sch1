<?php
error_reporting(0);
session_start(); 

//echo "db";
	$con = mysqli_connect("localhost","adminqc","qcadmin","ioentdb_sfs");
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}else{

	}

$userSession=$_SESSION['schAdminSession'];
//$role=$_SESSION['cps_role'];
?>
