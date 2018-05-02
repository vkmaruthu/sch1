<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';


/* ------------Reasons DB Operation --------------------- */

if(isset($_POST['saveReasons'])){
    $reason_id=$_POST['reason_id'];
    $reason_type_id=$_POST['reason_type_id'];
    $message=$_POST['message'];
    $color_code=$_POST['color'];
    $reason_code_no=$_POST['reason_code_no'];
    $table = 'sfs_reason_code';
    if($reason_id == ''){
        $DataMarge=array('id'=>$reason_code_no,
            'reason_type_id'=>$reason_type_id,
            'message'=>$message,
            'color_code'=>$color_code
        );
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
       // echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery);
        if(!$res) {
            $error="Reason Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Reason Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Reason Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
        }
    }else{
        $DataMarge=array('id'=>$reason_code_no,
            'reason_type_id'=>$reason_type_id,
            'message'=>$message,
            'color_code'=>$color_code
        );
        $cond=' id='.$reason_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery);
        //echo $sqlQuery;
        if(!$res) {
            $error="Reason Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Reason Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getReasonsDetails'])){
    $eqQ="SELECT rc.id, rc.message, rc.color_code, rt.message as message1, rt.color_code as color_code1, rc.reason_type_id  FROM sfs_reason_code rc, sfs_reason_type rt where rt.id=reason_type_id";
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
        $id=$row['id'];
        $message=$row['message'];
        $color_code=$row['color_code'];
        $message1=$row['message1'];
        $color_code1=$row['color_code1'];
        $reason_type_id=$row['reason_type_id'];
        $getEQData[]=array('id' =>"$id",
            'message' =>"$message",
            'color_code' =>"$color_code",
            'message1' => "$message1",
            'color_code1' => "$color_code1",
            'reason_type_id' => "$reason_type_id"
        );
        
    }
    
    $status['reasontDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deleteReason'])){
    $reason_id=$_POST['reason_id'];
   
    $delQ="DELETE FROM sfs_reason_code WHERE id=".$reason_id;
    $result=mysqli_query($con,$delQ); //or die('Error:'.mysqli_error($con));
    
    if(!$result) {
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

/* End of Reasons DB Operations */


if(isset($_POST['saveReasonType'])){
    $message=$_POST['message1'];
    $color_code=$_POST['color_code1'];
    $reason_id1=$_POST['reason_id1'];
    $r_id=$_POST['id_reason_type'];
    $table = 'sfs_reason_type';
    if($r_id == ''){
        $DataMarge=array('id'=>$reason_id1,
            'message'=>$message,
            'color_code'=>$color_code
        );
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Reason Type Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Reason Type Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Reason Type Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $DataMarge=array(
            'message'=>$message,
            'color_code'=>$color_code
        );
        $cond=' id='.$reason_id1;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); 
        if(!$res) {
            $error="Reason Code Type Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Reason Code Type Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
        }
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getReasonType'])){
    $eqQ="SELECT id,message, color_code FROM sfs_reason_type";
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($eqDetails)){
           $id=$row['id'];
           $message=$row['message'];
           $color_code=$row['color_code'];
           $getEQData[]=array('id' =>"$id",
                      'message' =>"$message",
                      'color_code' => "$color_code"
           );
        
    }
    $status['reasonTypes'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

?>