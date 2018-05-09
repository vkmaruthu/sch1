<?php 
    require 'db.php';
    require 'commonFunctions.php';
    //require '../common/session.php';

if(isset($_POST['userDetails'])){

    $userMail=$_POST['userMail']; 

    $eqQ="SELECT su.first_name as first_name,su.last_name as last_name, su.email_id as email_id, su.contact_number as contact_number, su.img_file_name as img_file_name, su.roles_id as roles_id,sr.name as rolename, sr.company_id as company_id, sr.plant_id as plant_id ,sr.screen_access as screen_access, sr.access_rights as access_rights,sc.descp as compName,sc.image_file_name as compImg  from sfs_user su, sfs_roles sr, sfs_company sc where su.roles_id=sr.id and sr.company_id = sc.id and su.email_id='".$userMail."'";

    
    $userDetailRes=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
   // echo $eqQ;
    while ($row=mysqli_fetch_array($userDetailRes)){
        $first_name=$row['first_name'];
        $last_name=$row['last_name'];
        $email_id=$row['email_id'];
        $contact_number=$row['contact_number'];
        $img_file_name=$row['img_file_name'];
        $roles_id=$row['roles_id'];
        $rolename=$row['rolename'];
        $company_id=$row['company_id'];
        $plant_id=$row['plant_id'];
        $screen_access=$row['screen_access'];
        $access_rights=$row['access_rights'];
        $compName=$row['compName'];
        $compImg=$row['compImg'];


        $q="select ui_tag_id from sfs_screens where id IN(".$screen_access.")";
        $res=mysqli_query($con,$q) or die('Error:'.mysqli_error($con));
        while ($row=mysqli_fetch_array($res)){
            $screenArr[]=$row['ui_tag_id'];
        }

        $screenQ="select ui_tag_id from sfs_screens";
        $screenRes=mysqli_query($con,$screenQ) or die('Error:'.mysqli_error($con));
        while ($row=mysqli_fetch_array($screenRes)){
            $allScreenArr[]=$row['ui_tag_id'];
        }



        $getData=array('first_name' =>"$first_name",
                        'last_name' =>"$last_name",
                        'email_id' =>"$email_id",
                        'contact_number' =>"$contact_number",
                        'img_file_name' =>"$img_file_name",
                        'roles_id' =>"$roles_id",
                        'rolename' =>"$rolename",
                        'company_id' =>"$company_id",
                        'plant_id' =>"$plant_id",
                        'screen_access' =>"$screen_access",
                        'access_rights' =>"$access_rights",
                        'compName' =>"$compName",
                        'compImg' =>"$compImg",
                     );
        
    }
    $status['userDetails'] = $getData;
    $status['screenArr'] = $screenArr;
    $status['allScreenArr'] = $allScreenArr;
    echo json_encode($status);
    mysqli_close($con);
}

?>