<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalRoleData=new Array();
var plantArray=new Array();
var companyArray=new Array();

tempData.oeeroles=
{
loadTable:function(){
    debugger;

    var url="loadData.txt";
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            success: function(obj){
            globalRoleData=obj;
    var DataTableProject = $('#roleTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "data":obj,   
            "columns": [
              { data: "role_name" },
              { data: "role_desc" },
              { data: "company_name"},
              { data: "plant_name" },
              { data: "screens"},
              { data: "access_mode" },
               { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                    var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeecompany.editRole('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                    var b='<button type="button" class="btn btn-danger btn-xs" onclick=""><i class="fa fa-trash"></i> </button>';
                   return a+' '+b;
                }
              },
               ]
           } );   
          }
        });  
},
getCompanyForDropdown:function(){//reasonsArray
  var url="getDataController.php";
  var myData = {getCompDetails:'getCompDetails'};
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    cache: false,
    data:myData,
    success: function(obj) {
        debugger;
        if(obj.compDetails !=null){
          companyArray = obj.compDetails;
          $("#plantName").html('');
          $("#plantName").append('<option value="0"> Select Plant </option>');

          $("#companyName").html('');
          $("#companyName").append('<option value="0"> Select Company </option>');
            if(companyArray != null){
              for(var i=0; i< companyArray.length; i++){
               $("#companyName").append('<option value="'+companyArray[i].id+'">'+companyArray[i].comp_desc+'</option>'); 
              }
            }
        }
      } 
  });
},  
getPlantDropdown:function(){
    var url="getDataController.php";
    var comp_id = $('#companyName').val();
    var myData = {getPlantDetails:'getPlantDetails', comp_id:comp_id};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        plantArray = obj.plantDetails;
        if(obj.plantDetails !=null){
           $("#plantName").html('');
         $("#plantName").append('<option value="0"> Select Plant </option>');
            for(var i=0; i< obj.plantDetails.length; i++){
             $("#plantName").append('<option value="'+obj.plantDetails[i].id+'">'+obj.plantDetails[i].plant_desc+'</option>'); 
            }
          }
        } 
    });
},
gotoScreens:function(){
   window.location="screens.php";
},
reload:function(){
     location.reload(true);
},
deleteRoles:function (id,img){
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
saveRoles:function(){
  debugger;
    var url="getDataController.php";
    var formEQData = new FormData($('#fromEquipment')[0]);
    formEQData.append("saveEquipment", "saveEquipment");
    var eq_code=$('#eq_code').val();
    var eq_protocol = $('#eq_protocol').val();
    var eqType = $('#eq_type').val();
    var model = $('#model').val();
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
          if(eq_protocol == ""){
           $('#eq_protocol').css('border-color', 'red');
             return false;
          }else {
            $('#eq_protocol').css('border-color', '');
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
             $("#showImg").hide();
           
             $("#size").html('');
             $('#eq_code').prop('readonly', false);
             $('#fromEquipment')[0].reset();

             $("#addEquipment").show();
             $("#updateEquipment").hide(); 
             $("#reason_codes").val('').change();         
             tempData.oeeEquipment.loadAllEquipment();
             tempData.oeeEquipment.resetModelOnAction();
             tempData.oeeEquipment.resetEQTyOnAction();

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
editRoles:function (id, wcId, eqTypeId, modelId){
  debugger;
   for(var i=0;i<globalEquipmentData.length;i++){ 
       if(id==globalEquipmentData[i].id){
         $("#showImg").show();
         $('#eq_id').val(globalEquipmentData[i].id);
         $('#eq_code').val(globalEquipmentData[i].eq_code);
         $('#eq_desc').val(globalEquipmentData[i].eq_desc);
         $('#eq_protocol').val(globalEquipmentData[i].eq_protocol);
         
         $('#eq_type_id').val(globalEquipmentData[i].eq_type_id);
         $('#eq_model_id').val(globalEquipmentData[i].eq_model_id);
         
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

};

$(document).ready(function() {
debugger;
  $('.select2').select2();
  $('#createRoles').click(function(){
    $("#fromRoles").fadeToggle("slow");
  });
  $("#fromRoles").fadeOut("fast");
  $("#plantName").prop("disabled", true);

  
  $('#companyName').change(function(){
     if($('#companyName').val() != 0){
        tempData.oeeroles.getPlantDropdown();
        $("#plantName").prop("disabled", false); 
     }else{
       $("#plantName").html('');
       $("#plantName").append('<option value="0"> Select Plant </option>');
       $("#plantName").prop("disabled", true); 
     }
  });

  //tempData.oeeroles.loadTable();
  tempData.oeeroles.getCompanyForDropdown();

});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Role Configuration<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <!-- <div class="panel-title pull-left">
              <p style="margin: 0px; font-size: 18px; font-weight: 600;">Create Roles</p>
        </div> -->
        <button type="button" id="createRoles" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Role
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <form class="" id="fromRoles">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/> 
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Name<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="roleName" id="roleName" onkeyup=""
                     placeholder="Role Name" maxlength="10" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="roleDesc" id="roleDesc" onkeyup=""
                   placeholder="Role Description" class="form-control" required="true"/>
                </div>
                </div>
              </div>
            
              <div class="row" style="margin-top: 10px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Company Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" id="companyName">
                    </select>
                  </div>
                </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Plant Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" id="plantName">
                    </select>
                  </div>
                </div>
                </div>
              </div>

              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Access Permission</label>
                <div class="col-md-5 col-sm-5 col-xs-5" style="padding-right: 0px;">
                  <div class="form-group">
                    <select class="form-control select2" multiple="multiple" data-placeholder="Select" style="width: 100%;" id="screen">
                      <option value="1">Dashboard</option>
                      <option value="2">Reports</option>
                      <option value="3">Edit Idle Time</option>
                      <option value="4">Parts</option>
                      <option value="5">Tools</option>
                      <option value="6">Shift config</option>
                      <option value="7">OEE Config</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-2" style="padding-left: 3px;padding-top: 2px; ">
                  <button type="button" class="btn btn-sm btn-info" onclick="tempData.oeeroles.gotoScreens();" >
                    <i class="fa  fa-plus"></i> <!-- data-toggle="modal" data-target="#addEQTypeModal" -->
                  </button>
                </div>

                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Access Mode</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" id="accessMode">
                      <option selected="selected">Select</option>
                      <option value="1">Read</option>
                      <option value="2">Read/Write</option>
                    </select>
                  </div>
                </div>
                </div>
              </div> 

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addRole" onclick="" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Save 
                    </button>
                    <button type="button" id="updateRole" onclick=""  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update
                    </button>
                   </div>
              </div>
            </div>  
 <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="roleTable" class="table table-hover table-bordered nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Role Name</th>
              <th>Description</th>
              <th>Company Name</th>
              <th>Plant Name</th>
              <th>Access Permissions for Screens</th>
              <th>Access Mode</th>
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
