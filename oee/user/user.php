<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

var globalUserData=new Array();


tempData.oeeuser={
loadUserTable:function(){
  debugger;
  var url="getDataController.php";
  var comp_id=$('#comp_id').val();

  var myData={userTable:"userTable",comp_id:comp_id};
   $.ajax({
        type:"POST",
        url:url,
        async: false,
        dataType: 'json',
        data:myData,
        success: function(obj){
            
        globalUserData=obj.userDetails;

        if(obj.userDetails==null){
              $('#userTable').DataTable({
                "paging":false,
                "ordering":true,
                "info":true,
                "searching":false,         
                "destroy":true,
            }).clear().draw();

          }else{

var DataTableProject = $('#userTable').DataTable( {
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "destroy":true,
        "data":obj.userDetails,   
        "columns": [
        {data: "is_active" ,className: "text-left",
              render: function (data, type, row, meta) {
                if(row.is_active==1){
                  var a='<span style="color: green;font-size: 15px;font-weight: bold;">Active</span>';
                }else{
                  var a='<span style="color: red; font-size: 15px; font-weight: bold;">Inactive</span>';
                }
                return a;
              }
          },
         {data: "img_file_name" ,className: "text-left",
              render: function (data, type, row, meta) {
                 if(row.img_file_name != ""){
                    return '<div class="thumb"><img src="../common/img/user_img/'+row.img_file_name+'"></div>';
                  }else{
                    return '<div class="thumb"><img src="../common/img/user_img/default.png"></div>';
                  }
              }
          },
          { data: "first_name" },
          { data: "email_id" },
          { data: "contact_number"},
          { data: "roleName",
            render: function (data, type, row, meta) {
              return '<span style="color:blue;font-weight:600;">'+row.roleName+'</span>';
            }
          },
          { data: "compName",
             render: function (data, type, row, meta) {
              return '<span style="">'+row.compName+'</span><br><span style="margin-top:-8px;">'+row.plantName+'</span>';
            }
          },
          { data: "id" ,className: "text-left",
              render: function (data, type, row, meta) {
                var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeeuser.editUsers('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                 var b='<button type="button" class="btn btn-danger btn-xs" onclick="tempData.oeeuser.deleteUsers('+row.id+');"><i class="fa fa-trash"></i> </button>';

                if(row.is_active==1){
                  var btn='<button type="button" title="Deactive User" class="btn btn-danger btn-xs" onclick="tempData.oeeuser.deactiveUser('+row.id+');"><i class="glyphicon glyphicon-remove"></i> </button>';
                }else{
                  var btn='<button type="button" title="Àctive User" class="btn btn-success btn-xs" onclick="tempData.oeeuser.activeUser('+row.id+');"><i class="glyphicon glyphicon-ok"></i> </button>';
                }
                return btn+' '+a+' '+b;

                return btn+' '+a+' '+b;
              }
          },
           ]
         }); 
        
        } // else End here 

        } // ajax success ends
    });  
},
deactiveUser:function(id){
   var url="getDataController.php";
    var record_id=id;
    var myData={deactiveUser:"deactiveUser",record_id:record_id};
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
             $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="glyphicon glyphicon-remove"></i> '+obj.data.info+'</p>');             
               tempData.oeeuser.loadUserTable();
          }else{
            $("#delCommonMsg").show();
             $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
          }  
        } 
        setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);
      }
    });
},
activeUser:function(id){
  var url="getDataController.php";
    var record_id=id;
    var myData={activeUser:"activeUser",record_id:record_id};
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
             $('#delCommonMsg').html('<p class="commonMsgSuccess"> <i class="glyphicon glyphicon-ok"></i> '+obj.data.info+'</p>');             
               tempData.oeeuser.loadUserTable();
          }else{
            $("#delCommonMsg").show();
             $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
          }  
        } 
        setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);

      }
    });
},
reload:function(){
     location.reload(true);
},
deleteUsers:function(id){
    var url="getDataController.php";
    var record_id=id;
    var myData={deleteUser:"deleteUser",record_id:record_id};
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
               tempData.oeeuser.loadUserTable();
          }else{
            $("#delCommonMsg").show();
             $('#delCommonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.data.info+'</p>');
          }  
        } 
        setTimeout(function(){  $("#delCommonMsg").fadeToggle('slow'); }, 1500);

      }
    });
},
saveUsers:function(){
  debugger;
    var url="getDataController.php";
    var formEQData = new FormData($('#formUser')[0]);
    formEQData.append("saveUser", "saveUser");

    var firstName=$('#firstName').val();
    var emailId = $('#emailId').val();
    var password = $('#password').val();
    var companyName = $('#companyName').val();
    var userRole = $('#userRole').val();
    
      if(firstName == "") {
          $('#firstName').css('border-color', 'red');
          return false;
      }else{
          $('#firstName').css('border-color', '');
        
          if(emailId == ""){
           $('#emailId').css('border-color', 'red');
             return false;
          }else {
            $('#emailId').css('border-color', '');
          }

          if(password == ""){
           $('#password').css('border-color', 'red');
             return false;
          }else {
            $('#password').css('border-color', '');
          }

          if(companyName == 0){
            $('#msg').html('*Select Company');
            return false;
          }else {
            $('#msg').html('');
          }

          if(userRole == 0){
            $('#msg').html('*Select User Role');
            return false;
          }else {
            $('#msg').html('');
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
        if(obj.userData !=null){
          if(obj.userData.infoRes=='S'){
             $("#commonMsg").show();
             $('#commonMsg').html('<p class="commonMsgSuccess"> <i class="fa fa-check"></i> '+obj.userData.info+'</p>');
      
              tempData.oeeuser.clearForm();
              tempData.oeeuser.loadUserTable();

          }else{
            $("#commonMsg").show();
             $('#commonMsg').html('<p class="commonMsgFail"> <i class="fa fa-warning"></i> '+obj.userData.info+'</p>');
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
   $('#formUser')[0].reset();
   $("#addUser").show();
   $("#updateUser").hide(); 
   $("#formUser").fadeToggle("slow");
   $('#showImg').hide();
},
editUsers:function(id){
  debugger;
$('#showImg').show();
   $("#email_status").hide(); 
   $('#formUser')[0].reset();
   for(var i=0;i<globalUserData.length;i++){ 
       if(id==globalUserData[i].id){        
         $("#showImg").show();
         $('#record_id').val(globalUserData[i].id);
         $('#firstName').val(globalUserData[i].first_name);
         $('#lastName').val(globalUserData[i].last_name);
         $('#emailId').val(globalUserData[i].email_id);
         
         $('#password').val(globalUserData[i].password);
         $('#contactNumber').val(globalUserData[i].contact_number);         
         
         $('#companyName').val(globalUserData[i].compId).change();
         $('#userRole').val(globalUserData[i].roleId).change();
        $('#img_id').val(globalUserData[i].img_file_name);
         if(globalUserData[i].img_file_name!=''){
           $('#showImg').html('<img style="width: 30%;" src="../common/img/user_img/'+globalUserData[i].img_file_name+'">');
         }else{
           $('#showImg').html('<img style="width: 30%;" src="../common/img/user_img/default.png">');
         }
         $('#emailId').prop('readonly', true);
         break;        
       }
   }
   $("#formUser").fadeIn("fast");
   $("#addUser").hide();
   $("#updateUser").show();            
},
loadAllRoles:function(){
    var url="getDataController.php";
    var myData = {loadAllRoles:'loadAllRoles'};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        if(obj.screenDetails !=null){
           $("#screens").html('');
            for(var i=0; i< obj.screenDetails.length; i++){
             $("#screens").append('<option value="'+obj.screenDetails[i].id+'">'+obj.screenDetails[i].screenName+'</option>'); 
            }
          }
        } 
    });
},
getCompanyForDropdown:function(){//reasonsArray
  var url="getDataController.php";
  var myData = {getCompDetails:'getCompDetails'};
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    cache: false,
    data:myData,
    success: function(obj) {
        debugger;
        if(obj.compDetails !=null){
          companyArray = obj.compDetails;
          $("#userRole").html('');
          $("#userRole").append('<option value="0"> Select Role </option>');

          $("#companyName").html('');
          $("#companyName").append('<option value="0"> Select Company </option>');
            if(companyArray != null){
              for(var i=0; i< companyArray.length; i++){
               $("#companyName").append('<option value="'+companyArray[i].id+'">'+companyArray[i].comp_desc+'</option>'); 
              }
            }
        }
      } 
  });
},  
getUserRoleDropdown:function(){//reasonsArray
  var url="getDataController.php";
  var comp_id=$('#companyName').val();
  var myData = {getUserRoleDropdown:'getUserRoleDropdown',comp_id:comp_id};
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    cache: false,
    data:myData,
    success: function(obj) {
        debugger;
        if(obj.roleDetails !=null){
          $("#userRole").html('');
          $("#userRole").append('<option value="0"> Select Role </option>');
            if(obj.roleDetails != null){
              for(var i=0; i< obj.roleDetails.length; i++){
               $("#userRole").append('<option value="'+obj.roleDetails[i].id+'">'+obj.roleDetails[i].roleName+'</option>'); 
              }
            }
        }else{
          $("#userRole").html('');
          $("#userRole").append('<option value="0"> Select Role </option>');
        }
      } 
  });
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
checkValidEmail:function(){
  debugger;
  var url="getDataController.php";
  var emailId=$('#emailId').val();
  var resEmail = tempData.oeeuser.validateEmail(emailId);
  var res=null;

  if(emailId != ''){
      if(resEmail==1){
        res = tempData.oeeuser.checkValue(emailId,globalUserData);
          $("#email_status").show(); 
          $('#msg').html('');
          if(res==1){
            $('#email_status').html('<img src="../common/img/delete.png" style="width: 22px;">');
            $("#addUser").prop('disabled', true);
            $('#msg').html('*Email Id Already exists.');
          }else{
            $('#email_status').html('<img src="../common/img/confirm.png" style="width: 22px;">');
            $("#addUser").prop('disabled', false);
            $('#msg').html('');
          }
      }else{
        $('#msg').html('*Please Enter valid Email Id.');
        $('#email_status').hide();
        $("#addUser").prop('disabled', true);
        return false;
      }     
    }else{
        $("#email_status").hide(); 
    }
},
checkValue:function(value,arr){
  debugger;
  var status = 0;
  for(var i=0; i<arr.length; i++){
   var name = arr[i].email_id;
   if(name == value){
    status = 1;
    break;
   }
  }
  return status;
},
validateEmail:function(x) {
    //var x = document.forms["myForm"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    var status=1;
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        //alert("Not a valid e-mail address");
        status=0;
        return status;
    }else{
      return status;
    }
}

};

