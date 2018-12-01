<?php
//require '../common/db.php';
//require '../common/session.php';

function mysqli_insert_array($table, $data, $exclude = array()) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
            
            if($data[$key] == 'NULL'){
                $values[] =$data[$key];
            }else{
                $values[] ="'" .$data[$key]. "'";
            }
            
            //$values[] = "'" .$data[$key]. "'";
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
            
            if($data[$key] == 'NULL'){
                $dataA[]=$key."=".$data[$key];
            }else{
                $dataA[]=$key."='" .$data[$key]. "'";
            }
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
         $plantQ = "No data";
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
        
        $getPlantDetails[]=array('id' =>"$id",
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

    $status['plantDetails'] = $getPlantDetails;
    echo json_encode($status);
    mysqli_close($con);
}



?>