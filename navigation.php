<?php
include('config/database_connection.php');

$message = '';

//Code for added-to-cart goes back to current URL
	 $current_pagename = basename($_SERVER['REQUEST_URI']);

//Remove empty ID(key) in array
	 $array = $_SESSION['cart'];

	 foreach($array as $key=>$value)
	 {
	     if(is_null($value) || $key == "")
	         unset($array[$key]);
	 }

	 $cart_total_item_count = array_sum( array_column($array, 'quantity' ));

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand mobiletitleheader" style="width: 100px;left: 0;right: 0;margin: 0 auto;" href="products.php">GW</a>
<?php if(!isset($_SESSION['user_id'])) {

		echo "<a class='navbar-brand mobiletitleheader-smallscreen' href='products.php'>GW</a>";

	} else {
		echo "<a class='navbar-brand mobiletitleheader-smallscreen2' href='products.php'>GW</a>";
	}
	?>
<div class="container containerDropdownTogglerMenu">


											<a class="navbar-brand" id='searchIconHeaderPress' style='padding:0;margin:0;'><i class="fa fa-search form-control-feedback searchIconForMobile"></i></a><input class='form-control form-control-sm searchInputHeader'></input>
											<a class="navbar-brand" id='crossForInput' style='padding:0;margin:0;'>
											<i class="fas fa-times crossInput"></i>
										</a>
											<a class="nav-link hideCartForDesktop" href="cart.php">
													<i class="fas fa-shopping-cart shopping-cart-header"></i><div class="badge badge-primary" id="cart-count"><?php echo $cart_total_item_count; ?></div>
											</a>



            <button style='z-index:99999;' class="navbar-toggler collapsed order-first" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
							<span class='navbarButtonEffect'> </span>
	            <span> </span>
	            <span class='navbarButtonEffect'> </span>
              </button>
							<a class="navbar-brand titleheader" href="products.php">Gester's Webstore</a>
								<form class="form-inline my-0 form-search-header"><div class="form-group has-search">
							<span class="fa fa-search form-control-feedback"></span>
							<input id='search' type="text" class="form-control input-more-width" placeholder="Search">
							</div></form><div class="show_search" id="show_search"></div>
<div class="collapse navbar-collapse" id="myNavbar">



             <ul class="navbar-nav mr-auto hideSearchForMobile">

                <!-- highlight if $page_title has 'Products' word. -->
<!--
                <li <?php echo $page_title=="Products" ? "class='nav-item active'" : ""; ?>>
                    <a class="nav-link" href="index.php" >Products</a>
                </li> -->

            </ul>



					<ul class="navbar-nav">

						<?php
						if(!isset($_SESSION['user_id'])) {
							$classLogin = ($page_title=='Login') ? "class='nav-item active removeForDynamicLogin'" : "class='removeForDynamicLogin'";
							$classRegister = ($page_title=='Register') ? "class='nav-item active removeForDynamicLogin'" : "class='removeForDynamicLogin'";
							echo "
							<li $classLogin>
						<a id='dropdownMenuLogin' class='nav-link badge no-style-for-badge dropdown-togglez' data-toggle='dropdown' href='#'>Login<i class='arrow-loginheader down'></i></a>
						<!-- Dropdown login begins here -->
							<ul class='dropdown-menu dropdown-menu-login mt-1'>
								<li class='p-3'>
											<form method='POST' id='loginFormHeader' class='recaptcha_form'>
													<div class='form-group'>
															<input name='user_email' id='loginEmailHeader' placeholder='Email' class='form-control form-control-sm' type='text'
															oninvalid='setCustomValidity('This is not a valid email.')' oninput='setCustomValidity('')'
															pattern='^[^(\.)][a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[a-z]{2,5}' required/>
													</div>
													<div class='input-group' style='margin-bottom:1rem;'>
															<input name='user_password' id='loginPasswordHeader' placeholder='Password' class='form-control form-control-sm loginPassword pwd2'
															type='password' pattern='((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})'
															oninvalid='setCustomValidity('This is not a valid password.')' oninput='setCustomValidity('')' required/>
															<span class='input-group-btn'>
																<button class='btn btn-default reveal2' tabindex='-1' type='button'><i class='fas fa-eye change-eye2'></i></button>
															</span>
													</div>
													<div class='form-group'>
													<input type='hidden' name='token' id='tokenLoginHeader' />
															<button type='submit' id='loginSubmitButtonHeader' name='loginHeader' class='btn btn-primary btn-block'>Login</button>
													</div>
													<div class='form-group text-xs-center'>
															<small><a href='reset-password.php'>Forgot password?</a></small>
													</div>
											</form>
									</li>
							</ul>
						</li>
							<li $classRegister style='margin-right:10px;'>
								<a class='nav-link' href='register.php'>Register</a>
							</li>
							";

							echo "<div id='dynamicAjaxLogin'></div>";
							echo "
							<li class='nav-item showThisDynamicLogin' style='margin-right:15px;display:none;'>
							<a class='nav-link' href='logout.php'>Log out</a>
							</li>
							";
							}
						else {
							/* Catch firstname */
					    $sql = "SELECT user_firstname FROM register_user WHERE register_user_id= :id";
					    $statement = $connect->prepare($sql);
					    $statement->bindValue(':id', $_SESSION["user_id"]);
					    $success = $statement->execute();
							$row = $statement->fetch();

							$firstname = $row['user_firstname'];

							echo "<ul class='dropdown'><a class='welcome'><a class='badge badge-pill badge-primaryz welcomeText arrow-toggle' data-toggle='dropdown' align='center'>Welcome $firstname&nbsp;<i class='welcome-user-arrow down'></i></a></a>";
							echo "<li class='dropdown-menu dropdown-menu-welcome'>
									<a class='dropdown-header accountOverviewGreyBackground forArrow'><b>Account overview</b></a>
								<div class='dropdown-divider'></div>
									<a id='accountClickMenu' class='dropdown-item forArrow' >Account</a>
								<div class='dropdown-divider'></div>
									<a id='changePasswordClickMenu' class='dropdown-item forArrow'>Change password</a>
									<div class='dropdown-divider'></div>
										<a href='order-history.php' class='dropdown-item forArrow'>Order history</a>
								</li>
							</ul>";

							$query5 = "SELECT cart_contents FROM user_carts WHERE register_user_id=:register_user_id";
							$statement5 = $connect->prepare($query5);
							$statement5->bindValue(':register_user_id', $_SESSION['user_id']);
							$success5 = $statement5->execute();
							$row5 = $statement5->fetch();

							$result5 = $statement5->rowCount();

							if($result5 > 0) {
											$cart_content = $row5['cart_contents'];
											$cart = unserialize($cart_content);
											$_SESSION['cart'] = $cart;
							}

							echo "
							<li class='nav-item' style='margin-right:15px;'>
							<a class='nav-link' href='logout.php'>Log out</a>
							</li>
							";
					}


					?>
							<li id="cartMenu" <?php echo $page_title=="Cart" ? "class='nav-item'" : ""; ?> >
												<a class="nav-link" href="cart.php">
														<i class="fas fa-shopping-cart shopping-cart-header"></i><div class="badge badge-primary" id="cart-count"><?php echo $cart_total_item_count; ?></div>
												</a>
										</li>
									</ul>
          	</div>

