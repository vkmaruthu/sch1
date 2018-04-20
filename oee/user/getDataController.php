<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';

if(isset($_POST['saveScreen'])){
      
    $recordId=$_POST['recordId'];
    $screenId=$_POST['screenId'];
    $screenName=$_POST['screenName'];
    $screen_descp=$_POST['screen_descp'];
    
    $table = 'sfs_screens';
    $DataMarge=array('screenId'=>$screenId,
                     'name'=>$screenName,
                     'descp'=>$screen_descp
    );

    if($recordId == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Screen Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Screen Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Screen Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $cond=' id='.$recordId;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        //echo $sqlQuery;
        if(!$res) {
            $error="Screen Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Screen Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }            
        }        
    }    
    $status['screenData'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deleteScreen'])){
  $record_id=$_POST['record_id'];

  $comQ="DELETE FROM sfs_screens WHERE id=".$record_id;
  $delRecord=mysqli_query($con,$comQ); //or die('Error:'.mysqli_error($con));

        if(!$delRecord) {
            $error="Please Try again later";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){

              $response['info']="Record Deleted Successfully";
              $response['infoRes']="S"; // success   
            }else{
                $error="Please Try again later";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
         
        }
    $status['data'] = $response;     
    echo json_encode($status);
    mysqli_close($con);
}


if(isset($_POST['screenTable'])){
    $screenQ="SELECT id,screenId,name,descp FROM sfs_screens";
    $screenDetails=mysqli_query($con,$screenQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($screenDetails)){
        $id=$row['id'];
        $screenId=$row['screenId'];
        $name=$row['name'];
        $descp=$row['descp'];

        $getEQData[]=array('id' =>"$id",
            'screenId' =>"$screenId",
            'screenName' =>"$name",
            'screen_descp' => "$descp",
        );
        
    }
    
    $status['screenDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}



?>