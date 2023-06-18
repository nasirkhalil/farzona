<ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li <? if(stristr($_SERVER['PHP_SELF'],"dashboard.php")){ echo 'class="active"';}; ?>><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <!-- CONTENT MANAGEMENT -->
            <!-- <li class="treeview <? if(stristr($_SERVER['PHP_SELF'],"cms.php") || stristr($_SERVER['PHP_SELF'],"_blocks.php") || stristr($_SERVER['PHP_SELF'],"video_cms.php")){ echo "active";}; ?>">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Content Management</span>
                <i class="fa fa-angle-left pull-right"></i>                
              </a>
              <ul class="treeview-menu">
                <li><a href="manage_cms.php"><i class="fa fa-circle-o"></i> Manage Content</a></li>
                 <?php /*?><li><a href="manage_blocks.php"><i class="fa fa-circle-o"></i> Manage Home Blocks</a></li><?php */?>
                
                             
              </ul>
            </li> -->
            <!-- BANNERS MANAGEMENT -->
            <!-- <li class="treeview <? if(stristr($_SERVER['PHP_SELF'],"_banners.php")){ echo "active";}; ?>">
              <a href="#">
                <i class="fa fa-image"></i>
                <span>Banners Management</span>
                <i class="fa fa-angle-left pull-right"></i>                
              </a>
              <ul class="treeview-menu">
                <li><a href="manage_banners.php"><i class="fa fa-circle-o"></i> Manage Banners</a></li>                
              </ul>
            </li> -->
                        
            <!-- CATEGORIES MANAGEMENT -->
            <li class="treeview <? if(stristr($_SERVER['PHP_SELF'],"_categories.php")){ echo "active";}; ?>">
              <a href="#">
                <i class="fa fa-list"></i>
                <span>Categories Management</span>
                <i class="fa fa-angle-left pull-right"></i>                
              </a>
              <ul class="treeview-menu">
                <li><a href="manage_categories.php"><i class="fa fa-circle-o"></i> Manage Categories</a></li>                
              </ul>
            </li>
            
            <!-- Product MANAGEMENT -->
            <li class="treeview <? if(stristr($_SERVER['PHP_SELF'],"_products.php")){ echo "active";}; ?>">
              <a href="#">
                <i class="fa fa-umbrella"></i>
                <span>Product Management</span>
                <i class="fa fa-angle-left pull-right"></i>                
              </a>
              <ul class="treeview-menu">
                <li><a href="manage_products.php"><i class="fa fa-circle-o"></i> Manage Product</a></li>                
              </ul>
            </li>
          
            <!-- ENQUIRIES MANAGEMENT -->
            <!-- <li class="treeview <? if(stristr($_SERVER['PHP_SELF'],"_contact.php") || stristr($_SERVER['PHP_SELF'],"enquiry.php") || stristr($_SERVER['PHP_SELF'],"propsell.php")){ echo "active";}; ?>">
              <a href="#">
                <i class="fa fa-envelope-o"></i>
                <span>Enquiries Management</span>
                <i class="fa fa-angle-left pull-right"></i>                
              </a>
              <ul class="treeview-menu">                   
                <li><a href="manage_contact.php"><i class="fa fa-circle-o"></i> Manage Contact Us Enquiries</a></li>
               <?php /*?> <li><a href="manage_enquiry.php"><i class="fa fa-circle-o"></i> Manage Contact Us Footer</a></li><?php */?>
              </ul>
            </li> -->
            <!-- ADMIN SECTION -->
            <li class="treeview <? if(stristr($_SERVER['PHP_SELF'],"_email.php") || stristr($_SERVER['PHP_SELF'],"chpassword.php")){ echo "active";}; ?>">
              <a href="#">
                <i class="fa fa-pencil-square-o"></i>
                <span>Admin Section</span>
                <i class="fa fa-angle-left pull-right"></i>                
              </a>
              <ul class="treeview-menu">
                <li><a href="manage_email.php"><i class="fa fa-circle-o"></i> General Configurations</a></li>
                <li><a href="chpassword.php"><i class="fa fa-circle-o"></i> Change Password</a></li>                
              </ul>
            </li>
            
          </ul>