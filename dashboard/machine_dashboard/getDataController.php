<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';

if(isset($_POST['loadOeeData'])){     // getData for loadOeeData
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];
    $shift_num= $_POST['shift'];

    $selDate= explode("/",$_POST['selDate']);// getting only yyyy-mm-dd formate
    $final_date= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];

//echo $final_date;
    $sqlProceQRes = mysqli_query($con, "call sfsp_getMachineOee(".$comp_id.",".$plant_id.",".$workCenter_id.",".$iobotMachine.",'".$final_date."',".$shift_num.")")or die("Query fail: " .mysqli_error($con));
 
   while($row=mysqli_fetch_array($sqlProceQRes)) {

        $machine_status=$row['machine_status'];
        $oee_perc=$row['oee_per'];
        $image_filename=$row['image_filename'];
        $active_reason_code=$row['active_reason_code'];
        $active_reason_color=$row['active_reason_color'];
        $availability_perc=$row['availability_perc'];
        $planned_production_time=$row['planned_production_time'];
        $run_time=$row['run_time'];
        $run_time_perc=$row['run_time_perc'];
        $idle_time=$row['idle_time'];
        $idle_time_perc=$row['idle_time_perc'];
        $breakdown_time=$row['breakdown_time'];
        $breakdown_time_perc=$row['breakdown_time_perc'];
        $performance_perc=$row['performance_perc'];
        $ideal_cycle_time=$row['ideal_cycle_time'];
        $average_time_per_part=$row['average_time_per_part'];
        $quality_perc=$row['quality_perc'];
        $total_Count=$row['total_Count'];
        $ok_Count=$row['ok_Count'];
        $rejected_Count=$row['rejected_Count'];
        $oee_perc_color=$row['oee_perc_color'];
        $availability_perc_color=$row['availability_perc_color'];
        $performance_perc_color=$row['performance_perc_color'];
        $quality_perc_color=$row['quality_perc_color'];
              

        $final_info=array('machine_status'=>$machine_status,
                            'oee_perc'=>round($oee_perc),
                            'image_filename'=>$image_filename,
                            'active_reason_code'=>$active_reason_code,
                            'active_reason_color'=>$active_reason_color,
                            'availability_perc'=>round($availability_perc,10),
                            'planned_production_time'=>round($planned_production_time),
                            'run_time'=>round($run_time),
                            'idle_time'=>round($idle_time),
                            'breakdown_time'=>round($breakdown_time),
                            'performance_perc'=>round($performance_perc,10),
                            'ideal_cycle_time'=>round($ideal_cycle_time),
                            'average_time_per_part'=>round($average_time_per_part),
                            'quality_perc'=>round($quality_perc,10),
                            'total_Count'=>round($total_Count),
                            'ok_Count'=>round($ok_Count),
                            'rejected_Count'=>round($rejected_Count),
                            'oee_perc_color'=>$oee_perc_color,
                            'availability_perc_color'=>$availability_perc_color,
                            'performance_perc_color'=>$performance_perc_color,
                            'quality_perc_color'=>$quality_perc_color,
                            'run_time_perc'=>round($run_time_perc,10),
                            'idle_time_perc'=>round($idle_time_perc,10),
                            'breakdown_time_perc'=>round($breakdown_time_perc,10)
                            );
    }

    $status['oeeDetails']=$final_info;
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


