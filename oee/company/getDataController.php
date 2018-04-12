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

 


if(isset($_POST['saveCompany'])){

$comp_id=$_POST['comp_id'];
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
    $DataMarge=array('comp_code'=>$comp_code,
                  'comp_desc'=>$comp_desc,
                  'contact_person'=>$contact_person,
                  'contact_number'=>$contact_number,
                  'address'=>$address,
                  'image_file_name'=>$filePathDB
                );

      if($comp_id == ''){

        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
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
              $response['infoRes']="S"; // success
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


if(isset($_POST['getCompDetails'])){
    $comp_id=$_POST['comp_id'];  // It will use when its calling from Plants, Workcenter, Machine.
    
    if($comp_id != ''){
       $comQ="SELECT id,comp_code,comp_desc,address,contact_person,contact_number,image_file_name FROM sfs_company where id=".$comp_id;
    }else{
       $comQ="SELECT id,comp_code,comp_desc,address,contact_person,contact_number,image_file_name FROM sfs_company";
    }
    $comDetails=mysqli_query($con,$comQ) or die('Error:'.mysqli_error($con));

    while ($row=mysqli_fetch_array($comDetails)){ 
         $id=$row['id']; 
         $comp_code=$row['comp_code']; 
         $comp_desc=$row['comp_desc']; 
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

if(isset($_POST['deleteCompany'])){
  $comp_id=$_POST['comp_id'];
  $img=$_POST['img'];


  $comQ="DELETE FROM sfs_company WHERE id=".$comp_id;
  $delComp=mysqli_query($con,$comQ); //or die('Error:'.mysqli_error($con));

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
    $status['data'] = $response;     
    echo json_encode($status);
    mysqli_close($con);
}

/* ------------Plant DB Operation --------------------- */

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
    $DataMarge=array('plant_code'=>$plant_code,
        'plant_desc'=>$plant_desc,
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

if(isset($_POST['getPlantDetails'])){
    $comp_id=$_POST['comp_id'];
    $plantQ="SELECT id,plant_code,plant_desc,address,contact_person,contact_number,image_file_name, comp_id FROM sfs_plant where comp_id=".$comp_id;
    
    $plantDetails=mysqli_query($con,$plantQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($plantDetails)){
        $id=$row['id'];
        $comp_code=$row['plant_code'];
        $comp_desc=$row['plant_desc'];
        $address=$row['address'];
        $contact_person=$row['contact_person'];
        $contact_number=$row['contact_number'];
        $image_file_name=$row['image_file_name'];
        $comp_id=$row['comp_id'];
        
        $getCompData[]=array('id' =>"$id",
            'plant_code' =>"$comp_code",
            'plant_desc' =>"$comp_desc",
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
    
if(isset($_POST['deletePlant'])){
    $plant_id=$_POST['plant_id'];
    $img=$_POST['img'];
    
    
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
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}
/* End Plant DB Operations */


?>