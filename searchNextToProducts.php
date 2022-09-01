<?php
session_start();
// create a new function
function search($text){

	// for pagination purposes
	$pageLiveSearch = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
	$records_per_pageLiveSearch = 8; // set records or rows of data per page
	$from_record_numLiveSearch = ($records_per_pageLiveSearch * $pageLiveSearch) - $records_per_pageLiveSearch; // calculate for the query LIMIT clause

	// connection to the Ddatabase
include('config/database_connection.php');
	// let's filter the data that comes in
	$text = htmlspecialchars($text);
	// prepare the mysql query to select the users
	$get_product = $connect->prepare("SELECT p.id,p.name,p.price,pi.name AS image_name FROM products p  INNER JOIN product_images pi ON p.id = pi.product_id WHERE p.name LIKE concat('%', ?, '%') LIMIT ?, ?  ");

	// bind limit clause variables
	$get_product->bindValue(1, $text, PDO::PARAM_STR);
	$get_product->bindValue(2, $from_record_numLiveSearch, PDO::PARAM_INT);
	$get_product->bindValue(3, $records_per_pageLiveSearch, PDO::PARAM_INT);

	// execute query
	$get_product->execute();

	// let's filter the data that comes in
	$text = htmlspecialchars($text);
	// prepare the mysql query to select the users
	$get_all_products = $connect->prepare("SELECT p.name FROM products p  INNER JOIN product_images pi ON p.id = pi.product_id WHERE p.name LIKE concat('%', ?, '%') ");
	// bind limit clause variables
	$get_all_products->bindValue(1, $text, PDO::PARAM_STR);

	// execute query
	$get_all_products->execute();

	// Count TOTAL results
	$no_of_row = $get_all_products->rowCount();

	echo "<div style='position:absolute;margin-top:-98px;'>".$no_of_row." results</div>";

	// show the users on the page
	echo "<div class='row' style='margin-left:.5px;'>";
	while($names = $get_product->fetch(PDO::FETCH_ASSOC)){
		// show each user as a link
		// echo '<a href="product.php?id='.$names['id'].'"><div class="row"><div class="col-md-3"><img class="image-show_search" src="uploads/images/'.$names['image_name'].'"></div><div class="col-md-7 my-auto">'.$names['name'].'</div> <div class="col-md-2 my-auto">&#8364;'.$names['price'].'</div></div></a>';


		// creating box
		echo "<div class='col-md-3 m-b-40px' style='width: 25%;flex: 0 0 25%;max-width:25%;'>";

				// product id for javascript access
				echo "<div class='product-id display-none'>".$names['id']."</div>";

				echo "<a href='product.php?id=".$names['id']."' class='product-link'>";


								echo "<div class='m-b-10px'>";
								echo "<img src='uploads/images/".$names['image_name']."' class='w-100-pct' />";
								echo "</div>";


						// product name
						echo "<div class='product-name m-b-10px'><b class='indexprice'>&#8364;".$names['price']." </b><div class='productText'>".$names['name']."</div></div>";
				echo "</a>";

				// add to cart button
				echo "<div class='m-b-10px change-style-after-click' data-id='".$names['id']."'>";
						if(array_key_exists($names['id'], $_SESSION['cart'])){
								echo "<a href='cart.php' class='btn btn-success w-100-pct fade-in-color-button'>";
										echo "Update Quantity";
								echo "</a>";
						}else{
								echo "<a class='btn btn-primary w-100-pct add_to_cart' data-id='".$names['id']."'>Add to Cart</a>";
						}
				echo "</div>";

		echo "</div>";
	}
	echo "</div>";

	// show the users on the page
	if($no_of_row > 0) {
		$page_urlLiveSearch="products.php?";
} else {
	echo '<div>Sorry we couldnt find any results...</div>';
}


	$total_pagesLiveSearch = ceil($no_of_row / $records_per_pageLiveSearch);

}
// call the search function with the data sent from Ajax
search($_GET['txt']);
?>
