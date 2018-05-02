<?php
include '../common/db.php';
include '../common/session.php';
include '../common/header.php';
?>
<title>Configure Shifts</title>
    <link type="text/css" href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link type="text/css" href="https://cdn.datatables.net/scroller/1.4.4/css/scroller.dataTables.min.css" rel="stylesheet">
    <script type="text/javascript" src="../js/moment.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="../js/moment-with-locales.js"></script>

<style type="text/css">



.panel-default>.panel-heading {
  color: #333;
  background-color: #fff;
  border-color: #e4e5e7;
  padding: 0;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.panel-default>.panel-heading a {
  display: block;
  padding: 10px 15px;
   background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(171, 212, 247)),color-stop(100%,rgb(123, 161, 193)));
}

.panel-default>.panel-heading a:hover {
  display: block;
  padding: 10px 15px;
   background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(203, 231, 255)),color-stop(100%,rgb(57, 126, 186))); 
}

.panel-default>.panel-heading a:after {
  content: "";
  position: relative;
  top: 1px;
  display: inline-block;
  font-family: 'Glyphicons Halflings';
  font-style: normal;
  font-weight: 400;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  float: right;
  transition: transform .25s linear;
  -webkit-transition: -webkit-transform .25s linear;
}

.panel-default>.panel-heading a[aria-expanded="false"] {
      background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(255, 255, 255)),color-stop(100%,rgb(184, 204, 216)));  
}

/*.panel-default>.panel-heading a[aria-expanded="true"]:after {
  content: "\2212";
  -webkit-transform: rotate(180deg);
  transform: rotate(180deg);
  margin-top: -2%;
}

.panel-default>.panel-heading a[aria-expanded="false"]:after {
  content: "\002b";
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
  margin-top: -2%;
}*/

.accordion-option {
  width: 100%;
  float: left;
  clear: both;
  margin: 15px 0;
}

.accordion-option .title {
  font-size: 20px;
  font-weight: bold;
  float: left;
  padding: 0;
  margin: 0;
}

.accordion-option .toggle-accordion {
  float: right;
}

.accordion-option .toggle-accordion:before {
  content: "Expand All ";
}

.accordion-option .toggle-accordion.active:before {
  content: "Collapse All";
}

.panel-group .panel-heading+.panel-collapse>.panel-body {
    border: 1px solid rgb(128, 167, 199);
}

</style>

<style type="text/css">
.table{
      box-shadow: 1px 1px 4px 0px black;
}

 .divCommonCss{   
    box-shadow: 0px 0px 7px 0px #101010;
    padding-top: 10px;
    border-radius: 5px;
    padding-bottom: 10px;
}

.panel-title {
    font-size: 14px !important;
}


.col-md-4{
      padding-bottom: 5px;
}

.titleName{
      text-transform: uppercase;
    color: #080808;
}

sub{
      color: black;
    text-transform: lowercase;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{
      font-size: 13px;
}

.headTitle{
    color: #0c0c0c;
    background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgba(255, 255, 255, 0)),color-stop(100%,rgb(222, 224, 222)));
}

.errorText{
      font-size: 13px;
    font-weight: bold;
    color: red;
}

@media (min-width: 992px){
.col-md-4 {
    padding-left: 0px;
}

.col-md-2 {
    padding-left: 0px;
}
}

.alert-success{
  background-color: #b5dca5 !important;
}
.alert-danger{
  background-color: #ef8787 !important;
}

.text-wrap{
      white-space:normal;
  }
.width-500{
    width:200px;
}
.durationTime{
  line-height: 30px;
}


</style>
<script type="text/javascript">
   
var UpcomingGoabalData=null;   
var SpecialGoabalData=null;   
var CurrentGobalData=null;   
var HistoryGoabalData=null;   
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}
 
