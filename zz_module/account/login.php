<?
  print_r($_POST);
include "inc_head.php"; ?>

<body>
  <!-- Page Preloder -->
  <!-- <div id="preloder">
        <div class="loader"></div>
    </div> -->

  <!-- Offcanvas Menu Begin -->
  <div class="offcanvas-menu-overlay"></div>
  <div class="offcanvas-menu-wrapper">
    <div class="offcanvas__close">+</div>
    <ul class="offcanvas__widget">
      <li><span class="icon_search search-switch"></span></li>
      <li><a href="#"><span class="icon_heart_alt"></span>
          <div class="tip">2</div>
        </a></li>
      <li><a href="#"><span class="icon_bag_alt"></span>
          <div class="tip">2</div>
        </a></li>
    </ul>
    <div class="offcanvas__logo">
      <a href="<?= $conf->site_url ?>"><img src="img/logo.png" alt=""></a>
    </div>
    <div id="mobile-menu-wrap"></div>
    <div class="offcanvas__auth">
      <a href="<?= $conf->site_url ?>cart">Login</a>
      <a href="<?= $conf->site_url ?>register">Register</a>
    </div>
  </div>
  <!-- Offcanvas Menu End -->

  <!-- Header Section Begin -->
  <? include "inc_header.php";  ?>
  <!-- Header Section End -->

  <!-- Breadcrumb Begin -->
  <div class="breadcrumb-option">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb__links">
            <a href="<?= $conf->site_url ?>"><i class="fa fa-home"></i> Home</a>
            <span>Login</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumb End -->

  <!-- Checkout Section Begin -->
  <section class="checkout spad">
    <div class="container">
      <!-- <div class="row">
                <div class="col-lg-12">
                    <h6 class="coupon__link"><span class="icon_tag_alt"></span> <a href="#">Have a coupon?</a> Click
                    here to enter your code.</h6>
                </div>
            </div> -->
      <form action="" method="post"  class="checkout__form">
        <div class="row">
          <div class="col-lg-12">
            <h5>Login</h5>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="checkout__form__input">
                  <p>Email or Mobile <span>*</span></p>
                  <input type="text" name="mobile_email">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="checkout__form__input">
                  <p>Password <span>*</span></p>
                  <input type="text" name="password">
                </div>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-6">
                 <button type="submit" name="btn_register" value="1" class="site-btn" style="margin-top: 33px;">Log In</button>
              </div>
            </div>
            <div class="row">
              <p>Don't have account <a href="<?=$conf->site_url?>register">Register</a></p>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- Checkout Section End -->

  <!-- Footer Section Begin -->
  <? include "inc_footer.php"; ?>
  <!-- Footer Section End -->

  <!-- Search Begin -->
  <div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
      <div class="search-close-switch">+</div>
      <form class="search-model-form">
        <input type="text" id="search-input" placeholder="Search here.....">
      </form>
    </div>
  </div>
  <!-- Search End -->
  <? include "inc_script.php"; ?>