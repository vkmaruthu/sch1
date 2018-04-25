<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalRolesData =new Array();
var plantArray=new Array();
var companyArray=new Array();

tempData.oeeRoles=
{
roleTable:function(){
   debugger;
  var url="getDataController.php";
  var filterComp =$('#filterComp').val();
  var filterPlant=$('#filterPlant').val();

  var myData={roleTable:"roleTable",filterComp:filterComp,filterPlant:filterPlant};
   $.ajax({
        type:"POST",
        url:url,
        async: false,
        dataType: 'json',
        data:myData,
        success: function(obj){
            
        globalRolesData=obj.rolesDetails;

        if(obj.rolesDetails==null){
              $('#roleTable').DataTable({
                "paging":false,
                "ordering":true,
                "info":true,
                "searching":false,         
                "destroy":true,
            }).clear().draw();

          }else{

var DataTableProject = $('#roleTable').DataTable( {
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "destroy":true,
        "data":obj.rolesDetails,   
        "columns": [
          { data: "name" },
          { data: "description" },
          { data: "companyName" },
          { data: "plantName" },
          { data: "screen_access" ,className: "text-left",
            render: function (data, type, row, meta) {
              var a=row.screen_access;
              var text='<div style="white-space:normal;width:200px;">'+a.slice(0, -2)+'</div>';
               return text;
            }
          },
          { data: "access_rights" ,className: "text-left",
            render: function (data, type, row, meta) {
              if(row.access_rights==1){
                return 'Read'; 
              }else{
                return 'Read / Write'; 
              }
            }
          },
          { data: "id" ,className: "text-left",
              render: function (data, type, row, meta) {
                var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeRoles.editRoles('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                 var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeRoles.deleteRoles('+row.id+');"><i class="fa fa-trash"></i> </button>';
                return a+' '+b;
              }
            },
           ]
         }); 
        
        } // else End here 

        } // ajax success ends
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

          $("#filterComp").html('');
          $("#filterComp").append('<option value="0"> Select Company </option>');
            if(companyArray != null){
              for(var i=0; i< companyArray.length; i++){
               $("#filterComp").append('<option value="'+companyArray[i].id+'">'+companyArray[i].comp_desc+'</option>'); 
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
          else{
            $("#plantName").html('');
            $("#plantName").append('<option value="0"> Select Plant </option>');
          }
        } 
    });
},
filterPlantDropdown:function(){
    var url="getDataController.php";
    var comp_id = $('#filterComp').val();
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
              $("#filterPlant").html('');
              $("#filterPlant").append('<option value="0"> Select Plant </option>');
              for(var i=0; i< obj.plantDetails.length; i++){
               $("#filterPlant").append('<option value="'+obj.plantDetails[i].id+'">'+obj.plantDetails[i].plant_desc+'</option>'); 
              }
          }
          else{
            $("#filterPlant").html('');
            $("#filterPlant").append('<option value="0"> Select Plant </option>');
          }
        } 
    });
},
loadAllScreen:function(){
    var url="getDataController.php";
    var myData = {screenTable:'screenTable'};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
          if(obj.screenDetails !=null){
             $("#screens").html('');
              for(var i=0; i< obj.screenDetails.length; i++){
               $("#screens").append('<option value="'+obj.screenDetails[i].id+'">'+obj.screenDetails[i].screenName+'</option>'); 
              }
          }else{
              $("#screens").html('');
          }
        } 
    });
},
gotoScreens:function(){
   window.location="screens.php?screen=r";
},
reload:function(){
     location.reload(true);
},
deleteRoles:function (id){
    var url="getDataController.php";
    var recordId=id;
    var myData={deleteRoles:"deleteRoles",recordId:recordId};
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
             
             tempData.oeeRoles.roleTable();

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

    var formEQData = new FormData($('#fromRoles')[0]);
    formEQData.append("saveRoles", "saveRoles");
    
    var roleName=$('#roleName').val();
    //var companyName = $('#companyName').val();
    var screens = $('#screens').val();
    var accessMode = $('#accessMode').val();
    
      if(roleName == "") {
          $('#roleName').css('border-color', 'red');
          return false;
      }else{
          $('#roleName').css('border-color', '');

          if(screens == ""){
            $('#msg').html('*Select Screens');
               return false;
            }else {
             $('#msg').html('');
          }
         
          if(accessMode == 0){
           $('#msg').html('*Select Access Mode');
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
        if(obj.screenData !=null){
          if(obj.screenData.infoRes=='S'){
             $("#commonMsg").show();
             $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.screenData.info+'</p>');
    
             tempData.oeeRoles.clearForm();
             tempData.oeeRoles.roleTable();
          }else{
            $("#commonMsg").show();
             $('#commonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.screenData.info+'</p>');
          }  
        } 

        setTimeout(function(){  
          $("#commonMsg").fadeToggle('slow');        
        }, 1500);

      }
    });
  }
},
editRoles:function (id){
  debugger;
   for(var i=0;i<globalRolesData.length;i++){ 
       if(id==globalRolesData[i].id){
         $('#recordId').val(globalRolesData[i].id);
         $('#roleName').val(globalRolesData[i].name);
         $('#roleDesc').val(globalRolesData[i].description);
         if(globalRolesData[i].companyName==''){
            $('#companyName').val(0).change();         
            $('#plantName').val(0).change();
         }else{
            $('#companyName').val(globalRolesData[i].company_id).change();         
            $('#plantName').val(globalRolesData[i].plant_id).change();
         }
         
         $('#accessMode').val(globalRolesData[i].access_rights).change();

         var str = globalRolesData[i].screen_access_arr;
         var screens = new Array();
         screens = str.split(",");
         $('#screens').val(screens).change();
         break;
       }
   }
   $("#fromRoles").fadeIn("fast");
   $("#addRole").hide();
   $("#updateRole").show();            
},
clearForm:function(){
    $('#fromRoles')[0].reset();
    $("#addRole").show();
    $("#updateRole").hide();             
    $("#screens").val('').change(); 
    $("#accessMode").val(0).change(); 
    $("#companyName").val(0).change(); 
    $("#plantName").val(0).change(); 
    $("#fromRoles").fadeToggle("slow");
}

};