var totalCountOfHours=null;  
tempData.suppliers=
{
/*loadComp:function(){
   debugger;
      $.ajax({
          type:'POST',
          url:'getSuppliers.php',
          async:false,
          data: "getCompDetails=1221",
          dataType: 'json',
          success: function (obj) {
              debugger;
              $('#comp_id').val(obj.data.id);
              $('#comp_idd').val(obj.data.id);
              $('#compName').html('<span style="color:black;">'+obj.data.comp_desc+"</span>");
          }
        });   
},
getUserInfo:function(){
  debugger;

  var url= "../common/getUserData.php";
  var myData = {getUserData:5532};

$.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    data:myData,
    success: function(obj) {
        debugger;
      $('#comp_id').val(obj.data.comp_id);
      $('#comp_idd').val(obj.data.comp_id);
      $('#plant_id').val(obj.data.plant_id);
      $('#compName').html('<span style="color:black;">'+obj.data.comp_desc+"</span>");           
    }
});

},*/
checkShiftType:function(){
  debugger;
  //var getShiftType=$('#shifts').val();
  var shiftsCount=$('#shiftsCount').val();
  if(shiftsCount==0){
    $("#btnSave").prop('disabled', true);
    $("#warMsg").html("* Please select the shift.");
  }else{
    $("#btnSave").prop('disabled', false);
    $("#warMsg").html("");
  }
  
},
checkShiftTypeE:function(){
  debugger;
  //var getShiftType=$('#shifts').val();
  var shiftsCount=$('#shiftsCountE').val();
  if(shiftsCount==0){
    $("#btnSaveE").prop('disabled', true);
    $("#warMsgE").html("* Please select the shift.");
  }else{
    $("#btnSaveE").prop('disabled', false);
    $("#warMsgE").html("");
  }  
},
checkDateTimeBefore8:function(){
  debugger;
  var startDate = new Date($('#startDateTime').val());
  var today = new Date();
  var selectedDate=startDate.getDate()+'-'+startDate.getMonth()+'-'+startDate.getFullYear();
  var sysDate=today.getDate()+'-'+today.getMonth()+'-'+today.getFullYear();;

   if(selectedDate == sysDate)
      if(today.getHours() > 8) {
        $("#btnSave").prop('disabled', true);
        $("#shiftsCount").prop('disabled', true);
        $("#warMsg").html("* Today After 8 AM, You Can't Create a Shift.");
      }else{
        $("#warMsg").html("");
      }
},
dateCompare:function(){
  debugger;
    var startDate = new Date($('#startDateTime').val());
    var endDate = new Date($('#endtDateTime').val());
    var hours= tempData.suppliers.getTotalHour(startDate,endDate);
    var hoursMin= tempData.suppliers.getDiffHourMin(startDate,endDate);

  if(startDate != null && endDate != null && startDate != "Invalid Date" && endDate != "Invalid Date") {
      if (startDate.getTime() >= endDate.getTime()){    
          $("#warMsg").html("* Start time is greater than the End Time!");
          $("#btnSave").prop('disabled', true);
          //$("#shifts").prop('disabled', true);
          $("#shiftsCount").prop('disabled', true);
          return;
        }else{
            var stDateTime=$('#startDateTime').val().split(' ');
            var onlyDate=stDateTime[0].split('/');
            var dateCheck=onlyDate[2]+'-'+onlyDate[0]+'-'+onlyDate[1];
            
            var UpcomingTotalHours=hours;
            var CurrentTotalHours=hours;
            var SpecialTotalHours=hours;

            /* Check the day and shift not more than 24 */  
          if(UpcomingGoabalData !=null){
            for(var i=0; i<UpcomingGoabalData.length;i++){
              if(dateCheck==UpcomingGoabalData[i].shift_start_date){
                  UpcomingTotalHours +=parseInt(UpcomingGoabalData[i].num_hours);                 
              }
            }
          }

           if(CurrentGobalData !=null){
            for(var i=0; i<CurrentGobalData.length;i++){
              if(dateCheck==CurrentGobalData[i].shift_start_date){
                  CurrentTotalHours +=parseInt(CurrentGobalData[i].num_hours);                 
              }
            }
          }

           if(SpecialGoabalData !=null){
            for(var i=0; i<SpecialGoabalData.length;i++){
              if(dateCheck==SpecialGoabalData[i].shift_start_date){
                  SpecialTotalHours +=parseInt(SpecialGoabalData[i].num_hours);                 
              }
            }
          }

            if(hours>24 || UpcomingTotalHours>24 || CurrentTotalHours>24 || SpecialTotalHours>24 ){
              $('#getHours').html(hoursMin);
              $('#getHoursEdit').html(hoursMin);
              $("#warMsg").html("* Total Hours Per Day Should be <= 24 ");
              $("#btnSave").prop('disabled', true);
            }else{
              $('#getHours').html(hoursMin);
              $('#getHoursEdit').html(hoursMin);
              $("#warMsg").html("");
              $("#btnSave").prop('disabled', false);        
              //$("#shifts").prop('disabled', false);        
              $("#shiftsCount").prop('disabled', false);        
              
              tempData.suppliers.checkShiftType();
              tempData.suppliers.checkDateTimeBefore8();

            }

         
        }
  }
},
longStartTime:function(){
  debugger;
 var mainStartDate = $('#startDateTime').val().split(" ");
 var mainEndDate = $('#endtDateTime').val().split(" ");

if(mainStartDate != ""){
  var longStartTime=mainStartDate[0]+' '+$('#longStartTime').val();
  var longEndTime=mainEndDate[0]+' '+$('#longEndTime').val();

  var startDate = new Date(longStartTime);
  var endDate = new Date(longEndTime);
  var hoursMin= tempData.suppliers.getDiffHourMin(startDate,endDate);
  //var hours= tempData.suppliers.getTotalHour(startDate,endDate);

  if(startDate != null && endDate != null && startDate != "Invalid Date" && endDate != "Invalid Date") {
      if (startDate.getTime() >= endDate.getTime()){    
        $("#warMsgLong").html("* Long Break Start time is greater than the End Time!");
        $('#getlongStartTime').html("00:00");
        $("#btnSave").prop('disabled', true);
        return;
      }else{
        $('#getlongStartTime').html(hoursMin);
        $("#warMsgLong").html("");
        $("#btnSave").prop('disabled', false);     
      }
  }
}else{
  $("#warMsgLong").html("* Please Select IN Date Fisrt.");
}

},
break1StartTime:function(){
  debugger;
 var mainStartDate = $('#startDateTime').val().split(" ");
 var mainEndDate = $('#endtDateTime').val().split(" ");

    if(mainStartDate != ""){
      var break1StartTime=mainStartDate[0]+' '+$('#break1StartTime').val();
      var break1EndTime=mainEndDate[0]+' '+$('#break1EndTime').val();

      var startDate = new Date(break1StartTime);
      var endDate = new Date(break1EndTime);
      var hoursMin= tempData.suppliers.getDiffHourMin(startDate,endDate);
      //var hours= tempData.suppliers.getTotalHour(startDate,endDate);

      if(startDate != null && endDate != null && startDate != "Invalid Date" && endDate != "Invalid Date") {
          if (startDate.getTime() >= endDate.getTime()){    
            $("#warMsgBreak1").html("* Short Break 1 Start time is greater than the End Time!");
            $('#getbreak1StartTime').html("00:00");
            $("#btnSave").prop('disabled', true);
            return;
          }else{
            $('#getbreak1StartTime').html(hoursMin);
            $("#warMsgBreak1").html("");
            $("#btnSave").prop('disabled', false);     
          }
      }
    }else{
      $("#warMsgLong").html("* Please Select IN Date Fisrt.");
    }

},
break2StartTime:function(){
  debugger;
 var mainStartDate = $('#startDateTime').val().split(" ");
 var mainEndDate = $('#endtDateTime').val().split(" ");

    if(mainStartDate != ""){
      var break2StartTime=mainStartDate[0]+' '+$('#break2StartTime').val();
      var break2EndTime=mainEndDate[0]+' '+$('#break2EndTime').val();

      var startDate = new Date(break2StartTime);
      var endDate = new Date(break2EndTime);
      var hoursMin= tempData.suppliers.getDiffHourMin(startDate,endDate);
      //var hours= tempData.suppliers.getTotalHour(startDate,endDate);

      if(startDate != null && endDate != null && startDate != "Invalid Date" && endDate != "Invalid Date") {
          if (startDate.getTime() >= endDate.getTime()){    
            $("#warMsgBreak2").html("* Short Break 2 Start time is greater than the End Time!");
            $('#getbreak2StartTime').html("00:00");
            $("#btnSave").prop('disabled', true);
            return;
          }else{
            $('#getbreak2StartTime').html(hoursMin);
            $("#warMsgBreak2").html("");
            $("#btnSave").prop('disabled', false);     
          }
      }
    }else{
      $("#warMsgLong").html("* Please Select IN Date Fisrt.");
    }

},
checkDupShift:function(){
debugger;
//alert('as');SpecialGoabalData CurrentGobalData
if($('#shifts').is(':checked')) {

    if(SpecialGoabalData!=null){
        var stDateTime=$('#startDateTime').val().split(' ');
        var onlyDate=stDateTime[0].split('/');
        var dateCheck=onlyDate[2]+'-'+onlyDate[0]+'-'+onlyDate[1];
        $("#warMsg").html('');

        $('#endtDateTime').prop('disabled', false);

      if(CurrentGobalData!=null){
        for(var i=0; i<CurrentGobalData.length;i++){
            if(dateCheck==CurrentGobalData[i].shift_start_date){
               $("#warMsg").html("* Selected Date Current Shift Already Created.");
               $('#endtDateTime').prop('disabled', true);
            }else{
               $("#warMsg").html('');
               $('#endtDateTime').prop('disabled', false);
            }
        }
      } 

      if(UpcomingGoabalData!=null){
        for(var i=0; i<UpcomingGoabalData.length;i++){
          if(dateCheck==UpcomingGoabalData[i].shift_start_date){
             $("#warMsg").html("* Selected Date Upcoming Shift Already Created.");
             $('#endtDateTime').prop('disabled', true);
          }else{
             $("#warMsg").html('');
             $('#endtDateTime').prop('disabled', false);
          }
        }
      }  

   

        for(var i=0; i<SpecialGoabalData.length;i++){
          if(dateCheck==SpecialGoabalData[i].shift_start_date){
            var shiftCountNum=(parseInt(SpecialGoabalData[i].shift) + parseInt(1));
            if(shiftCountNum <= 3){        
              //$('#shiftsCount').html('<option value="'+(parseInt(SpecialGoabalData[i].shift) + parseInt(1)) +'">'+(parseInt(SpecialGoabalData[i].shift) + parseInt(1))+'</option><option value="G">General</option>');
              $('#shiftsCount').html('<option value="'+(parseInt(SpecialGoabalData[i].shift) + parseInt(1)) +'">'+(parseInt(SpecialGoabalData[i].shift) + parseInt(1))+'</option>');
              var out_time = new Date(SpecialGoabalData[i].out_time);
              $('#startDateTime').val(tempData.suppliers.getDateTimeFormat(out_time));
            }
            else{
              $("#warMsg").html("* Already 3 Shifts Created On "+ stDateTime[0]);
              $('#fromCreateShift')[0].reset();
            }
          }else{
           // $('#shiftsCount').html('<option value="1">1</option><option value="G">General</option>');
            $('#shiftsCount').html('<option value="1">1</option>');
          }

        }
      }else{        
        //$('#shiftsCount').html('<option value="1">1</option><option value="G">General</option>');
        $('#shiftsCount').html('<option value="1">1</option>');
      }

}else{
$('#endtDateTime').prop('disabled', false);
      if(UpcomingGoabalData!=null){
        var stDateTime=$('#startDateTime').val().split(' ');
        var onlyDate=stDateTime[0].split('/');
        var dateCheck=onlyDate[2]+'-'+onlyDate[0]+'-'+onlyDate[1];
        $("#warMsg").html('');

       for(var i=0; i<SpecialGoabalData.length;i++){
          if(dateCheck==SpecialGoabalData[i].shift_start_date){
             $("#warMsg").html("* Selected Date Special Shift Already Created.");
             $('#endtDateTime').prop('disabled', true);
          }else{
             $("#warMsg").html('');
             $('#endtDateTime').prop('disabled', false);
          }
        }

        for(var i=0; i<UpcomingGoabalData.length;i++){
          if(dateCheck==UpcomingGoabalData[i].shift_start_date){
            var shiftCountNum=(parseInt(UpcomingGoabalData[i].shift) + parseInt(1));
            if(shiftCountNum <= 3){        
             // $('#shiftsCount').html('<option value="'+(parseInt(UpcomingGoabalData[i].shift) + parseInt(1)) +'">'+(parseInt(UpcomingGoabalData[i].shift) + parseInt(1))+'</option><option value="G">General</option>'); 

              $('#shiftsCount').html('<option value="'+(parseInt(UpcomingGoabalData[i].shift) + parseInt(1)) +'">'+(parseInt(UpcomingGoabalData[i].shift) + parseInt(1))+'</option>');
              var out_time = new Date(UpcomingGoabalData[i].out_time);
              $('#startDateTime').val(tempData.suppliers.getDateTimeFormat(out_time));
            }
            else{
              $("#warMsg").html("* Already 3 Shifts Created On "+ stDateTime[0]);
              $('#fromCreateShift')[0].reset();
            }
          }else{
            //$('#shiftsCount').html('<option value="1">1</option><option value="G">General</option>');
            $('#shiftsCount').html('<option value="1">1</option>');
          }

        }
      }else if(CurrentGobalData!=null){
        var stDateTime=$('#startDateTime').val().split(' ');
        var onlyDate=stDateTime[0].split('/');
        var dateCheck=onlyDate[2]+'-'+onlyDate[0]+'-'+onlyDate[1];
        $("#warMsg").html('');

        for(var i=0; i<SpecialGoabalData.length;i++){
          if(dateCheck==SpecialGoabalData[i].shift_start_date){
             $("#warMsg").html("* Selected Date Special Shift Already Created.");
             $('#endtDateTime').prop('disabled', true);
          }else{
             $("#warMsg").html('');
             $('#endtDateTime').prop('disabled', false);
          }
        }

        for(var i=0; i<CurrentGobalData.length;i++){
          if(dateCheck==CurrentGobalData[i].shift_start_date){
            var shiftCountNum=(parseInt(CurrentGobalData[i].shift) + parseInt(1));
            if(shiftCountNum <= 3){        
              //$('#shiftsCount').html('<option value="'+(parseInt(CurrentGobalData[i].shift) + parseInt(1)) +'">'+(parseInt(CurrentGobalData[i].shift) + parseInt(1))+'</option><option value="G">General</option>');

              $('#shiftsCount').html('<option value="'+(parseInt(CurrentGobalData[i].shift) + parseInt(1)) +'">'+(parseInt(CurrentGobalData[i].shift) + parseInt(1))+'</option>');
              var out_time = new Date(CurrentGobalData[i].out_time);
              $('#startDateTime').val(tempData.suppliers.getDateTimeFormat(out_time));
            }
            else{
              $("#warMsg").html("* Already 3 Shifts Created On "+ stDateTime[0]);
              $('#fromCreateShift')[0].reset();
              $('#getlongStartTime').html("00:00");
              $('#getbreak1StartTime').html("00:00");
              $('#getbreak2StartTime').html("00:00");
            }
          }else{
            //$('#shiftsCount').html('<option value="1">1</option><option value="G">General</option>');
            $('#shiftsCount').html('<option value="1">1</option>');
          }

        }
      }else{        
        //$('#shiftsCount').html('<option value="1">1</option><option value="G">General</option>');
        $('#shiftsCount').html('<option value="1">1</option>');
      }
}

},
dateCompareE:function(){
  debugger;
    var startDate = new Date($('#startDateTimeE').val());
    var endDate = new Date($('#endtDateTimeE').val());
    var hours= tempData.suppliers.getTotalHour(startDate,endDate);

  if(startDate != null && endDate != null && startDate != "Invalid Date" && endDate != "Invalid Date") {
      if (startDate.getTime() >= endDate.getTime()){    
          $("#warMsgE").html("* Start time is greater than the End Time!");
           $("#btnSaveE").prop('disabled', true);
           //$("#shifts").prop('disabled', true);
           $("#shiftsCountE").prop('disabled', true);

        return;
        }else{
        $('#getHoursEdit').html(hours);
        $("#warMsgE").html("");
        $("#btnSaveE").prop('disabled', false);        
        //$("#shifts").prop('disabled', false);        
        $("#shiftsCountE").prop('disabled', false);        
        
        tempData.suppliers.checkShiftTypeE();
      }
  }
},
getTotalHour:function(startDate,endDate){
  var startDate = new Date(startDate);
  var endDate = new Date(endDate);
  var difference = Math.abs(startDate.getTime() - endDate.getTime());
  var hourDifference = parseInt(difference  / 1000 / 3600);
  return hourDifference;
},
getDiffHourMin:function(startDate,endDate){
  var startDate = new Date(startDate);
  var endDate = new Date(endDate);
  var difference = Math.abs(startDate.getTime() - endDate.getTime())/1000;
  var hourDifference = parseInt(difference / 3600);
  var minDiff = Math.abs(difference / 60) % 60;

  return tempData.suppliers.addZero(hourDifference)+':'+tempData.suppliers.addZero(minDiff);
},
saveShift:function(){
  debugger;
  var url= "getShift.php";
  var plant_id=$('#plant_id').val();
  var startDate = $('#startDateTime').val();
  var endDate = $('#endtDateTime').val();
  var hours= tempData.suppliers.getTotalHour(startDate,endDate);
  var shiftsCount=$('#shiftsCount').val();
  var getShiftType='';
  var breakYN='';
  var recordId=0;

  if($('#shifts').is(':checked')) {
    getShiftType='SPECIAL';
  } else{
    getShiftType='NORMAL';
  }

  if($('#breakYN').is(':checked')) {
    breakYN='Y';
  } else{
    breakYN='N';
  }
  var getSelectedDateForBreak = $('#startDateTime').val().split(' ');
  var longStartTime = getSelectedDateForBreak[0]+' '+$('#longStartTime').val();
  var longEndTime = getSelectedDateForBreak[0]+' '+$('#longEndTime').val();
  var break1StartTime = getSelectedDateForBreak[0]+' '+$('#break1StartTime').val();
  var break1EndTime = getSelectedDateForBreak[0]+' '+$('#break1EndTime').val();
  var break2StartTime = getSelectedDateForBreak[0]+' '+$('#break2StartTime').val();
  var break2EndTime = getSelectedDateForBreak[0]+' '+$('#break2EndTime').val();

  var myData = {saveShift:'saveShift',plant_id:plant_id,startDate:startDate,endDate:endDate,hours:hours,getShiftType:getShiftType,shiftsCount:shiftsCount,recordId:recordId,breakYN:breakYN,longStartTime:longStartTime,longEndTime:longEndTime,break1StartTime:break1StartTime,break1EndTime:break1EndTime,break2StartTime:break2StartTime,break2EndTime:break2EndTime};
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    data:myData,
    success: function(obj) {
        debugger;
      //mysqli_insert_id
      if(obj.data !=null){
          if(obj.data.infoRes =='S'){
             alertify.alert('<p style="color:green;font-weight:600;">'+obj.data.info+'</p>');
             //tempData.suppliers.getRecentRow(obj.data.mysqli_insert_id);
             tempData.suppliers.loadAllFunc();  
             $('#fromCreateShift')[0].reset();
             $("#btnSave").prop('disabled', true);
             $("#shiftsCount").prop('disabled', true);
             $('#getHours').html("0");
             $('#getlongStartTime').html("00:00");
             $('#getbreak1StartTime').html("00:00");
             $('#getbreak2StartTime').html("00:00");
             $("#breakTable").hide();
             //$('#shiftsCount').html('<option value="0">0</option><option value="G">General</option>');
             $('#shiftsCount').html('<option value="0">0</option>');
           }else{
               alertify.alert('<p style="color:green;font-weight:600;">'+obj.data.info+'</p>');
           }
      }else{
         alertify.alert('<p style="color:red;font-weight:600;">Error While Saving, Pls Try Again</p>');
      }  

    }
  });
},
updateShift:function(){
  debugger;
  var url= "getShift.php";
  var plant_id=$('#plant_id').val();
  var startDate = $('#startDateTimeE').val();
  var endDate = $('#endtDateTimeE').val();
  var hours= tempData.suppliers.getTotalHour(startDate,endDate);  
  var shiftsCount=$('#shiftsCountE').val();
  var getShiftType='';
  var recordId=$('#recordIDE').val();

if ($('#shiftsE').is(':checked')) {
  getShiftType='SPECIAL';
} else{
  getShiftType='NORMAL';
}

  var myData = {saveShift:'saveShift',plant_id:plant_id,startDate:startDate,endDate:endDate,hours:hours,getShiftType:getShiftType,shiftsCount:shiftsCount,recordId:recordId};
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    data:myData,
    success: function(obj) {
        debugger;
      //mysqli_insert_id
      if(obj.data !=null){
          if(obj.data.infoRes =='S'){
             alertify.alert('<p style="color:green;font-weight:600;">'+obj.data.info+'</p>');
             //tempData.suppliers.getRecentRow(obj.data.mysqli_insert_id);
             tempData.suppliers.loadAllFunc();  
             $('#editMode').modal('hide');
           }else{
               alertify.alert('<p style="color:green;font-weight:600;">'+obj.data.info+'</p>');
           }
      }else{
         alertify.alert('<p style="color:red;font-weight:600;">Error While Saving, Pls Try Again</p>');
      }  

    }
  });
},
getRecentRow:function(last_id){
  debugger;
  var shiftContent='';
       var url= "getShift.php";
       var plant_id=$('#plant_id').val();
       var myData = {getRecentRow:1221,last_id:last_id,plant_id:plant_id};
      $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType:'json',
            data:myData,
            success: function(obj){
              debugger;
            
            shiftContent+='<tr><td class="text-right">'+obj.RecentRow.shift+'</td><td>'+tempData.suppliers.getSeparateAPTime(obj.RecentRow.in_time);+'</td><td>'+tempData.suppliers.getSeparateAPTime(obj.RecentRow.out_time);+'</td><td class="text-right">'+obj.RecentRow.num_hours+'</td><td><button class="btn btn-info btn-xs" onclick="tempData.suppliers.editRow('+obj.RecentRow.id+');"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" onclick="tempData.suppliers.deleteRow('+obj.RecentRow.id+');"> <i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button> </td></tr>';

            $('#shiftContent').append(shiftContent);

            }
          });

},
loadCurrentShift:function(){
    debugger;
       var url= "getShift.php";
       var plant_id=$('#plant_id').val();
       var myData = {loadCurrentShift:'loadCurrentShift',plant_id:plant_id};
      $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType:'json',
            data:myData,
            success: function(obj){
             debugger;
             CurrentGobalData=obj.CurrentShift;

            if(obj.CurrentShift==null){
              $('#loadCurrentShiftTable').DataTable({
                 "paging":false,
                  "ordering":true,
                  "info":true,
                  "searching":false,         
                  "destroy":true,
              }).clear().draw();

            }else{

     var loadCurrentShiftTable = $('#loadCurrentShiftTable').DataTable( {
           "paging":false,
            "ordering":true,
            "info":true,
            "searching":false,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 200,
            "data":obj.CurrentShift, 
            "order": [[ 1, "asc" ]],  
            "columns": [
              { data: "shift",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getShiftText(row.shift);
                }
              },
              { data: "in_time",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getSeparateAPTime(row.in_time);
                } 
              },
              { data: "out_time",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getSeparateAPTime(row.out_time);
                } 
              },
              { data: "num_hours",className: "text-right" },
              { data: "id" , className:"hideUpto8",
                render: function (data, type, row, meta) {
                  debugger;
                  var br='';
                  var a='<button class="btn btn-info btn-xs" onclick="tempData.suppliers.editRow('+row.id+');"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
                  if(row.breakYN=='Y'){
                    var objData=row;
                    br='<button class="btn btn-warning btn-xs" onclick="tempData.suppliers.CurrentBreakTime('+row.id+');"><i class="fa fa-clock-o" aria-hidden="true"></i> Break Times </button>';
                  }
          var b='<button class="btn btn-danger btn-xs" onclick="tempData.suppliers.deleteRow('+row.id+',\''+row.shift_start_date+'\');"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>'; /*a+' '+*/
                  return b+' '+br;
                }
              }]
           });   // Datatables Ends
  
              tempData.suppliers.checkTimeAbove8();
          } // else close
        } // success ends
     });
  },
  loadUpcomingShift:function(){
    debugger;
       var url= "getShift.php";
       var plant_id=$('#plant_id').val();
       var myData = {loadUpcomingShift:'loadUpcomingShift',plant_id:plant_id};
      $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType:'json',
            data:myData,
            success: function(obj){
             debugger;

             UpcomingGoabalData=obj.UpcomingShift;
              if(obj.UpcomingShift==null){
              $('#loadUpcomingShiftTable').DataTable({
                 "paging":false,
                  "ordering":true,
                  "info":true,
                  "searching":false,         
                  "destroy":true,
              }).clear().draw();

            }else{

     var loadUpcomingShiftTable = $('#loadUpcomingShiftTable').DataTable( {
           "paging":false,
            "ordering":true,
            "info":true,
            "searching":false,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 200,
            "data":obj.UpcomingShift,   
            "order": [[ 1, "desc" ]],
            "columns": [
              { data: "shift",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getShiftText(row.shift);
                }
              },
              { data: "in_time",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getSeparateAPTime(row.in_time);
                } 
              },
              { data: "out_time",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getSeparateAPTime(row.out_time);
                } 
              },
              { data: "num_hours",className: "text-right" },
              { data: "id",
                render: function (data, type, row, meta) {
                  debugger;
                  var br='';
                  var a='<button class="btn btn-info btn-xs" onclick="tempData.suppliers.editRow('+row.id+');"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
                  if(row.breakYN=='Y'){
                    var objData=row;
                    br='<button class="btn btn-warning btn-xs" onclick="tempData.suppliers.UpcomingBreakTime('+row.id+');"><i class="fa fa-clock-o" aria-hidden="true"></i> Break Times </button>';
                  }
          var b='<button class="btn btn-danger btn-xs" onclick="tempData.suppliers.deleteRow('+row.id+',\''+row.shift_start_date+'\');"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>'; /*a+' '+*/
                  return b+' '+br;
                }
              }]
           });   // Datatables Ends
          } // else close
        } // success ends
     });
  },  
  loadSpecialShift:function(){
    debugger;
       var url= "getShift.php";
       var plant_id=$('#plant_id').val();
       var myData = {loadSpecialShift:'loadSpecialShift',plant_id:plant_id};
      $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType:'json',
            data:myData,
            success: function(obj){
             debugger;
             SpecialGoabalData=obj.SpecialShift;

              if(obj.SpecialShift==null){
              $('#loadSpecialShiftTable').DataTable({
                 "paging":false,
                  "ordering":true,
                  "info":true,
                  "searching":false,         
                  "destroy":true,
              }).clear().draw();

            }else{

     var loadSpecialShiftTable = $('#loadSpecialShiftTable').DataTable( {
           "paging":false,
            "ordering":true,
            "info":true,
            "searching":false,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 200,
            "data":obj.SpecialShift,   
            "order": [[ 1, "desc" ]],
            "columns": [
              { data: "shift",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getShiftText(row.shift);
                }
              },
              { data: "in_time",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getSeparateAPTime(row.in_time);
                } 
              },
              { data: "out_time",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getSeparateAPTime(row.out_time);
                } 
              },
              { data: "num_hours",className: "text-right" },
              { data: "id" ,
                render: function (data, type, row, meta) {
                  debugger;
                  var br='';
                  var a='<button class="btn btn-info btn-xs" onclick="tempData.suppliers.editRow('+row.id+');"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
                  if(row.breakYN=='Y'){
                    var objData=row;
                    br='<button class="btn btn-warning btn-xs" onclick="tempData.suppliers.SpecialBreakTime('+row.id+');"><i class="fa fa-clock-o" aria-hidden="true"></i> Break Times </button>';
                  }
          var b='<button class="btn btn-danger btn-xs" onclick="tempData.suppliers.deleteRow('+row.id+',\''+row.shift_start_date+'\');"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>'; /*a+' '+*/
                  return b+' '+br;
                }
              }]
           });   // Datatables Ends
          } // else close
        } // success ends
     });
  },
  loadHistoryShift:function(){
    debugger;
       var url= "getShift.php";
       var plant_id=$('#plant_id').val();
       var myData = {loadHistoryShift:1221,plant_id:plant_id};
      $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType:'json',
            data:myData,
            success: function(obj){
             debugger;
             HistoryGoabalData=obj.HistoryShift;
              if(obj.HistoryShift==null){
              $('#loadHistoryShiftTable').DataTable({
                 "paging":false,
                  "ordering":true,
                  "info":true,
                  "searching":false,         
                  "destroy":true,
              }).clear().draw();

            }else{

     var loadHistoryShiftTable = $('#loadHistoryShiftTable').DataTable( {
           "paging":false,
            "ordering":true,
            "info":true,
            "searching":false,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 200,
            "data":obj.HistoryShift,   
            "order": [[ 1, "asc" ]],
            "columns": [
              { data: "shift",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getShiftText(row.shift);
                }
              },
              { data: "in_time",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getSeparateAPTime(row.in_time);
                } 
              },
              { data: "out_time",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getSeparateAPTime(row.out_time);
                } 
              },
              { data: "num_hours",className: "text-right" },
              { data: "id" ,
                render: function (data, type, row, meta) {
                  debugger;
                  var br='';
                  var a='<button class="btn btn-info btn-xs" onclick="tempData.suppliers.editRow('+row.id+');"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>';
                  if(row.breakYN=='Y'){
                    var objData=row;
                    br='<button class="btn btn-warning btn-xs" onclick="tempData.suppliers.HistoryBreakTime('+row.id+');"><i class="fa fa-clock-o" aria-hidden="true"></i> Break Times </button>';
                  }
          var b='<button class="btn btn-danger btn-xs" onclick="tempData.suppliers.deleteRow('+row.id+',\''+row.shift_start_date+'\');"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>'; /*a+' '+*/
                  return br;
                }
              }]
           });   // Datatables Ends
          } // else close
        } // success ends
     });
  },
  loadCommonTableForBreak:function(obj){
    debugger;
        var loadCommon = $('#breakTimesTable').DataTable( {
           "paging":false,
            "ordering":true,
            "info":true,
            "searching":false,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 100,
            "data":obj,   
            "columns": [
             { data: "shift",
                render: function (data, type, row, meta) {
                 return tempData.suppliers.getShiftText(row.shift);
                }
              },
              { data: "lbreak_startTime",
                render: function (data, type, row, meta) {
                  var getDateTime= tempData.suppliers.getSeparateAPTime(row.lbreak_startTime);
                  var getData=getDateTime.split(' ');
                  return getData[0]+' <b>'+getData[1]+' '+getData[2]+'</b>';
                }
              },
              { data: "lbreak_endTime",
                render: function (data, type, row, meta) {
                 var getDateTime= tempData.suppliers.getSeparateAPTime(row.lbreak_endTime);
                 var getData=getDateTime.split(' ');
                  return getData[0]+' <b>'+getData[1]+' '+getData[2]+'</b>';
                } 
              },
              { data: "break1_startTime",
                render: function (data, type, row, meta) {
                 var getDateTime= tempData.suppliers.getSeparateAPTime(row.break1_startTime);
                 var getData=getDateTime.split(' ');
                  return getData[0]+' <b>'+getData[1]+' '+getData[2]+'</b>';
                } 
              }, 
              { data: "break1_endTime",
                render: function (data, type, row, meta) {
                 var getDateTime= tempData.suppliers.getSeparateAPTime(row.break1_endTime);
                 var getData=getDateTime.split(' ');
                  return getData[0]+' <b>'+getData[1]+' '+getData[2]+'</b>';
                } 
              }, 
              { data: "break2_startTime",
                render: function (data, type, row, meta) {
                 var getDateTime= tempData.suppliers.getSeparateAPTime(row.break2_startTime);
                 var getData=getDateTime.split(' ');
                  return getData[0]+' <b>'+getData[1]+' '+getData[2]+'</b>';
                } 
              }, 
              { data: "break2_endTime",
                render: function (data, type, row, meta) {
                 var getDateTime= tempData.suppliers.getSeparateAPTime(row.break2_endTime);
                 var getData=getDateTime.split(' ');
                  return getData[0]+' <b>'+getData[1]+' '+getData[2]+'</b>';
                } 
              },             
              ]
           });   // Datatables Ends
  },
  getObjects:function(obj, key, val) {  // JSON Search function
    debugger;
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(tempData.suppliers.getObjects(obj[i], key, val));
        } else if (i == key && obj[key] == val) {
            objects.push(obj);
        }
    }
    return objects;    
  },
  CurrentBreakTime:function(val){
    debugger;
     $('#breakMode').modal({show:true});
    var getObj= tempData.suppliers.getObjects(CurrentGobalData,'id',val);
    setTimeout(function(){  tempData.suppliers.loadCommonTableForBreak(getObj); }, 200);    
  },
  UpcomingBreakTime:function(val){
    debugger;
     $('#breakMode').modal({show:true});
    var getObj= tempData.suppliers.getObjects(UpcomingGoabalData,'id',val);
    setTimeout(function(){  tempData.suppliers.loadCommonTableForBreak(getObj); }, 200);    
  },  
  SpecialBreakTime:function(val){
    debugger;
     $('#breakMode').modal({show:true});
    var getObj= tempData.suppliers.getObjects(SpecialGoabalData,'id',val);
    setTimeout(function(){  tempData.suppliers.loadCommonTableForBreak(getObj); }, 200);    
  },    
  HistoryBreakTime:function(val){
    debugger;
     $('#breakMode').modal({show:true});
    var getObj= tempData.suppliers.getObjects(HistoryGoabalData,'id',val);
    debugger;
    setTimeout(function(){  tempData.suppliers.loadCommonTableForBreak(getObj); }, 200);    
  },  
  getShiftText:function(val){
    if(val=='G'){
      return '<span class="text-left">GENERAL</span>';
    }else{
      return '<span class="text-right"> Shift - <b>'+val+'</b></span>';
    }
  },
  getSeparateAPTime:function(timeData){
    var time = new Date(timeData);
    var timeaa=time.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
    var timeaa1=timeaa.replace(/:/g,':');
    var date=tempData.suppliers.addZero(time.getDate())+'-'+tempData.suppliers.addZero(time.getMonth()+1)+'-'+time.getFullYear();
    return date+' '+timeaa1;
    //var finalTime=timeaa1.split(' ');
  },
  addZero:function(num) {
    if (num < 10) {
        num = "0" + num;
    }
    return num;
  },
  deleteRow:function(id,startDate){
    debugger;
       var url= "getShift.php";
       var plant_id=$('#plant_id').val();
       var myData = {deleteRow:'deleteRow',plant_id:plant_id,recordId:id,startDate:startDate};

     $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType:'json',
            data:myData,
            success: function(obj){
              debugger;
              //alert();
              if(obj.data == 1){
                 alertify.alert('<p style="color:red;font-weight:600;">Shift Deleted Successfully</p>');                
                 tempData.suppliers.loadAllFunc();  
              }else{
                 alertify.alert('<p style="color:red;font-weight:600;">Error While Deleting, Pls Try Again</p>');
              } 

            } // success ends
      });
  },
  editRow:function(id){
    $('#editMode').modal({show:true});
    tempData.suppliers.editRowResult(id); 
  },
  editRowResult:function(id){
    debugger;
       var url= "getShift.php";
       var plant_id=$('#plant_id').val();
       var myData = {editRow:'editRow',plant_id:plant_id,recordId:id};
      $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType:'json',
            data:myData,
            success: function(obj){
              debugger;
              //alert(obj);
              var in_time = new Date(obj.data.in_time);
                  in_time = tempData.suppliers.getDateTimeFormat(in_time); 
              var out_time = new Date(obj.data.out_time);
                  out_time = tempData.suppliers.getDateTimeFormat(out_time);
              $('#shiftsCountE').val(obj.data.shift);
              $('#startDateTimeE').val(in_time);
              $('#endtDateTimeE').val(out_time);
              $('#getHoursEdit').html(obj.data.num_hours);

              if(obj.data.shift_type=='SPECIAL'){
                $('#shiftsE').prop('checked', true);
              }else{
                $('#shiftsE').prop('checked', false);
              }    
              $('#recordIDE').val(obj.data.id);
             
            } // success ends
      });
  },
  getDateTimeFormat:function (date){
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
     return tempData.suppliers.addZero(date.getMonth()+1) + "/" + tempData.suppliers.addZero(date.getDate()) + "/" + date.getFullYear() + "  " + strTime;
  },
  loadAllFunc:function(){
    tempData.suppliers.loadCurrentShift();
    tempData.suppliers.loadUpcomingShift();
    tempData.suppliers.loadSpecialShift();
    tempData.suppliers.loadHistoryShift();
     tempData.suppliers.checkTimeAbove8();
  },
  checkTimeAbove8:function(){
    var today = new Date().getHours();
      if (today > 8) {
        $('.hideUpto8').hide();
      }else{
        $('.hideUpto8').show();
      }
  },
  addBreakRow:function(){
    if($('#breakYN').is(':checked')) {
      $("#breakTable").show();
    } else{
      $("#breakTable").hide();
    }
  }

};
 

