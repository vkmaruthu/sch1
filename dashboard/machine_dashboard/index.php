<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>


<!-- Highchart JS and CSS -->
<script src="../common/highchart/highcharts.js"></script>
<script src="../common/highchart/modules/data.js"></script>
<script src="../common/highchart/modules/drilldown.js"></script>

<script src="../common/highchart/highcharts-more.js"></script>
<script src="../common/highchart/solid-gauge.js"></script>
<script src="../common/highchart/bullet.js"></script>

<style type="text/css">
.expandAddCssDIV{
  height: 100% !important;
}
.expandAddCssGraph{
  height: 400px !important;
}
.expandAddCssGraphLineGraph {
    height: 84% !important;
}
#expandHourlyChart:hover{
  background-color: #c9cac9;
}
#expandActivityAnalysis:hover{
  background-color: #c9cac9;
}
.progressCss{
  height: 25px;
}
</style>

<script type="text/javascript">
/* highchart variable */
var operBtn=null;
var activity=null;

/* Shift Variables */
var Ghours=null;  
var GinTime=null;   
var GoutTime=null; 
var GtotalHour=null;  
var GstartHour=null;
var ShiftGobalData=null;
var GdbStartHour=null;

var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}
  
tempData.oeeDash=
{
getTimeHHMMSS:function(time){
  var hours = Math.floor(time / 3600);
  time -= hours * 3600;
  var minutes = Math.floor(time / 60);
  time -= minutes * 60;
  var seconds = parseInt(time % 60, 10);
  //console.log((hours < 10 ? '0' + hours : hours) + ':' + (minutes < 10 ? '0' + minutes : minutes) + ':' + (seconds < 10 ? '0' + seconds : seconds));
  return (hours < 10 ? '0' + hours : hours) + ':' + (minutes < 10 ? '0' + minutes : minutes) + ':' + (seconds < 10 ? '0' + seconds : seconds);
},  
NumFormat:function(num){
    var n = num.toString(), p = n.indexOf('.');
    return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
        return p<0 || i<p ? ($0+',') : $0;
    });
},
getEQDesc:function(){
    var url="getDataController.php";
    var comp_id=$('#comp_id').val();
    var myData = {getEquipmentDetailsWithCompID:'getEquipmentDetailsWithCompID', comp_id:comp_id};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        if( obj.equipmentDetails !=null){
         $("#eq_desc").html('');
         //$("#eq_desc").append('<option value="none"> Select Equipment </option>');
          for(var i=0; i< obj.equipmentDetails.length; i++){
           $("#eq_desc").append('<option value="'+obj.equipmentDetails[i].id+'">'+obj.equipmentDetails[i].eq_desc+'</option>'); 
          }
          }
        } 
    });
},
oeeCirclePerc:function(id,val,fgColor) {  
    debugger;
       $('#'+id).trigger('configure',{
            "min":0,
            "max":100,
            "fgColor":fgColor,
            "inputColor":fgColor,
            "format" : function (val) {
              return val + '%';
            }
        }
    );      
    $('#'+id).val(val).trigger('change');
}, 
getImg:function(img,reason,status,reason_color) {  
debugger;
    var dataSet;
    dataSet='<label class="pointer toggle-reason-bar pull-right" style="margin-right:10px;">'+reason+' <i style="background-color:'+reason_color+'; width:10px;height: 10px; display:inline-block;"></i></label>';

        $("#imgTitleInfo").html(dataSet);

        if(img !=""){
            $("#showIobotImg").html('<img src="../common/img/machine/'+img+'"  OnError="this.src=\'../common/img/machine/default.png\';" class="img-thumbnail dashMachineImg"/>');
        }else{
            $("#showIobotImg").html('<img src="../common/img/machine/default.png"  OnError="this.src=\'../common/img/machine/default.png\';" class="img-thumbnail dashMachineImg"/>');
        }

        if(status==1){
          $("#statusImg").html('<img src="../common/img/online.png" class="img-responsive statusImg"/>');
        }else{
          $("#statusImg").html('<img src="../common/img/offline.png" class="img-responsive statusImg"/>');  
        }
        
},
loadOeeData:function(){
    debugger;
    var selDate = $("#userDateSel").val();
    var url= "getDataController.php";
    var comp_id=$('#comp_id').val();
    var plant_id=$('#plant_id').val();
    var workCenter_id=$('#workCenter_id').val();
    var iobotMachine= $('#eq_desc').val();
    var shift= $('#shiftDropdown').val();

    var myData = {loadOeeData:'loadOeeData',selDate:selDate,comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine,shift:shift };

        $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj) {
              debugger;
              tempData.oeeDash.getImg(obj.oeeDetails.image_filename,obj.oeeDetails.active_reason_code,parseInt(obj.oeeDetails.machine_status),obj.oeeDetails.active_reason_color);
              tempData.oeeDash.oeeCirclePerc('oeePerc',parseInt(obj.oeeDetails.oee_perc),obj.oeeDetails.oee_perc_color);
              tempData.oeeDash.oeeCirclePerc('availPerc',parseInt(obj.oeeDetails.availability_perc),obj.oeeDetails.availability_perc_color);
              tempData.oeeDash.oeeCirclePerc('performPerc',parseInt(obj.oeeDetails.performance_perc),obj.oeeDetails.performance_perc_color);
              tempData.oeeDash.oeeCirclePerc('qualityPerc',parseInt(obj.oeeDetails.quality_perc),obj.oeeDetails.quality_perc_color);
              $('#PlannedProductionTime').html(tempData.oeeDash.getTimeHHMMSS(parseInt(obj.oeeDetails.planned_production_time)));
              $('#RunTime').html(tempData.oeeDash.getTimeHHMMSS(parseInt(obj.oeeDetails.run_time)));
              $('#RunTimePerc').css("width",parseInt(obj.oeeDetails.run_time_perc));
              $('#IdleTime').html(tempData.oeeDash.getTimeHHMMSS(parseInt(obj.oeeDetails.idle_time)));
              $('#IdleTimePerc').css("width",parseInt(obj.oeeDetails.idle_time_perc));
              $('#BreakdownTime').html(tempData.oeeDash.getTimeHHMMSS(parseInt(obj.oeeDetails.breakdown_time)));
              $('#BreakdownTimePerc').css("width",parseInt(obj.oeeDetails.breakdown_time_perc));
              $('#IdealCycleTime').html(tempData.oeeDash.getTimeHHMMSS(parseInt(obj.oeeDetails.ideal_cycle_time)));
              $('#AverageTimePart').html(tempData.oeeDash.getTimeHHMMSS(parseInt(obj.oeeDetails.average_time_per_part)));
              $('#TotalCount').html(tempData.oeeDash.NumFormat(parseInt(obj.oeeDetails.total_Count)));
              $('#OkCount').html(tempData.oeeDash.NumFormat(parseInt(obj.oeeDetails.ok_Count)));
              $('#RejectedCount').html(tempData.oeeDash.NumFormat(parseInt(obj.oeeDetails.rejected_Count)));
                                                              
            }
        });
},   
visitPlants:function(){
  window.location.href="../plants/index.php?selDate="+$('#userDateSel').val();
},
visitWorkcenter:function(){
  window.location.href="../workcenter/index.php?selDate="+$('#userDateSel').val();
},
visitMachine:function(){
  window.location.href="../machine/index.php?selDate="+$('#userDateSel').val();
},   
loadShiftData:function(){
    debugger;

    var selDate = $("#userDateSel").val();
    var url= "getDataController.php";

    var comp_id=$('#comp_id').val();
    var plant_id=$('#plant_id').val();
    var workCenter_id=$('#workCenter_id').val();
    var iobotMachine= $('#iobotMachine').val();  


    var myData = {loadShiftData:'loadShiftData',selDate:selDate,comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine };

        $.ajax({
            type:"POST",
            url:url,
            async: false,
            dataType: 'json',
            data:myData,
            success: function(obj) {
              debugger;
              ShiftGobalData=obj.shiftData;
             // $("#shiftDropdown").html('<option value="default">Default Shift</option>');
              $("#shiftDropdown").html(' ');
              if(obj.shiftData != null){
                for(var i=0;i<obj.shiftData.length;i++)
                {
                  if(obj.shiftData[i].shift != 0){
                    $("#shiftDropdown").append('<option value="'+obj.shiftData[i].id+'"> Shift-'+
                        obj.shiftData[i].shift+' '+obj.shiftData[i].dateFormat+'</option>');
                  }
                  else{
                     if(obj.shiftData.length>2){
                       // $("#shiftDropdown").append('<option value="'+obj.shiftData[i].id+'"> All Shift '+obj.shiftData[i].dateFormat+'</option>'); 
                      }
                  }
                } 
              }else{
                //$("#shiftDropdown").html('<option value="default">Default Shift</option>');
              }            
              
              tempData.oeeDash.shiftsdata();                                     
            }
        });
},   
convertTime:function(time){
    var d;
    d = new Date(time);
    d.setSeconds(d.getSeconds() - 1);
    return tempData.oeeDash.addZero(d.getHours()) + ':'+tempData.oeeDash.addZero(d.getMinutes()) + ':' + tempData.oeeDash.addZero(d.getSeconds());
},
convertTimeWithOutOneSec:function(time){
    var d;
    d = new Date(time);
   // d.setSeconds(d.getSeconds() - 1);
    return tempData.oeeDash.addZero(d.getHours()) + ':'+tempData.oeeDash.addZero(d.getMinutes()) + ':' + tempData.oeeDash.addZero(d.getSeconds());
},
addZero:function($num) {
    if($num < 10) {
        $num = "0".$num;
    }
    return $num;
},
getCommonDataForShift:function(obj){
    debugger;
  var arr=[];
  var hours = parseInt(obj.num_hours)*60*60;
  var inTime = tempData.oeeDash.convertTimeWithOutOneSec(obj.in_time);
  var outTime = tempData.oeeDash.convertTime(obj.out_time);
  var d = new Date(obj.in_time);
    arr.push({"hour":hours,"inTime":inTime,"outTime":outTime,"startHour":d.getHours()});
    return arr;
},
shiftsdata:function(){
     debugger;
     // tempData.oeeDash.changeDateFormat(); 
    var shift= $('#shiftDropdown').val();
    var ShiftName = $("#shiftDropdown option:selected").text();

    $('#ShiftLabel').html(ShiftName);

    if(shift=='default'){ // if no shift are aviable it takes default.
      Ghours=90200;  GinTime='00:00:00';   GoutTime='23:59:59';  GtotalHour=24;  GstartHour=1; GdbStartHour=1;
/*      tempData.oeeDash.loadEventGraph(Ghours,GinTime,GoutTime,GtotalHour,GstartHour);
      tempData.oeeDash.loadgraph_productivity_analysis1('00:00:00','23:59:59');*/
      tempData.oeeDash.activityAnalysis();
      tempData.oeeDash.checkData();
    }else{
      var singalJosn=tempData.oeeDash.getObjects(ShiftGobalData,'id',shift);
      var get3Data= tempData.oeeDash.getCommonDataForShift(singalJosn[0]); // Passing all Selected Shift Data
      //console.log(singalJosn);
      // hours,inTime,outTime,totalHour,startHour
      tempData.oeeDash.AfterShiftSelect(get3Data[0].hour,get3Data[0].inTime,get3Data[0].outTime,parseInt(singalJosn[0].num_hourss),get3Data[0].startHour,singalJosn[0].hour_start);
      
    }
},
AfterShiftSelect:function(hours,inTime,outTime,totalHour,startHour,dbStartHour){
        // hours,inTime,outTime,totalHour,startHour
        Ghours=hours;  GinTime=inTime;   GoutTime=outTime;  GtotalHour=totalHour;  GstartHour=startHour;
        GdbStartHour=dbStartHour;
/*        tempData.oeeDash.loadEventGraph(hours,inTime,outTime,totalHour,startHour); 
        tempData.oeeDash.loadgraph_productivity_analysis1(inTime,outTime); //inTime,outTime*/
        tempData.oeeDash.activityAnalysis();
        tempData.oeeDash.checkData();
},
getObjects:function(obj, key, val) {  // JSON Search function
    debugger;
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(tempData.oeeDash.getObjects(obj[i], key, val));
        } else if (i == key && obj[key] == val) {
            objects.push(obj);
        }
    }
    return objects;    
},
loadToolProcDrillData:function(mode){        /* Load Hourly Chart with Drilldown */
  // Ghours=90200;  GinTime='00:00:00';   GoutTime='23:59:59';  GtotalHour=24;  GstartHour=0;
    var selDate = $("#userDateSel").val();
    var url= "getDataController.php";

    var comp_id=$('#comp_id').val();
    var plant_id=$('#plant_id').val();
    var workCenter_id=$('#workCenter_id').val();
    var iobotMachine= $('#eq_desc').val();  
    var group_type=mode;
    var msg;

    var myData = {loadToolProcDrillData:'loadToolProcDrillData',selDate:selDate,comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine,total_hours:GtotalHour,start_hour:GstartHour,dbStartHour:GdbStartHour,group_type:group_type};

    if(mode=='T'){
      msg = 'Tool Hourly Production';
    }else if(mode=='P'){
      msg = 'Hourly Production';
    }else{
      msg = 'Machine Hourly Production';
    }

    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        if(mode=='M'){
          if(obj.machineData!=null){          
            tempData.oeeDash.loadMachineHourly(obj,msg);
          }else{
            msg = 'Data Not Available';
            tempData.oeeDash.loadMachineHourly(obj,msg);
          } 
        }else{
          if(obj.firstPhaseData!=null){          
            tempData.oeeDash.loadToolHourlyDrilldown(obj,msg); 
          }else{
            msg = 'Data Not Available';
            tempData.oeeDash.loadToolHourlyDrilldown(obj,msg); 
          }     
        }             
      } 
    });
},
loadToolHourlyDrilldown:function(obj,msg){        /* Load Hourly Chart with Drilldown */
debugger;
operBtn = Highcharts.chart('hourlyProduction', {
  lang: {
        drillUpText: '<',
    },
    chart: {
        type: 'column',
        events: {
                drillup: function (e) {
                  //alert();
                  //debugger; 
                  /*globalOrderNum='';
                  tempData.cpsData.checkHourlyGraph('','');
                  
                  $('#hourlyLineGraphName').html('');
                  $("#avgCountPerPartCycle").hide();
                  $("#avgCountPerPartSetting").hide();*/
              }
            }
    },
    title: {
        text: msg
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Count'
        }
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            events: {
              click: function (e){
                 // tempData.cpsData.checkHourlyGraph(e.point.drilldown); 
              }
            },
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },
    series: [{
        name: 'Production',
        colorByPoint: true,
        data: obj.firstPhaseData
    }],
    drilldown: {
        series:obj.secondPhaseData
    }
});
},
loadMachineHourly:function(obj,msg){        /* Load Hourly Chart with Drilldown */
debugger;
  operBtn =  Highcharts.chart('hourlyProduction', {
      chart: {
          type: 'column'
      },
      title: {
          text: msg
      },
      subtitle: {
          text: ''
      },
      xAxis: {
          categories:obj.rowHourArr,
          crosshair: true
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Count'
          }
      },
      tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key} Hour</span><table>',
          pointFormat: '<tr><td style="font-size:14px;color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0;font-size:14px"><b>{point.y}</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
      },
      plotOptions: {
          column: {
              pointPadding: 0.2,
              borderWidth: 0
          },
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  format: '{point.y}'
              }
          }
      },
      series:obj.machineData
      //[{"name":"TOOL12","data":[33,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,11]}]
  });
},
activityAnalysis:function(obj,msg){
debugger;  
activity = Highcharts.chart('activityAnalysis', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: msg
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.getHHMM}</b></b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '{point.getHHMM}',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            },
            showInLegend: true
        }
    },
     legend: {
            itemStyle: {
                color: 'black',
                fontSize: '10px'
            }
        },
    series: [{
        name: 'Productivity',
        colorByPoint: true,
        data: [
                {
                  "name": "Idle Production",
                  "y": 3.13,
                  "color": "#c6a43d",
                  "getHHMM": "03:07"
                },
                {
                  "name": "Setting",
                  "y": 0.69,
                  "color": "#FFA500",
                  "getHHMM": "00:41"
                },
                {
                  "name": "Idle No Production",
                  "y": 0.37,
                  "color": "#000",
                  "getHHMM": "00:22"
                },
                {
                  "name": "Productive",
                  "y": 0.86,
                  "color": "#50B432",
                  "getHHMM": "00:51"
                },
                {
                  "name": "Inspection",
                  "y": 0.08,
                  "color": "#ffff00",
                  "getHHMM": "00:04"
                },
                {
                  "name": "Maintenance",
                  "y": 2.67,
                  "color": "#ED561B",
                  "getHHMM": "02:40"
                }
              ]
    }]
  });

},
checkData:function(){
 //tempData.cpsData.changeDateFormat(); 
    var tool = document.getElementById('tool');
    var machine = document.getElementById('machine');
    var overView = document.getElementById('production');

    if(tool.checked){       
      tempData.oeeDash.loadToolProcDrillData('T');  
    }else if(machine.checked){        
      tempData.oeeDash.loadToolProcDrillData('M');  
    }else{          
      tempData.oeeDash.loadToolProcDrillData('P');
    }
},
reload:function(){
  $(".loader").fadeIn("slow");
  tempData.oeeDash.shiftsdata();

  tempData.oeeDash.loadOeeData();
  $(".loader").fadeOut("slow");
}

};



