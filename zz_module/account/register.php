<?
include "inc_head.php";
//check mobile exist
if (isset($_POST['btn_register'])) {
  $customer_salt = "U_rX3Qn3LcTW&";
  $name     = $_POST['first_name'];
  $email    = $_POST['email'];
  $mobile   = $_POST['mobile'];
  $password = $_POST['password'];
  // $confirm_password = $_POST['confirm_password'];
  $password = $general->hashthepass($password, $customer_salt);
  $inserts = "name,email,mobile,password,salt";
  $values = "'" . $name . "'
			 ,'" . $email . "'
			 ,'" . $mobile . "'
			 ,'" . $password . "'
			 ,'" . $customer_salt . "'";
  $register_query = $general->InsertRecord("customers", $inserts, $values);
}
?>
<style>
  label.error.fail-alert {
    /* border: 1px solid red; */
    color: red;
    border-radius: 4px;
    line-height: 1;
    /* padding: 2px 0 6px 6px; */
    /* background: #ffe6eb; */
  }

  input.fail-alert {
    border: 1px solid red !important;
    font-weight: 300;
    color: red !important;
  }

  input.valid.success-alert {
    border: 1px solid #4CAF50;
    color: green;
  }
</style>

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
            <span>Register</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumb End -->
  <!-- Checkout Section Begin -->
  <section class="checkout spad">
    <div class="container">
      <? if ( @$register_query > 0 ) { ?>
        <div class="alert alert-success" role="alert">
          You have registered, successfully.
        </div>
      <? } ?>
      <!-- <div class="row">
                <div class="col-lg-12">
                    <h6 class="coupon__link"><span class="icon_tag_alt"></span> <a href="#">Have a coupon?</a> Click
                    here to enter your code.</h6>
                </div>
            </div> -->
      <form action="" method="post" class="checkout__form" id="frm_register">
        <div class="row">
          <div class="col-lg-12">
            <h5>Register</h5>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="checkout__form__input">
                  <p>First Name <span>*</span></p>
                  <input type="text" name="first_name" id="first_name">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="checkout__form__input">
                  <p>Mobile <span>*</span></p>
                  <input type="text" name="mobile" id="mobile">
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="checkout__form__input">
                  <p>Email <span>*</span></p>
                  <input type="email" name="email" id="email">
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="checkout__form__input">
                  <p>Password <span>*</span></p>
                  <input type="text" name="password" id="password">
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="checkout__form__input">
                  <p>Confirm Password <span>*</span></p>
                  <input type="text" name="confirm_password">
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6">
              <button type="submit" name="btn_register" value="1" class="site-btn" style="margin-top: 33px;">Register</button>
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
  <script src="<?= $conf->assets_url ?>js/jquery.validate.min.js"></script>
  <script>
    $(document).on('keyup blur', '#mobile', function() {
      var $this = $(this);
      $.ajax({
        type: "POST",
        url: "<?= $conf->site_url ?>" + "zz_module/account/ajax_check.php",
        data: {
          mobile_no: $this.val(),
          check_mobile: 1
        },
        success: function(response) {
          $this.html(old_text);
        }
      });
    });
    ///
    $(document).on('keyup', '#email', function() {
      var $this = $(this);
      $.ajax({
        type: "POST",
        url: "<?= $conf->site_url ?>" + "zz_module/account/ajax_check.php",
        data: {
          email: $this.val(),
          check_email: 1
        },
        success: function(response) {
          $this.html(old_text);
        }
      });
    });
    $(document).ready(function() {
      $("#frm_register").validate({
        errorClass: "error fail-alert",
        validClass: "valid success-alert",
        rules: {
          first_name: {
            required: true,
            minlength: 3
          },
          mobile: {
            required: true,
            number: true,
            maxlength: 8,
            minlength: 8
          },
          email: {
            required: true,
          },
          password: {
            required: true,
          },
          confirm_password: {
            required: true,
            equalTo: "#password"
          }
        },
        messages: {
          first_name: {
            required: "Name is Required."
          },
          mobile: {
            minlength: "Mobile should be 8 digits"
          },
          password: {
            required: "Password is required"
          },
          confirm_password: {
            required: "Confirm password field is required",
            equalTo: "Confirm password not matched"
          }
        }
      });
    });
  </script>