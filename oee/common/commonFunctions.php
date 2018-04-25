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

if(isset($_POST['getCompDetails'])){
    $comp_id=$_POST['comp_id'];  // It will use when its calling from Plants, Workcenter, Machine.
    
    if($comp_id != ''){
        $comQ="SELECT id,code,descp,address,contact_person,contact_number,image_file_name FROM sfs_company where id=".$comp_id;
    }else{
        $comQ="SELECT id,code,descp,address,contact_person,contact_number,image_file_name FROM sfs_company";
    }
    $comDetails=mysqli_query($con,$comQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($comDetails)){
        $id=$row['id'];
        $comp_code=$row['code'];
        $comp_desc=$row['descp'];
        $address=$row['address'];
        $contact_person=$row['contact_person'];
        $contact_number=$row['contact_number'];
        $image_file_name=$row['image_file_name'];
        
        
        $getCompData[]=array('id' =>"$id",
            'comp_code' =>"$comp_code",
            'comp_desc' =>"$comp_desc",
            'address' =>"$address",
            'contact_person' =>"$contact_person",
            'contact_number' =>"$contact_number",
            'image_file_name' =>"$image_file_name"
        );
        
    }
    
    $status['compDetails'] = $getCompData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getPlantDetails'])){
    $comp_id=$_POST['comp_id'];
    $plant_id =$_POST['plant_id'];
    if ($plant_id != "") {
        $plantQ="SELECT p.id, p.code, p.descp, p.address, p.contact_person, p.contact_number, p.image_file_name, p.comp_id, c.code as comp_code FROM 
                 sfs_plant p, sfs_company c where p.comp_id=c.id and p.id=".$plant_id." and p.comp_id=".$comp_id;
    }elseif ($comp_id != ""){
        $plantQ="SELECT p.id, p.code, p.descp, p.address, p.contact_person, p.contact_number, p.image_file_name, p.comp_id, c.code as comp_code FROM
                 sfs_plant p, sfs_company c where p.comp_id=c.id  and p.comp_id=".$comp_id;
    }else {
        
    }
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
        $comp_code=$row['comp_code'];
        
        $getCompData[]=array('id' =>"$id",
            'plant_code' =>"$plant_code",
            'plant_desc' =>"$plant_desc",
            'address' =>"$address",
            'contact_person' =>"$contact_person",
            'contact_number' =>"$contact_number",
            'image_file_name' =>"$image_file_name",
            'comp_id' => "$comp_id",
            'comp_code' => "$comp_code",
        );
        
    }
    
    $status['plantDetails'] = $getCompData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getWCDetails'])){
    $comp_id = $_POST['comp_id'];
    $plant_id=$_POST['plant_id'];
    $wc_id = $_POST['wc_id'];
    if ($wc_id != "") {
        $plantQ="SELECT wc.id, wc.code, wc.descp, wc.contact_person, wc.contact_number, wc.image_file_name, wc.plant_id FROM sfs_workcenter wc, 
                 sfs_plant p, sfs_company c where wc.plant_id=p.id and p.comp_id=c.id and wc.id=".$wc_id;
    }elseif ($plant_id != "") {
        $plantQ="SELECT wc.id, wc.code, wc.descp, wc.contact_person, wc.contact_number, wc.image_file_name, wc.plant_id FROM sfs_workcenter wc,
                 sfs_plant p, sfs_company c where wc.plant_id=p.id and p.comp_id=c.id and wc.plant_id=".$plant_id;
    }else{
        return "No data";
    }
    
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
    $eq_id = $_POST['eq_id'];
    
    if ($eq_id != '') {
        $eqQ="SELECT eq.id,eq.eq_code,eq.eq_desc,eq.image_file_name, eq.eq_protocol, eq.eq_type_id, eq.eq_model_id, eq.wc_id, 
             eqm.name,eqt.eq_type_desc, eq.reason_code_arr FROM sfs_equipment eq, sfs_equipment_model eqm, sfs_equipment_type eqt 
             where eq.eq_model_id=eqm.id and eq.eq_type_id=eqt.id and  wc_id=".$wc_id." and eq.id=".$eq_id;
    }else{
      $eqQ="SELECT eq.id,eq.eq_code,eq.eq_desc,eq.image_file_name, eq.eq_protocol, eq.eq_type_id, eq.eq_model_id, eq.wc_id,
            eqm.name,eqt.eq_type_desc, eq.reason_code_arr FROM sfs_equipment eq, sfs_equipment_model eqm, sfs_equipment_type eqt
            where eq.eq_model_id=eqm.id and eq.eq_type_id=eqt.id and  wc_id=".$wc_id;
    }
    
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

if(isset($_POST['getPartsDetails'])){
    
    $plant_id=$_POST['plant_id'];
    $part_id=$_POST['part_id'];
    if ($part_id != '') {
        $eqQ="SELECT id, number, descp from sfs_part_fg where id=".$part_id;
    }else{
        $eqQ="SELECT id, number, descp from sfs_part_fg where plant_id=".$plant_id;
    }
    
    $partsDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($partsDetails)){
        $id=$row['id'];
        $part_num=$row['number'];
        $part_desc=$row['descp'];
        
        $getEQData[]=array('id' =>"$id",
            'part_num' =>"$part_num",
            'part_desc' =>"$part_desc"
        );
    }
    $status['partsDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}



?>