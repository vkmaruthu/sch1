<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';


/* ------------OEE Config DB Operation --------------------- */

if(isset($_POST['saveOEEConfig'])){
    
    $oee_id = $_POST['oee_limit_id'];
    if ($_POST['comp_desc'] == 0 || $_POST['comp_desc'] == "") {
        $comp_desc='NULL';
    }else{
        $comp_desc=$_POST['comp_desc'];
    }
    if ($_POST['plant_desc'] == 0 || $_POST['plant_desc'] == "") {
        $plant_desc='NULL';
    }else{
        $plant_desc=$_POST['plant_desc'];
    }
    if ($_POST['wc_desc'] == 0 || $_POST['wc_desc'] == "") {
        $wc_desc='NULL';
    }else{
        $wc_desc=$_POST['wc_desc'];
    }
    if ($_POST['eq_desc'] == "") {
        $eq_desc='NULL';
    }else if($_POST['eq_desc'] == "none"){
        $eq_desc='NULL';
    }else{
        $eq_desc=$_POST['eq_desc'];
    }
    $p_limits_db = split(",",$_POST['p_limits_db']);
    $p_high = $p_limits_db[1] > $p_limits_db[0] ? $p_limits_db[1]:$p_limits_db[0];
    $p_low = $p_limits_db[0] < $p_limits_db[1] ? $p_limits_db[0]:$p_limits_db[1];
    
    $a_limits_db = split(",",$_POST['a_limits_db']);
    $a_high = $a_limits_db[1] > $a_limits_db[0] ? $a_limits_db[1]:$a_limits_db[0];
    $a_low = $a_limits_db[1] > $a_limits_db[0] ? $a_limits_db[0]:$a_limits_db[1];
    
    $q_limits_db = split(",",$_POST['q_limits_db']);
    $q_high = $q_limits_db[1] > $q_limits_db[0] ? $q_limits_db[1]:$q_limits_db[0];
    $q_low =  $q_limits_db[1] > $q_limits_db[0] ? $q_limits_db[0]:$q_limits_db[1];
    
    $oee_limits_db = split(",",$_POST['oee_limits_db']);
    $oee_high = $oee_limits_db[1] > $oee_limits_db[0] ? $oee_limits_db[1]:$oee_limits_db[0];
    $oee_low = $oee_limits_db[1] > $oee_limits_db[0] ? $oee_limits_db[0]:$oee_limits_db[1];
    
    $table = 'sfs_oee_limit';
    $DataMarge=array('company_id'=>$comp_desc,
        'plant_id'=>$plant_desc,
        'workcenter_id'=>$wc_desc,
        'eq_code'=>"$eq_desc",
        'oee_high'=>"$oee_high",
        'oee_low'=>"$oee_low",
        'a_high'=>"$a_high",
        'a_low'=>"$a_low",
        'p_high'=>"$p_high",
        'p_low'=>"$p_low",
        'q_high'=>"$q_high",
        'q_low'=>"$q_low"
    );
    
    if($oee_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit");
        //echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery);
        if(!$res) {
            $error="OEE Assigned Already";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="OEE Assigned Already";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
        }
    }else{
        $cond=' id='.$oee_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery);
        //echo $sqlQuery;
        if(!$res) {
            $error="OEE Assigned Already";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="OEE Assigned Already";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getOEELimitsDetails'])){
    $comp_id=$_POST['comp_id'];
    $eqQ="SELECT ol.id, ol.oee_high, ol.oee_low, ol.a_high, ol.a_low, ol.p_low, ol.p_high, ol.q_high, ol.q_low, 
          ol.company_id, ol.plant_id, ol.workcenter_id, ol.eq_code, c.descp as comp_desc, p.descp as plant_desc, 
          wc.descp as wc_desc, eq.eq_desc
          FROM sfs_oee_limit ol LEFT JOIN sfs_company c on c.id=ol.company_id 
                      LEFT JOIN sfs_plant p on p.id=ol.plant_id
                      LEFT JOIN sfs_workcenter wc on wc.id=ol.workcenter_id
                      LEFT JOIN sfs_equipment eq on eq.eq_code=ol.eq_code where ol.company_id=".$comp_id;
    
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
        $id=$row['id'];
        $company_id=$row['company_id'];
        $comp_desc=$row['comp_desc'];
        $plant_id=$row['plant_id'];
        $plant_desc=$row['plant_desc'];
        $workcenter_id=$row['workcenter_id'];
        $wc_desc=$row['wc_desc'];
        $eq_code=$row['eq_code'];
        $eq_desc=$row['eq_desc'];
        
        $oee_high=$row['oee_high'];
        $oee_low=$row['oee_low'];
        $a_high=$row['a_high'];
        $a_low=$row['a_low'];
        $p_high=$row['p_high'];
        $p_low=$row['p_low'];
        $q_high=$row['q_high'];
        $q_low=$row['q_low'];
        
        $getEQData[]=array('id' =>"$id",
            'company_id' => "$company_id",
            'comp_desc' => "$comp_desc",
            'plant_id' => "$plant_id",
            'plant_desc' => "$plant_desc",
            'workcenter_id' => "$workcenter_id",
            'wc_desc' => "$wc_desc",
            'eq_code' => "$eq_code",
            'eq_desc' => "$eq_desc",
            'oee_high'  => "$oee_high",
            'oee_low' => "$oee_low",
            'a_high' => "$a_high",
            'a_low' => "$a_low",
            'p_high' => "$p_high",
            'p_low' => "$p_low",
            'q_high' => "$q_high",
            'q_low' => "$q_low"
        );
    }
    
    $status['oeeLimitsDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deleteOEELimits'])){
    $oee_limit_id=$_POST['oee_limit_id'];
   
    $delQ="DELETE FROM sfs_oee_limit WHERE id=".$oee_limit_id;
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

/* End of OEE Conf DB Operations */

?>