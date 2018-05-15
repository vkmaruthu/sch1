<?php
include '../common/db.php';
include '../common/session.php';
include '../common/header.php';
?>
<title>Edit Idle Time</title>

<input type="hidden" name="comp_id" id="comp_id"/> 
<input type="hidden" name="plant_id" id="plant_id"/> 
<input type="hidden" name="workCenter_id" id="workCenter_id"/> 
<input type="hidden" name="iobotMachine" id="iobotMachine"/>

<link type="text/css" href="../css/bootstrap-datetimepicker.css" rel="stylesheet">

<div class="container">
	<div class="col-md-12">
		<div class="page-header"> </div>
		<div class="panel panel-success" style="margin-bottom: 5px;">
			<div class="panel-heading "> 
				<div class="panel-title pull-left">
             		<b> Edit Idle Time </b>
         		</div>
		        <div class="panel-title pull-right" id="clock"></div>
		        <div class="clearfix"></div>
			</div>
						 
			<div class="panel-body">
			<div class="col-md-12" style="padding-bottom: 10px;">
			  <div class="col-ms-4 col-xs-12 col-md-1" style="font-weight: bold; padding-top: 2px; padding-right: 0px; font-size: 15px;"> Start Time:</div>
			    <div class="col-ms-8 col-xs-12 col-md-3">
					<div class="input-group date">
						<input name="startDateTime" id="startDateTime" type="text" class="form-control dateClassForTime" placeholder="mm/dd/yyyy" 
						 onfocusout="dateCompare();">
						<label class="input-group-addon btn" for="startDateTime">
						   <span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>
				<div class="col-ms-4 col-xs-12 col-md-1" style="font-weight: bold; padding-top: 2px; padding-right: 0px;font-size: 15px;">End Time:</div>
			    <div class="col-ms-8 col-xs-12 col-md-3">
					<div class="input-group date">
						<input name="endDateTime" id="endDateTime" type="text" class="form-control dateClassForTime" placeholder="mm/dd/yyyy" 
						 onfocusout="dateCompare();">
						<label class="input-group-addon btn" for="endDateTime">
						   <span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>
				<div class="col-md-2 col-xs-12">
					<button type="button" id="showData" class="btn btn-success btn-sm pull-left">
					  <i class="glyphicon glyphicon-search"></i> Show Data
					</button>
				</div>
				<div class="col-md-2 col-xs-12">
					<button type="button" id="editLog" onclick="loadEditedLogDetails();" class="btn btn-success btn-sm pull-right">
					  <i class="glyphicon glyphicon-eye-open"></i> Edit Log Details
					</button>
				</div>
			</div> 
			<div id="warMsg" style="text-align: left; font-weight: bold; color: red;"></div>
			<div id="table_loading" style="text-align: center; display:none">
                       <i class="fa fa-refresh fa-spin" style="font-size:35px"></i>
            </div>
			<div class="col-md-12" style="overflow-x:auto;display:none;" id="hideShow">
				<table id="loadUtilizationReportTable" class="table table-hover table-bordered table-responsive" style="width:100%">
				   <thead>
					<tr style="background-color:#2e4050; color: white;">
					  <th style="width: 10%;">Sl No</th>
					  <th>Start Time</th>
					  <th>End Time</th>                               
					  <th>Duration(hh:mm:ss)</th>
					  <th>Reason Code</th>					  
                      <th>Action</th>					  
					</tr>
					</thead>
				</table>
			</div>
			
		</div>				
		</div>
	
		<div class="row">
             
		 </div>
	</div>
</div>

<script type="text/javascript">
var globalUtilizationData=new Array();
var reasonArray;
var reasonId=0;
var myMap = new Map();
$(document).ready(function(){

	$(".loader").fadeOut("slow");
	$('#comp_id').val(<?php echo $_GET['com'];?>);
	$('#plant_id').val(<?php echo $_GET['pla'];?>);
	$('#workCenter_id').val(<?php echo $_GET['wor'];?>);
	$('#iobotMachine').val(<?php echo $_GET['io'];?>);	
      		
	// Fetch GET method data from URL	
	$.urlParam = function(name){
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		return results[1] || 0;
	}
    $('.dateClassForTime').datetimepicker();
    $("#showData").attr("disabled", "disabled");
   	 getReasonForDropdown();
	 
	 $("#btnExport1").click(function(e) {
       $('#loadEditedLogDetailsTable').table2excel();
     });

});

