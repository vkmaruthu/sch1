<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';


/* ------------Reasons DB Operation --------------------- */

if(isset($_POST['tempData'])){
    $res=null;
    $plant_id=$_POST['plant_id'];
    $record_id=$_POST['record_id'];

    $selDate= explode("/",$_POST['userDateSel']);// getting only Dateval
    $requireDate= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];

    $cust_code=$_POST['cust_name'];
    $fg_code=$_POST['fg_code'];
    $total_qty=$_POST['total_qty'];
    $plan=$_POST['plan'];
    $urgent=$_POST['urgent'];
    $silicon=$_POST['silicon'];
    $remarks=$_POST['remarks'];
    $truepass=$_POST['truepass'];
    $plan_type=$_POST['plan_type'];

    if($urgent != ""){ $urgent = 1; }
    if($silicon != ""){ $silicon = 1; }
    if($truepass != ""){ $truepass = 1; }



    $getPrevRec="SELECT * FROM tb_m_jobcard WHERE cust_code=".$cust_code." and req_date='".$requireDate."' and fg_code='".$fg_code."'";
//echo  $getPrevRec;
    $resPrevRec=mysqli_query($con,$getPrevRec) or die('Error:'.mysqli_error($con));
    $rowcount=mysqli_num_rows($resPrevRec);

if($rowcount>1){
    $response['info']="Job Card Already Created.";
    $response['infoRes']="C"; // success
}else{
    
if($record_id == ''){

    $total_qtyTemp=$total_qty;
    $total_qtyTemp=(int)($total_qtyTemp*12);
    $numQty = (int)($total_qtyTemp)/2100;

    if($numQty>intval($numQty +.1)){
        $numQty=(intval($numQty) + 1);
    }
    
    for($i=1;$i<=$numQty;$i++){
        if($total_qtyTemp<=2100){
            $tQtyArr[]=$total_qtyTemp;
        }else{
            $tQtyArr[]=2100;
        }        
        $total_qtyTemp = intval($total_qtyTemp - 2100);
    }

    $getOrderNum ='SELECT batch_no FROM tb_o_plant WHERE plnt_code='.$plant_id;
    $resOrderNum=mysqli_query($con,$getOrderNum) or die('Error:'.mysqli_error($con));
        while ($row=mysqli_fetch_array($resOrderNum)){
            $order_number=$row['batch_no'];
        }  

    $UpdateOrderNum=null;
    $UpdateOrderNum=$order_number;
    $DataMarge= NULL;
  for($tq=0;$tq<sizeof($tQtyArr);$tq++){ 
        $UpdateOrderNum=($UpdateOrderNum+1);
        $DataMarge[]=array('plant_id'=>$plant_id,
            'batch_no'=>$UpdateOrderNum.'_'.sizeof($tQtyArr).'_'.($tq+1),
            'ord_qty'=>$tQtyArr[$tq],
            'remarks'=>$remarks,
            'req_date'=>$requireDate,            
            'urgent'=>$urgent,
            'siliconize'=>$silicon,            
            'plan'=>$plan,
            'cust_name'=>$customer_name,
            'mainTotalQty'=>$total_qty,
            'true_pass'=>$truepass,
            'plan'=>$plan_type
        );
    }

     // 'batch_no'=>$UpdateOrderNum.'_'.sizeof($tQtyArr).'_'.($tq+1),
     //        'fg_code'=>$fg_code,
     //        'ord_qty'=>$tQtyArr[$tq],
     //        'remarks'=>$remarks,
     //        'req_date'=>$requireDate,            
     //        'urgent'=>$urgent,
     //        'siliconize'=>$silicon,            
     //        'plan'=>$plan,
     //        'cust_code'=>$cust_code,
     //        'cust_name'=>$cust_name,
     //        'true_pass'=>$truepass,
     //        'plan_code'=>$plan_type,
     //        'total_qty'=>$totalQtyDozen,
        $response['info']="Record Created Successfully, Please Confirm !!";
        $response['infoRes']="T"; // success
        $response['mysqli_insert_id']=mysqli_insert_id($con);
        $response['tempData']=$DataMarge;
           
    }else{ // Edit Individual Record 
       
    }
}
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['saveJobCard'])){
    $res=null;
    $plant_id=$_POST['plant_id'];
    $record_id=$_POST['record_id'];

    $selDate= explode("/",$_POST['userDateSel']);// getting only Dateval
    $requireDate= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];

    $cust_code=$_POST['cust_name'];
    $customer_name=$_POST['customer_name'];
    $fg_code=$_POST['fg_code'];
    $total_qty=$_POST['total_qty'];
    $plan=$_POST['plan'];
    $urgent=$_POST['urgent'];
    $silicon=$_POST['silicon'];
    $remarks=$_POST['remarks'];
    $truepass=$_POST['truepass'];
    $plan_type=$_POST['plan_type'];

    if($urgent != ""){ $urgent = 1; } else { $urgent = 0;}
    if($silicon != ""){ $silicon = 1; } else { $silicon = 0;}
    if($truepass != ""){ $truepass = 1; } else { $truepass = 0;}


    $getPrevRec="SELECT * FROM tb_m_jobcard WHERE cust_code='".$cust_code."' and req_date='".$requireDate."' and fg_code='".$fg_code."'";

    $resPrevRec=mysqli_query($con,$getPrevRec) or die('Error:'.mysqli_error($con));
    $rowcount=mysqli_num_rows($resPrevRec);

