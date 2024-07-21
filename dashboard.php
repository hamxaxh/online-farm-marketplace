<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
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
    $statement->execute(array(
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
                            $_SESSION['customer']['cust_id']
                        ));  
   
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
<?php
if (isset($_POST['formProfile'])) {

    $valid = 1;

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123."<br>";
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124."<br>";
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125."<br>";
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_126."<br>";
    }

    if(empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_127."<br>";
    }

    if(empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_128."<br>";
    }

    if(empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_129."<br>";
    }

    if($valid == 1) {

        // update data into the database
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_name=?, cust_cname=?, cust_phone=?, cust_country=?, cust_address=?, cust_age=?, cust_city=?, cust_state=?, cust_zip=? WHERE cust_id=?");
        $statement->execute(array(
                    strip_tags($_POST['cust_name']),
                    strip_tags($_POST['cust_cname']),
                    strip_tags($_POST['cust_phone']),
                    strip_tags($_POST['cust_country']),
                    strip_tags($_POST['cust_address']),
                    strip_tags($_POST['cust_age']),
                    strip_tags($_POST['cust_city']),
                    strip_tags($_POST['cust_state']),
                    strip_tags($_POST['cust_zip']),
                    $_SESSION['customer']['cust_id']
                ));  
       
        $success_message = LANG_VALUE_130;

        $_SESSION['customer']['cust_name'] = $_POST['cust_name'];
        $_SESSION['customer']['cust_cname'] = $_POST['cust_cname'];
        $_SESSION['customer']['cust_phone'] = $_POST['cust_phone'];
        $_SESSION['customer']['cust_country'] = $_POST['cust_country'];
        $_SESSION['customer']['cust_address'] = $_POST['cust_address'];
        $_SESSION['customer']['cust_age'] = $_POST['cust_age'];
        $_SESSION['customer']['cust_city'] = $_POST['cust_city'];
        $_SESSION['customer']['cust_state'] = $_POST['cust_state'];
        $_SESSION['customer']['cust_zip'] = $_POST['cust_zip'];
    }
}

if (isset($_POST['formPassowrd'])) {

    $valid = 1;

    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message .= LANG_VALUE_138."<br>";
    }

    if( !empty($_POST['cust_password']) && !empty($_POST['cust_re_password']) ) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139."<br>";
        }
    }
    
    if($valid == 1) {

        // update data into the database

        $password = strip_tags($_POST['cust_password']);
        
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=? WHERE cust_id=?");
        $statement->execute(array(md5($password),$_SESSION['customer']['cust_id']));
        
        $_SESSION['customer']['cust_password'] = md5($password);        

        $success_message = LANG_VALUE_141;
    }
}
?>

<link rel="stylesheet" href="user.css">
<!-- page title area start -->
  <!-- start wpo-page-title -->
  <section class="wpo-page-title">
            <h2 class="d-none">Hide</h2>
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="wpo-breadcumb-wrap">
                            <ol class="wpo-breadcumb-wrap">
                                <li><a href="index.php">Home</a></li>
                                <li>Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->
<!-- page title area end -->

<!-- profile area start -->

<!-- profile area end -->

