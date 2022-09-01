<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];

include('config/database_connection.php');

	$ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address

	$query5 = "INSERT INTO `ip` (`address` ,`timestamp`)VALUES (:ip,CURRENT_TIMESTAMP)";
				 $stmt5 = $connect->prepare($query5);
				 $stmt5->bindParam(':ip', $ip);
				 $stmt5->execute();

				 $lastid = $connect->lastInsertID();

				 function findIp() {
					 include('config/database_connection.php');

					 $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address
					 $query6 = "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE ? AND `timestamp` > (now() - interval 10 minute)";
					 $stmt6 = $connect->prepare($query6);
					 $stmt6->bindParam(1, $ip);
					 $stmt6->execute();
					 $count6 = $stmt6->fetchColumn();

					 return $count6;
				 }

         if(empty($_POST["user_email"]) || empty($_POST['user_password'])) {
           array_push($errors, "");
           $output = json_encode(array('type' => 'error', 'text' => "Email and password are required fields"));
           die($output);
         }

         if(strlen($_POST["user_email"]) > 250) {
           array_push($errors, "");
           $output = json_encode(array('type' => 'error', 'text' => "For Email is a max of 250 characters allowed"));
           die($output);
         }

         if(strlen($_POST["user_password"]) > 40) {
           array_push($errors, "");
           $output = json_encode(array('type' => 'error', 'text' => "For Password is a max of 40 characters allowed"));
           die($output);
         }

         // Validate email
         if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})$/i', $_POST["user_email"])) {
           array_push($errors, "");
           $output = json_encode(array('type' => 'error', 'text' => "This is not a valid email address"));
           die($output);
         }

         // Validate password strength
         if(!preg_match('@[A-Z]@', $_POST["user_password"]) || !preg_match('@[a-z]@', $_POST["user_password"]) || !preg_match('@[0-9]@', $_POST["user_password"])
         || !preg_match('/[^a-zA-Z\d]/', $_POST["user_password"]) || strlen($_POST["user_password"]) < 6) {
           array_push($errors, "");
           $output = json_encode(array('type' => 'error', 'text' => "This is not a valid password"));
           die($output);
         }

