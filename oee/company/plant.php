<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalPlantData=new Array();
var myMap = new Map();
  
tempData.oeeplant=
{
loadPlants:function(){
    debugger;
    var comp_id = $('#comp_id').val();
    var url="getDataController.php";
    var myData={getPlantDetails:"getPlantDetails", "comp_id":comp_id};
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){
                
            globalPlantData=obj.plantDetails;

            if(obj.plantDetails==null){
                  $('#plantTable').DataTable({
                    "paging":false,
                    "ordering":true,
                    "info":true,
                    "searching":false,         
                    "destroy":true,
                }).clear().draw();

              }else{

            var DataTableProject = $('#plantTable').DataTable( {
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false,
                    "destroy":true,
                    "data":obj.plantDetails,   
                    "columns": [
                      { data: "id" ,className: "text-left",
                        render: function (data, type, row, meta) {
                          var c='<button type="button" class="btn btn-success btn-xs" onclick="tempData.oeeplant.gotoWorkcenter('+row.id+',\''+row.comp_id+'\');"><i class="fa fa-check-square-o"></i> View Work Center</button>';
                          var d='<button type="button" class="btn btn-warning btn-xs" onclick="tempData.oeeplant.gotoParts('+row.id+',\''+row.comp_id+'\');"><i class="fa fa-check-square-o"></i> Parts </button>';
                          return c+' '+d;
                        }
                      },
                      { data: "image_file_name" ,className: "text-left",
                          render: function (data, type, row, meta) {
                             if(row.image_file_name != ""){
                                return '<div class="thumb"><img src="../common/img/plants/'+row.image_file_name+'"></div>';
                              }else{
                                return '<div class="thumb"><img src="../common/img/plants/default.png"></div>';
                              }
                          }
                       },
                      { data: "plant_code" },
                      { data: "plant_desc" },
                      { data: "address"},
                      { data: "contact_person" },
                      { data: "contact_number"},
                      { data: "id" ,className: "text-left",
                        render: function (data, type, row, meta) {
                          var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeplant.editPlant('+row.id+',\''+row.comp_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
                           var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeplant.deletePlant('+row.id+',\''+row.image_file_name+'\');"><i class="fa fa-trash"></i> </button>';
                          return a+' '+b;
                        }
                      },
                       ]
                     }); 
            
            } // else End here 

            } // ajax success ends
        });  

    },

    editPlant:function (id, comp_id){
        for(var i=0;i<globalPlantData.length;i++){
            if(id==globalPlantData[i].id){
              $("#showImg").show();

              $('#plant_id').val(globalPlantData[i].id);
              $('#plant_code').val(globalPlantData[i].plant_code);
              $('#plant_desc').val(globalPlantData[i].plant_desc);
              $('#address').val(globalPlantData[i].address);
              $('#contact_person').val(globalPlantData[i].contact_person);
              $('#contact_number').val(globalPlantData[i].contact_number);
              $('#comp_id').val(globalPlantData[i].comp_id);
              $('#img_id').val(globalPlantData[i].image_file_name);
              if(globalPlantData[i].image_file_name!=''){
                $('#showImg').html('<img style="width: 30%;" src="../common/img/plants/'+globalPlantData[i].image_file_name+'">');
              }else{
                $('#showImg').html('<img style="width: 30%;" src="../common/img/plants/default.png">');
              }
              $('#plant_code').prop('readonly', true);
              break;
            }
        }
        $("#fromPlant").fadeIn("fast");
        $("#addPlant").hide();
        $("#updatePlant").show();            
    },

 savePlant:function(){
    	  var url="getDataController.php";
    	  var fromPlantData = new FormData($('#fromPlant')[0]);
    	  fromPlantData.append("savePlant", "savePlant");
    	  var plant_code=$('#plant_code').val();
    	    if(plant_code == "") {
    	        $('#plant_code').css('border-color', 'red');
    	        return false;
    	    }else{
    	      $('#plant_code').css('border-color', '');
    	  $.ajax({
    	    type:"POST",
    	    url:url,
    	    async: false,
    	    dataType: 'json',
    	    cache: false,
    	    processData: false,
    	    contentType: false,
    	    data:fromPlantData,
    	    success: function(obj) {
    	        debugger;
    	      if(obj.data !=null){
    	        if(obj.data.infoRes=='S'){
    	           $("#commonMsg").show();
    	           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
    	           tempData.oeeplant.loadPlants();
    	           tempData.oeeplant.clearForm();

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
clearForm:function(){
	$("#fromPlant").fadeToggle("slow");
    $("#showImg").hide();
    $("#size").html('');
    $("#addPlant").show();
    $("#updatePlant").hide();
    $('#plant_code').prop('readonly', false);
    $('#fromPlant')[0].reset();
},
  deletePlant:function (id,img){
	  //alert(img);
	  var url="getDataController.php";
	  var plant_id=id;
	  var myData={deletePlant:"deletePlant",plant_id:plant_id,img:img};

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
	           tempData.oeeplant.loadPlants();

	        }else{
	          $("#delCommonMsg").show();
	           $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
	        }  
	      } 

	      setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);

	    }
	  });
},
	
gotoWorkcenter:function(plantId, compId){
  window.location="workcenter.php?comp_id="+compId+"&plant_id="+plantId;
},
gotoParts:function(plantId, compId){
	  window.location="../partsandtools/parts.php?comp_id="+compId+"&plant_id="+plantId+"&screen=c";
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
	    fSize = sizeinbytes; i=0;while(fSize>900){fSize/=1024;i++;}
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
	        //alert(obj.compDetails);
	        $('#compName').html(obj.compDetails[0].comp_desc);
	        //alert(obj.compDetails.comp_desc);
	      } 
	    }
	  });
}

};


