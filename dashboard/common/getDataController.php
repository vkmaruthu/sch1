<?php 
    require 'db.php';
    require 'commonFunctions.php';
    

if(isset($_POST['userDetails'])){

    $userMail=$_POST['userMail']; 
    $tokenPass=$_POST['token']; 
    
    $sql = "SELECT l.id,l.username,l.role,c.comp_desc FROM login l, tb_m_companny c WHERE username='".$userMail."' 
        and Password='".$tokenPass."'";

    $userDetailRes=mysqli_query($con,$sql) or die('Error:'.mysqli_error($con));
  
    while ($row=mysqli_fetch_array($userDetailRes)){
        $username = $row['username'];
        $user_role = $row['role'];
        $comp_desc = $row['comp_desc'];
       
        $response=array('username' =>$username,
                         'user_role' =>$user_role,
                         'comp_desc' =>$comp_desc
                        );
        
    }
    $status['userDetails'] = $response;
 
    echo json_encode($status);
    mysqli_close($con);
}
if(isset($_POST['reason'])){
   echo $s='welcome';
}
?>