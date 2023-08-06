<? include "inc_head.php";
$qry = "SELECT *,cart_details.id AS cart_detail_id FROM carts JOIN cart_details ON cart_details.cart_id = carts.id
          WHERE carts.session_id='" . session_id() . "'";
$carts = $general->CustomQuery($qry);

// echo "<pre>"; print_r($carts);
?>

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
      <a href="./index.html"><img src="img/logo.png" alt=""></a>
    </div>
    <div id="mobile-menu-wrap"></div>
    <div class="offcanvas__auth">
      <a href="#">Login</a>
      <a href="#">Register</a>
    </div>
  </div>
  <!-- Offcanvas Menu End -->

  <!-- Header Section Begin -->
  <? include "inc_header.php"; ?>
  <!-- Header Section End -->

  <!-- Breadcrumb Begin -->
  <div class="breadcrumb-option">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb__links">
            <a href="<?=$conf->site_url?>"><i class="fa fa-home"></i> Home</a>
            <span>Cart</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumb End -->

  <!-- Shop Cart Section Begin -->
  <section class="shop-cart spad">
    <? if (is_array($carts) && count($carts) > 0) {
        $g_sub_total = 0; ?>
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="shop__cart__table">
              <table>
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <? foreach ($carts as $key => $cart) {
                    $sub_total = $cart['product_price'] * $cart['product_quantity'];
                    $g_sub_total += $sub_total; ?>
                    <tr>
                      <td class="cart__product__item">
                        <img src="<?=$conf->site_url . $conf->product_dir ."_".$cart['product_image'] ?>" alt="">
                        <div class="cart__product__item__title">
                          <h6><?= $cart['product_name'] ?></h6><br>
                          color: <?=$cart['product_color']?> Size: <?=$cart['product_size']?>
                          <!-- <div class="rating">
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                        </div> -->
                        </div>
                      </td>
                      <td class="cart__price"><?= $cart['product_price'] ?> AED</td>
                      <td class="cart__quantity">
                        <div class="pro-qty">
                          <input type="text" value="<?=$cart['product_quantity']?>">
                        </div>
                      </td>
                      <td class="cart__total"><?= $sub_total ?> AED</td>
                      <td class="cart__close"><span class="icon_close" onclick="deleteCartItem(<?=$cart['cart_detail_id']?>)"></span></td>
                    </tr>
                  <? } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="cart__btn">
              <a href="#">Continue Shopping</a>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="cart__btn update__btn">
              <a href="#"><span class="icon_loading"></span> Update cart</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="discount__content">
              <h6>Discount codes</h6>
              <form action="#">
                <input type="text" placeholder="Enter your coupon code">
                <button type="submit" class="site-btn">Apply</button>
              </form>
            </div>
          </div>
          <?
            $grand_total = $g_sub_total;
          ?>
          <div class="col-lg-4 offset-lg-2">
            <div class="cart__total__procced">
              <h6>Cart total</h6>
              <ul>
                <li>Subtotal <span><?=$g_sub_total?> AED</span></li>
                <li>Total <span><?=$grand_total?> AED</span></li>
              </ul>
              <a href="<?=$conf->site_url?>checkout" class="primary-btn">Proceed to checkout</a>
            </div>
          </div>
        </div>
      </div>
    <? } else { ?>
      <p style="margin-left: 80px; color:red">Your cart is empty.</p>
    <? } ?>
  </section>
  <!-- Shop Cart Section End -->



  <? include "inc_footer.php"; ?>

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
  <script>
    function deleteCartItem(cart_id){
      if(!confirm("Are you sure, you want to delete.")){
        return false;
      }
      $.ajax({
        type: "POST",
        url: "<?= $conf->site_url ?>" + "zz_module/cart/delete_from_cart.php",
        data: {
          cart_id:cart_id
        },
        dataType: 'json',
        success: function(res) {
          // $this.html(old_text);
          // alert(res);
          if( res.status ){
            location.reload();
          }
        }
      });
    }
  </script>