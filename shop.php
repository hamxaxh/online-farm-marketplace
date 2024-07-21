<?php require_once 'header.php';?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_product_category = $row['banner_product_category'];
}
?>

<?php
if (!isset($_REQUEST['id']) || !isset($_REQUEST['type'])) {
    header('location: index.php');
    exit;
} else {
    $newProduct_date = "1970-01-01";
    if($_REQUEST['id'] == "all")
    {
        $current_date = date("Y-m-d");
        $newProduct_date = date("Y-m-d", strtotime($current_date . " -4 days"));
    }
    if (($_REQUEST['type'] != 'top-category') && ($_REQUEST['type'] != 'mid-category') && ($_REQUEST['type'] != 'end-category')) {
        header('location: index.php');
        exit;
    } else {

        $statement = $pdo->prepare("SELECT * FROM tbl_top_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $top[] = $row['tcat_id'];
            $top1[] = $row['tcat_name'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $mid[] = $row['mcat_id'];
            $mid1[] = $row['mcat_name'];
            $mid2[] = $row['tcat_id'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_end_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $end[] = $row['ecat_id'];
            $end1[] = $row['ecat_name'];
            $end2[] = $row['mcat_id'];
        }

        if ($_REQUEST['type'] == 'top-category') {
            
            if (!in_array($_REQUEST['id'], $top) && $_REQUEST['id'] != "all") {
                header('location: index.php');
                exit;
            } else {

                // Getting Title
                for ($i = 0; $i < count($top); $i++) {
                    if ($top[$i] == $_REQUEST['id']) {
                        $title = $top1[$i];
                        break;
                    }
                }
                $arr1 = array();
                $arr2 = array();
                // Find out all ecat ids under this
                for ($i = 0; $i < count($mid); $i++) {
                    if ($mid2[$i] == $_REQUEST['id'] || $_REQUEST['id'] == "all") {
                        $arr1[] = $mid[$i];
                    }
                }
                for ($j = 0; $j < count($arr1); $j++) {
                    for ($i = 0; $i < count($end); $i++) {
                        if ($end2[$i] == $arr1[$j]) {
                            $arr2[] = $end[$i];
                        }
                    }
                }
                $final_ecat_ids = $arr2;
            }
        }

        if ($_REQUEST['type'] == 'mid-category') {
            if (!in_array($_REQUEST['id'], $mid)) {
                header('location: index.php');
                exit;
            } else {
                // Getting Title
                for ($i = 0; $i < count($mid); $i++) {
                    if ($mid[$i] == $_REQUEST['id']) {
                        $title = $mid1[$i];
                        break;
                    }
                }
                $arr2 = array();
                // Find out all ecat ids under this
                for ($i = 0; $i < count($end); $i++) {
                    if ($end2[$i] == $_REQUEST['id']) {
                        $arr2[] = $end[$i];
                    }
                }
                $final_ecat_ids = $arr2;
            }
        }

        if ($_REQUEST['type'] == 'end-category') {
            if (!in_array($_REQUEST['id'], $end)) {
                header('location: index.php');
                exit;
            } else {
                // Getting Title
                for ($i = 0; $i < count($end); $i++) {
                    if ($end[$i] == $_REQUEST['id']) {
                        $title = $end1[$i];
                        break;
                    }
                }
                $final_ecat_ids = array($_REQUEST['id']);
            }
        }

    }
}

?>


        <!-- start wpo-page-title -->
        <section class="wpo-page-title">
            <h2 class="d-none">Hide</h2>
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="wpo-breadcumb-wrap">
                            <ol class="wpo-breadcumb-wrap">
                                <li><a href="index.php">Home</a></li>
                                <li>Shop</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- product-area-start -->
        <div class="shop-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="shop-filter-wrap">
                            <div class="filter-item">
                                <div class="shop-filter-item">
                                    <div class="shop-filter-search">
                                        <form method="post" action="search_result.php">
                                            <div>
                                                <input type="text" class="form-control" name="search_text" placeholder="Search..">
                                                <button type="submit"><i class="ti-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item category-widget">
                                    <h2>Categories</h2>
                                   
                            <nav class="sidebar  py-2 mb-4 ">
                                <ul class="nav flex-column" id="nav_accordion">
                                    <!--<li class="nav-item">-->
                                    <!--    <a class="nav-link" href="#"> Link name </a>-->
                                    <!--</li>-->
                                    <!--<li class="nav-item has-submenu">-->
                                    <!--    <a class="nav-link" href="#"> Submenu links </a>-->
                                    <!--    <ul class="submenu collapse">-->
                                    <!--        <li><a class="nav-link ps-40 " href="#">Submenu item 1 </a></li>-->
                                    <!--        <li><a class="nav-link ps-40" href="#">Submenu item 2 </a></li>-->
                                    <!--        <li><a class="nav-link ps-40" href="#">Submenu item 3 </a> </li>-->
                                    <!--    </ul>-->
                                    <!--</li>-->
                                    <!--<li class="nav-item has-submenu">-->
                                    <!--    <a class="nav-link" href="#"> More menus </a>-->
                                    <!--    <ul class="submenu collapse">-->
                                    <!--        <li><a class="nav-link ps-40" href="#">Submenu item 4 </a></li>-->
                                    <!--        <li><a class="nav-link ps-40" href="#">Submenu item 5 </a></li>-->
                                    <!--        <li><a class="nav-link ps-40" href="#">Submenu item 6 </a></li>-->
                                    <!--        <li><a class="nav-link ps-40" href="#">Submenu item 7 </a></li>-->
                                    <!--    </ul>-->
                                    <!--</li>-->
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) {

                                        ?>
                                        <li class="nav-item has-submenu"> <a  class="nav-link"
                                                href="shop.php?id=<?php echo $row['tcat_id']; ?>&type=top-category"><?php echo $row['tcat_name']; ?></a>
                                               <ul class="submenu collapse">
                                                   <li><a class="nav-link ps-40" href="shop.php?id=<?php echo $row['tcat_id']; ?>&type=top-category">All</a></li>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = {$row['tcat_id']} ");
                                            $statement1->execute();
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                ?>

                                                 <li><a class="nav-link ps-40" 
                                                        href="shop.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category"><?php echo $row1['mcat_name']; ?></a></li>

                                                <?php

                                            } ?>
                                        </ul>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <!--<li class="nav-item">-->
                                    <!--    <a class="nav-link" href="#"> Something </a>-->
                                    <!--</li>-->
                                    <!--<li class="nav-item">-->
                                    <!--    <a class="nav-link" href="#"> Other link </a>-->
                                    <!--</li>-->
                                </ul>
                            </nav>
                                </div>
                            </div>
                            <!-- <div class="filter-item">
                                <div class="shop-filter-item">
                                    <h2>Filter by price</h2>
                                    <div class="shopWidgetWraper">
                                        <div class="priceFilterSlider">
                                            <form action="#" method="get" class="clearfix">
                                                <div id="sliderRange"></div>
                                                <div class="pfsWrap">
                                                    <label>Price:</label>
                                                    <span id="amount"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item">
                                    <h2>Color</h2>
                                    <ul>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Green <span>(21)</span>
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Blue <span>(24)</span>
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Red<span>(13)</span>
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Brown<span>(27)</span>
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Yellow<span>(12)</span>
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                White<span>(32)
                                                </span>
                                                <input type="radio" name="topcoat2">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item">
                                    <h2>Size</h2>
                                    <ul>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Small <span>(10)</span>
                                                <input type="radio" name="topcoat3">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Medium<span>(24)</span>
                                                <input type="radio" name="topcoat3">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Large<span>(13)</span>
                                                <input type="radio" name="topcoat3">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                Extra Large<span>(18)</span>
                                                <input type="radio" name="topcoat3">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item new-product">
                                    <h2>New Products</h2>
                                    <ul>
                                        <li>
                                            <div class="product-card">
                                                <div class="card-image">
                                                    <div class="image">
                                                        <img src="assets/images/new-product/1.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <h3><a href="product-single.php">Stylish Pink Coat</a></h3>

                                                    <div class="price">
                                                        <span class="present-price">PKR 120.00</span>
                                                        <del class="old-price">PKR 200.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="product-card">
                                                <div class="card-image">
                                                    <div class="image">
                                                        <img src="assets/images/new-product/2.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <h3><a href="product-single.php">Blue Bag</a></h3>

                                                    <div class="price">
                                                        <span class="present-price">PKR 120.00</span>
                                                        <del class="old-price">PKR 200.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="product-card">
                                                <div class="card-image">
                                                    <div class="image">
                                                        <img src="assets/images/new-product/3.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <h3><a href="product-single.php">Kids Blue Shoes</a></h3>

                                                    <div class="price">
                                                        <span class="present-price">PKR 120.00</span>
                                                        <del class="old-price">PKR 200.00</del>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-item">
                                <div class="shop-filter-item tag-widget">
                                    <h2>Popular Tags</h2>
                                    <ul>
                                        <li><a href="#">Fashion</a></li>
                                        <li><a href="#">Shoes</a></li>
                                        <li><a href="#">Kids</a></li>
                                        <li><a href="#">Theme</a></li>
                                        <li><a href="#">Stylish</a></li>
                                        <li><a href="#">Women</a></li>
                                        <li><a href="#">Shop</a></li>
                                        <li><a href="#">Men</a></li>
                                        <li><a href="#">Blog</a></li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="shop-section-top-inner">
                           
                            <div class="shoping-list">
                                <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="grid-tab" data-bs-toggle="pill"
                                            data-bs-target="#grid" type="button" role="tab" aria-controls="grid"
                                            aria-selected="true"><i class="fa fa-th "></i></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="list-tab" data-bs-toggle="pill"
                                            data-bs-target="#list" type="button" role="tab" aria-controls="list"
                                            aria-selected="false"><i class="fa fa-list "></i></button>
                                    </li>
                                </ul>
                            </div>
                            <div class="short-by">
                                <ul>
                                    <li>
                                        Sort by:
                                    </li>
                                    <li>
                                    <select class="" id="sorting" onchange="sortProducts()" data-select2-id="select2-data-sorting" tabindex="-1" aria-hidden="true">
                                <option value="0" data-select2-id="select2-data-2-o494">Default Sorting</option>
                                <option value="1">Title</option>
                                <option value="2">Price: Low to High</option>
                                <option value="3">Price: High to Low</option>
                                <!-- <option value="4">Popular</option> -->


                            </select>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                                <div class="product-wrap">
                                    <div class="row align-items-center " id="item-container">
                                    <?php
// Checking if any product is available or not
$prod_count = 0;

$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE `date` > '$newProduct_date'  ");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$prod_table_ecat_ids = [];
foreach ($result as $row) {
    $prod_table_ecat_ids[] = $row['ecat_id'];
}

for ($ii = 0; $ii < count($final_ecat_ids); $ii++):
    if (in_array($final_ecat_ids[$ii], $prod_table_ecat_ids)) {
        $prod_count++;
    }
endfor;

if ($prod_count == 0) {
    echo '<div class="pl_15">No Product Found</div>';
} else {
    for ($ii = 0; $ii < count($final_ecat_ids); $ii++) {
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE `date` > '$newProduct_date' AND ecat_id=? AND p_is_active=? ");
        $statement->execute(array($final_ecat_ids[$ii], 1));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $i = 0;
        foreach ($result as $row) {
            $i++
            ?>

                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 product_item_sort">
                                    <div class="product-item">
                                        <div class="product_name_sort " style="display: none;">
                                        <?php echo $row['p_name']; ?>
                                        </div>
                                        <div class="current_price " style="display: none;">
                                        <?php echo $row['p_current_price']; ?>
                                        </div>
                                        <div class="product_ids_default " style="display: none;">
                                        <?php echo $i; ?>
                                        </div>
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
                                        <?php if ($row['p_old_price'] != ''): ?>
                                        <del class="old-price">PKR <?php echo $row['p_old_price']; ?></del>
                                        <?php endif;?>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product-single.php?id=<?php echo $row['p_id']; ?>">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                                        </div>
                                    <?php
}
    }
}
?>


                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade product-list" id="list" role="tabpanel"
                                aria-labelledby="list-tab">
                                <div class="product-row">
                                    <div class="row align-items-center " id="item-container1">
                                    <?php
// Checking if any product is available or not
$prod_count = 0;
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE `date` > '$newProduct_date' ");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$prod_table_ecat_ids = [];
foreach ($result as $row) {
    $prod_table_ecat_ids[] = $row['ecat_id'];
}

for ($ii = 0; $ii < count($final_ecat_ids); $ii++):
    if (in_array($final_ecat_ids[$ii], $prod_table_ecat_ids)) {
        $prod_count++;
    }
endfor;

if ($prod_count == 0) {
    echo '<div class="pl_15">No Product Found</div>';
} else {
    for ($ii = 0; $ii < count($final_ecat_ids); $ii++) {
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE `date` > '$newProduct_date' AND ecat_id=? AND p_is_active=? ");
        $statement->execute(array($final_ecat_ids[$ii], 1));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $i = 0;
        foreach ($result as $row) {
            $i++;
            ?>

                                    <div class="col-xl-12 col-12 product_item_sort">

                                        <div class="product-item">
                                            <div class="product_name_sort " style="display: none;">
                                                <?php echo $row['p_name']; ?>
                                            </div>
                                            <div class="current_price " style="display: none;">
                                                <?php echo $row['p_current_price']; ?>
                                            </div>
                                            <div class="product_ids_default " style="display: none;">
                                                <?php echo $i; ?>
                                            </div>
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
                                                    <?php if ($row['p_old_price'] != ''): ?>
                                                    <del class="old-price">PKR <?php echo $row['p_old_price']; ?></del>
                                                    <?php endif;?>
                                                </div>
                                                <p><?php echo strip_tags(substr($row['p_short_description'], 0, 50)); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
}
    }
}
?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- product-area-end -->


        <?php
include 'footer.php';
?>

<script>
    function sortProducts() {
  const sortSelect = document.getElementById('sorting');
  const sortBy = sortSelect.value; // Get the selected sorting criteria

  const productContainer = document.getElementById('item-container');
  const productContainer1 = document.getElementById('item-container1');
  const productItems = Array.from(productContainer.querySelectorAll('.product_item_sort'));
  const productItems1 = Array.from(productContainer1.querySelectorAll('.product_item_sort'));

  // Sort the product items based on the selected criteria
  productItems.sort((a, b) => {

    const defultA = parseFloat(a.querySelector('.product_ids_default').textContent.trim());
    const defultB = parseFloat(b.querySelector('.product_ids_default').textContent.trim());
    const priceA = parseFloat(a.querySelector('.current_price').textContent.replace('$', '').trim());
    const priceB = parseFloat(b.querySelector('.current_price').textContent.replace('$', '').trim());
    const titleA = a.querySelector('.product_name_sort').textContent.toLowerCase();
    const titleB = b.querySelector('.product_name_sort').textContent.toLowerCase();
    console.log(titleA);
    // Implement sorting logic based on the 'sortBy' value
    if (sortBy === '2') {
        return priceA - priceB;
      // Sort by price: Low to High
      // ...
    } else if (sortBy === '3') {
        return priceB - priceA;
      // Sort by price: High to Low
      // ...
    } else if (sortBy === '1') {
        return titleA.localeCompare(titleB);

    }
    else if (sortBy == "0")
    {
        return defultA -defultB;
    }


  });
  productItems1.sort((a, b) => {

    const defultA = parseFloat(a.querySelector('.product_ids_default').textContent.trim());
    const defultB = parseFloat(b.querySelector('.product_ids_default').textContent.trim());
    const priceA = parseFloat(a.querySelector('.current_price').textContent.replace('$', '').trim());
    const priceB = parseFloat(b.querySelector('.current_price').textContent.replace('$', '').trim());
    const titleA = a.querySelector('.product_name_sort').textContent.toLowerCase();
    const titleB = b.querySelector('.product_name_sort').textContent.toLowerCase();

    // Implement sorting logic based on the 'sortBy' value
    if (sortBy === '2') {
        return priceA - priceB;
      // Sort by price: Low to High
      // ...
    } else if (sortBy === '3') {
        return priceB - priceA;
      // Sort by price: High to Low
      // ...
    } else if (sortBy === '1') {

        return titleA.localeCompare(titleB);
    }
    else if (sortBy == "0")
    {
        return defultA -defultB;
    }


  });

  // Remove all product items from the container
  productItems.forEach(item => item.remove());
  productItems1.forEach(item => item.remove());

  // Append the sorted product items back to the container
  productItems.forEach(item => productContainer.appendChild(item));
  productItems1.forEach(item => productContainer1.appendChild(item));
}
</script>