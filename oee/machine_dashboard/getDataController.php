<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';

if(isset($_POST['loadOeeData'])){     // getData for loadOeeData
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];
    //$shift_num= $_POST['shift_num'];
    $shift_num= 1;

    $selDate= explode("/",$_POST['selDate']);// getting only yyyy-mm-dd fomate
    $final_date= $selDate[2].'-'.$selDate[1].'-'.$selDate[0];

    $sqlProceQ = mysqli_query($con, "call sfsp_getMachineOee('".$comp_id."','".$plant_id."','".$workCenter_id."',".$iobotMachine.",".$final_date.",".$shift_num.")")or die("Query fail: " .mysqli_error($con));
 
    while ($row=mysqli_fetch_array($sqlProceQ))
    {
        $machine_status=$row['machine_status'];
        $oee_perc=$row['oee_perc'];
        $image_filename=$row['image_filename'];
        $active_reason_code=$row['active_reason_code'];
        $active_reason_color=$row['active_reason_color'];
        $availability_perc=$row['availability_perc'];
        $planned_production_time=$row['planned_production_time'];
        $run_time=$row['run_time'];
        $idle_time=$row['idle_time'];
        $breakdown_time=$row['breakdown_time'];
        $performance_perc=$row['performance_perc'];
        $ideal_cycle_time=$row['ideal_cycle_time'];
        $average_time_per_part=$row['average_time_per_part'];
        $quality_perc=$row['quality_perc'];
        $total_Count=$row['total_Count'];
        $ok_Count=$row['ok_Count'];
        $rejected_Count=$row['rejected_Count'];

        $final_data=array('machine_status'=>"$machine_status",
                            'oee_perc'=>"$oee_perc",
                            'image_filename'=>"$image_filename",
                            'active_reason_code'=>"$active_reason_code",
                            'active_reason_color'=>"$active_reason_color",
                            'availability_perc'=>"$availability_perc",
                            'planned_production_time'=>"$planned_production_time",
                            'run_time'=>"$run_time",
                            'idle_time'=>"$idle_time",
                            'breakdown_time'=>"$breakdown_time",
                            'performance_perc'=>"$performance_perc",
                            'ideal_cycle_time'=>"$ideal_cycle_time",
                            'average_time_per_part'=>"$average_time_per_part",
                            'quality_perc'=>"$quality_perc",
                            'total_Count'=>"$total_Count",
                            'ok_Count'=>"$ok_Count",
                            'rejected_Count'=>"$rejected_Count"
                            );
    }

    $status['oeeDetails']=$final_data;
    echo json_encode($status);    
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
        $sqlQ="SELECT id, code, start_date, end_date, plant_id, in_time, out_time, total_minutes, num_hour, type, lb_starttime, lb_endtime, sb1_starttime, sb1_endtime, sb2_starttime, sb2_endtim,breakYN FROM sfs_shifts FROM  sfs_shifts where type='SPECIAL' and plant_id=".$plant_id." and start_date='".$final_date."'";
    }else{
        $sqlQ="SELECT id, code, start_date, end_date, plant_id, in_time, out_time, total_minutes, num_hour, type, lb_starttime, lb_endtime, sb1_starttime, sb1_endtime, sb2_starttime, sb2_endtime,breakYN  FROM  sfs_shifts 
        where type='NORMAL' and plant_id=".$plant_id." and start_date=(SELECT MAX(DATE(start_date)) FROM  sfs_shifts WHERE DATE(start_date) <= '".$final_date."' and plant_id=".$plant_id."  and type='NORMAL')";  
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
        $num_hourss=$row['num_hour'];
        $total_minutes=$row['total_minutes'];
        $shift_type=$row['type'];
        $shift_state=$row['shift_state'];
        $plant_id=$row['plant_id'];
        $breakYN=$row['breakYN'];
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
}

?>