$(document).ready(function() {
debugger; 
//$(".loader").fadeIn("slow");
  $("#companyOEE").parent().addClass('active');
  $("#companyOEE").parent().parent().closest('.treeview').addClass('active menu-open');
  
/*  var today="<?php echo $_GET['selDate']; ?>";
  $('.datepicker-me').datepicker('setDate', today);
*/
var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
$('.datepicker-me').datepicker('setDate', today);

tempData.oeeDash.getEQDesc();
tempData.oeeDash.loadShiftData();  // Load the shift
tempData.oeeDash.reload();  // Load the shift


$('#expandHourlyChart').click(function(e){
    $('#expandHourlyChartScreen').toggleClass('fullscreen'); 
    $('#expandHourlyChartScreen').removeAttr("style");
    $('#expandHourlyChart').toggleClass('fa-expand fa-caret-down'); 
    $('#expandHourlyChartScreen').find('.panel-default').toggleClass('expandAddCssDIV');
    $('#hourlyProduction').toggleClass('expandAddCssGraph');
    operBtn.setSize($('#hourlyProduction').width(), $('#hourlyProduction').height());
});

$('#expandActivityAnalysis').click(function(e){
    $('#activityAnalysisScreen').toggleClass('fullscreen'); 
    $('#activityAnalysisScreen').removeAttr("style");
    $('#expandActivityAnalysis').toggleClass('fa-expand fa-caret-down'); 
    $('#activityAnalysisScreen').find('.panel-default').toggleClass('expandAddCssDIV');
    $('#activityAnalysis').toggleClass('expandAddCssGraph');
    activity.setSize($('#activityAnalysis').width(), $('#activityAnalysis').height());
});

$(".loader").fadeOut("slow");
});

