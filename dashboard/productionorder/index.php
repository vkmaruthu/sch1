<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalPOData=new Array();
var wcArray=new Array();
tempData.oeeprodorder=
{
loadAllPO:function(){
  debugger;
  var plantId = $('#plants').val();
  var comp_id =  $('#comp_id').val();
  var url="getDataController.php";
  var myData={getPODetails:"getPODetails", plant_id:plantId, comp_id:comp_id};
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){
            globalPOData=obj.poDetails;
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
              { data: "material" },
              { data: "operation" },
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
                       result ='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeprodorder.assingPOModal('+row.id+',\''+row.plant_id+'\');" title="Assign PO"><i class="fa fa-flag"> Assign </i></button>';
                    }else {
                       var d='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeprodorder.stopPOModal('+row.id+',\''+row.plant_id+'\');" title="Stop PO"><i class="fa fa-stop"> Stop </i></button>';
                       var e='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeprodorder.completePOModal('+row.id+',\''+row.plant_id+'\');" title="Complete PO"><i class="fa fa-remove"> Complete </i></button>';
                       result = d+' '+e
                    }
                    return result;
                  }
              },
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  if(row.is_final_confirmed != 1){
                  var a='<button type="button" title="Edit" class="btn btn-primary btn-xs" onclick="tempData.oeeprodorder.editPO('+row.id+',\''+row.plant_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
                  var b='<button type="button" title="Delete" class="btn btn-danger btn-xs" onclick="tempData.oeeprodorder.deletePO('+row.id+');"><i class="fa fa-trash"></i> </button>';
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
savePO:function(){
  var url="getDataController.php";
  $('#material_name').val($("#material option:selected" ).text());
  var order_number=$('#order_number').val();
  if($('#plantSave').val() == 0){
      $('#msg').html('*Select Plant');
      return false;
   }else {
	   $('#msg').html('');
   }
  if(order_number == "") {
        $('#order_number').css('border-color', 'red');
        return false;
   }else{
       $('#order_number').css('border-color', '');
       if($('#material').val() == 0){
    	    $('#msg').html('*Select Material');
    	    return false;
    	}else {
    		$('#msg').html('');
    	}
	   
       if($('#operation').val() == 0){
    	    $('#msg').html('*Select Operation');
    	    return false;
    	}else {
    		$('#msg').html('');
    	}

       var fromPOData = new FormData($('#fromPO')[0]);
       fromPOData.append("savePO", "savePO");
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    data:fromPOData,
    success: function(obj) {
        debugger;
      if(obj.data !=null){
        if(obj.data.infoRes=='S'){
           $("#commonMsg").show();
           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
           tempData.oeeprodorder.loadAllPO();
           tempData.oeeprodorder.clearForm();

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

}, 
editPO:function (id, wcId){
    for(var i=0;i<globalPOData.length;i++){
        if(id==globalPOData[i].id){
          $('#po_id').val(globalPOData[i].id);
          $('#order_number').val(globalPOData[i].order_number);
          $('#line_feed_qty').val(globalPOData[i].line_feed_qty);
          $('#target_qty').val(globalPOData[i].target_qty);
          $('#conf_no').val(globalPOData[i].conf_no);
          $('#order_number').prop('readonly', true);

          $('#plantSave').val(globalPOData[i].plant_id).change();       
          $("#material option:contains(" + globalPOData[i].material + ")").attr('selected', 'selected').change();
          $('#operation').val(globalPOData[i].operation).change();

          $("#material").prop("disabled", true); 
          $("#operation").prop("disabled", true);
          $("#plantSave").prop("disabled", true); 
          break;
        }
    }
    $("#fromPO").fadeIn("fast");
    $("#addPO").hide();
    $("#updatePO").show();            
},
deletePO:function (id){
  var url="getDataController.php";
  var myData={deletePO:"deletePO",po_id:id};
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
           tempData.oeeprodorder.loadAllPO();
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
	   tempData.oeeprodorder.loadAllPO();
},
clearForm:function(){
    $('#order_number').prop('readonly', false);
    $("#plantSave").prop("disabled", false);
    $('#fromPO')[0].reset();
    $("#fromPO").fadeToggle("slow");
    $("#addPO").show();
    $("#updatePO").hide();
    $("#plantSave").val(0).change();
    $("#operation").val(0).change();
    $("#material").val(0).change();
    $('#material_name').val('');
},
getParts:function(){
	  var url="getDataController.php";
	  var compId = $('#comp_id').val();
	  var plantId = $('#plantSave').val();
	  var myData = {getPartsDetails:'getPartsDetails', comp_id:compId, plant_id:plantId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
    	 $("#material").html('');
    	 $("#material").append('<option value="0"> Select Material </option>');
	      if(obj.partsDetails !=null){
        		for(var i=0; i< obj.partsDetails.length; i++){
    			   $("#material").append('<option value="'+obj.partsDetails[i].id+'">'+obj.partsDetails[i].part_num+'</option>'); 
        		}
	        }
	      } 
	});
},
getOperation:function(){
	  var url="getDataController.php";
	  var part_id = $('#material').val() ;
	  var myData = {getOperation:'getOperation', part_id:part_id};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
  	     $("#operation").html('');
  	     $("#operation").append('<option value="0"> Select Operation </option>');
	      if(obj.oprDetails !=null){
      		for(var i=0; i< obj.oprDetails.length; i++){
  			   $("#operation").append('<option value="'+obj.oprDetails[i].opr_num+'">'+obj.oprDetails[i].opr_num+'/'+obj.oprDetails[i].opr_name+'</option>'); 
      		}
	        }
	      } 
	});
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
assingPOModal:function(id, plantId){
	$('#assignPOModal').modal('show');
    for(var i=0;i<globalPOData.length;i++){
        if(id==globalPOData[i].id){
        	 $('#po_number').val(globalPOData[i].order_number);
             $('#oper_no').val(globalPOData[i].operation);
             $('#lin_feed_qty').val(globalPOData[i].line_feed_qty);
             $('#mat_name').val(globalPOData[i].material);
             $('#targ_qty').val(globalPOData[i].target_qty);
             $("#wc_name").val(globalPOData[i].wc_desc);
             $('#po_assign_id').val(id);
          break;
        }   
   }
    tempData.oeeprodorder.getWCDesc(plantId);
},
assignPOToEq:function(){
	  var url="getDataController.php";
	  var fromPartData = new FormData($('#fromAssignPO')[0]);
	  fromPartData.append("assignPO", "assignPO");
	  var lin_feed_qty=$('#lin_feed_qty').val();
	    if(lin_feed_qty == "" || lin_feed_qty == 0) {
	        $('#lin_feed_qty').css('border-color', 'red');
	        return false;
	    }else{
	      $('#lin_feed_qty').css('border-color', '');
	      
	       $('#order_number').css('border-color', '');
	       if($('#equi_code').val() == 0){
	    	    $('#modalMsg').html('*Select Equipment');
	    	    return false;
	    	}else {
	    		$('#modalMsg').html('');
	    	}	      
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    processData: false,
	    contentType: false,
	    data:fromPartData,
	    success: function(obj) {
	        debugger;
	      if(obj.data !=null){
	        if(obj.data.infoRes=='S'){
		       $('#assignPOModal').modal('hide');
	           $("#commonMsg").show();
	           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
	           $('#fromAssignPO')[0].reset();
		       $('#po_assign_id').val('');
		       $("#equi_code").html('');
		       $("#equi_code").append('<option value="0"> Select Equipment </option>');
	            tempData.oeeprodorder.loadAllPO();
	        }else{
		      $('#assignPOModal').modal('hide');
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
},
stopPOModal:function(id, plantId){
	$('#stopPOModal').modal('show');
    for(var i=0;i<globalPOData.length;i++){
        if(id==globalPOData[i].id){
        	 $('#stop_po_number').val(globalPOData[i].order_number);
             $('#stop_oper_no').val(globalPOData[i].operation);
             $('#stop_targ_qty').val(globalPOData[i].target_qty);
             $("#stop_yield_qty").val(globalPOData[i].conf_yield);
             $("#stop_scrap_qty").val(globalPOData[i].conf_scrap);
             $('#stop_po_assign_id').val(id);
             $('#stop_equi_code').val(globalPOData[i].eq_code);
          break;
        }   
   }
},
removePOFromEq:function(){
	  var url="getDataController.php";
	  var fromPartData = new FormData($('#fromStopPO')[0]);
	  fromPartData.append("stopPO", "stopPO");
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    processData: false,
	    contentType: false,
	    data:fromPartData,
	    success: function(obj) {
	        debugger;
	      if(obj.data !=null){
	        if(obj.data.infoRes=='S'){
	           $("#commonMsg").show();
	           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
	           $('#fromStopPO')[0].reset();
		       $('#stop_po_assign_id').val('');
		       $('#stop_po_number').val('');
		       $('#stopPOModal').modal('hide');
		        $('#stop_equi_code').val('');
	            tempData.oeeprodorder.loadAllPO();
	        }else{
		      $('#stopPOModal').modal('hide');
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
completePOModal:function(id, plantId){
		$('#completePOModal').modal('show');
	    for(var i=0;i<globalPOData.length;i++){
	        if(id==globalPOData[i].id){
	        	 $('#com_po_number').val(globalPOData[i].order_number);
	             $('#com_oper_no').val(globalPOData[i].operation);
	             $('#com_targ_qty').val(globalPOData[i].target_qty);
	             $("#com_yield_qty").val(globalPOData[i].conf_yield);
	             $("#com_scrap_qty").val(globalPOData[i].conf_scrap);
	             $('#com_po_assign_id').val(id);
	             $('#com_equi_code').val(globalPOData[i].eq_code);
	          break;
	        }   
	   }
},
finalConfirm:function(){
	  var url="getDataController.php";
	  var fromPartData = new FormData($('#fromComPO')[0]);
	  fromPartData.append("completePO", "completePO");
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    processData: false,
	    contentType: false,
	    data:fromPartData,
	    success: function(obj) {
	        debugger;
	      if(obj.data !=null){
	        if(obj.data.infoRes=='S'){
	           $("#commonMsg").show();
	           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
	           $('#fromStopPO')[0].reset();
		       $('#com_po_assign_id').val('');
		       $('#com_po_number').val('');
		       $('#com_equi_code').val('');
		       $('#completePOModal').modal('hide');
	            tempData.oeeprodorder.loadAllPO();
	        }else{
		      $('#completePOModal').modal('hide');
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
  $("#fromPO").hide();
  $("#workcenters").prop("disabled", true); 
  $("#material").prop("disabled", true); 
  $("#operation").prop("disabled", true);
  $('#createPO').click(function(){
	  tempData.oeeprodorder.clearForm();
  });
  $('#cancel').click(function(){
	  tempData.oeeprodorder.clearForm();
  });
  $('#order_number').keyup(function(){
     $('#order_number').css('border-color', '');
  });
  $('#plantSave').change(function(){
      $('#msg').html('');
  });
  $('#material').change(function(){
      $('#msg').html('');
  });
  $('#operation').change(function(){
      $('#msg').html('');
  });
  $('#equi_code').change(function(){
      $('#modalMsg').html('');
  });
  $("#equi_code").append('<option value="0"> Select Operation </option>');
  $("#equi_code").prop("disabled", true);
  $('#plantSave').change(function(){	  
      if($('#plantSave').val() != 0){
         tempData.oeeprodorder.getParts();  
         $("#material").prop("disabled", false);   
      }else{  
   	     $("#material").html('');
   	     $("#material").append('<option value="0"> Select Material </option>');     
         $("#material").prop("disabled", true); 
         $("#operation").html('');
   	     $("#operation").append('<option value="0"> Select Operation </option>');
   	     $("#operation").prop("disabled", true);
      }
   });
  
  $('#material').change(function(){	  
      if($('#material').val() != 0){
         tempData.oeeprodorder.getOperation(); 
         $("#operation").prop("disabled", false);        
      }else {
   	     $("#operation").html('');
   	     $("#operation").append('<option value="0"> Select Operation </option>');
   	     $("#operation").prop("disabled", true);
      }
   });

  $('#wc_name').change(function(){	  
      if($('#wc_name').val() != 0){
         tempData.oeeprodorder.getEquipmentDesc($('#wc_name').val()); 
         $("#equi_code").prop("disabled", false);        
      }else {
   	     $("#equi_code").html('');
   	     $("#equi_code").append('<option value="0"> Select Operation </option>');
   	     $("#equi_code").prop("disabled", true);
      }
   });
  
    tempData.oeeprodorder.loadAllPO();
    tempData.oeeprodorder.getPlantsForFilterDropdown();
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Production Order<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left"> </div>
            <button type="button" onclick="tempData.oeeprodorder.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
            </button>
            <button type="button" id="createPO" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
                  <i class="fa fa-pencil-square-o"></i>&nbsp; Add Production Order
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
        <form class="" id="fromPO" enctype="multipart/form-data">     
          <input type="hidden" name="comp_id" id="comp_id"/>
          <input type="hidden" name="plant_id" id="plant_id"/> 
          <input type="hidden" name="wc_id" id="wc_id"/> 
          <input type="hidden" name="eq_id" id="eq_id"/> 
          <input type="hidden" name="po_id" id="po_id"/>             
            <div class="form-group">
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
                 <label class="control-label col-md-4 col-sm-6 col-xs-12">PO Number <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="order_number" id="order_number" placeholder="Production Order Number" maxlength="20" class="form-control" required="true" autofocus/>
                  </div>
                </div>
              </div>
              
              <div class="row" style="margin-top: 0px;">
                   <input type="hidden" name="material_name" id="material_name"/> 
                    <div class="col-md-6">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12"> Material <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control select2"  id="material" name="material" style="width:100%;">
                          <option value="0">Select Material</option>
                          </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12"> Operation <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control select2"  id="operation" name="operation" style="width:100%;">
                          <option value="0">Select Operation</option>
                          </select>
                        </div>
                    </div>
              </div>
                          
              <div class="row" style="margin-top: 10px;">
               <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Target Quantity<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" value="0" name="target_qty"  maxlength="15" id="target_qty" onkeyup=""
                       placeholder="Target Qty" class="form-control" required="true"/>
                    </div>
                </div>
               <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Line feed Quantity</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" value="0" name="line_feed_qty"  maxlength="15" id="line_feed_qty" onkeyup=""
                       placeholder="Line Feed Qty" class="form-control" required="true" value="0"/>
                    </div>
               </div>
              </div>
              
              <div class="row" style="margin-top: 10px;">
                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Confirmation Number</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" value="0" name="conf_no"  maxlength="15" id="conf_no" onkeyup=""
                       placeholder="Confirmation Number" class="form-control" required="true"/>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
              </div>
              
              <div class="row">
                <div id="msg" style="padding-left: 28px;color: red;"></div>
                   <div class="col-md-12 text-center">
                    <button type="button" id="addPO" onclick="tempData.oeeprodorder.savePO();" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Save 
                    </button>
                    <button type="button" id="updatePO" onclick="tempData.oeeprodorder.savePO();" class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update
                    </button>
                     <button type="button" id="cancel" onclick="" class="btn btn-sm btn-danger"><i class="fa fa-close"></i>&nbsp; Cancel
                    </button>
                   </div>
              </div>
            </div>  
           <hr class="hr-primary"/>  
          </form>

       <div class="table-responsive"> 
        <div class="col-sm-6">
            <div>
                <label>Filter By:  
                   <select class="form-control select2"  id="plants" name="plants" style="width : auto;">
                      <option value="0">Select Plants</option>
                   </select>
                   
                  <button type="button" id="refresh" onclick="tempData.oeeprodorder.filter();" 
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
               <th>PO Number</th>
               <th>Material</th>
               <th>Operation</th>  
               <th>Confirmation No.</th>
               <th>Target Qty</th>
               <th>Line Feed Qty</th>
               <th>Confirmed Yield</th>
               <th>Confirmed Scrap</th>
               <th>Plant</th>
               <th>Equipment</th>
               <th>PO Action</th>
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

<!-- Assign production order modal -->

    <div class="modal fade" id="assignPOModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Assign Production Order</h4>
          </div>
          <form id="fromAssignPO" enctype="multipart/form-data">
           <input type="hidden" name="po_assign_id" id="po_assign_id"/> 
           <div class="modal-body">          
               <div class="row">                                  
                    <div class="col-md-12" >
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">PO Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="po_number" id="po_number" onkeyup=""
                           placeholder="" class="form-control"  required="true" readonly/>
                        </div>
                    </div>
                    
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Material</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="mat_name" id="mat_name" onkeyup=""
                           placeholder="" class="form-control"  required="true" readonly/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Operation</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="oper_no" id="oper_no" onkeyup=""
                           placeholder="" class="form-control"  required="true" readonly/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Target Quantity</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="targ_qty" id="targ_qty" onkeyup=""
                           placeholder="" class="form-control" required="true" readonly/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Line Feed Quantity <span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="lin_feed_qty" id="lin_feed_qty" onkeyup=""
                           placeholder="Line Feed Qty" class="form-control"  required="true"/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Work Center</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control select2"  id="wc_name" name="wc_name" style="width:100%;">
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Equipment<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control select2"  id="equi_code" name="equi_code" style="width:100%;">
                            </select>
                        </div>
                    </div>
                </div>
                <div id="modalMsg" style="color: red;"></div>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" onclick="tempData.oeeprodorder.assignPOToEq();" >Assign</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    
    
    <!-- Stop production order modal -->

    <div class="modal fade" id="stopPOModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Stop Production Order</h4>
          </div>
          <form id="fromStopPO" enctype="multipart/form-data">
           <input type="hidden" name="stop_po_assign_id" id="stop_po_assign_id"/> 
             <input type="hidden" name="stop_equi_code" id="stop_equi_code"/> 
           <div class="modal-body">          
               <div class="row">                                  
                    <div class="col-md-12" >
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">PO Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="stop_po_number" id="stop_po_number" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Operation</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="stop_oper_no" id="stop_oper_no" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Target Quantity</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="stop_targ_qty" id="stop_targ_qty" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Confirmed Yield Count</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="stop_yield_qty" id="stop_yield_qty" class="form-control" readonly/>
                        </div>
                    </div>
                    
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Confirmed Scrap Count</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="stop_scrap_qty" id="stop_scrap_qty" class="form-control" readonly/>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" onclick="tempData.oeeprodorder.removePOFromEq();" >Stop</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    
    
     
    <!-- Complete production order modal -->

    <div class="modal fade" id="completePOModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Complete Production Order</h4>
          </div>
          <form id="fromComPO" enctype="multipart/form-data">
           <input type="hidden" name="com_po_assign_id" id="com_po_assign_id"/> 
           <input type="hidden" name="com_oper_no" id="com_oper_no"/> 
           <input type="hidden" name="com_equi_code" id="com_equi_code"/> 
           <div class="modal-body">          
               <div class="row">                                  
                    <div class="col-md-12" >
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">PO Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="com_po_number" id="com_po_number" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Target Quantity</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="com_targ_qty" id="com_targ_qty" class="form-control" readonly/>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top: 3px;">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Confirmed Yield Count</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="com_yield_qty" id="com_yield_qty" class="form-control" readonly/>
                        </div>
                    </div>
                    
                    <div class="col-md-12" style="padding-top: 3px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Confirmed Scrap Count</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="com_scrap_qty" id="com_scrap_qty" class="form-control" readonly/>
                        </div>
                    </div>
                </div>
                <div><span>  Note: You can't re-assign after PO completion</span></div>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" onclick="tempData.oeeprodorder.finalConfirm();" >Complete</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    
    

</body>
</html>