$(document).ready(function() {
    debugger;
   $("#menuCompany").parent().addClass('active');
   $("#menuCompany").parent().parent().closest('.treeview').addClass('active menu-open');

    $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
    $('.select2').select2();
    $("#fromPlant").hide();
    $('#commonMsg').hide();
    $("#showImg").hide();
      $('#createPlant').click(function(){
    	  tempData.oeeplant.clearForm();
      });
      $('#cancel').click(function(){
    	  tempData.oeeplant.clearForm();
        });
      $('#plant_code').keyup(function(){
         this.value = this.value.toUpperCase();
         $('#plant_code').css('border-color', '');
      });
    
      $("#contact_number").keyup(function() {
          $("#contact_number").val(this.value.match(/[0-9]*/));
      });
      
   tempData.oeeplant.getCompanyDesc();   
   tempData.oeeplant.loadPlants();
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
       <div class="col-md-12 col-sm-12 col-xs-12 pull-left headerTitle">
        <h4 style="margin-top: 3px;"><a id="compName" ></a> <b> / Plants </b></h4>
      </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
          <a href="index.php" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Back </a>
        </div>
        
        <button type="button" onclick="tempData.oeeplant.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>
        
        <button type="button" id="createPlant" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Plant
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

         <div id="delCommonMsg"> </div>  
           <div id="commonMsg"> </div> 
        <form class="" id="fromPlant" enctype="multipart/form-data"> 
            
          <input type="hidden" name="comp_id" id="comp_id"/>
          <input type="hidden" name="img_id" id="img_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/> 
          
          
          
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Code <span class="required">*</span> </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="plant_code" id="plant_code" onkeyup=""
                     placeholder="Plant Code" maxlength="4" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="plant_desc" id="plant_desc" onkeyup=""
                   placeholder="Plant Description" class="form-control" required="true"/>
                </div>
                </div>
              </div>
            
              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Contact Person</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="contact_person" id="contact_person" onkeyup=""
                   placeholder="Contact Person" class="form-control" required="true"/>
                </div>
                </div>

               <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Contact Number</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="contact_number" id="contact_number" onkeyup=""
                   placeholder="Contact Number"  maxlength="10" class="form-control" required="true"/>
                </div>
                </div>

              </div>

              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea class="form-control" placeholder="Address" rows="2" id="address" name="address"></textarea>
                </div>
                </div>
                
                <div class="col-md-6">
                 <label class="control-label col-md-4 col-sm-6 col-xs-12">Upload Image</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       
                   <input type="file" name="image_file_name" id="image_file_name" accept="image/*" class="form-control col-md-12 col-xs-12" 
                    onchange="tempData.oeeplant.AlertFilesizeType(this);" />
                      <span class="pull-right">[ Upload only Image ]  </span>
                      <span id="size" style="color:red;font-size:13px;"></span>
                      <span id="lblError" style="color:red;font-size:13px;"></span>
                    <span id="showImg"></span> 
                     
                    </div>
                </div>
              </div> 

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addPlant" onclick="tempData.oeeplant.savePlant();" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Save
                    </button>
                    <button type="button" id="updatePlant" onclick="tempData.oeeplant.savePlant();"  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update
                    </button>
                    <button type="button" id="cancel"   class="btn btn-sm btn-danger"><i class="fa fa-close"></i>&nbsp; Cancel
                    </button>
                   </div>
              </div>
            </div>  
           <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="plantTable" class="table table-hover table-bordered nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Action</th>
              <th>Plant Image</th>
              <th>Code</th> 
              <th>Description</th>
              <th>Address</th>
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