</script>

<input type="hidden" name="comp_id" id="comp_id"/> 
<input type="hidden" name="plant_id" id="plant_id"/> 
<input type="hidden" name="workCenter_id" id="workCenter_id"/> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content  //mainSectionTop-->
    <section class="content">

    <div class="btnsStyle btnsStyleDashboard" id="btns">
      <div class="col-md-5 col-sm-12 col-xs-12 pull-left headerTitle">
       <!--  <a onclick="tempData.oeeDash.visitPlants();">Plants</a> / <a onclick="tempData.oeeDash.visitWorkcenter();">WorkCenter</a> / 
        <a onclick="tempData.oeeDash.visitMachine();">Machine</a> / Name of Machine<br>  -->

          <div class="col-md-4 col-sm-6 col-xs-12" style="padding:0px;">
                <div class="form-group" style="margin-bottom:0px;">
                  <select class="form-control select2"  id="eq_desc" name="eq_desc" 
                  style="width: 100%;padding:0px !important;">
                    <option value="none"> Select Equipment </option>
                  </select>
               <!--  <p style="font-size: 11px;"> As on 24/04/2018 18:00:00 </p> -->
                </div>
          </div>      
      </div>

      <div class="col-md-5 col-sm-12 col-xs-12 pull-right" style="margin-top:7px;">
          

         
        <div class="col-md-1 col-sm-1 col-xs-1 pull-right">
          <button type="button" onclick="tempData.oeeDash.reload();" class="btn btn-sm btn-info"
           style="">   <i class="fa  fa-refresh"> </i>
          </button>
        </div> 

        <div class="col-md-5 col-xs-5 pull-right">  
          <div class='input-group date datepicker-me' data-provide="datepicker">
            <input type='text' class="form-control" id='userDateSel' name="userDateSel" 
                   style="cursor: pointer;" readonly="readonly"/>
              <label class="input-group-addon btn" for="userDateSel">
                  <span class="glyphicon glyphicon-calendar"></span>               
              </label>
          </div>  
        </div>

        <div class="col-md-5 col-xs-5 pull-right">
          <select class="form-control" id="shiftDropdown" style="font-size: 12px; padding: 2px;">
          </select>   <!-- onchange= "tempData.oeeDash.shiftsdata(); -->
        </div> 

     

      </div>      
    </div>

