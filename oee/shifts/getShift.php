<?php 
	require '../common/db.php';
	include '../common/session.php';

function mysqli_insert_array($table, $data, $exclude = array()) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
            //$values[] = "'" . mysql_real_escape_string($data[$key]) . "'";
			$values[] = "'" .$data[$key]. "'";
        }
    }     
    $fields = implode(",", $fields);
    $values = implode(",", $values);

    $sql="INSERT INTO `$table` ($fields) VALUES ($values)";
    return $sql;
}	

function mysqli_update_array($table, $data, $exclude = array(),$cond) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
        	$dataA[]=$key."='" .$data[$key]. "'";
        }
    }     
    $dataA = implode(",", $dataA);

    $updateSql = "UPDATE $table SET $dataA where $cond";
    return $updateSql;
}

// get time formate in mm/dd/yyyy hh:mm PM TO yyyy-mm-dd hh:mm:ss Database Formate
function getDbDateTimeFormate($input) {
	$Datetime = date("Y-m-d H:i:s", strtotime($input));
	$only_date =date("Y-m-d", strtotime($input));
	 return  array( "DateTime" => $Datetime,
                    "only_date" => $only_date,
                   );
}

function addZero($num) {
	if($num < 10) {
        $num = "0".$num;
    }
    return $num;
  }

	
