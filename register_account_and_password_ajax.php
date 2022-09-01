<?php
session_start();

$errors = [];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('config/database_connection.php');

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

    $email = $_POST['email'];

			$query = "
			SELECT * FROM register_user
			WHERE user_email = :user_email
			";
			$stmt = $connect->prepare($query);
			$stmt->execute(
				array(
					':user_email'	=>	$email
				)
			);
			$no_of_row = $stmt->rowCount();

			if($no_of_row > 0)
			{
        $output = json_encode(array('type' => 'error', 'text' => "This Email already exists"));
        die($output);
			}
			else {

                  //See if gender is chosen
                  if (!isset($_POST['gender']))  {
                    array_push($errors, "");
                    $output = json_encode(array('type' => 'error', 'text' => "Choose your gender please"));
                    die($output);
                  }

									//see if country is chosen
									if($_POST["country"] == 'Select Country'){
										array_push($errors, "");
										$output = json_encode(array('type' => 'error', 'text' => "Choose your country please"));
										die($output);
									}

									if (empty($_POST['name']) || empty($_POST['lastname']) || empty($_POST['streetname']) || empty($_POST['streetnumber'])
											|| empty($_POST['zipcode']) || empty($_POST['city']) || empty($_POST['phone']) || empty($email) ||
											empty($_POST['new_password'])) {
												array_push($errors, "");
												$output = json_encode(array('type' => 'error', 'text' => "All fields are required to fill in except your Birth date"));
												die($output);
									}

									if ( strlen($_POST['name']) > 40 || strlen($_POST['lastname']) > 40 || strlen($_POST['streetname']) > 40 || strlen($_POST['city']) > 40 ||
											 strlen($_POST['new_password'] ) > 40) {
												array_push($errors, "");
												$output = json_encode(array('type' => 'error', 'text' => "For fields: Firstname, Lastname, Streetname, City and Password are a max of 40 characters allowed"));
												die($output);
											}

											if(strlen($_POST['streetnumber']) > 15) {
												array_push($errors, "");
												$output = json_encode(array('type' => 'error', 'text' => "For field Streetnumber is a max of 15 characters allowed"));
												die($output);
											}

											if(strlen($_POST['zipcode']) > 7) {
												array_push($errors, "");
												$output = json_encode(array('type' => 'error', 'text' => "For field Zipcode is a max of 7 characters allowed"));
												die($output);
											}

											if(strlen($_POST['phone']) > 20) {
												array_push($errors, "");
												$output = json_encode(array('type' => 'error', 'text' => "For field Phonenumber is a max of 20 characters allowed"));
												die($output);
											}
											if(strlen($email) > 250) {
												array_push($errors, "");
												$output = json_encode(array('type' => 'error', 'text' => "For field Email is a max of 250 characters allowed"));
												die($output);
											}

											if($_POST['date'] && strlen($_POST['date']) > 10) {
												array_push($errors, "");
												$output = json_encode(array('type' => 'error', 'text' => "For field Birthdate is a max of 10 characters allowed"));
												die($output);
											}


                  // Allow only letters and spaces function for the below input fields
                  function validate_inputs($input) {
                      return preg_match('/^[\p{L} ]+$/u', $input);
                  }
                  if (!validate_inputs($_POST['name']) || !validate_inputs($_POST['lastname']) || !validate_inputs($_POST['streetname']) || !validate_inputs($_POST['city'])) {
                    array_push($errors, "");
                    $output = json_encode(array('type' => 'error', 'text' => "For fields: Firstname, Lastname, Streetname and City are only letters and spaces allowed"));
                    die($output);
                  }

                  //Streetnumber validation see below
                  if(!preg_match('/^[A-Za-z0-9- ]+$/', $_POST['streetnumber'])) {
                    array_push($errors, "");
                    $output = json_encode(array('type' => 'error', 'text' => "This is not a valid streetnumber. Only letters, numbers, spaces and dashes allowed"));
                    die($output);
                  }

                  // Validate zipcode see below
                  if(!preg_match('/^[a-z0-9 ]+$/i', $_POST['zipcode'])) {
                    array_push($errors, "");
                    $output = json_encode(array('type' => 'error', 'text' => "This is not a valid zipcode. Only letters, numbers and spaces allowed"));
                    die($output);
                  }

                  // Validate date input see below
                  if(!preg_match('~^(?:0?[1-9]|[12][0-9]|3[01])([- /.])(?:0?[1-9]|1[012])\1(?:19|20)\d{2}$~', $_POST['date']) && $_POST['date']) {
                    array_push($errors, "");
                    $output = json_encode(array('type' => 'error', 'text' => '"dd/mm/yyyy", "dd-mm-yyyy", "dd.mm.yyyy" format and years within "1900" and "2000" are allowed'));
                    die($output);
                  }

                  //validate phone number see below
                  if(!preg_match('/^[0-9-\s]+$/D', $_POST['phone'])) {
                    array_push($errors, "");
                    $output = json_encode(array('type' => 'error', 'text' => "This is not a valid phonenumber. Only numbers, spaces and dashes allowed"));
                    die($output);
                  }

                  // Validate email
                  if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})$/i', $email)) {
                    array_push($errors, "");
                    $output = json_encode(array('type' => 'error', 'text' => "This is not a valid email address"));
                    die($output);
                  }

                  // Validate password strength
                  if(!preg_match('@[A-Z]@', $_POST['new_password']) || !preg_match('@[a-z]@', $_POST['new_password']) || !preg_match('@[0-9]@', $_POST['new_password'])
                  || !preg_match('/[^a-zA-Z\d]/', $_POST['new_password']) || strlen($_POST['new_password']) < 6) {
                    array_push($errors, "");
                    $output = json_encode(array('type' => 'error', 'text' => "Password is not a valid password. See the information box when you click inside the Password field"));
                    die($output);
                  }


				if (count($errors) == 0) {

        $user_encrypted_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        $insert_query = "
        INSERT INTO register_user (user_email, user_password,user_phonenumber,user_date,user_gender, user_country, user_firstname,
        user_lastname, user_streetname,user_streetnumber,user_zipcode,user_city)
        VALUES (:user_email, :user_password,:user_phonenumber,:user_date,:user_gender,:user_country,:user_firstname,:user_lastname,
        :user_streetname,:user_streetnumber,:user_zipcode,:user_city)
        ";
        $stmt = $connect->prepare($insert_query);
        $stmt->execute(
          array(
            ':user_gender' => $_POST['gender'],
            ':user_firstname' => $_POST['name'],
            ':user_lastname' => $_POST['lastname'],
            ':user_country' => $_POST['country'],
            ':user_streetname' => $_POST['streetname'],
            ':user_streetnumber' => $_POST['streetnumber'],
            ':user_zipcode' => $_POST['zipcode'],
            ':user_city' => $_POST['city'],
            ':user_date' => $_POST['date'],
            ':user_phonenumber' => $_POST['phone'],
            ':user_email'			=>	$email,
            ':user_password'		=>	$user_encrypted_password,
          )
        );
        $result = $stmt->fetchAll();

        if(isset($result))
        {

        // Load Composer's autoloader
        require 'vendor/autoload.php';
        require 'vendor/phpmailer/phpmailer/src/Exception.php';
        require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/src/SMTP.php';

        $firstname = $_POST['name'];

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
					          font-size:23px!important;
					        }

					        u + .body .welcomeAt {
					          font-size:21px!important;
					        }

					        u + .body .whatIfForgotPassword{
					         font-size:18.5px!important;
					        }

					        u + .body .clickOnResetButtonText{
					         font-size:16.5px!important;
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

					         .buttonContent a{font-size:16px!important;}
					         #fontSizeHeader {font-size:28px!important;}
					         #fontSizeFooterHeader {font-size:22.5px!important;}
					         .fontSizeFooterBody {font-size:15.5px!important;}
					         #footerBodyTable {margin-top:10px!important;margin-bottom:20px!important;}
					         .buttonContent{padding:10px!important;}
					         .dearFirstname {font-size:23.5px!important;}
					         .welcomeAt {line-height:140%!important;font-size:21.5px!important;}
					         .whatIfForgotPassword {font-size:19.5px!important;}
					         .clickOnResetButtonText {font-size:16.5px!important;}
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
					                                             <td>
					                                         <b class="dearFirstname" style="font-size:25px;color:#000000;">Dear '.$firstname.'<b>,</b></b>
					                                         <p class="welcomeAt" style="font-size:23px;margin-top:10px;line-height:140%;color:#000000;">Welcome at <a href="https://gester.nl/webshop" style="color:#549bde;">gester.nl/webshop</a>! You have made your own account. We are happy that you registered at our website. You can visit our website and login with your credentials.</p>
					                                         <div class="showTumbsUpImageMobile" style="text-align:center;display:none;padding-top:.5rem;">
					                                         <img src="https://gester.nl/webshop/images/thumb-up-yellow.png" width="160">
					                                       </div>
					                                       </td>
					                                       <td class="hideThumbsUpImage" style="text-align:center;padding:2rem 2rem 2rem 1.5rem;">
					                                         <img src="https://gester.nl/webshop/images/thumb-up-yellow.png" width="160">
					                                       </td>
					                                     </tr>
					                                   </table>
					                                   <table border="0" cellpadding="20" width="100%">
					                                   <tr><td></td></tr>
					                                   </table>
					                                   <table border="0" cellpadding="35" width="100%">
					                                   <tr style="background:#d8fbf2;">
					                                     <td style="width:100%;padding:1rem 2rem 2rem 2rem;">
					                                 <b class="whatIfForgotPassword" style="font-size:20px;line-height:140%;color:#000000;">What you can do if you forgot your password?</b>
					                                 <p class="clickOnResetButtonText" style="margin-top:15px;font-size:17px;line-height:140%;color:#000000;">Click on the button below to reset your password.</p>
					                               <table border="0" cellpadding="0" cellspacing="0" class="emailButton" style="background-color:#fde45c;width:258px;margin-left:90px;">
					                                 <tr>
					                                   <td align="center" class="buttonContent">
					                                     <a style="font-size:15px;text-decoration:none!important;text-decoration:none;text-underline:none;line-height:135%;" href="'.$base_url.'reset-password.php?email='.$email.'"><font color="#000000">Reset</font></a>
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
           $mail->setFrom('gesternl@gester.nl', "Gester's Webstore");
           $mail->addAddress($email,$firstname);     // Add a recipient
					 // $mail->addAddress( 'gesternl@gester.nl', 'Gester Paez' ); // Copy from that mail to my email
           //$mail->addAddress('ellen@example.com');               // Name is optional
           // $mail->addReplyTo('gesternl@gester.nl', "Gester's Webstore");
           //$mail->addCC('cc@example.com');
           //$mail->addBCC('bcc@example.com');

           // Attachments
           //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
           //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

           // Content
           $mail->isHTML(true);                                  // Set email format to HTML
           $mail->Subject = "Welcome at Gester's Webstore";
           $mail->Body    = $mail_body;
           //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

           if($mail->Send())								//Send an Email. Return true on success or false on error
           {

             $query = "
             SELECT * FROM register_user
               WHERE user_email = :user_email
             ";
             $statement = $connect->prepare($query);
             $statement->execute(
               array(
                   'user_email'	=> $email
                 )
             );

             $count = $statement->rowCount();
             if($count > 0)
             {
               $result = $statement->fetchAll();
               foreach($result as $row)
               {
                 $_SESSION['user_id'] = $row['register_user_id'];
               }

             }

             $output = json_encode(array('type' => 'success', 'text' => "SuccessRedirectToIndex"));
             die($output);

           }
           else {
             $output = json_encode(array('type' => 'error', 'text' => "Mail could not be send"));
             die($output);
           }
         }
    }
  }
}
    else {
        $output = json_encode(array('type' => 'error', 'text' => "Robot verification failed. ".$response));
        die($output);
    }
    // close curl resource to free up system resources
    curl_close($ch);
  // echo $response;

?>
