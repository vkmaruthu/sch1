<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalEquipmentData=new Array();
tempData.oeeEquipment=
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
            globalEquipmentData=obj;
    var DataTableProject = $('#equipmentTable').DataTable( {
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
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeEquipment.editEquipment('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                   var b='<button type="button" class="btn btn-danger btn-xs" onclick=""><i class="fa fa-trash"></i> </button>';
                  return a+' '+b;
                }
              },
               ]
           } );   
          }
        });  

    },

    editEquipment:function (id){
        for(var i=0;i<globalEquipmentData.length;i++){
            if(id==globalEquipmentData[i].id){
              alert(globalEquipmentData[i].id);
              $('#eq_code').val(globalEquipmentData[i].role_name);
              $('#eq_desc').val(globalEquipmentData[i].role_desc);
              $('#address').val(globalEquipmentData[i].screens);
              $('#eq_protocol').val(globalEquipmentData[i].access_mode);
              $('#wc_id').val(globalEquipmentData[i].screens);
              break;
            }
        }
        $("#fromEquipment").fadeIn("fast");
        $("#addEq").hide();
        $("#updateEq").show();
    },

};

$(document).ready(function() {
debugger;

$('.select2').select2();
  tempData.oeeEquipment.loadTable();
  $('#createWC').click(function(){
    $("#fromEquipment").fadeToggle("slow");
      $("#addEq").show();
      $("#updateEq").hide();
  });
  $("#fromEquipment").fadeOut("fast");
  
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Equipment Details<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
        <a href="workcenter.php" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Work Center</a>
        </div>
        <button type="button" id="createWC" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Create Equipment
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <form class="" id="fromEquipment">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/> 
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Equipment Code</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="eq_code" id="eq_code" onkeyup=""
                     placeholder="Equipment Code" maxlength="10" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Equipment Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="eq_desc" id="eq_desc" onkeyup=""
                   placeholder="Equipment Description" class="form-control" required="true"/>
                </div>
                </div>
              </div>
            
              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Equipment Protocol</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="eq_protocol" id="eq_protocol" onkeyup=""
                   placeholder="Equipment Protocol" class="form-control" required="true"/>
                </div>
                </div>

               <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">File Upload</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   
                  <input type="file" name="fileUpload" id="fileUpload" class="form-control col-md-12 col-xs-12" onchange=""/>
                  <span class="pull-right">[ Upload only Image ]  </span>
                  <div id="size"></div>
                  <span id="lblError" style="color:red;font-size:13px;"></span>
                  <span id="success"></span>
                 
                </div>
                </div>

              </div>

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addEq" onclick="" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Equipment
                    </button>
                    <button type="button" id="updateEq" onclick=""  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update Equipment
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
              <th>Action</th>
              <th>Equipment Code</th> 
              <th>Equipment Descreption</th>
              <th>Equipment Protocol</th>
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
