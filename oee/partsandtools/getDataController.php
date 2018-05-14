<?php
require '../common/db.php';
require '../common/commonFunctions.php';
//require '../common/session.php';

/* ------------Parts DB Operation --------------------- */

if(isset($_POST['saveParts'])){
    
    $part_num=$_POST['part_num'];
    $part_desc=$_POST['part_desc'];
    $plant_id=$_POST['plant_id'];
    $part_id=$_POST['part_id'];
    
    $table = 'sfs_part_fg';
    $DataMarge=array('code'=>"$part_num",
        'descp'=>"$part_desc",
        'plant_id'=>$plant_id
    );
    
    if($part_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Part Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Part Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Part Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $cond=' id='.$part_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        if(!$res) {
            $error="Part Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Part Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deleteParts'])){
    $part_id=$_POST['part_id'];
    $delQ="DELETE FROM sfs_part_fg WHERE id=".$part_id;
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
/* End of Parts DB Operations */

/* Tools DB Operation  */

if(isset($_POST['saveTool'])){
    
    $comp_code = $_POST['comp_code'];
    $action = $_POST['action'];
    $plant_id = $_POST['plant_id'];
    $part_num = $_POST['part_num'];
    $img_id=$_POST['img_id'];
    $part_id=$_POST['part_id'];

    $tag_id=$_POST['tag_id'];
    $tool_opr_id_type=$_POST['tool_opr_id_type'];
    $tool_name=$_POST['tool_name'];
    
    $opr_id=$_POST['opr_id'];
    $tool_desc=$_POST['tool_desc'];
    $ton=$_POST['ton'];
    $maint_count=$_POST['maint_count'];
    $image_file_name=$_POST['image_file_name'];
    $lifetime_count=$_POST['lifetime_count'];
    $bm_setup_time=$_POST['bm_setup_time'];
    $bm_prod_time=$_POST['bm_prod_time'];
    $no_of_items_per_oper=$_POST['no_of_items_per_oper']; 
    
    $file_names = $_FILES['image_file_name']['name'];
    $file_sizes =$_FILES['image_file_name']['size'];
    $file_tmps =$_FILES['image_file_name']['tmp_name'];
    $file_types=$_FILES['image_file_name']['type'];
    
    $path_parts = pathinfo($file_names);
    $extension = $path_parts['extension'];
    
    if($file_names==""){
        if($img_id==''){
            $filePath="";
            $filePathDB="";
        }else{
            $filePath="";
            $filePathDB=$img_id;
        }
    }else{    
        $delPrevImg="../common/img/tools/".$img_id;
        unlink($delPrevImg);
        $filePathDB=$plant_id."_".$part_id."_".$opr_id."_".rand().".".$extension;
        $filePath="../common/img/tools/".$filePathDB;
    }
    
    $table = 'sfs_tool_opr';
    if($action == 'S'){
        $DataMarge=array('tag_id'=>"$tag_id",
            'name'=>"$tool_name",
            'number'=>"$opr_id",
            'descp'=>"$tool_desc",
            'ton'=>$ton,
            'maint_count'=>$maint_count,
            'image_file_name'=>"$filePathDB",
            'lifetime_count' => $lifetime_count,
            'bm_setup_time' => $bm_setup_time,
            'bm_prod_time' => $bm_prod_time,
            'no_of_items_per_oper' => $no_of_items_per_oper,
            'part_fg_id' => $part_id,
            'tool_opr_type_id' => $tool_opr_id_type
        );
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        //echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Tool(Operation)  Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Tool(Operation) Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Tool(Operation) Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $DataMarge=array('name'=>"$tool_name",
                     'number'=>"$opr_id",
                    'descp'=>"$tool_desc",
                    'ton'=>$ton,
                    'maint_count'=>$maint_count,
                    'image_file_name'=>"$filePathDB",
                    'lifetime_count' => $lifetime_count,
                    'bm_setup_time' => $bm_setup_time,
                    'bm_prod_time' => $bm_prod_time,
                    'no_of_items_per_oper' => $no_of_items_per_oper
        );
        $cond=" tag_id='".$tag_id."'";
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
       // echo $sqlQuery;
        if(!$res) {
            $error="Tool(Operation) Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Tool(Operation) Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getToolDetails'])){
    $comp_id=$_POST['comp_id'];
    $plant_id=$_POST['plant_id'];
    $part_id=$_POST['part_id'];
    $eqQ="SELECT topr.tag_id, topr.name, topr.number, topr.descp, topr.ton, topr.maint_count, topr.lifetime_count, topr.image_file_name, topr.bm_setup_time,
          topr.bm_prod_time, topr.no_of_items_per_oper, toid.id, toid.name as type_name FROM sfs_tool_opr topr, sfs_tool_opr_id_type toid  
          WHERE toid.id=topr.tool_opr_type_id and topr.part_fg_id=".$part_id;
    $partsDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($partsDetails)){
        $tag_id=$row['tag_id'];
        $mac_id=$row['mac_id'];
        $tool_name=$row['name'];
        
        $tool_desc=$row['descp'];
        $ton=$row['ton'];
        $maint_count=$row['maint_count'];
        $image_file_name=$row['image_file_name'];
        $lifetime_count=$row['lifetime_count'];
        $bm_setup_time=$row['bm_setup_time'];
        $bm_prod_time=$row['bm_prod_time'];
        $no_of_items_per_oper=$row['no_of_items_per_oper'];
        
        $number=$row['number'];
        $type_id=$row['id'];
        $id_type_name=$row['type_name'];
        $getEQData[]=array('tag_id' =>"$tag_id",
            'tool_name' => "$tool_name",
            'tool_desc' => "$tool_desc",
            'ton' => "$ton",
            'maint_count' => "$maint_count",
            'image_file_name' => "$image_file_name",
            'lifetime_count' => "$lifetime_count",
            'bm_setup_time' => "$bm_setup_time",
            'bm_prod_time' => "$bm_prod_time",
            'no_of_items_per_oper' => "$no_of_items_per_oper",
            'type_id' => "$type_id",
            'number' => "$number",
            'id_type_name' => "$id_type_name"
        );
    }
    $status['toolsDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deleteTool'])){
    $tag_id=$_POST['tag_id'];
    $img=$_POST['img'];  
    $Q="DELETE FROM sfs_tool_opr WHERE tag_id='".$tag_id."'";
    $del=mysqli_query($con,$Q); //or die('Error:'.mysqli_error($con));
    if(!$del) {
        $error="Please Try again later";
        $response['info']=$error;
        $response['infoRes']='E'; //Error
    }else {
        if(mysqli_errno() != 1062){ 
            $delPrevImg="../common/img/tools/".$img;
            unlink($delPrevImg);
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

if(isset($_POST['saveToolsIDTypesType'])){
    $type_id= $_POST['type_id'];
    $tool_id_type=$_POST['tool_id_type'];
    $id_type_desc=$_POST['id_type_desc'];
    
    $table = 'sfs_tool_opr_id_type';
    $DataMarge=array('name'=>$tool_id_type,
        'descp'=>$id_type_desc
    );
    
    if($type_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Tool Id Type Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Tool Id Type Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Tool Id Type Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
    }else{
        $cond=' id='.$type_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        if(!$res) {
            $error="Tool Id Type Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Tool Id Type Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }   
        }
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getToolIdTypes'])){ 
    $eqQ="SELECT id, name, descp FROM sfs_tool_opr_id_type";
    $partsDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($partsDetails)){
        $id=$row['id'];
        $id_type_name=$row['name'];
        $id_type_desc=$row['descp'];
        $getEQData[]=array('id' =>"$id",
            'tool_id_type' => "$id_type_name",
            'id_type_desc' => "$id_type_desc"
        );
    }
    $status['toolIdTypes'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}



?>