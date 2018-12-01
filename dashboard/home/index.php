<?php include('../common/header.php'); ?>
<?php //include('../common/sidebar.php'); ?>
<script type="text/javascript">
	$(document).ready(function() {
	add();
});


</script>
<script type="text/javascript">
$(document).ready(function() {
 debugger;
var tempData;
if(tempData===null||tempData===undefined){  
     
  add();
}
function add(){

	alert('welcome')
	 $(".dis").append("<b>Appended text</b>");
	 var url="reason.php";
             	$.ajax({
					      type:"POST",
					      url:url,
					      data:{'id': 'one'	},
					      success: function(obj) {
					      	console.log(obj.idleReason)
					      }
					  });
}



	   debugger;
            //alert('data')
    $("#reasons").parent().addClass('active');
    $("#reasons").parent().parent().closest('.treeview').addClass('active menu-open');

    $('.click_btn').click(function(){   
   
    		var val=$(this).data('value');  	alert(val);
    	    var url="getHome.php";
             	$.ajax({
					      type:"POST",
					      url:url,
					      data:{'id':val	},
					      success: function(obj) {
					      //	console.log(obj)
					      }
					  });
    });
    

});
</script>
<style type="text/css">
		/*.btn {
		margin: 20px;
		margin-left: 10px;
		width: 200px;
	}*/

	.content>.row{
		margin-top: 1%;
	}

	.btn-primary{
		height: 78px;
	    margin-top: 7px;
    	margin-bottom: 10px;
	}
</style>
 <div class="content-wrapper">
	<section class="content">
		<div class="row">

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b1" data-value='1'><strong>Reason Code 1</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b2" data-value='2'><strong>Reason Code 2</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b3" data-value='3'><strong>Reason Code 3</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b4" data-value='4'><strong>Reason Code 4</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b5" data-value='5'><strong>Reason Code 5</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b6" data-value='6'><strong>Reason Code 6</strong></button>
				</div>
		  
        
		
				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b7" data-value='7'><strong>Reason Code 7</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b8" data-value='8'><strong>Reason Code 8</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b9" data-value='9'><strong>Reason Code 9</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b10" data-value='10'><strong>Reason Code 10</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b11" data-value='11'><strong>Reason Code 11</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b12" data-value='12'><strong>Reason Code 12</strong></button>
				</div>
	    
		 		
				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b13" data-value='13'><strong>Reason Code 13</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b14" data-value='14'><strong>Reason Code 14</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b15" data-value='15'><strong>Reason Code 15</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b16" data-value='16'><strong>Reason Code 16</strong></button>
				</div>

				<div class="col-xs-6 col-md-2">
					<button class="col-xs-12 col-md-12 btn btn-primary btn_style click_btn" id="b17" data-value='17'><strong>Reason Code 17</strong></button>
				</div>
	        <div class="col-md-6 Headtitle text-center">  
	
		      <span class="reason" id="reason"><div class="dis"></div></span>
		    </div>


		</div>
	</section>
</div>

