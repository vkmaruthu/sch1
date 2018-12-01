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
		$password=md5($_POST['password'],FALSE);
        $sql = "SELECT id,username,Password,role FROM login WHERE username='".$email."' 
        and Password='".$password."'";
		// $sql="SELECT e.emp_id,e.role_code,e.frst_name,e.designation,p.plnt_code,p.plnt_s_desc,p.plnt_desc, c.comp_code,c.comp_desc	
		// FROM tb_m_employee e, tb_o_plant p,tb_o_company c 
		// 	WHERE e.emp_id='".$email."' and e.password='".$password."' 
		// 	and e.plnt_code=p.plnt_code and p.comp_code=c.comp_code";
		//echo "<pre>".	$sql; 
		//die();
		$query = mysqli_query($con,$sql) or die(mysqli_error());
		
		if(mysqli_num_rows($query) == 1) {
			while($row = mysqli_fetch_assoc($query)){
				

				$msg="User is Activated";
                $response['info']=$msg;
                $response['infoRes']='A'; //Activated
                
				$_SESSION['schAdminSession'] = $email;
				$_SESSION['schAdminRole'] = $password;

				
			}

			    						
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
