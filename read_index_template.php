<?php
if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=array();
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    // creating box
    echo "<div class='col-md-3 m-b-40px' style='width: 100%;flex: 0 0 100%;max-width:100%;'>";

        // product id for javascript access
        echo "<div class='product-id display-none'>{$id}</div>";

        echo "<a href='product.php?id={$id}' class='product-link'>";
            // select and show first product image
            $product_image->product_id=$id;
            $stmt_product_image=$product_image->readFirst();

            while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
                echo "<div class='m-b-10px'>";
                echo "<img src='uploads/images/{$row_product_image['name']}' class='w-100-pct' />";
                echo "</div>";
            }

            // product name
            echo "<div class='product-name m-b-10px'><b class='indexprice'>&#8364;{$price} </b><div class='productText'>{$name}</div></div>";
        echo "</a>";

        // add to cart button
        echo "<div class='m-b-10px change-style-after-click' data-id='{$id}'>";
            if(array_key_exists($id, $_SESSION['cart'])){
                echo "<a href='cart.php' class='btn btn-success w-100-pct fade-in-color-button'>";
                    echo "Update Quantity";
                echo "</a>";
            }else{
                echo "<a class='btn btn-primary w-100-pct add_to_cart' data-id='{$id}'>Add to Cart</a>";
            }
        echo "</div>";

    echo "</div>";
}

include_once('paging.php');
?>
