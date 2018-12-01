<?php 
error_reporting(0);
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" xmlns:epub="http://www.idpf.org/2007/ops">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="../common/img/favicon-32x32.png">

<?php //include('../common/header.php'); ?>
<?php //include('../common/sidebar.php'); ?>
<?php include('../common/commonCSS.php');?>
<?php include('../common/commonJS.php');?>
  
<?php require_once('../common/commonVariables.php'); ?>

<?php error_reporting(0); ?>

<script type="text/javascript" src="../common/js/jquery.qrcode.min.js"></script>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}
tempData.jobcard=
{
loadAllJobPO:function(){
  debugger;
  var plantId = $('#plant_id').val();
  var customer_code="<?php echo $_GET['code']; ?>";
  var requireDate="<?php echo $_GET['date']; ?>";
  var size_fg=<?php echo $_GET['fg']; ?>;

  var url="getDataController.php";
  var myData={getJobPoDetails:"getJobPoDetails", plant_id:plantId,customer_code:customer_code,requireDate:requireDate,size_fg:size_fg};
       $.ajax({
          type:"POST",
          url:url,
          async: false,
          dataType: 'json',
          data:myData,
          success: function(obj){           
              var content="";
              $('#qrContent').html('');
            debugger;
            if(obj.jobPoDetails != null){
              //alert(obj.jobPoDetails.length);
              var i=0;
              var nextPage='';

      for(var i=0;i<obj.jobPoDetails.length;i++){
                var elText=null;
                var contentVar="qrcode"+"_"+i;
                var u=null;
                var s=null;
                var t=null;
      if(i<(obj.jobPoDetails.length - 1)){  
        nextPage='<p class="hidden-md hidden-lg" style="page-break-before: always;"></p>';
      }else{
        nextPage=''
      }

                
      if(obj.jobPoDetails[i].urgent==0){
        u='Regular';
      }else{
        u="Urgent"
      }   

      if(obj.jobPoDetails[i].silicon==0){
        s='Not Siliconize';
      }else{
        s="Siliconize"
      }  

      if(obj.jobPoDetails[i].truepass==0){
        t='Not Truepass';
      }else{
        t="Truepass"
      }       

elText=obj.jobPoDetails[i].customer_code+':'+obj.jobPoDetails[i].order_number+':'+obj.jobPoDetails[i].requireDate+':'+obj.jobPoDetails[i].target_qty+':'+obj.jobPoDetails[i].plan+':'+u+':'+s+':'+t+':'+obj.jobPoDetails[i].remarks;

//elText="CUSTOMER:13436512_11_22:DDMMYYYY:26156827662:2100:PLAN_3234:Y:Y:REMARKS_278173847277";
var str=obj.jobPoDetails[i].order_number;
var res=str.split("_");


      content='<div class="col-md-2 col-xs-12 jobCard jobCardMd"><div class="row">'+
      '<div class="col-md-6 col-xs-6" id="'+contentVar+'" style="margin-top: 4%;"></div>'+
      '<div class="col-md-6 col-xs-6" id="" style="margin-top: 4%;"><p class="text">'+u+'</p>'+
      '<p class="subtext"><b>'+s+'</b></p><p class="subtext"><b>'+t+'</b></p></div>'+
      '<div class="col-md-12 col-xs-12 sunContent" style="margin-top: 4%;">'+
      '<p class="sizeCss">Size: '+obj.jobPoDetails[i].material_code+'</p>'+
      '<p>Customer: '+obj.jobPoDetails[i].customer_code+'</p>'+
      '<p>Required Date: '+tempData.jobcard.getDateFormate(obj.jobPoDetails[i].requireDate)+'</p>'+
      '<p>Plan: '+obj.jobPoDetails[i].plan+'</p>'+
      '<p>B.C. No: '+res[0]+'</p>'+
      '<p>S.C. No: '+res[1]+' / '+res[2]+'</p>'+
      '<p>ST. Qty: '+obj.jobPoDetails[i].target_qty+'</p>'+
      '<p>Remarks: '+obj.jobPoDetails[i].remarks+'</p>'+
      '</div></div></div><span class="hidden-md hidden-lg row"></span>'+nextPage;             
      $('#qrContent').append(content);

      $('#'+contentVar).qrcode(elText);   

             }
              
            }
          } // ajax success ends
        });   

  },
reload:function(){
	   location.reload(true);
},
clearForm:function(){
    $('#reason_type_id').val(0).change();  
    $("#fromJobCard").fadeToggle("slow");
    $('#eq_code').prop('readonly', false);
    $('#fromJobCard')[0].reset();
    $("#addJobCard").show();
    $("#updateReason").hide(); 
    $("#reason_code_no").val('');
    $("#record_id").val('');           
},
getDateFormate:function(date){  // DB formate date and time to dd-mm-yyyy
  var dt=date.split(' ');
  var onlyDate=dt[0].split('-');
  return onlyDate[2]+'-'+onlyDate[1]+'-'+onlyDate[0];
},

};