function dateCompare(){
	debugger;
   var startDate = new Date($('#startDateTime').val());
   var endDate = new Date($('#endDateTime').val());
   if (startDate == null || startDate == "Invalid Date")  {
	   $("#warMsg").text("*Select Start time!");
	   return;
   } else {
	   if (startDate != null && endDate != null && startDate != "Invalid Date" && endDate != "Invalid Date") {
		 if (startDate.getTime() > endDate.getTime()) {    
			  $("#warMsg").text("*Start time is greater than the End Time!");
			  $("#showData").prop('disabled', true);
			  return;
		  } else {
			  $("#warMsg").text("");
			  $("#showData").prop('disabled', false);
			  return;
		  }
	   }    
   }
};

$("#showData").click(function(){
	debugger;
   $('#hideShow').hide();
   loadUtilizationReportPopData();
   $("#editLog").prop('disabled', false);

});

function getDateFormate(date){
  debugger;
  var dt=date.split(' ');
  var onlyDate=dt[0].split('-');
  return onlyDate[2]+'-'+onlyDate[1]+'-'+onlyDate[0]+'  '+dt[1];
  //alert(sl[0]);
};

function getDiffHourMin(startDate,endDate){
  var startDate = new Date(startDate);
  var endDate = new Date(endDate);
  var difference = Math.abs(startDate.getTime() - endDate.getTime())/1000;
  var hourDifference = parseInt(difference / 3600);
  var minDiff = parseInt(Math.abs(difference / 60) % 60);
  var secDiff = (difference % 60);
  return addZero(hourDifference)+':'+addZero(minDiff)+':'+addZero(secDiff);
};

function addZero(num) {
  if (num < 10) {
      num = "0" + num;
  }
  return num;
};

function editIdleTimeRow(id, st, et, ireaonCodeNo, index, prevReasonName){
    $('#startDateTime1').val(st);
    $('#endDateTime1').val(et);
	$('#reasonDBId').val(id);
	$('#index').val(index);//prevReason
	$('#prevReasonCode').val(ireaonCodeNo);
	$('#prevReasonName').val(prevReasonName);
	$("#reasonCodeName option").remove();
	if(reasonArray != null){
		for(var i=0; i< reasonArray.length; i++){
			 //$('#reasonCodeName').append($("<option></option>").attr("value",reasonArray[i].reasonId).text(reasonArray[i].reasonMesg));
			    $("#reasonCodeName").append('<option value="'+reasonArray[i].reasonId+'">'+reasonArray[i].reasonMesg+'</option>');
		}
		$('#configManpowerMaterial').modal({show:true});
	}else {
		alertify.alert('<p style="color:red;font-weight:600;">Reason Codes not added in user role.</p>');
	}
    //$("#reasonCodeName").val(ireaonCodeNo);
};

