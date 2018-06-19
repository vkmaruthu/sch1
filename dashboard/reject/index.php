<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<style>
.tFormat {
     font-weight: bold;
     padding-top: 10px;
}

.tborder {
 border: 1px #a98787 solid;

}
.talign {
  text-align: center;
}
</style>

<script type="text/javascript">


/* Shift Variables */
var Ghours=null;  
var GinTime=null;   
var GoutTime=null; 
var GtotalHour=null;  
var GstartHour=null;
var ShiftGobalData=null;
var GdbStartHour=null;
var equipGobalData=null;


var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalRejectData=new Array();
var poGlobalArray=new Array();
var qcGlobalArray=new Array();
tempData.oeereject=
{
loadAllRjectData:function(start_time, end_time, qCode, eq_code, plantId){
  debugger;
  var comp_id =  $('#comp_id').val();
  var url="getDataController.php";
  var myData={getRejCount:"getRejCount", plant_id:plantId, comp_id:comp_id, quality_codes_id:qCode, start_time:start_time, end_time:end_time, eq_code:eq_code };
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){
            globalRejectData=obj.rejectCount;
        if(obj.rejectCount==null){
          $('#rejectTable').DataTable({
             "paging":false,
             "ordering":true,
             "info":true,
             "searching":false,         
             "destroy":true,
          }).clear().draw();

        }else{
            
    var DataTableProject = $('#rejectTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "destroy":true,
            "data":obj.rejectCount,   
            "columns": [           
              { data: "start_time" },
              { data: "end_time" },
              { data: "count",className: "text-right" },
              { data: "reason_message"},
              { data: "descp"},
            ]
           });
           } // else End here    //image_file_name

          } // ajax success ends
        });   

},

reload:function(){
   location.reload(true);
},
getQualityCode:function(){
	  var url="getDataController.php";
	  var compId = $('#comp_id').val();
	  var myData = {getQualityCode:'getQualityCode', comp_id:compId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	      if(obj.getQC !=null){
	    	  qcGlobalArray = obj.getQC;
	        }
	      } 
	});
},
getPlantsForFilterDropdown:function(){
	  var url="getDataController.php";
	  var compId = $('#comp_id').val();
	  var myData = {getPlantDetails:'getPlantDetails', comp_id:compId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	      if(obj.plantDetails !=null){
     	         $("#plantSave").html('');
      		for(var i=0; i< obj.plantDetails.length; i++){
  			   $("#plantSave").append('<option value="'+obj.plantDetails[i].id+'">'+obj.plantDetails[i].plant_desc+'</option>'); 
      		}
      	    $("#plantSave").val(obj.plantDetails[0].id).change();
	        }
	      } 
	});
},
getPlantsForTableFilter:function(){
	  var url="getDataController.php";
	  var compId = $('#comp_id').val();
	  var myData = {getPlantDetails:'getPlantDetails', comp_id:compId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	      if(obj.plantDetails !=null){
           	 $("#plants").html('');
      		for(var i=0; i< obj.plantDetails.length; i++){
  			   $("#plants").append('<option value="'+obj.plantDetails[i].id+'">'+obj.plantDetails[i].plant_desc+'</option>');  
      		}
      	    $("#plants").val(obj.plantDetails[0].id).change();
	        }
	      } 
	});
},

clearForm:function(){
    $('#order_number').prop('readonly', false);
    $("#plantSave").prop("disabled", false);
    $('#fromReject')[0].reset();
    $("#fromReject").fadeToggle("slow");
    $("#addReject").show();
    $("#updateReject").hide();
    $("#equi_code").val(0).change();
    $("#wc_name").val(0).change();
    //$("#shift_id").val(0).change();
    $("#dropHide").fadeToggle("slow");
    tempData.oeereject.getPlantsForFilterDropdown();
},

