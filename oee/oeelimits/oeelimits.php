<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>
<?php error_reporting(0); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalOEEConfigData=new Array();
var reasonTypeArray=new Array();
tempData.oeelimitconfig=
{
loadAllOEEConfigData:function(){
    	var url="getDataController.php";
    	var comId = $('#comp_id').val();
    	var myData={getOEELimitsDetails:"getOEELimitsDetails", comp_id:comId};
    	   $.ajax({
    	        type:"POST",
    	        url:url,
    	        async: false,
    	        dataType: 'json',
    	        data:myData,
    	        success: function(obj){
    	        	globalOEEConfigData=obj.oeeLimitsDetails;
    	        if(obj.oeeLimitsDetails==null){
    	              $('#oeeConfigTable').DataTable({
    	                "paging":false,
    	                "ordering":true,
    	                "info":true,
    	                "searching":false,         
    	                "destroy":true,
    	            }).clear().draw();

    	          }else{
    	        var DataTableProject = $('#oeeConfigTable').DataTable( {
    	                'paging'      : true,
    	                'lengthChange': false,
    	                'searching'   : true,
    	                'ordering'    : true,
    	                'info'        : true,
    	                'autoWidth'   : false,
    	                "destroy":true,
    	                "data":obj.oeeLimitsDetails,   
    	                "columns": [
    	                	{ data: "comp_desc"},
    	                    { data: "plant_desc"},
    	                    { data: "wc_desc" },
    	      			    { data: "eq_desc"},
    	      			    { data: "oee_high",
    	      					render: function (data, type, row, meta) {
    	      						return row.oee_low +' to '+row.oee_high;
    	      					}
    	      				},
    	      			    { data: "a_high",
    	      					render: function (data, type, row, meta) {
    	      						return row.a_low +' to '+row.a_high;
    	      					}
    	      				},
    	      			    { data: "p_high",
    	      					render: function (data, type, row, meta) {
    	      						return row.p_low +' to '+row.p_high;
    	      					}
    	      				},
    	      			    { data: "q_high",
    	      					render: function (data, type, row, meta) {
    	      						return row.q_low +' to '+row.q_high;
    	      					}
    	      				},
    	                    { data: "id" ,className: "text-left",
    	                      render: function (data, type, row, meta) {
    	                          var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeelimitconfig.editOEELimits('+row.id+',\''+row.comp_desc+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
    	                          var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeelimitconfig.deleteOEELimits('+row.id+');"><i class="fa fa-trash"></i> </button>';
    	                         return a+' '+b;
    	                     }
    	                    },
    	                     ]
    	                 }); 
    	        } 
    	        } 
    	    });  
 },
 saveOEEConfig:function(){
		  var url="getDataController.php";
		  $('#p_limits_db').val($('#p_limits').asRange('get'));
		  $('#a_limits_db').val($('#a_limits').asRange('get'));
		  $('#q_limits_db').val($('#q_limits').asRange('get'));
		  $('#oee_limits_db').val($('#oee_limits').asRange('get'));
		  var formEQData = new FormData($('#fromOEELimits')[0]);
		  formEQData.append("saveOEEConfig", "saveOEEConfig");
		  var comp_desc=$('#comp_desc').val();
		    if(comp_desc == 0) { 
			    $('#msg').html('*Select Company');
  		        return false;
		    }else{
		    	$('#msg').html('');
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
		      if(obj.data !=null){
		        if(obj.data.infoRes=='S'){
		           $("#commonMsg").show();
		           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
		           tempData.oeelimitconfig.loadAllOEEConfigData();
		           tempData.oeelimitconfig.clearForm();

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
editOEELimits:function(id){
    for(var i=0;i<globalOEEConfigData.length;i++){ //     
        if(id==globalOEEConfigData[i].id){
            
          $('#oee_limit_id').val(globalOEEConfigData[i].id);
          $('#comp_desc').val(globalOEEConfigData[i].company_id).change();
          $('#plant_desc').val(globalOEEConfigData[i].plant_id).change();
          $('#wc_desc').val(globalOEEConfigData[i].workcenter_id).change();
          $('#eq_desc').val(globalOEEConfigData[i].eq_code).change();

          $('#oee_limits').asRange('set',[globalOEEConfigData[i].oee_low,globalOEEConfigData[i].oee_high]); 
          $('#a_limits').asRange('set',[globalOEEConfigData[i].a_low,globalOEEConfigData[i].a_high]); 
          $('#p_limits').asRange('set',[globalOEEConfigData[i].p_low,globalOEEConfigData[i].p_high]); 
          $('#q_limits').asRange('set',[globalOEEConfigData[i].q_low,globalOEEConfigData[i].q_high]); 
          break;
        }
    }
    $("#fromOEELimits").fadeIn("fast");
    $("#addOEELimits").hide();
    $("#updateOEELimits").show();
	
},
deleteOEELimits:function (id){
	  var url="getDataController.php";
	  var myData={deleteOEELimits:"deleteOEELimits",oee_limit_id:id};
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
	           tempData.oeelimitconfig.loadAllOEEConfigData();
	        }else{
	           $("#delCommonMsg").show();
	           $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
	        }  
	      } 
	      setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);
	    }
	  });
},

