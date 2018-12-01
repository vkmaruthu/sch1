<?php 
     require_once('../common/db.php');
     require_once('../common/commonFunctions.php');
 
    //require 'commonFunctions.php';
   

  
    
    //$sql = "SELECT * FROM idle_reason";

    $sql = "SELECT short_desc,long_desc FROM idle_reason";

    $userDetailRes=mysqli_query($con,$sql) or die('Error:'.mysqli_error($con));
  
    while ($row=mysqli_fetch_array($userDetailRes)){
        $short_desc[] = $row['short_desc'];
        $long_desc[] = $row['long_desc'];
        
          $response=array( 'short_desc' =>$short_desc,
                         'long_desc' =>$long_desc
                       );
     
        
    }
    
    $status['idleReason'] = $response;
 
    echo json_encode($status);
    mysqli_close($con);

 ?>