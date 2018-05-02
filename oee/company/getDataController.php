<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';

if(isset($_POST['saveCompany'])){
    $comp_id=$_POST['comp_id_local'];
    $img_id=$_POST['img_id'];
    $comp_code=$_POST['comp_code'];
    $comp_desc=$_POST['comp_desc'];
    $contact_person=$_POST['contact_person'];
    $contact_number=$_POST['contact_number'];
    $address=$_POST['address'];
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
      $delPrevImg="../common/img/comp_logo/".$img_id; 
      unlink($delPrevImg); 
      $filePathDB=$comp_code."_".rand().".".$extension;
      $filePath="../common/img/comp_logo/".$filePathDB;    
    }
      //unlink("../$img_name");                   
    $table = 'sfs_company';  
    $DataMarge=array('code'=>$comp_code,
                  'descp'=>$comp_desc,
                  'contact_person'=>$contact_person,
                  'contact_number'=>$contact_number,
                  'address'=>$address,
                  'image_file_name'=>$filePathDB
                );
  if($comp_id == ''){
    $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
   // echo $sqlQuery;
    $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));  
    if(!$res) {
        $error="Company Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
    }else {
        if(mysqli_errno() != 1062){
          move_uploaded_file($file_tmps,$filePath);
          $response['info']="Company Created Successfully";
          $response['infoRes']="S"; // success
          $response['mysqli_insert_id']=mysqli_insert_id($con);     
        }else{
            $error="Company Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }
     
    }

  }else{
    $cond=' id='.$comp_id;
    $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
    $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));  
    //echo $sqlQuery;
    if(!$res) {
        $error="Company Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
    }else {
        if(mysqli_errno() != 1062){
          move_uploaded_file($file_tmps,$filePath);
          $response['info']="Record Updated Successfully";
          $response['infoRes']="S"; 
          $response['mysqli_insert_id']=mysqli_insert_id($con);     
        }else{
            $error="Company Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }
     
    }

  } 
$status['data'] = $response;     
echo json_encode($status);
mysqli_close($con);
}


if(isset($_POST['deleteCompany'])){
  $comp_id=$_POST['comp_id'];
  $img=$_POST['img'];

 $checkFKQ = "SELECT id FROM sfs_plant where comp_id=".$comp_id." LIMIT 1";
 $res=mysqli_query($con,$checkFKQ ) or die('Error:'.mysqli_error($con));
 if($row=mysqli_fetch_array($res)){
     $error="Company ID ".$comp_id." is used in Plant. Delete first Plant.";
     $response['info']=$error;
     $response['infoRes']='E';
  }else{   
      $comQ="DELETE FROM sfs_company WHERE id=".$comp_id;
      $delComp=mysqli_query($con,$comQ) or die('Error:'.mysqli_error($con));
            if(!$delComp) {
                $error="Please Try again later";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }else {
                if(mysqli_errno() != 1062){
                  $delPrevImg="../common/img/comp_logo/".$img; 
                  unlink($delPrevImg); 
                  $response['info']="Record Deleted Successfully";
                  $response['infoRes']="S"; // success   
                }else{
                    $error="Please Try again later";
                    $response['info']=$error;
                    $response['infoRes']='E'; //Error
                }
             
            }
    }
    $status['data'] = $response;     
    echo json_encode($status);
    mysqli_close($con);
}

/* ------------------- Plant DB Operation --------------------- */

