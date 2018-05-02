<?php 
    require '../common/db.php';
    require '../common/commonFunctions.php';
    //require '../common/session.php';

if(isset($_POST['loadShiftData'])){     // getData for loadShiftData
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];

    $final_date= $_POST['selDate'];

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