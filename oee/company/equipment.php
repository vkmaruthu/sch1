<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalEquipmentData=new Array();
var modelMap = new Map();
var eqTypeMap = new Map();

tempData.oeeEquipment=
{
loadAllEquipment:function(){
debugger;
var comp_id = $('#comp_id').val();
var plant_id = $('#plant_id').val();
var wc_id = $('#wc_id').val();
var url="getDataController.php";
var myData={getEquipmentDetails:"getEquipmentDetails", "wc_id":wc_id, "comp_id":comp_id, "plant_id":plant_id};
   $.ajax({
        type:"POST",
        url:url,
        async: false,
        dataType: 'json',
        data:myData,
        success: function(obj){
            
        globalEquipmentData=obj.equipmentDetails;

        if(obj.equipmentDetails==null){
              $('#equipmentTable').DataTable({
                "paging":false,
                "ordering":true,
                "info":true,
                "searching":false,         
                "destroy":true,
            }).clear().draw();

          }else{

        var DataTableProject = $('#equipmentTable').DataTable( {
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                "destroy":true,
                "data":obj.equipmentDetails,   
                "columns": [
                  { data: "image_file_name" ,className: "text-left",
                      render: function (data, type, row, meta) {
                         if(row.image_file_name != ""){
                            return '<div class="thumb"><img src="../common/img/machine/'+row.image_file_name+'"></div>';
                          }else{
                            return '<div class="thumb"><img src="../common/img/machine/default.png"></div>';
                          }
                      }
                   },
                  { data: "eq_code" },
                  { data: "eq_desc" },
                  { data: "eq_protocol" },
                  { data: "eq_type_id" },
                  { data: "eq_model_id" },
                  { data: "contact_person" },
                  { data: "contact_number"},
                  { data: "id" ,className: "text-left",
                    render: function (data, type, row, meta) {
                      var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeEquipment.editEquipment('+row.id+',\''+row.wc_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
                       var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeEquipment.deleteEquipment('+row.id+',\''+row.image_file_name+'\');"><i class="fa fa-trash"></i> </button>';
                      return a+' '+b;
                    }
                  },
                   ]
                 }); 
        
        } // else End here 

        } // ajax success ends
    });  
},
getCompanyDesc:function(){	
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
},
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
getWCDesc:function(){	
		  var url="getDataController.php";
		  var plant_id=$('#plant_id').val();
		  var comp_id=$('#comp_id').val();
		  var wc_id=$('#wc_id').val();
		  var myData={getWCDetails:"getWCDetails",plant_id:plant_id, comp_id:comp_id, wc_id:wc_id};
		  $.ajax({
		    type:"POST",
		    url:url,
		    async: false,
		    dataType: 'json',
		    data:myData,
		    success: function(obj) {
		      if(obj.wcDetails !=null){
		        $('#wcName').html(obj.wcDetails[0].wc_desc);
		      } 
		    }
	  });
 },

reload:function(){
	   location.reload(true);
},

AlertFilesizeType:function(name){   
	  debugger;
	   var imgPathName = window.URL.createObjectURL(name.files[0]);
	   $('#showImg').show();
	   $('#showImg').html('<img style="width: 30%;" src="'+imgPathName+'">');

	    var sizeinbytes = document.getElementById('image_file_name').files[0].size;
	    var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
	    fSize = sizeinbytes; i=0;
	    while(fSize>900){fSize/=1024;i++;}
	    var size=((Math.round(fSize*100)/100));//+' '+fSExt[i]);
	    if(fSExt[i] =='KB'){
	      $('#size').html("File size :"+size+" "+fSExt[i]+"<b>");
	    }
	    else if(size < 3 && fSExt[i] =='MB'){
	      $('#size').html("<b> File size :"+size+" "+fSExt[i]+"<b>");
	    }
	    else{
	      $('#size').html("<b>File size : "+size+" "+fSExt[i]+" , ( File size must be excately 3 MB )<b>");
	    }
	      
	    var allowedFiles = [".jpg", ".jpeg", ".png"];
	    var fileUpload = document.getElementById("image_file_name");
	    var lblError = document.getElementById("lblError");
	    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
	    if (!regex.test(fileUpload.value.toLowerCase())) {
	        lblError.innerHTML = "Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.";
	        return false;
	    }else{
	      lblError.innerHTML = "";
	      return true;
	    }
},

deleteEquipment:function (id,img){
	  //alert(img);
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

saveEquipment:function(){
	  var url="getDataController.php";
	  var formEQData = new FormData($('#fromEquipment')[0]);
	  formEQData.append("saveEquipment", "saveEquipment");
	  var eq_code=$('#eq_code').val();
	    if(eq_code == "") {
	        $('#eq_code').css('border-color', 'red');
	        return false;
	    }else{
	      $('#eq_code').css('border-color', '');
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
	           $("#addEquipmentuipment").show();
	           $("#updateEquipmentuipment").hide();
	           $('#eq_code').prop('readonly', false);
	           $('#fromEquipment')[0].reset();
	           
	           tempData.oeeEquipment.loadAllEquipment();

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
gotoBack:function(){
	 var comp_id = $('#comp_id').val();
	 var plant_id = $('#plant_id').val();
	 window.location="plant.php?comp_id="+comp_id+"&plant_id="+plant_id;
},
editEquipment:function (id){
   for(var i=0;i<globalEquipmentData.length;i++){ 
       if(id==globalEquipmentData[i].id){
         $("#showImg").show();
         $('#eq_id').val(globalEquipmentData[i].id);
         $('#eq_code').val(globalEquipmentData[i].eq_code);
         $('#eq_desc').val(globalEquipmentData[i].eq_desc);
         $('#eq_protocol').val(globalEquipmentData[i].eq_protocol);
         
         $('#eq_type_id').val(globalEquipmentData[i].eq_type_id);
         $('#eq_model_id').val(globalEquipmentData[i].eq_model_id);
         
         $('#contact_person').val(globalEquipmentData[i].contact_person);
         $('#contact_number').val(globalEquipmentData[i].contact_number);
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
   $("#addEquipmentuipment").hide();
   $("#updateEquipmentuipment").show();            
}

};

$(document).ready(function() {
debugger;

  $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
  $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
  $('#wc_id').val(<?php echo $_GET['wc_id'];?>);
  
  $('.select2').select2();
  $("#fromEquipment").hide();
  $('#commonMsg').hide();
  $("#showImg").hide();
    $('#createEquipment').click(function(){
      $("#fromEquipment").fadeToggle("slow");
        $('#eq_code').prop('readonly', false);
        $('#fromEquipment')[0].reset();
        $("#showImg").hide();
        $("#size").html('');
        $("#addEquipmentuipment").show();
        $("#updateEquipmentuipment").hide();
    });
  
    $('#eq_code').keyup(function(){
       this.value = this.value.toUpperCase();
       $('#eq_code').css('border-color', '');
    });
  
    $("#contact_number").keyup(function() {
        $("#contact_number").val(this.value.match(/[0-9]*/));
    });

    tempData.oeeEquipment.getCompanyDesc();
    tempData.oeeEquipment.loadAllEquipment();
    tempData.oeeEquipment.getPlantDesc();
    tempData.oeeEquipment.getWCDesc();
  
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
         <h4 style="margin-top: 3px;"><spam id="compName" ></spam>/ <spam id="plantName" ></spam>/ <spam id="wcName" ></spam><b> / Equipment </b></h4>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
            <a onclick="tempData.oeeEquipment.gotoBack();" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Back </a>
        </div>
        <button type="button" id="createEquipment" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Create Equipment
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <div id="delCommonMsg"> </div>  
        
        <form class="" id="fromEquipment" enctype="multipart/form-data"> 
            
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="img_id" id="img_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/>
          <input type="hidden" name="wc_id" id="wc_id"/>
          
            <div id="commonMsg"> </div>
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Code</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="eq_code" id="eq_code" onkeyup=""
                     placeholder="Equipment Code" maxlength="4" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="eq_desc" id="eq_desc" onkeyup=""
                   placeholder="Equipment Description" class="form-control" required="true"/>
                </div>
                </div>
              </div>
              
              <div class="row" style="margin-top: 10px;">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Equipment Type</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="eq_type" style="width: 100%;">
                          <option selected="selected">Select Equipment Type</option>
                           <option value="1">Productive</option>
                        </select>
                      </div>
                    </div>
                </div>

               <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Model</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="model" style="width: 100%;">
                           <option selected="selected">
                             Select Model
                           </option>
                           <option value="1">Productive</option>
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                    <label class="control-label col-md-4 col-sm-6 col-xs-12">Protocol</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="eq_protocol" id="eq_protocol" onkeyup=""
                       placeholder="Equipment Protocol" class="form-control" required="true"/>
                    </div>
                </div>

              <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Logo Upload</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">    
                   <input type="file" name="image_file_name" id="image_file_name" accept="image/*" class="form-control col-md-12 col-xs-12" 
                    onchange="tempData.oeeEquipment.AlertFilesizeType(this);" />
                      <span class="pull-right">[ Upload only Image ]  </span>
                      <span id="size" style="color:red;font-size:13px;"></span>
                      <span id="lblError" style="color:red;font-size:13px;"></span>
                    <span id="showImg"></span> 
                   </div>
                </div>

              </div>

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addEquipment" onclick="tempData.oeeEquipment.saveEquipment()" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Equipment
                    </button>
                    <button type="button" id="updateEquipment" onclick="tempData.oeeEquipment.saveEquipment()"  class="btn btn-sm btn-success" style="display:none;">
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
              <th>Image</th>
              <th>Code</th> 
              <th>Descreption</th>
              <th>Protocol</th>
              <th>Equipment Type</th>
              <th>Model</th>
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