getWCDesc:function(plantId){	
	  var url="getDataController.php";
	  var comp_id=$('#comp_id').val();
	  var myData={getWCDetails:"getWCDetails",plant_id:plantId, comp_id:comp_id};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    data:myData,
	    success: function(obj) {
	    	 $("#wc_name").html('');
	    	 $("#wc_name").append('<option value="0"> Select Work Center </option>');
		      if(obj.wcDetails !=null){
	        		for(var i=0; i< obj.wcDetails.length; i++){
	    			   $("#wc_name").append('<option value="'+obj.wcDetails[i].id+'">'+obj.wcDetails[i].wc_desc+'</option>'); 
	        		}
		        }
		      }   
         });
},
getForTableDropdownWCDesc:function(plantId){	
	  var url="getDataController.php";
	  var comp_id=$('#comp_id').val();
	  var myData={getWCDetails:"getWCDetails",plant_id:plantId, comp_id:comp_id};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    data:myData,
	    success: function(obj) {
	    	 $("#d_wc").html('');
	    	 $("#d_wc").append('<option value="0"> Select Work Center </option>');
		      if(obj.wcDetails !=null){
	        		for(var i=0; i< obj.wcDetails.length; i++){
	    			   $("#d_wc").append('<option value="'+obj.wcDetails[i].id+'">'+obj.wcDetails[i].wc_desc+'</option>'); 
	        		}
		        }
		      }   
       });
},
getEquipmentDesc:function(wc_id){	
	  var url="getDataController.php";
	  var comp_id=$('#comp_id').val();
	  var myData={getEquipmentDetails:"getEquipmentDetails",wc_id:wc_id, comp_id:comp_id};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    data:myData,
	    success: function(obj) {
	    	 $("#equi_code").html('');
	    	 $("#equi_code").append('<option value="0"> Select Equipment </option>');
		      if(obj.equipmentDetails !=null){
	        		for(var i=0; i< obj.equipmentDetails.length; i++){
	    			   $("#equi_code").append('<option value="'+obj.equipmentDetails[i].eq_code+'">'+obj.equipmentDetails[i].eq_desc+'</option>'); 
	        		}
		        }
		      }   
       });
},
getEquipmentDescForTableDropdown:function(wc_id){	
	  var url="getDataController.php";
	  var comp_id=$('#comp_id').val();
	  var myData={getEquipmentDetails:"getEquipmentDetails",wc_id:wc_id, comp_id:comp_id};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    data:myData,
	    success: function(obj) {
	    	 $("#d_equip").html('');
	    	 $("#d_equip").append('<option value="0"> Select Equipment </option>');
		      if(obj.equipmentDetails !=null){
	        		for(var i=0; i< obj.equipmentDetails.length; i++){
	    			   $("#d_equip").append('<option value="'+obj.equipmentDetails[i].eq_code+'">'+obj.equipmentDetails[i].eq_desc+'</option>'); 
	        		}
		        }
		      }   
     });
},
getPOData:function(plantId, eq_code){
	  var comp_id =  $('#comp_id').val();
	  if(plantId != 0){
	  var url="getDataController.php";
	  var myData={getPODetails:"getPODetails", plant_id:plantId, comp_id:comp_id, eq_code:eq_code};
	       $.ajax({
	            type:"POST",
	            url:url,
	            async: false,
	            dataType: 'json',
	            data:myData,
	            success: function(obj){
	            poGlobalArray =null;
	   	    	 $("#order_number").html('');
		    	 $("#order_number").append('<option value="0"> Select PO </option>');
			      if(obj.poDetails !=null){
			    	  poGlobalArray = obj.poDetails;
		        		for(var i=0; i< obj.poDetails.length; i++){
		    			   $("#order_number").append('<option value="'+obj.poDetails[i].id+'">'+obj.poDetails[i].order_number+'/'+obj.poDetails[i].operation+'</option>'); 
		        		}
			        }
	                
	            }
	        });   
	  }
},

loadShiftData:function(plantId){
    var selDate = $("#userDateSel").val();
    var url= "getDataController.php";
    var comp_id=$('#comp_id').val();
    var plant_id=plantId;
    var workCenter_id=$('#wc_name').val();
    var iobotMachine= $('#equi_code').val();  
    var myData = {loadShiftData:'loadShiftData',selDate:selDate,comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine };
        $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj) {
            	ShiftGobalData = null;
              if(obj.shiftData != null){
               ShiftGobalData=obj.shiftData;
               $("#shift_id").html('');
                for(var i=0;i<obj.shiftData.length;i++)
                {
                   if(obj.shiftData[i].shift != 0){
                        $("#shift_id").append('<option value="'+obj.shiftData[i].id+'"> Shift-'+
                            obj.shiftData[i].shift+' '+obj.shiftData[i].dateFormat+'</option>');
                    }
                } 
                $("#shift_id").val(obj.shiftData[0].id).change();
              }else{
                $("#shift_id").html('');
                $("#shift_id").html('<option value="0">Select Shift</option>');
              }            
                                                   
            }
        });
},

