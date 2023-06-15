<section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <p><?php echo $_SESSION['admins']['user']?></p>
            </div>
            <div class="pull-left info">
              <p>Welcome <?php echo $_SESSION['admins']['user']?></p>
              
            </div>
          </div>
          <!-- search form -->
          <?php /*?><form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form><?php */?>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <?php include "inc_menu.php"; ?>
        </section>