if(isset($_POST['saveShift'])){

		$recordId= $_POST['recordId'];	 //  recordId 

		$plant_id= $_POST['plant_id'];	 //  plant_id
		$num_hours= $_POST['hours'];	//  num_hours
		$shift_type= $_POST['getShiftType'];  // shift_type
		$shiftsCount= $_POST['shiftsCount'];  // shiftsCount
		$startDate = getDbDateTimeFormate($_POST["startDate"]);  // Calling Function to get Value : 20/10/2014 05:39 PM
		$endDate = getDbDateTimeFormate($_POST["endDate"]);  // Calling Function to get Value : 20/10/2014 05:39 PM
		$in_time=$startDate['DateTime'];  // in_time
		$out_time=$endDate['DateTime'];   // out_time
	    $shift_start_date=$startDate['only_date']; // shift_start_date
		// shift_state
	    if( date($shift_start_date) == date("Y-m-d")){
	    	$shift_state='R';
	    }else if(date($shift_start_date) > date("Y-m-d")){
	    	$shift_state='U';
	    }else{
	    	$shift_state='X'; // not a valid date
	    }
	   
	    date_default_timezone_set('Asia/Calcutta');
	    $created_on= date("Y-m-d H:i:s"); //  created_on
	    $user_id= 0; //  user_id

	    // checking shifts is already present
  	/*	$checkShiftSql="SELECT COUNT(*) as rowCount FROM `qc_plant_shifts` WHERE is_deleted=0 and shift_start_date='".$startDate['only_date']."' and shift='".$shiftsCount."' and plant_id=".$plant_id;

	    $resultShift=mysqli_query($con,$checkShiftSql);
	    while($row = mysqli_fetch_array($resultShift)){
		  $DBshiftsCount = $row['rowCount'];  // shift 
		}*/


		$breakYN=$_POST['breakYN']; //breakYN
		$longStartTime=getDbDateTimeFormate($_POST['longStartTime']); //longStartTime
		$longEndTime=getDbDateTimeFormate($_POST['longEndTime']); //longEndTime

		$break1StartTime=getDbDateTimeFormate($_POST['break1StartTime']); //break1StartTime
		$break1EndTime=getDbDateTimeFormate($_POST['break1EndTime']); //break1EndTime

		$break2StartTime=getDbDateTimeFormate($_POST['break2StartTime']); //break2StartTime
		$break2EndTime=getDbDateTimeFormate($_POST['break2EndTime']); //break2EndTime


		$table= 'qc_plant_shifts';	
		$DataMarge=array('shift'=>$shiftsCount,
						  'shift_start_date'=>$shift_start_date,
						  'in_time'=>$in_time,
						  'out_time'=>$out_time,
						  'num_hours'=>$num_hours,
						  'shift_type'=>$shift_type,
						  'shift_state'=>$shift_state,
						  'created_on'=>$created_on,
						  'plant_id'=>$plant_id,
						  'user_id'=>$user_id,
						  'breakYN'=>$breakYN,
						  'lbreak_startTime'=>$longStartTime['DateTime'],
						  'lbreak_endTime'=>$longEndTime['DateTime'],
						  'break1_startTime'=>$break1StartTime['DateTime'],
						  'break1_endTime'=>$break1EndTime['DateTime'],
						  'break2_startTime'=>$break2StartTime['DateTime'],
						  'break2_endTime'=>$break2EndTime['DateTime']
						);
// print_r($DataMarge);
	
		if($recordId==0){
			//if($timeRowCount==0){
			    //if($DBshiftsCount==0){
					$sqlQuery = mysqli_insert_array($table, $DataMarge, "submit"); // Function say generate complete query
				    $res=mysqli_query($con,$sqlQuery) or die('Error: ' . mysqli_error());		
						if(!$res) {
							//$error= "Query Failed: " . $result['mysql_error'];
							$error="Error while Saving..";
							$response['info']=$error;
							$response['infoRes']='E'; //Error
						}else {
						  $response['info']="Shift Saved Successfully";
						  $response['infoRes']="S"; // success
						  $response['mysqli_insert_id']=mysqli_insert_id($con);
						}
				/*}else{					
					$response['info']="<p style='color:red;font-weight:600;'> Shift Already Exits for Date :".$shift_start_date."</p>";
					$response['infoRes']='SE'; // Shift Exits
				}*/
			/*}else{
				$response['info']="Shift Time Already Exits for Date :".$shift_start_date;
				$response['infoRes']='SE'; // Shift Exits
			}*/
		}else{
				$cond=' id = '.$recordId;
				$sqlUpdateQuery = mysqli_update_array($table, $DataMarge, "submit",$cond); // Function say generate complete query

			    $res=mysqli_query($con,$sqlUpdateQuery) or die('Error: ' . mysqli_error());		
					if(!$res) {
						//$error= "Query Failed: " . $result['mysql_error'];
						$error="Error while Saving..";
						$response['info']=$error;
						$response['infoRes']='E'; //Error
					}else {
					  $response['info']="Shift Updated Successfully";
					  $response['infoRes']="S"; // success
					}	
		}	

		$status['data'] = $response;     
        echo json_encode($status);
        mysqli_close($con);
}
/*
if(isset($_POST['getShiftsData'])){
	
	$plant_id= $_POST['plant_id'];	

	$sql1="SELECT id as shift_id,num_shifts as num_shifts,shift as shift,num_hours as num_hours,start_time as start_time,end_time as end_time from qc_plant_shifts where plant_id=".$plant_id;
        $getRecords1 = mysqli_query($con,$sql1) ;

        while ($row=mysqli_fetch_array($getRecords1)) 
        {
            $shift_id=$row['shift_id'];
            $num_shifts=$row['num_shifts'];
            $shift=$row['shift'];
            $num_hours=$row['num_hours'];
            $start_time=$row['start_time'];
            $count=$row['count'];

            $shiftData[]=array('shift_id' =>"$shift_id",'num_shifts' =>"$num_shifts",'shift' =>"$shift",'num_hours' =>"$num_hours",'start_time' =>"$start_time");
        } 

		$getCount="SELECT count(id) as count from qc_plant_shifts where plant_id=".$plant_id;
        $getCountRes = mysqli_query($con,$getCount);
 		while ($row=mysqli_fetch_array($getCountRes)) 
        {  $NumShift=$row['count'];  }
        if($shiftData==null){
        	$shiftData=0;
        }

        $status['data'] =  $shiftData;     
        $status['count'] =   $NumShift;   
        echo json_encode($status);
        mysqli_close($con);
}*/


if(isset($_POST['getRecentRow'])){
	
	$plant_id= $_POST['plant_id'];
	$last_id= $_POST['last_id'];
	

	$shiftQuery="SELECT id,shift,in_time,out_time,num_hours,created_on,shift_type FROM qc_plant_shifts where id=".$last_id." 
				and plant_id=".$plant_id;	
    $shiftRes=mysqli_query($con,$shiftQuery) or die('Error:'.mysqli_error());

		while ($row=mysqli_fetch_array($shiftRes)){ 
		 $id=$row['id']; 
		 $shift=$row['shift']; 
		 $in_time=$row['in_time']; 
		 $out_time=$row['out_time']; 
		 $num_hours=$row['num_hours']; 
		 $created_on=$row['created_on']; 
		 $shift_type=$row['shift_type']; 


		  $getRecentRow=array('id' =>"$id",'shift' =>"$shift",'in_time' =>"$in_time",'out_time' =>"$out_time",'num_hours' =>"$num_hours",'created_on' =>"$created_on",'shift_type' =>"$shift_type");

        }

			$status['RecentRow'] = $getRecentRow;     
            echo json_encode($status); 
            mysqli_close($con);
}

