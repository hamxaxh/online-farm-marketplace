<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['search_text'])) {
    header('location: index.php');
    exit;
} else {
	if($_REQUEST['search_text']=='') {
		header('location: index.php');
    	exit;
	}
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_search = $row['banner_search'];
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
                        <!-- <li><a href="shop.php">Product</a></li> -->
                        <li>Search Result</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

            <?php 
                $search_text = strip_tags($_REQUEST['search_text']); 
                // echo $search_text; 
            ?>            
        
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12 pt-3">
                <div class="product product-cat">
                    <h3 class="pt-3 pb-3">Search (Title) : <?php echo $search_text ?></h3>
                    <div class="row">
                        <?php
                            $search_text = '%'.$search_text.'%';

                        ?>

			<?php
            /* ===================== Pagination Code Starts ================== */
            $adjacents = 5;
            $where = "";
        
       if($_REQUEST['service'] != "")
            {
        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE  tcat_id = ".$_REQUEST['service']);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $mid = "";
        foreach ($result as $row) {
            $mid .= $row['mcat_id'].",";
         
        }
         

        $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE  mcat_id IN (".$mid."0)");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $end = "";
        foreach ($result as $row) {
            $end .= $row['ecat_id'].",";
         
        }
           
            
                $where .="AND ecat_id IN (".$end."0)";
                
            }
            
        
            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? AND p_name LIKE ?   $where");
            $statement->execute(array(1,$search_text));
            $total_pages = $statement->rowCount();

            $targetpage = BASE_URL.'search_result.php?search_text='.$_REQUEST['search_text'];   //your file name  (the name of this file)
            $limit = 12;                                 //how many items to show per page
            $page = @$_GET['page'];
            if($page) 
                $start = ($page - 1) * $limit;          //first item to display on this page
            else
                $start = 0;
            

            $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? AND p_name LIKE ? LIMIT $start, $limit");
            $statement->execute(array(1,$search_text));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
           
            
            if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
            $prev = $page - 1;                          //previous page is page - 1
            $next = $page + 1;                          //next page is page + 1
            $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
            $lpm1 = $lastpage - 1;   
            $pagination = "";
            if($lastpage > 1)
            {   
                $pagination .= "<div class=\"pagination\">";
                if ($page > 1) 
                    $pagination.= "<a href=\"$targetpage&page=$prev\">&#171; previous</a>";
                else
                    $pagination.= "<span class=\"disabled\">&#171; previous</span>";    
                if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
                {   
                    for ($counter = 1; $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";                 
                    }
                }
                elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
                {
                    if($page < 1 + ($adjacents * 2))        
                    {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";       
                    }
                    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                    {
                        $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";       
                    }
                    else
                    {
                        $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";                 
                        }
                    }
                }
                if ($page < $counter - 1) 
                    $pagination.= "<a href=\"$targetpage&page=$next\">next &#187;</a>";
                else
                    $pagination.= "<span class=\"disabled\">next &#187;</span>";
                $pagination.= "</div>\n";       
            }
            /* ===================== Pagination Code Ends ================== */
            ?>

                        <?php
                            
                            if(!$total_pages):
                                echo '<span style="color:red;font-size:18px;">No result found</span>';
                            else:
                            foreach ($result as $row) {
                                ?>
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 custom-col-10">
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
                            <div class="clear"></div>
							<div class="pagination">
                            <?php 
                                echo $pagination; 
                            ?>
                            </div>
                            <?php
                            endif;
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>