$(document).ready(function() {
debugger;
 //$('#comp_id').val(<?php echo $_GET['comp_id']; ?>);

 $("#menuUsers").parent().addClass('active');
 $("#menuUsers").parent().parent().closest('.treeview').addClass('active menu-open');

  $('#commonMsg').hide();
  $('.select2').select2();
  $("#formUser").fadeOut("fast");
  $("#userRole").prop("disabled", true);

  $('#createUser').click(function(){
    $('#formUser')[0].reset();
    $("#formUser").fadeToggle("slow");
    $('#emailId').prop('readonly', false);
    $('#showImg').hide();
  });

  $('#companyName').change(function(){
     if($('#companyName').val() != 0){
        tempData.oeeuser.getUserRoleDropdown();
        $("#userRole").prop("disabled", false); 
     }else{
       $("#userRole").html('');
       $("#userRole").append('<option value="0"> Select Role </option>');
       $("#userRole").prop("disabled", true); 
     }
  });  

  tempData.oeeuser.loadUserTable();
  tempData.oeeuser.getCompanyForDropdown();

});

</script>
<input type="hidden" name="comp_id" id="comp_id" />

  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">User Configuration<h3>
        </div>
      </div>

    <div class="panel panel-default">
      <div class="panel-heading "> 
        <button type="button" onclick="tempData.oeeuser.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button>

        <button type="button" id="createUser" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Add User
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
        
        <div id="delCommonMsg"> </div> 
        <div id="commonMsg"> </div> 

        <form class="" id="formUser" enctype="multipart/form-data">    
            <input type="hidden" name="record_id" id="record_id"/>  
            <input type="hidden" name="img_id" id="img_id"/>             

            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">First Name</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="firstName" id="firstName" onkeyup=""
                     placeholder="First Name" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Last Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="lastName" id="lastName" onkeyup=""
                   placeholder="Last Name" class="form-control" required="true"/>
                </div>
                </div>
              </div>
            
              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Email Id</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="email" name="emailId" id="emailId" onkeyup="tempData.oeeuser.checkValidEmail();"
                   placeholder="Email Id" class="form-control" required="true"/>
                   <div class="emailConfirm" id="email_status"></div>
                </div>
                </div>

               <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" name="password" id="password" onkeyup=""
                   placeholder="Password" class="form-control" required="true"/>
                </div>
                </div>
              </div>

              <div class="row" style="margin-top: 1px;">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Contact Number</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="contactNumber" id="contactNumber" onkeyup=""
                     placeholder="Contact Number" class="form-control" required="true"/>
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Company Name</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="form-control select2" style="width: 100%;" id="companyName" name="companyName">
                      </select>
                    </div>
                  </div>
                </div>   
              </div>

              <div class="row" style="margin-top: 1px;">                
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">User Role</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="form-control select2" style="width: 100%;" id="userRole" name="userRole">
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Image Upload</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">    
                   <input type="file" name="img_file_name" id="img_file_name" accept="image/*" class="form-control col-md-12 col-xs-12" onchange="tempData.oeeuser.AlertFilesizeType(this);" />
                      <span class="pull-right">[ Upload only Image ]  </span>
                      <span id="size" style="color:red;font-size:13px;"></span>
                      <span id="lblError" style="color:red;font-size:13px;"></span>
                    <span id="showImg"></span> 
                   </div>
                </div>

              </div> 



              <div class="row">
                <div id="msg" style="padding-left: 28px;color: red;"></div>
                   <div class="col-md-12 text-center">
                    <button type="button" id="addUser" onclick="tempData.oeeuser.saveUsers();" 
                      class="btn btn-sm btn-success"> <i class="fa fa-floppy-o"></i>&nbsp; Save 
                    </button>
                    <button type="button" id="updateUser" onclick="tempData.oeeuser.saveUsers();"  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update
                    </button>
                      <button type="button" id="cancelRole" onclick="tempData.oeeuser.clearForm();"  class="btn btn-sm btn-danger"> <i class="glyphicon glyphicon-remove"></i>&nbsp; Cancel
                      </button>                    
                   </div>
              </div>
            </div>  
 <hr class="hr-primary"/>  
          </form>

      <div class="table-responsive"> 
          <table id="userTable" class="table table-hover table-bordered nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>status</th>
              <th>User Image</th>
              <th>User Name</th>
              <th>Email ID</th>
              <th>Contact Number</th>
              <th>Role</th> 
              <th>Company</th> 
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