loadShiftDataForFilter:function(plantId){
    var selDate = $("#userDateSel").val();
    var url= "getDataController.php";
    var comp_id=$('#comp_id').val();
    var plant_id=plantId;
    var workCenter_id=$('#wc_name').val();
    var iobotMachine= $('#equi_code').val();  
    var myData = {loadShiftData:'loadShiftData',selDate:selDate,comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine };
        $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj) {
            	ShiftGobalData = null;
              if(obj.shiftData != null){
               ShiftGobalData=obj.shiftData;
               $("#d_shift_id").html('');
                for(var i=0;i<obj.shiftData.length;i++)
                {
                   if(obj.shiftData[i].shift != 0){
                        $("#d_shift_id").append('<option value="'+obj.shiftData[i].id+'"> Shift-'+
                                obj.shiftData[i].shift+' '+obj.shiftData[i].dateFormat+'</option>');
                    }
                } 
                $("#d_shift_id").val(obj.shiftData[0].id).change();
              }else{
                $("#d_shift_id").html('');
                $("#d_shift_id").html('<option value="0">Select Shift</option>');
              }            
                                                   
            }
        });
},
shiftsdataFilter:function(){  
     var shift= $('#d_shift_id').val();
     var singalJosn=tempData.oeereject.getObjects(ShiftGobalData,'id',shift);
     var get3Data= tempData.oeereject.getCommonDataForShift(singalJosn[0]); // Passing all Selected Shift Data
     // hours,inTime,outTime,totalHour,startHour
     tempData.oeereject.AfterShiftSelect(get3Data[0].hour,get3Data[0].inTime,get3Data[0].outTime,parseInt(singalJosn[0].num_hourss),get3Data[0].startHour,singalJosn[0].hour_start);
},
shiftsdata:function(){  
    var shift= $('#shift_id').val();
    var singalJosn=tempData.oeereject.getObjects(ShiftGobalData,'id',shift);
    var get3Data= tempData.oeereject.getCommonDataForShift(singalJosn[0]); // Passing all Selected Shift Data
    // hours,inTime,outTime,totalHour,startHour
    tempData.oeereject.AfterShiftSelect(get3Data[0].hour,get3Data[0].inTime,get3Data[0].outTime,parseInt(singalJosn[0].num_hourss),get3Data[0].startHour,singalJosn[0].hour_start);
},
AfterShiftSelect:function(hours,inTime,outTime,totalHour,startHour,dbStartHour){
       // hours,inTime,outTime,totalHour,startHour
       Ghours=hours;  GinTime=inTime;   GoutTime=outTime;  GtotalHour=totalHour;  GstartHour=startHour;
       GdbStartHour=dbStartHour;
},
getObjects:function(obj, key, val) {  // JSON Search function
   var objects = [];
   for (var i in obj) {
       if (!obj.hasOwnProperty(i)) continue;
       if (typeof obj[i] == 'object') {
           objects = objects.concat(tempData.oeereject.getObjects(obj[i], key, val));
       } else if (i == key && obj[key] == val) {
           objects.push(obj);
       }
   }
   return objects;    
},
convertTime:function(time){
    var d;
    d = new Date(time);
    d.setSeconds(d.getSeconds() - 1);
    return tempData.oeereject.addZero(d.getHours()) + ':'+tempData.oeereject.addZero(d.getMinutes()) + ':' + tempData.oeereject.addZero(d.getSeconds());
},
convertTimeWithOutOneSec:function(time){
    var d;
    d = new Date(time);
    return tempData.oeereject.addZero(d.getHours()) + ':'+tempData.oeereject.addZero(d.getMinutes()) + ':' + tempData.oeereject.addZero(d.getSeconds());
},
addZero:function(num) {
    if(num < 10) {
        num = "0"+num;
    }
    return num;
},
getCommonDataForShift:function(obj){
  var arr=[];
  var hours = parseInt(obj.num_hourss)*60*60;
  var inTime = tempData.oeereject.convertTimeWithOutOneSec(obj.in_time);
  var outTime = tempData.oeereject.convertTime(obj.out_time);
  var d = new Date(obj.in_time);
    arr.push({"hour":hours,"inTime":inTime,"outTime":outTime,"startHour":d.getHours()});
    return arr;
},
filter:function(){  
	tempData.oeereject.shiftsdataFilter();
	if($("#userDateSel").val() != '' &&  $('#plants').val() !=0){
		var plantId = $('#plants').val();
    	var startDate = tempData.oeereject.dateFormat($("#userDateSel").val());
    	var endDate = startDate;
    	 if(GinTime > GoutTime){
    		 endDate = tempData.oeereject.dateAddDay(startDate);
    	 }
    	 startDate = startDate+' '+GinTime
    	 endDate = endDate+' '+GoutTime
    	 if($('#d_equip').val() !=0 && $('#d_equip').val() !=''){
    		 tempData.oeereject.loadAllRjectData(startDate, endDate, 2, $('#d_equip').val(),plantId);
         }else{
        	 alert("Select Equipment");
          }
	 }else{
         alert("Select Plant");
	 }
},
createRejectInput:function(shift_id){
   tempData.oeereject.shiftsdata();
   var content= '';
   var Gcontent = '';
   $('#shiftTable').html('');
   var j = 0;
   var lstartH = GstartHour;
   var userDate = tempData.oeereject.dateFormat($('#userDateSel').val());
   for(var i=0 ; i < GtotalHour ; i++){
       if((j+lstartH) == 24){
         j=0; lstartH=0;
         userDate=tempData.oeereject.dateAddDay(userDate+' 00:00:00');
        }
       content = '  <tr id="'+parseInt(lstartH+j)+'"><td width="10%"><div class=" tFormat talign">'+parseInt(lstartH+j)+':00 - '+parseInt(lstartH+j+1)+':00</div></td> '+
       '<td><div class="col-md-7 col-sm-7 col-xs-7"><input onkeyup="tempData.oeereject.calculation(\''+"kg_"+parseInt(lstartH+j)+'\');" id="kg_'+parseInt(lstartH+j)+'" type="number" min="0" step="0.01" value="0" class="form-control" /></div><div class="col-md-2 col-sm-2 col-xs-2 tFormat">Kg</div></td>'+
       '<td><select class="form-control select2 loadVal"  id="qc_'+parseInt(lstartH+j)+'" name="qc_'+parseInt(lstartH+j)+'"></select></td> '+
       '<td><div class="col-md-8 col-sm-8 col-xs-8"><input id="cort_'+parseInt(lstartH+j)+'" type="number" min="0" step="0.01"  value="0" class="form-control" readonly style="text-align: right;" /></div><div class="col-md-4 col-sm-4 col-xs-4 tFormat">Cartons</div></td>'+ 
       '<td hidden><div class="col-md-8 col-sm-8 col-xs-8"><input id="rev_'+parseInt(lstartH+j)+'" type="number" min="0" step="0.01"  value="0" class="form-control" readonly /></div><div class="col-md-4 col-sm-4 col-xs-4 tFormat">Revolutions</div></td>'+
       '<td><button type="button" id="btn_'+parseInt(lstartH+j)+'" class="btn btn-success btn-xs" onclick="tempData.oeereject.insertReject(\''+"H_"+parseInt(lstartH+j)+'\');" title="Calculate" style="display:none;"><i class="fa fa-floppy-o"> Save </i></button></td> </tr> '+
       '<input type="hidden" name="d_'+parseInt(lstartH+j)+'" id="d_'+parseInt(lstartH+j)+'" value="'+userDate+'" /> ';
       Gcontent += content;
       content = '';
       j++;
   }
   j=0;
   $('#shiftTable').append(Gcontent);
   Gcontent = '';
   for(var i=0;i<qcGlobalArray.length;i++)
   {
       if(qcGlobalArray[i].shift != 0){
           $(".loadVal").append('<option value="'+qcGlobalArray[i].id+'">'+qcGlobalArray[i].reason_message+'</option>');
       }
   }
},
dateFormat:function(date){
    var Date = date.split('/');
    return Date[2]+'-'+Date[1]+'-'+Date[0];
},
dateAddDay:function(val) {
    var newdate = new Date(val);
    newdate.setDate(newdate.getDate() + 1);
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var someFormattedDate = y + '-' +mm + '-' + dd ;
    return someFormattedDate;
},
calculation:function(val){	
	if(val !=null && $('#mul_factor').val() !=0){
		var hrs = val.split('_')[1];
		if($('#kg_'+hrs).val() != 0){
    		var cort = ($('#kg_'+hrs).val()/$('#kg').val());
    		cort = Math.round(cort * 10000) / 10000;
    		$('#cort_'+hrs).val(cort);
    		var rev = (cort / ($('#mul_factor').val()));
    		rev = Math.round(rev);
    		$('#rev_'+hrs).val(rev);
		}else{
			//alert('Enter the reject quantities first.');
		}
		$('#btn_'+hrs).show();
	}else {
		alert('Select PO Number');
	}
}, 
insertReject:function(val){	
	if(val !=null && ($('#data_info_id').val() !=0)){
	var hrs = val.split('_')[1];
	if($('#rev_'+hrs).val() !=0 ){ 
		    var dataTime = $('#d_'+hrs).val();
    		var startDT = dataTime + ' '+tempData.oeereject.addZero(hrs)+':25:00';
    		var endDT = dataTime + ' '+tempData.oeereject.addZero(hrs)+':35:00';
    		var dinfoId = $('#data_info_id').val();
    		var count = $('#rev_'+hrs).val();
    		var qualityCode =$('#qc_'+hrs).val();
    		tempData.oeereject.saveReject(startDT,endDT,count, qualityCode, dinfoId, hrs);
		}else {
			alert('First Calculate Data on '+hrs+' Hrs To '+parseInt(parseInt(hrs)+1)+' Hrs');
		}
		
	}else {
		alert('Select First PO Number');
	}
},
saveReject:function(startDT, endDT, count, qualityCode, data_info_id, hrs){
	  var url="getDataController.php";
	  var myData = {insertRej:"insertRej", start_time:startDT, end_time:endDT, count:count, quality_codes_id:qualityCode, data_info_id:data_info_id};
	  $.ajax({
          type:"POST",
          url:url,
          async: false,
          dataType: 'json',
          data:myData,
	    success: function(obj) {
	        debugger;
	      if(obj.data !=null){
	        if(obj.data.infoRes=='S'){
	           $("#commonMsg").show();
	           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
	           $("#btn_"+hrs).remove();
	           $("#cal_"+hrs).remove();
	           $("#kg_"+hrs).prop('disabled', true);
	           $("#qc_"+hrs).prop('disabled', true);
	        }else{
	          $("#commonMsg").show();
	          $('#commonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
	        }  
	      } 
	      setTimeout(function(){  
	        $("#commonMsg").fadeToggle('slow');        
	      }, 1500);

	    }
	});
},
common:function(){
	$("#wc_name").html('');
	$("#wc_name").append('<option value="0"> Select Work Center </option>');     
    $("#wc_name").prop("disabled", true); 
    $("#equi_code").html('');
    $("#equi_code").append('<option value="0"> Select Equipment </option>');
    $("#equi_code").prop("disabled", true);
    $("#order_number").html('');
    $("#order_number").append('<option value="0"> Select PO </option>');
	$("#order_number").prop("disabled", true);
    $("#shift_id").html('');
    $("#shift_id").html('<option value="0">Select Shift</option>');
    $("#shift_id").prop("disabled", true);
    $("#shiftTable").html('');
	$('#mul_factor').val(0);
    $('#data_info_id').val(0); 
}

};

