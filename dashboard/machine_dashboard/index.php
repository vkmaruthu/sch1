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

.progress-bar.progress-bar-defalt {
    background-color: #e2e4e2;
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

/* Event Chart*/
var globalUtilizationData=null;

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
          
          equipGobalData=obj.equipmentDetails;

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
              if(obj.oeeDetails !=null){

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

            }else{

              tempData.oeeDash.getImg("default.png",'',0,"#FFFFFF");
              tempData.oeeDash.oeeCirclePerc('oeePerc',0,"#000000");
              tempData.oeeDash.oeeCirclePerc('availPerc',0,"#000000");
              tempData.oeeDash.oeeCirclePerc('performPerc',0,"#000000");
              tempData.oeeDash.oeeCirclePerc('qualityPerc',0,"#000000");
              $('#PlannedProductionTime').html('00:00:00');
              $('#RunTime').html("00:00:00");
              $('#RunTimePerc').css("width",parseInt(0));
              $('#IdleTime').html("00:00:00");
              $('#IdleTimePerc').css("width",parseInt(0));
              $('#BreakdownTime').html("00:00:00");
              $('#BreakdownTimePerc').css("width",parseInt(0));
              $('#IdealCycleTime').html("00:00:00");
              $('#AverageTimePart').html("00:00:00");
              $('#TotalCount').html(tempData.oeeDash.NumFormat(parseInt(0)));
              $('#OkCount').html(tempData.oeeDash.NumFormat(parseInt(0)));
              $('#RejectedCount').html(tempData.oeeDash.NumFormat(parseInt(0)));
              
            }

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

  var eq=$('#eq_desc').val();
  var data = tempData.oeeDash.getObjects(equipGobalData,'id',eq);
  console.log(data);
  $('#plant_id').val(data[0].plant_id);  
  

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
              
              //tempData.oeeDash.shiftsdata();                                     
            }
        });
},   
shiftDetails:function(obj){
  $('#productionPeriod').html(tempData.oeeDash.getOnlyTime(obj.in_time)+' - '+tempData.oeeDash.getOnlyTime(obj.out_time));
  $('#longBreak').html(tempData.oeeDash.getOnlyTime(obj.lbreak_startTime)+' - '+tempData.oeeDash.getOnlyTime(obj.lbreak_endTime));
  $('#ShortBreak1').html(tempData.oeeDash.getOnlyTime(obj.break1_startTime)+' - '+tempData.oeeDash.getOnlyTime(obj.break1_endTime));
  $('#ShortBreak2').html(tempData.oeeDash.getOnlyTime(obj.break2_startTime)+' - '+tempData.oeeDash.getOnlyTime(obj.break2_endTime));
},
getOnlyTime:function(time){
  var val;

  if(time!=''){
    var onlyTime = time.split(' ');
    val = onlyTime[1].slice(0, -3);
  }else{
    val= "00:00"
  }
  return val;
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
    return tempData.oeeDash.addZero(d.getHours()) + ':'+tempData.oeeDash.addZero(d.getMinutes()) + ':' + tempData.oeeDash.addZero(d.getSeconds());
},
addZero:function(num) {
    if(num < 10) {
        num = "0"+num;
    }
    return num;
},
getCommonDataForShift:function(obj){
  var arr=[];
  var hours = parseInt(obj.num_hourss)*60*60;
  var inTime = tempData.oeeDash.convertTimeWithOutOneSec(obj.in_time);
  var outTime = tempData.oeeDash.convertTime(obj.out_time);
  var d = new Date(obj.in_time);
    arr.push({"hour":hours,"inTime":inTime,"outTime":outTime,"startHour":d.getHours()});
    return arr;
},
shiftsdata:function(){
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
      
      tempData.oeeDash.shiftDetails(singalJosn[0]);
      
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
},
getObjects:function(obj, key, val) {  // JSON Search function
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
  // Ghours=90200;  GinTime='00:00:00';   GoutTime='23:59:59';  GtotalHour=24;  GstartHour=0; GdbStartHour=fromShift
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
operBtn = Highcharts.chart('hourlyProduction', {
  lang: {
        drillUpText: '<',
    },
    chart: {
        type: 'column',
        events: {
                drillup: function (e) {
                  //alert();
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
                  //alert(); 
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
  });
},
getActivityAnalysis:function(){
  // Ghours=90200;  GinTime='00:00:00';   GoutTime='23:59:59';  GtotalHour=24;  GstartHour=0; GdbStartHour=fromShift
    var selDate = $("#userDateSel").val();
    var url= "getDataController.php";

    var comp_id=$('#comp_id').val();
    var plant_id=$('#plant_id').val();
    var workCenter_id=$('#workCenter_id').val();
    var iobotMachine= $('#eq_desc').val();  
    var shift= $('#shiftDropdown').val();

    var myData = {getActivityAnalysis:'getActivityAnalysis', selDate:selDate, comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine,total_hours:GtotalHour,start_hour:GstartHour,shift:shift,sTime:GinTime,eTime:GoutTime};
    var msg="";

    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        if(obj.analysisData !=null){
          msg=""
          tempData.oeeDash.activityAnalysisChat(obj,msg);
        }else{
          msg=" Data Not Available"
          tempData.oeeDash.activityAnalysisChat(obj,msg);
        }
          
      } 
    });
},
activityAnalysisChat:function(obj,msg){ // pie chart
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
        data:obj.analysisData
          
    }]
  });
},
getActivityProgress:function(){ // bar chart
  // Ghours=90200;  GinTime='00:00:00';   GoutTime='23:59:59';  GtotalHour=24;  GstartHour=0; GdbStartHour=fromShift
    var selDate = $("#userDateSel").val();
    var url= "getDataController.php";

    var comp_id=$('#comp_id').val();
    var plant_id=$('#plant_id').val();
    var workCenter_id=$('#workCenter_id').val();
    var iobotMachine= $('#eq_desc').val();  
    var shift= $('#shiftDropdown').val();

    var myData = {getActivityProgress:'getActivityProgress', selDate:selDate, comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine,total_hours:GtotalHour,start_hour:GstartHour,shift:shift,sTime:GinTime,eTime:GoutTime};
    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      data:myData,
      success: function(obj) {
        //alert();
debugger;
    globalUtilizationData=obj.activityData;

/* Bulding progressBar Time Series */  //totalHour:GtotalHour,startHour:GstartHour
    var totalHour=GtotalHour;
    var startHour=GstartHour;
    var timeContent='';
    var widthPer=100/totalHour;
    var jk=0;

    for(var ii=0;ii<totalHour;ii++){
      var startHourTime=(startHour+ii);
        if(startHourTime>=24){
          startHourTime=jk; 
          jk=jk+1;
        }
       timeContent+='<div class="progress-bar progress-bar-defalt" style="width:'+widthPer+'%;color:#000000;border: 1px solid #c0cac0;"> '+startHourTime+'h</div>';
    }
    $('#timeContentSeries').html(timeContent);


/* Bulding progressBar */
  if(obj.activityData ==null){
    $('#UtilizationLabel').html('');
    $('.productive-analysis').html('');
    $('.productive-analysis').html('<div class="progress" style="margin-bottom: 0px;"><div class="progress-bar progress-bar-defalt" style="width:100%"></div></div>');
    $('#UtilizationLabel').html('<center><p> Data Not Available !! <p></center>');
  }else{

    var labelContent='';
    var divData='';
    var stTime='';
    var enTime='';
    var status=1;

for(var q=0;q<obj.reasonCode.length;q++){ 
   /* Bulding UtilizationLabel */
   labelContent+='<label id="label'+obj.reasonCode[q].message.replace(/\s/g, "")+'" class="pointer toggle-reason-bar" dataid="progress-bar-success" style="margin-right:10px;"><i style="background-color:'+obj.reasonCode[q].color_code+'; width:10px;height: 10px; display:inline-block; margin-right:5px;"></i>'+obj.reasonCode[q].message+'</label>';
   if(q==5){
    labelContent+='<br>';
   }
}


for(var q=0;q<obj.activityData.length;q++){        // Main Loop

  /* Formatting Date Time dd/mm/yyyy hh:mm:ss */
  var stTime = tempData.oeeDash.dbDateTimeSeparate(obj.activityData[q].start_time);
  var enTime = tempData.oeeDash.dbDateTimeSeparate(obj.activityData[q].end_time);
  
  var selDate = $("#userDateSel").val().split('/')
  selDateF=selDate[2]+'-'+selDate[1]+'-'+selDate[0];

  var selDate2 = (stTime.date).split('/')
  selDateF2=selDate2[2]+'-'+selDate2[1]+'-'+selDate2[0];

  var d1 = selDateF+" "+GinTime;
  var d2 = selDateF2+" "+stTime.time;

  var uiStDate = new Date(d1); //yyyy-mm-dd
  var dbStDate = new Date(d2); 
  debugger;
  if(status==1){
    if(uiStDate<dbStDate){
     divData+=tempData.oeeDash.insertBlankEvent(d1,d2); 
    }
    status=0;
  }   
 // 


  /* Bulding main progress bar */    
  var widthVal=tempData.oeeDash.getRation(parseInt(obj.activityData[q].duration));
  divData+='<div class="progress-bar" style="width:'+parseFloat(widthVal)+'%;background-color:'+obj.activityData[q].color_code+'" title="'+obj.activityData[q].message+' - '+stTime.time+' to '+enTime.time+'"> </div>';

} // end of FOR LOOP

  var finalDiv='<div class="progress" style="margin-bottom: 0px;height:30px;">'+divData+'</div>';
    $('#UtilizationLabel').html(labelContent);
    $('.productive-analysis').html(finalDiv);

  } // else ends 

       } 
    });
},
insertBlankEvent:function(startT,EndT){
  debugger;
  var defaultTime= tempData.oeeDash.getRation(tempData.oeeDash.timeDiff(startT,EndT));
  return '<div class="progress-bar progress-bar-defalt" style="width:'+parseFloat(defaultTime) +'%"></div>';
}, 
getRation:function(t){
  debugger;
  var e=GtotalHour*3600;
  var per = (100 * t) / e;
  return per;
},
timeDiff:function(time1,time2){
  t1=new Date(time1);
  t2=new Date(time2);
  var dif = t1-t2;
  var finalVal =Math.abs((t1-t2)/1000);
  return finalVal;
},
dbDateTimeSeparate:function(time){
  debugger;
  var dateTimeArr = new Array();

  var dateTime = time.split(' ');
  var onlyDate=dateTime[0].split('-');
  var date=onlyDate[2]+'/'+onlyDate[1]+'/'+onlyDate[0]

  dateTimeArr['date']=date;
  dateTimeArr['time']=dateTime[1];
  return dateTimeArr;
},
checkData:function(){
 //tempData.oeeDash.changeDateFormat(); 
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

  tempData.oeeDash.getActivityProgress();
  tempData.oeeDash.getActivityAnalysis();
  tempData.oeeDash.checkData();
  $(".loader").fadeOut("slow");
},
loadUtilizationReport:function(){
    debugger
    $('#loadUtilizationReport').modal({show:true});
      setTimeout(function(){
         tempData.oeeDash.loadUtilizationReportPopData(); 
      }, 200);
},
loadUtilizationReportPopData:function(){
    debugger
    $('#loadUtilizationReportTable').hide();
    $('#table_disGraph7').show();

/*        $.ajax({
            type:"POST",
            url:"loadData.json",
            async: false,
            dataType: 'json',
            success: function(obj){*/
              //debugger;

              $('#loadUtilizationReportTable').show();
              $('#table_disGraph7').hide();

   var DataTableProject = $('#loadUtilizationReportTable').DataTable( {
            "paging":false,
            "ordering":true,
            "info":true,
            "searching":true,         
            "destroy":true,
            "scrollX": true,
            "scrollY": 350,
            "data":globalUtilizationData,   
            "columns": [
              {data:null,"SlNo":false,className: "text-center"},
              { data: "start_time",
                render: function (data, type, row, meta) {
                    return tempData.oeeDash.getDateFormate(row.start_time);
                }
              },             
              { data: "end_time",
                render: function (data, type, row, meta) {
                    return tempData.oeeDash.getDateFormate(row.end_time);
                }
              },
              { data: null,"duration":false,className: "text-right",
                render: function (data, type, row, meta) {
                    return tempData.oeeDash.getDiffHourMin(row.start_time,row.end_time);
                }
              }, 
              { data: "message",
                render: function (data, type, row, meta) {
                    return '<span style=color:'+row.color_code+';font-weight:bold;>'+row.message+'</sanp>';
                }
              }          
            ]
           });   
        DataTableProject.on( 'order.dt search.dt', function () {
          DataTableProject.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                  cell.innerHTML = i+1;
              } );
          } ).draw(); 
},
getDateFormate:function(date){
  debugger;
  var dt=date.split(' ');
  var onlyDate=dt[0].split('-');
  return onlyDate[2]+'-'+onlyDate[1]+'-'+onlyDate[0]+'  '+dt[1];
},
getDiffHourMin:function(startDate,endDate){
  var startDate = new Date(startDate);
  var endDate = new Date(endDate);
  var difference = Math.abs(startDate.getTime() - endDate.getTime())/1000;
  var hourDifference = parseInt(difference / 3600);
  var minDiff = parseInt(Math.abs(difference / 60) % 60);
  var secDiff = (difference % 60);

  return tempData.oeeDash.addZero(hourDifference)+':'+tempData.oeeDash.addZero(minDiff)+':'+tempData.oeeDash.addZero(secDiff);
},
/*setPalnt:function(this){
  console.log(this.value);
  $('#plant_id').val();  
}*/
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

