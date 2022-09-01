<?php
// connect to database
include('config/database_connection.php');
session_start();

// include objects
include_once('objects/product.php');
include_once('objects/product_image.php');

//Date and time catcher
$date = function()
{
    if(!isset($_COOKIE['GMT_bias']))
    {
?>

        <script type="text/javascript">
            var Cookies = {};
            Cookies.create = function (name, value, days) {
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    var expires = "; expires=" + date.toGMTString();
                }
                else {
                    var expires = "";
                }
                document.cookie = name + "=" + value + expires + "; path=/";
                this[name] = value;
            }

            var now = new Date();
            Cookies.create("GMT_bias",now.getTimezoneOffset(),1);
            window.location = "<?php echo $_SERVER['PHP_SELF'];?>";
        </script>

        <?php

    }
    else {
      $fct_clientbias = $_COOKIE['GMT_bias'];
    }

    $fct_servertimedata = gettimeofday();
    $fct_servertime = $fct_servertimedata['sec'];
    $fct_serverbias = $fct_servertimedata['minuteswest'];
    $fct_totalbias = $fct_serverbias - $fct_clientbias;
    $fct_totalbias = $fct_totalbias * 60;
    $fct_clienttimestamp = $fct_servertime + $fct_totalbias;
    $fct_time = time();
    $fct_year = strftime("%Y", $fct_clienttimestamp);
    $fct_month = strftime("%m", $fct_clienttimestamp);
    $fct_day = strftime("%d", $fct_clienttimestamp);
    $fct_hour = strftime("%I", $fct_clienttimestamp);
    $fct_minute = strftime("%M", $fct_clienttimestamp);
    $fct_second = strftime("%S", $fct_clienttimestamp);
    $fct_am_pm = strftime("%p", $fct_clienttimestamp);
    return $fct_month."/".$fct_day."/".$fct_year." ".$fct_hour.":".$fct_minute.":".$fct_second." ".$fct_am_pm."";
};
$_SESSION['date'] = $date();

// initialize objects
$product = new Product($connect);
$product_image = new ProductImage($connect);

// set page title
$page_title="Products";

// page header html
include 'layout_header.php';
?>
<div id="pageName" value="products.php"></div>

<!-- Modal for #keywords limit input -->
<div id="limitInputWords" class="modal fade" role="dialog">
  <div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content resizeModel">
  <div class="modal-header">
    <h3>Notification</h3><button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body resizeModelBody">
  		<p>The limit for this input is 40 characters.</p>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-info" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>

<!-- <script src='libs/js/jQuery/jquery-3.4.1.js'></script> -->
	<!-- Search form -->
	<div class="post-search-panel">
    <form class='form-inline my-0 formSearchNextToProducts'><div class='form-group has-searchNextToProducts'>
  <span class='fa fa-search form-control-feedback'></span>
		<input type="text" id="keywords" class='form-control less-width-search' placeholder="Search"
    value="<?php echo isset($_GET['searchText']) ? $_GET['searchText'] : "";?>" maxlength="40"/>
	</div>
</form>
	</div>



<div class='row sorting-products-select' style='position:absolute;right:200px;margin-top:77px;z-index:1;'>
<i class="fas fa-sort-amount-up" style='font-size:22px;margin-top:12.5px;margin-right:10px;'></i>
  <select id="sortBy" onchange="searchFilter();">
  <option name="date_ascending" value="id|ASC" <?php echo (isset($_GET['sort']) && $_GET['sort'] == "date_ascending") ? "selected" : "";?>>Date: Newest First</option>
  <option name="date_descending" value="id|DESC" <?php echo (isset($_GET['sort']) && $_GET['sort'] == "date_descending") ? "selected" : "";?>>Date: Oldest First</option>
  <option name="name_ascending" value="name|ASC" <?php echo (isset($_GET['sort']) && $_GET['sort'] == "name_ascending") ? "selected" : "";?>>Ascending by name</option>
  <option name="name_descending" value="name|DESC" <?php echo (isset($_GET['sort']) && $_GET['sort'] == "name_descending") ? "selected" : "";?>>Descending by name</option>
  <option name="price_ascending" value="price|ASC" <?php echo (isset($_GET['sort']) && $_GET['sort'] == "price_ascending") ? "selected" : "";?>>Price: Low to High</option>
  <option name="price_descending" value="price|DESC" <?php echo (isset($_GET['sort']) && $_GET['sort'] == "price_descending") ? "selected" : "";?>>Price: High to Low</option>
</select>
</div>



	<div class="post-wrapper">
		<!-- Loading overlay -->
		<div class="loading-overlay"  style='width:923.9px;'><div class="overlay-content"><img id='preLoaderGif' style='width:550px;' src="images/Line-Preloader.gif"></div></div>

		<!-- Post list container -->
		<div id="postContent">
			<?php
			// Include pagination library file
			include_once 'Pagination.class.php';

			// Include database configuration file
			require_once 'config/database_connection.php';

			// Set some useful configuration
			$baseURL = 'getData.php';
			$limit = 8;

      // Set conditions for search
        $whereSQL = $orderSQL = '';
        if(!empty($_GET['searchText'])){
            $whereSQL = "WHERE name LIKE '%".$_GET['searchText']."%'";
        }
        if(!empty($_GET['sort'])) {

          if(isset($_GET['sort']) && $_GET['sort'] == "date_ascending") {
            $result = "id|ASC";
          } else if(isset($_GET['sort']) && $_GET['sort'] == "date_descending") {
            $result = "id|DESC";
          } else if(isset($_GET['sort']) && $_GET['sort'] == "name_ascending") {
            $result = "name|ASC";
          } else if(isset($_GET['sort']) && $_GET['sort'] == "name_descending") {
            $result = "name|DESC";
          } else if(isset($_GET['sort']) && $_GET['sort'] == "price_ascending") {
            $result = "price|ASC";
          } else if(isset($_GET['sort']) && $_GET['sort'] == "price_descending") {
            $result = "price|DESC";
          }

          $result_explode = explode('|', $result);
          $orderSQL = " ORDER BY ".$result_explode[0]." ".$result_explode[1];
        }else{
            $orderSQL = " ORDER BY id ASC";
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
          'contentDiv' => 'postContent',
          'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);


			// Fetch records based on the limit
			$query = $connect->query("SELECT * FROM products ".$whereSQL.$orderSQL." LIMIT $limit");




			if($query->rowCount() > 0) {

        // For paging loading on URL page paramater
        if(isset($_GET['page'])) {
          $loadPageNumber = ($_GET['page'] * $limit) - $limit;
          echo "<script>$(document).ready(function(){searchFilter(".$loadPageNumber.")});</script>";
        } else {
    ?>

			<!-- Display posts list -->
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
			} ?>
			</div>
      </div>

			<!-- Display pagination links -->
			<?php echo $pagination->createLinks(); ?>
	<?php
}
		}else{

			echo "<div class='search-not-found' style='width:923.9px;'><div class='search-not-found-content'><img style='width:100px;' src='images/questionMarkGlass.png'><p class='NosearchText' style='margin-top:20px;margin-bottom:0rem;font-weight:400;'>No search result found on:</p><p style='margin-bottom:0rem;' id='keywords-result'></p><p class='NosearchText' style='font-weight:400;margin-top:.3rem;'>Try refining your request...</p></div></div>";
		}


	include('layout_footer.php');
	?>