<!-- Plant / Workcenter / Machine -->
<!-- <div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
       <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
          <select class="form-control select2"  id="eq_desc" name="eq_desc" style="width: 100%">
            <option value="none"> Select Equipment </option>
          </select>
        </div>
      </div>
  </div>
</div> -->

<div class="row">
     <!-- OEE -->
    <div class="col-md-3 col-sm-6 col-xs-12">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> OEE
            </div>
            <div class="panel-title pull-right">
              <div id="statusImg"></div>
            </div>
           <!--  <div class="panel-title pull-right">
               <i id="compProfile" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
              </div> -->
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
            <div class="row">
              <div class="col-md-12 col-xs-12 text-center" style="margin-bottom: 3%;">
                <input type="text" class="knob" id="oeePerc" data-skin="tron" data-thickness="0.2" data-width="80" data-height="80" readonly>
              </div>
               
              <div class="col-md-8 col-xs-8">
                <span id="showIobotImg"></span>  
              </div>

              <div class="col-md-12 col-xs-12" style="margin-top: 6%; padding-right: 7px;">
                    <span id="imgTitleInfo" style="font-size: 12px;"></span>
              </div> 
            </div>      
          </div>
        </div>
      </div>
<!-- OEE Ends -->  


 <!-- Availability -->
    <div class="col-md-3 col-sm-6 col-xs-12">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Availability
            </div>         
           <!--  <div class="panel-title pull-right">
               <i id="compProfile" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
              </div> -->
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
            <div class="row">
              <div class="col-md-12 col-xs-12 text-center">
                <input type="text" class="knob" id="availPerc" data-skin="tron" data-thickness="0.2" data-width="80" data-height="80" readonly>
              </div>
               
            <p class="text-center"> Planned Production Time </p>
            <p class="text-center" style="font-size: 25px;margin: -5%;font-weight: bold;color: #013885;"
             id="PlannedProductionTime"></p> 
            
            <div class="col-md-12 col-xs-12" style="margin-top:8%;    padding: 0px;">
                <p class="col-md-7 col-xs-7 availTextRight">Run Time</p>
                <p class="col-md-5 col-xs-5 text-right availTextLeft" id="RunTime"></p>
                <div class="col-md-12 col-xs-12" style="margin-top: -10px; margin-bottom: 4%;">    
                  <div class="progress progress-sm active" style="margin: auto;">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" id="RunTimePerc">
                      <!-- <span class="sr-only">20% Complete</span> -->
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-12 col-xs-12" style="padding: 0px;">
                <p class="col-md-7 col-xs-7 availTextRight">Idle Time</p>
                <p class="col-md-5 col-xs-5 text-right availTextLeft" id="IdleTime"></p>
                <div class="col-md-12 col-xs-12" style="margin-top: -10px; margin-bottom: 4%;">    
                  <div class="progress progress-sm active" style="margin: auto;">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" id="IdleTimePerc">
                      <!-- <span class="sr-only">20% Complete</span> -->
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-12 col-xs-12" style="padding: 0px;">
                <p class="col-md-8 col-xs-8 availTextRight">Breakdown Time</p>
                <p class="col-md-4 col-xs-4 text-right availTextLeft" id="BreakdownTime"></p>
                <div class="col-md-12 col-xs-12" style="margin-top: -10px; margin-bottom: 4%;">    
                  <div class="progress progress-sm active" style="margin: auto;">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" id="BreakdownTimePerc">
                      <!-- <span class="sr-only">20% Complete</span> -->
                    </div>
                  </div>
                </div>
            </div>

            </div>      
          </div>
        </div>
      </div>
