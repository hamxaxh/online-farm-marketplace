<?php require_once 'header.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if (!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
?>
<?php
if (isset($_POST['formBilling'])) {

    // update data into the database
    $statement = $pdo->prepare("UPDATE tbl_customer SET
                            cust_b_name=?,
                            cust_b_cname=?,
                            cust_b_phone=?,
                            cust_b_country=?,
                            cust_b_address=?,
                            cust_b_city=?,
                            cust_b_state=?,
                            cust_b_zip=?,
                            cust_s_name=?,
                            cust_s_cname=?,
                            cust_s_phone=?,
                            cust_s_country=?,
                            cust_s_address=?,
                            cust_s_city=?,
                            cust_s_state=?,
                            cust_s_zip=?

                            WHERE cust_id=?");
    $statement->execute(
        array(
            strip_tags($_POST['cust_b_name']),
            strip_tags($_POST['cust_b_cname']),
            strip_tags($_POST['cust_b_phone']),
            strip_tags($_POST['cust_b_country']),
            strip_tags($_POST['cust_b_address']),
            strip_tags($_POST['cust_b_city']),
            strip_tags($_POST['cust_b_state']),
            strip_tags($_POST['cust_b_zip']),
            strip_tags($_POST['cust_s_name']),
            strip_tags($_POST['cust_s_cname']),
            strip_tags($_POST['cust_s_phone']),
            strip_tags($_POST['cust_s_country']),
            strip_tags($_POST['cust_s_address']),
            strip_tags($_POST['cust_s_city']),
            strip_tags($_POST['cust_s_state']),
            strip_tags($_POST['cust_s_zip']),
            $_SESSION['customer']['cust_id'],
        )
    );

    $success_message = LANG_VALUE_122;

    $_SESSION['customer']['cust_b_name'] = strip_tags($_POST['cust_b_name']);
    $_SESSION['customer']['cust_b_cname'] = strip_tags($_POST['cust_b_cname']);
    $_SESSION['customer']['cust_b_phone'] = strip_tags($_POST['cust_b_phone']);
    $_SESSION['customer']['cust_b_country'] = strip_tags($_POST['cust_b_country']);
    $_SESSION['customer']['cust_b_address'] = strip_tags($_POST['cust_b_address']);
    $_SESSION['customer']['cust_b_city'] = strip_tags($_POST['cust_b_city']);
    $_SESSION['customer']['cust_b_state'] = strip_tags($_POST['cust_b_state']);
    $_SESSION['customer']['cust_b_zip'] = strip_tags($_POST['cust_b_zip']);
    $_SESSION['customer']['cust_s_name'] = strip_tags($_POST['cust_s_name']);
    $_SESSION['customer']['cust_s_cname'] = strip_tags($_POST['cust_s_cname']);
    $_SESSION['customer']['cust_s_phone'] = strip_tags($_POST['cust_s_phone']);
    $_SESSION['customer']['cust_s_country'] = strip_tags($_POST['cust_s_country']);
    $_SESSION['customer']['cust_s_address'] = strip_tags($_POST['cust_s_address']);
    $_SESSION['customer']['cust_s_city'] = strip_tags($_POST['cust_s_city']);
    $_SESSION['customer']['cust_s_state'] = strip_tags($_POST['cust_s_state']);
    $_SESSION['customer']['cust_s_zip'] = strip_tags($_POST['cust_s_zip']);
  

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
                        <li><a href="cart.php">Cart</a></li>
                        <li>Checkout</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- wpo-checkout-area start-->
<div class="wpo-checkout-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Checkout</h2>
                    <!-- <p>There are 4 products in this list</p> -->
                </div>
            </div>
        </div>

        <div class="checkout-wrap">
            <div class="row">
                <?php if (!isset($_SESSION['customer'])): ?>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger">
                            <?php echo LANG_VALUE_160; ?>
                        </a>
                    </p>
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
                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <!-- <div class="col-lg-6">
                                        <div class="caupon-wrap s2">
                                            <div class="coupon coupon-2">
                                                <div id="toggle2">
                                                    <div class="text"><i class="fi flaticon-user-profile"></i> Returning customer?
                                                        <span>Click Here to Login</span></div>
                                                </div>
                                            </div>
                                            <div class="create-account s2">
                                                <span>If you have shopped with us before, please enter your details in
                                                    the boxes below.
                                                    If you are a new customer, please proceed to the Billing & Shipping
                                                    section.</span>
                                                <div class="name-input">
                                                    <input type="text" class="form-control" placeholder="Name" required>
                                                </div>
                                                <div class="name-email">
                                                    <input type="email" class="form-control" placeholder="Email"
                                                        required>
                                                </div>
                                                <div class="input-wrap s1">
                                                    <button type="submit">Login</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="caupon-wrap s1">
                                            <div class="coupon coupon-1">
                                                <div id="toggle1">
                                                    <div class="text"><i class="fi flaticon-coupon"></i>Have a Coupon?<span>Click Here
                                                            to Enter</span></div>
                                                </div>
                                            </div>
                                            <div class="create-account s1">
                                                <span>If you have coupon code,please apply it</span>
                                                <div class="input-wrap">
                                                    <input type="password">
                                                    <button>Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                        </div>
                        <form class="caupon-wrap s3 " method="post">
                            <div class="biling-item">
                                <div class="coupon coupon-3">
                                    <h2>Billing Address</h2>
                                </div>
                                <div class="billing-adress">
                                    <div class="contact-form form-style">
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                <label for="">Full Name</label>
                                                <input type="text" class="form-control" name="cust_b_name"
                                                    value="<?php echo $_SESSION['customer']['cust_b_name']; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                <label for="">Last Name</label>
                                                <input type="text" class="form-control" name="cust_b_cname"
                                                    value="<?php echo $_SESSION['customer']['cust_b_cname']; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                <label for="">Phone No</label>
                                                <input type="text" class="form-control" name="cust_b_phone"
                                                    value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                <label for="">Country</label>
                                                <select name="cust_b_country" class="form-control">
                                                    <?php
                                                    $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                    $statement->execute();
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $row) {
                                                        ?>
                                                            <option value="<?php echo $row['country_id']; ?>"
                                                            <?php if ($row['country_id'] == $_SESSION['customer']['cust_b_country']) {echo 'selected';}?>>
                                                            <?php echo $row['country_name']; ?></option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label for="">Address</label>
                                                <textarea name="cust_b_address" class="form-control" cols="30" rows="10"
                                                    style="height:100px;"><?php echo $_SESSION['customer']['cust_b_address']; ?></textarea>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                <label for="">City</label>
                                                <input type="text" class="form-control" name="cust_b_city"
                                                    value="<?php echo $_SESSION['customer']['cust_b_city']; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                <label for="">State / Province</label>
                                                <input type="text" class="form-control" name="cust_b_state"
                                                    value="<?php echo $_SESSION['customer']['cust_b_state']; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                <label for="">Zip/Postal Code</label>
                                                <input type="text" class="form-control" name="cust_b_zip"
                                                    value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="biling-item">
                                <div class="coupon coupon-3">
                                    <h2>Shipping Info</h2>
                                </div>
                                <div class="billing-adress">
                                    <div class="contact-form form-style">
                                        <div class="row">
                                        <div class="form-group col-lg-6 col-md-12 col-sm-6">
                                                    <label for="">Full Name</label>
                                                    <input type="text" class="form-control" name="cust_s_name"
                                                        value="<?php echo $_SESSION['customer']['cust_s_name']; ?>">
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12 col-sm-6">
                                                    <label for="">Last Name</label>
                                                    <input type="text" class="form-control" name="cust_s_cname"
                                                        value="<?php echo $_SESSION['customer']['cust_s_cname']; ?>">
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12 col-sm-6">
                                                    <label for="">Phone No</label>
                                                    <input type="text" class="form-control" name="cust_s_phone"
                                                        value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>">
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12 col-sm-6">
                                                    <label for="">Country</label>
                                                    <select name="cust_s_country" class="form-control">
                                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                                        <option value="<?php echo $row['country_id']; ?>"
                                                            <?php if($row['country_id'] == $_SESSION['customer']['cust_s_country']) {echo 'selected';} ?>>
                                                            <?php echo $row['country_name']; ?></option>
                                                        <?php
                                        }
                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12 col-sm-6">
                                                    <label for="">Address</label>
                                                    <textarea name="cust_s_address" class="form-control" cols="30"
                                                        rows="10"
                                                        style="height:100px;"><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12 col-sm-6">
                                                    <label for="">City</label>
                                                    <input type="text" class="form-control" name="cust_s_city"
                                                        value="<?php echo $_SESSION['customer']['cust_s_city']; ?>">
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12 col-sm-6">
                                                    <label for="">State / Province</label>
                                                    <input type="text" class="form-control" name="cust_s_state"
                                                        value="<?php echo $_SESSION['customer']['cust_s_state']; ?>">
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12 col-sm-6">
                                                    <label for="">Zip/Postal Code</label>
                                                    <input type="text" class="form-control" name="cust_s_zip"
                                                        value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>">
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary w-100 text-white"
                                            value="Update" name="formBilling">
                            </div>
                        </form>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="cout-order-area">
                        <h3>Your Order</h3>
                        <div class="oreder-item">
                            <div class="title">
                                <h2>Products <span>Subtotal</span></h2>
                            </div>
                            <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                            <div class="oreder-product">




                                <div class="images">
                                    <span>
                                        <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                                    </span>
                                </div>
                                <div class="product">
                                    <ul>
                                        <li class="first-cart"><?php echo $arr_cart_p_name[$i]; ?>(x<?php echo $arr_cart_p_qty[$i]?>)</li>
                                        <!-- <li>
                                            <div class="rating-product">
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <span>15</span>
                                            </div>
                                        </li> -->
                                    </ul>
                                </div>
                                <span>PKR <?php
$row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
$table_total_price = $table_total_price + $row_total_price;
?>
<?php echo $row_total_price; ?></span>
</div>
                                <?php endfor; ?>
                            <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                        $statement->execute(array($_SESSION['customer']['cust_country']));
                        $total = $statement->rowCount();
                        if($total) {
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        } else {
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        }                        
                        ?>
                            <div class="title s2">
                                <h2>Sub Total<span>PKR  <?php echo $table_total_price; ?></span></h2>
                            </div>
                            <div class="title s2">
                                <h2>Shipping Charges<span>PKR  <?php echo $shipping_cost; ?></span></h2>
                            </div>
                            <div class="title s2">
                                <h2>Total<span>PKR   <?php
                                $final_total = $table_total_price+$shipping_cost;
                                ?>
                                                        <?php echo $final_total; ?></span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="caupon-wrap s5">
                        <div class="payment-area">
                            <div class="row">
                                <div class="col-12">
                                    <div class="payment-option" id="open5">
                                        <h3>Payment</h3>
                                        <div class="payment-select">
                                            <ul>
                                                <li class="addToggle">
                                                    <input id="add" type="radio" name="payment" checked="checked"
                                                        value="30">
                                                    <label for="add">Cash on Delivery</label>
                                                </li>
                                                <!-- <li class="removeToggle">
                                                    <input id="remove" type="radio" name="payment" value="30">
                                                    <label for="remove">Cash on delivery</label>
                                                </li> -->
                                                <!-- <li class="getwayToggle">
                                                    <input id="getway" type="radio" name="payment" value="30">
                                                    <label for="getway">Online Getway</label>
                                                </li> -->
                                            </ul>
                                        </div>
                                        <div id="open6" class="payment-name active">
                                            <!-- <ul>
                                                <li class="visa"><input id="1" type="radio" name="size" value="30">
                                                    <label for="1"><img src="assets/images/checkout/img-1.png"
                                                            alt=""></label>
                                                </li>
                                                <li class="mas"><input id="2" type="radio" name="size" value="30">
                                                    <label for="2"><img src="assets/images/checkout/img-2.png"
                                                            alt=""></label>
                                                </li>
                                                <li class="ski"><input id="3" type="radio" name="size" value="30">
                                                    <label for="3"><img src="assets/images/checkout/img-3.png"
                                                            alt=""></label>
                                                </li>
                                                <li class="pay"><input id="4" type="radio" name="size" value="30">
                                                    <label for="4"><img src="assets/images/checkout/img-4.png"
                                                            alt=""></label>
                                                </li>
                                            </ul>
                                            <div class="contact-form form-style">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Card holder Name*" id="holder"
                                                            name="name">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Card Number*" id="card" name="card">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="CVV*" id="CVV" name="CVV">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Expire Date*" id="date" name="date">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <div class="submit-btn-area text-center">
                                                            <button class="theme-btn" type="submit">Place
                                                                Order</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <?php
		                $checkout_access = 1;
		                if(
		                    ($_SESSION['customer']['cust_b_name']=='') ||
		                    ($_SESSION['customer']['cust_b_cname']=='') ||
		                    ($_SESSION['customer']['cust_b_phone']=='') ||
		                    ($_SESSION['customer']['cust_b_country']=='') ||
		                    ($_SESSION['customer']['cust_b_address']=='') ||
		                    ($_SESSION['customer']['cust_b_city']=='') ||
		                    ($_SESSION['customer']['cust_b_state']=='') ||
		                    ($_SESSION['customer']['cust_b_zip']=='') ||
		                    ($_SESSION['customer']['cust_s_name']=='') ||
		                    ($_SESSION['customer']['cust_s_cname']=='') ||
		                    ($_SESSION['customer']['cust_s_phone']=='') ||
		                    ($_SESSION['customer']['cust_s_country']=='') ||
		                    ($_SESSION['customer']['cust_s_address']=='') ||
		                    ($_SESSION['customer']['cust_s_city']=='') ||
		                    ($_SESSION['customer']['cust_s_state']=='') ||
		                    ($_SESSION['customer']['cust_s_zip']=='')
		                ) {
		                    $checkout_access = 0;
		                }
		                ?>
                                                <?php if($checkout_access == 0): ?>
                                                <div class="col-md-12">
                                                    <div style="color:red;font-size:22px;margin-bottom:50px;">
                                                        You must have to fill up all the billing and shipping
                                                        information from your dashboard panel in
                                                        order to checkout the order. Please fill up the information
                                                        going to <a href="dashboard.php"
                                                            style="color:red;text-decoration:underline;">this link</a>.
                                                    </div>
                                                </div>
                                                <?php else: ?>
                                                <div class="col-md-12">

                                                    <div class="row cart-area-s2 ">

                                                      



                                                        <form action="payment/bank/cod.php" class="show w-100 apply-area" method="post"
                                                            id="bank_form">
                                                            <input type="hidden" name="amount"
                                                                value="<?php echo $final_total; ?>">
                                                            
                                                                
                                                            
                                                            <div class="col-md-12 form-group">
                                                                <button type="submit" class="theme-btn-s2 bg-green w-100 ms-0"
                                                                    value="" name="form3">Place Order</button>
                                                            </div>
                                                           
                                                        </form>

                                                    </div>


                                                </div>
                                                <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
</div>
<!-- wpo-checkout-area end-->
<?php
include 'footer.php';
?>