$(document).ready(function(){
  debugger;
   $(".loader").fadeOut("slow");

    $('#comp_id').val(<?php echo $_GET['com'];?>);
    $('#plant_id').val(<?php echo $_GET['pla'];?>);
    $('#workCenter_id').val(<?php echo $_GET['wor'];?>);
    $('#iobotMachine').val(<?php echo $_GET['io'];?>);    

/*  var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());*/
  //{format:'DD/MM/YYYY hh:mm ', }


  /* Only Used in Create Shift */
  $('#startDateTime').datetimepicker({  
    minDate:new Date()
  });
  $('#endtDateTime').datetimepicker({  
    minDate:new Date()
  });

  /* Only Used in Edit Mode*/
  $('.dateClassForTime12').datetimepicker({  
    minDate:new Date()
  });


  /*Only used for Break Time*/
  $('#longStartTime').datetimepicker({
     format: 'LT'
  });
  $('#longEndTime').datetimepicker({
     format: 'LT'
  }); 
  $('#break1StartTime').datetimepicker({
     format: 'LT'
  });
  $('#break1EndTime').datetimepicker({
     format: 'LT'
  });
  $('#break2StartTime').datetimepicker({
     format: 'LT'
  });
  $('#break2EndTime').datetimepicker({
     format: 'LT'
  });


  $("#shiftDropdown").hide();
  $("#addShiftRecord").hide();
  $("#btnSave").prop('disabled', true);
  $('#getHours').html(0);
  $('#getHoursEdit').html(0);
  $('#getlongStartTime').html("00:00");
  $('#getbreak1StartTime').html("00:00");
  $('#getbreak2StartTime').html("00:00");

/*  $('#btnBack').click(function(){
     window.location="suppliers.php";
  });*/

  $("#btnCreate").click(function(){
      $("#shiftDropdown").slideToggle("slow");
      $("#addShiftRecord").slideToggle("slow");
  });

  //tempData.suppliers.getUserInfo();
  tempData.suppliers.loadAllFunc();

   $("#headingOne").on("click", function() {
    setTimeout(function(){ tempData.suppliers.loadCurrentShift(); }, 200);
   });

   $("#headingTwo").on("click", function() {
    setTimeout(function(){ tempData.suppliers.loadUpcomingShift(); }, 200);
   });

   $("#headingThree").on("click", function() {
    setTimeout(function(){ tempData.suppliers.loadSpecialShift(); }, 200);
   });

   $("#headingFour").on("click", function() {
    setTimeout(function(){ tempData.suppliers.loadHistoryShift(); }, 200);      
   });

/* Toggle Accordion */
   $(".toggle-accordion").on("click", function() {
    var accordionId = $(this).attr("accordion-id"),
    numPanelOpen = $(accordionId + ' .collapse.in').length;
    
    $(this).toggleClass("active");  

    if (numPanelOpen == 0) { 
      openAllPanels(accordionId);
    } else {
      closeAllPanels(accordionId);
    }
  });

  openAllPanels = function(aId) {
    //console.log("setAllPanelOpen");
    $(aId + ' .panel-collapse:not(".in")').collapse('show');
  }
  closeAllPanels = function(aId) {
    //console.log("setAllPanelclose");
    $(aId + ' .panel-collapse.in').collapse('hide');
  }
     

  $('#btnAccordion').trigger('click'); 
  setTimeout(function(){ 
    $('#collapseCurrentbtn').trigger('click');
  }, 500);
   
    $('#shifts').click(function() {
          $('#startDateTime').val('');
          $('#endtDateTime').val('');
          $('#shiftsCount').val('');
    });

setInterval('updateClock()', 1000);
});
</script>

