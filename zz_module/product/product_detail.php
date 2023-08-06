<? $product = $general->getSingdet(" product_prd WHERE id_prd = " . $pagedetails[0]['idtab_lk']);
// echo count($product); die;
if (is_array($product) && count($product) > 0) {
  $product =  $product[0];
  $size_query = "SELECT size_details.id AS size_id, size_details.name AS size_name,product_sizes.available_quantity   FROM product_sizes JOIN size_details ON size_details.id = product_sizes.size_detail_id
			 								WHERE product_sizes.product_id=" . $product['id_prd'];
  $product_sizes  = $general->CustomQuery($size_query);
  $product_images = $general->getAll("prdimages_img WHERE idprd_img=" . $product['id_prd']);
  //related products query
  $qry = "SELECT name_prd,sale_price,thumb_name_prd,links_lk AS link FROM product_prd
    JOIN link_lk ON link_lk.idtab_lk = product_prd.id_prd AND table_lk = 'product_prd'
	  WHERE idcat_prd = " . $product['idcat_prd'] . " AND status_prd = 1";
  $related_products = $general->CustomQuery($qry);
  //  echo "<pre>"; print_r($product_sizes); die;
}
include "inc_head.php"; ?>
<style>
  label.product_size {
    border: 1px solid grey;
    border-radius: 5px;
    padding: 12px;
  }

  label.active {
    border: 1px solid red;
    border-radius: 5px;
    padding: 12px;
  }
  .size_error{
    color:red !important;
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
            <a href="./index.html"><i class="fa fa-home"></i> Home</a>
            <a href="#">Women’s </a>
            <span><?= $product['name_prd'] ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumb End -->

  <!-- Product Details Section Begin -->
  <section class="product-details spad">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="product__details__pic">
            <div class="product__details__pic__left product__thumb nice-scroll">
              <?
              if (is_array($product_images) && count($product_images) > 0) {
                foreach ($product_images as $key => $product_image) {
              ?>
                  <a class="pt active" href="#product-<?= $key ?>">
                    <img src="<?= $conf->site_url . $conf->gallery_dir . "_" . $product_image['name_img'] ?>" alt="">
                  </a>
              <? }
              } ?>
            </div>
            <div class="product__details__slider__content">
              <div class="product__details__pic__slider owl-carousel">
                <?
                if (is_array($product_images) && count($product_images) > 0) {
                  foreach ($product_images as $key => $product_image) {
                ?>
                    <img data-hash="product-<?= $key ?>" class="product__big__img" src="<?= $conf->site_url . $conf->gallery_dir . $product_image['name_img'] ?>" alt="">
                <? }
                } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="product__details__text">
            <h3><?= $product['name_prd'] ?> <!--<span>Brand: SKMEIMore Men Watches from SKMEI</span>--></h3>
            <div class="rating">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <span>( 138 reviews )</span>
            </div>
            <div class="product__details__price"><?= $product['sale_price'] ?> <span><?= $product['price_prd'] ?></span></div>

            <div class="product__details__button">
              <div class="quantity">
                <span>Quantity:</span>
                <div class="pro-qty">
                  <input type="text" id="product_quantity" value="1">
                </div>
              </div>
              <a href="javascript:void(0)" class="cart-btn btn_add_to_cart"><span class="icon_bag_alt"></span> Add to cart</a>
              <ul>
                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
              </ul>
            </div>
            <div class="product__details__widget">
              <ul>
                <!-- <li>
									<span>Availability:</span>
									<div class="stock__checkbox">
										<label for="stockin">
											In Stock
											<input type="checkbox" id="stockin">
											<span class="checkmark"></span>
										</label>
									</div>
								</li> -->
                <!-- <li>
										<span>Available color:</span>
										<div class="color__checkbox">
												<label for="red">
														<input type="radio" name="color__radio" id="red" checked>
														<span class="checkmark"></span>
												</label>
												<label for="black">
														<input type="radio" name="color__radio" id="black">
														<span class="checkmark black-bg"></span>
												</label>
												<label for="grey">
														<input type="radio" name="color__radio" id="grey">
														<span class="checkmark grey-bg"></span>
												</label>
										</div>
								</li> -->
                <li>
                  <p class="size_error"></p>
                  <span>Available size:</span>
                  <div class="size__btn">
                    <? if (is_array($product_sizes) && count($product_sizes) > 0) {
                      foreach ($product_sizes as $key => $product_size) { ?>
                        <label for="xs-btn<?= $key ?>" class="product_size">
                          <input type="radio" name="product_size" value="<?= $product_size['size_id'] ?>" id="xs-btn<?= $key ?>">
                          <?= $product_size['size_name'] ?>
                        </label>
                    <? }
                    } else {
                      echo "Size not Available.";
                    } ?>
                    <!-- <label for="s-btn">
											<input type="radio" id="s-btn">
											s
										</label>
										<label for="m-btn">
											<input type="radio" id="m-btn">
											m
										</label>
										<label for="l-btn">
											<input type="radio" id="l-btn">
											l
										</label> -->
                  </div>
                </li>
                <!-- <li>
									<span>Promotions:</span>
									<p>Free shipping</p>
								</li> -->
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="product__details__tab">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
              </li>
              <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                            </li> -->
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tabs-1" role="tabpanel">
                <!-- <h6>Description</h6> -->
                <?= $product['details_prd'] ?>
              </div>
              <!-- <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <h6>Specification</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                quis, sem.</p>
                            </div> -->
              <div class="tab-pane" id="tabs-3" role="tabpanel">
                <h6>Reviews ( 2 )</h6>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="related__title">
            <h5>RELATED PRODUCTS</h5>
          </div>
        </div>
        <?
        if (is_array($related_products) && count($related_products) > 0) {
          foreach ($related_products as $related_product) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="product__item">
                <div class="product__item__pic set-bg" data-setbg="<?= $conf->site_url . $conf->product_dir . $related_product['thumb_name_prd'] ?>">
                  <div class="label new">New</div>
                  <ul class="product__hover">
                    <li><a href="<?= $conf->site_url . $conf->product_dir . $related_product['thumb_name_prd'] ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                  </ul>
                </div>
                <div class="product__item__text">
                  <h6><a href="<?= $conf->site_url . $related_product['link'] ?>"><?= $related_product['name_prd'] ?></a></h6>
                  <!-- <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                  </div> -->
                  <div class="product__price"><?= $related_product['sale_price'] ?></div>
                </div>
              </div>
            </div>
        <? }
        } ?>
      </div>
    </div>
  </section>
  <!-- Product Details Section End -->
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
  <script>
    var product_size_id = 0;
    var product_id = <?= $product['id_prd'] ?>;

    $(document).on('click', '.product_size', function() {
      // alert("product id is=" + product_id);
      product_size_id = $('input[name="product_size"]:checked').val();
      $(this).addClass('active');
      $('.size_error').html('');
    });
    $(document).on('click', '.btn_add_to_cart', function() {
      if( product_size_id < 1 ){
        $('#product_quantity').focus();
        $('.size_error').html('Please Select Size.');
        return;
      }
      var $this = $(this);
      // alert($this.html());
      var old_text = $this.html();
      $this.text('Adding...');
      // alert('add to cart');
      var product_quantity = $('#product_quantity').val();
      $.ajax({
        type: "POST",
        url: "<?= $conf->site_url ?>" + "zz_module/cart/add_to_cart.php",
        data: {
          product_id: product_id,
          product_size_id: product_size_id,
          product_quantity: product_quantity
        },
        success: function(response) {
          $this.html(old_text);
        }
      });
    });
  </script>