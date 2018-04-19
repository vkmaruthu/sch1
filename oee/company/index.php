<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalCompanyData=new Array();
var myMap = new Map();
  
tempData.oeecompany=
{
loadAllComp:function(){
    debugger;

  var url="getDataController.php";
  var myData={getCompDetails:"getCompDetails"};
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj){

            globalCompanyData=obj.compDetails;

        if(obj.compDetails==null){
          $('#companyTable').DataTable({
             "paging":false,
              "ordering":true,
              "info":true,
              "searching":false,         
              "destroy":true,
          }).clear().draw();

        }else{
            /*     "scrollX": true,    "scrollY": 250,*/
    var DataTableProject = $('#companyTable').DataTable( {
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "destroy":true,
            "data":obj.compDetails,   
            "columns": [
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var c='<button type="button" class="btn btn-success btn-xs" onclick="tempData.oeecompany.gotoPlants('+row.id+',\''+row.comp_code+'\',\''+row.comp_desc+'\');"><i class="fa fa-check-square-o"></i> View Plant</button>';
                  return c;
                }
              },
              { data: "image_file_name" ,className: "text-left",
                render: function (data, type, row, meta) {
                   if(row.image_file_name != ""){
                      return '<div class="thumb"><img src="../common/img/comp_logo/'+row.image_file_name+'"></div>';
                    }else{
                      return '<div class="thumb"><img src="../common/img/comp_logo/d/eimsdefault.png"></div>';
                    }
                }
              },
              { data: "comp_code" },
              { data: "comp_desc" },
              { data: "address"},
              { data: "contact_person" },
              { data: "contact_number"},
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeecompany.editCompany('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeecompany.deleteCompany('+row.id+',\''+row.image_file_name+'\');"><i class="fa fa-trash"></i> </button>';
                  return a+' '+b;
                }
              },
               ]
           });

           } // else End here    //image_file_name

          } // ajax success ends
        });    


},
editCompany:function (id){
    for(var i=0;i<globalCompanyData.length;i++){
        if(id==globalCompanyData[i].id){
          //alert(globalCompanyData[i].id);
          $("#showImg").show();

          $('#comp_id').val(globalCompanyData[i].id);
          $('#comp_code').val(globalCompanyData[i].comp_code);
          $('#comp_desc').val(globalCompanyData[i].comp_desc);
          $('#address').val(globalCompanyData[i].address);
          $('#contact_person').val(globalCompanyData[i].contact_person);
          $('#contact_number').val(globalCompanyData[i].contact_number);

          $('#img_id').val(globalCompanyData[i].image_file_name);
          if(globalCompanyData[i].image_file_name!=''){
            $('#showImg').html('<img style="width: 30%;" src="../common/img/comp_logo/'+globalCompanyData[i].image_file_name+'">');
          }else{
            $('#showImg').html('<img style="width: 30%;" src="../common/img/comp_logo/d/eimsdefault.png">');
          }


          $('#comp_code').prop('readonly', true);
          break;

        }
    }
    $("#fromCompany").fadeIn("fast");
    $("#addCompBtn").hide();
    $("#updateCompany").show();            
},
deleteCompany:function (id,img){
  //alert(img);
  var url="getDataController.php";
  var comp_id=id;
  var myData={deleteCompany:"deleteCompany",comp_id:comp_id,img:img};

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
           //$('#fromCompany')[0].reset();
          // $("#showImg").hide();
           //$("#size").html('');
          // $("#addCompBtn").show();
           //$("#updateCompany").hide();
           // location.reload(true);
           tempData.oeecompany.loadAllComp();

        }else{
          $("#delCommonMsg").show();
           $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
        }  
      } 

      setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);

    }
  });

},

