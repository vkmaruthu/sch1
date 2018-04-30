<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>


<!-- Highchart JS and CSS -->
<script src="../common/highchart/highcharts.js"></script>
<script src="../common/highchart/modules/data.js"></script>
<script src="../common/highchart/modules/drilldown.js"></script>

<script src="../common/highchart/highcharts-more.js"></script>
<script src="../common/highchart/solid-gauge.js"></script>
<script src="../common/highchart/bullet.js"></script>

<script type="text/javascript">
/* highchart variable */
var operBtn=null;

/* Shift Variables */
var Ghours=null;  
var GinTime=null;   
var GoutTime=null; 
var GtotalHour=null;  
var GstartHour=null;
var ShiftGobalData=null;

var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}
  
tempData.oeeDash=
{
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
getImg:function() {  
debugger;
    var dataSet;
    dataSet='<label class="pointer toggle-reason-bar pull-right" style="margin-right:10px;"> Productive <i style="background-color: green; width:10px;height: 10px; display:inline-block;"></i></label>';

        $("#imgTitleInfo").html(dataSet);
        $("#showIobotImg").html('<img src="../common/img/machine/default.png" class="img-thumbnail dashMachineImg"/>');
        $("#statusImg").html('<img src="../common/img/online.png" class="img-responsive statusImg"/>');
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

/*    var comp_id=$('#comp_id').val();
    var plant_id=$('#plant_id').val();
    var workCenter_id=$('#workCenter_id').val();
    var iobotMachine= $('#iobotMachine').val();
*/
    var comp_id=1;
    var plant_id=1;
    var workCenter_id=1;
    var iobotMachine=1;

    var myData = {loadShiftData:'loadShiftData',selDate:selDate,plant_id:plant_id,comp_id:comp_id,plant_id:plant_id,workCenter_id:workCenter_id,iobotMachine:iobotMachine };

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
                        $("#shiftDropdown").append('<option value="'+obj.shiftData[i].id+'"> All Shift '+obj.shiftData[i].dateFormat+'</option>'); 
                      }
                  }
                } 
              }else{
                $("#shiftDropdown").html('<option value="default">Default Shift</option>');
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
      Ghours=90200;  GinTime='00:00:00';   GoutTime='23:59:59';  GtotalHour=24;  GstartHour=0;
/*      tempData.oeeDash.loadEventGraph(Ghours,GinTime,GoutTime,GtotalHour,GstartHour);
      tempData.oeeDash.loadgraph_productivity_analysis1('00:00:00','23:59:59');*/
      tempData.oeeDash.checkData();
    }else{
      var singalJosn=tempData.oeeDash.getObjects(ShiftGobalData,'id',shift);
      var get3Data= tempData.oeeDash.getCommonDataForShift(singalJosn[0]); // Passing all Selected Shift Data
      // hours,inTime,outTime,totalHour,startHour
      tempData.oeeDash.AfterShiftSelect(get3Data[0].hour,get3Data[0].inTime,get3Data[0].outTime,parseInt(singalJosn[0].num_hours),get3Data[0].startHour);
      
    }
  },
  AfterShiftSelect:function(hours,inTime,outTime,totalHour,startHour){
        // hours,inTime,outTime,totalHour,startHour
        Ghours=hours;  GinTime=inTime;   GoutTime=outTime;  GtotalHour=totalHour;  GstartHour=startHour;

/*        tempData.oeeDash.loadEventGraph(hours,inTime,outTime,totalHour,startHour); 
        tempData.oeeDash.loadgraph_productivity_analysis1(inTime,outTime); //inTime,outTime*/
        tempData.oeeDash.checkData();
  },
   getObjects:function(obj, key, val) {  // JSON Search function
    debugger;
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(tempData.cpsData.getObjects(obj[i], key, val));
        } else if (i == key && obj[key] == val) {
            objects.push(obj);
        }
    }
    return objects;    
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
        text: 'Hourly Production'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Parts / PO'
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
        data: [
                {
                  "id": "900010055",
                  "y": 5,
                  "name": "8000500028 / MEGA-223-P01 (TC1)",
                  "drilldown": "900010055"
                }
              ]
    }],
    drilldown: {
        series: [
                  {
                    "name": "8000500028",
                    "id": "900010055",
                    "data": [
                      [
                        "6h",
                        0
                      ],
                      [
                        "7h",
                        0
                      ],
                      [
                        "8h",
                        1
                      ],
                      [
                        "9h",
                        2
                      ],
                      [
                        "10h",
                        2
                      ],
                      [
                        "11h",
                        0
                      ],
                      [
                        "12h",
                        0
                      ],
                      [
                        "13h",
                        0
                      ]
                    ]
                  }
                ]
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
          categories:[
                        "6h",
                        "7h",
                        "8h",
                        "9h",
                        "10h",
                        "11h",
                        "12h",
                        "13h"
                      ],
          crosshair: true
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Parts'
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
      series:[
                {
                  "name": "TMC-1001",
                  "data": [
                    [
                      "6h",
                      0
                    ],
                    [
                      "7h",
                      0
                    ],
                    [
                      "8h",
                      0
                    ],
                    2,
                    2,
                    [
                      "11h",
                      0
                    ],
                    [
                      "12h",
                      0
                    ],
                    [
                      "13h",
                      0
                    ]
                  ]
                }
              ]
      //[{"name":"TOOL12","data":[33,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,11]}]
  });
},
checkData:function(){
 //tempData.cpsData.changeDateFormat(); 
    var tool = document.getElementById('tool');
    var machine = document.getElementById('machine');
    var overView = document.getElementById('production');

    if(tool.checked){       
      tempData.oeeDash.loadToolHourlyDrilldown(); 
    }else if(machine.checked){        
      tempData.oeeDash.loadMachineHourly();
    }else{
      $('#hourlyProduction').html('<h3> Under development </h3>');
    }
},

};