reload:function(){
	   location.reload(true);
},
getCompDesc:function(){
	  var url="getDataController.php";
	  var compId = $('#comp_id').val();
	  var myData = {getCompDetails:'getCompDetails', comp_id:compId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	        debugger;
	      if( obj.compDetails !=null){
	    	 $("#comp_desc").html('');
	    	 $("#comp_desc").append('<option value="0"> Select Company </option>');
          		for(var i=0; i< obj.compDetails.length; i++){
      			   $("#comp_desc").append('<option value="'+obj.compDetails[i].id+'">'+obj.compDetails[i].comp_desc+'</option>'); 
          		}
	        }
	      } 
	  });
},
getPlantDesc:function(compId){
	  var url="getDataController.php";
	  var myData = {getPlantDetails:'getPlantDetails', comp_id:compId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	        debugger;
	      if( obj.plantDetails !=null){
	    	 $("#plant_desc").html('');
	    	 $("#plant_desc").append('<option value="0"> Select Plant </option>');
        		for(var i=0; i< obj.plantDetails.length; i++){
    			   $("#plant_desc").append('<option value="'+obj.plantDetails[i].id+'">'+obj.plantDetails[i].plant_desc+'</option>'); 
        		}
	        }
	      } 
	  });
},
getWCDesc:function(pId){
	  var url="getDataController.php";
	  var myData = {getWCDetails:'getWCDetails', plant_id:pId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	      if( obj.wcDetails !=null){
	    	 $("#wc_desc").html('');
	    	 $("#wc_desc").append('<option value="0"> Select Work Center </option>');
        		for(var i=0; i< obj.wcDetails.length; i++){
    			   $("#wc_desc").append('<option value="'+obj.wcDetails[i].id+'">'+obj.wcDetails[i].wc_desc+'</option>'); 
        		}
	        }
	      } 
	  });
},
getEQDesc:function(wcId){
	  var url="getDataController.php";
	  var myData = {getEquipmentDetails:'getEquipmentDetails', wc_id:wcId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	      if( obj.equipmentDetails !=null){
	    	 $("#eq_desc").html('');
	    	 $("#eq_desc").append('<option value="0"> Select Equipment </option>');
      		for(var i=0; i< obj.equipmentDetails.length; i++){
  			   $("#eq_desc").append('<option value="'+obj.equipmentDetails[i].eq_code+'">'+obj.equipmentDetails[i].eq_desc+'</option>'); 
      		}
	        }
	      } 
	  });
},
clearForm:function(){
    $('#comp_desc').val(0).change();  
    $("#fromOEELimits").fadeToggle("slow");
    $('#fromOEELimits')[0].reset();
    $("#addOEELimits").show(); 
    $("#updateOEELimits").hide();
    $("#oee_limit_id").val('');
    $('#p_limits_db').val('');
	$('#a_limits_db').val('');
    $('#q_limits_db').val('');
	$('#oee_limits_db').val('');
    $('#oee_limits').asRange('set',[0,0]); 
    $('#a_limits').asRange('set',[0,0]); 
    $('#p_limits').asRange('set',[0,0]); 
    $('#q_limits').asRange('set',[0,0]);
}

};