$("#btnExport1").click(function(e) {
    $('#loadUtilizationReportTable').table2excel();
}); 

$('#eq_desc').change(function() {
  tempData.oeeDash.loadShiftData();  // Load the shift
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


<!-- Activity Analysis -->
    <div class="col-md-3 col-sm-6 col-xs-12" id="activityAnalysisScreen">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Activity Analysis (hh:mm)
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



<!-- Activity Progress -->
    <div class="col-md-9 col-sm-12 col-xs-12" id="activityProgressScreen">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Activity Progress
            </div>
              <div class="panel-title pull-right">
              <!--  <i id="compProfile" class="btn btn-xs fa fa-expand" aria-hidden="true"></i> -->
              <button class="btn btn-xs bg-purple btn-flat" onclick="tempData.oeeDash.loadUtilizationReport();"><i class="fa fa-file-text-o" aria-hidden="true"></i> &nbsp; Report</button>
              </div>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
              <div class="table-responsive" style="height: 270px;">
                  <!-- <div id="productivity_analysis" style="width: 100%; height: 400px;"></div> -->
                  <br>
<table class="table table-striped col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <!-- <tbody class="productive-analysis"> -->
      <tbody>
        <tr>
          <td style="padding: 0px !important;">
            <!-- productive-analysis Progress Chart here -->      
            <div class="productive-analysis"></div>
            <!-- Utilization Analysis Data Loaded Here -->
            <div class="progress" style="margin-bottom: 0px;" id="timeContentSeries"></div>
          </td>  
      </tr>
      <tr class="legent-toggle-tr">
        <td style="text-align:center;font-size: 12px;font-weight: 100;">
        <span id="UtilizationLabel"></span>       
      </td></tr>
    </tbody>
  </table>
            </div>

          </div>
        </div>
      </div>
<!-- Activity Progress Ends --> 



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
                  <p class="text-center shiftDetailsTime" id="productionPeriod"></p>
              </div>
              <div class="col-md-12 col-xs-12" style="padding: 0px;">              
                  <p class="text-center">Long Break</p>
                  <p class="text-center shiftDetailsTime" id="longBreak"></p>
              </div>
              <div class="col-md-12 col-xs-12" style="padding: 0px;">              
                  <p class="text-center">Short Break - 01</p>
                  <p class="text-center shiftDetailsTime" id="ShortBreak1"></p>
              </div>
              <div class="col-md-12 col-xs-12" style="padding: 0px;">              
                  <p class="text-center">Short Break - 02</p>
                  <p class="text-center shiftDetailsTime" id="ShortBreak2"></p>
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



<!-- Load load Utilization Report -->
<div id="loadUtilizationReport" class="modal fade"  role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:90%;">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-list-alt" aria-hidden="true"></i> Utilization Report :  <span id="ShiftLabel"></span></h4>
            </div>
            <div class="modal-body">
              <div id="moreInfoBody">              

                  <div class="table-responsive">
                    <button type="button" id="btnExport1" class="btn btn-success btn-sm pull-left">
                      <i class="glyphicon glyphicon-save"></i> Export
                    </button>

                  <div id="table_disGraph7" style="text-align: center;">
                       <i class="fa fa-refresh fa-spin" style="font-size:35px"></i>
                  </div>

                    <!-- <span class="pull-right"> <b>* Time in (hh:mm:ss) </b> </span> -->
                       <table id="loadUtilizationReportTable" class="table table-hover table-bordered table-responsive" style="width:100%">
                           <thead>
                            <tr>
                              <th style="width: 10%;">Sl No</th>
                              <th>Start Time <!-- <SUB>(yyyy-mm-dd)</SUB> --></th>
                              <th>End Time <!-- <SUB>(yyyy-mm-dd)</SUB> --> </th>                               
                              <th>Duration <!-- <SUB>(hh:mm:ss)</SUB> --></th>                               
                              <th style="width: 30%;">Reason</th>                         
                            </tr>
                            </thead>
                        </table>
                    </div>          


              </div>
            
            </div>
            <div class="modal-footer" style="border-top:none;">
               
            </div>
    </div>
  </div>
</div> 


</body>
</html>
