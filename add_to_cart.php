<?php
// start session
session_start();
include('config/database_connection.php');

// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// make quantity a minimum of 1
$quantity=$quantity<=0 ? 1 : $quantity;

// add new item on array
$cart_item=array(
    'quantity'=>$quantity
);

/*
 * check if the 'cart' session array was created
 * if it is NOT, create the 'cart' session array
 */
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

// check if the item is in the array, if it is, do not add
if(array_key_exists($id, $_SESSION['cart'])){
    // redirect to product list and tell the user it was added to cart
    //header('Location: products.php?action=exists&id=' . $id . '&page=' . $page);
}

// else, add the item to the array
else{

    $_SESSION['cart'][$id]=$cart_item;
    //Remove empty ID(key) in array
    	 $array = $_SESSION['cart'];

    	 foreach($array as $key=>$value)
    	 {
    	     if(is_null($value) || $key == '')
    	         unset($array[$key]);
    	 }

    echo $cart_total_item_count = array_sum( array_column($array, 'quantity' ));


    // redirect to product list and tell the user it was added to cart
    //header('Location: products.php?action=added&page=' . $page);

    if(isset($_SESSION['user_id'])) {

        $query = "SELECT cart_contents FROM user_carts WHERE register_user_id=:register_user_id";
        $statement = $connect->prepare($query);
        $statement->bindValue(':register_user_id', $_SESSION['user_id']);
        $success = $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $no_of_row = $statement->rowCount();

        if($no_of_row > 0) {

        $serialized_cart = serialize($_SESSION["cart"]);

        $query2 = "UPDATE user_carts SET cart_contents=:cart_contents
                  WHERE register_user_id=:register_user_id";

        $statement2 = $connect->prepare($query2);
        $statement2->execute(array(
        ':register_user_id' => $_SESSION['user_id'],
        ':cart_contents' => $serialized_cart
      ));
    } else {

      $serialized_cart = serialize($_SESSION["cart"]);

      $query3 = "INSERT INTO user_carts (register_user_id,cart_contents) VALUES
      (:register_user_id,:serialized_cart)";

      $statement3 = $connect->prepare($query3);
      $statement3->execute(array(
      ':register_user_id' => $_SESSION['user_id'],
      ':serialized_cart' => $serialized_cart
    ));
    }
  }
}


?>
