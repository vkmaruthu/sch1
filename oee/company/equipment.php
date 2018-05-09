<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalEquipmentData=new Array();
var modelArray = new Array();
var eqTypeArray = Array();
var reasonsArray = Array();

tempData.oeeEquipment=
{
loadAllEquipment:function(){
debugger;
var comp_id = $('#comp_id').val();
var plant_id = $('#plant_id').val();
var wc_id = $('#wc_id').val();
var url="getDataController.php";
var myData={getEquipmentDetails:"getEquipmentDetails", "wc_id":wc_id, "comp_id":comp_id, "plant_id":plant_id};
   $.ajax({
        type:"POST",
        url:url,
        async: false,
        dataType: 'json',
        data:myData,
        success: function(obj){
            
        globalEquipmentData=obj.equipmentDetails;

        if(obj.equipmentDetails==null){
              $('#equipmentTable').DataTable({
                "paging":false,
                "ordering":true,
                "info":true,
                "searching":false,         
                "destroy":true,
            }).clear().draw();

          }else{

        var DataTableProject = $('#equipmentTable').DataTable( {
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                "destroy":true,
                "data":obj.equipmentDetails,   
                "columns": [
                  { data: "image_file_name" ,className: "text-left",
                      render: function (data, type, row, meta) {
                         if(row.image_file_name != ""){
                            return '<div class="thumb"><img src="../common/img/machine/'+row.image_file_name+'"></div>';
                          }else{
                            return '<div class="thumb"><img src="../common/img/machine/default.png"></div>';
                          }
                      }
                   },
                  { data: "eq_code" },
                  { data: "eq_desc" },
                  { data: "eq_protocol" },
                  { data: "eq_type_name" },
                  { data: "model_name" },
                  { data: "mac_id" },
                  { data: "reason_code_name" ,className: "text-left",
                    render: function (data, type, row, meta) {
                      var a=row.reason_code_name;
                      var text='<div style="white-space:normal;width:200px;">'+a.slice(0, -2)+'</div>';
                       return text;
                    }
                  },
                  { data: "id" ,className: "text-left",
                      render: function (data, type, row, meta) {
                        var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeEquipment.editEquipment('+row.id+',\''+row.wc_id+'\',\''+row.eq_type_id+'\',\''+row.eq_model_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
                         var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeEquipment.deleteEquipment('+row.id+',\''+row.image_file_name+'\');"><i class="fa fa-trash"></i> </button>';
                        return a+' '+b;
                      }
                    },
                   ]
                 }); 
        
        } // else End here 

        } // ajax success ends
    });  
},
getCompanyDesc:function(){	
  var url="getDataController.php";
  var comp_id=$('#comp_id').val();
  var myData={getCompDetails:"getCompDetails",comp_id:comp_id};
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    data:myData,
    success: function(obj) {
      if(obj.compDetails !=null){
        $('#compName').html(obj.compDetails[0].comp_desc);
      } 
    }
  });
},
getPlantDesc:function(){	
	  var url="getDataController.php";
	  var plant_id=$('#plant_id').val();
	  var comp_id=$('#comp_id').val();
	  var myData={getPlantDetails:"getPlantDetails",plant_id:plant_id, comp_id:comp_id};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    data:myData,
	    success: function(obj) {
	      if(obj.plantDetails !=null){
	        $('#plantName').html(obj.plantDetails[0].plant_desc);
	      } 
	    }
	  });
},
getWCDesc:function(){	
		  var url="getDataController.php";
		  var plant_id=$('#plant_id').val();
		  var comp_id=$('#comp_id').val();
		  var wc_id=$('#wc_id').val();
		  var myData={getWCDetails:"getWCDetails",plant_id:plant_id, comp_id:comp_id, wc_id:wc_id};
		  $.ajax({
		    type:"POST",
		    url:url,
		    async: false,
		    dataType: 'json',
		    data:myData,
		    success: function(obj) {
		      if(obj.wcDetails !=null){
		        $('#wcName').html(obj.wcDetails[0].wc_desc);
		      } 
		    }
	  });
 },

reload:function(){
	   location.reload(true);
},