<input type="hidden" name="comp_id" id="comp_id"/> 
<input type="hidden" name="plant_id" id="plant_id"/> 
<input type="hidden" name="workCenter_id" id="workCenter_id"/> 
<input type="hidden" name="iobotMachine" id="iobotMachine"/>

<div class="container">
	<div class="col-md-12">
		<div class="page-header">
		</div>
		<div class="panel panel-success">
			<div class="panel-heading "> 
				<div class="panel-title pull-left">
             		Create Shifts
         		</div>
		        <div class="panel-title pull-right" id="clock"></div>
		        <div class="clearfix"></div>
			</div>
						 
			<div class="panel-body">
				<div class="row">

<!-- <button type="button" id="btnBack" 
class="col-md-1 btn btn-primary btn-sm" style="float:left;margin-bottom: 3%;margin-left:1%;">
<i class="fa fa-reply" aria-hidden="true"></i>&nbsp;&nbsp;Back</button> -->

<button type="button" id="btnCreate" class="col-md-2 btn btn-warning btn-sm pull-right" style="margin-right: 2%;margin-bottom: 3%" >
<i class="fa fa-arrows" aria-hidden="true"></i>&nbsp;&nbsp;Create New Shift</button>

<div class="col-md-3 col-xs-8 pull-right" id="shiftDropdown">
  <!-- <label class="control-label col-md-4 col-sm-6 col-xs-5" style="margin-top: 2%;">Shift Type</label> -->
  <div class="col-md-8 col-sm-6 col-xs-6 pull-right">
    <input type="checkbox" name="shifts" class="mychart" id="shifts" on><label class="fontClass">Special Shift</label>
  </div>
