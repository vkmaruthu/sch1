<?php
require '../common/db.php';
require '../common/commonFunctions.php';
//require '../common/session.php';

/* ------------PO DB Operation --------------------- */

if(isset($_POST['savePO'])){
    
    $order_number=$_POST['order_number'];
    $material=$_POST['material_name'];
    $target_qty=$_POST['target_qty'];
    $line_feed_qty=$_POST['line_feed_qty'];
    $conf_no=$_POST['conf_no'];
    $operation=$_POST['operation'];
    $plant_id=$_POST['plantSave'];
    $po_id=$_POST['po_id'];
    
    $table = 'sfs_dc_po';
    if($po_id == ''){
        $DataMarge=array('order_number' => $order_number,
            'material'=>$material,
            'target_qty'=>$target_qty,
            'line_feed_qty'=>$line_feed_qty,
            'conf_no'=>$conf_no,
            'operation'=>$operation,
            'plant_id'=>$plant_id
        );
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        //echo $sqlQuery;
        if(!$res) {
            $error="Production Order Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Production Order Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Production Order Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }else{
        $DataMarge=array('material'=>$material,
            'target_qty'=>$target_qty,
            'line_feed_qty'=>$line_feed_qty,
            'conf_no'=>$conf_no
        );
        $cond=' id='.$po_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        //echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));
        if(!$res) {
            $error="Production Order Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Production Order Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getPODetails'])){
    $comp_id = $_POST['comp_id'];
    $plant_id=$_POST['plant_id'];
    
    if (($plant_id != "" && $plant_id != 0)) {
       $eqQ="SELECT dp.id, dp.operation, dp.order_number, dp.material, dp.target_qty, dp.line_feed_qty, dp.conf_no, dp.no_of_conf, 
                dp.conf_yield_count, dp.conf_scarp_count, dp.is_final_confirmed, dp.plant_id, dp.eq_code, p.descp, eq.descp as eq_desc
                FROM  sfs_dc_po dp LEFT JOIN  sfs_plant p on dp.plant_id=p.id 
                                   LEFT JOIN sfs_company c on c.id=p.comp_id
                                   LEFT JOIN sfs_equipment eq on dp.eq_code=eq.code
                WHERE c.id=p.comp_id and p.id=dp.plant_id and dp.plant_id=".$plant_id;
      }else {
        $eqQ="SELECT dp.id, dp.operation, dp.order_number, dp.material, dp.target_qty, dp.line_feed_qty, dp.conf_no, dp.no_of_conf, 
                dp.conf_yield_count, dp.conf_scarp_count, dp.is_final_confirmed, dp.plant_id, dp.eq_code, p.descp, eq.descp as eq_desc
                FROM  sfs_dc_po dp LEFT JOIN  sfs_plant p on dp.plant_id=p.id 
                                   LEFT JOIN sfs_company c on c.id=p.comp_id
                                   LEFT JOIN sfs_equipment eq on dp.eq_code=eq.code
                WHERE c.id=p.comp_id and p.id=dp.plant_id  and c.id=".$comp_id;
      }

    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
        $id=$row['id'];
        $order_number=$row['order_number'];
        $material=$row['material'];
        $target_qty=$row['target_qty'];
        $line_feed_qty=$row['line_feed_qty'];	
        $conf_no=$row['conf_no'];
        
        $operation=$row['operation'];
        $conf_count=$row['no_of_conf'];
        $conf_yield=$row['conf_yield_count'];
        $conf_scrap=$row['conf_scarp_count'];
        $is_final_confirmed=$row['is_final_confirmed'];
        $plant_desc=$row['descp'];
        $plantId=$row['plant_id'];
        $eq_code=$row['eq_code'];
        $eq_desc=$row['eq_desc'];
        
        $getEQData[]=array('id' =>"$id",
            'order_number' =>"$order_number",
            'material' =>"$material",
            'target_qty' => "$target_qty",
            'line_feed_qty' => "$line_feed_qty",
            'conf_no' => "$conf_no",
            'conf_count' =>"$conf_count",
            'conf_yield' =>"$conf_yield",
            'conf_scrap' => "$conf_scrap",
            'is_final_confirmed' => "$is_final_confirmed",
            'operation' => "$operation",
            'plant_id' => "$plantId",
            'plant_desc' => "$plant_desc",
            'eq_desc' => "$eq_desc",
            'eq_code' => "$eq_code"
        );
    }
    $status['poDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['deletePO'])){
    $po_id=$_POST['po_id'];
    $delQ="DELETE FROM sfs_dc_po WHERE id=".$po_id;
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
/* End of PO DB Operations */


if(isset($_POST['getOperation'])){
    
    $part_id=$_POST['part_id'];
    if ($part_id != '') {
        $eqQ="SELECT number, name, descp FROM sfs_tool_opr where part_fg_id=".$part_id;
    }
    $partsDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($partsDetails)){
        $opr_num=$row['number'];
        $opr_name=$row['name'];
        $opr_desc=$row['descp'];
        
        $getEQData[]=array('opr_num' =>"$opr_num",
            'opr_name' =>"$opr_name",
            'opr_desc' =>"$opr_desc"
        );
    }
    $status['oprDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['assignPO'])){   
    $po_num=$_POST['po_number'];
    $po_id=$_POST['po_assign_id'];
    $oper_no=$_POST['oper_no'];
    $lin_feed_qty=$_POST['lin_feed_qty'];
    $equi_code=$_POST['equi_code'];
    
    $table = 'sfs_dc_po';
    $DataMarge=array(
        'line_feed_qty'=>"$lin_feed_qty",
        'eq_code'=> "$equi_code"
    );
    if($po_id != '' && $equi_code !=''){
        $cond=' id='.$po_id." and order_number='".$po_num."' and operation='".$oper_no."'";
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond);
        //echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery);
        if(!$res) {
            $error="Equipment Already Assigned";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                $sqlQuery = "UPDATE sfs_equipment SET order_id=".$po_id." where eq_code='".$equi_code."'";
                $res=mysqli_query($con,$sqlQuery);
                $response['info']="Equipment Successfully Assigned To PO:".$po_num." Operation:".$oper_no;
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Equipment Already Assigned";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['stopPO'])){ 
    $po_num=$_POST['stop_po_number'];
    $po_id=$_POST['stop_po_assign_id'];
    $oper_no=$_POST['stop_oper_no'];
    $equi_code=$_POST['stop_equi_code'];
    $table = 'sfs_dc_po';
    if($po_id != ''){
        $cond=' id='.$po_id." and order_number='".$po_num."' and operation='".$oper_no."'";
        $sqlQuery = "UPDATE sfs_dc_po SET line_feed_qty=0, eq_code=null where ".$cond;
        // echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery); 
        if(!$res) {
            $error="Error in removing equipment";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                $sqlQuery = "UPDATE sfs_equipment SET order_id=0 where eq_code='".$equi_code."'";
                $res=mysqli_query($con,$sqlQuery);
                $response['info']="Equipment Removed Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Error in removing equipment";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['completePO'])){ 
    $po_num=$_POST['com_po_number'];
    $po_id=$_POST['com_po_assign_id'];
    $oper_no=$_POST['com_oper_no'];
    $equi_code=$_POST['com_equi_code'];
    $table = 'sfs_dc_po';
    if($po_id != ''){
        $cond=' id='.$po_id." and order_number='".$po_num."' and operation='".$oper_no."'";
        $sqlQuery = "UPDATE sfs_dc_po SET line_feed_qty=0, eq_code=null, is_final_confirmed=1 where ".$cond ;
        // echo $sqlQuery;
        $res=mysqli_query($con,$sqlQuery);
        if(!$res) {
            $error="Error in Completing the Production Order";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                $sqlQuery = "UPDATE sfs_equipment SET order_id=0 where eq_code='".$equi_code."'";
                $res=mysqli_query($con,$sqlQuery);
                $response['info']="Production Order completed Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Error in Completing the Production Order";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }
        
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}


    
?>