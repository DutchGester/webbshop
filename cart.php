<?php
// start session
session_start();

// connect to database
include('config/database_connection.php');

// include objects
include_once('objects/product.php');
include_once('objects/product_image.php');

// initialize objects
$product = new Product($connect);
$product_image = new ProductImage($connect);

// set page title
$page_title="My basket";

// include page header html
include 'layout_header.php';

echo '<div id="pageName" value="cart.php"></div>';


$array = $_SESSION['cart'];

foreach($array as $key=>$value)
{
    if(is_null($value) || $key == "")
        unset($array[$key]);
}

if(count($array)>0){


    // get the product ids
    $ids = array();
    foreach($_SESSION['cart'] as $id=>$value){
        array_push($ids, $id);
    }

    $stmt=$product->readByIds($ids);

    $total=0;
    $item_count=0;
echo "<div id='cartPageContainer' class='cartPageContainer'>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quantity=$_SESSION['cart'][$id]['quantity'];
        $sub_total=$price*$quantity;


        // =================

        echo "<div class='col-md-12 styling-cart whole-product-div' data-id='{$id}'>";

          echo "<div class='row align-items-center'>";
          // select and show first product image
          $product_image->product_id=$id;
          $stmt_product_image=$product_image->readFirst();

          while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
              echo "<div class='col-md-2 center-for-mobile'>";
              echo "<img src='uploads/images/{$row_product_image['name']}' class='w-70-pct padding-image-cart' />";
              echo "</div>";
          }
            echo "<div class='col-md-4'>";
                echo "<a href='product.php?id={$id}' class='cart-product-link'><div class='product-name'><h5>{$name}</h5></div></a>";
  echo "</div>";
                // update quantity
                echo "<div class='col-md-2 update-quantity-form' style='text-align:center;'>";
                           echo "<div class='quantity d-flex align-items-center justify-content-center'>
                              <span class='cart-titles'>Quantity:</span>
                         <a class='change-quantity update-quantity disable-minus' data-id='{$id}' data-multi='-1'><div class='square minus'></div></a>
                         <div class='quantity-input cart-quantity d-flex align-items-center justify-content-center'>{$quantity}</div>
                         <a class='change-quantity update-quantity' data-id='{$id}' data-multi='1'><div class='square plus'></div></a>
                       </div>";

