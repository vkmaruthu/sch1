<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalScreenData=new Array();


tempData.oeescreen={
loadScreenTable:function(){
  debugger;
  var url="getDataController.php";
  var myData={screenTable:"screenTable"};
   $.ajax({
        type:"POST",
        url:url,
        async: false,
        dataType: 'json',
        data:myData,
        success: function(obj){
            
        globalScreenData=obj.screenDetails;

        if(obj.screenDetails==null){
              $('#screenTable').DataTable({
                "paging":false,
                "ordering":true,
                "info":true,
                "searching":false,         
                "destroy":true,
            }).clear().draw();

          }else{

var DataTableProject = $('#screenTable').DataTable( {
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "destroy":true,
        "data":obj.screenDetails,   
        "columns": [
          { data: "screenId" },
          { data: "screenName" },
          { data: "screen_descp" },
          { data: "id" ,className: "text-left",
              render: function (data, type, row, meta) {
                var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeescreen.editScreens('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                 var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeescreen.deleteScreens('+row.id+');"><i class="fa fa-trash"></i> </button>';
                return a+' '+b;
              }
            },
           ]
         }); 
        
        } // else End here 

        } // ajax success ends
    });  
},
reload:function(){
     location.reload(true);
},
deleteScreens:function(id){
    var url="getDataController.php";
    var record_id=id;
    var myData={deleteScreen:"deleteScreen",record_id:record_id};
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
               tempData.oeescreen.loadScreenTable();
          }else{
            $("#delCommonMsg").show();
             $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
          }  
        } 
        setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);

      }
    });
},
saveScreens:function(){
  debugger;
    var url="getDataController.php";
    var formEQData = new FormData($('#fromScreen')[0]);
    formEQData.append("saveScreen", "saveScreen");

    var screenId=$('#screenId').val();
    var screenName = $('#screenName').val();
    
      if(screenId == "") {
          $('#screenId').css('border-color', 'red');
          return false;
      }else{
          $('#screenId').css('border-color', '');
        
          if(screenName == ""){
           $('#screenName').css('border-color', 'red');
             return false;
          }else {
            $('#screenName').css('border-color', '');
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

             $('#fromScreen')[0].reset();

             $("#addScreen").show();
             $("#updateScreen").hide();       
              tempData.oeescreen.loadScreenTable();

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
editScreens:function(id){
  debugger;

   for(var i=0;i<globalScreenData.length;i++){ 
       if(id==globalScreenData[i].id){        
         $('#record_id').val(globalScreenData[i].id);
         $('#screenId').val(globalScreenData[i].screenId);
         $('#screenName').val(globalScreenData[i].screenName);
         $('#screen_descp').val(globalScreenData[i].screen_descp);        
         break;         
       }
   }
   $("#fromScreen").fadeIn("fast");
   $("#addScreen").hide();
   $("#updateScreen").show();            
},

};

$(document).ready(function() {
debugger;
   $("#menuScreens").parent().addClass('active');
   $("#menuScreens").parent().parent().closest('.treeview').addClass('active menu-open');

  $('#commonMsg').hide();
  $('.select2').select2();
  $('#createScreen').click(function(){
    $("#fromScreen").fadeToggle("slow");
  });
  $("#fromScreen").fadeOut("fast");
  $("#plantName").prop("disabled", true);

  tempData.oeescreen.loadScreenTable();

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
        <!-- <div class="panel-title pull-left">
              <p style="margin: 0px; font-size: 18px; font-weight: 600;">Create Roles</p>
        </div> -->
        <button type="button" id="createScreen" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Screen
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
        
        <div id="delCommonMsg"> </div>  

        <form class="" id="fromScreen">    
            <input type="hidden" name="record_id" id="record_id"/> 
             <div id="commonMsg"> </div>

            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Id<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="screenId" id="screenId" onkeyup=""
                     placeholder="ID Name" maxlength="10" class="form-control" required="true" autofocus/>
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Name<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="screenName" id="screenName" onkeyup=""
                     placeholder="Screen Name"  class="form-control" required="true"/>
                  </div>
                </div>                
              </div>
            
              <div class="row" style="margin-top: 10px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Screen Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <textarea class="form-control" placeholder="Description" rows="2" id="screen_descp" name="screen_descp"></textarea>
                </div>
                </div>
                
              </div>

              

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addScreen" onclick="tempData.oeescreen.saveScreens();" 
                      class="btn btn-sm btn-success"> <i class="fa fa-floppy-o"></i>&nbsp; Save 
                    </button>
                    <button type="button" id="updateScreen" onclick=""  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update
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
              <th>Screen ID</th>
              <th>Screen Name</th>
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