if($rowcount>1){
    $response['info']="Job Card Already Created.";
    $response['infoRes']="C"; // success
}else{
    
if($record_id == ''){

    $total_qtyTemp=$total_qty;
    $total_qtyTemp=(int)($total_qtyTemp*12);
    $totalQtyDozen=(int)($total_qty*12);
    $numQty = (int)($total_qtyTemp)/2100;

    if($numQty>intval($numQty +.1)){
        $numQty=(intval($numQty) + 1);
    }
    
    for($i=1;$i<=$numQty;$i++){
        if($total_qtyTemp<=2100){
            $tQtyArr[]=$total_qtyTemp;
        }else{
            $tQtyArr[]=2100;
        }        
        $total_qtyTemp = intval($total_qtyTemp - 2100);
    }

    $getOrderNum ='SELECT batch_no FROM tb_o_plant WHERE plnt_code='.$plant_id;
    $resOrderNum=mysqli_query($con,$getOrderNum) or die('Error:'.mysqli_error($con));
        while ($row=mysqli_fetch_array($resOrderNum)){
            $order_number=$row['batch_no'];
        }  
    $UpdateOrderNum=null;
    $UpdateOrderNum=$order_number;
  for($tq=0;$tq<sizeof($tQtyArr);$tq++){
    $UpdateOrderNum=(int)($UpdateOrderNum + 1);
        $DataMarge=null;        
        $table = 'tb_m_jobcard';
        $DataMarge=array('plnt_code'=>$plant_id,           
            'batch_no'=>$UpdateOrderNum.'_'.sizeof($tQtyArr).'_'.($tq+1),
            'fg_code'=>$fg_code,
            'ord_qty'=>$tQtyArr[$tq],
            'remarks'=>$remarks,
            'req_date'=>$requireDate,            
            'urgent'=>$urgent,
            'siliconize'=>$silicon,            
            'plan'=>$plan,
            'cust_code'=>$cust_code,
            'cust_name'=>$customer_name,
            'true_pass'=>$truepass,
            'plan_code'=>$plan_type,
            'total_qty'=>$totalQtyDozen,
        );

    $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
    $res=mysqli_query($con,$sqlQuery);

  }
    
        if(!$res) {
            $error="Record Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){

            $upOrder='UPDATE tb_o_plant SET batch_no ='.$UpdateOrderNum.' WHERE plnt_code ='.$plant_id;
            mysqli_query($con,$upOrder);
  

// Write a Update Code for tb_t_job_status

            $jobStatus ="SELECT * FROM tb_m_jobcard j, tb_m_fg_opr fo WHERE j.fg_code=fo.fg_code and j.fg_code='".$fg_code."' and fo.oper_code=10 LIMIT 1";
            $jobStatusRes=mysqli_query($con,$jobStatus) or die('Error:'.mysqli_error($con));
            $jobRow=mysqli_fetch_array($jobStatusRes);
            //echo $jobRow['wrk_ctr_desc'];

            $getPrevRec1="SELECT * FROM tb_m_jobcard WHERE cust_code='".$cust_code."' 
            and req_date='".$requireDate."' and fg_code='".$fg_code."'";
            $resPrevRec1=mysqli_query($con,$getPrevRec1) or die('Error:'.mysqli_error($con));
            while ($row=mysqli_fetch_array($resPrevRec1)){
                $batch_no=$row['batch_no'];

                $batch_noArr[] = $batch_no;
            } 
            // print_r($batch_noArr);

            for($tq=0;$tq<sizeof($batch_noArr);$tq++){
                    $table = 'tb_t_job_status';
                    $DataMarge=array('batch_no'=>$batch_noArr[$tq],           
                        'from_dept'=>"NULL",
                        'from_dept_desc'=>"NULL",
                        'from_mach'=>"NULL",
                        'from_mach_desc'=>"NULL",            
                        'to_dept'=>$jobRow['wrk_ctr_code'],
                        'to_dept_desc'=>$jobRow['wrk_ctr_desc'],            
                        'to_mach'=>"NULL",
                        'to_mach_desc'=>"NULL",
                        'emp_id'=>"NULL",
                        'status_code'=>801,
                        'oper_code'=>$jobRow['oper_code'],
                        'created_at'=>"NULL",
                        'updated_at'=>"NULL",
                );
                // Function say generate complete query
                $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); 
               // echo $sqlQuery;
                $res=mysqli_query($con,$sqlQuery);
            }

            //die();

                $response['info']="Record Created Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Record Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
        }



    }else{ // Edit Individual Record 
      /*  $DataMarge=array('id'=>$reason_code_no,
            'reason_type_id'=>$reason_type_id,
            'message'=>$message,
            'color_code'=>$color_code
        );
        $cond=' id='.$reason_id;
        $sqlQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery);
        //echo $sqlQuery;
        if(!$res) {
            $error="Record Code Already Exists";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }else {
            if(mysqli_errno() != 1062){
                move_uploaded_file($file_tmps,$filePath);
                $response['info']="Record Updated Successfully";
                $response['infoRes']="S"; // success
                $response['mysqli_insert_id']=mysqli_insert_id($con);
            }else{
                $error="Record Code Already Exists";
                $response['info']=$error;
                $response['infoRes']='E'; //Error
            }
            
        }*/
        
    }
}    
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}