</div>


<div class="col-md-12 col-xs-12" style="margin-top: -1%;"> 

<div class="row col-md-offset-1" id="addShiftRecord">
<form class="" id="fromCreateShift">  
<!-- <input type="hidden" name="comp_id" id="comp_id"/> 
<input type="hidden" name="plant_id" id="plant_id"/> 
<input type="hidden" name="workCenter_id" id="workCenter_id"/> 
<input type="hidden" name="iobotMachine" id="iobotMachine"/> -->

      <div class="row">
          <div class="col-md-11">
              <table class="table table-bordered">
                <thead>
                  <tr class="headTitle">
                    <th>Shifts</th>
                    <th>In DateTime <sub>(mm-dd-yyyy)</sub> </th>
                    <th>Out DateTime <sub>(mm-dd-yyyy)</sub> </th>                    
                    <th>No. of Hours</th>
                    <th>Shift Break</th>
                    <th>Action</th>
                  </tr>
                </thead>
                 
                <tbody id="shiftContent">
                </tbody>

                <tfoot>
                 <tr>
                    <td>
                      <select name="shiftsCount"  id="shiftsCount" class="form-control" onchange="tempData.suppliers.checkShiftType();"> 
                        <!-- onchange="tempData.suppliers.checkShiftType();" -->                        
                      </select>
                    </td>
                    <td>
                      <div class="input-group date">
                      <input name="startDateTime" id="startDateTime" type="text" class="form-control dateClassForTime" onfocusout="tempData.suppliers.checkDupShift()" placeholder="mm/dd/yyyy" />
                      <label class="input-group-addon btn" for="startDateTime">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </label>
                      </div>
                    </td>
                    <td>
                      <div class="input-group date">
                      <input name="endtDateTime" id="endtDateTime" type="text" class="form-control dateClassForTime" onfocusout="tempData.suppliers.dateCompare()" placeholder="mm/dd/yyyy" />
                      <label class="input-group-addon btn" for="endtDateTime">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </label>
                      </div>
                    </td>                    
                    <td class="text-right" id="getHours"></td>
                    <td class="text-center">
                      <input type="checkbox" name="breakYN" class="mychart" id="breakYN" onclick="tempData.suppliers.addBreakRow();"><label class="fontClass">&nbsp;</label>
                    </td>
                    <td>
                      <button type="button" class="btn btn-success btn-sm" id="btnSave" onclick="tempData.suppliers.saveShift();"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                    </td>
                  </tr>
                </tfoot>
              </table>

              <div id="breakTable" style="display:none;">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <tr class="headTitle" style="text-transform: uppercase;">
                      <th colspan="3">Long Break</th>
                      <th colspan="3">Short Break 1</th>
                      <th colspan="3">Short Break 2</th>
                    </tr>
                  </tr>    
                </thead>  
                <tbody>
                  <tr>
                    <td>
                      <!-- Long Break -->
                      <b>Start Time</b><br>
                      <div class="input-group date">
                        <input name="longStartTime" id="longStartTime" type="text" class="form-control" placeholder="hh:mm" onfocusout="tempData.suppliers.longStartTime()"/>
                        <label class="input-group-addon btn" for="longStartTime">
                        <span class="glyphicon glyphicon-time"></span>
                        </label>
                      </div>
                    </td>
                    <td>
                      <b>End Time</b><br>
                      <div class="input-group date">
                        <input name="longEndTime" id="longEndTime" type="text" class="form-control" placeholder="hh:mm" onfocusout="tempData.suppliers.longStartTime()"/>
                        <label class="input-group-addon btn" for="longEndTime">
                        <span class="glyphicon glyphicon-time"></span>
                        </label>
                      </div>
                    </td>
                    <td class="text-center"><b>Duration</b><br><span class="durationTime" id="getlongStartTime"></span>  </td> 


                    <!-- Short Break 1 -->
                    <td>
                      <b>Start Time</b><br>
                      <div class="input-group date">
                        <input name="break1StartTime" id="break1StartTime" type="text" class="form-control" placeholder="hh:mm" onfocusout="tempData.suppliers.break1StartTime()"/>
                        <label class="input-group-addon btn" for="break1StartTime">
                        <span class="glyphicon glyphicon-time"></span>
                        </label>
                      </div>
                    </td>
                    <td>
                      <b>End Time</b><br>
                      <div class="input-group date">
                        <input name="break1EndTime" id="break1EndTime" type="text" class="form-control" placeholder="hh:mm" onfocusout="tempData.suppliers.break1StartTime()"/>
                        <label class="input-group-addon btn" for="break1EndTime">
                        <span class="glyphicon glyphicon-time"></span>
                        </label>
                      </div>
                    </td>
                    <td class="text-center"><b>Duration</b><br><span class="durationTime" id="getbreak1StartTime"></span>  </td> 

                    <!-- Short Break 2 -->
                    <td>
                      <b>Start Time</b><br>
                      <div class="input-group date">
                        <input name="break2StartTime" id="break2StartTime" type="text" class="form-control" placeholder="hh:mm" onfocusout="tempData.suppliers.break2StartTime()"/>
                        <label class="input-group-addon btn" for="break2StartTime">
                        <span class="glyphicon glyphicon-time"></span>
                        </label>
                      </div>
                    </td>
                    <td>
                      <b>End Time</b><br>
                      <div class="input-group date">
                        <input name="break2EndTime" id="break2EndTime" type="text" class="form-control" placeholder="hh:mm" onfocusout="tempData.suppliers.break2StartTime()"/>
                        <label class="input-group-addon btn" for="break2EndTime">
                        <span class="glyphicon glyphicon-time"></span>
                        </label>
                      </div>
                    </td>
                    <td class="text-center"><b>Duration</b><br><span class="durationTime" id="getbreak2StartTime"></span>  </td> 

                  </tr>
                </tbody>    
              </table>
            </div>
                  
               <p id="warMsg" class="errorText"></p>
               <p id="warMsgLong" class="errorText"></p>
               <p id="warMsgBreak1" class="errorText"></p>
               <p id="warMsgBreak2" class="errorText"></p>
            </div>          
      </div>
      </form>
  </div>  