function loadUtilizationReportPopData(){
	$('#table_loading').show();
	var prevIdleEndTime = '';
    var globalDataLength=0;
	var comp_id=$('#comp_id').val();
	var plant_id=$('#plant_id').val();
	var workCenter_id=$('#workCenter_id').val();
	var iobotMachine= $('#iobotMachine').val();
    var startDate = $('#startDateTime').val();
    var endDate = $('#endDateTime').val();
    var j=0;
	
	var myData = {idleData:'idleData',comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine,
	inTime:startDate, outTime:endDate};
        $.ajax({
            type:"POST",
            url:"getConfigIdleData.php",
            async: false,
            dataType: 'json',
			data: myData,
            success: function(obj){
				debugger;
			$('#table_loading').hide();
			if(obj.data !=null){
				   
				$('#hideShow').show();
				globalUtilizationData=[];
				debugger;
				for(var i=0;i<obj.data.length;i++){
					
					 if(prevIdleEndTime != obj.data[i].reason_code){ 
						  globalUtilizationData.push({"message":obj.data[i].message,"start_time":obj.data[i].start_time,"end_time":obj.data[i].end_time, "table_id":obj.data[i].table_id, 
						  "reason_code":obj.data[i].reason_code, "arrayIndex":j, "color":obj.data[i].color, "isEdited":obj.data[i].is_edited_reason});
						  
						   prevIdleEndTime = obj.data[i].reason_code;
						   globalDataLength=globalUtilizationData.length;
						   j++;
					 } else {
						  globalUtilizationData[globalDataLength-1].end_time=obj.data[i].end_time;
						  prevIdleEndTime = obj.data[i].reason_code;
					 }
				 
				}
				  //debugger;
	   var DataTableProject = $('#loadUtilizationReportTable').DataTable( {
				"paging":false,
				"ordering":true,
				"info":true,
				"searching":true,         
				"destroy":true,
				"scrollX": true,
				"scrollY": 350,
				"data":globalUtilizationData,   
				"columns": [
				  {data:null,"SlNo":false,className: "text-center"},
				  
				  { data: "start_time",
					render: function (data, type, row, meta) {
						return getDateFormate(row.start_time);
					}
				  },  
				  
				  { data: "end_time", 
					render: function (data, type, row, meta) {
						return getDateFormate(row.end_time);
					}
				  },
				  
				  { data: null,"Duration":false,className: "text-right",
					render: function (data, type, row, meta) {
						return getDiffHourMin(row.start_time,row.end_time);
					}
				  }, 
				  
				 { data: "message",
					render: function (data, type, row, meta) {
						return '<span style=color:'+row.color+';font-weight:bold;>'+row.message+'</sanp>';
					}
				 },
				 
				 { data: null ,
					render: function (data, type, row, meta) {
					  debugger; 
					  if(row.reason_code == 33 || row.reason_code == 34){
					    var a='<button class="btn btn-info btn-xs" onclick="editIdleTimeRow(\''+row.table_id+'\',\''+row.start_time+'\',\''+row.end_time+'\','+row.reason_code+','+row.arrayIndex+',\''+row.message+'\');" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
					    return a;
					  } else if(row.isEdited == 1){
					     var a='<button class="btn btn-info btn-xs" onclick="editIdleTimeRow(\''+row.table_id+'\',\''+row.start_time+'\',\''+row.end_time+'\','+row.reason_code+','+row.arrayIndex+',\''+row.message+'\');" style="background-color: #5cb85c;"> <i class="glyphicon glyphicon-saved" aria-hidden="true"></i> Edit</button>';
					     return a;
				      } else {
					     var a='<button class="btn btn-info btn-xs" onclick="editIdleTimeRow(\''+row.table_id+'\',\''+row.start_time+'\',\''+row.end_time+'\','+row.reason_code+','+row.arrayIndex+',\''+row.message+'\');" style="visibility: hidden;"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
					     return a;
					  }
					}
				  }			  
				]
			   });   
			DataTableProject.on( 'order.dt search.dt', function () {
			  DataTableProject.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
					  cell.innerHTML = i+1;
				  } );
			  } ).draw();
			} else{
				$('#warMsg').html('No Data available');
			}	
			
        }
     });
};

function getReasonForDropdown(){
	debugger;
	var reasonCodes=$('#reasonCode').val();
	var myData = {getReason:'getReason',reasonCodes:reasonCodes};
	myMap.clear();
	$.ajax({
            type:"POST",
            url:"getConfigIdleData.php",
            async: false,
            dataType: 'json',
			data: myData,
            success: function(obj){
				if(obj.data !=null){
			    	 reasonArray = JSON.parse(JSON.stringify(obj.data));
					 console.log(reasonArray);
					 if(reasonArray != null){
					   for(var i=0; i< reasonArray.length; i++){					   
						myMap.set(reasonArray[i].reasonId, reasonArray[i].color);
  
					   }
					 }
				}
			}
         });
};

function saveEditedIdleTime(){
	var inDBId = $('#reasonDBId').val();
	var rcNum = $('#reasonCodeName').val();
	var rcMessage = $("#reasonCodeName option:selected").text();
	var startTime = $('#startDateTime1').val();
	var endTime = $('#endDateTime1').val();
	var indx = $("#index").val();
	var userName = $(".userLogin").text();
	var prevReasonCode = $('#prevReasonCode').val();
    var myData = {updateReasonChanged:'updateReasonChanged', iobotName:inDBId, reasonCodeNo:rcNum, reasonMesg:rcMessage,
	              start_time:startTime, end_time:endTime, reasonCodeNoPrev:prevReasonCode, userName:userName};
	$.ajax({
            type:"POST",
            url:"getConfigIdleData.php",
            async: false,
            dataType: 'json',
			data: myData,
            success: function(obj){ 
				if(obj.data !=null){
				  if(obj.data.infoRes =='S'){
					globalUtilizationData[indx].message = rcMessage;
					globalUtilizationData[indx].reason_code = rcNum;
					globalUtilizationData[indx].color = myMap.get(rcNum);
					globalUtilizationData[indx].isEdited= 1;
					populateTableDataAfterEdit();
					alertify.alert('<p style="color:green;font-weight:600;">'+obj.data.info+'</p>');
					$('#startDateTime1').val('');
					$('#endDateTime1').val('');
					$('#reasonDBId').val('');
					$('#reasonCodeName').val('');
					$("#index").val('');
					$('#prevReasonCode').val('');
					$('#configManpowerMaterial').modal('hide');
				   }else{
					   alertify.alert('<p style="color:green;font-weight:600;">'+obj.data.info+'</p>');
				   }
			  }else{
				 alertify.alert('<p style="color:red;font-weight:600;">Error While Saving, Pls Try Again</p>');
			  } 
		  }
      });
};

