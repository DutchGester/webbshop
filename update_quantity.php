<?php
session_start();
include('config/database_connection.php');
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : 1;
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";
$price = isset($_GET['price']) ? $_GET['price'] : "";
$total = isset($_GET['total']) ? $_GET['total'] : "";
$beforeQuantity = isset($_GET['beforeQuantity']) ? $_GET['beforeQuantity'] : "";



// make quantity a minimum of 1
$quantity=$quantity<=0 ? 1 : $quantity;

// remove the item from the array
unset($_SESSION['cart'][$id]);

// add the item with updated quantity
$_SESSION['cart'][$id]=array(
    'quantity'=>$quantity
);

/* Save the session of the quantity again into the database */
if(isset($_SESSION['user_id'])) {

    $query = "SELECT cart_contents FROM user_carts WHERE register_user_id=:register_user_id";
    $statement = $connect->prepare($query);
    $statement->bindValue(':register_user_id', $_SESSION['user_id']);
    $success = $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    $result = $statement->rowCount();

    $serialized_cart = serialize($_SESSION["cart"]);

    $query2 = "UPDATE user_carts SET cart_contents=:cart_contents
              WHERE register_user_id=:register_user_id";

    $statement2 = $connect->prepare($query2);
    $statement2->execute(array(
    ':register_user_id' => $_SESSION['user_id'],
    ':cart_contents' => $serialized_cart
    ));
}

// redirect to product list and tell the user it was added to cart
// header('Location: cart.php?action=quantity_updated&id=' . $id);

$array = $_SESSION['cart'];

foreach($array as $key=>$value)
{
    if(is_null($value) || $key == "")
        unset($array[$key]);
}

$cart_total_item_count = array_sum( array_column($array, 'quantity' ));
$sub_total = number_format($price*$quantity, 2, '.', ',');

$pressedPlus =0;
$pressedMinus = 0;
if($beforeQuantity < $quantity) {
  $pressedPlus = $beforeQuantity;
} else {
  $pressedMinus = $beforeQuantity;
}


if($pressedPlus != 0) {
  $PlusQuantityValue = $quantity - $pressedPlus;
  $totalValue = $PlusQuantityValue * $price + $total;
} else {
  $MinusQuantityValue = $pressedMinus - $quantity;
  $totalValue = $total - $MinusQuantityValue * $price;
}

$advert = array(
'cart_total' => $cart_total_item_count,
'price' => number_format($price, 2, '.', ','),
'sub_total' => $sub_total,
'total' => $totalValue,
'totalDecimal' => number_format($totalValue, 2, '.', ','),
);

echo json_encode($advert);

?>
