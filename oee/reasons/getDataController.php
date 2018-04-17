<?php 
    require '../common/db.php';
    //require '../common/session.php';

function mysqli_insert_array($table, $data, $exclude = array()) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
            //$values[] = "'" . mysql_real_escape_string($data[$key]) . "'";
            $values[] = "'" .$data[$key]. "'";
        }
    }     
    $fields = implode(",", $fields);
    $values = implode(",", $values);

    $sql="INSERT INTO `$table` ($fields) VALUES ($values) ";
    return $sql;
}   

function mysqli_update_array($table, $data, $exclude = array(),$cond) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $dataA[]=$key."='" .$data[$key]. "'";
        }
    }     
    $dataA = implode(",", $dataA);

    $updateSql = "UPDATE $table SET $dataA where $cond";
    return $updateSql;
}

// get time formate in mm/dd/yyyy hh:mm PM TO yyyy-mm-dd hh:mm:ss Database Formate
function getDbDateTimeFormate($input) {
    $Datetime = date("Y-m-d H:i:s", strtotime($input));
    $only_date =date("Y-m-d", strtotime($input));
     return  array( "DateTime" => $Datetime,
                    "only_date" => $only_date,
                   );
}

function addZero($num) {
    if($num < 10) {
        $num = "0".$num;
    }
    return $num;
  }


/* ------------Reasons DB Operation --------------------- */

if(isset($_POST['saveReasons'])){
   
    $reason_id=$_POST['reason_id'];
    $reason_type_id=$_POST['reason_type_id'];
    $message=$_POST['message'];
    $color_code=$_POST['color'];
    
    $table = 'sfs_reason_code';
    $DataMarge=array('reason_type_id'=>$reason_type_id,
                     'message'=>$message,
                     'color_code'=>$color_code
    );

    if($reason_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
       // echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
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
        $cond=' id='.$reason_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
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
    
    $reason_id=$_POST['reason_id'];
   
    $table = 'sfs_reason_type';
    $DataMarge=array('message'=>$message,
                'color_code'=>$color_code
    );

    if($reason_id == ''){
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