if (count($errors) == 0) {

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
	$no_of_row = $statement->rowCount();

	if($no_of_row > 0)
	{


		$result = $statement->fetchAll();
		foreach($result as $row)
		{

				// if counter is not set, set to zero
				if(!isset($_SESSION['counter'])) {
						$_SESSION['counter'] = 0;
				}

				// if button is pressed, increment counter
				if(isset($_POST["login"])) {
					// echo "<br><br><br>";
					++$_SESSION['counter'];
				}

				if(findIp() >= 3) {

					$response = $_POST['token'];

					// get cURL resource
					$ch = curl_init();

					// set url
					curl_setopt($ch, CURLOPT_URL, 'https://www.recaptcha.net/recaptcha/api/siteverify');

					// set method
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

					// return the transfer as a string
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

					// set headers
					curl_setopt($ch, CURLOPT_HTTPHEADER, [
					  'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
					]);

					// form body
					$body = [
					  'secret' => '----PASSWORD----',
					  'response' => $response,
					];
					$body = http_build_query($body);

					// set body
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

					// send the request and save response to $response
					$response = curl_exec($ch);

					$captchaResponse = json_decode($response, true);

					if ($captchaResponse['success'] == '1' && $captchaResponse['score'] >= 0.5) {

				if($_SESSION['counter'] === 5) {

					// generate a unique random token of length 100
					$token = bin2hex(random_bytes(50));

					$email = $row['user_email'];

						// store token in the password-reset database table against the user's email
					$query2 = "INSERT INTO password_resets(email, token) VALUES (:user_email, :token)";

					$statement2 = $connect->prepare($query2);
					$statement2->execute(array(
					':user_email' => $email,
					':token' => $token
					));

						/* Catch firstname for $mail_body */
						$query3 = "SELECT user_firstname FROM register_user WHERE user_email=:user_email";
						$statement3 = $connect->prepare($query3);
						$statement3->bindValue(':user_email', $email);
						$success3 = $statement3->execute();
						$row = $statement3->fetch();

						$firstname = $row['user_firstname'];

						// Load Composer's autoloader
						require 'vendor/autoload.php';
						require 'vendor/phpmailer/phpmailer/src/Exception.php';
						require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
						require 'vendor/phpmailer/phpmailer/src/SMTP.php';

							/* Here begins mail function*/
							$base_url = "https://gester.nl/webshop/";  //change this baseurl value as per your file path
							$mail_body = '

              <!DOCTYPE html>
              <html>
              <head>
                <title>Gesters Webshop</title>
                <style type="text/css">
                  /* RESET STYLES */

                  body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica,Arial,sans-serif;}
                  table{border-collapse:collapse;}
                  table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
                  h1, h2, h3, h4, h5, h6{color:#000000; font-weight:normal; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}

                  /* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */

                  .emailButton{background-color:#fde45c;width:258px;margin-left:90px;}
                  .buttonContent{color:#FFFFFF;line-height:100%;padding:10px;text-align:center;}
                  .buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}

                  /* Queries for mobile */
                    @media only screen and (max-width: 600px) {

                      u + .body .buttonContent {
                         padding:10px!important;
                        }

                     u + .body .buttonContent a{
                      font-size:15px!important;
                     }

                     u + .body #fontSizeHeader{
                      font-size:25px!important;
                     }

                     u + .body #fontSizeFooterHeader{
                      font-size:21.5px!important;
                     }

                     u + .body .fontSizeFooterBody{
                      font-size:15.5px!important;
                     }

                     u + .body .dearFirstname {
                       font-size:20px!important;
                     }

                     u + .body .unusualActivityInYourAccount {
                       font-size:18px!important;
                     }


                      .emailButton {
                        margin-left:0px!important;
                        width:100%!important;
                      }
                      .marginBottom {
                        margin-bottom:0px!important;
                      }
                      .marginTop {
                        margin-top:25px!important;
                      }
                      .marginBottomEnding {
                        margin-bottom:10px!important;
                      }
                      .marginTopZero {
                        margin-top:0px!important;
                      }

                      .buttonContent a{font-size:16.5px!important;}
                      #fontSizeHeader {font-size:28px!important;}
                      #fontSizeFooterHeader {font-size:22.5px!important;}
                      .fontSizeFooterBody {font-size:15.5px!important;}
                      #footerBodyTable {margin-top:10px!important;margin-bottom:20px!important;}
                      .buttonContent{padding:10px!important;}
                      .dearFirstname {font-size:20.5px!important;}
                      .unusualActivityInYourAccount {line-height:140%!important;font-size:18.5px!important;}
                      .contactAndService {margin-bottom:10px!important;}
                      .paddingLeftRight {padding-left:30px!important;padding-right:30px!important;}
                      .lineHeightFooter {line-height:170%!important;}
                      .removePaddingContent {padding:0px!important;}
                      .spacesBetweenDivs {height:40px!important;}
                      .hideThumbsUpImage {display:none!important;}
                      .showTumbsUpImageMobile {display:block!important;}
                      .insideBodyWidth {width:100%!important;}
                    }
                </style>
              </head>

              <body class="body">
              <center style="background-color:#FFFFFF;">
                <table border="0" cellpadding="0" cellspacing="0" height="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
                  <tr>
                    <td align="center" id="bodyCell">

                        <table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="100%" id="emailBody">

                          <tr>
                            <td align="center">

                              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#71aee8">
                                <tr>
                                  <td align="center">

                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="flexibleContainer">
                                      <tr>
                                        <td align="center" width="100%" class="flexibleContainerCell">

                                          <table border="0" cellpadding="18" cellspacing="0" width="100%">
                                            <tr>
                                              <td align="center" class="textContent">
                                                <b id="fontSizeHeader" style="color:#FFFFFF;line-height:100%;font-size:24px;font-weight:bold;text-align:center;">Gesters Webshop</b>
                                              </td>
                                            </tr>
                                          </table>
                                          <!-- // CONTENT TABLE -->
                                        </td>
                                      </tr>
                                    </table>
                                    <!-- // FLEXIBLE CONTAINER -->
                                  </td>
                                </tr>
                              </table>
                              <!-- // CENTERING TABLE -->
                            </td>
                          </tr>
                          <tr>
                            <td align="center">
                              <!-- CENTERING TABLE // -->
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFF">
                                <tr>
                                  <td align="center">
                                    <!-- FLEXIBLE CONTAINER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="flexibleContainer">
                                      <tr>
                                        <td align="center" width="100%" class="flexibleContainerCell">
                                          <table border="0" cellpadding="35" cellspacing="0" width="100%">
                                            <tr>
                                              <td align="center" class="removePaddingContent">
                                                <!-- CONTENT TABLE // -->
                                                <table class="insideBodyWidth" border="0" cellpadding="0" cellspacing="0" width="94%">

                                                  <tr>
                                                    <td class="textContent">
                                                      <div mc:edit="body" style="text-align:left;font-size:14px;margin-bottom:0;line-height:135%;">
                                                      <table border="0" cellpadding="0" width="100%">
                                                      <tr class="spacesBetweenDivs" style="line-height:0px;height:0px;margin:0;padding:0;"><td style="line-height:0px;height:0px;margin:0;padding:0;"></td></tr>
                                                      </table>

                                                <table border="0" cellpadding="35" width="100%">
                                                <tr style="background:#fff4ba;">
                                                  <td style="width:100%;padding:1rem 2rem 2rem 2rem;">
                                              <p class="dearFirstname" style="font-size:21px;color:#000000;font-weight:bold;">Dear '.$firstname.',</p>
                                              <p class="unusualActivityInYourAccount" style="font-size:19px;margin-top:10px;line-height:140%;color:#000000;">There has been unusual activity in your account at <b>'.$_SESSION['date'].'</b>, a user entered the wrong password 5 times with your email address. If you are <b>not</b> the one, you can click the button below to change your password.</p>
                                            <table border="0" cellpadding="0" cellspacing="0" class="emailButton" style="background-color:#fde45c;width:358px;margin-left:90px;">
                                              <tr>
                                                <td align="center" class="buttonContent">
                                                  <a style="font-size:15px;text-decoration:none!important;text-decoration:none;text-underline:none;line-height:135%;" href="'.$base_url.'new-pass.php?token='.$token.'"><font color="#000000">Change</font></a>
                                                </td>
                                              </tr>
                                            </table>
                                            </td>
                                          </tr>
                                          </table>
                                          <table border="0" cellpadding="0" width="100%">
                                          <tr class="spacesBetweenDivs" style="line-height:0px;height:0px;margin:0;padding:0;"><td style="line-height:0px;height:0px;margin:0;padding:0;"></td></tr>
                                          </table>
                                                    </div>
                                                    </td>
                                                  </tr>
                                                </table>
                                                <!-- // CONTENT TABLE -->
                                              </td>
                                            </tr>
                                          </table>
                                        </td>
                                      </tr>
                                    </table>
                                    <!-- // FLEXIBLE CONTAINER -->
                                  </td>
                                </tr>
                              </table>
                              <!-- // CENTERING TABLE -->
                            </td>
                          </tr>

                          <tr>
                            <td align="center">

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#71aee8">
                              <tr>
                                <td align="center">

                                  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="flexibleContainer">
                                    <tr>
                                      <td align="center" width="100%" class="flexibleContainerCell">

                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:0px;">
                                          <tr>
                                            <td align="center" class="textContent">
                                              <h2 id="fontSizeFooterHeader" class="marginBottom marginTop contactAndService" style="color:#205478;line-height:100%;font-size:20.5px;font-weight:bold;margin-bottom:0px;margin-top:15px;text-align:center;">Contact & Service</h2>
                                            </td>
                                          </tr>
                                        </table>
                                        <table id="footerBodyTable" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:0px;margin-bottom:0px;">
                                        <tr>
                                          <td style="padding-bottom:15px;" class="paddingLeftRight">
                                          <p class="fontSizeFooterBody marginBottom marginTopZero lineHeightFooter" style="color:#FFFFFF;line-height:135%;font-size:15.5px;font-weight:normal;margin-bottom:0px;margin-top:15px;text-align:center;"><b>Openinghours:</b> ma t/m vr: <a style="text-decoration:underline;color:#FFFFFF;"> 8:30 - 17:00 uur</a>, zaterdag: <a style="text-decoration:underline;color:#FFFFFF;"> 10:00 - 16:00 uur</a></p>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td style="padding-bottom:0px;" class="paddingLeftRight">
                                              <p class="fontSizeFooterBody marginBottom lineHeightFooter" style="color:#FFFFFF;line-height:135%;font-size:15.5px;font-weight:normal;margin-bottom:0px;text-align:center;margin-top:0px;"><b>Contact us at this number:</b> <a href="tel:0761218912" style="text-decoration:underline;border:none;color:#205478;font-weight:500;">076 121 8912</a></p>
                                          </td>
                                        </tr>
                                          <tr>
                                            <td>
                                            <p class="fontSizeFooterBody marginBottomEnding paddingLeftRight lineHeightFooter" style="color:#FFFFFF;line-height:135%;font-size:15.5px;padding-left:20px;padding-right:20px;font-weight:normal;margin-bottom:15px;text-align:center;margin-top:15px;"><b>To file a complaint:</b> <a href="tel:0761598133" style="text-decoration:underline;border:none;color:#205478;font-weight:500;">076 159 8133</a></p>
                                            </td>
                                            </tr>
                                        </table>
                                        <!-- // CONTENT TABLE -->

                                      </td>
                                    </tr>
                                  </table>
                                  <!-- // FLEXIBLE CONTAINER -->
                                </td>
                              </tr>
                            </table>
                              <!-- // CENTERING TABLE -->
                            </td>
                          </tr>
                          <!-- // MODULE ROW -->
                        </table>
                        </td>
                        </tr>
                      </table>
                    </center>
                    </body>
                    </html>

							';

							$mail = new PHPMailer(true);
										//Server settings
							$mail->SMTPDebug = 0;                                       // Enable verbose debug output
							$mail->isSMTP();                                            // Set mailer to use SMTP
              $mail->Host       = 'mail.argewebhosting.nl';  // Specify main and backup SMTP servers
              $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
              $mail->Username   = 'gesternl@gester.nl';                     // SMTP username
              $mail->Password   = 'i6BFhz#xVvGPVYS#';                               // SMTP password
              $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
              $mail->Port       = 587;                                    // TCP port to connect to

							$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						)
						);

							//Recipients
							$mail->setFrom('gesternl@gester.nl', "Gesters Webshop");
							$mail->addAddress($email, $firstname);     // Add a recipient
							//$mail->addAddress('ellen@example.com');               // Name is optional
							// $mail->addReplyTo('gester@gester.nl', "Gesters Webshop");
							//$mail->addCC('cc@example.com');
							//$mail->addBCC('bcc@example.com');

							// Attachments
							//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
							//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

							// Content
							$mail->isHTML(true);                                  // Set email format to HTML
							$mail->Subject = "Detecting suspicious activity on your account!";
							$mail->Body    = $mail_body;
							//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

							if($mail->send())								//Send an Email. Return true on success or false on error
							{
								$_SESSION['counter'] = 0;
							}
					}
				}  else {

					$_SESSION['counter'] = $_SESSION['counter'] - 1;

					// delete last entry
					$delete = $connect->prepare("DELETE FROM `ip` WHERE id = :id LIMIT 1");
					$delete->execute(array(':id' => $lastid));

					$output = json_encode(array('type' => 'error', 'text' => "Robot verification failed. ".$response));
					die($output);

			    }
			    // close curl resource to free up system resources
			    curl_close($ch);
			  // echo $response;
			}

					if(password_verify($_POST["user_password"], $row["user_password"]))
					//if($row["user_password"] == $_POST["user_password"])
					{

						if(findIp() > 5)
						{
               $output = json_encode(array('type' => 'error', 'text' => "aThis email doesn't exist. Enter your correct email address. <br> 5 attempts are allowed to log in within 10 minutes. <br> Login attempts are <b> ".findIp()." </b> times. Try again in 10 minutes."));
               die($output);
						} else {

							$_SESSION['counter'] = 0;

							$query9 = "DELETE FROM ip WHERE address=:ip;";
							$statement9 = $connect->prepare($query9);
							$statement9->execute(array(
							':ip' => $ip
							));

						$_SESSION['user_id'] = $row['register_user_id'];

						$sqlz = "
						SELECT user_firstname,user_lastname, user_streetname,user_streetnumber,user_zipcode,user_city,user_gender FROM register_user
						WHERE register_user_id= :id";

						$statementz = $connect->prepare($sqlz);
						$statementz->bindValue(':id', $_SESSION["user_id"]);
						$success = $statementz->execute();
						$rowz = $statementz->fetchAll(PDO::FETCH_ASSOC);

						$arrayz = array();
						foreach ($rowz as $row) {
						    $arrayz[] = $row['user_firstname'];
						    $arrayz[] = $row['user_lastname'];
						    $arrayz[] = $row['user_streetname'];
						    $arrayz[] = $row['user_streetnumber'];
						    $arrayz[] = $row['user_zipcode'];
						    $arrayz[] = $row['user_city'];
								$arrayz[] = $row['user_gender'];
						}

						$first_name = $arrayz[0];
						$last_name = $arrayz[1];
						$street_name = $arrayz[2];
						$street_number = $arrayz[3];
						$zip_code = $arrayz[4];
						$city = $arrayz[5];
						$gender = $arrayz[6];

						$query10 = "
						SELECT * FROM password_resets
							WHERE email = :email
						";
						$statement10 = $connect->prepare($query10);
						$statement10->execute(
							array(
									':email'	=>	$row['user_email']
								)
						);

						$no_of_row = $statement10->rowCount();

						if($no_of_row > 0)
						{
						$query11 = "DELETE FROM password_resets WHERE email=:email;";
						$statement11 = $connect->prepare($query11);
						$statement11->execute(array(
						':email' => $row["user_email"]
						));
					}

					if(count($_SESSION['cart'])>0){

									$query12 = "SELECT register_user_id FROM user_carts WHERE register_user_id=:id";
									$statement12 = $connect->prepare($query12);
									$statement12->execute(array(
									':id' => $_SESSION['user_id']
									));

									$no_of_row = $statement12->rowCount();

									if($no_of_row > 0) {

									$query13 = "DELETE FROM user_carts WHERE register_user_id=:id;";
									$statement13 = $connect->prepare($query13);
									$statement13->execute(array(
									':id' => $_SESSION['user_id']
									));
								}

								$serialized_cart = serialize($_SESSION["cart"]);

								$query14 = "INSERT INTO user_carts (register_user_id,cart_contents) VALUES
								(:register_user_id,:serialized_cart)";

								$statement14 = $connect->prepare($query14);
								$statement14->execute(array(
								':register_user_id' => $_SESSION['user_id'],
								':serialized_cart' => $serialized_cart
									));
							}

							/* Catch firstname */
							$query3 = "SELECT user_firstname FROM register_user WHERE register_user_id=:user_id";
							$statement3 = $connect->prepare($query3);
							$statement3->bindValue(':user_id', $_SESSION['user_id']);
							$success3 = $statement3->execute();
							$row = $statement3->fetch();

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

							//Remove empty ID(key) in array
								 $array = $_SESSION['cart'];

								 foreach($array as $key=>$value)
								 {
								     if(is_null($value) || $key == "")
								         unset($array[$key]);
								 }

								 $cart_total_item_count = array_sum( array_column($array, 'quantity' ));

							$output = json_encode(array('type' => 'success', 'text' => $first_name."||".$cart_total_item_count."||".$last_name."||".$street_name."||".$street_number."||".$zip_code."||".$city."||".$gender));

              die($output);
						}
					}
					else
					{
            if(findIp() == 1)
            {
            $output = json_encode(array('type' => 'error', 'text' => "mWrong password entered"));
            die($output);
          }

						if(findIp() > 1 && findIp() < 5)
						{
               $output = json_encode(array('type' => 'error', 'text' => "nWrong password entered. <br> 5 attempts are allowed to login within 10 minutes. <br> Login attempts are <b> ".findIp()." </b> times."));
               die($output);
						}
						if(findIp() > 4)
							{
                 $output = json_encode(array('type' => 'error', 'text' => "bWrong password entered. <br> 5 attempts are allowed to log in within 10 minutes. <br>Login attempts are <b>".findIp()."</b> times. Try again in 10 minutes."));
                 die($output);
							}
					}
			}
		}
		else
		{

      if(findIp() == 1)
      {
      $output = json_encode(array('type' => 'error', 'text' => "cThis email doesn't exist. Enter your correct email address"));
      die($output);
    }
			if(findIp() > 1 && findIp() < 5)
			{
        $output = json_encode(array('type' => 'error', 'text' => "xThis email doesn't exist. Enter your correct email address.<br> 5 attempts are allowed to login within 10 minutes. <br> Login attempts are <b>".findIp()."</b> times."));
        die($output);
			}
			if(findIp() > 4)
				{
          $output = json_encode(array('type' => 'error', 'text' => "zThis email doesn't exist. Enter your correct email address.<br> 5 attempts are allowed to log in within 10 minutes. <br> Login attempts are <b> ".findIp()." </b> times. Try again in 10 minutes."));
          die($output);
				}
	}
}
?>
