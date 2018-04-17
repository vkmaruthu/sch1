 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../common/img/user.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
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
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="../home"><i class="fa fa-circle-o"></i> Company</a></li>
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
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-files-o"></i> Shift Configuration</a></li>
              <li><a href="pages/layout/boxed.html"><i class="fa fa-th"></i> OEE Configuration</a></li>
              <li><a href="../user/role.php"><i class="fa fa-users"></i> Role Configuration</a></li>
              <li><a href="../user/user.php"><i class="fa fa-users"></i> User Configuration</a></li>
              <li><a href="../company"><i class="fa fa-users"></i> Company</a></li>
              <li><a href="../reasons/createreasons.php"><i class="fa fa-users"></i> reasons</a></li>
          </ul>
        </li>
        
       <!--  <li class="treeview">
          <a href="#">
            <i class="fa fa-file"></i> <span>Reports</span>
            
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li> 
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


<script>

    $('#myInput').keyup( function() {
        var matches = $( 'ul#myUL' ).find( 'li:contains('+ $( this ).val() +') ' );
        $( 'li', 'ul#myUL' ).not( matches ).slideUp();
        matches.slideDown();    
    });

</script>