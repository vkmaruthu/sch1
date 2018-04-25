<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalToolsData=new Array();
var modelArray = new Array();
var tooLIdTypeArray = Array();
var reasonsArray = Array();
var plant_code = "";
var comp_code = "";
var part_code = "";

tempData.oeeTools=
{
loadAllTools:function(){
debugger;
var comp_id = $('#comp_id').val();
var plant_id = $('#plant_id').val();
var part_id = $('#part_id').val();

var url="getDataController.php";
var myData={getToolDetails:"getToolDetails","comp_id":comp_id, "plant_id":plant_id, part_id:part_id};
   $.ajax({
        type:"POST",
        url:url,
        async: false,
        dataType: 'json',
        data:myData,
        success: function(obj){
        globalToolsData=obj.toolsDetails;

        if(obj.toolsDetails==null){
              $('#toolTable').DataTable({
                "paging":false,
                "ordering":true,
                "info":true,
                "searching":false,         
                "destroy":true,
            }).clear().draw();

          }else{       

        var DataTableProject = $('#toolTable').DataTable( {
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                "destroy":true,
                "data":obj.toolsDetails,   
                "columns": [
                  { data: "image_file_name" ,className: "text-left",
                      render: function (data, type, row, meta) {
                         if(row.image_file_name != ""){
                            return '<div class="thumb"><img src="../common/img/tools/'+row.image_file_name+'"></div>';
                          }else{
                            return '<div class="thumb"><img src="../common/img/machine/default.png"></div>';
                          }
                      }
                   },
                  { data: "number"},
                  { data: "tool_name" },
                  { data: "tool_desc" },
                  { data: "ton" },
                  { data: "maint_count" },
                  { data: "lifetime_count" },
                  { data: "bm_setup_time" },
                  { data: "bm_prod_time" },
                  { data: "no_of_items_per_oper" },
                  { data: "tag_id" ,className: "text-left",
                      render: function (data, type, row, meta) {
                        var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeTools.editTool(\''+row.tag_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
                         var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeTools.deleteTool(\''+row.tag_id+'\',\''+row.image_file_name+'\');"><i class="fa fa-trash"></i> </button>';
                        return a+' '+b;
                      }
                    },
                   ]
                 }); 
        
        } // else End here 

        } // ajax success ends
    });  
},
saveTool:function(action){
	debugger;
	  var url="getDataController.php";
      $('#plant_code').val(plant_code);
      $('#comp_code').val(comp_code); 
      $('#part_code').val(part_code);
      $('#action').val(action);
      
      var idType = $('#tool_opr_id_type').val();
      if(idType == 0){
          $('#msg').html('*Select Tool Operation Id Type');
          return false;
	     }else{
	    	 $('#msg').html('');
		 }
      var idName = $("#tool_opr_id_type option:selected").text();
      if(idName.toUpperCase() === "OPERATION"){
    	    $('#tag_id').val($('#plant_id').val()+':'+$('#part_id').val()+':'+$('#opr_id').val());
        }else{
        	$('#tag_id').val($('#plant_id').val()+':'+$('#opr_id').val());
        }
	  var formEQData = new FormData($('#fromTool')[0]);
	  formEQData.append("saveTool", "saveTool");
	   var tool_name=$('#opr_id').val();
	    if(tool_name == "") {
	        $('#opr_id').css('border-color', 'red');
	        return false;
	    }else{
	        $('#opr_id').css('border-color', '');
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
	           tempData.oeeTools.loadAllTools();
	           tempData.oeeTools.clearForm();

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
editTool:function (tag_id){
	debugger;
 for(var i=0;i<globalToolsData.length;i++){ 
     if(tag_id==globalToolsData[i].tag_id){
       $("#showImg").show();
       $('#tag_id').val(tag_id);
       $('#tool_name').val(globalToolsData[i].tool_name);
       $('#tool_desc').val(globalToolsData[i].tool_desc);
       $('#bm_setup_time').val(globalToolsData[i].bm_setup_time);
       $('#bm_prod_time').val(globalToolsData[i].bm_prod_time);
       $('#no_of_items_per_oper').val(globalToolsData[i].no_of_items_per_oper);
       $('#ton').val(globalToolsData[i].ton);
       $('#maint_count').val(globalToolsData[i].maint_count);
       $('#lifetime_count').val(globalToolsData[i].lifetime_count);
       $('#img_id').val(globalToolsData[i].image_file_name);
       $('#opr_id').val(globalToolsData[i].number);
       $('#tool_opr_id_type').val(globalToolsData[i].type_id).change();
       if(globalToolsData[i].image_file_name!=''){
         $('#showImg').html('<img style="width: 30%;" src="../common/img/tools/'+globalToolsData[i].image_file_name+'">');
       }else{
         $('#showImg').html('<img style="width: 30%;" src="../common/img/machine/default.png">');
       }
       $('#opr_id').prop('readonly', true);
       $("#tool_opr_id_type").prop("disabled", true);
       break;
     }
 }
 $("#fromTool").fadeIn("fast");
 $("#addToolsBtn").hide();
 $("#updateTools").show();            
},
deleteTool:function (id,img){
	  var url="getDataController.php";
	  var myData={deleteTool:"deleteTool",tag_id:id,img:img};
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
	           tempData.oeeTools.loadAllTools()
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
gotoBack:function(){
	 var comp_id = $('#comp_id').val();
	 var plant_id = $('#plant_id').val();
	 if($('#screen').val() == "p"){
	 	window.location="parts.php?comp_id="+comp_id+"&plant_id="+plant_id+"&screen=p";
	 }else{
		window.location="parts.php?comp_id="+comp_id+"&plant_id="+plant_id+"&screen=c";
	 }
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
	        plant_code = obj.plantDetails[0].plant_code;
	        comp_code = obj.plantDetails[0].comp_code;
	        $('#plant_code').val(plant_code);
	        $('#comp_code').val(comp_code); 
	      } 
	    }
	  });
},
getPartDesc:function(){	
		  var url="getDataController.php";
		  var plant_id=$('#plant_id').val();
		  var comp_id=$('#comp_id').val();
		  var part_id=$('#part_id').val();
		  var myData={getPartsDetails:"getPartsDetails",plant_id:plant_id, comp_id:comp_id, part_id:part_id};
		  $.ajax({
		    type:"POST",
		    url:url,
		    async: false,
		    dataType: 'json',
		    data:myData,
		    success: function(obj) {
		      if(obj.partsDetails !=null){
		        $('#partName').html(obj.partsDetails[0].part_desc);
		        part_code = obj.partsDetails[0].part_num;
		        $('#part_num').val(part_code); 
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


saveToolsIDTypesType:function(){  //tool_id_type id_type_desc
	  var url="getDataController.php";
	  var tool_id_type = $('#tool_id_type').val();
	  var formEQData = new FormData($('#fromToolIdType')[0]);
	  formEQData.append("saveToolsIDTypesType", "saveToolsIDTypesType");
	  var tool_id_type=$('#tool_id_type').val();
	    if(tool_id_type == "") {
	        $('#tool_id_type').css('border-color', 'red');
	        return false;
	    }else{
	      $('#tool_id_type').css('border-color', '');
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
	           
	     	  $('#fromToolIdType')[0].reset();
	          $('#addToolIdType').modal('hide');
	          tempData.oeeTools.getToolIdTypeForDropdown();

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
getToolIdTypeForDropdown:function(){
	  var url="getDataController.php";
	  var myData = {getToolIdTypes:'getToolIdTypes'};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	        debugger;
	      if(obj.toolIdTypes !=null){
     		 $("#tool_opr_id_type").html('');
	    	 $("#tool_opr_id_type").append('<option value="0"> Select Tool Id Type </option>');
    		 for(var i=0; i< obj.toolIdTypes.length; i++){
			   $("#tool_opr_id_type").append('<option value="'+obj.toolIdTypes[i].id+'">'+obj.toolIdTypes[i].tool_id_type+'</option>'); 
    		 }
	        }
	      } 
	  });
 },
 getWCForFilterDropdown:function(){
	  var url="getDataController.php";
	  var plantId = $('#plant_id').val();
	  var myData = {getWCDetails:'getWCDetails', plant_id:plantId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	      if(obj.wcDetails !=null){
        	 $("#workcenter").html('');
	    	 $("#workcenter").append('<option value="0"> Select Work Center </option>');
       		for(var i=0; i< obj.wcDetails.length; i++){
   			   $("#workcenter").append('<option value="'+obj.wcDetails[i].id+'">'+obj.wcDetails[i].wc_desc+'</option>'); 
       		}
	        }
	      } 
	  });
},
clearForm:function(){     
	$("#fromTool").fadeToggle("slow");
    $('#opr_id').prop('readonly', false);
    $("#showImg").hide();
    $("#size").html('');
    $('#tool_opr_id_type').val(0).change();
    $('#tag_id').val("");
    $('#opr_id').val("");
    $('#action').val("");
    $('#img_id').val("");
    $('#fromTool')[0].reset();
    $("#addToolsBtn").show();
    $("#updateTools").hide(); 
    $("#tool_opr_id_type").prop("disabled", false);
}

};

$(document).ready(function() {
debugger;

  $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
  $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
  $('#part_id').val(<?php echo $_GET['part_id'];?>);
  $('#screen').val('<?php echo $_GET['screen'];?>');

  if($('#screen').val() == "p"){
	  $("#menuPlants").parent().addClass('active');
	  $("#menuPlants").parent().parent().closest('.treeview').addClass('active menu-open');
   }else{
	   $("#menuCompany").parent().addClass('active');
	   $("#menuCompany").parent().parent().closest('.treeview').addClass('active menu-open');
   }
  
  $('.select2').select2();
  $("#fromTool").hide();
  $('#commonMsg').hide();
  $("#showImg").hide();
  
    $('#createTools').click(function(){
      	tempData.oeeTools.clearForm();
    });
    $('#cancel').click(function(){
      	tempData.oeeTools.clearForm();
    });
  
    $('#opr_id').keyup(function(){tool_id_type
       $('#opr_id').css('border-color', '');
    });

    $('#tool_id_type').keyup(function(){
    	this.value = this.value.toUpperCase();
     });

    $('#tool_opr_id_type').change(function(){
    	  $('#msg').html('');
          var idName = $("#tool_opr_id_type option:selected").text();
          if(idName.toUpperCase() === "OPERATION"){
             $('#idName').html('Operation No.<span class="required">*</span>');
             $('#op_name').html('Operation Name<span class="required">*</span>');
             $('#op_desc').html('Description<span class="required">*</span>');
          }else{
        	  $('#idName').html('Tool Number<span class="required">*</span>');
              $('#op_name').html('Tool Name<span class="required">*</span>');
              $('#op_desc').html('Tool Description<span class="required">*</span>');
          }        
     });

    tempData.oeeTools.loadAllTools();
    tempData.oeeTools.getPlantDesc();
    tempData.oeeTools.getPartDesc();
    tempData.oeeTools.getToolIdTypeForDropdown();
    tempData.oeeTools.getWCForFilterDropdown();
  
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
         <h4 style="margin-top: 3px;"><a id="plantName" ></a> <b>/</b> <a id="partName" ></a> <b>/</b> Tools <span style="font-size: 13px;">(Operation)</span> </h4>
        </div>
      </div>
<!-- <a id="compName" ></a> <b>/</b> -->
    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
            <a onclick="tempData.oeeTools.gotoBack();" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Back </a>
        </div>
        <button type="button" onclick="tempData.oeeTools.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>
        <button type="button" id="createTools" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Tools
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
        <form class="" id="fromTool" enctype="multipart/form-data"> 
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="img_id" id="img_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/>
          <input type="hidden" name="tag_id" id="tag_id"/>
          <input type="hidden" name="part_id" id="part_id"/>
          <input type="hidden" name="screen" id="screen"/>
          <input type="hidden" name="part_num" id="part_num"/> 
          <input type="hidden" name="plant_code" id="plant_code"/> 
          <input type="hidden" name="action" id="action"/> 
            <div class="form-group">
            
               <div class="row" style="margin-top: 0px;">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12" >Tool/Operation Type*</label>
                    <div class="col-md-5 col-sm-5 col-xs-10" style="padding-right: 0px;">
                      <div class="form-group">
                        <select class="form-control select2"  id="tool_opr_id_type" name="tool_opr_id_type" style="width:100%;">                      
                        </select>
                      </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-2" style="padding-left: 3px;padding-top: 3px; ">
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#addToolIdType">
                        <i class="fa  fa-plus"></i>
                      </button>
                    </div>
                </div>
               <div class="col-md-6">
                 
                </div>
              </div>
            
               <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12" id="idName" >Tool Number<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="opr_id" id="opr_id" onkeyup=""
                     placeholder="" maxlength="30" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12" id="op_name">Tool Name<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="tool_name" id="tool_name" onkeyup=""
                     placeholder=""  class="form-control" required="true" autofocus/>
                  </div>

                </div>
              </div>
              
             <div class="row" style="margin-top: 10px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12" id="op_desc">Tool Description<span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="tool_desc" id="tool_desc" onkeyup=""
                   placeholder="" class="form-control" required="true"/>
                </div>
                </div>
                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Tons <b> (ton) </b> </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" name="ton" id="ton" onkeyup=""
                       placeholder="Tons" class="form-control" required="true" value="0"/>
                    </div>

                </div>
              </div>
              
              <div class="row" style="margin-top: 10px;">
               <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Bench Mark Setup Time<b>(min)</b></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" name="bm_setup_time" id="bm_setup_time" onkeyup=""
                       placeholder="Bench Mark Setup Time" class="form-control" required="true" value="0"/>
                    </div>   
                </div>
                 <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Bench Mark Production Time<b>(min)</b></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" name="bm_prod_time" id="bm_prod_time" onkeyup=""
                       placeholder="Bench Mark Production Time" class="form-control" required="true" value="0"/>
                    </div>   
                </div>
              </div>
              
             <div class="row" style="margin-top: 0px;">
               <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Maintenance Count</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" name="maint_count" id="maint_count" onkeyup=""
                       placeholder="Maintenance Count" class="form-control" required="true" value="0"/>
                    </div>   
                </div>
                 <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Life Time Count</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" name="lifetime_count" id="lifetime_count" onkeyup=""
                       placeholder="Life Time Count" class="form-control" required="true" value="0"/>
                    </div>   
                </div>
              </div>
              
              <div class="row" style="margin-top: 10px;">
              
                 <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">No. of Items Per Operation</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="1" name="no_of_items_per_oper" id="no_of_items_per_oper" onkeyup=""
                       placeholder="No. of Items Per Operation" class="form-control" required="true" value="1"/>
                    </div>   
                 </div>
               
                  <div class="col-md-6">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Image Upload</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">    
                       <input type="file" name="image_file_name" id="image_file_name" accept="image/*" class="form-control col-md-12 col-xs-12" 
                        onchange="tempData.oeeTools.AlertFilesizeType(this);" />
                          <span class="pull-right">[ Upload only Image ]  </span>
                          <span id="size" style="color:red;font-size:13px;"></span>
                          <span id="lblError" style="color:red;font-size:13px;"></span>
                        <span id="showImg"></span> 
                       </div>
                    </div>
              </div>
              
              <div class="row">
               <div id="msg" style="padding-left: 28px;color: red;"></div>
                   <div class="col-md-12 text-center">
                    <button type="button" id="addToolsBtn" onclick="tempData.oeeTools.saveTool('S');" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Save
                    </button>
                    <button type="button" id="updateTools" onclick="tempData.oeeTools.saveTool('U');"  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update
                    </button>
                     <button type="button" id="cancel" class="btn btn-sm btn-danger"><i class="fa fa-close"></i>&nbsp; Cancel
                    </button>
                   </div>
              </div>
            </div>  
           <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="toolTable" class="table table-bordered table-hover nowarp" style="font-size: 12px;">
           <thead>
             <tr>
              <th>Image</th>
              <th>Operation/Tool Number</th>
              <th>Operation/Tool Name</th>
              <th>Description</th>
              <th>Ton<span style="font-size: 10px;">(ton)</span></th>
              <th>Maintenance Count</th>
              <th>Life Time Count</th>
              <th>Bench Mark Setup Time<span style="font-size: 10px;">(min)</span></th>
              <th>Bench Mark Production Time<span style="font-size: 10px;">(min)</span></th>
              <th>No. Of Items per Operation</th>
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
 
 <!-- Add Tools Id Type-->

    <div class="modal fade" id="addToolIdType">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add Tools Id Type</h4>
          </div>
          <form id="fromToolIdType" enctype="multipart/form-data"> 
          <div class="modal-body">          
               <div class="row">
                    <div class="col-md-12">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Tools Id Type<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="tool_id_type" name="tool_id_type" onkeyup=""
                           placeholder="Tools Id Type" class="form-control" required="true"/>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Description<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="id_type_desc" id="id_type_desc" onkeyup=""
                           placeholder="Description" class="form-control" required="true"/>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" onclick="tempData.oeeTools.saveToolsIDTypesType();">Save</button>
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
