<?php
session_start();

if(isset($_POST['page'])){
  // include objects
  include_once('objects/product.php');
  include_once('objects/product_image.php');
  // initialize objects
  $product = new Product($connect);
  $product_image = new ProductImage($connect);
    // Include pagination library file
    include_once 'Pagination.class.php';

    // Include database configuration file
    require_once 'config/database_connection.php';

	// Set some useful configuration
	$baseURL = 'getData.php';
	$offset = !empty($_POST['page'])?$_POST['page']:0;
	$limit = 8;

	// Set conditions for search
    $whereSQL = $orderSQL = '';
    if(!empty($_POST['keywords'])){
        $whereSQL = "WHERE name LIKE '%".$_POST['keywords']."%'";
    }
    if(!empty($_POST['sortBy'])){
      $result = $_POST['sortBy'];
      $result_explode = explode('|', $result);
      $orderSQL = " ORDER BY ".$result_explode[0]." ".$result_explode[1];
    }else{
        $orderSQL = " ORDER BY id DESC";
    }






	// Count of all records
    $query   = $connect->query("SELECT COUNT(*) as rowNum FROM products ".$whereSQL.$orderSQL);
    $result  = $query->fetch(PDO::FETCH_ASSOC);
    $rowCount= $result['rowNum'];

	// Initialize pagination class
    $pagConfig = array(
        'baseURL' => $baseURL,
        'totalRows' => $rowCount,
        'perPage' => $limit,
		'currentPage' => $offset,
		'contentDiv' => 'postContent',
		'link_func' => 'searchFilter'
    );
    $pagination =  new Pagination($pagConfig);

    // Fetch records based on the offset and limit
    $query = $connect->query("SELECT * FROM products $whereSQL $orderSQL LIMIT $offset,$limit");

    if($query->rowCount() > 0){
    ?>

    </div>

<div class='labelTextFromSearch'><span class='labelTextFromSearchSpan'></span><a class='closeLabelText'></a></div>
<div class='resetAllFilters'><a class="resetAllFiltersButton">Reset all filters</a></div>
<div class="products-wrapper" style='width:923.9px;'>
  <div class='row products-container' style='margin-left:2%;margin-top:125px;'>

      <?php while($row = $query->fetch(PDO::FETCH_ASSOC)){
        extract($row);

  // creating box
  echo "<div class='col-md-3 m-b-40px product-size-for-mobile' style='width: 25%;flex: 0 0 25%;max-width:25%;'>";

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
  echo "</div>";
    echo "</div>";

       // Display pagination links
      echo $pagination->createLinks();
    }else{
      echo "<script>$(document).ready(function(){ $('.loading-overlay').hide(); });</script>";
      echo "<style>.sorting-products-select {display:none;}</style>";
     echo "<div class='search-not-found' style='width:923.9px;'><div class='search-not-found-content'><img style='width:100px;' src='images/questionMarkGlass.png'><p class='NosearchText' style='margin-top:20px;margin-bottom:0rem;font-weight:400;'>No search result found on:</p><p style='margin-bottom:0rem;' id='keywords-result'></p><p class='NosearchText' style='font-weight:400;margin-top:.3rem;'>Try refining your request...</p></div></div>";
	}
}
?>
