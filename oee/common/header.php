<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" xmlns:epub="http://www.idpf.org/2007/ops">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8 width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


<!-- <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
 // Tell the browser to be responsive to screen width
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
  
  <style type="text/css">

/*
 * Skin: Blue
 * ----------
 */
 .main-header .navbar {
      background: linear-gradient(#f1f1f1eb, #8a535300, #e2e0e0);
    border-bottom: 1px solid #adadad;
}
 .main-header .navbar .nav > li > a {
  color: #000000;
}
 .main-header .navbar .nav > li > a:hover,
 .main-header .navbar .nav > li > a:active,
 .main-header .navbar .nav > li > a:focus,
 .main-header .navbar .nav .open > a,
 .main-header .navbar .nav .open > a:hover,
 .main-header .navbar .nav .open > a:focus,
 .main-header .navbar .nav > .active > a {
  background-color: #e6dede;
  color: #000000;
}
 .main-header .navbar .sidebar-toggle {
  color: #000000;
}
 .main-header .navbar .sidebar-toggle:hover {
  color: #000000;
  background-color: #e6dede;
}
 .main-header .navbar .sidebar-toggle {
  color: #000000; 
}
 .main-header .navbar .sidebar-toggle:hover {
  background-color: #e6dede;
}
@media (max-width: 767px) {
   .main-header .navbar .dropdown-menu li.divider {
    background-color: rgba(255, 255, 255, 0.1);
  }
   .main-header .navbar .dropdown-menu li a {
    color: #fff;
  }
   .main-header .navbar .dropdown-menu li a:hover {
    background: #adadad;
  }
}
 .main-header .logo {
   background: linear-gradient(#fdfdfd4d, #ffffff00, #e2e0e047);   
  color: #000000;
}
 .main-header .logo:hover {
   background: linear-gradient(#fdfdfd4d, #ffffff00, #e2e0e047);
}
 .main-header li.user-header {
  background-color:#e6dede;
}
 .content-header {
  background: transparent;
}
 .wrapper,
 .main-sidebar,
 .left-side {
  background-color: #f9fafc;
}
 .main-sidebar {
  border-right: 1px solid #d2d6de;
}
 .user-panel > .info,
 .user-panel > .info > a {
  color: #444444;
}
 .sidebar-menu > li {
  -webkit-transition: border-left-color 0.3s ease;
  -o-transition: border-left-color 0.3s ease;
  transition: border-left-color 0.3s ease;
  background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(255, 255, 255)),color-stop(100%,rgb(212, 216, 212)));
}
 .sidebar-menu > li.header {
  color: #848484;
  background: #f9fafc;
}
 .sidebar-menu > li > a {
  border-left: 3px solid transparent;
  font-weight: 600;
}
 .sidebar-menu > li:hover > a,
 .sidebar-menu > li.active > a {
  color: #000000;
  background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(255, 255, 255)),color-stop(100%,rgb(212, 216, 212)));
}
 .sidebar-menu > li.active {
  border-left-color: #3c8dbc;
}
 .sidebar-menu > li.active > a {
  font-weight: 600;
}
 .sidebar-menu > li > .treeview-menu {
  background: #f4f4f5;
}
 .sidebar a {
  color: #444444 !important;
}
 .sidebar a:hover {
  text-decoration: none;
  color: #444444 !important;
}
 .sidebar-menu .treeview-menu > li > a {
  color: #777777;
}
 .sidebar-menu .treeview-menu > li.active > a,
 .sidebar-menu .treeview-menu > li > a:hover {
  color: #000000;
  background: #e6dede;
}
 .sidebar-menu .treeview-menu > li.active > a {
  font-weight: 600;
}
 .sidebar-form {
  border-radius: 3px;
  border: 1px solid #d2d6de;
  margin: 10px 10px;
}
 .sidebar-form input[type="text"],
 .sidebar-form .btn {
  box-shadow: none;
  background-color: #fff;
  border: 1px solid transparent;
  height: 35px;
}
 .sidebar-form input[type="text"] {
  color: #666;
  border-top-left-radius: 2px;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 2px;
}
 .sidebar-form input[type="text"]:focus,
 .sidebar-form input[type="text"]:focus + .input-group-btn .btn {
  background-color: #fff;
  color: #666;
}
 .sidebar-form input[type="text"]:focus + .input-group-btn .btn {
  border-left-color: #fff;
}
 .sidebar-form .btn {
  color: #999;
  border-top-left-radius: 0;
  border-top-right-radius: 2px;
  border-bottom-right-radius: 2px;
  border-bottom-left-radius: 0;
}
@media (min-width: 768px) {
  .sidebar-mini.sidebar-collapse .sidebar-menu > li > .treeview-menu {
    border-left: 1px solid #d2d6de;
  }
}
 .main-footer {
  border-top-color: #d2d6de;
}
.skin-blue.layout-top-nav .main-header > .logo {
  background-color: #3c8dbc;
  color: #000000;
  border-bottom: 0 solid transparent;
}
.skin-blue.layout-top-nav .main-header > .logo:hover {
  background-color: #3b8ab8;
}

  </style>
  

  <?php include('commonCSS.php');?>
  <?php include('commonJS.php');?>
  
<?php require_once('commonVariables.php'); ?>

  <!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="skin-blue sidebar-mini fixed" onload="window.history.forward();">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="javascript:void(0);" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="../common/img/SCHLogo_Blue.png" class="SCHLogo" style="width: 100%;"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="../common/img/SCHLogo_full.png" class="FullSCHLogo"></span>
      <span class="logo-lg" id="compImg"><!-- <img src="../common/img/comp_logo/d/eimsdefault.png" class="CustMobileLogo"> --></span>
      <span class="logo-lg"><img src="../common/img/SCHLogo_Blue.png" class="SCHLogoMobile"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="index.php" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>


    <div class="col-md-10 Headtitle text-center">  
      <span class="product_title">smartFactory Dashboard</span><br>
      <span class="company_title" id="compNameDB"></span>
    </div>

    <div class="col-md-2" style=" margin-left: -4%;">  
      <span class="logo-mini" id="compImgMini">
       <!--  <img src="../common/img/comp_logo/d/eimsdefault.png" class="cust_logo"> -->
      </span>
    </div>  
           
       
     
    </nav>
  </header>

<script type="text/javascript">

$(document).ready(function() {
    debugger; 
    /* Global Variable Page Level */
/*    var selDate=null;
    var selMonth=null;
    var selYear=null;
    var finalDateFormat=null;*/

      var setDateFormat="dd/mm/yyyy";
      $('.datepicker-me').datepicker({
          format: setDateFormat,
          autoclose: true
      });

});

</script>