$(document).ready(function() {
    debugger;

    $("#menuJobCardScreen").parent().addClass('active');
    $("#menuJobCardScreen").parent().parent().closest('.treeview').addClass('active menu-open');

    var setDateFormat="dd/mm/yyyy";
    $('.datepicker-me').datepicker({
        format: setDateFormat,
        autoclose: true
    });

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('.datepicker-me').datepicker('setDate', today);

    $('#comp_id').val(<?php echo $_GET['comp_id'];?>);
    $('#plant_id').val(<?php echo $_GET['plant_id'];?>);
    $('#wc_id').val(<?php echo $_GET['wc_id'];?>);
    $('#color').css('background-color','#b2ba62');
 	
  tempData.jobcard.loadAllJobPO();

});

</script>
<style type="text/css">
canvas{
  width: 110px; 
} 
p{
  margin-left: 3%;
  margin-bottom: 3px;
}
.text{
  font-weight: 900;
  text-transform: uppercase;
  margin-left: 10%;
}
.sizeCss{
  font-weight: 900;
  text-transform: uppercase;
}
.subtext{
  font-size: 10px;
  margin-left: 10%;
}
.sunContent>p{
  font-size: 12px;
}



/* A4 Landscape*/
@page {
    margin-left: 30%;   
}

@media print {
   .jobCard{
      width: 40%;      
    }
}

.jobCardMd{
    border: 1px solid black;
    height: 330px;
    margin-left: 0px;
    margin-bottom: 30px;
    border-radius: 1px;
    box-shadow: 0px 0px 10px 0px #00000052;
  }

    /* Custom, iPhone Retina */ 
    @media only screen and (min-width : 320px) {
      .jobCardMd{      
        margin-left: 0px;
      }

    }
      /* Extra Small Devices, Phones */ 
    @media only screen and (min-width : 480px) {

    }

    /* Small Devices, Tablets */
    @media only screen and (min-width : 768px) {

    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width : 992px) {

    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width : 1200px) {
      .jobCardMd{       
        margin-left: 84px;      
      }
    }


</style>
 
        <input type="hidden" name="comp_id" id="comp_id"/> 
        <input type="hidden" name="plant_id" id="plant_id"/>
        <input type="hidden" name="wc_id" id="wc_id"/>      

  <div class="">
    <!-- Main content -->
    <section class="content">
      <div id="qrContent"></div>
      <!-- <div class="col-md-4 jobCard jobCardMd">
         <div class="col-md-12" id="qrcode" style="margin-top: 4%;"></div>
      </div> 
      <p class="hidden-md hidden-lg" style="page-break-before: always">

      <div class="col-md-4 jobCard jobCardMd">
       <div class="col-md-12" id="qrcode1" style="margin-top: 4%;"></div>
      </div> 

       <p class="hidden-md hidden-lg" style="page-break-before: always">

      <div class="col-md-4 jobCard jobCardMd">
       <div class="col-md-12" id="qrcode2" style="margin-top: 4%;"></div>
      </div> 

      <p class="hidden-md hidden-lg" style="page-break-before: always">

      <div class="col-md-4 jobCard jobCardMd">
       <div class="col-md-12" id="qrcode3" style="margin-top: 4%;"></div>
      </div>  -->
      
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
