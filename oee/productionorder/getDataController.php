<?php
require '../common/db.php';
require '../common/commonFunctions.php';
//require '../common/session.php';

/* ------------PO DB Operation --------------------- */

if(isset($_POST['savePO'])){
    
    $order_number=$_POST['order_number'];
    $material=$_POST['material'];
    $target_qty=$_POST['target_qty'];
    $line_feed_qty=$_POST['line_feed_qty'];
    $conf_no=$_POST['conf_no'];
    $operation=$_POST['operation'];
    $workcenter_id=$_POST['workcenter_id'];
    $po_id=$_POST['po_id'];
    
    $table = 'sfs_dc_po';
    $DataMarge=array('order_number'=>$order_number,
        'material'=>$material,
        'target_qty'=>$target_qty,
        'line_feed_qty'=>$line_feed_qty,
        'conf_no'=>$conf_no,
        'operation'=>$operation,
        'workcenter_id'=>$workcenter_id
    );
    
    if($po_id == ''){
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery); //or die('Error: ' . mysqli_error($con));

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
        $cond=' id='.$po_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
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
    $plant_id=$_POST['plant_id'];
    $wc_id=$_POST['wc_id'];
    
    if (($plant_id != "" && $plant_id != 0) && ($wc_id != "" && $wc_id != 0)) {
       $eqQ="SELECT dp.id, dp.operation, dp.order_number, dp.material, dp.target_qty, dp.line_feed_qty, dp.conf_no, dp.conf_count, dp.conf_yield,
        dp.conf_scrap, dp.is_final_confirmed, dp.workcenter_id, wc.descp FROM sfs_dc_po dp, sfs_workcenter wc where dp.workcenter_id=wc.id and wc.id=".$wc_id;
    }else {
        $eqQ="SELECT dp.id, dp.operation, dp.order_number, dp.material, dp.target_qty, dp.line_feed_qty, dp.conf_no, dp.conf_count, dp.conf_yield,
        dp.conf_scrap, dp.is_final_confirmed, dp.workcenter_id, wc.descp FROM sfs_dc_po dp, sfs_workcenter wc where dp.workcenter_id=wc.id";
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
        $conf_count=$row['conf_count'];
        $conf_yield=$row['conf_yield'];
        $conf_scrap=$row['conf_scrap'];
        $is_final_confirmed=$row['is_final_confirmed'];
        $workcenter_id=$row['workcenter_id'];
        $wc_desc=$row['descp'];
        
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
            'workcenter_id' => "$workcenter_id",
            'operation' => "$operation",
            'wc_desc' => "$wc_desc"
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

    
?>