$(document).ready(function() {
debugger;
  $('.select2').select2();
  $('#createRoles').click(function(){
    $("#fromRoles").fadeToggle("slow");
  });
  $("#fromRoles").fadeOut("fast");
  $("#plantName").prop("disabled", true);
  $("#filterPlant").prop("disabled", true);

  
  $('#companyName').change(function(){
     if($('#companyName').val() != 0){
        tempData.oeeRoles.getPlantDropdown();
        $("#plantName").prop("disabled", false); 
     }else{
       $("#plantName").html('');
       $("#plantName").append('<option value="0"> Select Plant </option>');
       $("#plantName").prop("disabled", true); 
     }
  });  

  $('#filterComp').change(function(){
     if($('#filterComp').val() != 0){
        tempData.oeeRoles.filterPlantDropdown();
        $("#filterPlant").prop("disabled", false); 
     }else{
       $("#filterPlant").html('');
       $("#filterPlant").append('<option value="0"> Select Plant </option>');
       $("#filterPlant").prop("disabled", true); 
     }
  });

  $('#roleName').keyup(function(){
     this.value = this.value.toUpperCase();
     $('#roleName').css('border-color', '');
  });

    $('#roleDesc').change(function(){
        $('#msg').html('');
     });
     $('#companyName').change(function(){
        $('#msg').html('');
     });
     
     $('#screens').change(function(){
         $('#msg').html('');
      });

      $('#accessMode').change(function(){
         $('#msg').html('');
      });

  tempData.oeeRoles.roleTable();
  tempData.oeeRoles.getCompanyForDropdown();
  tempData.oeeRoles.loadAllScreen();

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
          <button type="button" onclick="tempData.oeeRoles.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>

        <button type="button" id="createRoles" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">  <i class="fa fa-pencil-square-o"></i>&nbsp; Add Role
        </button>

          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
         <div id="delCommonMsg"> </div>
         <div id="commonMsg"> </div>  

        <form class="" id="fromRoles">    
          <input type="hidden" name="recordId" id="recordId"/>     
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
                    <select class="form-control select2" style="width: 100%;" id="companyName" name="companyName">
                    </select>
                  </div>
                </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Plant Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" id="plantName" name="plantName">
                    </select>
                  </div>
                </div>
                </div>
              </div>

              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Screens</label>
                <div class="col-md-5 col-sm-5 col-xs-10" style="padding-right: 0px;">
                  <div class="form-group">
                    <select class="form-control select2" multiple="multiple" data-placeholder="Select Screens" style="width: 100%;" id="screens" name="screens[]">                     
                    </select>
                  </div>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-2" style="padding-left: 3px;padding-top: 2px; ">
                  <button type="button" class="btn btn-sm btn-info" onclick="tempData.oeeRoles.gotoScreens();" >
                    <i class="fa  fa-plus"></i> <!-- data-toggle="modal" data-target="#addEQTypeModal" -->
                  </button>
                </div>

                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Access Mode</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" id="accessMode" name="accessMode">
                      <option value="0">Select Mode</option>
                      <option value="1">Read</option>
                      <option value="2">Read/Write</option>
                    </select>
                  </div>
                </div>
                </div>
              </div> 

              <div class="row">
                   <div id="msg" style="padding-left: 28px;color: red;"></div>
                 <div class="col-md-12 text-center">
                  <button type="button" id="addRole" onclick="tempData.oeeRoles.saveRoles();" class="btn btn-sm btn-success">
                    <i class="fa fa-floppy-o"></i>&nbsp; Save 
                  </button>
                  <button type="button" id="updateRole" onclick="tempData.oeeRoles.saveRoles();"  class="btn btn-sm btn-success" style="display:none;"> <i class="fa fa-floppy-o"></i>&nbsp; Update
                  </button>
                  <button type="button" id="cancelRole" onclick="tempData.oeeRoles.clearForm();"  class="btn btn-sm btn-danger"> <i class="glyphicon glyphicon-remove"></i>&nbsp; Cancel
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
                   <select class="form-control select2"  id="filterComp" name="filterComp" >
                      <option value="0">Select Company</option>
                   </select>
                   
                   <select class="form-control select2"  id="filterPlant" name="filterPlant" >
                      <option value="0">Select Plant</option>
                   </select>
                   
                  <button type="button" onclick="tempData.oeeRoles.roleTable();" class="btn btn-sm btn-primary pull-right" style="padding-top: 6px;margin-left:15px;"><i class="fa  fa-refresh"></i>
                  </button>
                </label>
            </div>
        </div>


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
