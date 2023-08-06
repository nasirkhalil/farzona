   <? $categories = $general->CustomQuery(" SELECT category_cat.name_cat,category_cat.id_cat,link_lk.links_lk AS link FROM category_cat
                                    JOIN link_lk ON link_lk.idtab_lk = category_cat.id_cat AND table_lk = 'category_cat'
                                    WHERE parent_cat = 0 AND status_cat = 1"); ?> 
    <!-- Header Section Begin -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="./index.html">Home</a></li>
                            <? foreach( $categories as $category ){ ?>
                              <li><a href="<?=$conf->site_url.$category['link']?>"><?=$category['name_cat']?></a>
                                  <? $sub_category =  $general->CustomQuery(" SELECT category_cat.name_cat,category_cat.id_cat,link_lk.links_lk AS link FROM category_cat
                                    JOIN link_lk ON link_lk.idtab_lk = category_cat.id_cat AND table_lk = 'category_cat'
                                    WHERE status_cat = 1 AND parent_cat = ".$category['id_cat']);
                                    if( is_array($sub_category) && count($sub_category) > 0 ){
                                      echo '<ul class="dropdown">';
                                      foreach( $sub_category as $scategory ){ ?>
                                         <li><a href="<?=$conf->site_url.$scategory['link']?>"><?=$scategory['name_cat']?></a></li>
                                  <?  }
                                      echo "</ul>";
                                    } ?>
                              </li>
                            <? } ?>
                            <!-- <li><a href="#">Women’s</a></li>
                            <li><a href="#">Men’s</a></li>
                            <li><a href="./shop.html">Shop</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="./product-details.html">Product Details</a></li>
                                    <li><a href="./shop-cart.html">Shop Cart</a></li>
                                    <li><a href="./checkout.html">Checkout</a></li>
                                    <li><a href="./blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="./blog.html">Blog</a></li> -->
                            <li><a href="./contact.html">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        <div class="header__right__auth">
                            <a href="<?=$conf->site_url?>login">Login</a>
                            <a href="<?=$conf->site_url?>register">Register</a>
                        </div>
                        <ul class="header__right__widget">
                            <li><span class="icon_search search-switch"></span></li>
                            <li><a href="#"><span class="icon_heart_alt"></span>
                                <div class="tip">2</div>
                            </a></li>
                            <li><a href="<?=$conf->site_url?>cart"><span class="icon_bag_alt"></span>
                                <div class="tip">2</div>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->