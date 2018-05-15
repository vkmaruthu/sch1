<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalPlantsData=new Array();
var myMap = new Map();
  
tempData.oeeparts=
{
loadAllPart:function(){
 debugger;
  var comId = $('#comp_id').val();
  var plantId = $('#plant_id').val();
  var url="getDataController.php";
  var myData={getPartsDetails:"getPartsDetails", comp_id:comId, plant_id:plantId};
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){

            globalPlantsData=obj.partsDetails;

        if(obj.partsDetails==null){
          $('#partsTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

        }else{

    var DataTableProject = $('#partsTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "destroy":true,
            "data":obj.partsDetails,   
            "columns": [
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var c='<button type="button" class="btn btn-success btn-xs" onclick="tempData.oeeparts.gotoTools('+row.id+');"><i class="fa fa-check-square-o"></i> View Tools</button>';
                  return c;
                }
              },
              { data: "part_num" },
              { data: "part_desc" },
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeparts.editPart('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                  var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeparts.deletePart('+row.id+');"><i class="fa fa-trash"></i> </button>';
                  return a+' '+b;
                }
              },
               ]
           });

           } // else End here    //image_file_name

          } // ajax success ends
        });    


},
editPart:function (id){
    for(var i=0;i<globalPlantsData.length;i++){
        if(id==globalPlantsData[i].id){
          $('#part_id').val(globalPlantsData[i].id);
          $('#part_num').val(globalPlantsData[i].part_num);
          $('#part_desc').val(globalPlantsData[i].part_desc);
          $('#part_num').prop('readonly', true);
          break;

        }
    }
    $("#fromParts").fadeIn("fast");
    $("#addPartBtn").hide();
    $("#updatePart").show();            
},
deletePart:function (id){
  var url="getDataController.php";
  var part_id=id;
  var myData={deleteParts:"deleteParts",part_id:part_id};
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
           tempData.oeeparts.loadAllPart();

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

savePart:function(){
  var url="getDataController.php";
  var fromPartData = new FormData($('#fromParts')[0]);
  fromPartData.append("saveParts", "saveParts");
  var part_num=$('#part_num').val();

    if(part_num == "") {
        $('#part_num').css('border-color', 'red');
        return false;
    }else{
      $('#part_num').css('border-color', '');
       if( $('#part_desc').val() ==  ""){
 	     $('#part_desc').css('border-color', 'red');
         return false;
       }else{
    	   $('#part_desc').css('border-color', '');
       }


  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    data:fromPartData,
    success: function(obj) {
        debugger;
      if(obj.data !=null){
        if(obj.data.infoRes=='S'){
           $("#commonMsg").show();
           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
           tempData.oeeparts.clearForm();
           tempData.oeeparts.loadAllPart();

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
gotoTools:function(id){
    var comId = $('#comp_id').val();
    var plantId = $('#plant_id').val();
     if($('#screen').val() == "c"){
         window.location="tools.php?comp_id="+comId+"&plant_id="+plantId+"&part_id="+id+"&screen=c";
     }else{
    	 window.location="tools.php?comp_id="+comId+"&plant_id="+plantId+"&part_id="+id+"&screen=p";
     }
},
reload:function(){
   location.reload(true);
},
gotoBack:function(){
 var comp_id = $('#comp_id').val();
 var plant_id = $('#plant_id').val();
  if($('#screen').val() == "c"){
     window.location="../company/plant.php?comp_id="+comp_id+"&plant_id="+plant_id;
  }else{
	  window.location="../partsandtools/plant.php?comp_id="+comp_id+"&plant_id="+plant_id;
  }
},
/* getCompanyDesc:function(){	
	  var url="getDataController.php";
	  var comp_id=$('#comp_id').val();
	  var myData={getCompDetails:"getCompDetails",comp_id:comp_id};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    data:myData,
	    success: function(obj) {
	      if(obj.compDetails !=null){
	        $('#compName').html(obj.compDetails[0].comp_desc);
	      } 
	    }
	  });
}, */
getPlantDesc:function(){	
	  var url="getDataController.php";
	  var plant_id=$('#plant_id').val();
	  var comp_id=$('#comp_id').val();
	  var myData={getPlantDetails:"getPlantDetails",plant_id:plant_id, comp_id:comp_id};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    data:myData,
	    success: function(obj) {
	      if(obj.plantDetails !=null){
	        $('#plantName').html(obj.plantDetails[0].plant_desc);
	      } 
	    }
	  });
},
clearForm:function(){
    $('#part_num').prop('readonly', false);
    $('#fromParts')[0].reset();
    $("#fromParts").fadeToggle("slow");
    $("#addPartBtn").show();
    $("#updatePart").hide();
}

};

$(document).ready(function() {
debugger;


  $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
  $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
  $('#screen').val('<?php echo $_GET['screen'];?>');

  if($('#screen').val() == "p"){
	  $("#menuPlants").parent().addClass('active');
	  $("#menuPlants").parent().parent().closest('.treeview').addClass('active menu-open');
   }else{
	   $("#menuCompany").parent().addClass('active');
	   $("#menuCompany").parent().parent().closest('.treeview').addClass('active menu-open');
   }
  
  $('.select2').select2();  
  $('#commonMsg').hide();
  $("#fromParts").hide();

  $('#createPart').click(function(){
	tempData.oeeparts.clearForm();
  });
  $('#cancel').click(function(){
		tempData.oeeparts.clearForm();
   });

  $('#part_num').keyup(function(){
     $('#part_num').css('border-color', '');
  });
  $('#part_desc').keyup(function(){
	     $('#part_desc').css('border-color', '');
  });

  $("#contact_number").keyup(function() {
      $("#contact_number").val(this.value.match(/[0-9]*/));
  }); 
    tempData.oeeparts.loadAllPart();
    //tempData.oeeparts.getCompanyDesc();
    tempData.oeeparts.getPlantDesc();
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h4 style="margin-top: 3px;"><a id="plantName" ></a><b> / Parts(FG) </b></h4>
        </div>
      </div>
      <!--<a id="compName" ></a> <b>/</b>  -->
    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
             <a onclick="tempData.oeeparts.gotoBack();" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Back </a>
        </div>
        <button type="button" onclick="tempData.oeeparts.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>

        <button type="button" id="createPart" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Part
        </button>

       
      <div class="clearfix"></div>
      </div>   
      <div class="panel-body">

        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

         <div id="commonMsg"> </div> 
        <div id="delCommonMsg"> </div>  
        <form class="" id="fromParts" enctype="multipart/form-data">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/>  
          <input type="hidden" name="part_id" id="part_id"/> 
          <input type="hidden" name="screen" id="screen"/> 

            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Part Number <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="part_num" id="part_num" onkeyup=""
                     placeholder="Part Number " maxlength="30" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="part_desc" id="part_desc" onkeyup=""
                   placeholder="Part Description" class="form-control" required="true"/>
                </div>
                </div>
              </div>  

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addPartBtn" onclick="tempData.oeeparts.savePart();" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Save 
                    </button>
                    
                    <button type="button" id="updatePart" onclick="tempData.oeeparts.savePart();" class="btn btn-sm btn-success" style="display:none;">
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
          <table id="partsTable" class="table table-bordered table-hover nowarp" style="font-size: 12px;">
           <thead>
             <tr>
              <th>Action</th>
              <th>Part Number</th> 
              <th>Description</th> 
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