if(isset($_POST['savePlant'])){
    $comp_id=$_POST['comp_id'];
    $plant_id=$_POST['plant_id'];
    $img_id=$_POST['img_id'];
    $plant_code=$_POST['plant_code'];
    $plant_desc=$_POST['plant_desc'];
    $contact_person=$_POST['contact_person'];
    $contact_number=$_POST['contact_number'];
    $address=$_POST['address'];  
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
        
        $delPrevImg="../common/img/plants/".$img_id;
        unlink($delPrevImg);
        $filePathDB=$plant_code."_".rand().".".$extension; 
        $filePath="../common/img/plants/".$filePathDB;    
    }
    //unlink("../$img_name");    
    $table = 'sfs_plant';
    $DataMarge=array('code'=>$plant_code,
        'descp'=>$plant_desc,
        'contact_person'=>$contact_person,
        'contact_number'=>$contact_number,
        'address'=>$address,
        'image_file_name'=>$filePathDB,
        'comp_id'=>$comp_id
    );
    
    if($plant_id == ''){  
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Plant Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Plant Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Plant Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $cond=' id='.$plant_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        //echo $sqlQuery;
        if(!$res) {
            $error="Plant Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Plant Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}
 
if(isset($_POST['deletePlant'])){
    $plant_id=$_POST['plant_id'];
    $img=$_POST['img'];
    
    $checkFKQ = "SELECT id FROM sfs_workcenter where plant_id=".$plant_id." LIMIT 1";
    $res=mysqli_query($con,$checkFKQ ) or die('Error:'.mysqli_error($con));
    if($row=mysqli_fetch_array($res)){
        $error="Plant ID (".$plant_id.") is used in Workcenter. Delete first Workcenter.";
        $response['info']=$error;
        $response['infoRes']='E';
    }else{
        $delQ="DELETE FROM sfs_plant WHERE id=".$plant_id;
        $result=mysqli_query($con,$delQ); //or die('Error:'.mysqli_error($con));   
        if(!$result) {
            $error="Please Try again later";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                
                $delPrevImg="../common/img/plants/".$img;
                unlink($delPrevImg);
                
                $response['info']="Record Deleted Successfully";
                $response['infoRes']="S"; // success
            }else{
                $error="Please Try again later";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
                }    
        }
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}
/* End Plant DB Operations */

/* ------------WC DB Operation --------------------- */

if(isset($_POST['saveWC'])){
    $plant_id=$_POST['plant_id'];
    $img_id=$_POST['img_id'];
    $wc_id=$_POST['wc_id'];    
    $wc_code=$_POST['wc_code'];
    $wc_desc=$_POST['wc_desc'];
    $contact_person=$_POST['contact_person'];
    $contact_number=$_POST['contact_number'];   
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
        $delPrevImg="../common/img/workcenter/".$img_id;
        unlink($delPrevImg);
        $filePathDB=$wc_code."_".rand().".".$extension;
        
        $filePath="../common/img/workcenter/".$filePathDB;   
    }
    //unlink("../$img_name");
    $table = 'sfs_workcenter';
    $DataMarge=array('code'=>$wc_code,
                    'descp'=>$wc_desc,
                    'contact_person'=>$contact_person,
                    'contact_number'=>$contact_number,
                    'image_file_name'=>$filePathDB,
                    'plant_id'=>$plant_id
    );
    if($wc_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Work Center Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Work Center Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Work Center Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $cond=' id='.$wc_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        //echo $sqlQuery;
        if(!$res) {
            $error="Work Center Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Work Center Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }   
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deleteWC'])){
    $wc_id=$_POST['wc_id'];
    $img=$_POST['img'];
    
    $checkFKQ = "SELECT id FROM sfs_equipment where wc_id=".$wc_id." LIMIT 1";
    $res=mysqli_query($con,$checkFKQ ) or die('Error:'.mysqli_error($con));
    if($row=mysqli_fetch_array($res)){
        $error="Work Center ID (".$wc_id.") is used in Equipment. Delete first Equipment.";
        $response['info']=$error;
        $response['infoRes']='E';
    }else{
        $delQ="DELETE FROM sfs_workcenter WHERE id=".$wc_id;
        $result=mysqli_query($con,$delQ) or die('Error:'.mysqli_error($con));
        if(!$result) {
            $error="Please Try again later";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                $delPrevImg="../common/img/workcenter/".$img;
                unlink($delPrevImg);
                $response['info']="Record Deleted Successfully";
                $response['infoRes']="S"; // success
            }else{
                $error="Please Try again later";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}
/* End of WC DB Operations */


/* ------------Equipment DB Operation --------------------- */

if(isset($_POST['saveEquipment'])){
    $eq_id=$_POST['eq_id'];
    $img_id=$_POST['img_id'];
    $wc_id=$_POST['wc_id'];   
    $eq_type_id=$_POST['eq_type'];
    $eq_model_id=$_POST['model'];
    $eq_code=$_POST['eq_code'];
    $eq_desc=$_POST['eq_desc'];
    $eq_protocol=$_POST['eq_protocol'];
    $reason_codes = implode(',',$_POST['reason_codes']);
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
        $delPrevImg="../common/img/machine/".$img_id;
        unlink($delPrevImg);
        $filePathDB=$eq_code."_".rand().".".$extension;
        $filePath="../common/img/machine/".$filePathDB;
    }
    $table = 'sfs_equipment';
    $DataMarge=array('eq_code'=>$eq_code,
                    'eq_desc'=>$eq_desc,
                    'eq_protocol'=>$eq_protocol,
                    'wc_id'=>$wc_id,
                    'eq_type_id'=>$eq_type_id,
                    'eq_model_id'=>$eq_model_id,
                    'image_file_name'=>$filePathDB,
                    'reason_code_arr' => $reason_codes
    );
  //  print_r($DataMarge);
    if($eq_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
       // echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Equipment Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Equipment Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Equipment Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $cond=' id='.$eq_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        //echo $sqlQuery;
        if(!$res) {
            $error="Equipment Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Equipment Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deleteEquipment'])){
    $eq_id=$_POST['eq_id'];
    $img=$_POST['img'];
    $delQ="DELETE FROM sfs_equipment WHERE id=".$eq_id;
    $result=mysqli_query($con,$delQ);// or die('Error:'.mysqli_error($con));
    if(!$result) {
        $error="This Equipment Code is used in onother table. First Clear dependancy.";
        $response['info']=$error;
        $response['infoRes']='E'; //Error
    }else {
        if(mysqli_errno() != 1062){
            $delPrevImg="../common/img/machine/".$img;
            unlink($delPrevImg);
            $response['info']="Record Deleted Successfully";
            $response['infoRes']="S"; // success
        }else{
            $error="This Equipment Code is used in onother table. First Clear dependancy.";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

/* End of Equipment DB Operations */


if(isset($_POST['saveEquipmentModel'])){
    $name=$_POST['model_name'];
    $num_of_di=$_POST['num_of_di'];
    $num_of_do=$_POST['num_of_do'];
    $num_of_ai=$_POST['num_of_ai'];
    $num_of_ao=$_POST['num_of_ao'];
    $model_id=$_POST['model_id'];
    $table = 'sfs_equipment_model';
    $DataMarge=array('name'=>$name,
                'num_of_di'=>$num_of_di,
                'num_of_do'=>$num_of_do,
                'num_of_ai'=>$num_of_ai,
                'num_of_ao'=>$num_of_ao
    );
    if($model_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Equipment Model Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Equipment Model Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Equipment Model Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $cond=' id='.$model_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        //echo $sqlQuery;
        if(!$res) {
            $error="Equipment Model Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Equipment Model Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}
if(isset($_POST['saveEquipmentType'])){
    $eq_type_id=$_POST['type_id'];
    $eq_type_desc=$_POST['eq_type_desc'];
    $is_machine=$_POST['is_machine'];
    $is_afs_size_id=$_POST['is_afs_size_id'];
    $is_dc_po=$_POST['is_dc_po'];
    $is_tool=$_POST['is_tool'];
    $table = 'sfs_equipment_type';
    $DataMarge=array('eq_type_desc'=>$eq_type_desc,
                      'is_machine'=>$is_machine,
                      'is_afs_size_id'=>$is_afs_size_id,
                      'is_dc_po'=>$is_dc_po,
                      'is_tool'=>$is_tool
    );
    if($eq_type_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery);
        if(!$res) {
            $error="Equipment Type Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Equipment Type Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Equipment Type Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $cond=' id='.$eq_type_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery);
        //echo $sqlQuery;
        if(!$res) {
            $error="Equipment Type Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Equipment Type Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            } 
        } 
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getEquipmentModel'])){
    $eqQ="SELECT id,name, num_of_di, num_of_do, num_of_ai, num_of_ao FROM sfs_equipment_model";
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($eqDetails)){
           $id=$row['id'];
           $model_name=$row['name'];
           $num_of_di=$row['num_of_di'];
           $num_of_do=$row['num_of_do'];
           $num_of_ai=$row['num_of_ai'];
           $num_of_ao=$row['num_of_ao'];
           
           $getEQData[]=array('id' =>"$id",
              'model_name' =>"$model_name",
              'num_of_di'  =>"$num_of_di",
              'num_of_do'  =>"$num_of_do",
              'num_of_ai'  =>"$num_of_ai",
              'num_of_ao'  =>"$num_of_ao"
           );
    }
    $status['models'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getEquipmentType'])){
    $eqQ="SELECT id,eq_type_desc, is_machine, is_afs_size_id, is_dc_po, is_tool FROM sfs_equipment_type";
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
        $id=$row['id'];
        $eq_type_desc=$row['eq_type_desc'];
        $is_machine=$row['is_machine'];
        $is_afs_size_id=$row['is_afs_size_id'];
        $is_dc_po=$row['is_dc_po'];
        $is_tool=$row['is_tool'];
        $getEQData[]=array('id' =>"$id",
            'is_machine' =>"$is_machine",
            'eq_type_desc' =>"$eq_type_desc",
            'is_afs_size_id' =>"$is_afs_size_id",
            'is_dc_po' =>"$is_dc_po",
            'is_tool' =>"$is_tool"
        ); 
    }
    $status['eqTypes'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getReasons'])){
    $eqQ="SELECT id,message FROM sfs_reason_code";
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
        $id=$row['id'];
        $message=$row['message'];
        $getEQData[]=array('id' =>"$id",
            'message' =>"$message"
        );
        
    }
    $status['reasons'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

?>