$(document).ready(function() {
debugger;

  $('.select2').select2();  
  $('#commonMsg').hide();
  $("#fromReject").hide();
  $("#workcenters").prop("disabled", true); 
  $("#wc_name").prop("disabled", true); 
  $("#equi_code").prop("disabled", true);
  $("#shift_id").prop("disabled", true);
  var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  $('.datepicker-me').datepicker('setDate', today);
  
  $('#createReject').click(function(){
	  tempData.oeereject.clearForm();
  });

  $('#cancel').click(function(){
	  tempData.oeereject.clearForm();
  });

  $('#plantSave').change(function(){
      $('#msg').html('');
  });
  $('#wc_name').change(function(){
      $('#msg').html('');
  });
  $('#equi_code').change(function(){
      $('#msg').html('');
  });
  $('#shift_id').change(function(){
 	 tempData.oeereject.createRejectInput();	
 });
  
  $("#equi_code").append('<option value="0"> Select Equipment </option>');
  $("#equi_code").prop("disabled", true);

  $('#equi_code').change(function(){ 
	  if(($('#equi_code').val() != 0) && ($('#equi_code').val() != null)){
		  tempData.oeereject.getPOData($('#plantSave').val(), $('#equi_code').val());
	      $("#order_number").prop("disabled", false);
	  }else{
		 $("#order_number").html('');
   	     $("#order_number").append('<option value="0"> Select PO </option>');
     	 $("#order_number").prop("disabled", true);
	  }
  });
  
  $('#plantSave').change(function(){	  
      if($('#plantSave').val() != 0){
         tempData.oeereject.getWCDesc($('#plantSave').val());
         tempData.oeereject.loadShiftData($('#plantSave').val())  
         $("#wc_name").prop("disabled", false); 
         $("#shift_id").prop("disabled", false);  
  	     $('#mul_factor').val(0);
         $('#data_info_id').val(0); 
      }else{  
    	  tempData.oeereject.common();
      }
   });
  $('#wc_name').change(function(){	  
      if($('#wc_name').val() != 0){
         tempData.oeereject.getEquipmentDesc($('#wc_name').val()); 
         $("#equi_code").prop("disabled", false);        
      }else {
   	     $("#equi_code").html('');
   	     $("#equi_code").append('<option value="0"> Select Equipment </option>');
   	     $("#equi_code").prop("disabled", true);
   	     $("#order_number").html('');
   	     $("#order_number").append('<option value="0"> Select PO </option>');
     	 $("#order_number").prop("disabled", true);
      }
   });
   $('#order_number').change(function(){
      if($('#order_number').val() != 0){
  		 for(var i=0; i< poGlobalArray.length; i++){
  	  		if($('#order_number').val() == poGlobalArray[i].id){
      	          $('#mul_factor').val(poGlobalArray[i].no_of_items_per_oper);
      	          $('#data_info_id').val(poGlobalArray[i].data_info_id);
      	          break;
  	  	      }
  	  		}
       }else {
    	   $('#mul_factor').val(0);
           $('#data_info_id').val(0); 
       }	  
   });
/*    $('#userDateSel').change(function(){ 
       tempData.oeereject.getPlantsForFilterDropdown();
       tempData.oeereject.getPlantsForTableFilter();
       tempData.oeereject.common();
   });  */

   $('#plants').change(function(){ 
      if($('#plants').val() != 0){
          tempData.oeereject.getForTableDropdownWCDesc($('#plants').val()); 
          $("#d_wc").prop("disabled", false);
          tempData.oeereject.loadShiftDataForFilter($('#plants').val())  
          $("#shift_id").prop("disabled", false); 
     	  $("#d_equip").html('');
    	  $("#d_equip").append('<option value="0"> Select Equipment </option>');
          $("#d_equip").prop("disabled", true);   
                
       }else {
	     $("#d_wc").html('');
	     $("#d_wc").append('<option value="0"> Select Work Center </option>');
	     $("#d_wc").prop("disabled", true);
	     $("#d_equip").html('');
	     $("#d_equip").append('<option value="0"> Select Equipment </option>');
  	     $("#d_equip").prop("disabled", true);
  	     $("#shift_id").html('');
         $("#shift_id").html('<option value="0">Select Shift</option>');
         $("#shift_id").prop("disabled", true);
       }
    });
   $('#d_wc').change(function(){ 
	      if($('#d_wc').val() != 0){
	          tempData.oeereject.getEquipmentDescForTableDropdown($('#d_wc').val()); 
	          $("#d_equip").prop("disabled", false);        
	       }else {
		     $("#d_equip").html('');
		     $("#d_equip").append('<option value="0"> Select Equipment </option>');
	  	     $("#d_equip").prop("disabled", true);
	       }
	});
    tempData.oeereject.loadAllRjectData();
    tempData.oeereject.getPlantsForFilterDropdown();
    tempData.oeereject.getPlantsForTableFilter();
    tempData.oeereject.getQualityCode();
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Reject<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">           
        
        </div>
             <div class="col-md-3 pull-left">
              <label class="control-label col-md-4">Date: </label>  
                <div class='col-md-8 input-group date datepicker-me' data-provide="datepicker">
                <input type='text' class="form-control" id='userDateSel' name="userDateSel" 
                       style="cursor: pointer;" readonly="readonly"/>
                  <label class="input-group-addon btn" for="userDateSel">
                      <span class="glyphicon glyphicon-calendar"></span>               
                  </label>
              </div>
           </div> 
          <div class="col-md-3 pull-left">

          </div> 
            
            <button type="button" onclick="tempData.oeereject.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
            </button>
            <button type="button" id="createReject" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
                  <i class="fa fa-pencil-square-o"></i>&nbsp; Add Reject
            </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <div id="delCommonMsg"> </div> 
        <div id="commonMsg"> </div>  
        <form class="" id="fromReject" enctype="multipart/form-data">     
          <input type="hidden" name="comp_id" id="comp_id"/>
          <input type="hidden" name="plant_id" id="plant_id"/>  
           <input type="hidden" name="data_info_id" id="data_info_id"/>  
            <div class="form-group">
               <div class="row" style="margin-bottom: 0px;">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Plant <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="plantSave" name="plantSave" style="width:100%;">
                          <option value="0">Select Plant</option>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Work Center<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control select2"  id="wc_name" name="wc_name" style="width:100%;">
                        </select>
                    </div>
                </div>
              </div>
              
              <div class="row" style="margin-top: 0px;">
                    <div class="col-md-6">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Equipment<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control select2"  id="equi_code" name="equi_code" style="width:100%;">
                            </select>
                        </div>
                    </div>    
                 
                   <div class="col-md-6">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">PO Number/Opern <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control select2"  id="order_number" name="order_number" style="width:100%;">
                            </select>
                        </div>
                   </div>
              </div>
                    

               
              <div class="row" style="margin-top: 10px;">
               <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Shift:</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control select2"  id="shift_id" name="shift_id" style="width:100%;">
                    <option value="0">Select Shift</option>
                    </select>
                </div>
                </div>
                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">1 Carton Equal To </label>
                    <div class="col-md-4 col-sm-4 col-xs-10">
                      <input type="number" min="1" step="0.01" value="4.16" name="kg" id="kg" class="form-control" />
                    </div><span style="vertical-align: -webkit-baseline-middle; font-weight: 600;">Kg</span>
                </div>
              </div> 
              
              <div class="row" style="margin-top: 10px;">
               <div class="col-md-6">
                    <div class="col-md-4 col-sm-4 col-xs-10">
                      <input type="hidden" min="0" step="0.01" value="0" name="mul_factor" id="mul_factor" class="form-control" readonly/>
                    </div>
                   </div>
               </div>
             
              </div>
          
              <div class="row" style="margin-top: 10px;  padding-left: 5px; padding-right: 5px;">
                <div class="col-md-12">
                  <table  class="table table-bordered table-hover nowarp tborder"  style="font-size: 12px;">  
                  	<tbody id="shiftTable"></tbody>
                  </table>
               </div>
                 <div class="col-md-12 text-center">
                     <button type="button" id="cancel" onclick="" class="btn btn-sm btn-danger"><i class="fa fa-close"></i>&nbsp; Cancel
                    </button>
                   </div>
                 <span style="padding-left: 20px;color : #6f5757;">* Note : Select all the fields before entering the rejects. Once data is saved you can't edit.</span>
              </div>
              
            </div>  
           <hr class="hr-primary"/>  
          </form>
     </div>     
 <div class="row" id="dropHide">
       <div class="table-responsive"> 
        <div class="col-sm-12" >
                <label>Select:</label>
                   <select class="form-control select2"  id="plants" name="plants" style="width : auto;">
                      <option value="0">Select Plant</option>
                   </select>
                   
                   <select class="form-control select2"  id="d_wc" name="d_wc" style="width : auto;">
                      <option value="0">Select Work Center</option>
                   </select>
                   
                   <select class="form-control select2"  id="d_equip" name="d_equip" style="width : auto;">
                      <option value="0">Select Equipment</option>
                   </select>
                   
                    <select class="form-control select2"  id="d_shift_id" name="d_shift_id" style="width:auto;">
                       <option value="0">Select Shift</option>
                    </select>

                  <button type="button" id="refresh" onclick="tempData.oeereject.filter();" 
                	    class="btn btn-sm btn-primary pull-right" style="padding-top: 6px;margin-left:15px;">
                 	    Load Data
                  </button>
                  <div id="msgFilter"></div>
       
        </div>
        
          <table  id="rejectTable" class="table table-bordered table-hover nowarp" style="font-size: 12px;">
           <thead>
             <tr>       
               <th>Start Time</th>
               <th>End Time</th>
               <th>Cartons</th>  
               <th>Reason</th>  
               <th>Equipment</th>
             </tr>
           </thead>
           </table>

         </div>
   </div>      
         

    </div>
   </div>       
   </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php //include('../common/footer.php'); ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <!-- <div class="control-sidebar-bg"></div> -->
</div>
<!-- ./wrapper -->

        

</body>
</html>
