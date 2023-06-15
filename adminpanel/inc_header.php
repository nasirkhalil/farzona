<header class="main-header">
        <!-- Logo -->
        <a href="<?=$conf->site_url?>" target="_blank" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="<?=$conf->site_url?>images/<?=$conf->logo?>" height="40" /></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="<?=$conf->site_url?>images/<?=$conf->logo?>" height="40" /></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a class="dropdown-toggle">
                	<span class="hidden-xs">Welcome <?php echo $_SESSION['admins']['user']?></span>
                </a>                
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li class="dropdown user user-menu">
                <a href="logout.php" class="dropdown-toggle">
                	<span class="hidden-xs">Logout</span>
                </a>                
              </li>
            </ul>
          </div>
        </nav>
      </header>