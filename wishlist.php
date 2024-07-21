<?php
include('header.php');
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
                                <li><a href="product.php">Product Page</a></li>
                                <li>Wishlist</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- cart-area start -->
        <div class="cart-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="single-page-title">
                            <h2>Your Wishlist</h2>
                            <!-- <p>There are 4 products in this list</p> -->
                        </div>
                    </div>
                </div>
                <?php
                if(isset($_SESSION['customer']))
                {

                
$statement = $pdo->prepare("SELECT * FROM `tbl_wishlist` INNER JOIN `tbl_product` ON `tbl_product`.`p_id` = `tbl_wishlist`.`product_id` WHERE  `tbl_wishlist`.`cust_id` = ?;");
$statement->execute(array(
                       
                        $_SESSION['customer']['cust_id']
                    ));  
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount(PDO::FETCH_ASSOC);

                                            ?>
                <div class="form">
                    <div class="cart-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <form action="">
                                    <table class="table-responsive cart-wrap">
                                        <thead>
                                            <tr>
                                                <th class="images images-b">Product</th>
                                                <th class="ptice">Price</th>
                                                <th class="stock">Stock Status</th>
                                                <th class="remove remove-b">Action</th>
                                                <th class="remove remove-b">Remove</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                        <?php
                                                    foreach($result as $row)
                                                    {
                                                        ?>
                                            <tr class="wishlist-item">
                                                <td class="product-item-wish">
                                                    <div class="check-box"><input type="checkbox"
                                                            class="myproject-checkbox">
                                                    </div>
                                                    <div class="images">
                                                        <span>
                                                            <img src="assets/uploads/<?php echo $row['p_featured_photo'];?>" alt="">
                                                        </span>
                                                    </div>
                                                    <div class="product">
                                                        <ul>
                                                            <li class="first-cart"><?php echo $row['p_name'];?></li>
                                                            <!-- <li>
                                                                <div class="rating-product">
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <span>130</span>
                                                                </div>
                                                            </li> -->
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="ptice">PKR <?php echo $row['p_current_price'];?></td>
                                                <td class="stock"><?php echo ($row['p_qty'] > 0) ?'<span class="in-stock">In Stock</span>' : '<span class="in-stock out-stock">Sold Out</span>' ;?></td>
                                                <td class="add-wish">
                                                    <a class="theme-btn-s2" href="product-single.php?id=<?php echo $row['p_id'];?>">Add to Cart</a>
                                                </td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn"><a data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="" href="wishlist_item_delete.php?id=<?php echo $row['id'];?>"
                                                                data-bs-original-title="Remove from Cart"
                                                                aria-label="Remove from Cart"><i
                                                                    class="fi flaticon-remove"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                        ?>
                                            
                                        </tbody> 
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                else {
                    echo "Please login to see wishlist";
                }
                ?>
            </div>
        </div>
        <!-- cart-area end -->

        <?php
include('footer.php');
?>