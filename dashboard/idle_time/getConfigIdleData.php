<?php
require '../common/db.php';

if(isset($_POST['idleData'])){	 // getData for Table
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];
	$inTime= $_POST['inTime'];
	$inTime = date("Y-m-d H:i:s", strtotime($inTime));
	$outTime= $_POST['outTime'];
	$outTime= date("Y-m-d H:i:s", strtotime($outTime));
        $sql="SELECT qe.id, qe.start_time, qe.is_edited_reason, qe.end_time, qe.reason_code, qrc.reason_code_message as message, qe.table_id, qrc.color_code as color FROM qc_event qe, qc_iobot_info qii, qc_unit_details qud, qc_reason_codes qrc
           WHERE qe.table_id=qii.ru_id AND qii.unit_id=qud.id AND qud.plant_id=".$plant_id." AND qrc.reason_code_no=qe.reason_code and qe.start_time >= '".$inTime."' and qe.end_time <= '".$outTime."'";
    //echo $sql;
    $getRows= mysqli_query($con,$sql) or die("Error :".mysql_error());
    while ($row=mysqli_fetch_array($getRows))
    {
        $start_time=$row['start_time'];
        $end_time=$row['end_time'];
		$message=$row['message'];
		$table_id=$row['table_id'];	
		$id=$row['id']; 
		$reason_code = $row['reason_code']; 
		$color = $row['color'];
		$is_edited_reason=$row['is_edited_reason'];
        $final_data[]=array('id'=>"$id",'start_time'=>"$start_time",'end_time'=>"$end_time",'message'=>"$message",'table_id'=>"$table_id", 'reason_code'=>"$reason_code", 'color'=>"$color", 'is_edited_reason'=>"$is_edited_reason");
    }
    $status['data']=$final_data;
    echo json_encode($status);
}

if(isset($_POST['getReason'])){// get reason code data for Dropdown
	$reasonCodes= $_POST['reasonCodes'];
    $sql="SELECT reason_code_no as reasonId, reason_code_message as reasonMesg, color_code as color FROM qc_reason_codes where id IN(".$reasonCodes.")";
    $getRows= mysqli_query($con,$sql) or die("Error :".mysql_error());
    while ($row=mysqli_fetch_array($getRows))
    {
        $reasonId=$row['reasonId'];
        $reasonMesg=$row['reasonMesg']; 
		$color=$row['color']; 
        $final_data[]=array('reasonId'=>"$reasonId",'reasonMesg'=>"$reasonMesg",'color'=>"$color");
    }
    
    $status['data']=$final_data;
    echo json_encode($status);
}

if(isset($_POST['updateReasonChanged'])){ // update idle time reason changed
    $iobotName= $_POST['iobotName'];
	$reasonCodeNo= $_POST['reasonCodeNo'];
	$reasonMesg= $_POST['reasonMesg'];
	$start_time= $_POST['start_time'];
	$end_time= $_POST['end_time'];
	
	$reasonCodeNoPrev= $_POST['reasonCodeNoPrev'];
	$userName= $_POST['userName'];
	
    $sql="UPDATE qc_event SET reason_code=".$reasonCodeNo.", message='".$reasonMesg."', is_edited_reason=1 WHERE table_id='".$iobotName."' and start_time >= '".$start_time."' and end_time <='".$end_time."'";
    $getRows= mysqli_query($con,$sql) or die("Error :".mysql_error());
   if(!$getRows) {
		$error="Error while Saving..";
		$response['info']=$error;
		$response['infoRes']='E'; //Error
	}else {
		$response['info']="Changed Reason Updated Successfully";
		$response['infoRes']="S"; // success
		
		$sql2="INSERT INTO `reason_changed_log`(`user_name`, `start_time`, `end_time`, `edited_time`, `prev_reason`, `current_reason`, `table_id`) VALUES ('".$userName."','".$start_time."','".$end_time."',CURRENT_TIMESTAMP(),".$reasonCodeNoPrev.",".$reasonCodeNo.",'".$iobotName."')";
        $getRows2= mysqli_query($con,$sql2) or die("Error :".mysql_error());
	}
    $status['data']=$response;
    echo json_encode($status);
}

if(isset($_POST['editedLogData'])){	 // getData for Table
    $comp_id= $_POST['comp_id'];
    $plant_id= $_POST['plant_id'];
    $workCenter_id= $_POST['workCenter_id'];
    $iobotMachine= $_POST['iobotMachine'];
    $sql="SELECT rcl.id, rcl.user_name, rcl.start_time, rcl.end_time, rcl.prev_reason,(SELECT reason_code_message FROM qc_reason_codes WHERE reason_code_no=rcl.prev_reason) as prev_message,
	      rcl.current_reason, (SELECT reason_code_message FROM qc_reason_codes WHERE reason_code_no=rcl.current_reason) as current_message, rcl.table_id,rcl.edited_time
          FROM reason_changed_log rcl, qc_iobot_info qii, qc_unit_details qud
          WHERE rcl.table_id=qii.ru_id AND qii.unit_id=qud.id AND qud.plant_id=".$plant_id." ORDER by rcl.id DESC LIMIT 100";
    //echo $sql;
    $getRows= mysqli_query($con,$sql) or die("Error :".mysql_error());
    while ($row=mysqli_fetch_array($getRows))
    {
        $start_time=$row['start_time'];
        $end_time=$row['end_time'];
		$prev_message=$row['prev_message'];
		$table_id=$row['table_id'];	
		$id=$row['id']; 
		$current_message = $row['current_message']; 
		$user_name = $row['user_name'];
		$edited_time = $row['edited_time'];
		$prev_reason = $row['prev_reason'];
		$current_reason = $row['current_reason'];
        $final_data[]=array('id'=>"$id",'start_time'=>"$start_time",'end_time'=>"$end_time",
		'prev_message'=>"$prev_message",'table_id'=>"$table_id", 'current_message'=>"$current_message",
		'user_name'=>"$user_name", 'edited_time'=>"$edited_time", 'prev_reason'=>"$prev_reason", 'current_reason'=>"$current_reason");
    }
    $status['data']=$final_data;
    echo json_encode($status);
}

?>



