<?php require_once('header.php'); ?>

<?php

// Check if the product is valid or not
if( !isset($_REQUEST['id'])   ) {
    header('location: index.php');
    exit;
}
$statement = $pdo->prepare("DELETE  FROM `tbl_wishlist`  WHERE  `id` = ?;");
$statement->execute(array(
                       
                        $_REQUEST['id']
                    ));  

header('location: index.php');
?>