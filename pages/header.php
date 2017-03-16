<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="../../proces/system-priv.php" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">FP</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>SIMON</b>FP</span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="../../asset/dist/img/default.jpg" class="user-image" alt="User Image"/>
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"><?php echo $emp->nama; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="../../asset/dist/img/default.jpg" class="img-circle" alt="User Image" />
              <p><?php echo $emp->nama; ?> - <?php echo $emp->nama_la; ?>
                <small>Bekerja sejak <?php echo date('d M Y', strtotime($emp->terupdate)); ?></small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
                <a href="../../proces/auth.php?signout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li style="width: 45px;">
        </li>
      </ul>
    </div>
  </nav>
</header>