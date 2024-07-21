<?php
ob_start();
session_start();

include "admin/inc/config.php";
include "admin/inc/functions.php";
include "admin/inc/CSRF_Protect.php";
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Getting all language variables into array as global variable
$i = 1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    define('LANG_VALUE_' . $i, $row['lang_value']);
    $i++;
}

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $logo = $row['logo'];
    $favicon = $row['favicon'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $meta_title_home = $row['meta_title_home'];
    $meta_keyword_home = $row['meta_keyword_home'];
    $meta_description_home = $row['meta_description_home'];
    $before_head = $row['before_head'];
    $after_body = $row['after_body'];
}

// Checking the order table and removing the pending transaction that are 24 hours+ old. Very important
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $ts1 = strtotime($row['payment_date']);
    $ts2 = strtotime($current_date_time);
    $diff = $ts2 - $ts1;
    $time = $diff / (3600);
    if ($time > 24) {

        // Return back the stock amount
        $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement1->execute(array($row['payment_id']));
        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result1 as $row1) {
            $statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
            $statement2->execute(array($row1['product_id']));
            $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result2 as $row2) {
                $p_qty = $row2['p_qty'];
            }
            $final = $p_qty + $row1['quantity'];

            $statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
            $statement->execute(array($final, $row1['product_id']));
        }

        // Deleting data from table
        $statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
        $statement1->execute(array($row['payment_id']));

        $statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
        $statement1->execute(array($row['id']));
    }
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <link rel="shortcut icon" type="image/png" href="assets/uploads/<?php echo $favicon; ?>">
    <?php

    $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $about_meta_title = $row['about_meta_title'];
        $about_meta_keyword = $row['about_meta_keyword'];
        $about_meta_description = $row['about_meta_description'];
        $faq_meta_title = $row['faq_meta_title'];
        $faq_meta_keyword = $row['faq_meta_keyword'];
        $faq_meta_description = $row['faq_meta_description'];
        $blog_meta_title = $row['blog_meta_title'];
        $blog_meta_keyword = $row['blog_meta_keyword'];
        $blog_meta_description = $row['blog_meta_description'];
        $contact_meta_title = $row['contact_meta_title'];
        $contact_meta_keyword = $row['contact_meta_keyword'];
        $contact_meta_description = $row['contact_meta_description'];
        // $pgallery_meta_title = $row['pgallery_meta_title'];
        // $pgallery_meta_keyword = $row['pgallery_meta_keyword'];
        // $pgallery_meta_description = $row['pgallery_meta_description'];
        // $vgallery_meta_title = $row['vgallery_meta_title'];
        // $vgallery_meta_keyword = $row['vgallery_meta_keyword'];
        // $vgallery_meta_description = $row['vgallery_meta_description'];
    }

    $cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

   // if ($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'shop.php' || $cur_page == 'product-single.php') {
        ?>
        <title>
            <?php echo $meta_title_home; ?>
        </title>
        <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
        <meta name="description" content="<?php echo $meta_description_home; ?>">
        <?php
    //} ?>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/flaticon_ecommerce.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/owl.carousel.css" rel="stylesheet">
    <link href="assets/css/owl.theme.css" rel="stylesheet">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/slick-theme.css" rel="stylesheet">
    <link href="assets/css/swiper.min.css" rel="stylesheet">
    <link href="assets/css/owl.transitions.css" rel="stylesheet">
    <link href="assets/css/jquery.fancybox.css" rel="stylesheet">
    <link href="assets/css/odometer-theme-default.css" rel="stylesheet">
    <link href="assets/sass/style.css" rel="stylesheet">
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <!--<img width="70%" src="assets/uploads/<?php echo $logo; ?>" alt="">-->
                </div>
            </div>
        </div>
        <!-- end preloader -->

        <!--  start header-middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index.php"><img width="70%"
                                    src="assets/uploads/<?php echo $logo; ?> " alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-12">
                        <form action="search_result.php" class="middle-box" method="post">
                            <div class="category">
                                <select name="service" class="form-control">
                                    <option selected="" value="">All Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) {

                                        ?>
                                        <option value="<?php echo $row['tcat_id']; ?>"><?php echo $row['tcat_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                    <option value="">All Of The Above</option>
                                </select>
                            </div>
                            <div class="search-box">
                                <div class="input-group">
                                    <input type="search" class="form-control" name="search_text" placeholder="What are you looking for?">
                                    <button class="search-btn" type="submit"> <i class="fi flaticon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="middle-right" id="wishlist-cart">
                            <ul>
                                <?php
                                if (isset($_SESSION['customer'])) {
                                    ?>

                                    <li><a href="dashboard.php"><i class="fa fi fa-tachometer "></i><span class="">Dashboard</span></a></li>
                                    <li><a href="logout.php"><i class="fa-sign-out fa fi"></i><span>Logout</span></a></li>
                                    <li>
                                        <div class="header-wishlist-form-wrapper">
                                            <?php
$statement = $pdo->prepare("SELECT * FROM `tbl_wishlist` INNER JOIN `tbl_product` ON `tbl_product`.`p_id` = `tbl_wishlist`.`product_id` WHERE  `tbl_wishlist`.`cust_id` = ?;");
$statement->execute(array(
                       
                        $_SESSION['customer']['cust_id']
                    ));  
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount(PDO::FETCH_ASSOC);

                                            ?>
                                            <button class="wishlist-toggle-btn"> <i class="fi flaticon-heart"></i>
                                               <?php echo ($count > 0) ?  ' <span class="cart-count">'.$count.'</span>' : "";?></button>
                                            <div class="mini-wislist-content">
                                                <button class="mini-cart-close"><i class="ti-close"></i></button>
                                                <div class="mini-cart-items">
                                                    <?php
                                                    foreach($result as $row)
                                                    {
                                                        ?>
                                                        <div class="mini-cart-item clearfix">
                                                        <div class="mini-cart-item-image">
                                                            <a href="#"><img src="assets/uploads/<?php echo $row['p_featured_photo'];?>" alt></a>
                                                        </div>
                                                        <div class="mini-cart-item-des">
                                                            <a href="#"><?php echo $row['p_name'];?></a>
                                                            <span class="mini-cart-item-price">PKR <?php echo $row['p_current_price'];?> x 1</span>
                                                            <span class="mini-cart-item-quantity"><a href="wishlist_item_delete.php?id=<?php echo $row['id'];?>"><i
                                                                        class="ti-close"></i></a></span>
                                                        </div>
                                                    </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                    
                                                </div>
                                                <div class="mini-cart-action clearfix">
                                                    <!-- <span class="mini-checkout-price">Subtotal:
                                                        <span>$410</span></span> -->
                                                    <div class="mini-btn">
                                                        <a href="checkout.php" class="view-cart-btn s1">Checkout</a>
                                                        <a href="wishlist.php" class="view-cart-btn">View Wishlist</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a href="login.php"><i class="fi flaticon-user-profile"></i><span>Login</span></a>
                                    </li>

                                    <?php
                                }
                                ?>



                                <li>
                                    <div class="mini-cart">
                                        <?php if (!isset($_SESSION['cart_p_id'])): ?>
                                            <?php
                                            $arr_cart_p_id = []; ?>
                                        <?php else: ?>
                                            <?php
                                            $table_total_price = 0;

                                            $i = 0;
                                            foreach ($_SESSION['cart_p_id'] as $key => $value) {
                                                $i++;
                                                $arr_cart_p_id[$i] = $value;
                                            }

                                            $i = 0;
                                            foreach ($_SESSION['cart_size_id'] as $key => $value) {
                                                $i++;
                                                $arr_cart_size_id[$i] = $value;
                                            }

                                            $i = 0;
                                            foreach ($_SESSION['cart_size_name'] as $key => $value) {
                                                $i++;
                                                $arr_cart_size_name[$i] = $value;
                                            }

                                            $i = 0;
                                            foreach ($_SESSION['cart_color_id'] as $key => $value) {
                                                $i++;
                                                $arr_cart_color_id[$i] = $value;
                                            }

                                            $i = 0;
                                            foreach ($_SESSION['cart_color_name'] as $key => $value) {
                                                $i++;
                                                $arr_cart_color_name[$i] = $value;
                                            }

                                            $i = 0;
                                            $arr_cart_p_qty = [];
                                            foreach ($_SESSION['cart_p_qty'] as $key => $value) {
                                                $i++;
                                                $arr_cart_p_qty[$i] = $value;
                                            }

                                            $i = 0;
                                            foreach ($_SESSION['cart_p_current_price'] as $key => $value) {
                                                $i++;
                                                $arr_cart_p_current_price[$i] = $value;
                                            }

                                            $i = 0;
                                            foreach ($_SESSION['cart_p_name'] as $key => $value) {
                                                $i++;
                                                $arr_cart_p_name[$i] = $value;
                                            }

                                            $i = 0;
                                            foreach ($_SESSION['cart_p_featured_photo'] as $key => $value) {
                                                $i++;
                                                $arr_cart_p_featured_photo[$i] = $value;
                                            }
                                            ?>
                                        <?php endif; ?>
                                        <button class="cart-toggle-btn"> <i class="fi flaticon-add-to-cart"></i>
                                            <span class="cart-count">
                                                <?php echo count($arr_cart_p_id) ?>
                                            </span></button>
                                        <div class="mini-cart-content">
                                            <button class="mini-cart-close"><i class="ti-close"></i></button>
                                            <div class="mini-cart-items">
                                                <?php if (!isset($_SESSION['cart_p_id'])): ?>
                                                    <?php
                                                    echo "Cart is empty";
                                                    ?>

                                                <?php else: ?>

                                                    <?php for ($i = 1; $i <= count($arr_cart_p_id); $i++): ?>
                                                        <div class="mini-cart-item clearfix">
                                                            <div class="mini-cart-item-image">
                                                                <a href="#"><img
                                                                        src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>"
                                                                        alt></a>
                                                            </div>
                                                            <div class="mini-cart-item-des">
                                                                <a href="#">
                                                                    <?php echo $arr_cart_p_name[$i]; ?>
                                                                </a>
                                                                <span class="mini-cart-item-price">PKR
                                                                    <?php echo $arr_cart_p_current_price[$i]; ?> x
                                                                    <?php echo $arr_cart_p_qty[$i]; ?>
                                                                </span>
                                                                <span class="mini-cart-item-quantity"><a
                                                                        onclick="return confirmDelete();"
                                                                        href="cart-item-delete.php?id=<?php echo $arr_cart_p_id[$i]; ?>&size=<?php echo $arr_cart_size_id[$i]; ?>&color=<?php echo $arr_cart_color_id[$i]; ?>"><i
                                                                            class="ti-close"></i></a></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $row_total_price = $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i];
                                                        $table_total_price = $table_total_price + $row_total_price;
                                                        ?>
                                                    <?php endfor;

                                                    ?>


                                                </div>
                                                <div class="mini-cart-action clearfix">
                                                    <span class="mini-checkout-price">Subtotal:
                                                        <span>
                                                            <?php echo $table_total_price; ?>
                                                        </span></span>
                                                    <div class="mini-btn">
                                                        <a href="checkout.php" class="view-cart-btn s1">Checkout</a>
                                                        <a href="cart.php" class="view-cart-btn">View Cart</a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  end header-middle -->
        <div class="wpo-site-header">
            <nav class="navigation navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-lg-none dl-block">
                            <div class="mobail-menu">
                                <button type="button" class="navbar-toggler open-btn">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar first-angle"></span>
                                    <span class="icon-bar middle-angle"></span>
                                    <span class="icon-bar last-angle"></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-6 col-sm-5 col-6 d-block d-lg-none">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="#"><img src="assets/uploads/<?php echo $logo; ?>"
                                        alt="logo"></a>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-1 col-1">
                            <div id="navbar" class="collapse navbar-collapse navigation-holder">
                                <button class="menu-close"><i class="ti-close"></i></button>
                                <ul class="nav navbar-nav mb-2 mb-lg-0">
                                <li class="menu-item"> <a
                                                href="customer_panel">Seller Panel</a>
                                                    </li>
                                <li class="menu-item"> <a
                                                href="shop.php?id=all&type=top-category">New Arrivals</a>
                                                    </li>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) {

                                        ?>
                                        <li class="menu-item-has-children"> <a
                                                href="shop.php?id=<?php echo $row['tcat_id']; ?>&type=top-category"><?php echo $row['tcat_name']; ?></a>
                                        <ul class="sub-menu">
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = {$row['tcat_id']} ");
                                            $statement1->execute();
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                ?>

                                                <li> <a
                                                        href="shop.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category"><?php echo $row1['mcat_name']; ?></a></li>

                                                <?php

                                            } ?>
                                        </ul>
                                        </li>
                                        <?php
                                    }
                                    ?>





                                </ul>

                            </div><!-- end of nav-collapse -->
                        </div>

                    </div>
                </div><!-- end of container -->
            </nav>
        </div>
        </header>
        <?php
            if(isset($_POST['subscribe']))
            {
                $subsc_email = $_POST['email'];
                $statement = $pdo->prepare("INSERT INTO `tbl_subscriber`( `subs_email`, `subs_date`, `subs_date_time` , subs_active)  VALUES ('$subsc_email' , CURRENT_TIME() , CURRENT_TIME() , 1)");
                $statement->execute();
            }
        ?>
        <!-- end of header -->