AlertFilesizeType:function(name){   
	  debugger;
	   var imgPathName = window.URL.createObjectURL(name.files[0]);
	   $('#showImg').show();
	   $('#showImg').html('<img style="width: 30%;" src="'+imgPathName+'">');

	    var sizeinbytes = document.getElementById('image_file_name').files[0].size;
	    var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
	    fSize = sizeinbytes; i=0;
	    while(fSize>900){fSize/=1024;i++;}
	    var size=((Math.round(fSize*100)/100));//+' '+fSExt[i]);
	    if(fSExt[i] =='KB'){
	      $('#size').html("File size :"+size+" "+fSExt[i]+"<b>");
	    }
	    else if(size < 3 && fSExt[i] =='MB'){
	      $('#size').html("<b> File size :"+size+" "+fSExt[i]+"<b>");
	    }
	    else{
	      $('#size').html("<b>File size : "+size+" "+fSExt[i]+" , ( File size must be excately 3 MB )<b>");
	    }
	      
	    var allowedFiles = [".jpg", ".jpeg", ".png"];
	    var fileUpload = document.getElementById("image_file_name");
	    var lblError = document.getElementById("lblError");
	    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
	    if (!regex.test(fileUpload.value.toLowerCase())) {
	        lblError.innerHTML = "Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.";
	        return false;
	    }else{
	      lblError.innerHTML = "";
	      return true;
	    }
},

deleteEquipment:function (id,img){
	  var url="getDataController.php";
	  var eq_id=id;
	  var myData={deleteEquipment:"deleteEquipment",eq_id:eq_id,img:img};
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
	           
	           tempData.oeeEquipment.loadAllEquipment();

	        }else{
	          $("#delCommonMsg").show();
	           $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
	        }  
	      } 
	      setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);

	    }
	  });
},

