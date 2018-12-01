<?php
require_once('../common/db.php');
print_r($_POST);

$id=$_POST['id'];
$sql = "INSERT INTO `check` (`id`, `reason_code`, `time`) VALUES (NULL, '$id', CURRENT_TIMESTAMP)";
$q=mysqli_query($con,$sql);

	if ($q) {
		echo "insert";
	}
	else{
		echo "insert fail";
	}
mysqli_close($con);

?>