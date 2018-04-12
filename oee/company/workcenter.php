<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalWCData=new Array();
tempData.oeewc=
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
            globalWCData=obj;
    var DataTableProject = $('#wcTable').DataTable( {
        	'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "data":obj,   
            "columns": [
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var c='<button type="button" class="btn btn-success btn-xs" onclick="tempData.oeewc.gotoEquipment();"><i class="fa fa-check-square-o"></i> View Equipment</button>';
                  return c;
                }
              },
              { data: "role_name" },
              { data: "role_desc" },
              { data: "company_name"},
              { data: "plant_name" },
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeewc.editWC('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                   var b='<button type="button" class="btn btn-danger btn-xs" onclick=""><i class="fa fa-trash"></i> </button>';
                  return a+' '+b;
                }
              },
               ]
           } );   
          }
        });  

    },

    editWC:function (id){
        for(var i=0;i<globalWCData.length;i++){
            if(id==globalWCData[i].id){
              alert(globalWCData[i].id);
              $('#wcCode').val(globalWCData[i].role_name);
              $('#wcDesc').val(globalWCData[i].role_desc);
              $('#address').val(globalWCData[i].screens);
              $('#contactPerson').val(globalWCData[i].access_mode);
              $('#contactNumber').val(globalWCData[i].screens);
              break;
            }
        }
        $("#fromWC").fadeIn("fast");
        $("#addWC").hide();
        $("#updateWC").show();
    },

  gotoEquipment:function(){
	  window.location="equipment.php";
  }

};

$(document).ready(function() {
debugger;

$('.select2').select2();
  tempData.oeewc.loadTable();
  $('#createWC').click(function(){
    $("#fromWC").fadeToggle("slow");
      $("#addWC").show();
      $("#updateWC").hide();
  });
  $("#fromWC").fadeOut("fast");
  
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Work Center<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
        <a href="plant.php" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Plant</a>
        </div>
        <button type="button" id="createWC" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Create Work Center
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <form class="" id="fromWC">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/> 
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Work Center Code</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="wcCode" id="wcCode" onkeyup=""
                     placeholder="Work Center Code" maxlength="10" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Work Center Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="wcDesc" id="wcDesc" onkeyup=""
                   placeholder="Work Center Description" class="form-control" required="true"/>
                </div>
                </div>
              </div>
            
              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Contact Person</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="contactPerson" id="contactPerson" onkeyup=""
                   placeholder="Contact Person" class="form-control" required="true"/>
                </div>
                </div>

               <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Contact Number</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="contactNumber" id="contactNumber" onkeyup=""
                   placeholder="Contact Number" class="form-control" required="true"/>
                </div>
                </div>

              </div>

              <div class="row" style="margin-top: 1px;">          
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
                    <button type="button" id="addWC" onclick="" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Work Center 
                    </button>
                    <button type="button" id="updateWC" onclick=""  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update Work Center
                    </button>
                   </div>
              </div>
            </div>  
           <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="wcTable" class="table table-hover table-bordered nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Action</th>
              <th>Work Center Code</th> 
              <th>Work Center Descreption</th>
              <th>Contact Person</th>
              <th>Contact Number</th>
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
