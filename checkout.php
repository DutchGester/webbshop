<?php
// start session
session_start();

// connect to database
include('config/database_connection.php');

if(isset($_SESSION['user_id']))
{

$sql = "
SELECT user_phonenumber,user_date,user_gender,user_country,user_email,user_firstname,user_lastname,
user_streetname,user_streetnumber,user_zipcode,user_city FROM register_user WHERE register_user_id= :id";

$statement = $connect->prepare($sql);
$statement->bindValue(':id', $_SESSION["user_id"]);
$success = $statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$array = array();
foreach ($rows as $row) {
    $array[] = $row['user_phonenumber'];
    $array[] = $row['user_date'];
    $array[] = $row['user_gender'];
    $array[] = $row['user_country'];
    $array[] = $row['user_email'];
    $array[] = $row['user_firstname'];
    $array[] = $row['user_lastname'];
    $array[] = $row['user_streetname'];
    $array[] = $row['user_streetnumber'];
    $array[] = $row['user_zipcode'];
    $array[] = $row['user_city'];
}

$phonenumber = $array[0];
$datez = $array[1];
$gender = $array[2];
$country = $array[3];
$email = $array[4];
$first_name = $array[5];
$last_name = $array[6];
$street_name = $array[7];
$street_number = $array[8];
$zip_code = $array[9];
$city = $array[10];
}

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
            echo "<div class='col-md-8 align-self-center full-width-mobile'>";
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
            echo "<div style='margin-left:auto; margin-right:0;width:30.2%;' id='cartPageContainer' class='cartPageContainer hideForDynamicOverflowForCheckOutRegistration'>";
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
              <h4 freeShippingCostsOrNot' style='color:black;'>&#8364;&nbsp;5.00</h4></div>";
            } else {
              $plusShippingCosts = $total;
              $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;' class='col-md-5'><h6>Shipping costs</h6>
              <h4 freeShippingCostsOrNot' style='color:#019829;font-weight:bold;'>Free</h4></div>";
            }

            echo $freeOrShippingCosts;

            echo "</div>";
            echo "</div>";
            echo "</div>";


            echo "<div style='width:100%;display:none;' id='cartPageContainer' class='cartPageContainer showForDynamicOverflowForCheckOutRegistration'>";
            echo "<div  style='padding:25px;width:100%;max-width:100%;background:white;'class='col-md-12 styling-cart whole-product-div'>";
            echo "<div class='row align-self-center'>";
            echo "<div style='text-align:left;' class='col-md-3 align-self-center itWillBeDeliveredToo'>";
            echo "<h4>It will be delivered to</h4>";
            echo "</div>";
            echo "<div style='text-align:left;' class='col-md-1 align-self-center'>";
            echo "<i style='font-size:45px;' class='fas fa-long-arrow-alt-right' style='vertical-align: middle;'></i>";
            echo "</div>";
            echo "<div style='text-align:left;padding-right:0;padding-left:50px;' class='col-md-5 align-self-center nameAdress'>";
            echo "<p class='firstNameLastName' style='font-size:1.25rem;margin-bottom:.2rem;display:none;'></p>";
            echo "<p class='streetNameStreetNumber' style='font-size:1.25rem;margin-bottom:.2rem;display:none;'></p>";
            echo "<p class='zipcodeCity' style='font-size:1.25rem;margin-bottom:.2rem;display:none;'></p>";

                  echo "</div>";
                  echo "<div style='text-align:center;padding-left:0;margin-left:-40px;' class='col-md-2 align-self-center'>";
                  echo $item_count>1 ? "<h6 style='margin-left:0px;' class='place-order-total-empty'>Total ({$item_count} items)</h6>"
                      : "<h6 style='margin-left:0px;' class='place-order-total-empty'>Total ({$item_count} item)</h6>";
                      echo "<h4 style='' class='place-order-price-empty'>&#8364; " . number_format($total, 2, '.', ',') . "</h4>";
                  echo "</div>";

                  if($total <= 30 ) {
                    $plusShippingCosts = $total + 5;
                    $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;max-width:10%;flex:0 0 10%;padding-right:0;' class='col-md-1 align-self-center shippingCosts'><h6>Shipping costs</h6>
                    <h4 freeShippingCostsOrNot' style='color:black;'>&#8364;&nbsp;5.00</h4></div>";
                  } else {
                    $plusShippingCosts = $total;
                    $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;max-width:10%;flex:0 0 10%;padding-right:0;' class='col-md-1 align-self-center shippingCosts'><h6>Shipping costs</h6>
                    <h4 freeShippingCostsOrNot' style='color:#019829;font-weight:bold;'>Free</h4></div>";
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
            echo "<div style='text-align:left;' class='col-md-3 align-self-center itWillBeDeliveredToo'>";
            echo "<h4>It will be delivered to</h4>";
            echo "</div>";
            echo "<div style='text-align:left;' class='col-md-1 align-self-center'>";
            echo "<i style='font-size:45px;' class='fas fa-long-arrow-alt-right' style='vertical-align: middle;'></i>";
            echo "</div>";
            echo "<div style='text-align:left;padding-right:0;padding-left:50px;' class='col-md-5 align-self-center nameAdress'>";

    if(empty($first_name) || empty($last_name) || empty($street_name) ||
      empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
    empty($country) || empty($gender)) {
      echo "<h4 id='loadingDots'>Awaiting below information<span>.</span><span>.</span><span>.</span><span>.</span><span>.</span></h4>";
      echo "<p class='firstNameLastName' style='font-size:1.25rem;margin-bottom:.2rem;display:none;'></p>";
      echo "<p class='streetNameStreetNumber' style='font-size:1.25rem;margin-bottom:.2rem;display:none;'></p>";
      echo "<p class='zipcodeCity' style='font-size:1.25rem;margin-bottom:.2rem;display:none;'></p>";

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
              $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;max-width:10%;flex:0 0 10%;padding-right:0;' class='col-md-1 align-self-center shippingCosts'><h6>Shipping costs</h6>
              <h4 freeShippingCostsOrNot' style='color:black;'>&#8364;&nbsp;5.00</h4></div>";
            } else {
              $plusShippingCosts = $total;
              $freeOrShippingCosts = "<div style='text-align:center;padding-left:1.5px;max-width:10%;flex:0 0 10%;padding-right:0;' class='col-md-1 align-self-center shippingCosts'><h6>Shipping costs</h6>
              <h4 freeShippingCostsOrNot' style='color:#019829;font-weight:bold;'>Free</h4></div>";
            }

            echo $freeOrShippingCosts;

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

          }

          if(isset($_SESSION['user_id'])) {
          if(empty($first_name) || empty($last_name) || empty($street_name) ||
            empty($street_number) || empty($zip_code) || empty($city) || empty($phonenumber) ||
          empty($country) || empty($gender)) {
            echo "
          <div class='container containerResize finishAccountCheckout col-md-12' style='padding:25px;width:95%!important;margin-top:50px;margin-left:28px;display:block;margin-bottom:50px;border:1px solid grey;box-shadow: 0px 0px 17px 0px #c2c2c2;'>
          <div class='row'>
          <div class='col-2'></div><div class='col-8'><div id='message2'></div></div>
          <div class='col-12' style='margin-bottom:30px;margin-top:10px;'><div class='col-2' style='text-align:right;'>* = required field</div></div>
          <div class='col-md-6'>
          <form method='post' id='finishAccountForm' class='recaptcha_form'>
          <div class='form-group row'>
          <label for='gender' style='text-align:right;' class='col-4 col-form-label'>Gender*</label>
          <div style='margin-top:6.5px;' class='col-8'>
          <input id='1' type='radio' name='gender' class='gender' value='Male' "; echo ($gender== 'Male') ?  'checked' : '' ; echo" required/>  <label for='1'>Male</label>
          <input id='2' style='margin-left:20px;' type='radio' name='gender' class='gender'  value='Female' "; echo ($gender== 'Female') ?  'checked' : '' ; echo"required/> <label for='2'>Female</label>
          </div>
          </div>
          <div class='form-group row'>
          <label for='name' style='text-align:right;' class='col-4 col-form-label'>First name*</label>
          <div class='col-8'>
          <input id='name' name='name' placeholder='First name' class='form-control'
          type='text' pattern='^[A-Za-z\s]+$' oninvalid='setCustomValidity('Only letters and spaces allowed.')' oninput='setCustomValidity('')'
          required value="; echo $first_name; echo" >
          </div>
          </div>
          <div class='form-group row'>
          <label for='lastname' style='text-align:right;' class='col-4 col-form-label'>Last name*</label>
          <div class='col-8'>
          <input id='lastname' name='lastname' placeholder='Last name' class='form-control'
          type='text' pattern='^[A-Za-z\s]+$' oninvalid='setCustomValidity('Only letters and spaces allowed.')' oninput='setCustomValidity('')'
          required value="; echo $last_name; echo">
          </div>
          </div>
          <div class='form-group row'>
          <label for='country' style='text-align:right;' class='col-4 col-form-label'>Country*</label>
          <div class='col-8'>
            <select name='country' class='form-control countrySelect' data-show-subtext='true' data-live-search='true' data-live-search-placeholder='Search your country...' required/>
            "; if($country) {
                if($country == 'Select Country') {
                echo "<option value='' selected>Select Country</option>";
              } else {
                echo "<option value='' selected>Select Country</option>";
                echo "<option selected='selected'>".$country."</option>";
                }
            }
            else {
                echo "<option value='' selected='selected'>Select Country</option>";
            }
            echo "
            <option value='United States'>United States</option>
            <option value='United Kingdom'>United Kingdom</option>
            <option value='Afghanistan'>Afghanistan</option>
            <option value='Albania'>Albania</option>
            <option value='Algeria'>Algeria</option>
            <option value='American Samoa'>American Samoa</option>
            <option value='Andorra'>Andorra</option>
            <option value='Angola'>Angola</option>
            <option value='Anguilla'>Anguilla</option>
            <option value='Antarctica'>Antarctica</option>
            <option value='Antigua and Barbuda'>Antigua and Barbuda</option>
            <option value='Argentina'>Argentina</option>
            <option value='Armenia'>Armenia</option>
            <option value='Aruba'>Aruba</option>
            <option value='Australia'>Australia</option>
            <option value='Austria'>Austria</option>
            <option value='Azerbaijan'>Azerbaijan</option>
            <option value='Bahamas'>Bahamas</option>
            <option value='Bahrain'>Bahrain</option>
            <option value='Bangladesh'>Bangladesh</option>
            <option value='Barbados'>Barbados</option>
            <option value='Belarus'>Belarus</option>
            <option value='Belgium'>Belgium</option>
            <option value='Belize'>Belize</option>
            <option value='Benin'>Benin</option>
            <option value='Bermuda'>Bermuda</option>
            <option value='Bhutan'>Bhutan</option>
            <option value='Bolivia'>Bolivia</option>
            <option value='Bosnia and Herzegovina'>Bosnia and Herzegovina</option>
            <option value='Botswana'>Botswana</option>
            <option value='Bouvet Island'>Bouvet Island</option>
            <option value='Brazil'>Brazil</option>
            <option value='British Indian Ocean Territory'>British Indian Ocean Territory</option>
            <option value='Brunei Darussalam'>Brunei Darussalam</option>
            <option value='Bulgaria'>Bulgaria</option>
            <option value='Burkina Faso'>Burkina Faso</option>
            <option value='Burundi'>Burundi</option>
            <option value='Cambodia'>Cambodia</option>
            <option value='Cameroon'>Cameroon</option>
            <option value='Canada'>Canada</option>
            <option value='Cape Verde'>Cape Verde</option>
            <option value='Cayman Islands'>Cayman Islands</option>
            <option value='Central African Republic'>Central African Republic</option>
            <option value='Chad'>Chad</option>
            <option value='Chile'>Chile</option>
            <option value='China'>China</option>
            <option value='Christmas Island'>Christmas Island</option>
            <option value='Cocos (Keeling) Islands'>Cocos (Keeling) Islands</option>
            <option value='Colombia'>Colombia</option>
            <option value='Comoros'>Comoros</option>
            <option value='Congo'>Congo</option>
            <option value='Congo, The Democratic Republic of The'>Congo, The Democratic Republic of The</option>
            <option value='Cook Islands'>Cook Islands</option>
            <option value='Costa Rica'>Costa Rica</option>
            <option value='Cote D'ivoire'>Cote D'ivoire</option>
            <option value='Croatia'>Croatia</option>
            <option value='Cuba'>Cuba</option>
            <option value='Cyprus'>Cyprus</option>
            <option value='Czech Republic'>Czech Republic</option>
            <option value='Denmark'>Denmark</option>
            <option value='Djibouti'>Djibouti</option>
            <option value='Dominica'>Dominica</option>
            <option value='Dominican Republic'>Dominican Republic</option>
            <option value='Ecuador'>Ecuador</option>
            <option value='Egypt'>Egypt</option>
            <option value='El Salvador'>El Salvador</option>
            <option value='Equatorial Guinea'>Equatorial Guinea</option>
            <option value='Eritrea'>Eritrea</option>
            <option value='Estonia'>Estonia</option>
            <option value='Ethiopia'>Ethiopia</option>
            <option value='Falkland Islands (Malvinas)'>Falkland Islands (Malvinas)</option>
            <option value='Faroe Islands'>Faroe Islands</option>
            <option value='Fiji'>Fiji</option>
            <option value='Finland'>Finland</option>
            <option value='France'>France</option>
            <option value='French Guiana'>French Guiana</option>
            <option value='French Polynesia'>French Polynesia</option>
            <option value='French Southern Territories'>French Southern Territories</option>
            <option value='Gabon'>Gabon</option>
            <option value='Gambia'>Gambia</option>
            <option value='Georgia'>Georgia</option>
            <option value='Germany'>Germany</option>
            <option value='Ghana'>Ghana</option>
            <option value='Gibraltar'>Gibraltar</option>
            <option value='Greece'>Greece</option>
            <option value='Greenland'>Greenland</option>
            <option value='Grenada'>Grenada</option>
            <option value='Guadeloupe'>Guadeloupe</option>
            <option value='Guam'>Guam</option>
            <option value='Guatemala'>Guatemala</option>
            <option value='Guinea'>Guinea</option>
            <option value='Guinea-bissau'>Guinea-bissau</option>
            <option value='Guyana'>Guyana</option>
            <option value='Haiti'>Haiti</option>
            <option value='Heard Island and Mcdonald Islands'>Heard Island and Mcdonald Islands</option>
            <option value='Holy See (Vatican City State)'>Holy See (Vatican City State)</option>
            <option value='Honduras'>Honduras</option>
            <option value='Hong Kong'>Hong Kong</option>
            <option value='Hungary'>Hungary</option>
            <option value='Iceland'>Iceland</option>
            <option value='India'>India</option>
            <option value='Indonesia'>Indonesia</option>
            <option value='Iran, Islamic Republic of'>Iran, Islamic Republic of</option>
            <option value='Iraq'>Iraq</option>
            <option value='Ireland'>Ireland</option>
            <option value='Israel'>Israel</option>
            <option value='Italy'>Italy</option>
            <option value='Jamaica'>Jamaica</option>
            <option value='Japan'>Japan</option>
            <option value='Jordan'>Jordan</option>
            <option value='Kazakhstan'>Kazakhstan</option>
            <option value='Kenya'>Kenya</option>
            <option value='Kiribati'>Kiribati</option>
            <option value='Korea, Democratic People's Republic of'>Korea, Democratic People's Republic of</option>
            <option value='Korea, Republic of'>Korea, Republic of</option>
            <option value='Kuwait'>Kuwait</option>
            <option value='Kyrgyzstan'>Kyrgyzstan</option>
            <option value='Lao People's Democratic Republic'>Lao People's Democratic Republic</option>
            <option value='Latvia'>Latvia</option>
            <option value='Lebanon'>Lebanon</option>
            <option value='Lesotho'>Lesotho</option>
            <option value='Liberia'>Liberia</option>
            <option value='Libyan Arab Jamahiriya'>Libyan Arab Jamahiriya</option>
            <option value='Liechtenstein'>Liechtenstein</option>
            <option value='Lithuania'>Lithuania</option>
            <option value='Luxembourg'>Luxembourg</option>
            <option value='Macao'>Macao</option>
            <option value='Macedonia, The Former Yugoslav Republic of'>Macedonia, The Former Yugoslav Republic of</option>
            <option value='Madagascar'>Madagascar</option>
            <option value='Malawi'>Malawi</option>
            <option value='Malaysia'>Malaysia</option>
            <option value='Maldives'>Maldives</option>
            <option value='Mali'>Mali</option>
            <option value='Malta'>Malta</option>
            <option value='Marshall Islands'>Marshall Islands</option>
            <option value='Martinique'>Martinique</option>
            <option value='Mauritania'>Mauritania</option>
            <option value='Mauritius'>Mauritius</option>
            <option value='Mayotte'>Mayotte</option>
            <option value='Mexico'>Mexico</option>
            <option value='Micronesia, Federated States of'>Micronesia, Federated States of</option>
            <option value='Moldova, Republic of'>Moldova, Republic of</option>
            <option value='Monaco'>Monaco</option>
            <option value='Mongolia'>Mongolia</option>
            <option value='Montserrat'>Montserrat</option>
            <option value='Morocco'>Morocco</option>
            <option value='Mozambique'>Mozambique</option>
            <option value='Myanmar'>Myanmar</option>
            <option value='Namibia'>Namibia</option>
            <option value='Nauru'>Nauru</option>
            <option value='Nepal'>Nepal</option>
            <option value='Netherlands'>Netherlands</option>
            <option value='Netherlands Antilles'>Netherlands Antilles</option>
            <option value='New Caledonia'>New Caledonia</option>
            <option value='New Zealand'>New Zealand</option>
            <option value='Nicaragua'>Nicaragua</option>
            <option value='Niger'>Niger</option>
            <option value='Nigeria'>Nigeria</option>
            <option value='Niue'>Niue</option>
            <option value='Norfolk Island'>Norfolk Island</option>
            <option value='Northern Mariana Islands'>Northern Mariana Islands</option>
            <option value='Norway'>Norway</option>
            <option value='Oman'>Oman</option>
            <option value='Pakistan'>Pakistan</option>
            <option value='Palau'>Palau</option>
            <option value='Palestinian Territory, Occupied'>Palestinian Territory, Occupied</option>
            <option value='Panama'>Panama</option>
            <option value='Papua New Guinea'>Papua New Guinea</option>
            <option value='Paraguay'>Paraguay</option>
            <option value='Peru'>Peru</option>
            <option value='Philippines'>Philippines</option>
            <option value='Pitcairn'>Pitcairn</option>
            <option value='Poland'>Poland</option>
            <option value='Portugal'>Portugal</option>
            <option value='Puerto Rico'>Puerto Rico</option>
            <option value='Qatar'>Qatar</option>
            <option value='Reunion'>Reunion</option>
            <option value='Romania'>Romania</option>
            <option value='Russian Federation'>Russian Federation</option>
            <option value='Rwanda'>Rwanda</option>
            <option value='Saint Helena'>Saint Helena</option>
            <option value='Saint Kitts and Nevis'>Saint Kitts and Nevis</option>
            <option value='Saint Lucia'>Saint Lucia</option>
            <option value='Saint Pierre and Miquelon'>Saint Pierre and Miquelon</option>
            <option value='Saint Vincent and The Grenadines'>Saint Vincent and The Grenadines</option>
            <option value='Samoa'>Samoa</option>
            <option value='San Marino'>San Marino</option>
            <option value='Sao Tome and Principe'>Sao Tome and Principe</option>
            <option value='Saudi Arabia'>Saudi Arabia</option>
            <option value='Senegal'>Senegal</option>
            <option value='Serbia and Montenegro'>Serbia and Montenegro</option>
            <option value='Seychelles'>Seychelles</option>
            <option value='Sierra Leone'>Sierra Leone</option>
            <option value='Singapore'>Singapore</option>
            <option value='Slovakia'>Slovakia</option>
            <option value='Slovenia'>Slovenia</option>
            <option value='Solomon Islands'>Solomon Islands</option>
            <option value='Somalia'>Somalia</option>
            <option value='South Africa'>South Africa</option>
            <option value='South Georgia and The South Sandwich Islands'>South Georgia and The South Sandwich Islands</option>
            <option value='Spain'>Spain</option>
            <option value='Sri Lanka'>Sri Lanka</option>
            <option value='Sudan'>Sudan</option>
            <option value='Suriname'>Suriname</option>
            <option value='Svalbard and Jan Mayen'>Svalbard and Jan Mayen</option>
            <option value='Swaziland'>Swaziland</option>
            <option value='Sweden'>Sweden</option>
            <option value='Switzerland'>Switzerland</option>
            <option value='Syrian Arab Republic'>Syrian Arab Republic</option>
            <option value='Taiwan, Province of China'>Taiwan, Province of China</option>
            <option value='Tajikistan'>Tajikistan</option>
            <option value='Tanzania, United Republic of'>Tanzania, United Republic of</option>
            <option value='Thailand'>Thailand</option>
            <option value='Timor-leste'>Timor-leste</option>
            <option value='Togo'>Togo</option>
            <option value='Tokelau'>Tokelau</option>
            <option value='Tonga'>Tonga</option>
            <option value='Trinidad and Tobago'>Trinidad and Tobago</option>
            <option value='Tunisia'>Tunisia</option>
            <option value='Turkey'>Turkey</option>
            <option value='Turkmenistan'>Turkmenistan</option>
            <option value='Turks and Caicos Islands'>Turks and Caicos Islands</option>
            <option value='Tuvalu'>Tuvalu</option>
            <option value='Uganda'>Uganda</option>
            <option value='Ukraine'>Ukraine</option>
            <option value='United Arab Emirates'>United Arab Emirates</option>
            <option value='United Kingdom'>United Kingdom</option>
            <option value='United States'>United States</option>
            <option value='United States Minor Outlying Islands'>United States Minor Outlying Islands</option>
            <option value='Uruguay'>Uruguay</option>
            <option value='Uzbekistan'>Uzbekistan</option>
            <option value='Vanuatu'>Vanuatu</option>
            <option value='Venezuela'>Venezuela</option>
            <option value='Viet Nam'>Viet Nam</option>
            <option value='Virgin Islands, British'>Virgin Islands, British</option>
            <option value='Virgin Islands, U.S.'>Virgin Islands, U.S.</option>
            <option value='Wallis and Futuna'>Wallis and Futuna</option>
            <option value='Western Sahara'>Western Sahara</option>
            <option value='Yemen'>Yemen</option>
            <option value='Zambia'>Zambia</option>
            <option value='Zimbabwe'>Zimbabwe</option>
            </select>
          </div>
          </div>
          <div class='form-group row'>
          <label for='streetname' style='text-align:right;' class='col-4 col-form-label'>Street name*</label>
          <div class='col-8'>
          <input id='streetname' name='streetname' placeholder='Street name' class='form-control'
           type='text' pattern='^[A-Za-z\s]+$' oninvalid='setCustomValidity('Only letters and spaces allowed.')' oninput='setCustomValidity('')'
           required value="; echo $street_name; echo ">
          </div>
          </div>
          <div class='form-group row'>
          <label for='streetnumber' style='text-align:right;' class='col-4 col-form-label'>Street number*</label>
          <div class='col-8'>
          <input id='streetnumber' name='streetnumber' placeholder='Street number' class='form-control'
           type='text' pattern='[a-zA-Z0-9-\s]+' oninvalid='setCustomValidity('Only letters, numbers, spaces and dashes allowed.')'
           oninput='setCustomValidity('')' required value="; echo $street_number; echo ">
          </div>
          </div>

          <!-- closing COL-8 -->
          </div>

          <div class='col-md-6'>
          <div class='form-group row'>
          <label for='zipcode' style='text-align:right;' class='col-4 col-form-label'>Zipcode*</label>
          <div class='col-8'>
          <input id='zipcode' name='zipcode' placeholder='Zipcode' class='form-control'
          type='text' pattern='^[a-zA-Z 0-9 ]*$' oninvalid='setCustomValidity('Only letters, numbers and spaces allowed.')'
          oninput='setCustomValidity('')' required value="; echo $zip_code; echo ">
          </div>
          </div>
          <div class='form-group row'>
          <label for='city' style='text-align:right;' class='col-4 col-form-label'>City*</label>
          <div class='col-8'>
          <input id='city' name='city' placeholder='City' class='form-control'
          type='text' pattern='^[A-Za-z\s]+$' oninvalid='setCustomValidity('Only letters and spaces allowed.')' oninput='setCustomValidity('')'
          required value="; echo $city; echo ">
          <div id='showInformationForPasswordDiv' style='text-align:center;'>
          	<div class='d-table-cell align-middle'>
          	<div id='length' class='glyphicon glyphicon-remove'>Must be at least 6 to 40 characters</div>
          <div id='upperCase' class='glyphicon glyphicon-remove'>Must have atleast 1 upper case character</div>
          <div id='lowerCase' class='glyphicon glyphicon-remove'>Must have atleast 1 lower case character</div>
          <div id='numbers' class='glyphicon glyphicon-remove'>Must have atleast 1 numeric character</div>
          <div id='symbols' class='glyphicon glyphicon-remove'>Must have atleast 1 special character</div>
          <div class='arrow-down'></div>
          </div>
          </div>
          </div>
          </div>
          <div class='form-group row'>
          <label for='date' style='text-align:right;' class='col-4 col-form-label'>Birth date</label>
          <div class='col-8'>
            <input id='date' type='text' name='date' data-date='' class='form-control' placeholder=''dd/mm/yyyy', 'dd-mm-yyyy' or 'dd.mm.yyyy''
          	pattern='(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d' oninvalid='setCustomValidity('This is not a valid date.')'
          	oninput='setCustomValidity('')' autocomplete='off' placeholder='Birth date' value="; echo $datez; echo " >
          </div>
          </div>
          <div class='form-group row'>
          <label for='phone' style='text-align:right;' class='col-4 col-form-label'>Phone number*</label>
          <div class='col-8'>
          <input type='text' id='phone' placeholder='Phone number' class='form-control' pattern='^[0-9 \\s-]+$' oninvalid='setCustomValidity('Only numbers, spaces and dashes.')'
             oninput='setCustomValidity('')' required value="; echo $phonenumber; echo " >
          </div>
          </div>
          <div class='form-group row'>
          <label for='second-email' style='text-align:right;' class='col-4 col-form-label'>Email*</label>
          <div class='col-8'>
          <input id='email' name='email' placeholder='Email' class='form-control'
          type='text' pattern='^[^(\.)][a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[aA-zZ]{2,5}' oninvalid='setCustomValidity('This is not a valid email.')'
          oninput='setCustomValidity('')' value="; echo $email; echo " disabled>
          </div>
          </div>
          <div class='form-group row'>
          <div class='offset-4 col-8'>
          <input type='hidden' name='token' id='token' />
          <button id='submitFinishAccountCheckout' type='submit' class='btn btn-block btn-primary'>Save changes</button>
          </div>
          </div>
          </form>
          </div>
          </div>
          </div>";

          echo "<div class='place-order-button' style='align-items: center;justify-content: center;margin-top:70px;display:none;'>
          <a style='padding:14px;' href='place_order.php?order=success' class='btn btn-success m-b-10px'>
          <i class='fas fa-shopping-cart'></i>&nbsp;&nbsp;Place order
          </a>
          </div>";
        } else {
          echo "<div class='place-order-button' style='align-items: center;justify-content: center;margin-top:70px;display:flex;'>
          <a style='padding:14px;' href='place_order.php?order=success' class='btn btn-success m-b-10px'>
          <i class='fas fa-shopping-cart'></i>&nbsp;&nbsp;Place order
          </a>
          </div>";
        }
      }


            if(!isset($_SESSION['user_id'])) {
            echo "<div id='informationDivCheckout'><i class='fas fa-info-circle' style='color:white;margin-top:-5px;font-size:23px;margin-left:16px;'></i><h4>Login to continue or else if your new enter your email adress</h4></div>";
          }




    if(!isset($_SESSION['user_id'])) {
        echo "<div class= 'col-md-4 loginFormCheckout' style='margin-bottom:50px;padding-left:0px;max-width:35%;margin-top:35px;display:inline-block;border-right:1px solid grey;padding-right:30px;'>
        <form method='post' id='loginFormCheckout' class='recaptcha_form'>
          <div class='message'></div>
          <div class='form-group'>
          <label><b>For existing users</b></label>
          <input type='text' id='loginEmail' class='form-control cardBodyInputFieldBeforeLogin' placeholder='Email address' />
          </div>
          <div class='form-group' style='margin-bottom:0px;'>
          <label>Password</label>
          </div>
          <div class='input-group' style='margin-bottom:1rem;'>
          <input id='loginPassword' type='password' class='form-control cardBodyInputFieldBeforeLogin pwd' placeholder='Password'
          pattern='((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})' oninvalid='setCustomValidity(\"This is not a valid password.\")'
          oninput='setCustomValidity('')' required />
          <span class='input-group-btn'>
            <button class='btn btn-default reveal' tabindex='-1' type='button'><i class='fas fa-eye change-eye'></i></button>
          </span>
          </div>
          <div class='form-group'>
          <input type='hidden' name='token' id='token' />
          <button id='loginSubmitButton' type='submit' name='login' class='btn btn-primary resizeButtonBeforeLogin loginSubmitButtonCheckout'>Login</button>
          <a style='margin-left:10px;' href='reset-password.php'>Forgot your password?</a>
          </div>

          </form>
        </div>";
        echo "<div class= 'col-md-4 registerFormCheckout' style='margin-bottom:50px;padding-left:30px;max-width:35%;margin-top:35px;display:inline-block;padding-right:30px;'>
        <form method='post' id='register_checkout_first_part' class='recaptcha_form'>
          <div style='visibility: hidden;top: -43px;width: 339px;position: absolute;' class='messageSecond secondMessageCheckout'></div>
          <label><b>For new users</b></label>
          <div class='form-group'>
          <input type='text' id='first-email' class='form-control cardBodyInputFieldBeforeLogin' placeholder='Email address'/>
          </div>
          <div style='height:26.5px;' class='form-group'>
          <label style='visibility:hidden;'>Password</label>
          <input style='visibility:hidden;' class='form-control cardBodyInputFieldBeforeLogin'/>
          </div>
          <div class='form-group'>
           <input type='hidden' name='token' id='tokenRegisterCheckout'/>
           <button id='submitEmailRegister' type='submit' class='btn btn-primary resizeButtonBeforeLogin'>Make new account</button>
          </div>

          </form>
        </div>

        <div class='container containerResize accountForRegister col-md-12 row' style='padding:25px;width:95%!important;margin-top:50px;margin-left:34px;display:none;margin-bottom:50px;border:1px solid grey;box-shadow: 0px 0px 17px 0px #c2c2c2;'>
        <div class='col-2'></div><div class='col-8'><div id='message2'></div></div>
        <div class='col-12' style='margin-bottom:30px;margin-top:10px;'><div class='col-2' style='text-align:right;'>* = required field</div></div>
        <div class='col-md-6'>
        <form method='post' id='register_checkout_second_part' class='recaptcha_form'>
        <div class='form-group row'>
        <label for='gender' style='text-align:right;' class='col-4 col-form-label'>Gender*</label>
        <div style='margin-top:6.5px;' class='col-8'>
        <input id='1' type='radio' name='gender' class='gender' value='Male' required/>  <label for='1'>Male</label>
        <input id='2' style='margin-left:20px;' type='radio' name='gender' class='gender'  value='Female' required/> <label for='2'>Female</label>
        </div>
        </div>
        <div class='form-group row'>
        <label for='name' style='text-align:right;' class='col-4 col-form-label'>First name*</label>
        <div class='col-8'>
        <input id='name' name='name' placeholder='First name' class='form-control'
        type='text' pattern='^[A-Za-z\s]+$' oninvalid='setCustomValidity('Only letters and spaces allowed.')' oninput='setCustomValidity('')' required/>
        </div>
        </div>
        <div class='form-group row'>
        <label for='lastname' style='text-align:right;' class='col-4 col-form-label'>Last name*</label>
        <div class='col-8'>
        <input id='lastname' name='lastname' placeholder='Last name' class='form-control'
        type='text' pattern='^[A-Za-z\s]+$' oninvalid='setCustomValidity('Only letters and spaces allowed.')' oninput='setCustomValidity('')' required/>
        </div>
        </div>
        <div class='form-group row'>
        <label for='country' style='text-align:right;' class='col-4 col-form-label'>Country*</label>
        <div class='col-8'>
          <select name='country' class='form-control countrySelect' data-show-subtext='true' data-live-search='true' data-live-search-placeholder='Search your country...' required/>
        	<option value='Select Country' selected=''>Select Country</option>
          <option value='United States'>United States</option>
          <option value='United Kingdom'>United Kingdom</option>
          <option value='Afghanistan'>Afghanistan</option>
          <option value='Albania'>Albania</option>
          <option value='Algeria'>Algeria</option>
          <option value='American Samoa'>American Samoa</option>
          <option value='Andorra'>Andorra</option>
          <option value='Angola'>Angola</option>
          <option value='Anguilla'>Anguilla</option>
          <option value='Antarctica'>Antarctica</option>
          <option value='Antigua and Barbuda'>Antigua and Barbuda</option>
          <option value='Argentina'>Argentina</option>
          <option value='Armenia'>Armenia</option>
          <option value='Aruba'>Aruba</option>
          <option value='Australia'>Australia</option>
          <option value='Austria'>Austria</option>
          <option value='Azerbaijan'>Azerbaijan</option>
          <option value='Bahamas'>Bahamas</option>
          <option value='Bahrain'>Bahrain</option>
          <option value='Bangladesh'>Bangladesh</option>
          <option value='Barbados'>Barbados</option>
          <option value='Belarus'>Belarus</option>
          <option value='Belgium'>Belgium</option>
          <option value='Belize'>Belize</option>
          <option value='Benin'>Benin</option>
          <option value='Bermuda'>Bermuda</option>
          <option value='Bhutan'>Bhutan</option>
          <option value='Bolivia'>Bolivia</option>
          <option value='Bosnia and Herzegovina'>Bosnia and Herzegovina</option>
          <option value='Botswana'>Botswana</option>
          <option value='Bouvet Island'>Bouvet Island</option>
          <option value='Brazil'>Brazil</option>
          <option value='British Indian Ocean Territory'>British Indian Ocean Territory</option>
          <option value='Brunei Darussalam'>Brunei Darussalam</option>
          <option value='Bulgaria'>Bulgaria</option>
          <option value='Burkina Faso'>Burkina Faso</option>
          <option value='Burundi'>Burundi</option>
          <option value='Cambodia'>Cambodia</option>
          <option value='Cameroon'>Cameroon</option>
          <option value='Canada'>Canada</option>
          <option value='Cape Verde'>Cape Verde</option>
          <option value='Cayman Islands'>Cayman Islands</option>
          <option value='Central African Republic'>Central African Republic</option>
          <option value='Chad'>Chad</option>
          <option value='Chile'>Chile</option>
          <option value='China'>China</option>
          <option value='Christmas Island'>Christmas Island</option>
          <option value='Cocos (Keeling) Islands'>Cocos (Keeling) Islands</option>
          <option value='Colombia'>Colombia</option>
          <option value='Comoros'>Comoros</option>
          <option value='Congo'>Congo</option>
          <option value='Congo, The Democratic Republic of The'>Congo, The Democratic Republic of The</option>
          <option value='Cook Islands'>Cook Islands</option>
          <option value='Costa Rica'>Costa Rica</option>
          <option value='Cote D'ivoire'>Cote D'ivoire</option>
          <option value='Croatia'>Croatia</option>
          <option value='Cuba'>Cuba</option>
          <option value='Cyprus'>Cyprus</option>
          <option value='Czech Republic'>Czech Republic</option>
          <option value='Denmark'>Denmark</option>
          <option value='Djibouti'>Djibouti</option>
          <option value='Dominica'>Dominica</option>
          <option value='Dominican Republic'>Dominican Republic</option>
          <option value='Ecuador'>Ecuador</option>
          <option value='Egypt'>Egypt</option>
          <option value='El Salvador'>El Salvador</option>
          <option value='Equatorial Guinea'>Equatorial Guinea</option>
          <option value='Eritrea'>Eritrea</option>
          <option value='Estonia'>Estonia</option>
          <option value='Ethiopia'>Ethiopia</option>
          <option value='Falkland Islands (Malvinas)'>Falkland Islands (Malvinas)</option>
          <option value='Faroe Islands'>Faroe Islands</option>
          <option value='Fiji'>Fiji</option>
          <option value='Finland'>Finland</option>
          <option value='France'>France</option>
          <option value='French Guiana'>French Guiana</option>
          <option value='French Polynesia'>French Polynesia</option>
          <option value='French Southern Territories'>French Southern Territories</option>
          <option value='Gabon'>Gabon</option>
          <option value='Gambia'>Gambia</option>
          <option value='Georgia'>Georgia</option>
          <option value='Germany'>Germany</option>
          <option value='Ghana'>Ghana</option>
          <option value='Gibraltar'>Gibraltar</option>
          <option value='Greece'>Greece</option>
          <option value='Greenland'>Greenland</option>
          <option value='Grenada'>Grenada</option>
          <option value='Guadeloupe'>Guadeloupe</option>
          <option value='Guam'>Guam</option>
          <option value='Guatemala'>Guatemala</option>
          <option value='Guinea'>Guinea</option>
          <option value='Guinea-bissau'>Guinea-bissau</option>
          <option value='Guyana'>Guyana</option>
          <option value='Haiti'>Haiti</option>
          <option value='Heard Island and Mcdonald Islands'>Heard Island and Mcdonald Islands</option>
          <option value='Holy See (Vatican City State)'>Holy See (Vatican City State)</option>
          <option value='Honduras'>Honduras</option>
          <option value='Hong Kong'>Hong Kong</option>
          <option value='Hungary'>Hungary</option>
          <option value='Iceland'>Iceland</option>
          <option value='India'>India</option>
          <option value='Indonesia'>Indonesia</option>
          <option value='Iran, Islamic Republic of'>Iran, Islamic Republic of</option>
          <option value='Iraq'>Iraq</option>
          <option value='Ireland'>Ireland</option>
          <option value='Israel'>Israel</option>
          <option value='Italy'>Italy</option>
          <option value='Jamaica'>Jamaica</option>
          <option value='Japan'>Japan</option>
          <option value='Jordan'>Jordan</option>
          <option value='Kazakhstan'>Kazakhstan</option>
          <option value='Kenya'>Kenya</option>
          <option value='Kiribati'>Kiribati</option>
          <option value='Korea, Democratic People's Republic of'>Korea, Democratic People's Republic of</option>
          <option value='Korea, Republic of'>Korea, Republic of</option>
          <option value='Kuwait'>Kuwait</option>
          <option value='Kyrgyzstan'>Kyrgyzstan</option>
          <option value='Lao People's Democratic Republic'>Lao People's Democratic Republic</option>
          <option value='Latvia'>Latvia</option>
          <option value='Lebanon'>Lebanon</option>
          <option value='Lesotho'>Lesotho</option>
          <option value='Liberia'>Liberia</option>
          <option value='Libyan Arab Jamahiriya'>Libyan Arab Jamahiriya</option>
          <option value='Liechtenstein'>Liechtenstein</option>
          <option value='Lithuania'>Lithuania</option>
          <option value='Luxembourg'>Luxembourg</option>
          <option value='Macao'>Macao</option>
          <option value='Macedonia, The Former Yugoslav Republic of'>Macedonia, The Former Yugoslav Republic of</option>
          <option value='Madagascar'>Madagascar</option>
          <option value='Malawi'>Malawi</option>
          <option value='Malaysia'>Malaysia</option>
          <option value='Maldives'>Maldives</option>
          <option value='Mali'>Mali</option>
          <option value='Malta'>Malta</option>
          <option value='Marshall Islands'>Marshall Islands</option>
          <option value='Martinique'>Martinique</option>
          <option value='Mauritania'>Mauritania</option>
          <option value='Mauritius'>Mauritius</option>
          <option value='Mayotte'>Mayotte</option>
          <option value='Mexico'>Mexico</option>
          <option value='Micronesia, Federated States of'>Micronesia, Federated States of</option>
          <option value='Moldova, Republic of'>Moldova, Republic of</option>
          <option value='Monaco'>Monaco</option>
          <option value='Mongolia'>Mongolia</option>
          <option value='Montserrat'>Montserrat</option>
          <option value='Morocco'>Morocco</option>
          <option value='Mozambique'>Mozambique</option>
          <option value='Myanmar'>Myanmar</option>
          <option value='Namibia'>Namibia</option>
          <option value='Nauru'>Nauru</option>
          <option value='Nepal'>Nepal</option>
          <option value='Netherlands'>Netherlands</option>
          <option value='Netherlands Antilles'>Netherlands Antilles</option>
          <option value='New Caledonia'>New Caledonia</option>
          <option value='New Zealand'>New Zealand</option>
          <option value='Nicaragua'>Nicaragua</option>
          <option value='Niger'>Niger</option>
          <option value='Nigeria'>Nigeria</option>
          <option value='Niue'>Niue</option>
          <option value='Norfolk Island'>Norfolk Island</option>
          <option value='Northern Mariana Islands'>Northern Mariana Islands</option>
          <option value='Norway'>Norway</option>
          <option value='Oman'>Oman</option>
          <option value='Pakistan'>Pakistan</option>
          <option value='Palau'>Palau</option>
          <option value='Palestinian Territory, Occupied'>Palestinian Territory, Occupied</option>
          <option value='Panama'>Panama</option>
          <option value='Papua New Guinea'>Papua New Guinea</option>
          <option value='Paraguay'>Paraguay</option>
          <option value='Peru'>Peru</option>
          <option value='Philippines'>Philippines</option>
          <option value='Pitcairn'>Pitcairn</option>
          <option value='Poland'>Poland</option>
          <option value='Portugal'>Portugal</option>
          <option value='Puerto Rico'>Puerto Rico</option>
          <option value='Qatar'>Qatar</option>
          <option value='Reunion'>Reunion</option>
          <option value='Romania'>Romania</option>
          <option value='Russian Federation'>Russian Federation</option>
          <option value='Rwanda'>Rwanda</option>
          <option value='Saint Helena'>Saint Helena</option>
          <option value='Saint Kitts and Nevis'>Saint Kitts and Nevis</option>
          <option value='Saint Lucia'>Saint Lucia</option>
          <option value='Saint Pierre and Miquelon'>Saint Pierre and Miquelon</option>
          <option value='Saint Vincent and The Grenadines'>Saint Vincent and The Grenadines</option>
          <option value='Samoa'>Samoa</option>
          <option value='San Marino'>San Marino</option>
          <option value='Sao Tome and Principe'>Sao Tome and Principe</option>
          <option value='Saudi Arabia'>Saudi Arabia</option>
          <option value='Senegal'>Senegal</option>
          <option value='Serbia and Montenegro'>Serbia and Montenegro</option>
          <option value='Seychelles'>Seychelles</option>
          <option value='Sierra Leone'>Sierra Leone</option>
          <option value='Singapore'>Singapore</option>
          <option value='Slovakia'>Slovakia</option>
          <option value='Slovenia'>Slovenia</option>
          <option value='Solomon Islands'>Solomon Islands</option>
          <option value='Somalia'>Somalia</option>
          <option value='South Africa'>South Africa</option>
          <option value='South Georgia and The South Sandwich Islands'>South Georgia and The South Sandwich Islands</option>
          <option value='Spain'>Spain</option>
          <option value='Sri Lanka'>Sri Lanka</option>
          <option value='Sudan'>Sudan</option>
          <option value='Suriname'>Suriname</option>
          <option value='Svalbard and Jan Mayen'>Svalbard and Jan Mayen</option>
          <option value='Swaziland'>Swaziland</option>
          <option value='Sweden'>Sweden</option>
          <option value='Switzerland'>Switzerland</option>
          <option value='Syrian Arab Republic'>Syrian Arab Republic</option>
          <option value='Taiwan, Province of China'>Taiwan, Province of China</option>
          <option value='Tajikistan'>Tajikistan</option>
          <option value='Tanzania, United Republic of'>Tanzania, United Republic of</option>
          <option value='Thailand'>Thailand</option>
          <option value='Timor-leste'>Timor-leste</option>
          <option value='Togo'>Togo</option>
          <option value='Tokelau'>Tokelau</option>
          <option value='Tonga'>Tonga</option>
          <option value='Trinidad and Tobago'>Trinidad and Tobago</option>
          <option value='Tunisia'>Tunisia</option>
          <option value='Turkey'>Turkey</option>
          <option value='Turkmenistan'>Turkmenistan</option>
          <option value='Turks and Caicos Islands'>Turks and Caicos Islands</option>
          <option value='Tuvalu'>Tuvalu</option>
          <option value='Uganda'>Uganda</option>
          <option value='Ukraine'>Ukraine</option>
          <option value='United Arab Emirates'>United Arab Emirates</option>
          <option value='United Kingdom'>United Kingdom</option>
          <option value='United States'>United States</option>
          <option value='United States Minor Outlying Islands'>United States Minor Outlying Islands</option>
          <option value='Uruguay'>Uruguay</option>
          <option value='Uzbekistan'>Uzbekistan</option>
          <option value='Vanuatu'>Vanuatu</option>
          <option value='Venezuela'>Venezuela</option>
          <option value='Viet Nam'>Viet Nam</option>
          <option value='Virgin Islands, British'>Virgin Islands, British</option>
          <option value='Virgin Islands, U.S.'>Virgin Islands, U.S.</option>
          <option value='Wallis and Futuna'>Wallis and Futuna</option>
          <option value='Western Sahara'>Western Sahara</option>
          <option value='Yemen'>Yemen</option>
          <option value='Zambia'>Zambia</option>
          <option value='Zimbabwe'>Zimbabwe</option>
          </select>
        </div>
        </div>
        <div class='form-group row'>
        <label for='streetname' style='text-align:right;' class='col-4 col-form-label'>Street name*</label>
        <div class='col-8'>
        <input id='streetname' name='streetname' placeholder='Street name' class='form-control'
         type='text' pattern='^[A-Za-z\s]+$' oninvalid='setCustomValidity('Only letters and spaces allowed.')' oninput='setCustomValidity('')' required/>
        </div>
        </div>
        <div class='form-group row'>
        <label for='streetnumber' style='text-align:right;' class='col-4 col-form-label'>Street number*</label>
        <div class='col-8'>
        <input id='streetnumber' name='streetnumber' placeholder='Street number' class='form-control'
         type='text' pattern='[a-zA-Z0-9-\s]+' oninvalid='setCustomValidity('Only letters, numbers, spaces and dashes allowed.')'  oninput='setCustomValidity('')' required/>
        </div>
        </div>

        <!-- closing COL-8 -->
        </div>

        <div class='col-md-6'>
        <div class='form-group row'>
        <label for='zipcode' style='text-align:right;' class='col-4 col-form-label'>Zipcode*</label>
        <div class='col-8'>
        <input id='zipcode' name='zipcode' placeholder='Zipcode' class='form-control'
        type='text' pattern='^[a-zA-Z 0-9 ]*$' oninvalid='setCustomValidity('Only letters, numbers and spaces allowed.')' oninput='setCustomValidity('')' required/>
        </div>
        </div>
        <div class='form-group row'>
        <label for='city' style='text-align:right;' class='col-4 col-form-label'>City*</label>
        <div class='col-8'>
        <input id='city' name='city' placeholder='City' class='form-control'
        type='text' pattern='^[A-Za-z\s]+$' oninvalid='setCustomValidity('Only letters and spaces allowed.')' oninput='setCustomValidity('')' required/>
        <div id='showInformationForPasswordDiv' style='text-align:center;'>
        	<div class='d-table-cell align-middle'>
        	<div id='length' class='glyphicon glyphicon-remove'>Must be at least 6 to 40 characters</div>
        <div id='upperCase' class='glyphicon glyphicon-remove'>Must have atleast 1 upper case character</div>
        <div id='lowerCase' class='glyphicon glyphicon-remove'>Must have atleast 1 lower case character</div>
        <div id='numbers' class='glyphicon glyphicon-remove'>Must have atleast 1 numeric character</div>
        <div id='symbols' class='glyphicon glyphicon-remove'>Must have atleast 1 special character</div>
        <div class='arrow-down'></div>
        </div>
        </div>
        </div>
        </div>
        <div class='form-group row'>
        <label for='date' style='text-align:right;' class='col-4 col-form-label'>Birth date</label>
        <div class='col-8'>
          <input id='date' type='text' name='date' data-date='' class='form-control' placeholder=''dd/mm/yyyy', 'dd-mm-yyyy' or 'dd.mm.yyyy''
        	pattern='(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d' oninvalid='setCustomValidity('This is not a valid date.')'
        	oninput='setCustomValidity('')' autocomplete='off' placeholder='Birth date' />
        </div>
        </div>
        <div class='form-group row'>
        <label for='phone' style='text-align:right;' class='col-4 col-form-label'>Phone number*</label>
        <div class='col-8'>
        <input type='text' id='phone' placeholder='Phone number' class='form-control' pattern='^[0-9 \\s-]+$' oninvalid='setCustomValidity('Only numbers, spaces and dashes.')'
           oninput='setCustomValidity('')' required/>
        </div>
        </div>
        <div class='form-group row'>
        <label for='second-email' style='text-align:right;' class='col-4 col-form-label'>Email*</label>
        <div class='col-8'>
        <input id='second-email' name='email' placeholder='Email' class='form-control'
        type='text' pattern='^[^(\.)][a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[aA-zZ]{2,5}' oninvalid='setCustomValidity('This is not a valid email.')'
        oninput='setCustomValidity('')' required/>
        </div>
        </div>
        <div class='form-group row'>
        <label for='passwordForRegistration' style='text-align:right;' class='col-4 col-form-label'>Password*</label>
        <div class='col-8'>
        <input id='passwordForRegistration' name='new_password' placeholder='Password' class='form-control' type='password'
        pattern='((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})' oninvalid='setCustomValidity('This is not a valid password.')' oninput='setCustomValidity('')'
        required/>
        </div>
        </div>
        <div class='form-group row'>
        <div class='offset-4 col-8'>
        <input type='hidden' name='token' id='token' />
        <button id='submitAccountRegister' type='submit' class='btn btn-block btn-primary' name='submit_register_account'>Make new account</button>
        </div>
        </div>
        </form>
        </div>
        </div>

        <div class='place-order-button' style='align-items: center;justify-content: center;margin-top:70px;display:none;'>
        <a style='padding:14px;' href='place_order.php?order=success' class='btn btn-success m-b-10px'>
        <i class='fas fa-shopping-cart'></i>&nbsp;&nbsp;Place order
        </a>
        </div>

        <div id='registerSpamMessage' class='modal' tabindex='-1' role='dialog'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
        <div class='modal-header'>
        	<h5 class='modal-title text-center col-12'>Information
        	<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        		<span aria-hidden='true'>&times;</span>
        	</button>
        	</h5>
        </div>
        <div class='modal-body text-center'>
        <p class='text-success' style='font-size:1.1rem;'>You are successfully registered <span style='text-decoration:underline;'>and logged in.</span> You received an email. It could be possible this email will come inside your <span style='text-decoration:underline;'>spam-box.</span></p>
        </div>
        <div class='modal-footer'>
          <button id='modal-button' type='button' class='btn btn-primary hideModalCloseButton' data-dismiss='modal'>Close</button>
        </div>
        </div>
        </div>
        </div>

        ";
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