</div>
        </nav>
				<div class="navbarSecond">
					<div class='container'>
				  <a href="products.php">Products</a>
				  <div class="subnav">
				    <button class="subnavbtn">NEW RELEASES<i class='subnav-arrow down'></i></button>
				    <div class="subnav-content">
							<div class='container containerSubNavContent'>
								<div class='row'>
								<div class='col-md-2 margin-right-subnav-links'>
				      <a href="#">Bestsellers</a>
				      <a href="#">Shop all new arrivals</a>
				    </div>
						<div class='col-md-2 normal-subnav-links margin-right-subnav-links' style='border-left: solid 1px white;'>
					<a href="#">NEW FOR MEN</a>
					<a href="#">Shoes</a>
					<a href="#">Clothing</a>
					<a href="#">Shop new</a>
				</div>
				<div class='col-md-2 normal-subnav-links margin-right-subnav-links'>
			<a href="#">NEW FOR WOMEN</a>
			<a href="#">Shoes</a>
			<a href="#">Clothing</a>
			<a href="#">Shop new</a>
		</div>
		<div class='col-md-2 normal-subnav-links margin-right-subnav-links' style='border-left: solid 1px white;'>
	<a href="#">NEW FOR KIDS</a>
	<a href="#">Boys shoes</a>
	<a href="#">Boys clothing</a>
	<a href="#">Girls shoes</a>
	<a href="#">Girls clothing</a>
	<a href="#">Shop new</a>
