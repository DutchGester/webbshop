<?php
// start session
session_start();

// connect to database
include('config/database_connection.php');
$first_name = "";
$last_name = "";
$street_name = "";
$street_number = "";
$zip_code = "";
$city = "";
$phonenumber = "";
$date = "";
$gender = "";
$country = "";

// include account variables to check on address etc. before checkout
include('account-variables.php');

// include objects
include_once('objects/product.php');
include_once('objects/product_image.php');

// initialize objects
$product = new Product($connect);
$product_image = new ProductImage($connect);

// set page title
$page_title="Checkout";

// include page header html
include 'layout_header.php';


if(count($_SESSION['cart'])>0){

    // get the product ids
    $ids = array();
    foreach($_SESSION['cart'] as $id=>$value){
        array_push($ids, $id);
    }

    $stmt=$product->readByIds($ids);

    $total=0;
    $item_count=0;
    $arr = array();
    echo "<div style='width:100%;' id='cartPageContainer' class='cartPageContainer'>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
            $arr[] = $row;

        $_SESSION['cart-checkout'] = $arr;

        $quantity=$_SESSION['cart'][$id]['quantity'];

        $sub_total=$price*$quantity;

        //echo "<div class='product-id' style='display:none;'>{$id}</div>";
        //echo "<div class='product-name'>{$name}</div>";

        // =================

            echo "<div  style='padding:25px;'class='col-md-12 styling-cart whole-product-div'>";
            echo "<div class='row align-self-center'>";
            echo "<div class='col-md-8 align-self-center'>";
                echo "<div class='product-name m-b-10px'><h4>{$name}</h4></div>";
                echo "</div>";
                echo "<div style='text-align:center;' class='col-md-3'>";
                echo $quantity>1 ? "<div class='quantity-items'>{$quantity} items</div>" : "<div class='quantity-items'>{$quantity} item</div>";
                echo "<h4 >&#8364; " . number_format($price, 2, '.', ',') . "</h4>";
            echo "</div>";
            echo "<div style='text-align:left;padding-left:0;' class='col-md-1 align-self-center'>";
            echo "<h5><a style='text-decoration:none;'href='cart.php'>Edit</a></h5>";
            echo "</div>";
            echo "</div>";

        echo "</div>";

        // =================

        $item_count += $quantity;
        $total+=$sub_total;

        $_SESSION['total'] =  $total;
        $_SESSION['item-count'] =  $item_count;

    }

            echo "</div>";
            if(!isset($_SESSION['user_id'])) {
            echo "<div style='margin-left:auto; margin-right:0;width:30.2%;' id='cartPageContainer' class='cartPageContainer'>";
            echo "<div  style='padding:25px;width:100%;max-width:100%;background:white;'class='col-md-12 styling-cart whole-product-div ml-auto'>";
            echo "<div class='row align-self-center'>";
            echo "<div style='text-align:center;' class='col-md-7'>";
            echo $item_count>1 ? "<h6 style='margin-left:0px;' class='place-order-total-empty'>Total ({$item_count} items)</h6>"
                : "<h6 style='margin-left:0px;' class='place-order-total-empty'>Total ({$item_count} item)</h6>";
                echo "<h4 style='' class='place-order-price-empty'>&#8364; " . number_format($total, 2, '.', ',') . "</h4>";
            echo "</div>";

            if($total <= 30 ) {
              $plusShippingCosts = $total + 5;
              $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;' class='col-md-5'><h6>Shipping costs</h6>
              <h5 freeShippingCostsOrNot' style='color:black;font-weight:bold;'>&#8364;5.00</div>";
            } else {
              $plusShippingCosts = $total;
              $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;' class='col-md-5'><h6>Shipping costs</h6>
              <h5 freeShippingCostsOrNot' style='color:#019829;font-weight:bold;'>Free</div>";
            }

            echo $freeOrShippingCosts;

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
          } else {
            echo "<div style='width:100%;' id='cartPageContainer' class='cartPageContainer'>";
            echo "<div  style='padding:25px;width:100%;max-width:100%;background:white;'class='col-md-12 styling-cart whole-product-div'>";
            echo "<div class='row align-self-center'>";
            echo "<div style='text-align:left;' class='col-md-3 align-self-center'>";
            echo "<h4>It will be delivered to</h4>";
            echo "</div>";
            echo "<div style='text-align:left;' class='col-md-1 align-self-center'>";
            echo "<i style='font-size:45px;' class='fas fa-long-arrow-alt-right' style='vertical-align: middle;'></i>";
            echo "</div>";
            echo "<div style='text-align:left;padding-right:0;padding-left:90px;' class='col-md-5 align-self-center'>";

    if(empty($first_name) || empty($last_name) || empty($street_name) ||
      empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
    empty($date) || empty($country) || empty($gender)) {
      echo "<h4 id='loadingDots'>Awaiting below information<span>.</span><span>.</span><span>.</span><span>.</span><span>.</span></h4>";
    } else {
      if($gender == 'Male') {
          echo "<p style='font-size:1.25rem;margin-bottom:.2rem'>Mr. ".$first_name. " ".$last_name."</p>";
        } else {
          echo "<p style='font-size:1.25rem;margin-bottom:.2rem'>Miss. ".$first_name. " ".$last_name."</p>";
        }
          echo "<p style='font-size:1.25rem;margin-bottom:.2rem'>".$street_name. " ".$street_number."</p>";
          echo "<p style='font-size:1.25rem;margin-bottom:.2rem'>".$zip_code. " ".$city."</p>";
    }

            echo "</div>";
            echo "<div style='text-align:center;padding-left:0;margin-left:-40px;' class='col-md-2 align-self-center'>";
            echo $item_count>1 ? "<h6 style='margin-left:0px;' class='place-order-total-empty'>Total ({$item_count} items)</h6>"
                : "<h6 style='margin-left:0px;' class='place-order-total-empty'>Total ({$item_count} item)</h6>";
                echo "<h4 style='' class='place-order-price-empty'>&#8364; " . number_format($total, 2, '.', ',') . "</h4>";
            echo "</div>";

            if($total <= 30 ) {
              $plusShippingCosts = $total + 5;
              $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;max-width:10%;flex:0 0 10%;padding-right:0;' class='col-md-1 align-self-center'><h6>Shipping costs</h6>
              <h5 freeShippingCostsOrNot' style='color:black;font-weight:bold;'>&#8364;5.00</div>";
            } else {
              $plusShippingCosts = $total;
              $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;max-width:10%;flex:0 0 10%;padding-right:0;' class='col-md-1 align-self-center'><h6>Shipping costs</h6>
              <h5 freeShippingCostsOrNot' style='color:#019829;font-weight:bold;'>Free</div>";
            }

            echo $freeOrShippingCosts;

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

          }
            if(!isset($_SESSION['user_id'])) {
            echo "<div id='informationDivCheckout'><i class='fas fa-info-circle' style='color:white;margin-top:-5px;font-size:23px;margin-left:16px;'></i><h4>Login to continue or else if your new enter your email adress</h4></div>";
          }

    /* login */
    $message = '';

    if(isset($_POST["login"]))
    {

      $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address
      $t=time(); //Storing time in variable
      $diff = (time()-600); // Here 600 mean 10 minutes 10*60

      $query5 = "INSERT INTO `ip` (`address` ,`timestamp`)VALUES (:ip,CURRENT_TIMESTAMP)";
             $stmt5 = $connect->prepare($query5);
             $stmt5->bindParam(':ip', $ip);
             $stmt5->execute();

    	$query = "
    	SELECT * FROM register_user
    		WHERE user_email = :user_email
    	";
    	$statement = $connect->prepare($query);
    	$statement->execute(
    		array(
    				'user_email'	=>	$_POST["user_email"]
    			)
    	);
      $_SESSION['email'] = $_POST['user_email'];
    	$count = $statement->rowCount();
    	if($count > 0)
    	{
    		$result = $statement->fetchAll();
    		foreach($result as $row)
    		{
    			if($row['user_email_status'] == 'verified')
    			{
    				if(password_verify($_POST["user_password"], $row["user_password"]))
    				//if($row["user_password"] == $_POST["user_password"])
    				{

      					$query6 = "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE ? AND `timestamp` > (now() - interval 10 minute)";
      					$stmt6 = $connect->prepare($query6);
      					$stmt6->bindParam(1, $ip);
      					$stmt6->execute();
      					$count6 = $stmt6->fetchColumn();

      					if($count6 > 5)
      					{
                   echo "<style>.hidemessage {display:none}</style>";
      					   $message = "<div style ='text-align:center'><label class='text-danger'>Your email and password are correct but you are only allowed 5 attempts to login in 10 minutes, try again after 10 minutes<br>Attempts to login is <b>".$count6."</b> times</label></div>";
      					} else {

                  $query9 = "DELETE FROM ip WHERE address=:ip;";
                  $statement9 = $connect->prepare($query9);
                  $statement9->execute(array(
                  ':ip' => $ip
                  ));

    					$_SESSION['user_id'] = $row['register_user_id'];

              $query2 = "SELECT register_user_id FROM user_carts WHERE register_user_id=:id";
              $statement2 = $connect->prepare($query2);
              $statement2->execute(array(
              ':id' => $_SESSION['user_id']
              ));

              $no_of_row = $statement2->rowCount();

              if($no_of_row > 0) {

              $query3 = "DELETE FROM user_carts WHERE register_user_id=:id;";
              $statement3 = $connect->prepare($query3);
              $statement3->execute(array(
              ':id' => $_SESSION['user_id']
              ));
            }

            $serialized_cart = serialize($_SESSION["cart"]);

            $query4 = "INSERT INTO user_carts (register_user_id,cart_contents) VALUES
            (:register_user_id,:serialized_cart)";

            $statement4 = $connect->prepare($query4);
            $statement4->execute(array(
            ':register_user_id' => $_SESSION['user_id'],
            ':serialized_cart' => $serialized_cart
              ));

                echo "<script>window.location='checkout.php?checkout-login=success';</script>";
    				}
          }
    				else
    				{
              echo "<style>.hidemessage {display:none}</style>";
              // echo "<script>$('html, body').animate({ scrollTop: $(document).height() }, 100);</script>";
              $message = "<div style='text-align:center;'><label class='text-danger'>Wrong password</label></div>";

              $query7 = "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE ? AND `timestamp` > (now() - interval 10 minute)";
              $stmt7 = $connect->prepare($query7);
              $stmt7->bindParam(1, $ip);
              $stmt7->execute();
              $count7 = $stmt7->fetchColumn();

              if($count7 > 1)
              {
                echo "<style>.hidemessage {display:none}</style>";
                // echo "<script>$('html, body').animate({ scrollTop: $(document).height() }, 100);</script>";
                 $message = "<div style ='text-align:center'><label class='text-danger'>Wrong password<br>You are allowed 5 attempts to login in 10 minutes<br>Attempts to login is <b>".$count7."</b> times</label></div>";
              }
            }
    			}
    			else
    			{
            echo "<style>.hidemessage {display:none}</style>";
            // echo "<script>$('html, body').animate({ scrollTop: $(document).height() }, 100);</script>";
            $message = "<div style='text-align:center;'><label class='text-danger'>Please first verify<br>
                      Click on the email verification website link inside your email inbox</label></div>";
    			}
    		}
    	}
    	else
    	{
        echo "<style>.hidemessage {display:none}</style>";
        // echo "<script>$('html, body').animate({ scrollTop: $(document).height() }, 100);</script>";
        $message = "<div style='text-align:center;'><label class='text-danger'>Wrong email address</label></div>";

        $query8 = "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE ? AND `timestamp` > (now() - interval 10 minute)";
        $stmt8 = $connect->prepare($query8);
        $stmt8->bindParam(1, $ip);
        $stmt8->execute();
        $count8 = $stmt8->fetchColumn();

        if($count8 > 1)
        {
           echo "<style>.hidemessage {display:none}</style>";
           $message = "<div style ='text-align:center'><label class='text-danger'>Wrong email address<br>You are allowed 5 attempts to login in 10 minutes<br>Attempts to login is <b>".$count8."</b> times</label></div>";
        }
      }
    }


    if(isset($_SESSION['user_id'])) {
    if(empty($first_name) || empty($last_name) || empty($street_name) ||
      empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
	  empty($date) || empty($country) || empty($gender)) {
      // echo "<script>$('html, body').animate({ scrollTop: $(document).height() }, 100);</script>";
      $message = "<div class='alert alert-danger' style='width:400px;font-size:18px;font-weight:500;text-align:center;margin-top:40px;margin-bottom:30px;'>Fill in the below red field(s) to continue</div>";
      echo("
      <style>.disable-cursor {
              cursor: no-drop;
            }

            .disable-cursor a {
              color: black;
              pointer-events: none;
              text-decoration: none;
            }
            </style>");
      }
    }

    if(isset($_SESSION['user_id'])) {
    if(empty($first_name) || empty($last_name) || empty($street_name) ||
      empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
    empty($date) || empty($country) || empty($gender)) {
      // echo "<script>$('html, body').animate({ scrollTop: $(document).height() }, 100);</script>";
      $messageMobile = "<div class='checkout-account-message-mobile'><label class='text-danger'>Fill in your above information to continue</label></div>";
      echo("
      <style>.disable-cursor {
              cursor: no-drop;
            }

            .disable-cursor a {
              color: black;
              pointer-events: none;
              text-decoration: none;
            }
            </style>");
      }
    }

 if($first_name && $last_name && $street_name && $street_number && $zip_code && $city
	&& $phonenumber && $date && $country && $gender) {
    if (isset($_GET['account-checkout'])) {
    if($_GET['account-checkout'] == 'success'){
    // echo "<script>$('html, body').animate({ scrollTop: $(document).height() }, 100);</script>";
    $message = "<label class='text-success'>You can now place your order</label>";
		}
	}
}
if($first_name && $last_name && $street_name && $street_number && $zip_code && $city
&& $phonenumber && $date && $country && $gender){
if (isset($_GET['checkout-login'])) {
if($_GET['checkout-login'] == 'success'){
// echo "<script>$('html, body').animate({ scrollTop: $(document).height() }, 100);</script>";
$message = "<label class='text-success'>You can now place your order</label>";
    }
  }
}

    // echo "<div class='col-md-8'></div>";
    if(isset($_SESSION['user_id']) && $first_name && $last_name && $street_name
      && $street_number && $zip_code && $city && $phonenumber && $date && $country && $gender) {
      echo "<div class='col-md-12 text-align-center'>";
    } else {
      echo "<div style='padding-left:0px;' class='col-md-12'>";
    }
        echo "<div class='cart-row login-checkout register-email-checkout'>";
        if(!empty($_SESSION['user_id'])) {
        if(empty($first_name) || empty($last_name) || empty($street_name) ||
          empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
		  empty($date) || empty($country) || empty($gender)) {
        echo $message;
        include('account-for-checkout.php');

        }
      }
    if(!isset($_SESSION['user_id'])) {
        echo "<div class= 'col-md-4' style='padding-left:0px;max-width:35%;margin-top:35px;display:inline-block;border-right:1px solid grey;padding-right:30px;'>
        <form method='post'>";
        echo $message;
        echo "
          <div class='form-group'>
          <label><b>For existing users</b></label>
          <input type='email' name='user_email' class='form-control' placeholder='User Email' required />
          </div>
          <div class='form-group'>
          <label>Password</label>
          <input type='password' name='user_password' class='form-control' required />
          </div>
          <div class='form-group'>
          <input type='submit' name='login' value='Login' class='btn btn-primary' />
          <a style='margin-left:10px;' href='reset-password.php'>Forgot your password?</a>
          </div>

          </form>
        </div>";
        echo "<div class= 'col-md-4' style='max-width:36%;margin-top:35px;display:inline-block;margin-left:5px;border-right:1px solid grey;padding-right:30px;'>
        <form method='post'>";
        echo $message;
        echo "
          <div class='form-group'>
          <label><b>For existing users</b></label>
          <input type='email' name='user_email' class='form-control' placeholder='User Email' required />
          </div>
          <div class='form-group'>
          <label>Password</label>
          <input type='password' name='user_password' class='form-control' required />
          </div>
          <div class='form-group'>
          <input type='submit' name='login' value='Login' class='btn btn-primary' />
          <a style='margin-left:10px;' href='reset-password.php'>Forgot your password?</a>
          </div>

          </form>
        </div>";
      }

          if(empty($first_name) || empty($last_name) || empty($street_name) ||
            empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
		  empty($date) || empty($country) || empty($gender)) {
                // echo $item_count>1 ? "<h4 style='margin-left:0px;' class='m-b-10px place-order-total-empty'>Total ({$item_count} items)</h4>"
                //     : "<h4 style='margin-left:0px;' class='m-b-10px place-order-total-empty'>Total ({$item_count} item)</h4>";
            } else {
              // echo $item_count>1 ? "<h4 style='margin-left:0px;' class='m-b-10px place-order-total'>Total ({$item_count} items)</h4>"
              //       :"<h4 style='margin-left:0px;' class='m-b-10px place-order-total'>Total ({$item_count} item)</h4>";
            }
            if(empty($first_name) || empty($last_name) || empty($street_name) ||
              empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
		  empty($date) || empty($country) || empty($gender)) {
            // echo "<h4 style='margin-left:32px' class='place-order-price-empty'>&#8364; " . number_format($plusShippingCosts, 2, '.', ',') . "</h4>";
          } else {
            // echo "<h4 class='place-order-price'>&#8364; " . number_format($total, 2, '.', ',') . "</h4>";
          }
          if(isset($_SESSION['user_id'])) {
            if(empty($first_name) || empty($last_name)
              || empty($street_name) || empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
		            empty($date) || empty($country) || empty($gender)) {
            // echo "<span class='disable-cursor place-order-button'>";
            // echo "<a href='place_order.php?order=success' class='btn btn-success m-b-10px'>";
            //     echo "<i class='fas fa-shopping-cart'></i>&nbsp;&nbsp;Place Order";
            // echo "</a>";
            // echo "</span>";
          } else {
            echo "<span class='disable-cursor'>";
            echo "<a href='place_order.php?order=success' class='btn btn-lg btn-success mt-5' style='padding:0.5rem 2.5rem;font-size:17px;'>";
                echo "<i class='fas fa-shopping-cart'></i>&nbsp;&nbsp;Place Order";
            echo "</a>";
            echo "</span>";
          }
          } else {
            // echo("
            // <style>.disable-cursor {
            //         cursor: no-drop;
            //       }
            //
            //       .disable-cursor a {
            //         color: black;
            //         pointer-events: none;
            //         text-decoration: none;
            //       }
            //       </style>");
            // echo "<span class='disable-cursor place-order-button'>";
            // echo "<a href='place_order.php?order=success' class='btn btn-lg btn-success m-b-10px' style='padding:0.5rem 2.5rem;font-size:17px;'>";
            //     echo "<i class='fas fa-shopping-cart'></i>&nbsp;&nbsp; Place Order";
            // echo "</a>";
            // echo "</span>";
          }
        echo "</div>";
    echo "</div>";

}

else{
    echo "<div class='col-md-12'>";
        echo "<div class='alert alert-danger'>";
            echo "No products found in your cart!";
        echo "</div>";
    echo "</div>";
}

include 'layout_footer.php';
?>
