<?php 
error_reporting(0);
session_start();

require_once('../common/db.php');

// if login session - then redirect to dashboard page
if(isset($_POST['getLogin'])){

	if (empty($_POST['email']) || empty($_POST['password'])) 
	{
		//$error = "Username or Password is invalid";
	}
	else
	{	
		//echo $_POST['password'];
		$email = $_POST['email'];				
		$password=$_POST['password'];

		$sql="SELECT su.roles_id as roles_id,sr.name as roleName, sr.company_id as company_id,su.is_active as is_active from sfs_user su, sfs_roles sr
		    where su.roles_id=sr.id and su.email_id='".$email."' and su.password='".$password."'";
		//echo "<br>Q :".$sql; //is_active
		$query = mysqli_query($con,$sql) or die(mysqli_error());
		
		if(mysqli_num_rows($query) == 1) {
			while($row = mysqli_fetch_assoc($query)){
				$roles_id = $row['roles_id'];
				$roleName = $row['roleName'];
				$company_id = $row['company_id'];
				$is_active = $row['is_active'];
			}

			if($is_active==1){
				$msg="User is Activated";
                $response['info']=$msg;
                $response['infoRes']='A'; //Activated

				$_SESSION['schAdminSession'] = $email;
				$_SESSION['schAdminRole'] = $roleName;

			}else{
				$msg="User is Deactivated";
                $response['info']=$msg;
                $response['infoRes']='D'; //Deactivated
			}
			    //$_SESSION['start'] = time(); // Taking now logged in time.
	            // Ending a session in 30 minutes from the starting time.
	            //$_SESSION['expire'] = $_SESSION['start'] + (10 * 5);
				//echo "<script> window.location='admin/index.php';</script>";	
			//echo "S";							
		}
		else {
			$msg="wrong user/password";
            $response['info']=$msg;
            $response['infoRes']='F'; //Deactivated
		}
				
	}

	$status['login'] = $response;     
    echo json_encode($status);
    mysqli_close($con);
}
?>