if(isset($_POST['getJobPoDetails'])){
   
    $plant_id=$_POST['plant_id'];

    $customer_code=$_POST['customer_code'];
   
    $selDate= explode("/",$_POST['requireDate']);// getting only Dateval
    $requireDate= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];

    $size_fg=$_POST['size_fg'];
    
    if($plant_id != "" && $plant_id != 0) {
        $condition = " jc.plnt_code=".$plant_id." AND jc.cust_code='".$customer_code."' 
         AND jc.req_date='".$requireDate."' AND jc.fg_code='".$size_fg."'";
    }     
      $eqQ="SELECT batch_no,plnt_code,fg_code,cust_code,cust_name,plan,plan_code,
    ord_qty,total_qty,req_date,urgent,siliconize,true_pass,remarks FROM tb_m_jobcard jc 
    WHERE ".$condition;

//echo $eqQ;

    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
         $batch_no=$row['batch_no'];
         $plnt_code=$row['plnt_code'];
         $fg_code=$row['fg_code'];
         $cust_code=$row['cust_code'];
         $cust_name=$row['cust_name'];
         $plan=$row['plan'];
         $plan_code=$row['plan_code'];
         $ord_qty=$row['ord_qty'];
         $total_qty=$row['total_qty'];
         $req_date=$row['req_date'];
         $urgent=$row['urgent'];
         $siliconize=$row['siliconize'];
         $true_pass=$row['true_pass'];
         $remarks=$row['remarks'];

         $getEQData[]=array('batch_no' =>$batch_no,
                            'plnt_code' =>$plnt_code,
                            'fg_code' =>$fg_code,
                            'cust_code' =>$cust_code,
                            'cust_name' =>$cust_name,
                            'plan' =>$plan,
                            'plan_code' =>$plan_code,
                            'ord_qty' =>$ord_qty,
                            'total_qty' =>$total_qty,
                            'req_date' =>$req_date,
                            'urgent' =>$urgent,
                            'siliconize' =>$siliconize,
                            'true_pass' =>$true_pass,
                            'remarks' =>$remarks,
                            );
    }
    $status['jobPoDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getCustomerDetails'])){
    $plant_code=$_POST['plant_id'];

    $eqQ="SELECT cust_code, cust_name FROM tb_m_customer";
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($eqDetails)){
           $cust_code=$row['cust_code'];
           $cust_name=$row['cust_name'];
           $getCuData[]=array('cust_code' =>$cust_code,
                              'cust_name' =>$cust_name
                             );
        
    }
    $status['custData'] = $getCuData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getPlanTypeDetails'])){
    $plant_id=$_POST['plant_id'];

    $eqQ="SELECT plan_code, plan_desc FROM tb_m_plan_type";
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($eqDetails)){
           $plan_code=$row['plan_code'];
           $plan_desc=$row['plan_desc'];
           $getPlanData[]=array('plan_code' =>"$plan_code",
                                'plan_desc' => "$plan_desc"
                                );
        
    }
    $status['planData'] = $getPlanData;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getSizeFgDetails'])){
    $plant_code=$_POST['plant_id'];

    $eqQ="SELECT fg_code,fg_desc FROM tb_m_fg WHERE plnt_code=".$plant_code;
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    
    while ($row=mysqli_fetch_array($eqDetails)){
           $fg_code=$row['fg_code'];
           $fg_descp=$row['fg_desc'];
           $getCuData[]=array('fg_code' =>"$fg_code",
                              'fg_descp' => "$fg_descp"
                              );
        
    }
    $status['sizeFgData'] = $getCuData;
    echo json_encode($status);
    mysqli_close($con);
}

