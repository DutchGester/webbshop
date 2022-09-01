<?php
// start session
session_start();
include('config/database_connection.php');
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$subtotal = isset($_GET['subtotal']) ? $_GET['subtotal'] : "";
$total = isset($_GET['total']) ? $_GET['total'] : "";
// $name = isset($_GET['name']) ? $_GET['name'] : "";

// remove the item from the array

unset($_SESSION['cart'][$id]);

if(isset($_SESSION['user_id'])) {

    $serialized_cart = serialize($_SESSION["cart"]);

    $query2 = "UPDATE user_carts SET cart_contents=:cart_contents
              WHERE register_user_id=:register_user_id";

    $statement2 = $connect->prepare($query2);
    $statement2->execute(array(
    ':register_user_id' => $_SESSION['user_id'],
    ':cart_contents' => $serialized_cart
    ));
}

$array = $_SESSION['cart'];

// foreach($array as $key=>$value)
// {
//     if(is_null($value) || $key == "")
//         unset($array[$key]);
// }

$cart_total_item_count = array_sum( array_column($array, 'quantity' ));

$substraction = $total - $subtotal;

$advert = array(
'cart_total' => $cart_total_item_count,
'total' => $substraction,
'totalDecimal' => number_format($substraction, 2, '.', ',')
);

echo json_encode($advert);

// redirect to product list and tell the user it was removed
// header('Location: cart.php?action=removed&id=' . $id);
?>