saveCompany:function(){
  var url="getDataController.php";
  var fromCompanyData = new FormData($('#fromCompany')[0]);
  fromCompanyData.append("saveCompany", "saveCompany");
  var comp_code=$('#comp_code').val();

    if(comp_code == "") {
        $('#comp_code').css('border-color', 'red');
        return false;
    }else{
      $('#comp_code').css('border-color', '');

  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    data:fromCompanyData,
    success: function(obj) {
        debugger;
        //alert(obj.data.info);
      if(obj.data !=null){
        if(obj.data.infoRes=='S'){
           $("#commonMsg").show();
           $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.data.info+'</p>');
           $('#fromCompany')[0].reset();
           $("#showImg").hide();
           $("#size").html('');
           $("#addCompBtn").show();
           $("#updateCompany").hide();
           $('#comp_code').prop('readonly', false);
           
           tempData.oeecompany.loadAllComp();

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
gotoPlants:function(id, compCode,compDesc){
    window.location="plant.php?comp_id="+id;
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
      
      
}

};

$(document).ready(function() {
debugger;

  $('.select2').select2();  
  $('#commonMsg').hide();
  $("#fromCompany").hide();
  $("#showImg").hide();

  $('#createCompany').click(function(){
      $('#comp_code').prop('readonly', false);
      $('#fromCompany')[0].reset();
      $("#showImg").hide();
      $("#size").html('');
    
      $("#fromCompany").fadeToggle("slow");
      $("#addCompBtn").show();
      $("#updateCompany").hide();
  });

  $('#comp_code').keyup(function(){
     this.value = this.value.toUpperCase();
     $('#comp_code').css('border-color', '');
  });

  $("#contact_number").keyup(function() {
      $("#contact_number").val(this.value.match(/[0-9]*/));
  }); 

    tempData.oeecompany.loadAllComp();
  
});

</script>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">Company<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <div class="panel-title pull-left">
              
        </div>

        <button type="button" onclick="tempData.oeecompany.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>


        <button type="button" id="createCompany" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add Company
        </button>

       


          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">

        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>


        <div id="delCommonMsg"> </div>  
        <form class="" id="fromCompany" enctype="multipart/form-data">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="img_id" id="img_id"/> 
          <!-- <input type="hidden" name="plant_id" id="plant_id"/>  -->

            <div id="commonMsg"> </div>  

            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Company Code <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="comp_code" id="comp_code" onkeyup=""
                     placeholder="Company Code" maxlength="4" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="comp_desc" id="comp_desc" onkeyup=""
                   placeholder="Company Description" class="form-control" required="true"/>
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
                  <input type="text" name="contact_number"  maxlength="10" id="contact_number" onkeyup=""
                   placeholder="Contact Number" class="form-control" required="true"/>
                </div>
                </div>

              </div>

              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea class="form-control" placeholder="address" rows="2" id="address" name="address"></textarea>
                </div>
                </div>
                
                <div class="col-md-6">
                 <label class="control-label col-md-4 col-sm-6 col-xs-12">Logo Upload</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       
                   <input type="file" name="image_file_name" id="image_file_name" accept="image/*" class="form-control col-md-12 col-xs-12" 
                    onchange="tempData.oeecompany.AlertFilesizeType(this);" />
                      <span class="pull-right">[ Upload only Image ]  </span>
                      <span id="size" style="color:red;font-size:13px;"></span>
                      <span id="lblError" style="color:red;font-size:13px;"></span>
                    <span id="showImg"></span> 
                     
                    </div>
                </div>
              </div> 

            

              <div class="row">
                   <div class="col-md-12 text-center">
                    <button type="button" id="addCompBtn" onclick="tempData.oeecompany.saveCompany();" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Save 
                    </button>
                    
                    <button type="button" id="updateCompany" onclick="tempData.oeecompany.saveCompany();" class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update
                    </button>
                   </div>
              </div>
            </div>  
           <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="companyTable" class="table table-bordered table-hover nowarp" style="font-size: 12px;">
           <thead>
             <tr>
              <th>Action</th>
              <th>Comapany Logo</th> 
              <th>Comapany Code</th> 
              <th>Description</th>
              <th>address</th>
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
