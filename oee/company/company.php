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
loadTable:function(){
    debugger;

    var url="loadData.txt";
       $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            success: function(obj){
            globalCompanyData=obj;
            /*
            for(var i=0;i<obj.length;i++){
              globalCompanyData.push({"id":obj.id,"role_name":obj.role_name,"role_desc":obj.role_desc, "company_name":obj.company_name, 
              "plant_name":obj.plant_name, "screens":obj.screens, "access_mode":obj.access_mode});
            }*/
    var DataTableProject = $('#companyTable').DataTable( {
           "paging":false,
            "ordering":true,
            "info":true,
            "searching":true,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 250,
            "data":obj,   
            "columns": [
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var c='<button type="button" class="btn btn-success btn-xs" onclick="tempData.oeecompany.gotoPlants();"><i class="fa fa-check-square-o"></i> View Plant</button>';
                  return c;
                }
              },
              { data: "role_name" },
              { data: "role_desc" },
              { data: "company_name"},
              { data: "plant_name" },
              { data: "screens"},
              { data: "id" ,className: "text-left",
                render: function (data, type, row, meta) {
                  var a='<button type="button" class="btn btn-primary btn-xs" onclick="tempData.oeecompany.editCompany('+row.id+');"><i class="fa fa-pencil-square-o"></i> </button>';
                   var b='<button type="button" class="btn btn-danger btn-xs" onclick=""><i class="fa fa-trash"></i> </button>';
                  return a+' '+b;
                }
              },
               ]
           } );   
          }
        });  

    },

    editCompany:function (id){
        for(var i=0;i<globalCompanyData.length;i++){
            if(id==globalCompanyData[i].id){
              alert(globalCompanyData[i].id);

              $('#companyCode').val(globalCompanyData[i].role_name);
              $('#companyDesc').val(globalCompanyData[i].role_desc);
              $('#address').val(globalCompanyData[i].screens);
              $('#contactPerson').val(globalCompanyData[i].access_mode);
              $('#contactNumber').val(globalCompanyData[i].screens);
              break;
            }
        }
        $("#fromCompany").fadeIn("fast");
        $("#addCompany").hide();
        $("#updateCompany").show();
           /*   globalCompanyData.push({"id":obj.id,"role_name":obj.role_name,"role_desc":obj.role_desc, "company_name":obj.company_name, 
              "plant_name":obj.plant_name, "screens":obj.screens, "access_mode":obj.access_mode});*/
            
    },


 openPopup:function(){
    $('#moreInfo').modal({show:true});
  },

  gotoPlants:function(){
	  window.location="plant.php";
  }

};

$(document).ready(function() {
debugger;

$('.select2').select2();
  tempData.oeecompany.loadTable();
  $('#createCompany').click(function(){
    $("#fromCompany").fadeToggle("slow");
      $("#addCompany").show();
      $("#updateCompany").hide();
  });
  $("#fromCompany").fadeOut("fast");
  
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
        <button type="button" id="createCompany" class="btn btn-sm btn-primary pull-right" style="margin-top: -3px;margin-bottom: -2px;">
              <i class="fa fa-pencil-square-o"></i>&nbsp; Create Company
        </button>
          <div class="clearfix"></div>
      </div>   
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12"> 
          <div id="status" class="alert alert-success" style="color:green;text-align:center;font-weight:600;display:none;"></div>
          <div id="error" class="alert alert-danger" style="color:white;text-align:center;font-weight:600;display:none;"></div>

        <form class="" id="fromCompany">     
          <input type="hidden" name="comp_id" id="comp_id"/> 
          <input type="hidden" name="plant_id" id="plant_id"/> 
            <div class="form-group">
             <div class="row">
                <div class="col-md-6">
                  <label class="control-label col-md-4 col-sm-6 col-xs-12">Company Code</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="companyCode" id="companyCode" onkeyup=""
                     placeholder="Company Code" maxlength="10" class="form-control" required="true" autofocus/>
                  </div>
                </div>
                
                <div class="col-md-6">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Company Description</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="companyDesc" id="companyDesc" onkeyup=""
                   placeholder="Company Description" class="form-control" required="true"/>
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
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea class="form-control" placeholder="Address" rows="2" id="address" name="address"></textarea>
                </div>
                </div>
                
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
                    <button type="button" id="addCompany" onclick="" 
                      class="btn btn-sm btn-success">
                      <i class="fa fa-floppy-o"></i>&nbsp; Add Company 
                    </button>
                    <button type="button" id="updateCompany" onclick=""  class="btn btn-sm btn-success" style="display:none;">
                      <i class="fa fa-floppy-o"></i>&nbsp; Update Company
                    </button>
                   </div>
              </div>
            </div>  
           <hr class="hr-primary"/>  
          </form>

      <div > 
          <table id="companyTable" class="table table-hover table-bordered table-responsive nowrap" style="font-size: 12px;width:100%;">
           <thead>
             <tr>
              <th>Action</th>
              <th>Comapany Code</th> 
              <th>Company Descreption</th>
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
