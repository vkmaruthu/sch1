<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}
  
tempData.oeework=
{
  generateTile:function(id,val,fgColor) {  
    debugger;
    var allTile='';
    $('#viewTile').html('');

     
      for(var i=0;i<=8;i++){
         var tile='<div class="col-md-4 col-xs-12" style="margin-bottom: 1%;"> <div class="col-md-12 col-xs-12 boxPlants"> <div class="col-md-8 col-xs-8"> <h3 style="font-size:21px;margin-top:4%;margin-bottom: 10%;font-weight:bold;"> WorkCenter Name '+i+' </h3> <h4 style="padding:3%;">Availability <span class="pull-right boxPlantsInner" style="background-color:orange;">52</span></h4> <h4 style="padding:3%;">Performance <span class="pull-right boxPlantsInner" style="background-color:orange;">52</span></h4> <h4 style="padding:3%;">Quality <span class="pull-right boxPlantsInner" style="background-color:orange;">52</span></h4> </div><div class="col-md-4 col-xs-4"> <div class="widget-user-image" style="margin-top:5%;"> <img class="img-thumbnail" src="../common/img/workcenter/default.png" alt="Machine"></img> </div><h2 style="margin:0px;"> <p class="boxPlantOee">'+(i+20)+'% </p><p class="text-center" style="font-size:30px;margin-top: -12%;">OEE</p></h2> </div><div class="col-md-7 col-xs-8 pull-right" style="margin-top: -3%;margin-bottom: 3%;"> <h2 class="btn btn-primary btn-xs btn-block" onclick="tempData.oeework.visitMachine();"> <span style="font-size: 15px;">View Machine </span> <i class="fa fa-arrow-circle-right" style="font-size: 18px;float: right; margin-top:2%;"></i> </h2> </div></div></div>';

        allTile+=tile;
      }
      // <div class="col-md-5 col-xs-5"> <img src="../common/img/online.png" class="img-responsive"/> </div>

      $('#viewTile').html(allTile);
  },
  visitMachine:function(){
    window.location.href="../machine";
  },

};



$(document).ready(function() {
debugger; 

tempData.oeework.generateTile();

});

</script>


 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

    <div class="btnsStyle" id="btns">
      
      <div class="col-md-5 col-sm-12 col-xs-12 pull-left headerTitle">
      <a href="../plants">Plants</a> / Work Center
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

<div class="row" id="viewTile"></div>

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