<!-- Availability Ends -->  

<!-- Performance -->
    <div class="col-md-3 col-sm-6 col-xs-12">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Performance
            </div>
            <div class="panel-title pull-right">
              <div id="statusImg"></div>
            </div>
           <!--  <div class="panel-title pull-right">
               <i id="compProfile" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
              </div> -->
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
            <div class="row">
              <div class="col-md-12 col-xs-12 text-center">
                <input type="text" class="knob" id="performPerc" data-skin="tron" data-thickness="0.2" data-width="80" data-height="80" readonly>
              </div>

            <div class="col-md-12 col-xs-12" style="padding: 0px;margin-top:5%;">
                <p class="text-center timeFontStyle" id="IdealCycleTime"></p>
                <p class="text-center">Ideal Cycle Time</p>
            </div>


            <div class="col-md-12 col-xs-12" style="padding: 0px;">
                <p class="text-center timeFontStyle" id="AverageTimePart"></p>
                <p class="text-center">Average Time / Part</p>
            </div>


            </div>      
          </div>
        </div>
      </div>
<!-- Performance Ends -->  

<!-- Quality -->
    <div class="col-md-3 col-sm-6 col-xs-12">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Quality
            </div>
           <!--  <div class="panel-title pull-right">
               <i id="compProfile" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
              </div> -->
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
            <div class="row">
              <div class="col-md-12 col-xs-12 text-center">
                <input type="text" class="knob" id="qualityPerc" data-skin="tron" data-thickness="0.2" data-width="80" data-height="80" readonly>
              </div>

            <div class="col-md-12 col-xs-12" style="padding: 0px;margin-bottom: -7%;">
                <p class="col-md-4 col-xs-4 availTextRight">
                  <img src="../common/img/m_dashboard/sum_sigma.png" style="margin-top: 25%;"/> </p>
              <div class="col-md-8 col-xs-8 ">
                <p class="text-right timeFontStyle" id="TotalCount"></p>
                <p class="text-right">Total Count</p>
              </div>
            </div>

            <div class="col-md-12 col-xs-12" style="padding: 0px;margin-bottom: -7%;">
                <p class="col-md-4 col-xs-4 availTextRight">
                  <img src="../common/img/m_dashboard/hand_up.png" style="margin-top: 25%;"/> </p>
              <div class="col-md-8 col-xs-8 ">
                <p class="text-right timeFontStyle" id="OkCount"></p>
                <p class="text-right">OK Count</p>
              </div>
            </div>


            <div class="col-md-12 col-xs-12" style="padding: 0px;">
                <p class="col-md-4 col-xs-4 availTextRight">
                  <img src="../common/img/m_dashboard/hand_down.png" style="margin-top: 25%;"/> </p>
              <div class="col-md-8 col-xs-8 ">
                <p class="text-right timeFontStyle" id="RejectedCount"></p>
                <p class="text-right">Rejected Count</p>
              </div>
            </div>

            </div>      
          </div>
        </div>
      </div>
<!-- Quality Ends --> 


<!-- Activity Progress -->
    <div class="col-md-9 col-sm-12 col-xs-12" id="activityProgressScreen">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Activity Progress
            </div>
              <div class="panel-title pull-right">
              <!--  <i id="compProfile" class="btn btn-xs fa fa-expand" aria-hidden="true"></i> -->
              <button class="btn btn-xs bg-purple btn-flat"><i class="fa fa-file-text-o" aria-hidden="true"></i> &nbsp; Report</button>
              </div>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
              <div class="table-responsive" style="height: 270px;">
                  <!-- <div id="productivity_analysis" style="width: 100%; height: 400px;"></div> -->