</div> <!-- After Create New Shift Button -->


<div class="col-md-10 col-xs-12 col-md-offset-1" style="margin-top: -2%;"> 
   <div class="accordion-option">
  <a id="btnAccordion" href="javascript:void(0)" class="toggle-accordion active btn btn-default btn-xs" accordion-id="#accordion"></a>
    </div>
     <div class="clearfix"></div>

  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">



    <!-- Current Shifts -->
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
        <a role="button" id="collapseCurrentbtn" data-toggle="collapse" data-parent="#accordion" href="#collapseCurrent" aria-expanded="true" aria-controls="collapseCurrent">
         
          <div class="row">
            <div class="col-md-12 col-xs-12">
               <label class="control-label titleName"> <i class="fa fa-calendar" aria-hidden="true"></i> Current Running Shifts</label>  <sub>(dd-mm-yyyy)</sub> 
            </div>
          </div>

        </a>
      </h4>
      </div>
      <div id="collapseCurrent" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
        
          <div class="row">
           <div class="col-md-12" style="overflow-x:auto;">
                <table id="loadCurrentShiftTable" class="table table-hover table-bordered table-responsive nowrap" style="font-size: 12px;width:100%;" >
                  <thead>
                    <tr class="headTitle">
                      <th>Shifts</th>
                      <th>In DateTime</th>
                      <th>Out DateTime</th>
                      <th>No. of Hours</th>
                      <th class="hideUpto8">Action</th>
                    </tr>
                  </thead>
                </table>             
              </div>          
        </div>

        </div>
      </div>
    </div>

      <!-- Upcoming Shifts -->
     <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
          <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
            
            <div class="row">
              <div class="col-md-12 col-xs-12">
                 <label class="control-label titleName"> <i class="fa fa-calendar" aria-hidden="true"></i> Upcoming Shifts</label>  <sub>(dd-mm-yyyy)</sub> 
              </div>
            </div>

          </a>
        </h4>
        </div>
        <div id="collapseZero" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
          <div class="panel-body">
           
              <div class="row">
                 <div class="col-md-12" style="overflow-x:auto;">
                    <table id="loadUpcomingShiftTable" class="table table-hover table-bordered table-responsive nowrap" style="font-size: 12px;width:100%;" >
                      <thead>
                        <tr class="headTitle">
                          <th>Shifts</th>
                          <th>In DateTime</th>
                          <th>Out DateTime</th>
                          <th>No. of Hours</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    </table>             
                  </div>             
              </div>

          </div>
        </div>
      </div>


    <!-- Special Shifts -->
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingThree">
        <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         
          <div class="row">
            <div class="col-md-12 col-xs-12">
               <label class="control-label titleName"> <i class="fa fa-calendar" aria-hidden="true"></i> Special Shifts</label>  <sub>(dd-mm-yyyy)</sub> 
            </div>
          </div>

        </a>
      </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
        <div class="panel-body">
        
          <div class="row">
              <div class="col-md-12" style="overflow-x:auto;">
                  <table id="loadSpecialShiftTable" class="table table-hover table-bordered table-responsive nowrap" style="font-size: 12px;width:100%;" >
                    <thead>
                      <tr class="headTitle">
                        <th>Shifts</th>
                        <th>In DateTime</th>
                        <th>Out DateTime</th>
                        <th>No. of Hours</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                  </table>             
                </div>               
          </div>

        </div>
      </div>
    </div>

    <!-- History -->
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingFour">
        <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          
           <div class="row">
              <div class="col-md-12 col-xs-12">
               <label class="control-label titleName"> <i class="fa fa-calendar" aria-hidden="true"></i> History</label>  <sub>(dd-mm-yyyy)</sub> 
              </div>
           </div>
        </a>
      </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
        <div class="panel-body">
          <div class="row">
             <div class="col-md-12" style="overflow-x:auto;">
                <table id="loadHistoryShiftTable" class="table table-hover table-bordered table-responsive nowrap" style="font-size: 12px;width:100%;" >
                  <thead>
                    <tr class="headTitle">
                      <th>Shifts</th>
                      <th>In DateTime</th>
                      <th>Out DateTime</th>
                      <th>No. of Hours</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>             
              </div>             
          </div>
        </div>
      </div>
    </div>


  </div>
