  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../../bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../../bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">



<!-- Added CSS -->

<!-- select -->
<link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="../../dist/css/AdminLTE.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="../../dist/css/skins/_all-skins.css">

<!-- Choose color  -->
<link rel="stylesheet" href="../common/css/spectrum.css">

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/iCheck/all.css">

<!-- Range Selection -->
<link rel="stylesheet" href="../common/css/asRange.css">

<style type="text/css">
  /* Let's get this party started */
::-webkit-scrollbar {
    width: 9px;
    height: 9px;
}
 
/* Track */
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
    -webkit-border-radius: 10px;
    border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: rgb(60, 141, 188);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}
::-webkit-scrollbar-thumb:window-inactive {
  background: rgba(255,0,0,0.4); 
}

table > thead > tr > th {
      background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(255, 255, 255)),color-stop(100%,rgb(212, 216, 212)));
}

.loader
{
 position: fixed;
 left: 0px;
 top: 0px;
 width: 100%;
 height: 100%;
 z-index: 9999;
 background: url(../common/img/load.gif) 50% 50% no-repeat rgba(222, 222, 222, 0.4);
}

.btnsStyle{
  border: 1px solid #e4e4e4;
  border-radius: 6px;
  margin-bottom: 1%;
  background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(255, 255, 255)),color-stop(100%,rgb(212, 216, 212)));
  box-shadow: 1px 1px 1px 0px;
  min-height: 44px;
  margin-top: -5px;
}

.commonPageHead{
  border: 1px solid #e4e4e4;
  border-radius: 6px; 
  background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(255, 255, 255)),color-stop(100%,rgb(212, 216, 212)));
  box-shadow: 1px 1px 1px 0px;
  min-height: 44px;
  margin-top: -5px;
}

.commonSizeOEE{
  font-size: 30px;
  margin-bottom: 3%;
}

.commonSizeOEEOther{
  font-size: 20px;
}

.content-wrapper{
      background-color: #ffffff !important;
}
.hr-primary{
  background-color: #D7DBD7; 
  border: 0; 
  height:1px;
}

.boxPlants{
  border: 1px solid #dcdfdc;
  border-radius: 4px;
  padding: 0px;
  background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,rgb(255, 255, 255)),color-stop(100%,rgb(241, 241, 243)));
  /*background-color: #85b8ff66;*/
  box-shadow: 2px 2px 4px 0px #555e6b;
}
.boxPlantsInner{
    padding: 3%;
    padding-right: 10%;
    padding-left: 10%;
    border-radius: 50%;
    font-weight: bold;    
    color: #000000;
}
.boxPlantOee{
    text-align: center;
    font-size: 44px;
    margin-top: 4px;
    font-weight: bold;
    text-shadow: #000000 0px 0px 0px;
}
.panelHeader{
  color: #0c0c0c;
    background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgba(255, 255, 255, 0)),color-stop(100%,rgb(222, 224, 222))) !important;
    border-color: #c5c4c4 !important;
    padding-top: 6px;
    padding-bottom: 5px;
}

.fullscreen{
    z-index: 10003;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0px;
    left: 0px;
    margin-top: 0%;
    background-color: rgba(0, 0, 0, 0.32);
 }
label{
  font-weight: 500;
  font-size: 15px;
}

.availTextRight{
  font-size: 15px;
      margin-bottom: 0px !important;
}
.availTextLeft{
    font-size: 15px;
    color: #003785;
    font-weight: bold;
}
.timeFontStyle{
    font-size: 38px;
    color: #013785;
    margin-bottom: -8px;
}

.timeFontStylePerformance{
    font-size: 32px;
    color: #013785;
    margin-bottom: -10px;
}


p{
   font-size: 15px;
}

.commonMsgSuccess{
    padding: 6px;
    font-size: 20px;
    color: #00a65a;
    font-weight: 600;
    background-color: #81b5ff94;
    border-radius: 5px;
}

.commonMsgFail{
    padding: 6px;
    font-size: 20px;
    color: #ef0000;
    font-weight: 600;
    background-color: #81b5ff94;
    border-radius: 5px;
}
.thumb {
  display: flex;
  justify-content: center;
}
.thumb img {
  height: 100%;
  width: auto;
}
.thumb img {
    width: 75px !important;
    height: 45px !important;
}
.fa-expand:hover{
  background-color: #dcd6d6;
}

