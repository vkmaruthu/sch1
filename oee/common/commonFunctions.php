<?php
//require '../common/db.php';
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

if(isset($_POST['getCompanyDetails'])){
    $comp_id=$_POST['comp_id'];  

    if($comp_id!=''){
        $plantQ="SELECT id,code,descp,address,contact_person,contact_number,image_file_name, comp_id FROM sfs_plant where comp_id=".$comp_id;
    }else{
        $plantQ="SELECT id,code,descp,address,contact_person,contact_number,image_file_name, comp_id FROM sfs_plant";
    }
    $plantDetails=mysqli_query($con,$plantQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($plantDetails)){
        $id=$row['id'];
        $comp_code=$row['code'];
        $comp_desc=$row['descp'];
        $address=$row['address'];
        $contact_person=$row['contact_person'];
        $contact_number=$row['contact_number'];
        $image_file_name=$row['image_file_name'];
        $comp_id=$row['comp_id'];
        
        $getCompData[]=array('id' =>"$id",
            'comp_code' =>"$comp_code",
            'comp_desc' =>"$comp_desc",
            'address' =>"$address",
            'contact_person' =>"$contact_person",
            'contact_number' =>"$contact_number",
            'image_file_name' =>"$image_file_name",
            'comp_id' => "$comp_id"
        );
        
    }
    
    $status['companyDetails'] = $getCompData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getPlantDetails'])){
    $comp_id=$_POST['comp_id'];   

   $plantQ="SELECT id,code,descp,address,contact_person,contact_number,image_file_name, comp_id FROM sfs_plant where comp_id=".$comp_id;
   $plantDetails=mysqli_query($con,$plantQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($plantDetails)){
        $id=$row['id'];
        $plant_code=$row['code'];
        $plant_desc=$row['descp'];
        $address=$row['address'];
        $contact_person=$row['contact_person'];
        $contact_number=$row['contact_number'];
        $image_file_name=$row['image_file_name'];
        $comp_id=$row['comp_id'];
        
        $getCompData[]=array('id' =>"$id",
            'plant_code' =>"$plant_code",
            'plant_desc' =>"$plant_desc",
            'address' =>"$address",
            'contact_person' =>"$contact_person",
            'contact_number' =>"$contact_number",
            'image_file_name' =>"$image_file_name",
            'comp_id' => "$comp_id"
        );
        
    }
    
    $status['plantDetails'] = $getCompData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getWCDetails'])){
    $plant_id=$_POST['plant_id'];

    $plantQ="SELECT id,code,descp,contact_person,contact_number,image_file_name, plant_id FROM sfs_workcenter where plant_id=".$plant_id;
    $wcDetails=mysqli_query($con,$plantQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($wcDetails)){
        $id=$row['id'];
        $wc_code=$row['code'];
        $wc_desc=$row['descp'];
        $contact_person=$row['contact_person'];
        $contact_number=$row['contact_number'];
        $image_file_name=$row['image_file_name'];
        $plant_id=$row['plant_id'];
        
        $getWCData[]=array('id' =>"$id",
            'wc_code' =>"$wc_code",
            'wc_desc' =>"$wc_desc",
            'contact_person' =>"$contact_person",
            'contact_number' =>"$contact_number",
            'image_file_name' =>"$image_file_name",
            'plant_id' => "$plant_id"
        );
        
    }
    
    $status['wcDetails'] = $getWCData;
    echo json_encode($status);
    mysqli_close($con);
}



if(isset($_POST['getEquipmentDetails'])){
    $wc_id=$_POST['wc_id'];

    $eqQ="SELECT eq.id,eq.eq_code,eq.eq_desc,eq.image_file_name, eq.eq_protocol, eq.eq_type_id, eq.eq_model_id, eq.wc_id, eqm.name,eqt.eq_type_desc, eq.reason_code_arr FROM sfs_equipment eq, sfs_equipment_model eqm, sfs_equipment_type eqt where eq.eq_model_id=eqm.id and eq.eq_type_id=eqt.id and  wc_id=".$wc_id;

    
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($eqDetails)){
        $id=$row['id'];
        $eq_code=$row['eq_code'];
        $eq_desc=$row['eq_desc'];
        $eq_protocol=$row['eq_protocol'];
        $eq_type_id=$row['eq_type_id'];
        $eq_model_id=$row['eq_model_id'];
        $image_file_name=$row['image_file_name'];
        $wc_id=$row['wc_id'];
        $model_name=$row['name'];
        $eq_type_name=$row['eq_type_desc'];
        $reason_code_arr=$row['reason_code_arr'];
        
        //$reasonCodeName = getAllReasonCodeNames($reason_code_arr);
        $q="select message from sfs_reason_code where id IN(".$reason_code_arr.")";
        $res=mysqli_query($con,$q) or die('Error:'.mysqli_error($con));
        while ($row=mysqli_fetch_array($res)){
            $message=$row['message'];
            $strMsg.=$message.', ';
        }
        
        $getEQData[]=array('id' =>"$id",
            'eq_code' =>"$eq_code",
            'eq_desc' =>"$eq_desc",
            'eq_protocol' => "$eq_protocol",
            'eq_type_id' => "$eq_type_id",
            'eq_model_id' => "$eq_model_id",
            'image_file_name' =>"$image_file_name",
            'wc_id' => "$wc_id",
            'model_name' => "$model_name",
            'eq_type_name' => "$eq_type_name",
            'reason_code_arr' => "$reason_code_arr",
            'reason_code_name' => "$strMsg"
        );
        $strMsg='';
    }
    
    $status['equipmentDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}


?>