saveEquipment:function(){
	debugger;
	  var url="getDataController.php";
	  var formEQData = new FormData($('#fromEquipment')[0]);
	  formEQData.append("saveEquipment", "saveEquipment");
	  var eq_code=$('#eq_code').val();
	  var eq_protocol = $('#eq_protocol').val();
	  var eqType = $('#eq_type').val();
	  var model = $('#model').val();
	  var mac_id = $('#mac_id').val();
	  var reasons = $('#reason_codes').val();
	    if(eq_code == "") {
	        $('#eq_code').css('border-color', 'red');
	        return false;
	    }else{
	        $('#eq_code').css('border-color', '');
    	    if(eqType == 0){
        	     $('#msg').html('*Select Equipment Type');
       		     return false;
       		  }else {
       			 $('#msg').html('');
       		  }
    	    if(model == 0){
    	    	$('#msg').html('*Select Model');
      		     return false;
      		  }else {
      			$('#msg').html('');
      		  }
    		  
    	    if(eq_protocol == 0){
    	    	$('#msg').html('*Select Protocol Type');
    		     return false;
    		  }else {
    			  $('#msg').html('');
    		  }
      		  if(mac_id == ""){
      			 $('#mac_id').css('border-color', 'red');
      			 return false;
      	  	  }else{
      	  		$('#mac_id').css('border-color', '');
          	  }

    	    if(reasons == ""){
    	    	$('#msg').html('*Select Reason Codes');
      		     return false;
      		  }else {
      			$('#msg').html('');
      		  }

  		  
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    processData: false,
	    contentType: false,
	    data:formEQData,
	    success: function(obj) {
	        debugger;
	      if(obj.data !=null){
	        if(obj.data.infoRes=='S'){
	           $("#commonMsg").show();
	           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
	           tempData.oeeEquipment.loadAllEquipment();
	           tempData.oeeEquipment.clearForm();
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

gotoBack:function(){
	 var comp_id = $('#comp_id').val();
	 var plant_id = $('#plant_id').val();
	 window.location="workcenter.php?comp_id="+comp_id+"&plant_id="+plant_id;
},
gotoReasons:function(){
	 var comp_id = $('#comp_id').val();
	 var plant_id = $('#plant_id').val();
	 var wc_id = $('#wc_id').val();
	 window.location="../reasons/createreasons.php?comp_id="+comp_id+"&plant_id="+plant_id+"&wc_id="+wc_id;
},
editEquipment:function (id, wcId, eqTypeId, modelId){
	debugger;
   for(var i=0;i<globalEquipmentData.length;i++){ 
       if(id==globalEquipmentData[i].id){
         $("#showImg").show();
         $('#eq_id').val(globalEquipmentData[i].id);
         $('#eq_code').val(globalEquipmentData[i].eq_code);
         $('#eq_desc').val(globalEquipmentData[i].eq_desc);
         $('#mac_id').val(globalEquipmentData[i].mac_id);
         
         $('#eq_type_id').val(globalEquipmentData[i].eq_type_id);
         $('#eq_model_id').val(globalEquipmentData[i].eq_model_id);
         $("#eq_protocol").val(globalEquipmentData[i].protocol_id).change();
         
         $('#model').val(modelId).change();
         $('#eq_type').val(eqTypeId).change();
         var str = globalEquipmentData[i].reason_code_arr;
         var reason = new Array();
         reason = str.split(",");
         $('#reason_codes').val(reason).change();
         
         
         $('#wc_id').val(globalEquipmentData[i].wc_id);
         $('#img_id').val(globalEquipmentData[i].image_file_name);
         if(globalEquipmentData[i].image_file_name!=''){
           $('#showImg').html('<img style="width: 30%;" src="../common/img/machine/'+globalEquipmentData[i].image_file_name+'">');
         }else{
           $('#showImg').html('<img style="width: 30%;" src="../common/img/machine/default.png">');
         }
         $('#eq_code').prop('readonly', true);
         break;
         
       }
   }
   $("#fromEquipment").fadeIn("fast");
   $("#addEquipment").hide();
   $("#updateEquipment").show();            
},
saveModel:function(){
	  var url="getDataController.php";
	  var formEQData = new FormData($('#fromEquipmentModel')[0]);
	  formEQData.append("saveEquipmentModel", "saveEquipmentModel");
	  var eq_code=$('#model_name').val();
	    if(eq_code == "") {
	        $('#model_name').css('border-color', 'red');
	        return false;
	    }else{
	      $('#model_name').css('border-color', '');
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    processData: false,
	    contentType: false,
	    data:formEQData,
	    success: function(obj) {
	        debugger;
	      if(obj.data !=null){
	        if(obj.data.infoRes=='S'){
	           $("#commonMsgModel").show();
	           $('#commonMsgModel').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
	           $('#fromEquipmentModel')[0].reset();
	           $('#model_id').val('');
	          // $('#addModelModal').modal('hide');
	           tempData.oeeEquipment.getModelNameForDropdown();

	        }else{
	          $("#commonMsgModel").show();
	           $('#commonMsgModel').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
	        }  
	      } 
	      setTimeout(function(){  
	        $("#commonMsgModel").fadeToggle('slow');        
	      }, 1500);
	    }
	  });
  }
},
saveEquipmentType:function(){
	  var url="getDataController.php";
	  var eq_type_desc = $('#eq_type_desc').val();
	  if ($('#is_machine').is(":checked")){$('#is_machine').val(1);}
	  if ($('#is_tool').is(":checked")){$('#is_tool').val(1);}
	  if ($('#is_dc_po').is(":checked")){$('#is_dc_po').val(1);}
	  if ($('#is_afs_size_id').is(":checked")){$('#is_afs_size_id').val(1);}
	  var formEQData = new FormData($('#fromEquipmentType')[0]);
	  formEQData.append("saveEquipmentType", "saveEquipmentType");
	  var eq_type_desc=$('#eq_type_desc').val();
	    if(eq_type_desc == "") {
	        $('#eq_type_desc').css('border-color', 'red');
	        return false;
	    }else{
	      $('#eq_type_desc').css('border-color', '');
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    processData: false,
	    contentType: false,
	    data:formEQData,
	    success: function(obj) {
	        debugger;
	      if(obj.data !=null){
	        if(obj.data.infoRes=='S'){
	           $("#commonMsgEqType").show();
	           $('#commonMsgEqType').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
	     	   $('#is_machine').iCheck('uncheck');
	     	   $('#is_tool').iCheck('uncheck');
	     	   $('#is_afs_size_id').iCheck('uncheck');
	           $('#is_dc_po').iCheck('uncheck');		     	        
	     	   $('#fromEquipmentType')[0].reset();
	     	   $('#type_id').val(''); 
	           tempData.oeeEquipment.getEQTypeForDropdown();
	        }else{
	          $("#commonMsgEqType").show();
	           $('#commonMsgEqType').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
	        }  
	      } 

	      setTimeout(function(){  
	        $("#commonMsgEqType").fadeToggle('slow');        
	      }, 1500);
	    }
	  });
  }
},
getModelNameForDropdown:function(){
	  var url="getDataController.php";
	  var myData = {getEquipmentModel:'getEquipmentModel'};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	        debugger;
	      if(obj.models !=null){
	         modelArray = obj.models;
	    	 tempData.oeeEquipment.loadModelTable(modelArray);
	    	 
             	if(modelArray != null){
             		 $("#model").html('');
        	    	 $("#model").append('<option value="0"> Select Model </option>');
            		for(var i=0; i< modelArray.length; i++){
        			   $("#model").append('<option value="'+modelArray[i].id+'">'+modelArray[i].model_name+'</option>'); 
            		}
            	}
        	
	        }

	      } 
	  });
},
loadEqTypeTable:function(eqType){
    var DataTableProject = $('#eqTypeTable').DataTable( {
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        "destroy"     : true,  
        'autoWidth'   : false,
        "pageLength": 4,
        "data":eqType,   
         "columns": [
          { data: "eq_type_desc" },
          { data: "is_machine" },
          { data: "is_tool" },
          { data: "is_dc_po" },
          { data: "is_afs_size_id" },
          { data: "id" ,className: "text-left",
              render: function (data, type, row, meta) {
                var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeEquipment.editEqType('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                // var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeEquipment.deleteModel('+row.id+');"><i class="fa fa-trash"></i> </button>';
                return a;
              }
            },
           ]
         });

 },
 
editEqType:function(id){
   for(var i=0;i<eqTypeArray.length;i++){ 
       if(id==eqTypeArray[i].id){
             $('#type_id').val(id); 
        	 $('#eq_type_desc').val(eqTypeArray[i].eq_type_desc);
        	 if (eqTypeArray[i].is_machine == 1){
            	 $('#is_machine').val(1);
            	 $('#is_machine').iCheck('check');
             }else{
        		 $('#is_machine').val(0);
            	 $('#is_machine').iCheck('uncheck');
             }
        	 if (eqTypeArray[i].is_tool == 1){
            	 $('#is_tool').val(1);
            	 $('#is_tool').iCheck('check');
             }else{
            	 $('#is_tool').val(0);
            	 $('#is_tool').iCheck('uncheck');
              }
        	 if (eqTypeArray[i].is_dc_po == 1 ){
            	 $('#is_dc_po').val(1);
            	 $('#is_dc_po').iCheck('check');
             }else{
            	 $('#is_dc_po').val(0);
            	 $('#is_dc_po').iCheck('uncheck');
             }
        	 if (eqTypeArray[i].is_afs_size_id == 1){
            	  $('#is_afs_size_id').val(1);
            	  $('#is_afs_size_id').iCheck('check');
             }else{
            	 $('#is_afs_size_id').val(0);
           	     $('#is_afs_size_id').iCheck('uncheck');
             }
		}
   }
},
loadModelTable:function(modelValue){
    var DataTableProject = $('#modelTable').DataTable( {
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        "destroy"     : true,  
        'autoWidth'   : false,
        "pageLength": 4,
        "data":modelValue,   
        "columns": [
          { data: "model_name" },
          { data: "num_of_di" },
          { data: "num_of_do" },
          { data: "num_of_ai" },
          { data: "num_of_ao" },
          { data: "id" ,className: "text-left",
              render: function (data, type, row, meta) {
                var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeEquipment.editModel('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                // var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeEquipment.deleteModel('+row.id+');"><i class="fa fa-trash"></i> </button>';
                return a;
              }
            },
           ]
         });

 },
editModel:function(id){
   for(var i=0;i<modelArray.length;i++){ 
       if(id==modelArray[i].id){ 
    	   $('#model_id').val(id);
    	   $('#model_name').val(modelArray[i].model_name);
    	   $('#num_of_di').val(modelArray[i].num_of_di);
    	   $('#num_of_do').val(modelArray[i].num_of_do);
    	   $('#num_of_ai').val(modelArray[i].num_of_ai);
    	   $('#num_of_ao').val(modelArray[i].num_of_ao);
		}
   }
},
getEQTypeForDropdown:function(){//reasonsArray
	  var url="getDataController.php";
	  var myData = {getEquipmentType:'getEquipmentType'};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	        debugger;
	      if(obj.eqTypes !=null){
	    	  eqTypeArray = obj.eqTypes;
	    	  tempData.oeeEquipment.loadEqTypeTable(eqTypeArray);
	    	 $("#eq_type").html('');
	    	 $("#eq_type").append('<option value="0"> Select Equipment Type </option>');
             	if(eqTypeArray != null){
            		for(var i=0; i< eqTypeArray.length; i++){
        			   $("#eq_type").append('<option value="'+eqTypeArray[i].id+'">'+eqTypeArray[i].eq_type_desc+'</option>'); 
            		}
            	}
	        }
	      } 
	  });
},
getEQProtocolTypeForDropdown:function(){//reasonsArray
	  var url="getDataController.php";
	  var myData = {getEqProtocolType:'getEqProtocolType'};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	    	 $("#eq_protocol").html('');
	    	 $("#eq_protocol").append('<option value="0"> Select Protocol Type </option>');
	      if(obj.protocolTypes !=null){
          		for(var i=0; i< obj.protocolTypes.length; i++){
      			   $("#eq_protocol").append('<option value="'+obj.protocolTypes[i].id+'">'+obj.protocolTypes[i].name+'</option>'); 
          		}
	        }
	      } 
	  });
},
getReasonsForDropdown:function(){
 	  var url="getDataController.php";
 	  var myData = {getReasons:'getReasons'};
 	  $.ajax({
 	    type:"POST",
 	    url:url,
 	    async: false,
 	    dataType: 'json',
 	    cache: false,
 	    data:myData,
 	    success: function(obj) {
 	        debugger;
 	      if(obj.reasons !=null){
 	    	 reasonsArray = obj.reasons;
              	if(reasonsArray != null){
             		for(var i=0; i< reasonsArray.length; i++){
         			   $("#reason_codes").append('<option value="'+reasonsArray[i].id+'">'+reasonsArray[i].message+'</option>'); 
             		}
             	}
 	        }
 	      } 
 	  });
},
clearForm:function(){
    $("#fromEquipment").fadeToggle("slow");
	$("#showImg").hide();
    $("#size").html('');
    $('#eq_code').prop('readonly', false);
    $('#fromEquipment')[0].reset();
    $("#addEquipment").show();
    $("#updateEquipment").hide(); 
    $("#reason_codes").val('').change();
    $("#model").val(0).change();  
    $("#eq_type").val(0).change();
    $("#eq_protocol").val(0).change();
    $("#img_id").val(''); 
    $("#eq_id").val('');      
}
  
};

