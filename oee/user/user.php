<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalUserData=new Array();
var myMap = new Map();
  
tempData.oeeusers=
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
            globalUserData=obj;
    var DataTableProject = $('#userTable').DataTable( {
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
              { data: "plant_name" },
              
              { data: "id" ,className: "text-left",
                  render: function (data, type, row, meta) {
                    var c='<button type="button" class="btn btn-warning btn-xs" onclick=""><i class="fa fa-remove"></i>Inactive </button>';
                    return c;
                  }
              },
              
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeecompany.editUser('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                   var b='<button type="button" class="btn btn-danger btn-xs" onclick=""><i class="fa fa-trash"></i> </button>';
                  return a+' '+b;
                }
              },
               ]
           } );   
          }
        });  

    },

    editUser:function (id){
        for(var i=0;i<globalUserData.length;i++){
            if(id==globalUserData[i].id){
              alert(globalUserData[i].id);

              $('#firstName').val(globalUserData[i].role_name);
              $('#lastName').val(globalUserData[i].role_desc);
              $("#emailId").val("1").change();

              $('#plantName').val("2").change();
              $('#accessMode').val("2").change();

              $('#screen').val([2,3,5]).change();

              break;
            }
        }

     $("#fromUsers").fadeIn("fast");
    }
};

$(document).ready(function() {
debugger;
$('.select2').select2();

  tempData.oeeusers.loadTable();
  $('#createUsers').click(function(){
    $("#fromUsers").fadeToggle("slow");
  });
  $("#fromUsers").fadeOut("fast");
  
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
              <p style="margin: 0px; font-size: 18px; font-weight: 600;">Create Users</p>
        </div>
        <button type="button" id="createUsers" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Create Users
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <form class="" id="fromUsers">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/> 
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">First Name</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="firstName" id="firstName" onkeyup=""
                     placeholder="First Name" maxlength="10" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Last Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="lastName" id="lastName" onkeyup=""
                   placeholder="Last Name" class="form-control" required="true"/>
                </div>
                </div>
              </div>
            
              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Email Id</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="emailId" id="emailId" onkeyup=""
                   placeholder="Email Id" class="form-control" required="true"/>
                </div>
                </div>

               <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" name="password" id="password" onkeyup=""
                   placeholder="Password" class="form-control" required="true"/>
                </div>
                </div>
              </div>

              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Contact Number</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="contactNumber" id="contactNumber" onkeyup=""
                   placeholder="Contact Number" class="form-control" required="true"/>
                </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">User Role</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" id="userRole">
                      <option selected="selected">Select</option>
                      <option value="1">Admin</option>
                      <option value="2">User</option>
                    </select>
                  </div>
                </div>
                </div>
              </div> 

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addUser" onclick="" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add User 
                    </button>
                    <button type="button" id="updateUser" onclick=""  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update User
                    </button>
                   </div>
              </div>
            </div>  
 <hr class="hr-primary"/>  
          </form>


      <div class="table-responsive"> 
          <table id="userTable" class="table table-hover table-bordered  nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email Id</th>
              <th>Contact Number</th>
              <th>User Role</th>
              <th>Status</th>
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
