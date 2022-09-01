<?php
// create a new function
function search($text){

	// connection to the Ddatabase
include('config/database_connection.php');
include_once('objects/product_image.php');

$product_image = new ProductImage($connect);

	// let's filter the data that comes in
	$text = htmlspecialchars($text);
	// prepare the mysql query to select the users
	$get_product = $connect->prepare("SELECT id,name,price FROM products WHERE name LIKE concat('%', :name, '%') LIMIT 5");
	// execute the query
	$get_product -> execute(array(':name' => $text));
	// show the users on the page
	while($names = $get_product->fetch(PDO::FETCH_ASSOC)){

		// select and show first product image
		$product_image->product_id=$names['id'];
		$stmt_product_image=$product_image->readFirst();

		while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
		// show each user as a link
		echo '<a href="product.php?id='.$names['id'].'"><div class="row"><div id="articleImage" class="col-md-3"><img class="image-show_search" src="uploads/images/'.$row_product_image['name'].'"></div><div id="articleName" class="col-md-7 my-auto">'.$names['name'].'</div> <div id="priceArticle" class="col-md-2 my-auto">&#8364;'.$names['price'].'</div></div></a>';
		}
	}

	// let's filter the data that comes in
	$text = htmlspecialchars($text);
	// prepare the mysql query to select the users
	$get_all_products = $connect->prepare("SELECT * FROM products WHERE name LIKE concat('%', :name, '%') ");
	// execute the query
	$get_all_products -> execute(array(':name' => $text));
	// Count TOTAL results
	$no_of_row = $get_all_products->rowCount();
	// show the users on the page
	if($no_of_row > 0) {
	echo '<a class="addHrefToFirstSearch"><button class="btn btn-primary button-end-show_search">Show all '.$no_of_row.' results</button></a>';
} else {
	echo '<button class="btn btn-primary button-end-show_search button-end-show_search-disabled">Sorry we couldnt find any results...</button>';
}

}
// call the search function with the data sent from Ajax
search($_GET['txt']);
?>