if(isset($_POST['deleteRow'])){	
	$id= $_POST['recordId'];	
	$plant_id= $_POST['plant_id'];	
	$startDate= $_POST['startDate'];	
//        id=".$id."
		$sql = "UPDATE qc_plant_shifts set is_deleted=1 WHERE shift_start_date='".$startDate."' and plant_id=".$plant_id;	
		//echo $sql;	
		$res=mysqli_query($con,$sql) or die('Error: ' . mysql_error());
		if($res){ 
				$status['data'] = 1;   
			    echo json_encode($status);
			    mysqli_close($con);
		}else{
			//die('Error: ' . mysql_error());
			$status['data'] = 0;   
			echo json_encode($status);
			mysqli_close($con);
		}
}

if(isset($_POST['editRow'])){	
	$id= $_POST['recordId'];	
	$plant_id= $_POST['plant_id'];	

		$sql = "SELECT id,shift,shift_start_date,shift_start_date,in_time,out_time,num_hours,shift_type,shift_state FROM `qc_plant_shifts` WHERE  is_deleted=0 and id=".$id." and plant_id=".$plant_id;	
		//echo $sql;	
		$res=mysqli_query($con,$sql) or die('Error: ' . mysql_error());
		while ($row=mysqli_fetch_array($res)){ 
		 $id=$row['id']; 
		 $shift=$row['shift']; 
		 $shift_start_date=$row['shift_start_date']; 
		 $in_time=$row['in_time']; 
		 $out_time=$row['out_time']; 
		 $num_hours=$row['num_hours']; 
		 $shift_type=$row['shift_type']; 
		 $shift_state=$row['shift_state'];	

		  $getRow=array('id' =>"$id",'shift' =>"$shift",'in_time' =>"$in_time",'out_time' =>"$out_time",'num_hours' =>"$num_hours",'shift_state' =>"$shift_state",'shift_type' =>"$shift_type",'shift_start_date' =>"$shift_start_date");
        }

        $status['data'] = $getRow;     
        echo json_encode($status);
        mysqli_close($con);
}


if(isset($_POST['loadCurrentShift'])){
	
	$plant_id= $_POST['plant_id'];
	$currDate= date("Y-m-d"); //  currentDate;

$ssq="SELECT id FROM qc_plant_shifts WHERE shift_type='SPECIAL' and plant_id=".$plant_id." and 
		DATE(shift_start_date) = '".$currDate."'";
$result = mysqli_query($con,$ssq);
if(mysqli_num_rows($result)>0){
    // Rows exist
	$shiftQuery="SELECT id,shift,in_time,out_time,num_hours,created_on,shift_type,shift_start_date,breakYN,lbreak_startTime,lbreak_endTime, break1_startTime,break1_endTime,break2_startTime,break2_endTime FROM qc_plant_shifts 
	where is_deleted=0 and shift_type='SPECIAL' and plant_id=".$plant_id." and shift_start_date='".$currDate."'";
}else{
	$shiftQuery="SELECT id,shift,in_time,out_time,num_hours,created_on,shift_type,shift_start_date,breakYN,lbreak_startTime,lbreak_endTime, break1_startTime,break1_endTime,break2_startTime,break2_endTime FROM qc_plant_shifts 
	where is_deleted=0 and shift_type='NORMAL' and plant_id=".$plant_id." and shift_start_date=(SELECT MAX(DATE(shift_start_date)) FROM qc_plant_shifts WHERE DATE(shift_start_date) <= '".$currDate."' and plant_id=".$plant_id." and is_deleted=0 and shift_type='NORMAL')";	
}

    $shiftRes=mysqli_query($con,$shiftQuery) or die('Error:'.mysqli_error());

//echo $shiftQuery;
		while ($row=mysqli_fetch_array($shiftRes)){ 
		 $id=$row['id']; 
		 $shift=$row['shift']; 
		 $in_time=$row['in_time']; 
		 $out_time=$row['out_time']; 
		 $num_hours=$row['num_hours']; 
		 $created_on=$row['created_on']; 
		 $shift_type=$row['shift_type']; 
		 $shift_start_date=$row['shift_start_date']; 

		 $breakYN=$row['breakYN']; 
		 $lbreak_startTime=$row['lbreak_startTime']; 
		 $lbreak_endTime=$row['lbreak_endTime']; 
		 $break1_startTime=$row['break1_startTime']; 
		 $break1_endTime=$row['break1_endTime']; 
		 $break2_startTime=$row['break2_startTime']; 
		 $break2_endTime=$row['break2_endTime']; 


		  $getCurrentShift[]=array('id' =>"$id",'shift' =>"$shift",'in_time' =>"$in_time",'out_time' =>"$out_time",'num_hours' =>"$num_hours",'created_on' =>"$created_on",'shift_type' =>"$shift_type",'shift_start_date' =>"$shift_start_date",'breakYN' =>"$breakYN",'lbreak_startTime' =>"$lbreak_startTime",'lbreak_endTime' =>"$lbreak_endTime",'break1_startTime' =>"$break1_startTime",'break1_endTime' =>"$break1_endTime",'break2_startTime' =>"$break2_startTime",'break2_endTime' =>"$break2_endTime");

        }

			$status['CurrentShift'] = $getCurrentShift;     
            echo json_encode($status); 
}

