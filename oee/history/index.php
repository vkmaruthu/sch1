<?php include('../common/header.php'); ?>
<?php include('../common/sidebar.php'); ?>
<?php error_reporting(0); ?>

<script type="text/javascript">
var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

tempData.oeelimitconfig=
{
reload:function(){
	   location.reload(true);
},
/* getCompDesc:function(){
	  var url="getDataController.php";
	  var compId = $('#comp_id').val();
	  var myData = {getCompDetails:'getCompDetails', comp_id:compId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	        debugger;
	      if( obj.compDetails !=null){
	    	 $("#comp_desc").html('');
	    	 $("#comp_desc").append('<option value="0"> Select Company </option>');
          		for(var i=0; i< obj.compDetails.length; i++){
      			   $("#comp_desc").append('<option value="'+obj.compDetails[i].id+'">'+obj.compDetails[i].comp_desc+'</option>'); 
          		}
	        }
	      } 
	  });
}, */
getPlantDesc:function(compId){
	  var url="getDataController.php";
	  var myData = {getPlantDetails:'getPlantDetails', comp_id:compId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	        debugger;
	      if( obj.plantDetails !=null){
	    	 $("#plant_desc").html('');
	    	 $("#plant_desc").append('<option value="0"> Select Plant </option>');
        		for(var i=0; i< obj.plantDetails.length; i++){
    			   $("#plant_desc").append('<option value="'+obj.plantDetails[i].id+'">'+obj.plantDetails[i].plant_desc+'</option>'); 
        		}
	        }
	      } 
	  });
},
getWCDesc:function(pId){
	  var url="getDataController.php";
	  var myData = {getWCDetails:'getWCDetails', plant_id:pId};
	  $.ajax({
	    type:"POST",
	    url:url,
	    async: false,
	    dataType: 'json',
	    cache: false,
	    data:myData,
	    success: function(obj) {
	      if( obj.wcDetails !=null){
	    	 $("#wc_desc").html('');
	    	 $("#wc_desc").append('<option value="0"> Select Work Center </option>');
        		for(var i=0; i< obj.wcDetails.length; i++){
    			   $("#wc_desc").append('<option value="'+obj.wcDetails[i].id+'">'+obj.wcDetails[i].wc_desc+'</option>'); 
        		}
	        }
	      } 
	  });
},
getEQDesc:function(wcId){
	  var url="getDataController.php";
	  var myData = {getEquipmentDetails:'getEquipmentDetails', wc_id:wcId};
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
	    	 $("#eq_desc").append('<option value="none"> Select Equipment </option>');
      		for(var i=0; i< obj.equipmentDetails.length; i++){
  			   $("#eq_desc").append('<option value="'+obj.equipmentDetails[i].eq_code+'">'+obj.equipmentDetails[i].eq_desc+'</option>'); 
      		}
	        }
	      } 
	  });
}

};

$(document).ready(function() {
    
   $("#menuHistory").parent().addClass('active');
   $("#menuHistory").parent().parent().closest('.treeview').addClass('active menu-open');
   $('.select2').select2();
/* tempData.oeelimitconfig.getCompDesc();
  $('#comp_desc').change(function(){
     $('#msg').html('');
	 var compId = $('#comp_desc').val();
	 if(compId != 0){
		 tempData.oeelimitconfig.getPlantDesc(compId);
	 }else{
		$("#plant_desc").html('');
	 	$("#plant_desc").append('<option value="0"> Select Plant </option>');
		$("#wc_desc").html('');
	 	$("#wc_desc").append('<option value="0"> Select Work Center </option>');
		$("#eq_desc").html('');
	 	$("#eq_desc").append('<option value="none"> Select Equipment </option>');
     }
 }); */
 
 $('#plant_desc').change(function(){
	 var pId = $('#plant_desc').val();
	 if(pId != 0){
		 tempData.oeelimitconfig.getWCDesc(pId);
	 }else{
		$("#wc_desc").html('');
	 	$("#wc_desc").append('<option value="0"> Select Work Center </option>');
		$("#eq_desc").html('');
	 	$("#eq_desc").append('<option value="none"> Select Equipment </option>');
     }
 });
 $('#wc_desc').change(function(){
	 var wcId = $('#wc_desc').val();
	 if(wcId != 0){
		 tempData.oeelimitconfig.getEQDesc(wcId);
	 }else{
		$("#eq_desc").html('');
	 	$("#eq_desc").append('<option value="none"> Select Equipment </option>');
     }
 });
 tempData.oeelimitconfig.getPlantDesc($('#comp_id').val());

});

