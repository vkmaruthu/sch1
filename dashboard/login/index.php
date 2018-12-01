<?php 
error_reporting(0);
session_start();  

if(isset($_SESSION['schAdminSession'])) {
  //echo "test";
  echo "<script> window.location='../jobcard';</script>";
}else{
  //echo $_SESSION['schAdminSession']."_Not working";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" xmlns:epub="http://www.idpf.org/2007/ops">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8 width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/png" sizes="32x32" href="../common/img/favicon-32x32.png">
  <?php include('../common/commonCSS.php');?>
  <?php include('../common/commonJS.php');?>

<style type="text/css">
.login-block{
    background: #DE6262;
    background: linear-gradient(to bottom, #ffffff, #003785);
    float: left;
    width: 100%;
    padding: 67px 25px;
    height: 800px;
    overflow: hidden;
}
/*
.banner-sec{background:url(https://static.pexels.com/photos/33972/pexels-photo.jpg) 
 no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
*/
.container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
.carousel-inner{border-radius:0 10px 10px 0;}
.carousel-caption{text-align:left; left:5%;}
.login-sec{padding: 50px 30px; position:relative;}
.login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
.login-sec .copy-text i{color:#FEB58A;}
.login-sec .copy-text a{color:#E36262;}
.login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #003785;}
.login-sec h2:after{content:" "; width:100px; height:5px; background:#FEB58A; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
.btn-login{background: #85b8ff; color:#003785; font-weight:600;}
.banner-text{width: 100%; position: absolute; bottom: 40px; padding-left: 20px; text-align: justify;}
.banner-text h2{color:#ffffff; font-weight:600;text-shadow: 3px 3px 0px black;}
.banner-text h2:after{content:" "; width:100px; height:5px; background:#000000; display:block; margin-top:20px; border-radius:3px;}
.banner-text p{    font-size: 16px;
    color: #000000;
    text-shadow: 0px 0px 1px #4c4c4c;
    background-color: #ffffff9e;
    padding: 13px;
    border-radius: 10px;}
</style>

<script type="text/javascript">
//window.history.forward();

var tempData;
if(tempData===null||tempData===undefined){
   tempData={};
}

tempData.oeeLogin=
{
getLogin:function(){
    var url="getLogin.php";
    var formEQData = new FormData($('#formLogin')[0]);
    formEQData.append("getLogin","getLogin");

    $.ajax({
      type:"POST",
      url:url,
      async: false,
      dataType: 'json',
      cache: false,
      processData: false,
      contentType: false,
      data:formEQData,
      success: function(obj) {
         debugger;
          if(obj.login != null){
            if(obj.login.infoRes=="A"){
              $('#status1').slideDown(600);
                $('#status2').hide();
                $('#status3').hide();
                window.setTimeout(function () { 
                  window.location='../home';
                },3000);
            }else if(obj.login.infoRes=="D"){
                $('#status3').slideDown(600);
                $('#status1').hide();
                $('#status2').hide();
            }
            else{
              $('#status3').hide();
              $('#status1').hide();
              $('#status2').slideDown(600);
            }


            window.setTimeout(function () { 
                $("#status1").slideUp(600);
                $('#status2').slideUp(600);
                $('#status3').slideUp(600);
            },6000);    
          }else{

          } 
          $('#email').val('');
          $('#password').val('');
      }
    });
}

};

$(document).ready(function() {


  $('.login-block').css({ height: $(window).innerHeight() });
  $(window).resize(function(){
    $('.login-block').css({ height: $(window).innerHeight() });
  });


  $('#email').val('');
  $('#password').val('');

  $('#formLogin').keydown(function(event) {
      //alert(event.keyCode);
      if (event.keyCode == 13) {
          tempData.oeeLogin.getLogin();
      }
    });


});


</script>

<!-- onload="window.history.forward();" -->
<body>

<section class="login-block">
    <div class="container">
  <div class="row">
    <div class="col-md-4 col-xs-12 login-sec">
      <img class="d-block img-responsive" src="../common/img/SCHLogo_full.png" alt="First slide">
        <h2 class="text-center">smartFactory</h2>
<form class="login-form" id="formLogin">

        <div class="col-xs-12 col-md-12 col-sm-12 ">
          <div class="alert alert-success" id="status1" style="display:none;text-align:center;">
            <strong> Login Successfully !! </strong>  &nbsp;&nbsp;&nbsp;
            <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
          </div>

          <div class="alert alert-danger" id="status2" style="display:none;text-align:center;">
            <strong>Warning !</strong> Wrong Username/Password.  
          </div>

          <div class="alert alert-warning" id="status3" style="display:none;text-align:center;">
            <strong>Warning !</strong> User is Deactivated.  
          </div>

        </div>

  <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    <input id="email" type="text" class="form-control" name="email" placeholder="Employee Id">
  </div><br>
  <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
  </div><br>
  
  
  <div class="form-check">
    <button type="button" onclick="tempData.oeeLogin.getLogin();" class="btn btn-login pull-right">
      Login <i class="fa fa-arrow-circle-right"></i></button>
  </div>
  
</form>
<!-- <div class="copy-text">Created with <i class="fa fa-heart"></i> by <a href="http://grafreez.com">Grafreez.com</a></div> -->
    </div>
    <div class="col-md-8 col-xs-12 banner-sec">
            <div id="carouselExampleIndicators" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img class="d-block img-responsive" src="../common/img/login_machine.jpg" alt="First slide" style="height: 478px;opacity: 0.6;">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>smartFactory Solutions</h2>
            <p>Smart Factory Solutions has been developed specifically to help industries overcome challenges of managing the ever increasing levels of complexity that a shop floor throws up. Smart Factory solutions provide real-time operational awareness, flexible control and data-driven insights that enable smarter decisions for optimal process execution.</p>
        </div>  
  </div>
    </div>
            </div>     
        
    </div>
  </div>
</div>
</section>

</div>

</body>
</html>