if(isset($_POST['loadUpcomingShift'])){
	
	$plant_id= $_POST['plant_id'];
	$currDate= date("Y-m-d"); //  currentDate;

	$shiftQuery="SELECT id,shift,in_time,out_time,num_hours,created_on,shift_type,shift_start_date,breakYN,lbreak_startTime,lbreak_endTime, break1_startTime,break1_endTime,break2_startTime,break2_endTime FROM qc_plant_shifts 
	where is_deleted=0 and shift_type='NORMAL' and plant_id=".$plant_id." and shift_start_date >'".$currDate."' order by shift_start_date ASC";	

	//echo $shiftQuery;
    $shiftRes=mysqli_query($con,$shiftQuery) or die('Error:'.mysqli_error());

		while ($row=mysqli_fetch_array($shiftRes)){ 
		 $id=$row['id']; 
		 $shift=$row['shift']; 
		 $in_time=$row['in_time']; 
		 $out_time=$row['out_time']; 
		 $num_hours=$row['num_hours']; 
		 $created_on=$row['created_on']; 
		 $shift_type=$row['shift_type']; 
		 $shift_start_date=$row['shift_start_date']; 

		 $breakYN=$row['breakYN']; 
		 $lbreak_startTime=$row['lbreak_startTime']; 
		 $lbreak_endTime=$row['lbreak_endTime']; 
		 $break1_startTime=$row['break1_startTime']; 
		 $break1_endTime=$row['break1_endTime']; 
		 $break2_startTime=$row['break2_startTime']; 
		 $break2_endTime=$row['break2_endTime']; 

		  $getCurrentShift[]=array('id' =>"$id",'shift' =>"$shift",'in_time' =>"$in_time",'out_time' =>"$out_time",'num_hours' =>"$num_hours",'created_on' =>"$created_on",'shift_type' =>"$shift_type",'shift_start_date' =>"$shift_start_date",'breakYN' =>"$breakYN",'lbreak_startTime' =>"$lbreak_startTime",'lbreak_endTime' =>"$lbreak_endTime",'break1_startTime' =>"$break1_startTime",'break1_endTime' =>"$break1_endTime",'break2_startTime' =>"$break2_startTime",'break2_endTime' =>"$break2_endTime");
        }

			$status['UpcomingShift'] = $getCurrentShift;     
            echo json_encode($status); 
}