echo "</div>";

            //price
              echo "<div class='col-md-2 update-price-price-form' style='text-align:center;'>";
              echo "<div class='cart-price d-flex align-items-center justify-content-center'>
                  <span class='cart-titles'>Price:</span>
              ";
                echo "<span class='valutaSign'>&#8364;&nbsp;</span><span class='cart-price-price'>". number_format($price, 2, '.', ',')."</span>";
              echo "</div>";
                  echo "</div>";

            //total Price
            echo "<div class='col-md-1 update-subtotal-price-form' style='text-align:center;'>";
            echo "<div class='cart-price d-flex align-items-center justify-content-center'>
                <span class='cart-titles'>Total price:</span>
            ";
              echo "<span class='valutaSign'>&#8364;&nbsp;</span><span class='cart-price-subtotal'>". number_format($sub_total, 2, '.', ',')."</span>";
              echo "<span class='cart-price-subtotal-value display-none'>".$sub_total."</span>";
            echo "</div>";
                echo "</div>";
            // delete from cart
            echo "<div class='col-md-1 update-delete-product-form' style='text-align:right;padding-right:25px;font-size:20px;'>";
            echo "<a class='delete-product-cart' data-id='{$id}'>";
                echo "<i class='fas fa-trash-alt'></i>";
            echo "</a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";


        // =================

        $item_count += $quantity;
        $total+=$sub_total;

  }

  echo "</div>";
    echo "<div class='col-md-12 update-total-price-form'>";
        echo "<div class='cart-row'>";
          echo $item_count>1 ? "<div class='row'><h5 class='col-md-8'><h5 class='item-count m-b-10px col-md-2 text-md-left' style='font-weight:400;'>Total <span class='item-or-items'>items</span><span class='haakjes' style='font-size:15px;'> (</span><span class='item-count-for-ajax' style='font-size:15px;'>{$item_count}</span><span class='haakjes' style='font-size:15px;'>)</span></h5><h5 class='item-price col-md-2' style='font-weight:bold;'>&#8364;&nbsp;<span class='cart-price-total' style='font-weight:bold;'>" . number_format($total, 2, '.', ',') . "</span></h5></h5></div>"
                :"<div class='row'><h5 class='col-md-8'><h5 class='item-count m-b-10px col-md-2 text-md-left' style='font-weight:400;'>Total <span class='item-or-items'>item</span><span class='haakjes' style='font-size:15px;'> (</span><span class='item-count-for-ajax' style='font-size:15px;'>{$item_count}</span><span class='haakjes' style='font-size:15px;'>)</span></h5><h5 class='item-price col-md-2' style='font-weight:bold;'>&#8364;&nbsp;<span class='cart-price-total' style='font-weight:bold;'>" . number_format($total, 2, '.', ',') . "</span></h5></h5></div>";

                if($total <= 30 ) {
                  $plusShippingCosts = $total + 5;
                  $freeOrShippingCosts = "<h5 class='col-md-2 freeShippingCostsOrNot' style='color:black;font-weight:bold;'><div id='borderSecondHalf'></div>&#8364;&nbsp;5.00";
                } else {
                  $plusShippingCosts = $total;
                  $freeOrShippingCosts = "<h5 class='col-md-2 freeShippingCostsOrNot' style='color:#019829;font-weight:bold;'><div id='borderSecondHalf'></div>Free";
                }

                echo "<div class='row'><h5 class='col-md-8'></h5><h5 class='col-md-2 text-md-left' style='font-weight:400;'><div id='borderFirstHalf'></div>Shipping costs<i data-toggle='tooltip' class='fa fa-info-circle' title='Verzendkosten Gratis boven 30 euro'></i></h5>". $freeOrShippingCosts ."</h5></div>";
            echo "<div class='row' style='margin-top:5px;'><h5 class='col-md-8'><h5 class='item-count m-b-10px col-md-2 text-md-left' style='font-weight:bold;'>Total</h5><h5 class='item-price col-md-2' style='font-weight:bold;'>&#8364;&nbsp;<span class='cart-price-total' style='font-weight:bold;'>" . number_format($plusShippingCosts, 2, '.', ',') . "</span></h5></h5></div>";
                      echo "<span class='cart-price-total-value display-none'>".$total."</span>";
            echo "<a href='checkout.php' class='btn btn-success animationButonArrow' style='margin-top:20px;'>";
                echo "Proceed to Checkout<i class='fas fa-angle-double-right arrowInsideButton'></i>";
            echo "</a>";
        echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row paymentLogos' style='margin-top:10px;margin-bottom:30px;'><div class='ml-auto' style='padding-right:15px;'><img src='images/idealLogoSmall.png' style='width:30px;height:25px;'><img src='images/masterCardLogoSmall.png' style='margin-left:5px;width:60px;height:25px;'><img src='images/paypalLogoSmall.png' style='margin-left:5px;width:80px;height:25px;'></div></div>";

}

// no products were added to cart
else{
  echo "<style>#pageTitle {display:none;}</style>";
}

echo "<div class='col-md-12 emptyCartContainer text-align-center display-none'>";
echo '
<div class="containerEmptyCart">
  <div class="contentEmptyCart">
    <div class="row mx-auto">
      <div class="col align-self-center"><i class="fas fa-shopping-cart empty-cart-cart-page"></i></div>
    </div>
    <div class="row mx-auto">
      <h3 class="col align-self-center" style="color:black;font-weight:650">Your basket is empty</h3>
    </div>
    <div class="row mx-auto">
      <p class="col align-self-center" style="color:black;font-weight:650;">You have no items in your cart</p>
  </div>
  <div class="row mx-auto">
  	<div class="col align-self-center">
  	<a href="products.php"><button style="font-weight:650;"type="button" class="btn btn-warning col-md-4">Continue shopping</button></a>
  </div>
  </div>
  </div>
  </div>';
echo "</div>";



// layout footer
include 'layout_footer.php';
?>
