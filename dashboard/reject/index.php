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
tempData.oeereject=
{
loadAllRjectData:function(){
  debugger;
  var plantId = $('#plants').val();
  var comp_id =  $('#comp_id').val();
  var url="getDataController.php";
  var myData={getPODetails:"getPODetails22", plant_id:plantId, comp_id:comp_id};
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){
            globalRejectData=obj.poDetails;
            $('#plants').val('');
        if(obj.poDetails==null){
          $('#poTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

        }else{
            
    var DataTableProject = $('#poTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "destroy":true,
            "data":obj.poDetails,   
            "columns": [           
              { data: "order_number" },
              { data: "wc_name" },
              { data: "equi_code" },
              { data: "conf_no", className: "text-right" },
              { data: "target_qty",className: "text-right"},
              { data: "line_feed_qty",className: "text-right"},
              { data: "conf_yield",className: "text-right"},
              { data: "conf_scrap",className: "text-right"},
              { data: "plant_desc"},
              { data: "eq_desc"},
              { data: "id" ,className: "text-left",
                  render: function (data, type, row, meta) {
                    var result = "";
                    if(row.is_final_confirmed == 1){
                    	result='<button type="button" class="btn btn-success btn-xs" onclick="" title="Completed PO"><i class="fa fa-check"></i> Completed </button>';
                    }else if(row.eq_code == "" || row.eq_code == null){ 
                       result ='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeereject.assingPOModal('+row.id+',\''+row.plant_id+'\');" title="Assign PO"><i class="fa fa-flag"> Assign </i></button>';
                    }else {
                       var d='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeereject.stopPOModal('+row.id+',\''+row.plant_id+'\');" title="Stop PO"><i class="fa fa-stop"> Stop </i></button>';
                       var e='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeereject.completePOModal('+row.id+',\''+row.plant_id+'\');" title="Complete PO"><i class="fa fa-remove"> Complete </i></button>';
                       result = d+' '+e
                    }
                    return result;
                  }
              },
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  if(row.is_final_confirmed != 1){
                  var a='<button type="button" title="Edit" class="btn btn-primary btn-xs" onclick="tempData.oeereject.editReject('+row.id+',\''+row.plant_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
                  var b='<button type="button" title="Delete" class="btn btn-danger btn-xs" onclick="tempData.oeereject.deleteReject('+row.id+');"><i class="fa fa-trash"></i> </button>';
                  return a+' '+b;
                  }else{
                	  return "";
                  }
                }
              },
               ]
           });

           } // else End here    //image_file_name

          } // ajax success ends
        });   

},


editReject:function (id, wcId){
    for(var i=0;i<globalRejectData.length;i++){
        if(id==globalRejectData[i].id){
          $('#po_id').val(globalRejectData[i].id);
          $('#order_number').val(globalRejectData[i].order_number);
          $('#line_feed_qty').val(globalRejectData[i].line_feed_qty);
          $('#target_qty').val(globalRejectData[i].target_qty);
          $('#conf_no').val(globalRejectData[i].conf_no);
          $('#order_number').prop('readonly', true);

          $('#plantSave').val(globalRejectData[i].plant_id).change();       
          $("#wc_name option:contains(" + globalRejectData[i].wc_name + ")").attr('selected', 'selected').change();
          $('#equi_code').val(globalRejectData[i].equi_code).change();

          $("#wc_name").prop("disabled", true); 
          $("#equi_code").prop("disabled", true);
          $("#plantSave").prop("disabled", true); 
          break;
        }
    }
    $("#fromReject").fadeIn("fast");
    $("#addReject").hide();
    $("#updateReject").show();            
},
deleteReject:function (id){
  var url="getDataController.php";
  var myData={deleteReject:"deleteReject",po_id:id};
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
           $("#delCommonMsg").show();
           $('#delCommonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-trash"></i> '+obj.data.info+'</p>');
           tempData.oeereject.loadAllRjectData();
        }else{
          $("#delCommonMsg").show();
           $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
        }  
      } 
      setTimeout(function(){ 
           $("#delCommonMsg").fadeToggle('slow'); 
       }, 1500);
    }
  });

},
reload:function(){
   location.reload(true);
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
         	 $("#plants").html('');
	    	 $("#plants").append('<option value="0"> Select Plant </option>');
        		for(var i=0; i< obj.plantDetails.length; i++){
    			   $("#plants").append('<option value="'+obj.plantDetails[i].id+'">'+obj.plantDetails[i].plant_desc+'</option>'); 
        		}

        	  $("#plantSave").html('');
	    	  $("#plantSave").append('<option value="0"> Select Plant </option>');
        		for(var i=0; i< obj.plantDetails.length; i++){
    			   $("#plantSave").append('<option value="'+obj.plantDetails[i].id+'">'+obj.plantDetails[i].plant_desc+'</option>'); 
        	   }
	        }
	      } 
	});
},

