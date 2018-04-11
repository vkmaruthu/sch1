<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
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

};



$(document).ready(function() {
debugger; 
  $('.knob').knob();

tempData.oeeDash.getImg();
tempData.oeeDash.oeeCirclePerc('oeePerc',75,'#E29C21');
tempData.oeeDash.oeeCirclePerc('availPerc',40,'#FDCA6C');
tempData.oeeDash.oeeCirclePerc('performPerc',20,'#DB4F31');
tempData.oeeDash.oeeCirclePerc('qualityPerc',90,'#1AD34E');


$('#compProfile').click(function(e){
    $('#compProfileScreen').toggleClass('fullscreen'); 
    $('#compProfileScreen').removeAttr("style");
    $('#compProfile').toggleClass('fa-expand fa-caret-down'); 
    $('#compProfileScreen').find('.panel-default').toggleClass('expandAddCssDIV');
    $('#compProfileScreen').find('.panel-heading').toggleClass('topNavheight');
     // tempData.cpsData.loadOnExpand();
});


});

</script>


 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

    <div class="btnsStyle btnsStyleDashboard" id="btns">
      <div class="col-md-5 col-sm-12 col-xs-12 pull-left headerTitle">
        <a href="../plants">Plants</a> / <a href="../workcenter">WorkCenter</a> / <a href="../machine">Machine</a> / Name of Machine<br> 
      <p style="font-size: 11px;">As on 24/04/2018 18:00:00 </p>
      </div>

      <div class="col-md-5 col-sm-12 col-xs-12 pull-right" style="margin-top:5px;">
          
          <div class="col-md-6 col-xs-5">
            <select class="form-control" id="shiftDropdown" style="font-size: 12px; padding: 2px;"
             onchange= "tempData.cpsData.shiftsdata();">
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
                <p class="col-md-7 col-xs-7 availTextRight">Breakdown Time</p>
                <p class="col-md-5 col-xs-5 text-right availTextLeft">01:15</p>
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
               
          <!--   <div class="col-md-12 col-xs-12" style="padding: 0px;margin-top:5%;">
                <p class="text-right timeFontStyle">04:12:01</p>
                <p class="text-right">Ideal Cycle Time</p>
            </div> -->

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
