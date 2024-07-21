<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_cart = $row['banner_cart'];
}
?>

<?php
$error_message = '';
if(isset($_POST['form1'])) {

    $i = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_product");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $i++;
        $table_product_id[$i] = $row['p_id'];
        $table_quantity[$i] = $row['p_qty'];
    }

    $i=0;
    foreach($_POST['product_id'] as $val) {
        $i++;
        $arr1[$i] = $val;
    }
    $i=0;
    foreach($_POST['quantity'] as $val) {
        $i++;
        $arr2[$i] = $val;
    }
    $i=0;
    foreach($_POST['product_name'] as $val) {
        $i++;
        $arr3[$i] = $val;
    }
    
    $allow_update = 1;
    for($i=1;$i<=count($arr1);$i++) {
        for($j=1;$j<=count($table_product_id);$j++) {
            if($arr1[$i] == $table_product_id[$j]) {
                $temp_index = $j;
                break;
            }
        }
        if($table_quantity[$temp_index] < $arr2[$i]) {
        	$allow_update = 0;
            $error_message .= '"'.$arr2[$i].'" items are not available for "'.$arr3[$i].'"\n';
        } else {
            $_SESSION['cart_p_qty'][$i] = $arr2[$i];
        }
    }
    $error_message .= '\nOther items quantity are updated successfully!';
    ?>

<?php if($allow_update == 0): ?>
<script>
alert('<?php echo $error_message; ?>');
</script>
<?php else: ?>
<script>
alert('All Items Quantity Update is Successful!');
</script>
<?php endif; ?>
<?php

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
                        <li><a href="shop.php">Product Page</a></li>
                        <li>Cart</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- cart-area-s2 start -->
<div class="cart-area-s2 section-padding pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Cart</h2>
                    <!-- <p>There are 4 products in this list</p> -->
                </div>
            </div>
        </div>
        <div class="cart-wrapper">
            <div class="row">
            <?php if(!isset($_SESSION['cart_p_id'])): ?>
                <?php echo 'Cart is empty'; ?>
                <?php else: ?>
                    
                    <?php
                        $table_total_price = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        $arr_cart_p_qty = [];
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                <div class="col-lg-8 col-12">
                    <form action="#" method="post">
                        <div class="cart-item">
                            <table class="table-responsive cart-wrap">
                                <thead>
                                    <tr>
                                        <th class="images images-b">Product</th>
                                        <th class="ptice">Price</th>
                                        <th class="stock">Quantity</th>
                                        <th class="ptice total">Subtotal</th>
                                        <th class="remove remove-b">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                                    <tr class="wishlist-item">
                                        <td class="product-item-wish">
                                            <div class="check-box"><input type="checkbox" class="myproject-checkbox">
                                            </div>
                                            <div class="images">
                                                <span>
                                                    <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                                                </span>
                                            </div>
                                            <div class="product">
                                                <ul>
                                                    <li class="first-cart"><?php echo $arr_cart_p_name[$i]; ?></li>
                                                    
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="ptice">PKR <?php echo $arr_cart_p_current_price[$i]; ?></td>
                                        <td class="td-quantity">
                                        <input type="hidden" name="product_id[]"
                                                value="<?php echo $arr_cart_p_id[$i]; ?>">
                                            <input type="hidden" name="product_name[]"
                                                value="<?php echo $arr_cart_p_name[$i]; ?>">
                                            <div class="quantity cart-plus-minus">
                                                <input class="text-value" name="quantity[]" type="text" value="<?php echo $arr_cart_p_qty[$i]; ?>">
                                                <div class="dec qtybutton">-</div>
                                                <div class="inc qtybutton">+</div>
                                            </div>
                                        </td>
                                        <td class="ptice">PKR <?php echo $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i]; ?></td>
                                        <td class="action">
                                        <?php
                                $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                            <ul>
                                                <li class="w-btn"><a href="cart-item-delete.php?id=<?php echo $arr_cart_p_id[$i]; ?>&size=<?php echo $arr_cart_size_id[$i]; ?>&color=<?php echo $arr_cart_color_id[$i]; ?>"data-bs-toggle="tooltip" data-bs-html="true" title="" href="#" data-bs-original-title="Remove from Cart" aria-label="Remove from Cart"><i class="fi ti-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                    
                                </tbody>

                            </table>
                        </div>
                        <div class="cart-action">
                            <div class="apply-area">
                                <input type="text" class="form-control" placeholder="Enter your coupon">
                                <button class="theme-btn-s2" type="submit">Apply</button>
                            </div>
                            <button type="submit" name="form1" class="theme-btn-s2" href="#"><i class="fi flaticon-refresh"></i> Update Cart</a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="cart-total-wrap">
                        <h3>Cart Totals</h3>
                        <div class="sub-total">
                            <h4>Subtotal</h4>
                            <span>PKR <?php echo $table_total_price; ?></span>
                        </div>
                       
<!--                         
                        <div class="sub-total pt-4">
                            <h4>Shipping</h4>
                            <span> 0101</span>
                        </div> -->
                        <div class="sub-total pt-4">
                            <h4>Total</h4>
                            <span>PKR <?php echo $table_total_price; ?></span>
                        </div>
                       <div class="pt-4">
                       <a class="theme-btn-s2" href="checkout.php">Proceed To CheckOut</a>
                       </div>
                       
                    </div> 
                   
                   
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>