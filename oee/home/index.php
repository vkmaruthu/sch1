<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}
  
tempData.oeehome=
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
  visitPlants:function(){
    window.location.href="../plants/index.php?selDate="+$('#userDateSel').val();
  },
  getSelDate:function(){
    var date= $('#userDateSel').val();
    alert(date);
  }

};



$(document).ready(function() {
debugger; 
/* Date is defined to DatePicker */
var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
$('.datepicker-me').datepicker('setDate', today);

tempData.oeehome.oeeCirclePerc('oeePerc',90,'#E29C21');
tempData.oeehome.oeeCirclePerc('availPerc',40,'#FDCA6C');
tempData.oeehome.oeeCirclePerc('performPerc',20,'#DB4F31');
tempData.oeehome.oeeCirclePerc('qualityPerc',90,'#1AD34E');

});

</script>


 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

    <div class="btnsStyle" id="btns">
      <div class="col-md-5 col-sm-12 col-xs-2 pull-left headerTitle" >
      <h3 style="margin-top: 2px;">Company<h3>
      </div>

      <div class="col-md-5 col-sm-12 col-xs-9 pull-right" style="margin-top:5px;">
           <!-- <div class="col-md-5 col-md-offset-2 col-xs-6">
            <select class="form-control" id="shiftDropdown" style="font-size: 12px; padding: 2px;"
             onchange= "tempData.cpsData.shiftsdata();">
            </select>   
          </div>  -->
        <div class="col-md-5 col-xs-9 pull-right">  
          <div class='input-group date datepicker-me' data-provide="datepicker">
            <input type='text' class="form-control" id='userDateSel' name="userDateSel"  onchange="tempData.oeehome.getSelDate();"
            style="cursor: pointer;" readonly="readonly"/>
              <label class="input-group-addon btn" for="userDateSel">
                  <span class="glyphicon glyphicon-calendar"></span>               
              </label>
          </div>  
        </div>
        </div>
      </div>


     <div class="col-xs-12 col-md-12 text-center">
        <input type="text" class="knob" id="oeePerc" data-skin="tron" data-thickness="0.2" data-width="180" data-height="180" readonly>
        <div class="knob-label commonSizeOEE">OEE</div>
      </div>

    <div class="row">
      <div class="col-xs-12 col-md-4 text-center">
        <input type="text" class="knob" id="availPerc" data-skin="tron" data-thickness="0.2" data-width="100" data-height="100" readonly>
        <div class="knob-label commonSizeOEEOther">Availability</div>
      </div>

      <div class="col-xs-6 col-md-4 text-center">
        <input type="text" class="knob" id="performPerc" data-skin="tron" data-thickness="0.2" data-width="100" data-height="100" readonly>
        <div class="knob-label commonSizeOEEOther">Performance</div>
      </div>

      <div class="col-xs-6 col-md-4 text-center">
        <input type="text" class="knob" id="qualityPerc" data-skin="tron" data-thickness="0.2" data-width="100" data-height="100" readonly>
        <div class="knob-label commonSizeOEEOther">Quality</div>
      </div>
    </div>

    <hr class="hr-primary"/>  

      <div class="col-xs-12 col-md-4 col-md-offset-4" style="margin-bottom: 2%;margin-top: -2%;">
            <h2 class="btn btn-primary btn-lg btn-block" onclick="tempData.oeehome.visitPlants()">View Plants 
             <i class="fa fa-arrow-circle-right" style="font-size: 27px;float: right;"></i> </h2>
            
        </div> 
      </div> 


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('../common/footer.php'); ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <!-- <div class="control-sidebar-bg"></div> -->
</div>
<!-- ./wrapper -->

</body>
</html>
