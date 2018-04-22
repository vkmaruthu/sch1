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
  var wcId = $('#workcenters').val();
  var url="getDataController.php";
  var myData={getPODetails:"getPODetails", plant_id:plantId, wc_id:wcId};
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){
            globalPOData=obj.poDetails;
            
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
              { data: "operation" },
              { data: "material" },
              { data: "conf_no" },
              { data: "target_qty"},
              { data: "line_feed_qty"},
              { data: "conf_yield"},
              { data: "conf_scrap"},
/*            { data: "conf_count"},
              { data: "is_final_confirmed"}, */
              { data: "wc_desc"},
              { data: "id" ,className: "text-left",
                  render: function (data, type, row, meta) {
                    var c='<button type="button" class="btn btn-primary btn-xs" onclick=""><i class="fa fa-pencil-square-o"></i>Assign </button>';
                    var d='<button type="button" class="btn btn-danger btn-xs" onclick=""><i class="fa fa-remove"></i> complete </button>';
                    return c+' '+d;
                  }
              },
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeprodorder.editPO('+row.id+',\''+row.workcenter_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
                  var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeprodorder.deletePO('+row.id+');"><i class="fa fa-trash"></i> </button>';
                  return a+' '+b;
                }
              },
               ]
           });

           } // else End here    //image_file_name

          } // ajax success ends
        });   

},
editPO:function (id, wcId){
    for(var i=0;i<globalPOData.length;i++){
        if(id==globalPOData[i].id){
          $('#po_id').val(globalPOData[i].id);
          $('#order_number').val(globalPOData[i].order_number);
          $('#operation').val(globalPOData[i].operation);
          $('#line_feed_qty').val(globalPOData[i].line_feed_qty);
          $('#material').val(globalPOData[i].material);
          $('#target_qty').val(globalPOData[i].target_qty);
          $('#conf_no').val(globalPOData[i].conf_no);
          $('#workcenter_id').val(wcId).change();
          $('#order_number').prop('readonly', true);
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

savePO:function(){
  var url="getDataController.php";
  var fromPOData = new FormData($('#fromPO')[0]);
  fromPOData.append("savePO", "savePO");
  var order_number=$('#order_number').val();
  var wc = $('#workcenter_id').val();
    if(order_number == "") {
        $('#order_number').css('border-color', 'red');
        return false;
    }else{
          $('#order_number').css('border-color', '');
          if(wc == 0){
               $('#msg').html('*Select Work Center');
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
reload:function(){
   location.reload(true);
},
getWCForDropdown:function(){
	  var url="getDataController.php";
	  var compId = $('#comp_id').val();
	  var myData = {getWCDetails:'getWCDetails', comp_id:compId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	      if(obj.wcDetails !=null){
	    	  wcArray = obj.wcDetails;
           	if(wcArray != null){
           	 $("#workcenter_id").html('');
	    	 $("#workcenter_id").append('<option value="0"> Select Work Center </option>');
          		for(var i=0; i< wcArray.length; i++){
      			   $("#workcenter_id").append('<option value="'+wcArray[i].id+'">'+wcArray[i].wc_desc+'</option>'); 
          		}
          	}
	        }
	      } 
	  });
},
getWCForFilterDropdown:function(){
	  var url="getDataController.php";
	  var plantId = $('#plants').val();
	  var myData = {getWCDetails:'getWCDetails', plant_id:plantId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
            $("#workcenters").html('');
    	    $("#workcenters").append('<option value="0"> Select Work Center </option>');
	      if(obj.wcDetails !=null){
        		for(var i=0; i< obj.wcDetails.length; i++){
    			   $("#workcenters").append('<option value="'+obj.wcDetails[i].id+'">'+obj.wcDetails[i].wc_desc+'</option>'); 
        		}
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
    var p = $('#plants').val();
    var wc = $('#workcenters').val();
    if(p !=0 && wc != 0){
	   tempData.oeeprodorder.loadAllPO();
	}else{
       alert('Select both Plant & Work center');
	}
},
clearForm:function(){
    $('#order_number').prop('readonly', false);
    $('#fromPO')[0].reset();
    $("#fromPO").fadeToggle("slow");
    $("#addPO").show();
    $("#updatePO").hide();
    $("#workcenter_id").val(0).change();
    $("#plantSave").val(0).change();
}

};

$(document).ready(function() {
debugger;
  $('#comp_id').val(1);
  $('.select2').select2();  
  $('#commonMsg').hide();
  $("#fromPO").hide();
  $("#workcenters").prop("disabled", true); 
  $('#createPO').click(function(){
	  tempData.oeeprodorder.clearForm();
  });

  $('#cancel').click(function(){
	  tempData.oeeprodorder.clearForm();
  });

  $('#order_number').keyup(function(){
     $('#order_number').css('border-color', '');
  });

  $("#target_qty").keyup(function() {
      $("#target_qty").val(this.value.match(/[0-9]*/));
  }); 

  $("#line_feed_qty").keyup(function() {
      $("#line_feed_qty").val(this.value.match(/[0-9]*/));
  }); 
  
  $("#conf_no").keyup(function() {
      $("#conf_no").val(this.value.match(/[0-9]*/));
  }); 
  $("#operation").keyup(function() {
      $("#operation").val(this.value.match(/[0-9]*/));
  });

  $('#workcenter_id').change(function(){
      $('#msg').html('');
  });

  $('#plants').change(function(){	  
         if($('#plants').val() != 0){
            tempData.oeeprodorder.getWCForFilterDropdown();
            $("#workcenters").prop("disabled", false);           
         }else{
         	 $("#workcenters").html('');
	    	 $("#workcenters").append('<option value="0"> Select Work Center </option>');
        	 $("#workcenters").prop("disabled", true); 
         }
   });
  
    tempData.oeeprodorder.loadAllPO();
    tempData.oeeprodorder.getWCForDropdown();
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
         
        <form class="" id="fromPO" enctype="multipart/form-data">     
          <input type="hidden" name="comp_id" id="comp_id"/>
          <input type="hidden" name="plant_id" id="plant_id"/> 
          <input type="hidden" name="wc_id" id="wc_id"/> 
          <input type="hidden" name="eq_id" id="eq_id"/> 
          <input type="hidden" name="po_id" id="po_id"/> 
            <div id="commonMsg"> </div>  
            
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
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Work Center <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="workcenter_id" name="workcenter_id" style="width:100%;">
                        </select>
                      </div>
                    </div>
                </div>
              </div>
            
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">PO Number <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="order_number" id="order_number" placeholder="Production Order Number" maxlength="20" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Operation</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="operation" id="operation" onkeyup=""
                   placeholder="Operation Number" class="form-control" required="true"/>
                </div>
                </div>
              </div>
              
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Material<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="material" id="material" onkeyup=""
                       placeholder="Material" class="form-control" required="true"/>
                    </div>
                </div>
                
                <div class="col-md-6">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Confirmation Number</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="conf_no"  maxlength="15" id="conf_no" onkeyup=""
                       placeholder="Confirmation Number" class="form-control" required="true"/>
                    </div>
                </div>
              </div> 
            
              <div class="row" style="margin-top: 5px;">
               <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Target Quantity<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="target_qty"  maxlength="15" id="target_qty" onkeyup=""
                       placeholder="Target Qty" class="form-control" required="true"/>
                    </div>
                </div>
               <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Line feed Quantity<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="line_feed_qty"  maxlength="15" id="line_feed_qty" onkeyup=""
                       placeholder="Line Feed Qty" class="form-control" required="true" value="0"/>
                    </div>
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
                   
                   <select class="form-control select2"  id="workcenters" name="workcenters" style="width : auto;">
                      <option value="0">Select Work Centers</option>
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
               <th>Production Order Number</th>
               <th>Operation</th> 
               <th>Material</th> 
               <th>Confirmation Number</th>
               <th>Target Qty</th>
               <th>Line Feed Qty</th>
               <th>Confirmed Yield</th>
               <th>Confirmed Scrap</th>
               <th>Work Center</th>
               <th>Action</th>
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
