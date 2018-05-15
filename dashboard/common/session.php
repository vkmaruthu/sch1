<?php

if(!isset($_SESSION['cps_admin'])) {
//echo "test";
	echo "<script> window.location='../logout.php';</script>";
}/*else{
        $now = time(); // Checking the time now when home page starts.
        $expire=$_SESSION['expire'];
        $data=$now."=".$expire;
        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "<script> 
            alert('Your session has expired!');
            window.location='../logout.php';</script>";
            //echo "Your session has expired! <a href='http://localhost/somefolder/login.php'>Login here</a>";
        }
        else{
      		//echo "<script> alert('".$data."');</script>";
      	}
    }*/

?>