function populateTableDataAfterEdit(){
	   var DataTableProject = $('#loadUtilizationReportTable').DataTable( {
            "paging":false,
            "ordering":true,
            "info":true,
            "searching":true,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 350,
            "data":globalUtilizationData,   
            "columns": [
              {data:null,"SlNo":false,className: "text-center"},
			  
              { data: "start_time",
                render: function (data, type, row, meta) {
                    return getDateFormate(row.start_time);
                }
              },  
			  
              { data: "end_time", 
                render: function (data, type, row, meta) {
                    return getDateFormate(row.end_time);
                }
              },
			  
              { data: null,"Duration":false,className: "text-right",
                render: function (data, type, row, meta) {
                    return getDiffHourMin(row.start_time,row.end_time);
                }
              }, 
			  
			  { data: "message",
				 render: function (data, type, row, meta) {
						return '<span style=color:'+row.color+';font-weight:bold;>'+row.message+'</sanp>';
					}
			  },
			 
             { data: null ,
                render: function (data, type, row, meta) {
                  debugger; 
				  if(row.reason_code == 33 || row.reason_code == 34){
					var a='<button class="btn btn-info btn-xs" onclick="editIdleTimeRow(\''+row.table_id+'\',\''+row.start_time+'\',\''+row.end_time+'\','+row.reason_code+','+row.arrayIndex+',\''+row.message+'\');" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
					return a;
				  } else if(row.isEdited == 1){
					var a='<button class="btn btn-info btn-xs" onclick="editIdleTimeRow(\''+row.table_id+'\',\''+row.start_time+'\',\''+row.end_time+'\','+row.reason_code+','+row.arrayIndex+',\''+row.message+'\');" style="background-color: #5cb85c;"> <i class="glyphicon glyphicon-saved" aria-hidden="true"></i> Edit</button>';
					return a;
				  } else {
					var a='<button class="btn btn-info btn-xs" onclick="editIdleTimeRow(\''+row.table_id+'\',\''+row.start_time+'\',\''+row.end_time+'\','+row.reason_code+','+row.arrayIndex+',\''+row.message+'\');" style="visibility: hidden;"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
					return a;
				  }
                }
              }			  
            ]
           });   
        DataTableProject.on( 'order.dt search.dt', function () {
          DataTableProject.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                  cell.innerHTML = i+1;
              } );
          } ).draw(); 
}; 

function loadEditedLogDetails(){
    debugger;
	$('#loadEditedLogDetails').modal({show:true});
      setTimeout(function(){
         loadEditedLogReportPopData(); 
      }, 200);
};

function loadEditedLogReportPopData(){
	var comp_id=$('#comp_id').val();
	var plant_id=$('#plant_id').val();
	var workCenter_id=$('#workCenter_id').val();
	var iobotMachine= $('#iobotMachine').val();
	debugger;
	var myData = {editedLogData:'editedLogData',comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine};
        $.ajax({
            type:"POST",
            url:"getConfigIdleData.php",
            async: false,
            dataType: 'json',
			data: myData,
            success: function(obj){
				debugger;
			if(obj.data !=null){
	        var DataTableProject = $('#loadEditedLogDetailsTable').DataTable( {
				"paging":false,
				"ordering":true,
				"info":true,
				"searching":true,         
				"destroy":true,
				"scrollX": true,
				"scrollY": 350,
				"data":obj.data,   
				"columns": [
				  {data:null,"SlNo":false,className: "text-center"},
				  { data: "user_name",
					render: function (data, type, row, meta) {
						return '<span style=font-weight:bold;>'+row.user_name+'</sanp>';
					}
				  },
				  
				  { data: "start_time",
					render: function (data, type, row, meta) {
						return getDateFormate(row.start_time);
					}
				  },  
				  
				  { data: "end_time", 
					render: function (data, type, row, meta) {
						return getDateFormate(row.end_time);
					}
				  },
				  
				  { data: "edited_time", 
					render: function (data, type, row, meta) {
						return getDateFormate(row.edited_time);
					}
				  }, 
				  
				 { data: "prev_message",
					render: function (data, type, row, meta) {//myMap
						return '<span style=color:'+myMap.get(row.prev_reason)+';font-weight:bold;>'+row.prev_message+'</sanp>';
					}
				 },
				 { data: "current_message",
					render: function (data, type, row, meta) {
						return '<span style=color:'+myMap.get(row.current_reason)+';font-weight:bold;>'+row.current_message+'</sanp>';
					}
				 }		  
				]
			   });   
			DataTableProject.on( 'order.dt search.dt', function () {
			  DataTableProject.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
					  cell.innerHTML = i+1;
				  } );
			  } ).draw();
			} 
        }
     });
};

