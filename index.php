<?php
include('header.php');
?>
        <section class="wpo-hero-slider-s2">
            <div class="swiper-container swiper-container-horizontal">
                <div class="swiper-wrapper"
                    style="transition-duration: 0ms; transform: translate3d(-6076px, 0px, 0px);">
                    
                    <?php
        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_slider");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {            
            ?>
                    <div class="swiper-slide" data-swiper-slide-index="1"
                        style="width: 1519px; transition: all 0ms ease 0s;">
                        <div class="slide-inner slide-bg-image" data-background="assets/uploads/<?php echo $row['photo']; ?>"
                            style="transform: translate3d(1519px, 0px, 0px); transition: all 0ms ease 0s; background-image: url(&quot;assets/uploads/<?php echo $row['photo']; ?>&quot;);">
                            <!-- <div class="gradient-overlay"></div> -->
                            <div class="container">
                                <div class="slide-content">
                                    <div data-swiper-parallax="200" class="slide-title-top"
                                        style="transition-duration: 0ms; transform: translate3d(200px, 0px, 0px);">
                                        <span>Best Brand At The</span>
                                    </div>
                                    <div data-swiper-parallax="300" class="slide-title"
                                        style="transition-duration: 0ms; transform: translate3d(300px, 0px, 0px);">
                                        <h2><?php echo $row['heading']; ?></h2>
                                    </div>
                                    <div data-swiper-parallax="400" class="slide-text"
                                        style="transition-duration: 0ms; transform: translate3d(400px, 0px, 0px);">
                                        <p><?php echo nl2br($row['content']); ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div data-swiper-parallax="500" class="slide-btns"
                                        style="transition-duration: 0ms; transform: translate3d(500px, 0px, 0px);">
                                        <a href="<?php echo $row['button_url']; ?>" class="theme-btn"><?php echo $row['button_text']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end slide-inner -->
                    </div> <!-- end swiper-slide -->
                    <?php
            $i++;
        }
        ?>
                    
                </div>
                <!-- end swiper-wrapper -->

                <!-- swipper controls -->
                <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span
                        class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span
                        class="swiper-pagination-bullet"></span><span
                        class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>

        <!-- start of themart-featured-section -->
       
        <!-- end of themart-featured-section -->
        <section class="themart-special-product-section section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="wpo-section-title">
                            <h2>Deals Of The Day</h2>
                        </div>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-lg-6 col-12">
                        <div class="offer-wrap">
                            <div class="content">
                                <!-- <h2>Stylish Pink Court</h2>
                                <span class="offer-price">PKR 80</span>
                                <del>PKR 150</del> -->
                               
                                <!-- <div class="count-up">
                                    <div id="clock-s2">
                                        <div class="box">
                                            <div>
                                                <div class="time">00</div> <span>Days</span>
                                            </div>
                                        </div>
                                        <div class="box">
                                            <div>
                                                <div class="time">00</div> <span>Hours</span>
                                            </div>
                                        </div>
                                        <div class="box">
                                            <div>
                                                <div class="time">00</div> <span>Mins</span>
                                            </div>
                                        </div>
                                        <div class="box">
                                            <div>
                                                <div class="time">00</div> <span>Secs</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <a class="theme-btn" href="shop.php?id=1&type=top-category">Shop Now</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <ul class="special-product">
                            <li>
                                <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_deal INNER JOIN  tbl_product on tbl_product.p_id = tbl_deal.product_id WHERE id = 1");
                                    $statement->execute(array(1));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                                    $i = 0;                        
                                    foreach ($result as $row) {
                                ?>
                                <div class="product-item">
                                    <div class="image">
                                        <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="">
                                        <ul class="cart-wrap">
                                            <li>
                                                <a href="#" onclick="addtocartwishlist(<?php echo $row['p_id']; ?> , 'form_add_to_cart')" data-bs-toggle="tooltip" data-bs-html="true"
                                                    title="" data-bs-original-title="Add To Cart"
                                                    aria-label="Add To Cart"><i class="fi flaticon-add-to-cart"></i></a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                                                <a href="product-single.php?id=<?php echo $row['p_id']; ?>"><i
                                                        class="fi flaticon-eye"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" onclick="addtocartwishlist(<?php echo $row['p_id']; ?> , 'form_add_to_wishlist')" data-bs-toggle="tooltip" data-bs-html="true"
                                                    title="" data-bs-original-title="Wish List"
                                                    aria-label="Wish List"><i class="fi flaticon-heart"
                                                        aria-hidden="true"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="text">
                                        <h2><a href="product-single.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h2>
                                       
                                        <div class="price">
                                            <span class="present-price">PKR <?php echo $row['p_current_price']; ?></span>
                                            <?php if($row['p_old_price'] != ''): ?>
                                        <del class="old-price">PKR <?php echo $row['p_old_price']; ?></del>
                                        <?php endif; ?>
                                        </div>
                                        <div class="shop-btn">
                                            <a class="theme-btn-s2" href="product-single.php?id=<?php echo $row['p_id']; ?>">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>
                            </li>
                            <li>
                            <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_deal INNER JOIN  tbl_product on tbl_product.p_id = tbl_deal.product_id WHERE id = 2");
                                    $statement->execute(array(1));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                                    $i = 0;                        
                                    foreach ($result as $row) {
                                ?>
                                <div class="product-item">
                                    <div class="image">
                                        <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="">
                                        <ul class="cart-wrap">
                                            <li>
                                                <a href="#" onclick="addtocartwishlist(<?php echo $row['p_id']; ?> , 'form_add_to_cart')" data-bs-toggle="tooltip" data-bs-html="true"
                                                    title="" data-bs-original-title="Add To Cart"
                                                    aria-label="Add To Cart"><i class="fi flaticon-add-to-cart"></i></a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#popup-quickview">
                                                <a href="product-single.php?id=<?php echo $row['p_id']; ?>"><i
                                                        class="fi flaticon-eye"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" onclick="addtocartwishlist(<?php echo $row['p_id']; ?> , 'form_add_to_wishlist')" data-bs-toggle="tooltip" data-bs-html="true"
                                                    title="" data-bs-original-title="Wish List"
                                                    aria-label="Wish List"><i class="fi flaticon-heart"
                                                        aria-hidden="true"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="text">
                                        <h2><a href="product-single.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h2>
                                        
                                        <div class="price">
                                            <span class="present-price">PKR <?php echo $row['p_current_price']; ?></span>
                                            <?php if($row['p_old_price'] != ''): ?>
                                        <del class="old-price">PKR <?php echo $row['p_old_price']; ?></del>
                                        <?php endif; ?>
                                        </div>
                                        <div class="shop-btn">
                                            <a class="theme-btn-s2" href="product-single.php">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- start of themart-interestproduct-section -->
        <section class="themart-interestproduct-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wpo-section-title">
                            <h2>Products Of Your Interest</h2>
                        </div>
                    </div>
                </div>
                <div class="product-wrap">
                    <div class="row">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? AND p_current_price != '' ORDER BY p_id DESC LIMIT 8");
                    $statement->execute(array(1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                    $i = 0;                        
                    foreach ($result as $row) {
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="">
                                    <?php if ($row['p_old_price'] != ''): ?>
                                        <div class="tag new">Sale <?php echo intval(-(($row['p_current_price'] / $row['p_old_price']) * 100) + 100); ?>% </div><?php
                            
                            if($row['arive_date'] > date('Y-m-d')){
                                    ?>
                            <div class="product__sale">
                                <span class="tag sale arrive_soon">Arrive Soon</span>
                            </div>
                                    <?php
                                }  ?>
                                        
                                        <?php endif;?>
                                    <ul class="cart-wrap">
                                        <li>
                                            <a href="#" onclick="addtocartwishlist(<?php echo $row['p_id']; ?> , 'form_add_to_cart')" data-bs-toggle="tooltip" data-bs-html="true"
                                                title="Add To Cart"><i class="fi flaticon-add-to-cart"></i></a>
                                        </li>
                                        <li >
                                            <a href="product-single.php?id=<?php echo $row['p_id']; ?>"><i
                                                    class="fi flaticon-eye"></i></a>
                                        </li>
                                        <li>
                                            <a href="#" onclick="addtocartwishlist(<?php echo $row['p_id']; ?> , 'form_add_to_wishlist')" ><i class="fi flaticon-heart"
                                                    aria-hidden="true"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h2>
                                    
                                    <div class="price">
                                        <span class="present-price">PKR <?php echo $row['p_current_price']; ?></span>
                                        <?php if($row['p_old_price'] != ''): ?>
                                        <del class="old-price">PKR <?php echo $row['p_old_price']; ?></del>
                                        <?php endif; ?>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product-single.php?id=<?php echo $row['p_id']; ?>">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                        
                        
                        <div class="more-btn">
                            <a class="theme-btn-s2" href="shop.php?id=all&type=top-category">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of themart-interestproduct-section -->




        <!-- start of themart-trendingproduct-section -->
        <section class="themart-trendingproduct-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wpo-section-title">
                            <h2>Trending Products</h2>
                        </div>
                    </div>
                </div>
                <div class="trendin-slider owl-carousel">
                <?php
                    $statement = $pdo->prepare("SELECT tbl_product.* , count(tbl_order.id) as selles  FROM tbl_product INNER JOIN tbl_order ON tbl_product.p_id = tbl_order.product_id WHERE p_is_active=? AND p_current_price != '' GROUP BY tbl_product.p_id  ORDER BY selles DESC LIMIT 8");
                    $statement->execute(array(1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                    $i = 0;                        
                    foreach ($result as $row) {?>
                <div class="product-item">
                                <div class="image">
                                    <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="">
                                    <?php if ($row['p_old_price'] != ''): ?>
                                        <div class="tag new">Sale <?php echo intval(-(($row['p_current_price'] / $row['p_old_price']) * 100) + 100); ?>% </div><?php
                            
                            if($row['arive_date'] > date('Y-m-d')){
                                    ?>
                            <div class="product__sale">
                                <span class="tag sale arrive_soon">Arrive Soon</span>
                            </div>
                                    <?php
                                }  ?>
                                        
                                        <?php endif;?>
                                    <ul class="cart-wrap">
                                        <li>
                                            <a href="#" onclick="addtocartwishlist(<?php echo $row['p_id']; ?> , 'form_add_to_cart')" data-bs-toggle="tooltip" data-bs-html="true"
                                                title="Add To Cart"><i class="fi flaticon-add-to-cart"></i></a>
                                        </li>
                                        <li >
                                            <a href="product-single.php?id=<?php echo $row['p_id']; ?>"><i
                                                    class="fi flaticon-eye"></i></a>
                                        </li>
                                        <li>
                                            <a href="#" onclick="addtocartwishlist(<?php echo $row['p_id']; ?> , 'form_add_to_wishlist')" ><i class="fi flaticon-heart"
                                                    aria-hidden="true"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></h2>
                                    
                                    <div class="price">
                                        <span class="present-price">PKR <?php echo $row['p_current_price']; ?></span>
                                        <?php if($row['p_old_price'] != ''): ?>
                                        <del class="old-price">PKR <?php echo $row['p_old_price']; ?></del>
                                        <?php endif; ?>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product-single.php?id=<?php echo $row['p_id']; ?>">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                                        }
                            ?>
                    
                </div>
            </div>
        </section>
        <!-- end of themart-trendingproduct-section -->



        <!-- start of themart-cta-section -->
        <section class="themart-cta-section section-padding">
            <div class="container">
                <div class="cta-wrap">
                    <div class="row">
                        <div class="col-lg-6 col-md-8 col-12">
                            <div class="cta-content">
                                <h2>Subscribe Our Newsletter & <br>
                                    Get 30% Discounts For Next Order</h2>
                                <form method="post">
                                    <div class="input-1">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email..."
                                            required="">
                                        <div class="submit clearfix">
                                            <button class="theme-btn-s2" type="submit" name="subscribe">Subscribe</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of themart-cta-section -->
        <!-- start wpo-newsletter-popup-area-section -->
        <section class="wpo-newsletter-popup-area-section">
            <div class="wpo-newsletter-popup-area">
                <div class="wpo-newsletter-popup-ineer">
                    <button class="btn newsletter-close-btn"><i class="ti-close"></i></button>
                    <div class="img-holder">
                        <img src="assets/images/pop-up.jpg" alt>
                    </div>
                    <div class="details">
                        <h4>Get 30% discount shipped to your inbox</h4>
                        <p>Subscribe to the Themart eCommerce newsletter to receive timely updates to your favorite
                            products</p>
                        <form>
                            <div>
                                <input type="email" placeholder="Enter your email">
                                <button type="submit">Subscribe</button>
                            </div>
                            <div>
                                <label class="checkbox-holder"> Don't show this popup again!
                                    <input type="checkbox" class="show-message">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- end wpo-newsletter-popup-area-section -->

        <?php
include('footer.php');
?>