</div>
			</div>
						</div>
						</div>
				  </div>
					<div class="subnav">
						<button class="subnavbtn">MEN<i class='subnav-arrow down'></i></button>
						<div class="subnav-content">
							<div class='container containerSubNavContent'>
								<div class='row'>
								<div class='col-md-2 margin-right-subnav-links'>
							<a href="#">New releases</a>
							<a href="#">Bestsellers</a>
						</div>
						<div class='col-md-2 normal-subnav-links margin-right-subnav-links' style='border-left: solid 1px white;'>
					<a href="#">SHOES</a>
					<a href="#">All shoes</a>
					<a href="#">All sale shoes</a>
					<a href="#">Basketball</a>
					<a href="#">Football</a>
					<a href="#">Tennis</a>
				</div>
				<div class='col-md-2 normal-subnav-links margin-right-subnav-links'>
			<a href="#">CLOTHING</a>
			<a href="#">All clothing</a>
			<a href="#">All sale clothing</a>
			<a href="#">T-shirts</a>
			<a href="#">Hoodies</a>
			<a href="#">Jackets</a>
		</div>
			</div>
						</div>
						</div>
					</div>
					<div class="subnav">
						<button class="subnavbtn">WOMEN<i class='subnav-arrow down'></i></button>
						<div class="subnav-content">
							<div class='container containerSubNavContent'>
								<div class='row'>
								<div class='col-md-2 margin-right-subnav-links'>
							<a href="#">New releases</a>
							<a href="#">Bestsellers</a>
						</div>
						<div class='col-md-2 normal-subnav-links margin-right-subnav-links' style='border-left: solid 1px white;'>
					<a href="#">SHOES</a>
					<a href="#">All shoes</a>
					<a href="#">All sale shoes</a>
					<a href="#">Basketball</a>
					<a href="#">Football</a>
					<a href="#">Tennis</a>
				</div>
				<div class='col-md-2 normal-subnav-links margin-right-subnav-links'>
			<a href="#">CLOTHING</a>
			<a href="#">All clothing</a>
			<a href="#">All sale clothing</a>
			<a href="#">T-shirts</a>
			<a href="#">Hoodies</a>
			<a href="#">Jackets</a>
		</div>
			</div>
						</div>
						</div>
					</div>
					<div class="subnav">
						<button class="subnavbtn">KIDS<i class='subnav-arrow down'></i></button>
						<div class="subnav-content">
							<div class='container containerSubNavContent'>
								<div class='row'>
								<div class='col-md-2 margin-right-subnav-links'>
							<a href="#">New releases</a>
							<a href="#">Bestsellers</a>
						</div>
						<div class='col-md-2 normal-subnav-links margin-right-subnav-links' style='border-left: solid 1px white;'>
					<a href="#">SHOES</a>
					<a href="#">All shoes</a>
					<a href="#">All sale shoes</a>
					<a href="#">Basketball</a>
					<a href="#">Football</a>
					<a href="#">Tennis</a>
				</div>
				<div class='col-md-2 normal-subnav-links margin-right-subnav-links'>
			<a href="#">CLOTHING</a>
			<a href="#">All clothing</a>
			<a href="#">All sale clothing</a>
			<a href="#">T-shirts</a>
			<a href="#">Hoodies</a>
			<a href="#">Jackets</a>
		</div>
			</div>
						</div>
						</div>
					</div>
					<div class="subnav">
						<button class="subnavbtn">SALE<i class='subnav-arrow down'></i></button>
						<div class="subnav-content">
							<div class='container containerSubNavContent'>
								<div class='row'>
								<div class='col-md-2 margin-right-subnav-links'>
							<a href="#">SHOP ALL SALE</a>
						</div>
						<div class='col-md-2 normal-subnav-links margin-right-subnav-links' style='border-left: solid 1px white;'>
					<a href="#">SALE FOR MEN</a>
					<a href="#">Clothing</a>
					<a href="#">Shoes</a>
				</div>
				<div class='col-md-2 normal-subnav-links margin-right-subnav-links'>
			<a href="#">SALE FOR WOMEN</a>
			<a href="#">Clothing</a>
			<a href="#">Shoes</a>
		</div>
		<div class='col-md-2 normal-subnav-links margin-right-subnav-links' style='border-left: solid 1px white;'>
	<a href="#">TOP SALES FOR KIDS</a>
	<a href="#">Clothing</a>
	<a href="#">Shoes</a>
</div>
			</div>
						</div>
						</div>
					</div>
				</div>
			</div>

			<div id="loginMessageModal" class="modal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title text-center col-12">Something went wrong
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</h5>
			</div>
			<div class="modal-body text-center">
			<p class="text-danger showMessageModal"></p>
			</div>
			<div class="modal-footer">
			<button id="modal-button" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
			</div>
			</div>
		</div>

		<div id="addedToCartModal" class="modal" tabindex="-1" role="dialog">
<div class="containerCartModal">
	<div class="contentModalCartModal">
		<div class="row mx-auto">
			<div class="col align-self-center"><img class="cart-after-item-added" src="images/add-to-cart-icon.png"></div>
		</div>
		<div class="row mx-auto">
			<h3 class="col align-self-center" style="color:white;font-weight:650">Your item is added to the cart</h3>
		</div>
		<div class="row mx-auto">
			<p class="col align-self-center" style="color:#ffc107;font-weight:650;">You have <span class="badge badge-primary" id="added-to-cart-cart-count"></span> items in your cart</p>
	</div>
<div class="row mx-auto go-down-for-mobile">
	<div class="col align-self-center">
	<a href="checkout.php"><button id="go-down-button-for-mobile" style="margin-right:4px;font-weight:650;" type="button" class="btn btn-primary col-md-4">Checkout</button></a>
<button style="margin-left:4px;font-weight:650;"type="button" class="btn btn-warning col-md-4" data-dismiss="modal">Continue shopping</button>
</div>
</div>
	</div>
	</div>
	</div>