$(document).ready(function() {
debugger; 


 $("#companyOEE").parent().addClass('active');
 $("#companyOEE").parent().parent().closest('.treeview').addClass('active menu-open');
 
var today="<?php echo $_GET['selDate']; ?>";
$('.datepicker-me').datepicker('setDate', today);

tempData.oeeDash.getImg();
tempData.oeeDash.oeeCirclePerc('oeePerc',75,'#E29C21');
tempData.oeeDash.oeeCirclePerc('availPerc',40,'#FDCA6C');
tempData.oeeDash.oeeCirclePerc('performPerc',20,'#DB4F31');
tempData.oeeDash.oeeCirclePerc('qualityPerc',90,'#1AD34E');
tempData.oeeDash.loadShiftData();

$('#activityProgressDetails').click(function(e){
    $('#activityProgressScreen').toggleClass('fullscreen'); 
    $('#activityProgressScreen').removeAttr("style");
    $('#activityProgress').toggleClass('fa-expand fa-caret-down'); 
    $('#activityProgressScreen').find('.panel-default').toggleClass('expandAddCssDIV');
    $('#activityProgressScreen').find('.panel-heading').toggleClass('topNavheight');
     // tempData.oeeDash.loadOnExpand();
});

$('#expandHourlyChart').click(function(e){
    $('#expandHourlyChartScreen').toggleClass('fullscreen'); 
    $('#expandHourlyChartScreen').removeAttr("style");
    $('#expandHourlyChart').toggleClass('fa-expand fa-caret-down'); 
    $('#expandHourlyChartScreen').find('.panel-default').toggleClass('expandAddCssDIV');
    $('#hourlyProduction').toggleClass('expandAddCssGraph');
    operBtn.setSize($('#hourlyProduction').width(), $('#hourlyProduction').height());
      //tempData.cpsData.loadOnExpand();
});



});