</script>
<input type="hidden" name="reasonCode" id="reasonCode"/> 
 <!-- Manpower & Material config Dialog  -->
 <div id="configManpowerMaterial" class="modal fade"  role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" >
    <div class="modal-content">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title"><i class="fa fa-list-alt" aria-hidden="true"></i> CHANGE IDLE TIME</h4>
            </div>
            <div class="modal-body"> 
			 
			   <div class="col-md-12">
					 <div class="col-md-12 col-ms-12 col-xs-12  form-group">
						 <div class="col-md-4 col-ms-12 col-xs-12 font-s">
							<span style="font-weight: bold; font-size: 15px;">Start Time : </span>
						 </div>
						   <div class="col-md-8 col-ms-12 col-xs-12">
							<input name="startDateTime1" id="startDateTime1" type="text" class="form-control" readonly/>
						 </div>
					 </div>
				  
					<div class="col-md-12 col-ms-12 col-xs-12 form-group">
						 <div class="col-md-4 col-ms-12 col-xs-12 font-s">
						   <span style="font-weight: bold; font-size: 15px;">End Time : </span>
						 </div>
						 <div class="col-md-8 col-ms-12 col-xs-12">
							<input name="endDateTime1" id="endDateTime1" type="text" class="form-control" readonly/>
						 </div>
					</div>
					<div class="col-md-12" style="padding-bottom: 5px;">
						  <div class="col-md-4 col-ms-12 col-xs-12 font-s"style="font-weight: bold; font-size: 15px;">
						   Prev Reason : 
						  </div>
						  <div class="col-md-8 col-ms-12 col-xs-12" style="padding-right: 12px;padding-left: 14px;">
							<input name="prevReasonName" id="prevReasonName" type="text" class="form-control"  readonly/>
						  </div>
				   </div>
					<div class="col-md-12" style="padding-bottom: 5px;">
						<div class="col-md-12 col-ms-12 col-xs-12  form-group">
						  <div class="col-md-4 col-ms-12 col-xs-12 font-s"style="font-weight: bold; font-size: 15px;">
						   Reason : 
						  </div>
						  <div class="col-md-8 col-ms-12 col-xs-12" style="padding-right: 0px;padding-left: 10px;">
							<select class="form-control" id="reasonCodeName">  
							</select>
						  </div>
						</div>
				   </div>
				   <div id="reasonDBId" style="visibility: hidden;"></div>
				   <div id="index" style="visibility: hidden;"></div>
				   <div id="prevReasonCode" style="visibility: hidden;"></div>
			  </div>		   
			 <div class="col-md-12" style="text-align: center;">
				<span style="margin-right: 4px;">
				    <button type="button"  onclick="saveEditedIdleTime();" class="btn btn-info btn-md">Save </button>
				</span>
				<span style="margin-right: 4px;">
				    <button type="button" onclick="" class="btn btn-danger btn-md" class="close" data-dismiss="modal">Cancel</button>
				</span>
			 </div>
            </div>
            <div class="modal-footer" style="border-top:none;">
            </div>
    </div>
  </div>
</div> 



<!-- Edited reason code log Report -->
<div id="loadEditedLogDetails" class="modal fade"  role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:90%;">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-list-alt" aria-hidden="true"></i> Edited Log Details</h4>
            </div>
            <div class="modal-body">
              <div id="moreInfoBody">
                  <div class="table-responsive">
                    <button type="button" id="btnExport1" class="btn btn-success btn-sm pull-left">
                      <i class="glyphicon glyphicon-save"></i> Export
                    </button>

                    <!-- <span class="pull-right"> <b>* Time in (hh:mm:ss) </b> </span> -->
                       <table id="loadEditedLogDetailsTable" class="table table-hover table-bordered table-responsive" style="width:100%">
                           <thead>
                            <tr style="background-color: #2e4050; color: white;">
                              <th style="width: 10%;">Sl No</th>
                              <th>Edited By</th>
                              <th>Start Time</th>
                              <th>End Time </th>                               
                              <th>Edited Date Time</th>
                              <th>Previous Reason</th>
                              <th>Current Reason</th>							  
                            </tr>
                            </thead>
                        </table>
                    </div>          
              </div>
            
            </div>
            <div class="modal-footer" style="border-top:none;"></div>
    </div>
  </div>
</div> 

</body>
</html>