if(isset($_POST['loadSpecialShift'])){
	
	$plant_id= $_POST['plant_id'];
	$currDate= date("Y-m-d"); //  currentDate;

	$shiftQuery="SELECT id,shift,in_time,out_time,num_hours,created_on,shift_type,shift_start_date,breakYN,lbreak_startTime,lbreak_endTime, break1_startTime,break1_endTime,break2_startTime,break2_endTime FROM qc_plant_shifts 
	where is_deleted=0 and shift_type='SPECIAL' and plant_id=".$plant_id." order by shift_start_date ASC";	
    $shiftRes=mysqli_query($con,$shiftQuery) or die('Error:'.mysqli_error());

		while ($row=mysqli_fetch_array($shiftRes)){ 
		 $id=$row['id']; 
		 $shift=$row['shift']; 
		 $in_time=$row['in_time']; 
		 $out_time=$row['out_time']; 
		 $num_hours=$row['num_hours']; 
		 $created_on=$row['created_on']; 
		 $shift_type=$row['shift_type']; 
		 $shift_start_date=$row['shift_start_date']; 

		 $breakYN=$row['breakYN']; 
		 $lbreak_startTime=$row['lbreak_startTime']; 
		 $lbreak_endTime=$row['lbreak_endTime']; 
		 $break1_startTime=$row['break1_startTime']; 
		 $break1_endTime=$row['break1_endTime']; 
		 $break2_startTime=$row['break2_startTime']; 
		 $break2_endTime=$row['break2_endTime']; 


		  $getCurrentShift[]=array('id' =>"$id",'shift' =>"$shift",'in_time' =>"$in_time",'out_time' =>"$out_time",'num_hours' =>"$num_hours",'created_on' =>"$created_on",'shift_type' =>"$shift_type",'shift_start_date' =>"$shift_start_date",'breakYN' =>"$breakYN",'lbreak_startTime' =>"$lbreak_startTime",'lbreak_endTime' =>"$lbreak_endTime",'break1_startTime' =>"$break1_startTime",'break1_endTime' =>"$break1_endTime",'break2_startTime' =>"$break2_startTime",'break2_endTime' =>"$break2_endTime");

        }

			$status['SpecialShift'] = $getCurrentShift;     
            echo json_encode($status); 
}

if(isset($_POST['loadHistoryShift'])){
	
	$plant_id= $_POST['plant_id'];
	$currDate= date("Y-m-d"); //  currentDate;

	$shiftQuery="SELECT id,shift,in_time,out_time,num_hours,created_on,shift_type,breakYN,lbreak_startTime,lbreak_endTime, break1_startTime,break1_endTime,break2_startTime,break2_endTime FROM qc_plant_shifts where is_deleted=0 
	and plant_id=".$plant_id." and shift_start_date<(SELECT MAX(DATE(shift_start_date)) FROM qc_plant_shifts WHERE DATE(shift_start_date) <='".$currDate."' and plant_id=".$plant_id." and is_deleted=0 and shift_type='NORMAL')";	


    $shiftRes=mysqli_query($con,$shiftQuery) or die('Error:'.mysqli_error());

		while ($row=mysqli_fetch_array($shiftRes)){ 
		 $id=$row['id']; 
		 $shift=$row['shift']; 
		 $in_time=$row['in_time']; 
		 $out_time=$row['out_time']; 
		 $num_hours=$row['num_hours']; 
		 $created_on=$row['created_on']; 
		 $shift_type=$row['shift_type']; 

		 $breakYN=$row['breakYN']; 
		 $lbreak_startTime=$row['lbreak_startTime']; 
		 $lbreak_endTime=$row['lbreak_endTime']; 
		 $break1_startTime=$row['break1_startTime']; 
		 $break1_endTime=$row['break1_endTime']; 
		 $break2_startTime=$row['break2_startTime']; 
		 $break2_endTime=$row['break2_endTime']; 


		  $getCurrentShift[]=array('id' =>"$id",'shift' =>"$shift",'in_time' =>"$in_time",'out_time' =>"$out_time",'num_hours' =>"$num_hours",'created_on' =>"$created_on",'shift_type' =>"$shift_type",'breakYN' =>"$breakYN",'lbreak_startTime' =>"$lbreak_startTime",'lbreak_endTime' =>"$lbreak_endTime",'break1_startTime' =>"$break1_startTime",'break1_endTime' =>"$break1_endTime",'break2_startTime' =>"$break2_startTime",'break2_endTime' =>"$break2_endTime");

        }

			$status['HistoryShift'] = $getCurrentShift;     
            echo json_encode($status); 
}

?>   
 