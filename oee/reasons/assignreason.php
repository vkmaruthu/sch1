<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalScreenData=new Array();
tempData.oeescreens=
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
            globalScreenData=obj;
    var DataTableProject = $('#screenTable').DataTable( {
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
               { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                    var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeescreens.editScreen('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                    var b='<button type="button" class="btn btn-danger btn-xs" onclick=""><i class="fa fa-trash"></i> </button>';
                   return a+' '+b;
                }
              },
               ]
           } );   
          }
        });  

    },

    editScreen:function (id){
        for(var i=0;i<globalScreenData.length;i++){
            if(id==globalScreenData[i].id){
              alert(globalScreenData[i].id);
              $('#screen_id').val(globalScreenData[i].role_name);
              $('#screen_desc').val(globalScreenData[i].role_desc);
              $("#companyName").val("1").change();
              break;
            }
        }

     $("#fromScreen").fadeIn("fast");
            
    }
};

$(document).ready(function() {
debugger;
$('.select2').select2();

  tempData.oeescreens.loadTable();
  $('#createScreens').click(function(){
    $("#fromScreen").fadeToggle("slow");
  });
  $("#fromScreen").fadeOut("fast");
  
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Screen Configuration<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
              <p style="margin: 0px; font-size: 18px; font-weight: 600;">Create Screen</p>
        </div>
        <button type="button" id="createScreens" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Create Screen
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <form class="" id="fromScreen">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/> 
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Id</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="screen_id" id="screen_id" onkeyup=""
                     placeholder="Screen Id" maxlength="10" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="screen_desc" id="screen_desc" onkeyup=""
                   placeholder="Screen Description" class="form-control" required="true"/>
                </div>
                </div>
              </div>

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addScreen" onclick=""  class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Screen 
                    </button>
                    <button type="button" id="updateScreen" onclick=""  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update Screen
                    </button>
                   </div>
              </div>
            </div>  
 <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="screenTable" class="table table-hover table-bordered nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>id</th>
              <th>Screen Id</th>
              <th>Screen Description</th>
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
