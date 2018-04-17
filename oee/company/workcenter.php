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
 loadAllWC:function(){
        debugger;
        var comp_id = $('#comp_id').val();
        var plant_id = $('#plant_id').val();
        var url="getDataController.php";
        var myData={getWCDetails:"getWCDetails", "comp_id":comp_id, "plant_id":plant_id};
           $.ajax({
                type:"POST",
                url:url,
                async: false,
                dataType: 'json',
                data:myData,
                success: function(obj){
                    
                globalWCData=obj.wcDetails;

                if(obj.wcDetails==null){
                      $('#wcTable').DataTable({
                        "paging":false,
                        "ordering":true,
                        "info":true,
                        "searching":false,         
                        "destroy":true,
                    }).clear().draw();

                  }else{

                var DataTableProject = $('#wcTable').DataTable( {
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : true,
                        'info'        : true,
                        'autoWidth'   : false,
                        "destroy":true,
                        "data":obj.wcDetails,   
                        "columns": [
                          { data: "id" ,className: "text-left",
                            render: function (data, type, row, meta) {
                              var c='<button type="button" class="btn btn-success btn-xs" onclick="tempData.oeewc.gotoEquipment('+row.id+',\''+row.plant_id+'\',\''+comp_id+'\');"><i class="fa fa-check-square-o"></i> View Equipment</button>';
                              return c;
                            }
                          },
                          { data: "image_file_name" ,className: "text-left",
                              render: function (data, type, row, meta) {
                                 if(row.image_file_name != ""){
                                    return '<div class="thumb"><img src="../common/img/workcenter/'+row.image_file_name+'"></div>';
                                  }else{
                                    return '<div class="thumb"><img src="../common/img/workcenter/default.png"></div>';
                                  }
                              }
                           },
                          { data: "wc_code" },
                          { data: "wc_desc" },
                          { data: "contact_person" },
                          { data: "contact_number"},
                          { data: "id" ,className: "text-left",
                            render: function (data, type, row, meta) {
                              var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeewc.editWC('+row.id+',\''+row.plant_id+'\',\''+comp_id+'\');"><i class="fa fa-pencil-square-o"></i> </button>';
                               var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeewc.deleteWC('+row.id+',\''+row.image_file_name+'\');"><i class="fa fa-trash"></i> </button>';
                              return a+' '+b;
                            }
                          },
                           ]
                         }); 
                
                } // else End here 

                } // ajax success ends
            });  

        },

        
  gotoEquipment:function(id, plantId, compId){
	  window.location="equipment.php?comp_id="+compId+"&plant_id="+plantId+"&wc_id="+id;
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

deleteWC:function (id,img){
	  //alert(img);
	  var url="getDataController.php";
	  var wc_id=id;
	  var myData={deleteWC:"deleteWC",wc_id:wc_id,img:img};
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
	           
	           tempData.oeewc.loadAllWC();

	        }else{
	          $("#delCommonMsg").show();
	           $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
	        }  
	      } 
	      setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);

	    }
	  });
},

