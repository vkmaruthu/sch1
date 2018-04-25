<?php 
error_reporting(0);
session_start();  

if(!isset($_SESSION['schAdminSession'])) {
	//echo "test";
	echo "<script> window.location='../logout.php';</script>";
}else{
	//echo $_SESSION['schAdminSession']."_Not working";
}

?>


<script type="text/javascript">
$(document).ready(function() {
  var userMail="<?php echo $_SESSION['schAdminSession'] ?>";
  var url="../common/getDataController.php";
  var myData = {userDetails:'userDetails',userMail:userMail};
  
  $.ajax({
    type:"POST",
    url:url,
    async: false,
    dataType: 'json',
    cache: false,
    data:myData,
    success: function(obj) {
        debugger;
        if(obj.userDetails !=null){
 			
        	for (var i=0; i < obj.allScreenArr.length ; i++) {
        		$('#'+obj.allScreenArr[i]).hide();
        	}	

        	for (var i=0; i < obj.screenArr.length ; i++) {
        		$('#'+obj.screenArr[i]).show();
        	}
 			

        	 /*if(obj.rule.Dashboard==1){$('#dashboard').show();}else{$('#dashboard').hide();}
             if(obj.rule.Configuration==1){$('#configuration').show();}else{$('#configuration').hide();}
             if(obj.rule.Tool_Tracking==1){$('#tool_tracking').show();}else{$('#tool_tracking').hide();}
             if(obj.rule.Machine_Tracking==1){$('#machine_tracking').show();}else{$('#machine_tracking').hide();}
             if(obj.rule.Alerts==1){$('#alerts').show();}else{$('#alerts').hide();}
             if(obj.rule.Reports==1){$('#reports').show();}else{$('#reports').hide();}   
             if(obj.rule.ManageUser==1){$('#ManageUser').show();}else{$('#ManageUser').hide();}   
             if(obj.rule.ManageRole==1){$('#ManageRole').show();}else{$('#ManageRole').hide();}   
             if(obj.rule.configure_shift==1){$('#configure_shift').show();}else{$('#configure_shift').hide();}*/

          	$('#compNameDB').html(obj.userDetails.compName);
          	$('#sidebarUserName').html(obj.userDetails.first_name);
          	if(obj.userDetails.img_file_name != ''){
          		$('#userImgFileName').html('<img src="../common/img/user_img/'+obj.userDetails.img_file_name+'" class="img-circle" alt="User Image">');
          	}else{
          		$('#userImgFileName').html('<img src="../common/img/user_img/default.png" class="img-circle" alt="User Image">');
          	}	

          	if(obj.userDetails.compImg != ''){
          		$('#compImg').html('<img src="../common/img/comp_logo/'+obj.userDetails.compImg+'" class="CustMobileLogo">');
          		$('#compImgMini').html('<img src="../common/img/comp_logo/'+obj.userDetails.compImg+'" class="cust_logo">');
          	}else{
          		$('#compImg').html('<img src="../common/img/comp_logo/d/eimsdefault.png" class="CustMobileLogo">');
          		$('#compImgMini').html('<img src="../common/img/comp_logo/d/eimsdefault.png" class="cust_logo">');
          	}
          	
        }else{
         
        }
      } 
  });

});
</script>