if(isset($_POST['loadToolProcDrillData'])){     // getData for loadToolDrillData
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];

    $selDate= explode("/",$_POST['selDate']);// getting only Dateval
    $final_date= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];
    $total_hours= $_POST['total_hours'];
    $start_hourUI= $_POST['start_hour'];
    $group_type= $_POST['group_type'];
    $dbStartHour= $_POST['dbStartHour'];

   
    $final_data=array();
    //$rowHourArr=array();

    $sqlProceQ = mysqli_query($con, "call sfsp_getHourlyDrill('".$final_date."','".$group_type."',".$total_hours.",".$dbStartHour.",".$iobotMachine.")") or die("Query fail: " .mysqli_error($con));
 
    while ($row=mysqli_fetch_array($sqlProceQ))
    {
         $hourArr=array();
         $y_axisData=array();
         //$total_count='';

        $name=$row['name'];
        $descp=$row['descp'];
        $no_of_hours=$row['no_of_hours'];
        $start_hour=$row['start_hour'];
        $total_count=$row['total_count'];

        $getStartHour=$start_hourUI;

    $jk=0;
    for($ii=0;$ii<$total_hours;$ii++){
      $startHourTime=($getStartHour+$ii);
        if($startHourTime>=24){
          $startHourTime=$jk; 
          $jk=$jk+1;
        }
       $y_axisData[]=$startHourTime."h";
    }
        $dbStartHour=$_POST['dbStartHour'];
        for($i=0;$i<$total_hours;$i++){
            $hourArr[]=array($y_axisData[$i],round($row['H'.$dbStartHour]));
            $dbStartHour++;
        }
                   
        if($group_type=='M'){            
            $machineData[]=array('name'=>"$descp",
                                 'data'=>$hourArr
                                 );
        }else{     
            $firstPhaseData[]=array('id'=>"$name",
                                    'y'=>round($total_count),
                                    'name'=>"$descp",
                                    'drilldown'=>"$name"
                                    );

            $secondPhaseData[]=array('name'=>"$descp",
                                     'id'=>"$name",
                                     'data'=>$hourArr
                                     );
        }
    }

    $status['secondPhaseData']=$secondPhaseData;
    $status['firstPhaseData']=$firstPhaseData;
    $status['machineData']=$machineData;
    $status['rowHourArr']=$y_axisData;
    echo json_encode($status);  
    mysqli_close($con); 
}

if(isset($_POST['getActivityProgress'])){     // getData for getActivityProgress
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];

    $selDate= explode("/",$_POST['selDate']);// getting only Dateval
    $final_date= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];
    $total_hours= $_POST['total_hours'];
    $start_hourUI= $_POST['start_hour'];
    $shift= $_POST['shift'];

    $y_axisData=array();    
    

    $sTime=$_POST['sTime'];
    $eTime=$_POST['eTime'];
    
    $startDateTime=$final_date." ".$sTime; 
    $endDateTime=$final_date." ".$eTime;;

    $start = strtotime($startDateTime);
    $end = strtotime($endDateTime);

    if($start-$end >= 0)
    $ModifideEndDate = date('Y-m-d', strtotime("+1 day", strtotime($endDateTime)));
    else
    $ModifideEndDate = $final_date;



    $jk=0;
    for($ii=0;$ii<$total_hours;$ii++){
      $startHourTime=($start_hourUI+$ii);
        if($startHourTime>=24){
          $startHourTime=$jk; 
          $jk=$jk+1;
        }
       $y_axisData[]=$startHourTime."h";
    }

    
    $sqlQ="SELECT DISTINCT se.start_time as start_time, se.end_time as end_time, TIMESTAMPDIFF(SECOND,se.start_time,se.end_time) as duration, se.reason_code_id as reason_code_id, src.message as message, src.color_code as color_code  
        FROM
        sfs_event se,
        sfs_data_info sdi,
        sfs_equipment seq,
        sfs_reason_code src,
        sfs_shifts shf
        WHERE
        se.data_info_id=sdi.id AND
        sdi.eq_code=seq.code AND
        src.id=se.reason_code_id AND
        seq.id=".$iobotMachine." AND
        DATE(se.start_time)='".$final_date."' AND
        shf.id=".$shift." AND
        se.reason_code_id <> 0 AND
        se.start_time >= TIMESTAMP('".$final_date."',TIME(shf.in_time)) AND
        se.end_time <= TIMESTAMP('".$ModifideEndDate."',TIME(shf.out_time))";  