</script>
 <input type="hidden" name="comp_id" id="comp_id"/> 
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="commonPageHead">
        <div class="col-md-10 col-sm-12 col-xs-10 pull-left headerTitle" >
        <h3 style="margin-top: 2px;">History<h3>
        </div>
      </div>

    <div class="" >
      <div class="panel-heading "> 
        <div class="panel-title pull-left"></div>
               <div class="row">
   <!--               
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="comp_desc" name="comp_desc" style="width: 100%">
                        </select>
                      </div>
                    </div>  
                </div>
    -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                     <div class="col-md-12 col-sm-12 col-xs-12" >
                      <div class="form-group">
                        <select class="form-control select2"  id="plant_desc" name="plant_desc" style="width: 100%">
                        <option value="0"> Select Plant </option>
                        </select>
                      </div>
                    </div>
                </div>
                 <div class="col-md-3 col-sm-6 col-xs-12">
                     <div class="col-md-12 col-sm-12 col-xs-12" >
                      <div class="form-group">
                        <select class="form-control select2"  id="wc_desc" name="wc_desc" style="width: 100%">
                           <option value="0"> Select Work Center </option>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <select class="form-control select2"  id="eq_desc" name="eq_desc" style="width: 100%">
                          <option value="none"> Select Equipment </option>
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              
   <!--      <button type="button" onclick="tempData.oeelimitconfig.reload();" class="btn btn-sm btn-info pull-right" style="margin-top: -3px;margin-bottom: -2px;margin-left:15px;">   <i class="fa  fa-refresh"> </i>
        </button> -->
          <div class="clearfix"></div>
      </div> 
      
   <!-- Score Card -->
       <div class="col-md-9 col-sm-12 col-xs-12" id="expandScoreCardScreen">  
           <div class="panel panel-default dashFirstRow">
             <div class="panel-heading panelHeader">
               <div class="panel-title pull-left">
                 <i class="fa fa-sliders fa-fw"></i> Score Card
               </div>
                 <div class="panel-title pull-right">
                  <i id="expandScoreCard" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
                 </div> 
               <div class="clearfix"></div>
             </div>
             <div class="panel-body">  
               <div class="table-responsive">
                   <div id="scoreCard" style="width:99%;height:210px;"></div>           
    
               </div>      
             </div>
           </div>
         </div>
    <!-- Score Card Ends --> 
    
    <!-- MTBF & MTTR  -->
       <div class="col-md-3 col-sm-12 col-xs-12" id="expandMTBFScreen">  
           <div class="panel panel-default dashFirstRow">
             <div class="panel-heading panelHeader">
               <div class="panel-title pull-left">
                 <i class="fa fa-sliders fa-fw"></i> MTBF & MTTR
               </div>
                 <div class="panel-title pull-right">
                  <i id="expandMTBF" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
                 </div> 
               <div class="clearfix"></div>
             </div>
             <div class="panel-body">  
               <div class="table-responsive">
                   <div id="mtbfAndmttr" style="width:99%;height:210px;"></div>           
    
               </div>      
             </div>
           </div>
         </div>
    <!-- MTBF & MTTR Ends -->
    
    <!-- Historical Analysis  -->
       <div class="col-md-12 col-sm-12 col-xs-12" id="expandHistoricalScreen">  
           <div class="panel panel-default dashFirstRow">
             <div class="panel-heading panelHeader">
               <div class="panel-title pull-left">
                 <i class="fa fa-sliders fa-fw"></i> Historical Analysis
               </div>
                 <div class="panel-title pull-right">
                  <i id="expandHistorical" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
                 </div> 
               <div class="clearfix"></div>
             </div>
             <div class="panel-body">  
               <div class="table-responsive">
                   <div id="historicalAnalysis" style="width:99%;height:210px;"></div>           
    
               </div>      
             </div>
           </div>
         </div>
    <!-- Historical Analysis Ends -->
    
    <!-- Availability   -->
       <div class="col-md-12 col-sm-12 col-xs-12" id="expandAvailabilityScreen">  
           <div class="panel panel-default dashFirstRow">
             <div class="panel-heading panelHeader">
               <div class="panel-title pull-left">
                 <i class="fa fa-line-chart fa-fw"></i> Availability
               </div>
                 <div class="panel-title pull-right">
                  <i id="expandAvailability" class="btn btn-xs fa fa-expand" aria-hidden="true"></i>
                 </div> 
               <div class="clearfix"></div>
             </div>
             <div class="panel-body">  
               <div class="table-responsive">
                   <div id="availability" style="width:99%;height:210px;"></div>  
               </div>      
             </div>
           </div>
         </div>
    <!-- Historical Analysis Ends -->
          
          
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
