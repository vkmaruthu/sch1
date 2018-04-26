<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';


/*---------------------------------------------------- Screens---------------------------------------------------- */

if(isset($_POST['saveScreen'])){
      
    $recordId=$_POST['record_id'];
    $ui_tag_id=$_POST['ui_tag_id'];
    $screenName=$_POST['screenName'];
    $screen_descp=$_POST['screen_descp'];
    
    $table = 'sfs_screens';
    $DataMarge=array('ui_tag_id'=>$ui_tag_id,
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
    $screenQ="SELECT id,ui_tag_id,name,descp FROM sfs_screens";
    $screenDetails=mysqli_query($con,$screenQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($screenDetails)){
        $id=$row['id'];
        $ui_tag_id=$row['ui_tag_id'];
        $name=$row['name'];
        $descp=$row['descp'];

        $getEQData[]=array('id' =>"$id",
            'ui_tag_id' =>"$ui_tag_id",
            'screenName' =>"$name",
            'screen_descp' => "$descp",
        );
        
    }
    
    $status['screenDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}


/*------------------------------------------- Roles---------------------------------------------------- */

if(isset($_POST['saveRoles'])){
      
    $recordId=$_POST['recordId'];
    $roleName=$_POST['roleName'];
    $roleDesc=$_POST['roleDesc'];
    $companyName=$_POST['companyName'];
    $plantName=$_POST['plantName'];
    $screens=implode(',',$_POST['screens']);
    $accessMode=$_POST['accessMode'];
    
    $table = 'sfs_roles';

   // $val=;
    if($companyName==0){
          $DataMarge=array('name'=>$roleName,
                     'descp'=>$roleDesc,
                     'screen_access'=>$screens,
                     'access_rights'=>$accessMode,
                     'company_id'=>'NULL',
                     'plant_id'=>'NULL'
                    );
    }else if($plantName==0) {
        $DataMarge=array('name'=>$roleName,
                     'descp'=>$roleDesc,
                     'company_id'=>$companyName,
                     'screen_access'=>$screens,
                     'access_rights'=>$accessMode,
                     'plant_id'=>'NULL'
                    );
    }
    else{
        $DataMarge=array('name'=>$roleName,
                     'descp'=>$roleDesc,
                     'company_id'=>$companyName,
                     'plant_id'=>$plantName,
                     'screen_access'=>$screens,
                     'access_rights'=>$accessMode,
                    );
    }

 // print_r($DataMarge);

    if($recordId == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query        $
        $res=mysqli_query($con,$sqlQuery) or die('Error: ' . mysqli_error($con));
        
        if(!$res) {
            $error="Role Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Role Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Role Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $cond=' id='.$recordId;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
       // echo $sqlQuery; die();
        $res=mysqli_query($con,$sqlQuery) or die('Error: ' . mysqli_error($con));

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



if(isset($_POST['roleTable'])){
      
    $comp_id=$_POST['filterComp'];
    $plant_id=$_POST['filterPlant'];

    if($comp_id!=0 && $plant_id!=0){
      $screenQ="SELECT sr.id,sr.name as role,sr.descp,sr.company_id,sr.plant_id,sc.descp as compName,sp.descp as PlantName,sr.screen_access,sr.access_rights  FROM sfs_roles sr,sfs_company sc,sfs_plant sp where sr.company_id=".$comp_id." and sr.plant_id=".$plant_id." GROUP BY name";
    }elseif($comp_id!=0){
      //$screenQ="SELECT sr.id,sr.name as role,sr.descp,sr.company_id,sr.plant_id,sc.descp as compName,sp.descp as PlantName,sr.screen_access,sr.access_rights FROM sfs_roles sr,sfs_company sc,sfs_plant sp where sr.company_id=".$comp_id." GROUP BY name";
      $screenQ="SELECT sr.id,sr.name as role,sr.descp,sr.company_id,sr.plant_id,sc.descp as compName,sr.screen_access,sr.access_rights FROM sfs_roles sr,sfs_company sc where sr.company_id=".$comp_id." GROUP BY name";
    }else{
      $screenQ="SELECT sr.id,sr.name as role,sr.descp,sr.company_id,sr.plant_id,sc.descp as compName,sp.descp as PlantName,sr.screen_access,sr.access_rights FROM sfs_roles sr  LEFT JOIN sfs_company sc ON sc.id = sr.company_id
        LEFT JOIN sfs_plant sp  ON sp.id = sr.plant_id";
    }
    
    //echo $screenQ;
    $screenDetails=mysqli_query($con,$screenQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($screenDetails)){
        $id=$row['id'];
        $roleName=$row['role'];
        $descp=$row['descp'];
        $compName=$row['compName'];
        $plantName=$row['PlantName'];
        $screen_access=$row['screen_access'];
        $access_rights=$row['access_rights'];
        $company_id=$row['company_id'];
        $plant_id=$row['plant_id'];

        $q="select name from sfs_screens where id IN(".$screen_access.")";
        $res=mysqli_query($con,$q) or die('Error:'.mysqli_error($con));
        while ($row=mysqli_fetch_array($res)){
            $name=$row['name'];
            $strMsg.=$name.', ';
        }

        $getRoleData[]=array('id' =>"$id",
            'name' =>"$roleName",
            'descp' =>"$descp",
            'companyName' => "$compName",
            'plantName' => "$plantName",
            'screen_access' => "$strMsg",
            'screen_access_arr' => "$screen_access",
            'plant_id' => "$plant_id",
            'company_id' => "$company_id",
            'access_rights' => "$access_rights"
        );    
        $strMsg='';    
    }
    
    $status['rolesDetails'] = $getRoleData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deleteRoles'])){
  $record_id=$_POST['recordId'];

  $comQ="DELETE FROM sfs_roles WHERE id=".$record_id;
  $delRecord=mysqli_query($con,$comQ) or die('Error:'.mysqli_error($con));

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



/*------------------------------------------- User ---------------------------------------------------- */

if(isset($_POST['saveUser'])){
      
    $recordId=$_POST['record_id'];
    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $emailId=$_POST['emailId'];
    $password=$_POST['password'];
    $contactNumber=$_POST['contactNumber'];
    $userRole=$_POST['userRole'];
    $img_id=$_POST['img_id'];

    $file_names = $_FILES['img_file_name']['name'];
    $file_sizes =$_FILES['img_file_name']['size'];
    $file_tmps =$_FILES['img_file_name']['tmp_name'];
    $file_types=$_FILES['img_file_name']['type'];


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

      $delPrevImg="../common/img/user_img/".$img_id; 
      unlink($delPrevImg); 
      $filePathDB=$userRole."_".rand().".".$extension;      
      $filePath="../common/img/user_img/".$filePathDB;
    }

    $table = 'sfs_user';
    $DataMarge=array('first_name'=>$firstName,
                     'last_name'=>$lastName,
                     'password'=>$password,
                     'email_id'=>$emailId,
                     'contact_number'=>$contactNumber,
                     'roles_id'=>$userRole,
                     'img_file_name'=>$filePathDB,
    );

    if($recordId == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));  

        if(!$res) {
            $error="User Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
              move_uploaded_file($file_tmps,$filePath);
              $response['info']="User Created Successfully";
              $response['infoRes']="S"; // success
              $response['mysqli_insert_id']=mysqli_insert_id($con);     
            }else{
                $error="User Already Exists";
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
            $error="User Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
              move_uploaded_file($file_tmps,$filePath);
              $response['info']="User Updated Successfully";
              $response['infoRes']="S"; // success
              $response['mysqli_insert_id']=mysqli_insert_id($con);     
            }else{
                $error="User Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
         
        }

      } 

    $status['userData'] = $response;     
    echo json_encode($status);
    mysqli_close($con);
}



if(isset($_POST['deleteUser'])){
  $record_id=$_POST['record_id'];

  $comQ="DELETE FROM sfs_user WHERE id=".$record_id;
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

if(isset($_POST['deactiveUser'])){
  $record_id=$_POST['record_id'];

  $comQ="UPDATE sfs_user SET is_active = 0 WHERE id=".$record_id;
  $deactiveRecord=mysqli_query($con,$comQ); //or die('Error:'.mysqli_error($con));

        if(!$deactiveRecord) {
            $error="Please Try again later";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){

              $response['info']="User Deactivated Successfully";
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

if(isset($_POST['activeUser'])){
  $record_id=$_POST['record_id'];

  $comQ="UPDATE sfs_user SET is_active = 1 WHERE id=".$record_id;
  $activeRecord=mysqli_query($con,$comQ); //or die('Error:'.mysqli_error($con));

        if(!$activeRecord) {
            $error="Please Try again later";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){

              $response['info']="User Activated Successfully";
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


if(isset($_POST['checkValidEmail'])){
  $emailId=$_POST['emailId'];
  $comp_id=$_POST['comp_id'];

  $comQ="SELECT su.name FROM sfs_user su, sfs_roles sr where sr.id=su.roles_id and su.email_id='".$emailId."' and sr.company_id=".$comp_id;
  $validEmail=mysqli_query($con,$comQ); //or die('Error:'.mysqli_error($con));

        if(!$validEmail) {
            $error="Please Try again later";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
              //$response['info']="User Activated Successfully";
              $rowcount=mysqli_num_rows($validEmail);
              if($rowcount>0){
                 $response['infoRes']=1; // found records 
              }else{
                 $response['infoRes']=0; // no records 
              } 
               
            }else{
                $error="Please Try again later";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
         
        }
    $status['validData'] = $response;     
    echo json_encode($status);
    mysqli_close($con);
}



if(isset($_POST['getUserRoleDropdown'])){
  $comp_id=$_POST['comp_id'];

    $screenQ="SELECT id,name,descp,screen_access FROM sfs_roles where company_id=".$comp_id;
    $roleDetails=mysqli_query($con,$screenQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($roleDetails)){
        $id=$row['id'];
        $name=$row['name'];
        $descp=$row['descp'];
        $screen_access=$row['screen_access'];

        $getEQData[]=array('id' =>"$id",
                           'roleName' =>"$name",
                           'descp' =>"$descp",
                           'screen_access' =>"$screen_access"
                          );
        
    }
    
    $status['roleDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['userTable'])){
  $comp_id=$_POST['comp_id'];

    if($comp_id!=0){
        $screenQ="SELECT su.id as id,su.name as name, su.first_name as first_name, su.last_name as last_name, su.password as password, su.email_id as email_id, su.contact_number as contact_number, su.is_active as is_active, su.img_file_name as img_file_name,sr.name as roleName,sr.id as roleId,sc.id as compId,sc.descp as compName,sp.descp as plantName 
            FROM sfs_user su 
            LEFT JOIN sfs_roles sr ON sr.id = su.roles_id  
            LEFT JOIN sfs_plant sp ON sp.id = sr.plant_id 
            LEFT JOIN sfs_company sc ON sc.id=sr.company_id
            where sr.company_id =".$comp_id;
    }else{
          $screenQ="SELECT su.id as id,su.name as name, su.first_name as first_name, su.last_name as last_name, su.password as password, su.email_id as email_id, su.contact_number as contact_number, su.is_active as is_active, su.img_file_name as img_file_name,sr.name as roleName,sr.id as roleId,sc.id as compId,sc.descp as compName,sp.descp as plantName 
            FROM sfs_user su  
            LEFT JOIN sfs_roles sr ON sr.id = su.roles_id  
            LEFT JOIN sfs_plant sp ON sp.id = sr.plant_id 
            LEFT JOIN sfs_company sc ON sc.id=sr.company_id";
    }

    $roleDetails=mysqli_query($con,$screenQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($roleDetails)){
        $id=$row['id'];
        $name=$row['name'];
        $first_name=$row['first_name'];
        $last_name=$row['last_name'];
        $email_id=$row['email_id'];
        $contact_number=$row['contact_number'];
        $is_active=$row['is_active'];
        $img_file_name=$row['img_file_name'];
        $roleName=$row['roleName'];
        $roleId=$row['roleId'];
        $compName=$row['compName'];
        $plantName=$row['plantName'];
        $password=$row['password'];
        $compId=$row['compId'];

        $getRoleTable[]=array('id' =>"$id",
                           'name' =>"$name",
                           'first_name' =>"$first_name",
                           'last_name' =>"$last_name",
                           'email_id' =>"$email_id",
                           'contact_number' =>"$contact_number",
                           'is_active' =>"$is_active",
                           'img_file_name' =>"$img_file_name",
                           'roleName' =>"$roleName",
                           'roleId' =>"$roleId",
                           'compName' =>"$compName",
                           'plantName' =>"$plantName",
                           'password' =>"$password",
                           'compId' =>"$compId",
                          );
        
    }
    
    $status['userDetails'] = $getRoleTable;
    echo json_encode($status);
    mysqli_close($con);
}

?>