</script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

    <div class="btnsStyle btnsStyleDashboard" id="btns">
      <div class="col-md-5 col-sm-12 col-xs-12 pull-left headerTitle">
        <a onclick="tempData.oeeDash.visitPlants();">Plants</a> / <a onclick="tempData.oeeDash.visitWorkcenter();">WorkCenter</a> / 
        <a onclick="tempData.oeeDash.visitMachine();">Machine</a> / Name of Machine<br> 
      <p style="font-size: 11px;">As on 24/04/2018 18:00:00 </p>
      </div>

      <div class="col-md-5 col-sm-12 col-xs-12 pull-right" style="margin-top:5px;">
          
          <div class="col-md-6 col-xs-5">
            <select class="form-control" id="shiftDropdown" style="font-size: 12px; padding: 2px;"
             onchange= "tempData.oeeDash.shiftsdata();">
            </select>   
          </div>  
        
        <div class="col-md-6 col-xs-7 pull-right">  
          <div class='input-group date datepicker-me' data-provide="datepicker">
            <input type='text' class="form-control" id='userDateSel' name="userDateSel"  onchange=""
            style="cursor: pointer;" readonly="readonly"/>
              <label class="input-group-addon btn" for="userDateSel">
                  <span class="glyphicon glyphicon-calendar"></span>               
              </label>
          </div>  
        </div>
      </div>      
    </div>

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
            <p class="text-center" style="font-size: 25px;margin: -5%;font-weight: bold;color: #013885;">07:00</p> 
            
            <div class="col-md-12 col-xs-12" style="margin-top:8%;    padding: 0px;">
                <p class="col-md-7 col-xs-7 availTextRight">Run Time</p>
                <p class="col-md-5 col-xs-5 text-right availTextLeft">04:17</p>
                <div class="col-md-12 col-xs-12" style="margin-top: -10px; margin-bottom: 4%;">    
                  <div class="progress progress-sm active" style="margin: auto;">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-12 col-xs-12" style="padding: 0px;">
                <p class="col-md-7 col-xs-7 availTextRight">Idle Time</p>
                <p class="col-md-5 col-xs-5 text-right availTextLeft">01:33</p>
                <div class="col-md-12 col-xs-12" style="margin-top: -10px; margin-bottom: 4%;">    
                  <div class="progress progress-sm active" style="margin: auto;">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 22%">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-12 col-xs-12" style="padding: 0px;">
                <p class="col-md-8 col-xs-8 availTextRight">Breakdown Time</p>
                <p class="col-md-4 col-xs-4 text-right availTextLeft">01:15</p>
                <div class="col-md-12 col-xs-12" style="margin-top: -10px; margin-bottom: 4%;">    
                  <div class="progress progress-sm active" style="margin: auto;">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 55%">
                      <span class="sr-only">20% Complete</span>
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
                <p class="text-center timeFontStyle">04:12:01</p>
                <p class="text-center">Ideal Cycle Time</p>
            </div>


            <div class="col-md-12 col-xs-12" style="padding: 0px;">
                <p class="text-center timeFontStyle">04:12:01</p>
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
                <p class="text-right timeFontStyle">10,854</p>
                <p class="text-right">Total Count</p>
              </div>
            </div>

            <div class="col-md-12 col-xs-12" style="padding: 0px;margin-bottom: -7%;">
                <p class="col-md-4 col-xs-4 availTextRight">
                  <img src="../common/img/m_dashboard/hand_up.png" style="margin-top: 25%;"/> </p>
              <div class="col-md-8 col-xs-8 ">
                <p class="text-right timeFontStyle">9,854</p>
                <p class="text-right">OK Count</p>
              </div>
            </div>


            <div class="col-md-12 col-xs-12" style="padding: 0px;">
                <p class="col-md-4 col-xs-4 availTextRight">
                  <img src="../common/img/m_dashboard/hand_down.png" style="margin-top: 25%;"/> </p>
              <div class="col-md-8 col-xs-8 ">
                <p class="text-right timeFontStyle">949</p>
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
            <div class="row">
                <!-- Load Machine & Production Order Chart --> <!-- class="widthClass"  -->
                <div id="hourlyProduction" style="width:100%;height:270px;border: 1px solid;"></div>           

            </div>      
          </div>
        </div>
      </div>
<!-- Activity Progress Ends --> 


<!-- Activity Analysis -->
    <div class="col-md-3 col-sm-6 col-xs-12">  
        <div class="panel panel-default dashFirstRow">
          <div class="panel-heading panelHeader">
            <div class="panel-title pull-left">
              <i class="fa fa-sliders fa-fw"></i> Activity Analysis
            </div>
            <div class="panel-title pull-right">
              <div id="statusImg"></div>
            </div>
              <div class="panel-title pull-right">
               <i id="compProfile" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
              </div> 
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">  
            <div class="row">              
                <!-- Load Activity Analysis pie Chart --> 
                <div id="activityAnalysis" style="width:100%;height:270px;border: 1px solid;"></div>   
            </div> 

          </div>
        </div>
      </div>
<!-- Activity Analysis Ends -->  

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