<table class="table table-striped col-lg-12 col-md-12 col-sm-12 col-xs-12">
<!--       <thead>
        <tr style="font-size: 13px;background-color: rgba(222, 219, 219, 0.42);">
          <th>Productivity Trend</th>          
          <th style="width:4%;"><span style="color:#50B432">Up</span></th>
          <th style="width:4%;"><span style="color:#ED561B">Down</span></th>  
          <th style="width:4%;"><span style="color:#8c7373">Idle</span></th>  
          <th style="width:4%;"><span style="color:orange">Setting</span></th>          
          <th style="width:1%;"><i class="fa fa-percent pointer" id="showPercent" aria-hidden="true"></i></th>          
         </tr>
      </thead> -->
      <tbody class="productive-analysis"><tr id="TMC-1001">
        <td><div class="progress progressCss" style="margin-bottom: 0px;">
          <div class="progress-bar progress-bar-defalt" style="width:0.1840277777777778%" title="2018-04-27 06:00:00 to 2018-04-27 06:00:53"></div> <div class="progress-bar" style="width:3.75%;background-color:#c6a43d" title="Idle Production - 06:00:53 to 06:18:53"> </div><div class="progress-bar" style="width:8.666666666666666%;background-color:#FFA500" title="Setting - 06:18:53 to 07:00:29"> </div><div class="progress-bar" style="width:0%;background-color:#3248b4" title="Part End - 07:00:29 to 07:00:29"> </div><div class="progress-bar" style="width:0.34375%;background-color:#000" title="Idle No Production - 07:00:29 to 07:02:08"> </div><div class="progress-bar" style="width:0.3645833333333333%;background-color:#50B432" title="Productive - 07:02:08 to 07:03:53"> </div><div class="progress-bar" style="width:0%;background-color:#338abd" title="Part Start - 07:02:08 to 07:02:08"> </div><div class="progress-bar" style="width:1.1250000000000013%;background-color:#50B432" title="Productive - 07:03:53 to 07:09:25"> </div><div class="progress-bar" style="width:0.4097222222222222%;background-color:#c6a43d" title="Idle Production - 07:09:25 to 07:11:23"> </div><div class="progress-bar" style="width:0%;background-color:#50B432" title="Productive - 07:09:25 to 07:09:25"> </div><div class="progress-bar" style="width:0.9375%;background-color:#c6a43d" title="Idle Production - 07:11:23 to 07:15:53"> </div><div class="progress-bar" style="width:0.5381944444444444%;background-color:#ffff00" title="Inspection - 07:15:53 to 07:18:28"> </div><div class="progress-bar" style="width:0%;background-color:#3248b4" title="Part End - 07:18:28 to 07:18:28"> </div><div class="progress-bar" style="width:0.03819444444444445%;background-color:#338abd" title="Part Start - 07:18:29 to 07:18:40"> </div><div class="progress-bar" style="width:0.7152777777777775%;background-color:#50B432" title="Productive - 07:18:40 to 07:22:11"> </div><div class="progress-bar" style="width:2.4375%;background-color:#c6a43d" title="Idle Production - 07:22:11 to 07:33:53"> </div><div class="progress-bar" style="width:0.2708333333333333%;background-color:#3248b4" title="Part End - 07:33:53 to 07:35:11"> </div><div class="progress-bar" style="width:0.3576388888888889%;background-color:#000" title="Idle No Production - 07:35:11 to 07:36:54"> </div><div class="progress-bar" style="width:0.006944444444444444%;background-color:#338abd" title="Part Start - 07:36:54 to 07:36:56"> </div><div class="progress-bar" style="width:0.32638888888888873%;background-color:#50B432" title="Productive - 07:36:56 to 07:38:29"> </div><div class="progress-bar" style="width:0.6006944444444444%;background-color:#c6a43d" title="Idle Production - 07:38:31 to 07:41:24"> </div><div class="progress-bar" style="width:0%;background-color:#50B432" title="Productive - 07:38:31 to 07:38:31"> </div><div class="progress-bar" style="width:2.5%;background-color:#c6a43d" title="Idle Production - 07:41:24 to 07:53:24"> </div><div class="progress-bar" style="width:0.003472222222222222%;background-color:#3248b4" title="Part End - 07:53:24 to 07:53:25"> </div><div class="progress-bar" style="width:0.6215277777777778%;background-color:#000" title="Idle No Production - 07:53:25 to 07:56:24"> </div><div class="progress-bar" style="width:0.059027777777777776%;background-color:#338abd" title="Part Start - 07:56:24 to 07:56:41"> </div><div class="progress-bar" style="width:0.7291666666666663%;background-color:#50B432" title="Productive - 07:56:41 to 08:00:13"> </div><div class="progress-bar" style="width:2.642361111111111%;background-color:#c6a43d" title="Idle Production - 08:00:13 to 08:12:54"> </div><div class="progress-bar" style="width:0.059027777777777776%;background-color:#3248b4" title="Part End - 08:12:54 to 08:13:11"> </div><div class="progress-bar" style="width:0.5659722222222222%;background-color:#000" title="Idle No Production - 08:13:11 to 08:15:54"> </div><div class="progress-bar" style="width:0.020833333333333332%;background-color:#338abd" title="Part Start - 08:15:54 to 08:16:00"> </div><div class="progress-bar" style="width:0.6249999999999998%;background-color:#50B432" title="Productive - 08:16:00 to 08:19:05"> </div><div class="progress-bar" style="width:2.7743055555555554%;background-color:#c6a43d" title="Idle Production - 08:19:05 to 08:32:24"> </div><div class="progress-bar" style="width:0.024305555555555556%;background-color:#3248b4" title="Part End - 08:32:24 to 08:32:31"> </div><div class="progress-bar" style="width:0.6006944444444444%;background-color:#000" title="Idle No Production - 08:32:31 to 08:35:24"> </div><div class="progress-bar" style="width:0.2569444444444444%;background-color:#338abd" title="Part Start - 08:35:24 to 08:36:38"> </div><div class="progress-bar" style="width:0.5868055555555552%;background-color:#50B432" title="Productive - 08:36:38 to 08:39:27"> </div><div class="progress-bar" style="width:0.3958333333333333%;background-color:#c6a43d" title="Idle Production - 08:39:30 to 08:41:24"> </div><div class="progress-bar" style="width:0%;background-color:#50B432" title="Productive - 08:39:30 to 08:39:30"> </div><div class="progress-bar" style="width:1.5590277777777777%;background-color:#c6a43d" title="Idle Production - 08:41:25 to 08:48:54"> </div><div class="progress-bar" style="width:0.3333333333333332%;background-color:#50B432" title="Productive - 08:48:54 to 08:50:29"> </div><div class="progress-bar" style="width:0.4930555555555556%;background-color:#c6a43d" title="Idle Production - 08:50:30 to 08:52:52"> </div><div class="progress-bar" style="width:0.024305555555555556%;background-color:#50B432" title="Productive - 08:52:53 to 08:52:58"> </div><div class="progress-bar" style="width:0.2951388888888889%;background-color:#3248b4" title="Part End - 08:53:00 to 08:54:25"> </div><div class="progress-bar" style="width:0.44791666666666663%;background-color:#ffff00" title="Inspection - 08:54:25 to 08:56:34"> </div><div class="progress-bar" style="width:0%;background-color:#338abd" title="Part Start - 08:56:34 to 08:56:34"> </div><div class="progress-bar" style="width:0.4340277777777777%;background-color:#50B432" title="Productive - 08:56:34 to 08:58:38"> </div><div class="progress-bar" style="width:2.0243055555555554%;background-color:#c6a43d" title="Idle Production - 08:58:41 to 09:08:24"> </div><div class="progress-bar" style="width:0.11111111111111112%;background-color:#50B432" title="Productive - 09:08:24 to 09:08:56"> </div><div class="progress-bar" style="width:0.5138888888888888%;background-color:#c6a43d" title="Idle Production - 09:08:56 to 09:11:24"> </div><div class="progress-bar" style="width:0.21875%;background-color:#50B432" title="Productive - 09:11:24 to 09:12:27"> </div><div class="progress-bar" style="width:0.3402777777777778%;background-color:#c6a43d" title="Idle Production - 09:12:27 to 09:14:05"> </div><div class="progress-bar" style="width:0%;background-color:#50B432" title="Productive - 09:12:27 to 09:12:27"> </div><div class="progress-bar" style="width:0.3784722222222222%;background-color:#000" title="Idle No Production - 09:14:05 to 09:15:54"> </div><div class="progress-bar" style="width:0%;background-color:#3248b4" title="Part End - 09:14:05 to 09:14:05"> </div><div class="progress-bar" style="width:0.0625%;background-color:#338abd" title="Part Start - 09:15:54 to 09:16:12"> </div><div class="progress-bar" style="width:0.3506944444444443%;background-color:#50B432" title="Productive - 09:16:12 to 09:17:54"> </div><div class="progress-bar" style="width:2.7083333333333335%;background-color:#c6a43d" title="Idle Production - 09:17:54 to 09:30:54"> </div><div class="progress-bar" style="width:0.36805555555555547%;background-color:#50B432" title="Productive - 09:30:54 to 09:32:40"> </div><div class="progress-bar" style="width:0.5659722222222222%;background-color:#c6a43d" title="Idle Production - 09:32:41 to 09:35:24"> </div><div class="progress-bar" style="width:0.0763888888888889%;background-color:#3248b4" title="Part End - 09:35:24 to 09:35:46"> </div><div class="progress-bar" style="width:0.4340277777777778%;background-color:#000" title="Idle No Production - 09:35:46 to 09:37:51"> </div><div class="progress-bar" style="width:0%;background-color:#338abd" title="Part Start - 09:37:51 to 09:37:51"> </div><div class="progress-bar" style="width:0.4861111111111111%;background-color:#50B432" title="Productive - 09:37:51 to 09:40:13"> </div><div class="progress-bar" style="width:0.5590277777777778%;background-color:#c6a43d" title="Idle Production - 09:40:13 to 09:42:54"> </div><div class="progress-bar" style="width:0%;background-color:#50B432" title="Productive - 09:40:13 to 09:40:13"> </div><div class="progress-bar" style="width:0.625%;background-color:#c6a43d" title="Idle Production - 09:42:54 to 09:45:54"> </div><div class="progress-bar" style="width:0.26041666666666663%;background-color:#50B432" title="Productive - 09:45:54 to 09:47:09"> </div><div class="progress-bar" style="width:3.1770833333333335%;background-color:#c6a43d" title="Idle Production - 09:47:10 to 10:02:25"> </div><div class="progress-bar" style="width:0.0625%;background-color:#3248b4" title="Part End - 10:02:25 to 10:02:43"> </div><div class="progress-bar" style="width:0.2916666666666667%;background-color:#338abd" title="Part Start - 10:02:43 to 10:04:07"> </div><div class="progress-bar" style="width:1.9409722222222225%;background-color:#50B432" title="Productive - 10:04:07 to 10:13:29"> </div><div class="progress-bar" style="width:0.3472222222222222%;background-color:#c6a43d" title="Idle Production - 10:13:29 to 10:15:09"> </div><div class="progress-bar" style="width:0.3784722222222222%;background-color:#50B432" title="Productive - 10:13:29 to 10:16:58"> </div><div class="progress-bar" style="width:0.40625%;background-color:#c6a43d" title="Idle Production - 10:16:58 to 10:18:55"> </div><div class="progress-bar" style="width:0.6180555555555555%;background-color:#50B432" title="Productive - 10:18:55 to 10:21:54"> </div><div class="progress-bar" style="width:0.9409722222222222%;background-color:#c6a43d" title="Idle Production - 10:21:54 to 10:26:25"> </div><div class="progress-bar" style="width:0.34027777777777773%;background-color:#50B432" title="Productive - 10:26:25 to 10:28:03"> </div><div class="progress-bar" style="width:3.0972222222222223%;background-color:#c6a43d" title="Idle Production - 10:28:03 to 10:42:55"> </div><div class="progress-bar" style="width:0.2638888888888889%;background-color:#3248b4" title="Part End - 10:42:55 to 10:44:11"> </div><div class="progress-bar" style="width:1.2986111111111112%;background-color:#000" title="Idle No Production - 10:44:11 to 10:50:25"> </div><div class="progress-bar" style="width:0.21875%;background-color:#338abd" title="Part Start - 10:50:25 to 10:51:28"> </div><div class="progress-bar" style="width:0.3784722222222222%;background-color:#50B432" title="Productive - 10:51:28 to 10:53:17"> </div><div class="progress-bar" style="width:5.34375%;background-color:#c6a43d" title="Idle Production - 10:53:17 to 11:18:56"> </div><div class="progress-bar" style="width:33.43055555555556%;background-color:#ED561B" title="Maintenance - 11:18:56 to 13:59:27"> </div></div></td>

          <!-- <td><span class="showDetails" style="color:#50B432">01:05 </span><span class="showDetailsPer" style="color:#50B432;display:none;">13.71%</span></td><td><span class="showDetails" style="color:#ED561B">02:40</span><span class="showDetailsPer" style="color:#ED561B;display:none;">33.43%</span></td><td><span class="showDetails" style="color:#8c7373">03:32</span><span class="showDetailsPer" style="color:#8c7373;display:none;">44.19%</span></td><td><span class="showDetails" style="color:orange">00:41</span><span class="showDetailsPer" style="color:orange;display:none;">8.67%</span></td> --></tr></tbody>
      <tbody>
        <tr>
          <td>
            <!-- Utilization Analysis Data Loaded Here -->
            <div class="progress" style="margin-bottom: 0px;" id="timeContentSeries"><div class="progress-bar progress-bar-defalt" style="width:12.5%;border: 1px solid #c0cac0;"> 6h</div><div class="progress-bar progress-bar-defalt" style="width:12.5%;border: 1px solid #c0cac0;"> 7h</div><div class="progress-bar progress-bar-defalt" style="width:12.5%;border: 1px solid #c0cac0;"> 8h</div><div class="progress-bar progress-bar-defalt" style="width:12.5%;border: 1px solid #c0cac0;"> 9h</div><div class="progress-bar progress-bar-defalt" style="width:12.5%;border: 1px solid #c0cac0;"> 10h</div><div class="progress-bar progress-bar-defalt" style="width:12.5%;border: 1px solid #c0cac0;"> 11h</div><div class="progress-bar progress-bar-defalt" style="width:12.5%;border: 1px solid #c0cac0;"> 12h</div><div class="progress-bar progress-bar-defalt" style="width:12.5%;border: 1px solid #c0cac0;"> 13h</div></div>
          </td>  
      </tr>
      <tr class="legent-toggle-tr">
        <td style="text-align:center;font-size: 12px;font-weight: 100;">
        <span id="UtilizationLabel"><label id="labelProductive" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:#50B432; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>Productive</label><label id="labelSetting" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:#FFA500; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>Setting</label><label id="labelInspection" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:#ffff00; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>Inspection</label><label id="labelMaintenance" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:#ED561B; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>Maintenance</label><label id="labelIdleProduction" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:#c6a43d; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>Idle Production</label><label id="labelIdleNoProduction" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:#000; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>Idle No Production</label><br><label id="labelPartEnd" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:#3248b4; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>Part End</label><label id="labelPartStart" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:#338abd; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>Part Start</label></span>       
      </td></tr>
    </tbody>
  </table>
            </div>

          </div>
        </div>
      </div>