$(document).ready(function() {
debugger;
      $("#menuCompany").parent().addClass('active');
      $("#menuCompany").parent().parent().closest('.treeview').addClass('active menu-open');
       
      $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
      $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
      $('#wc_id').val(<?php echo $_GET['wc_id'];?>);
      $('#screen').val('<?php echo $_GET['screen'];?>');

      if($('#screen').val() == "cs"){
          $("#fromEquipment").show();
      }else{
          $("#fromEquipment").hide();
      }
      $('.select2').select2();
      $('#commonMsg').hide();
      $("#showImg").hide();
      
      tempData.oeeEquipment.getCompanyDesc();
      tempData.oeeEquipment.loadAllEquipment();
      tempData.oeeEquipment.getPlantDesc();
      tempData.oeeEquipment.getWCDesc();
      tempData.oeeEquipment.getModelNameForDropdown();
      tempData.oeeEquipment.getEQTypeForDropdown();
      tempData.oeeEquipment.getReasonsForDropdown();
      tempData.oeeEquipment.getEQProtocolTypeForDropdown();
   
    $('#createEquipment').click(function(){
    	 tempData.oeeEquipment.clearForm();
    });
    $('#cancel').click(function(){
   	     tempData.oeeEquipment.clearForm();
    });
    $('#cancelBtn2').click(function(){
    	 $('#fromEquipmentModel')[0].reset();
    });
    $('#cancelBtn1').click(function(){
   	   $('#is_machine').iCheck('uncheck');
 	   $('#is_tool').iCheck('uncheck');
 	   $('#is_afs_size_id').iCheck('uncheck');
       $('#is_dc_po').iCheck('uncheck');
   	   $('#fromEquipmentType')[0].reset();
    });
    $('#eq_code').keyup(function(){
       $('#eq_code').css('border-color', '');
    });

    $('#mac_id').keyup(function(){
    	$('#mac_id').css('border-color', '');
    });

    $('#model_name').keyup(function(){
        this.value = this.value.toUpperCase();
        $('#model_name').css('border-color', '');
     });
    
    $('#model').change(function(){
        $('#msg').html('');
    });
    
    $('#eq_type').change(function(){
        $('#msg').html('');
    });

    $('#eq_protocol').change(function(){
        $('#msg').html('');
    });  
        
    $('#reason_codes').change(function(){
         $('#msg').html('');
    });
});

