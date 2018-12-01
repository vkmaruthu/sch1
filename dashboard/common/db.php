<?php
error_reporting(0);
session_start(); 

	//$con = mysqli_connect("localhost","root","","sfs");
	$con = mysqli_connect("localhost","root","","sch_maspl_dev");

	if (mysqli_connect_errno()) 
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}else{
     //echo "db connected";
	}

$userSession=$_SESSION['schAdminSession'];
?>