<!-- Activity Progress Ends --> 


<!-- Activity Analysis -->
    <div class="col-md-3 col-sm-6 col-xs-12" id="activityAnalysisScreen">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Activity Analysis
            </div>
            <div class="panel-title pull-right">
              <div id="statusImg"></div>
            </div>
              <div class="panel-title pull-right">
               <i id="expandActivityAnalysis" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
              </div> 
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
            <div class="row">              
                <!-- Load Activity Analysis pie Chart --> 
                <div id="activityAnalysis" style="width:99%;height:270px;"></div>
            </div> 
          </div>
        </div>
      </div>
<!-- Activity Analysis Ends -->  

<!-- Hourly Production -->
    <div class="col-md-9 col-sm-12 col-xs-12" id="expandHourlyChartScreen">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Hourly Production
            </div>
              <div class="panel-title pull-right">
                <label> <input type="radio" class="" name="order"  id="machine"  
                  onclick="tempData.oeeDash.checkData();" checked> Machine </label>&nbsp;&nbsp;
                <label> <input type="radio" class="" name="order" id="production" 
                  onclick= "tempData.oeeDash.checkData();"> Production </label>&nbsp;&nbsp;
                <label> <input type="radio" class="" name="order" id="tool" 
                  onclick= "tempData.oeeDash.checkData();"> Tool </label>

               <i id="expandHourlyChart" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
              </div> 
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
            <div class="table-responsive">
                <!-- Load Machine & Production Order Chart --> <!-- class="widthClass"  -->
                <div id="hourlyProduction" style="width:99%;height:270px;"></div>           

            </div>      
          </div>
        </div>
      </div>