</div>


			</div>				
		</div>
	</div>
</div>



<!--  View Time Mode -->
<div id="breakMode" class="modal fade"  role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:90%;">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-clock-o" aria-hidden="true"></i> Break Details</h4>
            </div>
            <div class="modal-body">
             <div class="row col-md-offset-1" id="breakModeRecord">

      <div class="row">
          <div class="col-md-11">
              <table class="table table-bordered" id="breakTimesTable" style="width:100%;">
                <thead>
                  <tr class="headTitle">
                    <th>Shifts</th>
                    <th>LongBreak StartTime</th>
                    <th>LongBreak EndTime</th>
                    <th>ShortBreak-1 StartTime</th>
                    <th>ShortBreak-1 EndTime</th>
                    <th>ShortBreak-2 StartTime</th>
                    <th>ShortBreak-2 EndTime</th>
                  </tr>
                </thead> 
                <tbody id="breakshiftContent">
                </tbody>                
              </table>  
          </div>      
      </div>
  </div>  
            
            </div>
            <div class="modal-footer" style="border-top:none;">
               
            </div>
    </div>
  </div>
</div> 


<!--  Edit Mode -->
<div id="editMode" class="modal fade"  role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:90%;">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Shift</h4>
            </div>
            <div class="modal-body">
             <div class="row col-md-offset-1" id="addShiftRecord">
