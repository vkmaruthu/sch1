<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalCRData=new Array();
tempData.oeecr=
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
            globalCRData=obj;
    var DataTableProject = $('#createReasonTable').DataTable( {
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
			  { data: "color_code",
					render: function (data, type, row, meta) {
						return '<input class="form-control" id="color_code" name="color_code" style="background-color:'+row.color_code+'" readonly>';
					}
				},
               { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                    var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeecr.editReasons('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                    var b='<button type="button" class="btn btn-danger btn-xs" onclick=""><i class="fa fa-trash"></i> </button>';
                   return a+' '+b;
                }
              },
               ]
           } );   
          }
        });  

    },

    editReasons:function (id){
        for(var i=0;i<globalCRData.length;i++){
            if(id==globalCRData[i].id){
              alert(globalCRData[i].id);
              $('#color').val(globalCRData[i].color_code);
              $('#message').val(globalCRData[i].role_desc);
              $("#reason_code_type").val("1").change();

            $('#color').css('background-color',globalCRData[i].color_code);
           	$('#backgroundColorPicker').spectrum({
           		color: globalCRData[i].color_code,
           		showAlpha: true,
           		move: function(color){
           			$('#color').css('background-color',color.toRgbString());
                       $('#color').val(color.toRgbString());

           		}
           	});
              
              break;
            }
        }

     $("#fromReasons").fadeIn("fast");
            
    }
};

$(document).ready(function() {
debugger;
$('.select2').select2();

  tempData.oeecr.loadTable();
  $('#createReasons').click(function(){
    $("#fromReasons").fadeToggle("slow");
  });
  $("#fromReasons").fadeOut("fast");

  $('#color').css('background-color','rgb(194, 202, 114)');
 	$('#backgroundColorPicker').spectrum({
 		color: 'rgb(194, 202, 114)',
 		showAlpha: true,
 		move: function(color){
 			$('#color').css('background-color',color.toRgbString());
             $('#color').val(color.toRgbString());

 		}
 	});

  $('#color1').css('background-color','rgb(194, 202, 114)');
 	$('#backgroundColorPicker1').spectrum({
 		color: 'rgb(194, 202, 114)',
 		showAlpha: true,
 		move: function(color){
 			$('#color1').css('background-color',color.toRgbString());
             $('#color1').val(color.toRgbString());

 		}
 	});

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
               <a href="assignreason.php" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Assign Reason</a>
        </div>
        <button type="button" id="createReasons" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Create Reason
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <form class="" id="fromReasons">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/> 
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Reason Code Type</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="reason_code_type" style="width: 100%;">
                          <option selected="selected">Select Reason Code Type</option>
                           <option value="1">Productive</option>
                        </select>
                      </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-default" style="width: 100%;">
                        <i class="fa  fa-wrench"></i>&nbsp; Add Reason Type
                      </button>
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
              
               <div class="row" style="margin-top: 10px;">        
                <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Color Code</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    	 <div class="col-md-8" style="padding-left: 0px; padding-right: 0px;">
                    		 <input class="form-control" id="color" name="color" readonly>
                    	</div>
                    	<div class="col-md-4" style="padding-left: 0px; padding-right: 0px; text-align: center;">
                    		 <input class="form-control" id="backgroundColorPicker" name="backgroundColorPicker">
                    	</div>
                    </div>
                </div>
              </div>

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addReason" onclick=""  class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Reason
                    </button>
                    <button type="button" id="updateReason" onclick=""  class="btn btn-sm btn-success" style="display:none;">
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


    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Reason Type</h4>
          </div>
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
                        		 <input class="form-control" id="color1" name="color1" readonly>
                        	</div>
                        	<div class="col-md-4" style="padding-left: 0px; padding-right: 0px; text-align: center;">
                        		 <input class="form-control" id="backgroundColorPicker1" name="backgroundColorPicker1">
                        	</div>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</body>
</html>
