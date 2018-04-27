 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image" id="userImgFileName">
        <!--   <img src="../common/img/user.jpg" class="img-circle" alt="User Image"> -->
        </div>
        <div class="pull-left info">
          <p id="sidebarUserName"></p>
          <a href="../logout.php">Logout <i class="fa fa-sign-out"></i></a> 
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <span class="btn btn-flat"><i class="fa fa-search"></i>
                </span>
              </span>
        </div>
      </form> 
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree" id="myUL">
       <!--  <li class="header">MAIN NAVIGATION</li> -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../home/index.php" id="companyOEE"><i class="fa fa-circle-o"></i> Company OEE</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> History</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Pridiction</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Configuration</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="pages/layout/top-nav.html" id="menuShiftConfiguration"><i class="fa fa-files-o"></i> Shift Configuration</a></li>
              <li><a href="../oeelimits/oeelimits.php" id="menuOeeConfiguration"><i class="fa fa-th"></i> OEE Configuration</a></li>
              <li><a href="../user/role.php" id="menuRoleConfiguration"><i class="fa fa-users"></i> Role Configuration</a></li>
              <li><a href="../user/user.php" id="menuUserConfiguration"><i class="fa fa-users"></i> User Configuration</a></li>
              <li><a href="../company/index.php" id="menuCompany"><i class="fa fa-users"></i> Add Company</a></li>
              <li><a href="../productionorder/index.php" id="menuProductionOrder"><i class="fa fa-th"></i> Production Order</a></li>
              <li><a href="../partsandtools/plant.php" id="menuPlants"><i class="fa fa-th"></i> Plants</a></li>
              <li><a href="../user/screens.php?screen=s" id="menuScreen"><i class="fa fa-files-o"></i> Screens</a></li>
              <li><a href="../reasons/createreasons.php" id="menuReason"><i class="fa fa-files-o"></i> Reasons</a></li>
          </ul>
        </li>        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


<script>

    /** add active class and stay opened when selected */
    var url = window.location;
    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
       return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
       return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');


    /* Search Menus*/
    $('#myInput').keyup( function() {
        var matches = $( 'ul#myUL' ).find( 'li:contains('+ $( this ).val() +') ' );
        $( 'li', 'ul#myUL' ).not( matches ).slideUp();
        matches.slideDown();    
    });

</script>