saveWC:function(){
	  var url="getDataController.php";
	  var fromWCData = new FormData($('#fromWC')[0]);
	  fromWCData.append("saveWC", "saveWC");
	  var wc_code=$('#wc_code').val();
	    if(wc_code == "") {
	        $('#wc_code').css('border-color', 'red');
	        return false;
	    }else{
	      $('#wc_code').css('border-color', '');
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    processData: false,
	    contentType: false,
	    data:fromWCData,
	    success: function(obj) {
	        debugger;
	      if(obj.data !=null){
	        if(obj.data.infoRes=='S'){
	           $("#commonMsg").show();
	           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
	           $("#showImg").hide();
	         
	           $("#size").html('');
	           $("#addWC").show();
	           $("#updateWC").hide();
	           $('#wc_code').prop('readonly', false);
	           $('#fromWC')[0].reset();
	           
	           tempData.oeewc.loadAllWC();

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
	 var id = $('#comp_id').val();
	 window.location="plant.php?comp_id="+id;
},

editWC:function (id, plant_id, comp_id){
    for(var i=0;i<globalWCData.length;i++){
        
        if(id==globalWCData[i].id){
          $("#showImg").show();
          $('#wc_id').val(globalWCData[i].id);
          $('#wc_code').val(globalWCData[i].wc_code);
          $('#wc_desc').val(globalWCData[i].wc_desc);
          $('#contact_person').val(globalWCData[i].contact_person);
          $('#contact_number').val(globalWCData[i].contact_number);
          $('#plant_id').val(globalWCData[i].plant_id);
          $('#img_id').val(globalWCData[i].image_file_name);
          if(globalWCData[i].image_file_name!=''){
            $('#showImg').html('<img style="width: 30%;" src="../common/img/workcenter/'+globalWCData[i].image_file_name+'">');
          }else{
            $('#showImg').html('<img style="width: 30%;" src="../common/img/workcenter/default.png">');
          }
          $('#wc_code').prop('readonly', true);
          break;
          
        }
    }
    $("#fromWC").fadeIn("fast");
    $("#addWC").hide();
    $("#updateWC").show();            
}


};

$(document).ready(function() {
debugger;

  $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
  $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
  
  $('.select2').select2();
  $("#fromWC").hide();
  $('#commonMsg').hide();
  $("#showImg").hide();
    $('#createWC').click(function(){
      $("#fromWC").fadeToggle("slow");
        $('#wc_code').prop('readonly', false);
        $('#fromWC')[0].reset();
        $("#showImg").hide();
        $("#size").html('');
        $("#addWC").show();
        $("#updateWC").hide();
    });
  
    $('#wc_code').keyup(function(){
       this.value = this.value.toUpperCase();
       $('#wc_code').css('border-color', '');
    });
  
    $("#contact_number").keyup(function() {
        $("#contact_number").val(this.value.match(/[0-9]*/));
    });

    tempData.oeewc.getCompanyDesc();
    tempData.oeewc.loadAllWC();   
    tempData.oeewc.getPlantDesc();
  
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
             <h4 style="margin-top: 3px;"><a id="compName" ></a> <b>/</b> <a id="plantName" ></a><b> / Work Centers </b></h4>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
           <a onclick="tempData.oeewc.gotoBack();" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Back </a>
        </div>
        
        <button type="button" onclick="tempData.oeewc.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>
        <button type="button" id="createWC" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Work Center
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <div id="delCommonMsg"> </div>  
        <form class="" id="fromWC" enctype="multipart/form-data"> 
            
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="img_id" id="img_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/>
          <input type="hidden" name="wc_id" id="wc_id"/> 
          
            <div id="commonMsg"> </div> 
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Code<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="wc_code" id="wc_code" onkeyup=""
                     placeholder="Work Center Code" maxlength="4" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="wc_desc" id="wc_desc" onkeyup=""
                   placeholder="Work Center Description" class="form-control" required="true"/>
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
                   placeholder="Contact Number" maxlength="10"  class="form-control" required="true"/>
                </div>
                </div>

              </div>

              <div class="row" style="margin-top: 1px;">                 
                  <div class="col-md-6">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Upload Image</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">    
                       <input type="file" name="image_file_name" id="image_file_name" accept="image/*" class="form-control col-md-12 col-xs-12" 
                        onchange="tempData.oeewc.AlertFilesizeType(this);" />
                          <span class="pull-right">[ Upload only Image ]  </span>
                          <span id="size" style="color:red;font-size:13px;"></span>
                          <span id="lblError" style="color:red;font-size:13px;"></span>
                        <span id="showImg"></span> 
                       </div>
                    </div>
              </div> 

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addWC" onclick="tempData.oeewc.saveWC();" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Work Center 
                    </button>
                    <button type="button" id="updateWC" onclick="tempData.oeewc.saveWC();"  class="btn btn-sm btn-success" style="display:none;">
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
              <th>Work Center Image</th>
              <th>Code</th> 
              <th>Descreption</th>
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
