<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalRoleData=new Array();
var myMap = new Map();
  
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
            /*
            for(var i=0;i<obj.length;i++){
              globalRoleData.push({"id":obj.id,"role_name":obj.role_name,"role_desc":obj.role_desc, "company_name":obj.company_name, 
              "plant_name":obj.plant_name, "screens":obj.screens, "access_mode":obj.access_mode});
            }*/
    var DataTableProject = $('#roleTable').DataTable( {
           "paging":false,
            "ordering":true,
            "info":true,
            "searching":true,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 250,
            "data":obj,   
            "columns": [
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeroles.editRole('+row.id+');"><i class="fa fa-pencil-square-o"></i> Edit</button>';
                  return a;
                }
              },
              { data: "role_name" },
              { data: "role_desc" },
              { data: "company_name"},
              { data: "plant_name" },
              { data: "screens"},
              { data: "access_mode" },
               ]
           } );   
          }
        });  

    },

    editRole:function (id){
        for(var i=0;i<globalRoleData.length;i++){
            if(id==globalRoleData[i].id){
              alert(globalRoleData[i].id);

              $('#roleName').val(globalRoleData[i].role_name);
              $('#roleDesc').val(globalRoleData[i].role_desc);
              $("#companyName").val("1").change();

              $('#plantName').val("2").change();
              $('#accessMode').val("2").change();

              $('#screen').val([2,3,5]).change();

              break;
            }

          $("#fromRoles").fadeIn("fast");
        }
           /*   globalRoleData.push({"id":obj.id,"role_name":obj.role_name,"role_desc":obj.role_desc, "company_name":obj.company_name, 
              "plant_name":obj.plant_name, "screens":obj.screens, "access_mode":obj.access_mode});*/
            
    }
};

$(document).ready(function() {
debugger;
$('.select2').select2();

  tempData.oeeroles.loadTable();
  $('#btnAddRoles').click(function(){
    $("#fromRoles").fadeToggle("slow");
  });
  $("#fromRoles").fadeOut("fast");
  
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">User Configuration<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
              <p style="margin: 0px; font-size: 18px; font-weight: 600;">Create Roles</p>
        </div>
        <button type="button" id="btnAddRoles" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Create Roles
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
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Role Name</label>
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
                      <option selected="selected">Select Company</option>
                       <option value="1">Bill Forge</option>
                       <option value="2">MillTech</option>
                    </select>
                  </div>
                </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Plant Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" id="plantName">
                      <option selected="selected">Select Plant</option>
                      <option value="1">Hot Forging MC.</option>
                      <option value="2">MillTech</option>
                    </select>
                  </div>
                </div>
                </div>
              </div>

              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Access Permission</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
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
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Role 
                    </button>
                    <button type="button" id="updateRole" onclick=""  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update Role
                    </button>
                   </div>
              </div>
            </div>  
 <hr class="hr-primary"/>  
          </form>


      <div > 
          <table id="roleTable" class="table table-hover table-bordered table-responsive nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Action</th> 
              <th>Role Name</th>
              <th>Description</th>
              <th>Company Name</th>
              <th>Plant Name</th>
              <th>Access Permissions for Screens</th>
              <th>Access Mode</th>
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
