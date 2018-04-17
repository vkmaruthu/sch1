<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>
<?php error_reporting(0); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalCRData=new Array();
var reasonTypeArray=new Array();
tempData.oeecr=
{
loadAllReason:function(){
    	var url="getDataController.php";
    	var myData={getReasonsDetails:"getReasonsDetails"};
    	   $.ajax({
    	        type:"POST",
    	        url:url,
    	        async: false,
    	        dataType: 'json',
    	        data:myData,
    	        success: function(obj){
    	            
    	        	globalCRData=obj.reasontDetails;

    	        if(obj.reasontDetails==null){
    	              $('#createReasonTable').DataTable({
    	                "paging":false,
    	                "ordering":true,
    	                "info":true,
    	                "searching":false,         
    	                "destroy":true,
    	            }).clear().draw();

    	          }else{

    	        var DataTableProject = $('#createReasonTable').DataTable( {
    	                'paging'      : true,
    	                'lengthChange': false,
    	                'searching'   : true,
    	                'ordering'    : true,
    	                'info'        : true,
    	                'autoWidth'   : false,
    	                "destroy":true,
    	                "data":obj.reasontDetails,   
    	                "columns": [
    	                    { data: "message1"},
    	                    { data: "message" },
    	      			    { data: "color_code",
    	      					render: function (data, type, row, meta) {
    	      						return '<input class="form-control" id="color_code" name="color_code" style="background-color:'+row.color_code+'" readonly>';
    	      					}
    	      				},
    	                    { data: "id" ,className: "text-left",
    	                      render: function (data, type, row, meta) {
    	                          var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeecr.editReasons('+row.id+',\''+row.reason_type_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
    	                          var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeecr.deleteReason('+row.id+');"><i class="fa fa-trash"></i> </button>';
    	                         return a+' '+b;
    	                     }
    	                    },
    	                     ]
    	                 }); 
    	        
    	        } // else End here 

    	        } // ajax success ends
    	    });  
   },
   saveReasons:function(){ //reason_type_id backgroundColorPicker message
		debugger;
		  var url="getDataController.php";
		  var formEQData = new FormData($('#fromReasons')[0]);
		  formEQData.append("saveReasons", "saveReasons");
		  var reason_type_id=$('#reason_type_id').val();
		  var message = $('#message').val();
		  
		    if(reason_type_id == 0) { 
			    $('#msg').html('*Select Reason Type');
  		        return false;
		    }else{
		    	$('#msg').html('');
			    if(message == "") {
			        $('#message').css('border-color', 'red');
			        return false;
			    }else{
			    	$('#message').css('border-color', '');
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
		           $('#fromReasons')[0].reset();

		           $("#addReason").show();
		           $("#updateReason").hide();          
		           tempData.oeecr.loadAllReason();
		           tempData.oeecr.resetRTyOnAction();

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
deleteReason:function (id){
	  var url="getDataController.php";
	  var myData={deleteReason:"deleteReason",reason_id:id};
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
	           
	           tempData.oeecr.loadAllReason();

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

editReasons:function (id, type_id){
	debugger;
    for(var i=0;i<globalCRData.length;i++){ 
       if(id==globalCRData[i].id){
         $('#reason_id').val(globalCRData[i].id);
         $('#message').val(globalCRData[i].message);
         $('#reason_type_id').val(type_id).change();
         
         $('#color').css('background-color',globalCRData[i].color_code);
         $('#color').val(globalCRData[i].color_code);
        	/* $('#color_code').spectrum({
        		color: globalCRData[i].color_code,
        		showAlpha: true,
        		move: function(color){
        			$('#color').css('background-color',color.toHexString());
                    $('#color').val(color.toHexString());

        		}
        	}); */
        	
         break;
         
       }
   }
   $("#fromReasons").fadeIn("fast");
   $("#addReason").hide();
   $("#updateReason").show();            
},
saveReasonType:function(){
	  var url="getDataController.php";
	  var formEQData = new FormData($('#fromReasonType')[0]);
	  formEQData.append("saveReasonType", "saveReasonType");
	  var message1=$('#message1').val();
	    if(message1 == "") {
	        $('#message1').css('border-color', 'red');
	        return false;
	    }else{
	      $('#message1').css('border-color', '');
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
	           $('#fromReasonType')[0].reset();
	           $('#reasonTypeModal').modal('hide');
	           tempData.oeecr.getReasonTypesForDropdown();

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
getReasonTypesForDropdown:function(){
	  var url="getDataController.php";
	  var myData = {getReasonType:'getReasonType'};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	        debugger;
	      if(obj.reasonTypes !=null){
	    	  reasonTypeArray = obj.reasonTypes;
	    	 $("#reason_type_id").html('');
	    	 $("#reason_type_id").append('<option value="0"> Select Reason Type </option>');
           	if(reasonTypeArray != null){
          		for(var i=0; i< reasonTypeArray.length; i++){
      			   $("#reason_type_id").append('<option value="'+reasonTypeArray[i].id+'">'+reasonTypeArray[i].message+'</option>'); 
          		}
          	}
	        }
	      } 
	  });
},
resetRTyOnAction:function(){
   	if(reasonTypeArray != null){
   	 $("#reason_type_id").html('');
	 $("#reason_type_id").append('<option value="0"> Select Reason Type </option>');
  		for(var i=0; i< reasonTypeArray.length; i++){
			   $("#reason_type_id").append('<option value="'+reasonTypeArray[i].id+'">'+reasonTypeArray[i].message+'</option>'); 
  		}
  	}
},
gotoBack:function(){
	 var comp_id = $('#comp_id').val();
	 var plant_id = $('#plant_id').val();
	 var wc_id = $('#wc_id').val();
	 window.location="equipment.php?comp_id="+comp_id+"&plant_id="+plant_id+"&wc_id="+wc_id;
},


};

$(document).ready(function() {
debugger;

    $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
    $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
    $('#wc_id').val(<?php echo $_GET['wc_id'];?>);
  
  $('#color').css('background-color','#b2ba62');
 	$('#color_code').spectrum({
 		color: '#b2ba62',
 		showAlpha: true,
 		move: function(color){
 			$('#color').css('background-color',color.toHexString());
             $('#color').val(color.toHexString());

 		}
 	});

  $('#color_code1').css('background-color','#b2ba62');
 	$('#backgroundColorPicker1').spectrum({
 		color: '#b2ba62',
 		showAlpha: true,
 		move: function(color){
 			$('#color_code1').css('background-color',color.toHexString());
            $('#color_code1').val(color.toHexString());

 		}
 	});

    $('#reason_type_id').change(function(){
        $('#msg').html('');
     });

  $('.select2').select2();
  $("#fromReasons").hide();
  $('#commonMsg').hide();
    $('#createReasons').click(function(){
      $("#fromReasons").fadeToggle("slow");
        $('#eq_code').prop('readonly', false);
        $('#fromReasons')[0].reset();
        $("#addReason").show();
        $("#updateReason").hide();
    });
     if($('#comp_id').val() != "" && $('#wc_id').val() != ""){
    	$('#back').show();
     }else{
    	 $('#back').hide();
      }
 tempData.oeecr.getReasonTypesForDropdown();
 tempData.oeecr.loadAllReason();

});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Reason Code<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
               <a onclick="tempData.oeecr.gotoBack();" class="btn btn-info btn-xs" id="back"><i class="fa fa-reply"></i>Back</a>
        </div>
        <button type="button" onclick="tempData.oeecr.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>
        <button type="button" id="createReasons" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Reasons
        </button>
        
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>
          
          <div id="delCommonMsg"> </div>  

        <form class="" id="fromReasons">  
           
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="reason_id" id="reason_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/>
          <input type="hidden" name="wc_id" id="wc_id"/>
          <div id="commonMsg"> </div>
            
            <div class="form-group">
             <div class="row">   
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12"> Reason Code Type <span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-10" style="padding-right: 0px;">
                      <div class="form-group">
                        <select class="form-control select2"  id="reason_type_id" name="reason_type_id">
                        </select>
                      </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-2" style="padding-left: 3px;padding-top: 3px; ">
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reasonTypeModal">
                        <i class="fa  fa-plus"></i>
                      </button>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Color Code</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    	 <div class="col-md-8" style="padding-left: 0px; padding-right: 0px;">
                    		 <input type="text" class="form-control" id="color" name="color" readonly>
                    	</div>
                    	<div class="col-md-4" style="padding-left: 0px; padding-right: 0px; text-align: center;">
                    		 <input class="form-control" id="color_code" name="color_code">
                    	</div>
                    </div>
                </div>
                
              </div>
              
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Reason message</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="message" id="message" onkeyup=""
                       placeholder="Reason message" class="form-control" required="true"/>
                    </div>
                </div>
                
                <div class="col-md-6">
                </div>
              </div>

              <div class="row">
               <div id="msg" style="padding-left: 28px;color: red;"></div>
                   <div class="col-md-12 text-center">
                    <button type="button" id="addReason" onclick="tempData.oeecr.saveReasons();"  class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Reason
                    </button>
                    <button type="button" id="updateReason" onclick="tempData.oeecr.saveReasons();"  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update Reason
                    </button>
                   </div>
              </div>
            </div>  
 <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="createReasonTable" class="table table-hover table-bordered nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Reason Code Type</th>
              <th>Reason Message</th>
              <th>Color Code</th>
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


    <div class="modal fade" id="reasonTypeModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Reason Type</h4>
          </div>
          <form id="fromReasonType" enctype="multipart/form-data"> 
          <div class="modal-body">          
               <div class="row">
                    <div class="col-md-12">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Reason message</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="message1" id="message1" onkeyup=""
                           placeholder="Reason message" class="form-control" required="true"/>
                        </div>
                    </div>
                    
                    <div class="col-md-12" style="padding-top: 10px;">
                        <label class="control-label col-md-4 col-sm-6 col-xs-12">Color Code</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        	 <div class="col-md-8" style="padding-left: 0px; padding-right: 0px;">
                        		 <input class="form-control" id="color_code1" name="color_code1" readonly>
                        	</div>
                        	<div class="col-md-4" style="padding-left: 0px; padding-right: 0px; text-align: center;">
                        		 <input class="form-control" id="backgroundColorPicker1" name="backgroundColorPicker1">
                        	</div>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="tempData.oeecr.saveReasonType();">Save</button>
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
