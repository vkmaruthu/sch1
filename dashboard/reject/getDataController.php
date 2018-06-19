<?php
require '../common/db.php';
require '../common/commonFunctions.php';
//require '../common/session.php';

/* ------------PO DB Operation --------------------- */

if(isset($_POST['insertRej'])){
    
    $start_time=$_POST['start_time'];
    $end_time=$_POST['end_time'];
    $count=$_POST['count'];
    $quality_codes_id=$_POST['quality_codes_id'];
    $data_info_id=$_POST['data_info_id'];
    
    $table = 'sfs_data';
    if($data_info_id != ''){
        $DataMarge=array('start_time' => $start_time,
            'end_time' => $end_time,
            'count' => $count,
            'quality_codes_id' => $quality_codes_id,
            'data_info_id' => $data_info_id
        );
        $sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
        $res=mysqli_query($con,$sqlQuery);// or die('Error: ' . mysqli_error($con));
        if(mysqli_errno() != 1062){
            move_uploaded_file($file_tmps,$filePath);
            $response['info']="Data Inserted Successfully.";
            $response['infoRes']="S"; // success
            $response['mysqli_insert_id']=mysqli_insert_id($con);
        }else{
            $error="Already data is inserted for this hour";
            $response['info']=$error;
            $response['infoRes']='E'; //Error
        }
        
    }
    $status['data'] = $response;
    echo json_encode($status);
    mysqli_close($con);
}

if(isset($_POST['getPODetails'])){
    $comp_id = $_POST['comp_id'];
    $plant_id=$_POST['plant_id'];
    $eq_code=$_POST['eq_code'];
    
    if (($plant_id != "" && $plant_id != 0)) {
       $eqQ="SELECT dp.id, dp.operation, dp.order_number, dp.material, sdi.id as data_info_id, sto.no_of_items_per_oper
                FROM  sfs_dc_po dp, sfs_plant sp, sfs_data_info sdi, sfs_tool_opr sto, sfs_equipment seq
                WHERE dp.plant_id=sp.id AND sdi.order_id=dp.id AND sto.number=dp.operation AND sdi.tag_id=sto.tag_id
                AND seq.code=sdi.eq_code AND dp.plant_id=".$plant_id." AND seq.code='".$eq_code."' ORDER by dp.id";
      }else {
          
      }
    $eqDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($eqDetails)){
        $id=$row['id'];
        $order_number=$row['order_number'];
        $material=$row['material'];
        $operation=$row['operation'];
        $data_info_id=$row['data_info_id'];
        $no_of_items_per_oper=$row['no_of_items_per_oper'];
        $getEQData[]=array('id' =>"$id",
            'order_number' =>"$order_number",
            'material' =>"$material",
            'operation' => "$operation",
            'data_info_id' => "$data_info_id",
            'no_of_items_per_oper' => "$no_of_items_per_oper"
        );
    }
    $status['poDetails'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}
