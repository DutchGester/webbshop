<?php

// include objects
include_once('objects/product.php');

// initialize objects
$product = new Product($connect);


if(count($_SESSION['cart'])>0){

    // get the product ids
    $ids = array();
    foreach($_SESSION['cart'] as $id=>$value){
        array_push($ids, $id);
    }

    $stmt=$product->readByIds($ids);

    $total=0;
    $price=0;
    $sub_total=0;
    $advert=0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quantity=$_SESSION['cart'][$id]['quantity'];
        $sub_total=$price*$quantity;
        $total+=$sub_total;

  }

}
