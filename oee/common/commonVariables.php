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
         	
         	  $('#comp_id').val(obj.userDetails.company_id);
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

          	/* Role Configuration */
         	/*$('#adminRole').val(obj.userDetails.rolename);
         	$('#companyName').val(obj.userDetails.company_id);*/
          	
        }else{
         
        }
      } 
  });

});
</script>