if(isset($_POST['getRejCount'])){
    $comp_id=$_POST['comp_id'];
    $quality_codes_id=$_POST['quality_codes_id'];
    $eq_code=$_POST['eq_code'];
    $start_time=$_POST['start_time'];
    $end_time=$_POST['end_time'];
    
    if ($eq_code != '') {
        $eqQ="SELECT sd.start_time, sd.end_time, ROUND((sd.count*no_of_items_per_oper), 3) as count, seq.code, seq.descp, sqc.reason_message 
         FROM sfs_data sd, sfs_data_info sdi, sfs_equipment seq, sfs_quality_code sqc, sfs_tool_opr sto, sfs_quality_type sqt 
         WHERE sd.data_info_id=sdi.id AND sdi.eq_code=seq.code AND sd.quality_codes_id=sqc.id AND sqc.quality_type_id=sqt.id AND
         sto.tag_id=sdi.tag_id AND
         sqc.quality_type_id=".$quality_codes_id." AND sdi.eq_code='".$eq_code."' AND start_time >= '".$start_time."' AND end_time <= '".$end_time."'";

    $partsDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
    while ($row=mysqli_fetch_array($partsDetails)){
        $start_time=$row['start_time'];
        $end_time=$row['end_time'];
        $count=$row['count'];
        $descp=$row['descp'];
        $reason_message=$row['reason_message'];
        
        $getEQData[]=array('start_time' =>"$start_time",
            'end_time' =>"$end_time",
            'count' =>"$count",
            'descp' =>"$descp",
            'reason_message' =>"$reason_message"
        );
    }
    }
    $status['rejectCount'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}
if(isset($_POST['loadShiftData'])){     // getData for loadShiftData
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];
    $selDate= explode("/",$_POST['selDate']);// getting only Dateval
    $final_date= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];
    function getHours($time){
        return date("H", strtotime($time));
    }
    $ssq="SELECT id FROM  sfs_shifts WHERE type='SPECIAL' and plant_id=".$plant_id." and
        DATE(start_date) = '".$final_date."'";
    
    $result = mysqli_query($con,$ssq);
    if(mysqli_num_rows($result)>0){
        $sqlQ="SELECT id, code, start_date, end_date, plant_id, in_time, out_time, total_minutes, num_hours,hour_start, type, lb_starttime, lb_endtime, sb1_starttime, sb1_endtime, sb2_starttime, sb2_endtim,is_break_availb FROM sfs_shifts FROM  sfs_shifts where type='SPECIAL' and plant_id=".$plant_id." and start_date='".$final_date."'";
    }else{
        $sqlQ="SELECT id, code, start_date, end_date, plant_id, in_time, out_time, total_minutes, num_hours, hour_start,type, lb_starttime, lb_endtime, sb1_starttime, sb1_endtime, sb2_starttime, sb2_endtime,is_break_availb  FROM  sfs_shifts where type='NORMAL' and plant_id=".$plant_id." and start_date=(SELECT MAX(DATE(start_date)) FROM  sfs_shifts WHERE DATE(start_date) <= '".$final_date."' and plant_id=".$plant_id."  and type='NORMAL')";
    }
    $sql=mysqli_query($con, $sqlQ) or die("Query fail: " .mysqli_error($con));
    while ($row=mysqli_fetch_array($sql))
    {
        $id=$row['id'];
        $shift=$row['code'];
        $shift_start_date=$row['start_date'];
        $shift_end_date=$row['end_date'];
        $in_time=$row['in_time'];
        $out_time=$row['out_time'];
        $dateFormat='('.getHours($row['in_time']).'h - '.getHours($row['out_time']).'h)';
        $num_hourss=$row['num_hours'];
        $hour_start=$row['hour_start'];
        $total_minutes=$row['total_minutes'];
        $shift_type=$row['type'];
        $shift_state=$row['shift_state'];
        $plant_id=$row['plant_id'];
        $breakYN=$row['is_break_availb'];
        $lbreak_startTime=$row['lb_starttime'];
        $lbreak_endTime=$row['lb_endtime'];
        $break1_startTime=$row['sb1_starttime'];
        $break1_endTime=$row['sb1_endtime'];
        $break2_startTime=$row['sb2_starttime'];
        $break2_endTime=$row['sb2_endtime'];
        
        $final_data[]=array('id'=>"$id",
            'shift'=>"$shift",
            'shift_start_date'=>"$shift_start_date",
            'shift_end_date'=>"$shift_end_date",
            'in_time'=>"$in_time",
            'out_time'=>"$out_time",
            'dateFormat'=>"$dateFormat",
            'num_hourss'=>"$num_hourss",
            'hour_start'=>"$hour_start",
            'total_minutes'=>"$total_minutes",
            'shift_type'=>"$shift_type",
            'shift_state'=>"$shift_state",
            'plant_id'=>"$plant_id",
            'breakYN'=>"$breakYN",
            'lbreak_startTime'=>"$lbreak_startTime",
            'lbreak_endTime'=>"$lbreak_endTime",
            'break1_startTime'=>"$break1_startTime",
            'break1_endTime'=>"$break1_endTime",
            'break2_startTime'=>"$break2_startTime",
            'break2_endTime'=>"$break2_endTime"
        );
    }
    
    if(sizeof($final_data)!=null){
        for($k=0;$k<sizeof($final_data);$k++){
            if($k==0){
                $AllshiftInTime=$final_data[$k]['in_time'];
            }
            $AllshiftOutTime=$final_data[$k]['out_time'];
            $countHours+=$final_data[$k]['num_hourss'];
        }
        
        $dateFormat='('.getHours($AllshiftInTime).'h - '.getHours($AllshiftOutTime).'h)';
        $final_data[]=array('id'=>19857,'shift'=>0,'in_time'=>$AllshiftInTime,'out_time'=>$AllshiftOutTime,'num_hourss'=>$countHours,'dateFormat'=>$dateFormat);
    }
    
    $status['shiftData']=$final_data;
    echo json_encode($status);
    mysqli_close($con);
}
if(isset($_POST['getQualityCode'])){
    $comp_id=$_POST['comp_id'];
    if ($comp_id != '') {
        $eqQ="SELECT sqc.id, sqc.reason_message, sqc.color_code FROM sfs_quality_code sqc , sfs_quality_type sqt
              WHERE  sqt.id=sqc.quality_type_id AND sqc.quality_type_id=2";
        $qcDetails=mysqli_query($con,$eqQ) or die('Error:'.mysqli_error($con));
        while ($row=mysqli_fetch_array($qcDetails)){
            $id=$row['id'];
            $reason_message=$row['reason_message'];
            $color_code=$row['color_code'];           
            $getEQData[]=array('id' =>"$id",
                'reason_message' =>"$reason_message",
                'color_code' =>"$color_code"
            );
        }
    }
    $status['getQC'] = $getEQData;
    echo json_encode($status);
    mysqli_close($con);
}



    
?>