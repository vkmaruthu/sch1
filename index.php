<?php
error_reporting(0);
session_start();  

if(!isset($_SESSION['schAdminSession'])) {
	//echo "test";
	echo "<script> window.location='/oee/logout.php';</script>";
}else{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=oee'>";
}

?>