// Search Job Card
if(isset($_POST['getSearchData'])){
   
    $plant_id=$_POST['plant_id'];
    $customer_code=$_POST['customer_name'];
    $size=$_POST['size_fg'];
       
    $s_to= explode("/",$_POST['s_to']);// getting only Dateval
    $s_to= $s_to[2].'-'.$s_to[1].'-'.$s_to[0];

    $s_from= explode("/",$_POST['s_from']);// getting only Dateval
    $s_from= $s_from[2].'-'.$s_from[1].'-'.$s_from[0];
// echo $customer_code;
// echo $plant_id;
// echo $size;
// die;
    if($customer_code != '0' && $size != 0) {
        $condition = " jc.plnt_code=".$plant_id." AND jc.cust_code='".$customer_code."' 
         AND jc.req_date BETWEEN '".$s_from."' AND '".$s_to."'  AND jc.part_fg_id=".$size;
    }else if($customer_code != '0'){
        $condition = " jc.plnt_code=".$plant_id." AND jc.cust_code='".$customer_code."' 
         AND jc.req_date BETWEEN '".$s_from."' AND '".$s_to."'";
    }else if($size != 0){
        $condition = " jc.plnt_code=".$plant_id." 
         AND jc.req_date BETWEEN '".$s_from."' AND '".$s_to."'  AND jc.part_fg_id=".$size;
    }else{
        $condition = " jc.plnt_code=".$plant_id." 
         AND jc.req_date BETWEEN '".$s_from."' AND '".$s_to."' ";
    }  

    $eqQ="SELECT batch_no,plnt_code,fg_code,cust_code,cust_name,plan,plan_code,
    ord_qty,total_qty,req_date,urgent,siliconize,true_pass,remarks FROM tb_m_jobcard jc 
    WHERE ".$condition;
//." group by req_date"
//echo $eqQ;

    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
         $batch_no=$row['batch_no'];
         $plnt_code=$row['plnt_code'];
         $fg_code=$row['fg_code'];
         $cust_code=$row['cust_code'];
         $cust_name=$row['cust_name'];
         $plan=$row['plan'];
         $plan_code=$row['plan_code'];
         $ord_qty=$row['ord_qty'];
         $total_qty=$row['total_qty'];
         $req_date=$row['req_date'];
         $urgent=$row['urgent'];
         $siliconize=$row['siliconize'];
         $true_pass=$row['true_pass'];
         $remarks=$row['remarks'];

         $getEQData[]=array('batch_no' =>$batch_no,
                            'plnt_code' =>$plnt_code,
                            'fg_code' =>$fg_code,
                            'cust_code' =>$cust_code,
                            'cust_name' =>$cust_name,
                            'plan' =>$plan,
                            'plan_code' =>$plan_code,
                            'ord_qty' =>$ord_qty,
                            'total_qty' =>$total_qty,
                            'req_date' =>$req_date,
                            'urgent' =>$urgent,
                            'siliconize' =>$siliconize,
                            'true_pass' =>$true_pass,
                            'remarks' =>$remarks,
                            );
    }
    
    $status['jobPoDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}
// Search Job Card with id and other
if(isset($_POST['getViewJobCardData'])){
   
    $plant_id=$_POST['plant_id'];
    $customer_code=$_POST['customer_code'];   
    $requireDate= $_POST['requireDate'];
    $size_fg=$_POST['size_fg'];
    
    if($plant_id != "" && $plant_id != 0) {
        $condition = " jc.plnt_code=".$plant_id." AND jc.cust_code='".$customer_code."' 
         AND jc.req_date='".$requireDate."' AND jc.fg_code='".$size_fg."'";
    }     
       $eqQ="SELECT batch_no,plnt_code,fg_code,cust_code,cust_name,plan,plan_code,
    ord_qty,total_qty,req_date,urgent,siliconize,true_pass,remarks FROM tb_m_jobcard jc 
    WHERE ".$condition;

//echo $eqQ;

    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
         $batch_no=$row['batch_no'];
         $plnt_code=$row['plnt_code'];
         $fg_code=$row['fg_code'];
         $cust_code=$row['cust_code'];
         $cust_name=$row['cust_name'];
         $plan=$row['plan'];
         $plan_code=$row['plan_code'];
         $ord_qty=$row['ord_qty'];
         $total_qty=$row['total_qty'];
         $req_date=$row['req_date'];
         $urgent=$row['urgent'];
         $siliconize=$row['siliconize'];
         $true_pass=$row['true_pass'];
         $remarks=$row['remarks'];

         $getEQData[]=array('batch_no' =>$batch_no,
                            'plnt_code' =>$plnt_code,
                            'fg_code' =>$fg_code,
                            'cust_code' =>$cust_code,
                            'cust_name' =>$cust_name,
                            'plan' =>$plan,
                            'plan_code' =>$plan_code,
                            'ord_qty' =>$ord_qty,
                            'total_qty' =>$total_qty,
                            'req_date' =>$req_date,
                            'urgent' =>$urgent,
                            'siliconize' =>$siliconize,
                            'true_pass' =>$true_pass,
                            'remarks' =>$remarks,
                            );
    }
    
    $status['jobPoDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}


?>