$(document).ready(function() {
    debugger;
   $("#menuOeeConfiguration").parent().addClass('active');
   $("#menuOeeConfiguration").parent().parent().closest('.treeview').addClass('active menu-open');
   $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
   $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
   $('#wc_id').val(<?php echo $_GET['wc_id'];?>);

   $('.select2').select2();
   $("#fromOEELimits").hide();
   $('#commonMsg').hide();
  
 tempData.oeelimitconfig.getCompDesc();
 tempData.oeelimitconfig.loadAllOEEConfigData();

 $('#createOEELimits').click(function(){
 	tempData.oeelimitconfig.clearForm();
 });
 
 $('#comp_desc').change(function(){
     $('#msg').html('');
	 var compId = $('#comp_desc').val();
	 if(compId != 0){
		 tempData.oeelimitconfig.getPlantDesc(compId);
	 }else{
		$("#plant_desc").html('');
	 	$("#plant_desc").append('<option value="0"> Select Plant </option>');
		$("#wc_desc").html('');
	 	$("#wc_desc").append('<option value="0"> Select Work Center </option>');
		$("#eq_desc").html('');
	 	$("#eq_desc").append('<option value="0"> Select Equipment </option>');
     }
 });
 $('#plant_desc').change(function(){
	 var pId = $('#plant_desc').val();
	 if(pId != 0){
		 tempData.oeelimitconfig.getWCDesc(pId);
	 }else{
		$("#wc_desc").html('');
	 	$("#wc_desc").append('<option value="0"> Select Work Center </option>');
		$("#eq_desc").html('');
	 	$("#eq_desc").append('<option value="0"> Select Equipment </option>');
     }
 });
 $('#wc_desc').change(function(){
	 var wcId = $('#wc_desc').val();
	 if(wcId != 0){
		 tempData.oeelimitconfig.getEQDesc(wcId);
	 }else{
		$("#eq_desc").html('');
	 	$("#eq_desc").append('<option value="0"> Select Equipment </option>');
     }
 });
 $('#cancel').click(function(){
 	tempData.oeelimitconfig.clearForm();
 });
  $('#oee_limit_id').val('');
  $("#oee_limits").asRange({
      range: true,
      limit: false
   });
  
  $("#a_limits").asRange({
      range: true,
      limit: false
   });
  $("#p_limits").asRange({
      range: true,
      limit: false
   });
  $("#q_limits").asRange({
      range: true,
      limit: false
   });
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">OEE Configuration<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
        </div>
        <button type="button" onclick="tempData.oeelimitconfig.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>
        <button type="button" id="createOEELimits" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add OEE Limits
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
        <form class="" id="fromOEELimits">  
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="oee_limit_id" id="oee_limit_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/>
          <input type="hidden" name="wc_id" id="wc_id"/>
          <input type="hidden" name="eq_code" id="eq_code"/>            
            <div class="form-group">
             <div class="row">   
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label class="control-label col-md-4 col-sm-4 col-xs-12">Company<span class="required">*</span></label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="comp_desc" name="comp_desc" style="width: 100%">
                        </select>
                      </div>
                    </div>  
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Plant</label>
                     <div class="col-md-8 col-sm-8 col-xs-12" >
                      <div class="form-group">
                        <select class="form-control select2"  id="plant_desc" name="plant_desc" style="width: 100%">
                        </select>
                      </div>
                    </div>
                </div>
                 <div class="col-md-3 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Work Center</label>
                     <div class="col-md-8 col-sm-8 col-xs-12" >
                      <div class="form-group">
                        <select class="form-control select2"  id="wc_desc" name="wc_desc" style="width: 100%">
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Equipment</label>
                     <div class="col-md-8 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="eq_desc" name="eq_desc" style="width: 100%">
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              
             <div class="row" style="padding-top: 20px;text-align: center;">
             <input type="hidden" name="oee_limits_db" id="oee_limits_db"/>
             <input type="hidden" name="a_limits_db" id="a_limits_db"/>
                <div class="col-md-6">
                    <div class="col-md-12 col-sm-12 col-xs-12 rangeBarSpace">        
                      <div class="col-md-2 col-sm-2 col-xs-2"><span>Low &nbsp;&nbsp;</span> </div>
                       <div class="col-md-8 col-sm-8 col-xs-8 range-example-3" id="oee_limits" ></div>
                      <div class="col-md-2 col-sm-2 col-xs-2"><span>High</span> </div>
                    </div>
                    <label class="control-label col-md-12 col-sm-12 col-xs-12">OEE Limits<span class="required">*</span></label>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 col-sm-12 col-xs-12 rangeBarSpace">        
                      <div class="col-md-2 col-sm-2 col-xs-2"> <span>Low &nbsp;&nbsp;</span></div>
                       <div class="col-md-8 col-sm-8 col-xs-8 range-example-3" id="a_limits" ></div>
                      <div class="col-md-2 col-sm-2 col-xs-2"><span> High</span> </div>
                    </div>
                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Availability Limits<span class="required">*</span></label>
                </div>
              </div>
              <div class="row" style="padding-top: 40px;text-align: center;">
                <input type="hidden" name="p_limits_db" id="p_limits_db"/> 
                <input type="hidden" name="q_limits_db" id="q_limits_db"/>
                <div class="col-md-6">
                    <div class="col-md-12 col-sm-12 col-xs-12 rangeBarSpace">        
                      <div class="col-md-2 col-sm-2 col-xs-2"><span>Low &nbsp;&nbsp;</span> </div>
                       <div class="col-md-8 col-sm-8 col-xs-8 range-example-3" id="p_limits" ></div>
                      <div class="col-md-2 col-sm-2 col-xs-2"><span>High</span> </div>
                    </div>
                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Performance Limits<span class="required">*</span></label>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 col-sm-12 col-xs-12 rangeBarSpace">        
                      <div class="col-md-2 col-sm-2 col-xs-2"><span>Low &nbsp;&nbsp;</span> </div>
                       <div class="col-md-8 col-sm-8 col-xs-8 range-example-3" id="q_limits" ></div>
                      <div class="col-md-2 col-sm-2 col-xs-2"><span>High</span> </div>
                    </div>
                   <label class="control-label col-md-12 col-sm-12 col-xs-12">Quality Limits<span class="required">*</span></label>
                </div>
              </div>
              
            <br>
              <div class="row">
               <div id="msg" style="padding-left: 28px;color: red;"></div>
                   <div class="col-md-12 text-center">
                    <button type="button" id="addOEELimits" onclick="tempData.oeelimitconfig.saveOEEConfig();"  class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Save
                    </button>
                    <button type="button" id="updateOEELimits" onclick="tempData.oeelimitconfig.saveOEEConfig();"  class="btn btn-sm btn-success" style="display:none;">
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
          <table id="oeeConfigTable" class="table table-hover table-bordered nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Company</th>
              <th>Plant</th>
              <th>Work Center</th>
              <th>Equipment</th>
              <th>OEE Limits</th>
              <th>Availability Limits</th>
              <th>Performance Limits</th>
              <th>Quality Limits</th>
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