filter:function(){
	   tempData.oeereject.loadAllRjectData();
},
clearForm:function(){
    $('#order_number').prop('readonly', false);
    $("#plantSave").prop("disabled", false);
    $('#fromReject')[0].reset();
    $("#fromReject").fadeToggle("slow");
    $("#addReject").show();
    $("#updateReject").hide();
    $("#plantSave").val(0).change();
    $("#equi_code").val(0).change();
    $("#wc_name").val(0).change();
    //$("#shift_id").val(0).change();
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
       content = '  <tr id="'+parseInt(lstartH+j)+'"><td><div class=" tFormat talign">'+parseInt(lstartH+j)+' Hrs To '+parseInt(lstartH+j+1)+' Hrs</div></td> '+
       '<td><div class="col-md-7 col-sm-7 col-xs-7"><input id="kg_'+parseInt(lstartH+j)+'" type="number" min="0" step="0.01" value="0" class="form-control" /></div><div class="col-md-2 col-sm-2 col-xs-2 tFormat">Kg</div><div class="col-md-3 col-sm-3 col-xs-3 tFormat"><button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeereject.calculation(\''+"H_"+parseInt(lstartH+j)+'\');" title="Calculate"><i class="fa fa-calculator"> Cal </i></button></div></td>'+
       '<td><div class="col-md-8 col-sm-8 col-xs-8"><input id="cort_'+parseInt(lstartH+j)+'" type="number" min="0" step="0.01"  value="0" class="form-control" readonly /></div><div class="col-md-4 col-sm-4 col-xs-4 tFormat">Cortans</div></td>'+ 
       '<td><div class="col-md-8 col-sm-8 col-xs-8"><input id="rev_'+parseInt(lstartH+j)+'" type="number" min="0" step="0.01"  value="0" class="form-control" readonly /></div><div class="col-md-4 col-sm-4 col-xs-4 tFormat">Rev</div></td>'+
       '<td><button type="button" id="btn_'+parseInt(lstartH+j)+'" class="btn btn-success btn-xs" onclick="tempData.oeereject.insertReject(\''+"H_"+parseInt(lstartH+j)+'\');" title="Calculate"><i class="fa fa-floppy-o"> Save </i></button></td></tr> '+
       '<input type="hidden" name="d_'+parseInt(lstartH+j)+'" id="d_'+parseInt(lstartH+j)+'" value="'+userDate+'" /> ';
       Gcontent += content;
       content = '';
       j++;
   }
   j=0;
   $('#shiftTable').append(Gcontent);
   Gcontent = '';
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
			alert('Enter the reject quantities first.');
		}
	}else {
		alert('Select First PO Number');
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
    		var qualityCode = 2;
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

  var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  $('.datepicker-me').datepicker('setDate', today);
  
  $('#createReject').click(function(){
	  tempData.oeereject.clearForm();
	  var date = new Date();
	  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
	  $('.datepicker-me').datepicker('setDate', today);
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
   $('#userDateSel').change(function(){
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
       tempData.oeereject.getPlantsForFilterDropdown();
   });

    tempData.oeereject.loadAllRjectData();
    tempData.oeereject.getPlantsForFilterDropdown();
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
             <div class="col-md-4 pull-left"> 
              <label class="control-label col-md-2">Date: </label>  
                <div class='input-group date datepicker-me' data-provide="datepicker">
                <input type='text' class="form-control" id='userDateSel' name="userDateSel" 
                       style="cursor: pointer;" readonly="readonly"/>
                  <label class="input-group-addon btn" for="userDateSel">
                      <span class="glyphicon glyphicon-calendar"></span>               
                  </label>
              </div>
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
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-md-6 "> 
 
            </div>
           <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Shift <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control select2"  id="shift_id" name="shift_id" style="width:100%;">
                    </select>
                </div>
           </div>
            </div>
               <div class="row" style="margin-bottom: 0px;">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Plant <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="plantSave" name="plantSave" style="width:100%;">
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
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">1 Carton Equal To </label>
                    <div class="col-md-4 col-sm-4 col-xs-10">
                      <input type="number" min="1" step="0.01" value="4.16" name="kg" id="kg" class="form-control" />
                    </div><span style="vertical-align: -webkit-baseline-middle; font-weight: 600;">Kg</span>
                    </div>
               <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">1 Rev Equal To </label>
                    <div class="col-md-4 col-sm-4 col-xs-10">
                      <input type="number" min="0" step="0.01" value="0" name="mul_factor" id="mul_factor" class="form-control" readonly/>
                    </div><span style="vertical-align: -webkit-baseline-middle; font-weight: 600;">Cartons</span>
                   </div>
               </div>
              </div>
              <span style="padding-left: 20px;color : #6f5757;">* Note : Select all the fields before entering the rejects. Once data is saved you can't edit.</span>
              <div class="row" style="margin-top: 10px;  padding-left: 5px; padding-right: 5px;">
                <div class="col-md-12">
                     <table id="shiftTable" class="table table-bordered table-hover nowarp tborder" style="font-size: 12px;">
                           
                      </table>
               </div>
              </div>
              
              <div class="row">
                <div id="msg" style="padding-left: 28px;color: red;"></div>
                   <div class="col-md-12 text-center">
                     <button type="button" id="cancel" onclick="" class="btn btn-sm btn-danger"><i class="fa fa-close"></i>&nbsp; Cancel
                    </button>
                   </div>
              </div>
            </div>  
           <hr class="hr-primary"/>  
          </form>

       <div class="table-responsive"> 
        <div class="col-sm-12">
            <div>
                <label>Select:  
                   <select class="form-control select2"  id="plants" name="plants" style="width : auto;">
                      <option value="0">Select Plant</option>
                   </select>
                   
                   <select class="form-control select2"  id="d_wc" name="d_wc" style="width : auto;">
                      <option value="0">Select Work Center</option>
                   </select>
                   
                   <select class="form-control select2"  id="d_equip" name="d_equip" style="width : auto;">
                      <option value="0">Select Equipment</option>
                   </select>
                   
                  <button type="button" id="refresh" onclick="tempData.oeereject.filter();" 
                	    class="btn btn-sm btn-primary pull-right" style="padding-top: 6px;margin-left:15px;">
                 	    <i class="fa  fa-refresh"></i>
                  </button>
                  <div id="msgFilter"></div>
                </label>
            </div>
        </div>
        
          <table id="poTable" class="table table-bordered table-hover nowarp" style="font-size: 12px;">
           <thead>
             <tr>       
               <th>Start Time</th>
               <th>End Time</th>
               <th>Count</th>  
               <th>Quality Type</th>  
               <th>Equipment</th>
               <th>Action</th> 
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