//echo $sqlQ;
    $sql=mysqli_query($con, $sqlQ) or die("Query fail: " .mysqli_error($con));
    while ($row=mysqli_fetch_array($sql))
    {
        $start_time=$row['start_time'];
        $end_time=$row['end_time'];
        $duration=$row['duration'];
        $reason_code_id=$row['reason_code_id'];
        $message=$row['message'];
        $color_code=$row['color_code'];

        $final_data[]=array('start_time'=>"$start_time",
                            'end_time'=>"$end_time",
                            'duration'=>"$duration",
                            'reason_code_id'=>"$reason_code_id",
                            'message'=>"$message",
                            'color_code'=>"$color_code",
                            );
    }

    $sqlR="SELECT DISTINCT src.message as message, src.color_code as color_code  
        FROM
        sfs_event se,
        sfs_data_info sdi,
        sfs_equipment seq,
        sfs_reason_code src,
        sfs_shifts shf
        WHERE
        se.data_info_id=sdi.id AND
        sdi.eq_code=seq.code AND
        src.id=se.reason_code_id AND
        seq.id=".$iobotMachine." AND
        DATE(se.start_time)='".$final_date."' AND
        shf.id=".$shift." AND
        se.reason_code_id <> 0 AND
        se.start_time >= TIMESTAMP('".$final_date."',TIME(shf.in_time)) AND
        se.end_time <= TIMESTAMP('".$ModifideEndDate."',TIME(shf.out_time))
        group by message"; 
//echo $sqlR;
    $sqlRes=mysqli_query($con, $sqlR) or die("Query fail: " .mysqli_error($con));
    while ($row=mysqli_fetch_array($sqlRes))
    {
        $message=$row['message'];
        $color_code=$row['color_code'];

         $reasonCode[]=array('message'=>"$message",
                             'color_code'=>"$color_code");
    }   

    $status['rowHourArr']=$y_axisData;
    $status['activityData']=$final_data;
    $status['reasonCode']=$reasonCode;
    echo json_encode($status);  
    mysqli_close($con); 
}



if(isset($_POST['getActivityAnalysis'])){     // getData for getActivityAnalysis
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];

    $selDate= explode("/",$_POST['selDate']);// getting only Dateval
    $final_date= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];
    $total_hours= $_POST['total_hours'];
    $start_hourUI= $_POST['start_hour'];
    $shift= $_POST['shift'];

    $sTime=$_POST['sTime'];
    $eTime=$_POST['eTime'];
    
    $startDateTime=$final_date." ".$sTime; 
    $endDateTime=$final_date." ".$eTime;;

    $start = strtotime($startDateTime);
    $end = strtotime($endDateTime);

    if($start-$end >= 0)
    $ModifideEndDate = date('Y-m-d', strtotime("+1 day", strtotime($endDateTime)));
    else
    $ModifideEndDate = $final_date;



    $sqlQ=" SELECT SUM(TIMESTAMPDIFF(SECOND,se.start_time,se.end_time)) as time_diff, se.reason_code_id as reason_code_id, src.message as message, src.color_code as color_code,DATE_FORMAT(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,se.start_time, se.end_time))),'%H:%i') AS getHHMM FROM
        sfs_event se,
           sfs_data_info sdi,
        sfs_equipment seq,
           sfs_reason_code src,
           sfs_shifts shf
        WHERE
        se.data_info_id=sdi.id AND
           sdi.eq_code=seq.code AND
           src.id=se.reason_code_id AND
           seq.id=".$iobotMachine." AND
           DATE(se.start_time)='".$final_date."' AND
           shf.id=".$shift." AND
           se.reason_code_id <> 0 AND
           se.start_time >= TIMESTAMP('".$final_date."',TIME(shf.in_time)) AND
           se.end_time <= TIMESTAMP('".$ModifideEndDate."',TIME(shf.out_time))
        GROUP BY se.reason_code_id";  

    $sql=mysqli_query($con, $sqlQ) or die("Query fail: " .mysqli_error($con));
    while ($row=mysqli_fetch_array($sql))
    {
        $duration=$row['time_diff'];
        $reason_code_id=$row['reason_code_id'];
        $message=$row['message'];
        $color_code=$row['color_code'];
        $getHHMM=$row['getHHMM'];

        $final_data[]=array('name'=>"$message",
                            'y'=>round($duration),
                            'color'=>"$color_code",
                            'getHHMM'=>"$getHHMM"
                            );
    }

    $status['analysisData']=$final_data;
    echo json_encode($status);  
    mysqli_close($con); 
}
?>