<!-- Hourly Production Ends --> 


<!-- Shift Details -->
    <div class="col-md-3 col-sm-6 col-xs-12" id="expandShiftDetailsScreen">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Shift Details
            </div>
            <div class="panel-title pull-right">
              <div id="statusImg"></div>
            </div>
              <!-- <div class="panel-title pull-right">
               <i id="expandShiftDetails" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
              </div>  -->
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
            <div class="row">              
              <div class="col-md-12 col-xs-12" style="padding: 0px;">              
                  <p class="text-center">Total Production Period</p>
                  <p class="text-center shiftDetailsTime">06:00 - 14:00</p>
              </div>
              <div class="col-md-12 col-xs-12" style="padding: 0px;">              
                  <p class="text-center">Long Break</p>
                  <p class="text-center shiftDetailsTime">10:00 - 10:30</p>
              </div>
              <div class="col-md-12 col-xs-12" style="padding: 0px;">              
                  <p class="text-center">Short Break - 01</p>
                  <p class="text-center shiftDetailsTime">08:00 - 08:15</p>
              </div>
              <div class="col-md-12 col-xs-12" style="padding: 0px;">              
                  <p class="text-center">Short Break - 02</p>
                  <p class="text-center shiftDetailsTime">12:00 - 12:15</p>
              </div>
            </div> 

          </div>
        </div>
      </div>
<!-- Shift Details Ends -->  



    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php //include('../common/footer.php'); ?>
  <!-- <div class="control-sidebar-bg"></div> -->
</div>
<!-- ./wrapper -->

</body>
</html>