<!-- profile menu area start -->
<section class="profile__menu pb-70 grey-bg pt-70">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-md-4">
                <div class="profile__menu-left bg-white mb-50">
                    <h3 class="profile__menu-title"><i class="fa fa-list-alt"></i> Your Menu</h3>
                    <div class="profile__menu-tab">
                        <div class="nav nav-tabs flex-column justify-content-start text-start" id="nav-tab"
                            role="tablist">
                            <button class="nav-link active" id="nav-account-tab" data-toggle="tab"
                                data-target="#nav-account" type="button" role="tab" aria-controls="nav-account"
                                aria-selected="true"> <i class="fa fa-user"></i> My Account</button>
                            <button class="nav-link " id="nav-billing-tab" data-toggle="tab" data-target="#nav-billing"
                                type="button" role="tab" aria-controls="nav-billing" aria-selected="true"> <i
                                    class="fa fa-user"></i> Billing Shipping Info</button>
                            <button class="nav-link" id="nav-order-tab" data-toggle="tab" data-target="#nav-order"
                                type="button" role="tab" aria-controls="nav-order" aria-selected="false"><i
                                    class="fa fa-file"></i>Orders</button>
                            <button class="nav-link" id="nav-password-tab" data-toggle="tab" data-target="#nav-password"
                                type="button" role="tab" aria-controls="nav-password" aria-selected="false"><i
                                    class="fa fa-lock"></i>Change Password</button>
                            <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-md-8">
                <div class="profile__menu-right">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-account" role="tabpanel"
                            aria-labelledby="nav-account-tab">
                            <div class="profile__info basic-login p-0">


                                <div class="profile__info-wrapper white-bg">
                                    <form action="" method="post" class="pt-70 pb-70 ">
                                        <?php $csrf->echoInputField(); ?>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="">Full Name *</label>
                                                <input type="text" class="form-control" name="cust_name"
                                                    value="<?php echo $_SESSION['customer']['cust_name']; ?>">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="">Last Name</label>
                                                <input type="text" class="form-control" name="cust_cname"
                                                    value="<?php echo $_SESSION['customer']['cust_cname']; ?>">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="">Email Address *</label>
                                                <input type="text" class="form-control" name=""
                                                    value="<?php echo $_SESSION['customer']['cust_email']; ?>" disabled>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="">Phone No *</label>
                                                <input type="text" class="form-control" name="cust_phone"
                                                    value="<?php echo $_SESSION['customer']['cust_phone']; ?>">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="">Address *</label>
                                                <textarea name="cust_address" class="form-control" cols="30" rows="10"
                                                    style="height:70px;"><?php echo $_SESSION['customer']['cust_address']; ?></textarea>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="">Country *</label>
                                                <select name="cust_country" class="form-control">
                                                    <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    ?>
                                                    <option value="<?php echo $row['country_id']; ?>"
                                                        <?php if($row['country_id'] == $_SESSION['customer']['cust_country']) {echo 'selected';} ?>>
                                                        <?php echo $row['country_name']; ?></option>
                                                    <?php
                                }
                                ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="">Age *</label>
                                                <input type="text" class="form-control" name="cust_age"
                                                    value="<?php echo $_SESSION['customer']['cust_age']; ?>">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="">City *</label>
                                                <input type="text" class="form-control" name="cust_city"
                                                    value="<?php echo $_SESSION['customer']['cust_city']; ?>">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="">State / Province *</label>
                                                <input type="text" class="form-control" name="cust_state"
                                                    value="<?php echo $_SESSION['customer']['cust_state']; ?>">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="">Zip/Postal Code *</label>
                                                <input type="text" class="form-control" name="cust_zip"
                                                    value="<?php echo $_SESSION['customer']['cust_zip']; ?>">
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary text-white" value="Update"
                                            name="formProfile">
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show " id="nav-billing" role="tabpanel"
                            aria-labelledby="nav-billing-tab">
                            <div class="profile__info basic-login p-0">


                                <div class="profile__info-wrapper white-bg">
                                    <form action="" method="post" class="pt-70 pb-70">
                                        <?php $csrf->echoInputField(); ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3>Billing Info</h3>
                                                <div class="form-group">
                                                    <label for="">Full Name</label>
                                                    <input type="text" class="form-control" name="cust_b_name"
                                                        value="<?php echo $_SESSION['customer']['cust_b_name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Last Name</label>
                                                    <input type="text" class="form-control" name="cust_b_cname"
                                                        value="<?php echo $_SESSION['customer']['cust_b_cname']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Phone No</label>
                                                    <input type="text" class="form-control" name="cust_b_phone"
                                                        value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Country</label>
                                                    <select name="cust_b_country" class="form-control">
                                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                                        <option value="<?php echo $row['country_id']; ?>"
                                                            <?php if($row['country_id'] == $_SESSION['customer']['cust_b_country']) {echo 'selected';} ?>>
                                                            <?php echo $row['country_name']; ?></option>
                                                        <?php
                                        }
                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Address</label>
                                                    <textarea name="cust_b_address" class="form-control" cols="30"
                                                        rows="10"
                                                        style="height:100px;"><?php echo $_SESSION['customer']['cust_b_address']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">City</label>
                                                    <input type="text" class="form-control" name="cust_b_city"
                                                        value="<?php echo $_SESSION['customer']['cust_b_city']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">State / Province</label>
                                                    <input type="text" class="form-control" name="cust_b_state"
                                                        value="<?php echo $_SESSION['customer']['cust_b_state']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Zip/Postal Code</label>
                                                    <input type="text" class="form-control" name="cust_b_zip"
                                                        value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h3>Shipping Info</h3>
                                                <div class="form-group">
                                                    <label for="">Full Name</label>
                                                    <input type="text" class="form-control" name="cust_s_name"
                                                        value="<?php echo $_SESSION['customer']['cust_s_name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Last Name</label>
                                                    <input type="text" class="form-control" name="cust_s_cname"
                                                        value="<?php echo $_SESSION['customer']['cust_s_cname']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Phone No</label>
                                                    <input type="text" class="form-control" name="cust_s_phone"
                                                        value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>">
                                                </div>
                                                <div class="form-group">
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
                                                <div class="form-group">
                                                    <label for="">Address</label>
                                                    <textarea name="cust_s_address" class="form-control" cols="30"
                                                        rows="10"
                                                        style="height:100px;"><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">City</label>
                                                    <input type="text" class="form-control" name="cust_s_city"
                                                        value="<?php echo $_SESSION['customer']['cust_s_city']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">State / Province</label>
                                                    <input type="text" class="form-control" name="cust_s_state"
                                                        value="<?php echo $_SESSION['customer']['cust_s_state']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Zip/Postal Code</label>
                                                    <input type="text" class="form-control" name="cust_s_zip"
                                                        value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary text-white"
                                            value="Update" name="formBilling">
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">
                            <div class="order__info">
                               

                                <div class="order__list pr-1 pl-1 white-bg table-responsive">



                                    <div class="table-responsive">
                                        <table class="table " >
                                            <thead>
                                                <tr>
                                                    <th>Order Id</th>
                                                    <th>Product Image</th>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Detail</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php
            /* ===================== Pagination Code Starts ================== */
            $adjacents = 5;

            $statement = $pdo->prepare("SELECT * FROM tbl_payment INNER JOIN tbl_order ON tbl_order.payment_id = tbl_payment.payment_id INNER JOIN tbl_product ON tbl_product.p_id = tbl_order.product_id WHERE customer_email=? ORDER BY tbl_payment.id DESC");
            $statement->execute(array($_SESSION['customer']['cust_email']));
           
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
           
            
            /* ===================== Pagination Code Ends ================== */
            ?>


                                                <?php
                                $tip = 1;
                                foreach ($result as $row) {
                                    $tip++;
                                    ?>
                                                <tr>
                                                    <td><?php echo $tip; ?></td>
                                                    <td style="width:130px;"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="<?php echo $row['p_name']; ?>" style="width:100px;"></td>
                                                    <td>
                                                        <?php
                                           
                                                echo $row['product_name'];
                                             
                                            
                                            ?>
                                                    </td>
                                                  
                                                    <td><?php echo $row['quantity']; ?></td>
                                                    <td><?php echo $row['unit_price'] * $row['quantity']; ?></td>
                                                  
                                                    <td><a href="product-single.php?id=<?php
                                            
                                                echo $row['product_id'];
                                             
                                            ?>">View</a></td>
                                                </tr>
                                                <?php
                                }
                                ?>

                                            </tbody>
                                        </table>
                                       

                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="tab-pane fade" id="nav-password" role="tabpanel"
                                aria-labelledby="nav-password-tab">
                                <div class="password__change ">
                                    <div class="password__change-top">
                                        <h3 class="password__change-title">Change Password</h3>
                                    </div>
                                    <div class="password__form white-bg basic-login p-3 pt-70 pb-70">
                                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                          
                            <div class="col-md-8 offset-md-2">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <div class="form-group ">
                                    <label for="">New Password *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label for="">Re TypePassword *</label>
                                    <input type="password" class="form-control" name="cust_re_password">
                                </div>
                                <input type="submit" class="btn btn-primary text-white" value="Update" name="formPassword">
                            </div>
                        </div>
                        
                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- profile menu area end -->

<?php require_once('footer.php'); ?>