<form class="" id="fromEditShift">     
<!-- <input type="hidden" name="comp_id" id="comp_id"/> 
<input type="hidden" name="plant_id" id="plant_id"/> 
<input type="hidden" name="workCenter_id" id="workCenter_id"/> 
<input type="hidden" name="iobotMachine" id="iobotMachine"/> -->
<input type="hidden" name="recordID" id="recordIDE"/>   

      <div class="row">
          <div class="col-md-11">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="pull-right">
                <input type="checkbox" name="shifts" class="mychart" id="shiftsE"><label class="fontClass">Special Shift</label>
              </div>
            </div>  
              <table class="table table-bordered">
                <thead>
                  <tr class="headTitle">
                    <th>Shifts</th>
                    <th>In DateTime</th>
                    <th>Out DateTime</th>                    
                    <th>No. of Hours</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <!--  
                <tbody id="shiftContent">
                </tbody> -->

                <tfoot>
                 <tr>
                    <td>
                      <select name="shiftsCount"  id="shiftsCountE" class="form-control" onchange="tempData.suppliers.checkShiftTypeE();" readonly> <!-- onchange="tempData.suppliers.checkShiftType();" -->
                        <option value="0">Select Shift</option>
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                      <!--   <option value="G">General</option> -->
                      </select>
                    </td>
                    <td>
                      <div class="input-group date">
                      <input name="startDateTime" id="startDateTimeE" type="text" class="form-control dateClassForTime12" onfocusout="tempData.suppliers.dateCompareE()" placeholder="mm/dd/yyyy" />
                      <label class="input-group-addon btn" for="startDateTime">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </label>
                      </div>
                    </td>
                    <td>
                      <div class="input-group date">
                      <input name="endtDateTime" id="endtDateTimeE" type="text" class="form-control dateClassForTime12" onfocusout="tempData.suppliers.dateCompareE()" placeholder="mm/dd/yyyy" />
                      <label class="input-group-addon btn" for="endtDateTime">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </label>
                      </div>
                    </td>                    
                    <td class="text-right" id="getHoursEdit"></td>
                    <td><button type="button" class="btn btn-success btn-sm" id="btnSaveE" onclick="tempData.suppliers.updateShift();"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Update Shift</button></td>
                  </tr>
                </tfoot>
              </table>
               <span id="warMsgE" class="errorText"></span>
            </div>          
      </div>
      </form>
  </div>  
            
            </div>
            <div class="modal-footer" style="border-top:none;">
               
            </div>
    </div>
  </div>
</div> 

</body>
</html>

