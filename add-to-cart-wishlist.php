
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
if (isset($_POST['form_add_to_cart'])) {

// getting the currect stock of this product
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
$statement->execute(array($_POST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $current_p_qty = $row['p_qty'];
   
    $_POST['p_current_price'] = $row['p_current_price'];
    $_POST['p_name'] = $row['p_name'];
    $_POST['p_featured_photo'] = $row['p_featured_photo'];
}
if ($_POST['p_qty'] > $current_p_qty):
    $temp_msg = 'Sorry! There are only ' . $current_p_qty . ' item(s) in stock';
    ?>
    <script type="text/javascript">
        alert('<?php echo $temp_msg; ?>');
    </script>
    <?php
else:
    if (isset($_SESSION['cart_p_id'])) {
        $arr_cart_p_id = array();
        $arr_cart_size_id = array();
        $arr_cart_color_id = array();
        $arr_cart_p_qty = array();
        $arr_cart_p_current_price = array();

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
        foreach ($_SESSION['cart_color_id'] as $key => $value) {
            $i++;
            $arr_cart_color_id[$i] = $value;
        }

        $added = 0;
        if (!isset($_POST['size_id'])) {
            $size_id = 0;

        } else {
            $size_id = $_POST['size_id'];
        }
        if (!isset($_POST['color_id'])) {
            $color_id = 0;
        } else {
            $color_id = $_POST['color_id'];
        }
        for ($i = 1; $i <= count($arr_cart_p_id); $i++) {
            if (($arr_cart_p_id[$i] == $_REQUEST['id']) && ($arr_cart_size_id[$i] == $size_id) && ($arr_cart_color_id[$i] == $color_id)) {
                $added = 1;
                break;
            }
        }
        if ($added == 1) {
            $error_message1 = 'This product is already added to the shopping cart.';
        } else {

            $i = 0;
            foreach ($_SESSION['cart_p_id'] as $key => $res) {
                $i++;
            }
            $new_key = $i + 1;

            if (isset($_POST['size_id'])) {

                $size_id = $_POST['size_id'];

                $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
                $statement->execute(array($size_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $size_name = $row['size_name'];
                }
            } else {
                $size_id = 0;
                $size_name = '';
            }

            if (isset($_POST['color_id'])) {
                $color_id = $_POST['color_id'];
                $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
                $statement->execute(array($color_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $color_name = $row['color_name'];
                }
            } else {
                $color_id = 0;
                $color_name = '';
            }

            if (($size_id == 0 && isset($_POST['size_id'])) || ($color_id == 0 && isset($_POST['color_id']))) {
                $error_message1 = "Please select color and size then you can add product to Cart";

            } else {
                $_SESSION['cart_p_id'][$new_key] = $_REQUEST['id'];
                $_SESSION['cart_size_id'][$new_key] = $size_id;
                $_SESSION['cart_size_name'][$new_key] = $size_name;
                $_SESSION['cart_color_id'][$new_key] = $color_id;
                $_SESSION['cart_color_name'][$new_key] = $color_name;
                $_SESSION['cart_p_qty'][$new_key] = $_POST['p_qty'];
                $_SESSION['cart_p_current_price'][$new_key] = $_POST['p_current_price'];
                $_SESSION['cart_p_name'][$new_key] = $_POST['p_name'];
                $_SESSION['cart_p_featured_photo'][$new_key] = $_POST['p_featured_photo'];
                $success_message1 = 'Product is added to the cart successfully!';
            }

        }

    } else {

        if (isset($_POST['size_id'])) {

            $size_id = $_POST['size_id'];

            $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
            $statement->execute(array($size_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $size_name = $row['size_name'];
            }
        } else {
            $size_id = 0;
            $size_name = '';
        }

        if (isset($_POST['color_id'])) {
            $color_id = $_POST['color_id'];
            $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
            $statement->execute(array($color_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $color_name = $row['color_name'];
            }
        } else {
            $color_id = 0;
            $color_name = '';
        }

        if (($size_id == 0 && isset($_POST['size_id'])) || ($color_id == 0 && isset($_POST['color_id']))) {

            $error_message1 = "Please select color and size then you can add product to Cart";
        } else {

            $_SESSION['cart_p_id'][1] = $_REQUEST['id'];
            $_SESSION['cart_size_id'][1] = $size_id;
            $_SESSION['cart_size_name'][1] = $size_name;
            $_SESSION['cart_color_id'][1] = $color_id;
            $_SESSION['cart_color_name'][1] = $color_name;
            $_SESSION['cart_p_qty'][1] = $_POST['p_qty'];
            $_SESSION['cart_p_current_price'][1] = $_POST['p_current_price'];
            $_SESSION['cart_p_name'][1] = $_POST['p_name'];
            $_SESSION['cart_p_featured_photo'][1] = $_POST['p_featured_photo'];
            $success_message1 = 'Product is added to the cart successfully!';
        }
    }
endif;
}
if(isset($_POST['form_add_to_wishlist']))
{
if(isset($_SESSION['customer']))
{
   
    $statement = $pdo->prepare("SELECT * FROM `tbl_wishlist` WHERE product_id = ? and cust_id = ?;");
    $statement->execute(array(
                            $_REQUEST['id'],
                            $_SESSION['customer']['cust_id']
                        ));  
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
   if(!empty($result))
   {
    $error_message1 = "The Product is already in wishlist";
   }
   else{
    $statement = $pdo->prepare("INSERT INTO `tbl_wishlist` (`product_id` , `cust_id`) values (? , ?)");
    $statement->execute(array(
                    $_REQUEST['id'],
                    $_SESSION['customer']['cust_id']
                ));  
                $success_message1 = "The Product is added to wishlist successfully";
               
   }
}
else {
    $error_message1 = "Please login first to add item in wishlist";
}
}

?>
                        <div id="message-return" class="d-none"><?php echo  @$success_message1." ". @$error_message1?></div>
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
                     