.shiftDetailsTime{
    font-size: 28px;
    color: #013785;
    margin-top: -17px;
}

a {cursor: pointer;}

.lb-md{
  font-size: 12px;
}
.emailConfirm{
  float: right;
  margin-top: -29px;
  margin-right: -25px;
}


/* Expand Div CSS */
.fullscreen{
    z-index: 10003;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0px;
    left: 0px;
    margin-top: 0%;
    background-color: rgba(0, 0, 0, 0.32);
 }

.expandAddCssDIV{
  height: 100% !important;
}
.expandAddCssGraph{
  height: 400px !important;
}
.expandAddCssGraphLineGraph {
    height: 84% !important;
}



/* Responsive Screen CSS MOBILE TAB PC etc... */
/* **************************************************************************************************** */
/*==========  Mobile First Method  ==========*/

    /* Custom, iPhone Retina */ 
    @media only screen and (min-width : 320px) {
      .FullSCHLogo{
        width: 35%;
        float: left;
        display: none;
      }
      .CustMobileLogo{
         height: 48px;
         width: 120px;
         overflow: hidden;
         float: right;
      }
      .cust_logo{
        display: none;
      }
      .SCHLogoMobile{
        display: inline;
        height: 42px;
        overflow: hidden;
        float: left;
      }
      
      .product_title{
          font-size: 22px;
          color: #0b408a;
          font-weight: 600;
      }     
      .company_title{
          font-size: 18px;
          font-weight: 600;          
          text-shadow: 1px 0px 0px #ccd5e4;
          color: black;
          text-transform: capitalize;
      } 
      .Headtitle{
        margin-left: 8%;
      }

      .headerTitle{
          font-size: 15px;
          margin-top: 3%;
      }
      .btnsStyle{
        min-height: 80px;
      }
      .btnsStyleDashboard{
        min-height: 90px;
      }

      .dashMachineImg{
        margin-left: 40%;
        width: 144px;
        height: 145px;
      }
      .statusImg{
        width: 24%;
        margin-top:-8%;
        float: right;
      }
      .dashFirstRow{
        height: 400px;
      }
      .commonPageHead{
        min-height:57px;
         margin-bottom: 3%;
      }
      .banner-sec{
        display: none;
      }
     .rangeBarSpace {
        margin-bottom: -30px;
        margin-top: 30px;
      }
      .mainSectionTop{
        margin-top: 34%;
      }
    }

    /* Extra Small Devices, Phones */ 
    @media only screen and (min-width : 480px) {

    }

    /* Small Devices, Tablets */
    @media only screen and (min-width : 768px) {

    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width : 992px) {

    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width : 1200px) {
      .FullSCHLogo{
        width: 100%;
        display: inline;
      }
      .SCHLogoMobile{
        display: none;
      }
      .CustMobileLogo{
         display: none;
      }
      .cust_logo{
          float: right;
          display: inline;
          height: 50px;
          width: 120px;
          overflow: hidden;
      }
      .product_title{        
          font-size: 21px;
          color: #0b408a;
          font-weight: 600;
      }       
      .company_title{
          font-size: 16px;
          color: #0b408a;
          font-weight: 600;    
          text-shadow: 1px 0px 0px #ccd5e4;
          color: black;
          text-transform: capitalize;
      } 
      .Headtitle{
        margin-left: 0%;
      }
      .headerTitle{
          font-size: 14px;
          margin-top: 7px;
      }
      .btnsStyle{
        min-height: 50px;
      }
      .btnsStyleDashboard{
        min-height: 50px;
      }
      .dashMachineImg{
        margin-left: 40%;
        /*width: 84%;*/
        width: 140px;
        height: 137px;
      }
      .statusImg{
        width: 26%;
        margin-top: -9%;
        float: right;
      }
      .dashFirstRow{
        height: 335px;
      }
      .commonPageHead{
        min-height: 47px;
         margin-bottom: 1%;
      }
      .banner-sec{
        display: inline;
      }
      .rangeBarSpace {
        margin-bottom: -10px;
        margin-top: 20px;
       }
      .mainSectionTop{
        margin-top: 4%;
      }


    }
</style>