</script>
  <input type="hidden" name="screen" id="screen"/>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
         <h4 style="margin-top: 3px;"><a id="compName" ></a> <b>/</b> <a id="plantName" ></a> <b>/</b> <a id="wcName" ></a> <b>/</b> Equipment </h4>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
            <a onclick="tempData.oeeEquipment.gotoBack();" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Back </a>
        </div>
        <button type="button" onclick="tempData.oeeEquipment.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>
        <button type="button" id="createEquipment" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Equipment
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
        <form class="" id="fromEquipment" enctype="multipart/form-data"> 
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="img_id" id="img_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/>
          <input type="hidden" name="wc_id" id="wc_id"/>
           <input type="hidden" name="eq_id" id="eq_id"/>

            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Code <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="eq_code" id="eq_code" onkeyup=""
                     placeholder="Equipment Code" maxlength="10" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Description <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="eq_desc" id="eq_desc" onkeyup=""
                   placeholder="Equipment Description" class="form-control" required="true"/>
                </div>
                </div>
              </div>
              
              <div class="row" style="margin-top: 10px;">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Equipment Type <span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-10" style="padding-right: 0px;">
                      <div class="form-group">
                        <select class="form-control select2"  id="eq_type" name="eq_type" style="width:100%;">
                        </select>
                      </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-2" style="padding-left: 3px;padding-top: 3px; ">
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#addEQTypeModal">
                        <i class="fa  fa-plus"></i>
                      </button>
                    </div>
                </div>

               <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Model<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-10" style="padding-right: 0px;">
                      <div class="form-group">
                        <select class="form-control select2"  id="model" name="model" style="width:100%;">
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-md-1 col-sm-1 col-xs-2" style="padding-left: 3px; padding-top: 3px; ">
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#addModelModal">
                        <i class="fa  fa-plus"></i>
                      </button>
                    </div>
                </div>
              </div>
              
              <div class="row">
                   <div class="col-md-6">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Protocol<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <select class="form-control select2"  id="eq_protocol" name="eq_protocol" style="width:100%;">
                                </select>
                            </div>
                        </div>   
                    </div>
                    <div class="col-md-6">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Mac Id<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="mac_id" id="mac_id" onkeyup=""
                           placeholder="Mac Id" class="form-control" required="true"/>
                        </div>   
                    </div>
              </div>
              
              <div class="row">
                  <div class="col-md-6">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Image Upload</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">    
                       <input type="file" name="image_file_name" id="image_file_name" accept="image/*" class="form-control col-md-12 col-xs-12" 
                        onchange="tempData.oeeEquipment.AlertFilesizeType(this);" />
                          <span class="pull-right">[ Upload only Image ]  </span>
                          <span id="size" style="color:red;font-size:13px;"></span>
                          <span id="lblError" style="color:red;font-size:13px;"></span>
                        <span id="showImg"></span> 
                       </div>
                    </div>
                    <div class="col-md-6">               
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Reason Codes <span class="required">*</span></label>
                            <div class="col-md-5 col-sm-5 col-xs-10" style="padding-right: 0px;">
                              <div class="form-group">
                                <select class="form-control select2"  id="reason_codes" name="reason_codes[]" multiple="reason_codes" data-placeholder="Select Reason Codes" style="width:100%;">
                                </select>
                              </div>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-2" style="padding-left: 3px;padding-top: 1px; ">
                              <button type="button" class="btn btn-sm btn-info" onclick="tempData.oeeEquipment.gotoReasons();">
                                <i class="fa  fa-plus"></i>
                              </button>
                          </div>
                    </div>

              </div>
              

              <div class="row">
               <div id="msg" style="padding-left: 28px;color: red;"></div>
                   <div class="col-md-12 text-center">
                    <button type="button" id="addEquipment" onclick="tempData.oeeEquipment.saveEquipment()" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Save
                    </button>
                    <button type="button" id="updateEquipment" onclick="tempData.oeeEquipment.saveEquipment()"  class="btn btn-sm btn-success" style="display:none;">
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
          <table id="equipmentTable" class="table table-hover table-bordered  nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Image</th>
              <th>Code</th> 
              <th>Description</th>
              <th>Protocol</th>
              <th>Equipment Type</th>
              <th>Model</th>
              <th>Mac Id</th>
              <th>Reason Code</th>
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
 
 <!-- Add Equipment Type Modal -->

    <div class="modal fade" id="addEQTypeModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Equipment Type</h4>
          </div>
          <form id="fromEquipmentType" enctype="multipart/form-data">
          <input type="hidden" name="type_id" id="type_id"/>  
          <div class="modal-body">          
               <div class="row">
                    <div class="col-md-12">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <input type="text" name="eq_type_desc" id="eq_type_desc" onkeyup=""
                           placeholder="Equipment Type Desc" class="form-control" required="true"/>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12" style="padding-top: 1px;">
                          <div class="checkbox">
                            <label><input type="checkbox" name="is_machine" value="0" id="is_machine" class="minimal"> Is Machine</label>
                          </div>
                          <div class="checkbox">
                            <label><input type="checkbox" name="is_dc_po" value="0" id="is_dc_po" class="minimal"> Is dc po</label>
                          </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                          <div class="checkbox">
                            <label><input type="checkbox" name="is_tool" value="0" id="is_tool" class="minimal"> Is Tool</label>
                          </div>
                          <div class="checkbox">
                            <label><input type="checkbox" name="is_afs_size_id" value="0" id="is_afs_size_id" class="minimal"> Is afs size id</label>
                          </div>
                     </div>
                </div>
            <br>
            <div class="" style="text-align: center;">
           		 <button type="button" class="btn btn-success" onclick="tempData.oeeEquipment.saveEquipmentType();">Save</button>
           		 <button type="button" class="btn btn-danger " data-dismiss="modal" id="cancelBtn1">Cancel</button>
            </div>
            <div id="commonMsgEqType"></div>
            <br>
          </form>
             <div class="table-responsive"> 
              <table id="eqTypeTable" class="table table-hover table-bordered  nowrap">
               <thead>
                 <tr>
                  <th>Description</th>
                  <th>Is Machine</th> 
                  <th>Is Tool</th>
                  <th>Is dc po</th> 
                  <th>Is afs size Id</th>
                  <th>Action</th>
                 </tr>
               </thead>
               </table>
             </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    
     <!-- Add Model modal -->

    <div class="modal fade" id="addModelModal">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add Model</h4>
          </div>
          <form id="fromEquipmentModel" enctype="multipart/form-data"> 
          <input type="hidden" name="model_id" id="model_id"/> 
          <div class="modal-body">          
               <div class="row">
                    <div class="col-md-6">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Model Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="model_name" id="model_name" onkeyup=""
                           placeholder="Enter Model Name" class="form-control" required="true"/>
                        </div>
                    </div>
                    
                    <div class="col-md-6" style="padding-top: 1px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">No. of Digital I/P</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" name="num_of_di" id="num_of_di"
                           placeholder="No. of Digital Input" class="form-control" maxlength="4" value="0"/>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 1px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">No. of Digital O/P</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" name="num_of_do" id="num_of_do"
                           placeholder="No. of Digital Output" class="form-control" maxlength="4" value="0"/>
                        </div>
                    </div>
                    
                    <div class="col-md-6" style="padding-top: 1px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">No. of Analog I/P</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" name="num_of_ai" id="num_of_ai" 
                           placeholder="No. of Analog Input" class="form-control" maxlength="4" value="0"/>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 1px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">No. of Analog O/P</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" min="0" name="num_of_ao" id="num_of_ao" onkeyup=""
                           placeholder="No. of Analog Output" class="form-control"  maxlength="4" value="0"/>
                        </div>
                    </div>
                </div>
           <br>
          <div class="" style="text-align: center;">
            <button type="button" class="btn btn-success" onclick="tempData.oeeEquipment.saveModel();" >Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelBtn2">Cancel</button>
          </div>
          <div id="commonMsgModel"></div>
           <br>
          </form>
          
            <div class="table-responsive"> 
              <table id="modelTable" class="table table-hover table-bordered  nowrap">
               <thead>
                 <tr>
                  <th>Model</th>
                  <th>No. of Digital I/P</th> 
                  <th>No. of Digital O/P</th>
                  <th>No. of Analog I/P</th> 
                  <th>No. of Analog O/P</th>
                  <th>Action</th>
                 </tr>
               </thead>
               </table>
             </div>
           </div>
           <div class="modal-footer">
           </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    

</body>
</html>
