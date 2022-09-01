<?php
session_start();

include('config/database_connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";

			$page_title="Verify your email";

			$site_key = '6Ld8o-0aAAAAAMCsoo2NWxtAV0zC-z4RIqREQLb-';
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// if (isset($_POST['submit'])) {
				function post_captcha($user_response) {
						$fields_string = '';
						$fields = array(
								'secret' => '----PASSWORD----',
								'response' => $user_response
						);
						foreach($fields as $key=>$value)
						$fields_string .= $key . '=' . $value . '&';
						$fields_string = rtrim($fields_string, '&');

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
						curl_setopt($ch, CURLOPT_POST, count($fields));
						curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

						$result = curl_exec($ch);
						curl_close($ch);

						return json_decode($result, true);
				}

				// Call the function post_captcha
				$res = post_captcha($_POST['g-recaptcha-response']);

				if ($res['success']) {

						$query = "
						SELECT user_email FROM register_user
						WHERE user_email = :user_email
						";
						$stmt = $connect->prepare($query);
						$stmt->execute(
							array(
								':user_email'	=>	$_GET['email']
							)
						);

						$no_of_row = $stmt->rowCount();

						if($no_of_row > 0)
						{
							$query3 = "DELETE FROM register_user WHERE user_email=:email;";
							$statement3 = $connect->prepare($query3);
							$statement3->execute(array(
							':email' => $_GET['email']
							));
						}

      function random_str(
          $length,
          $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
      ) {
          $str = '';
          $max = mb_strlen($keyspace, '8bit') - 1;
          if ($max < 1) {
              throw new Exception('$keyspace must be at least two characters long');
          }
          for ($i = 0; $i < $length; ++$i) {
              $str .= $keyspace[random_int(0, $max)];
          }
          return $str;
      }

     $user_password = random_str(8);
     $user_encrypted_password = password_hash($user_password, PASSWORD_DEFAULT);
     $user_activation_code = md5(rand());
     $insert_query = "
     INSERT INTO register_user
     (user_email, user_password, user_activation_code, user_email_status)
     VALUES (:user_email, :user_password, :user_activation_code, :user_email_status)
     ";
     $stmt = $connect->prepare($insert_query);
     $stmt->execute(
       array(
         ':user_email'			=>	$_GET['email'],
         ':user_password'		=>	$user_encrypted_password,
         ':user_activation_code'	=>	$user_activation_code,
         ':user_email_status'	=>	'not verified'
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

       $email = $_GET['email'];

       $base_url = "http://www.gester.nl/webshop/";  //change this baseurl value as per your file path
			 $mail_body = '

			 								<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			 								<html xmlns="http://www.w3.org/1999/xhtml">
			 								<head>
			 									<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			 									<meta name="viewport" content="width=device-width, initial-scale=1.0">
			 									<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			 									<title>Email Camping La Rustique</title>
			 									<style type="text/css">
			 										/* RESET STYLES */

			 										body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}
			 										table{border-collapse:collapse;}
			 										table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
			 										h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica;line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}


			 										/* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */

			 										.emailButton{background-color:#205478; border-collapse:separate;}
			 										.buttonContent{color:#FFFFFF; font-family:Helvetica; line-height:100%; padding:10px;text-align:center;}
			 										.buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}

			 										/* Queries for mobile */
			 											@media only screen and (max-width: 600px) {
			 												*[class="gmail-fix"] {
			 													display: none !important;
			 												}

			 												u + .body .buttonContent a{
			 												 font-size:17px!important;
			 												}

			 												u + .body #fontSizeHeader{
			 												 font-size:28px!important;
			 												}

			 												u + .body #fontSizeHeaderBody{
			 												 font-size:25.25px!important;
			 												}

			 												u + .body .fontSizeBody{
			 												 font-size:20.25px!important;
			 												}
			 												u + .body #fontSizeFooterHeader{
			 												 font-size:26px!important;
			 												}

			 												u + .body .fontSizeFooterBody{
			 												 font-size:17px!important;
			 												}


			 												/* IF YOU WANT TO CHANGE EMAIL BORDER FOR MOBILE */
			 												#borderLeftRight {
			 												}

			 												.emailButton {
			 													width:50%!important;
			 												}
			 												.marginBottom {
			 													margin-bottom:0px!important;
			 												}
			 												.marginTop {
			 													margin-top:25px!important;
			 												}
			 												.marginBottomEnding {
			 													margin-bottom:30px!important;
			 												}
			 												.marginTopZero {
			 													margin-top:0px!important;
			 												}

			 												.buttonContent a{font-size:20px!important;}
			 												#fontSizeHeader {font-size:33px!important;}
			 												#fontSizeHeaderBody {font-size:28px!important;}
			 												.fontSizeBody {font-size:23px!important;}
			 												#fontSizeFooterHeader {font-size:28px!important;}
			 												.fontSizeFooterBody {font-size:20px!important;}
			 												#footerBodyTable {margin-top:10px!important;margin-bottom:20px!important;}

			 												.buttonContent{padding:15px!important;}

			 											}

			 											/* Queries for desktop */
			 											@media only screen and (min-width: 601px) {

			 											}
			 									</style>

			 									<!--[if (mso)|(mso 16)]>
			 										<style type="text/css">
			 										body, table, td, a, span { font-family: Arial, Helvetica, sans-serif !important; }
			 										a {text-decoration: none;}
			 										</style>
			 										<![endif]-->
			 								</head>

			 								<body class="body">
			 								<center style="background-color:#FFFFFF;">
			 									<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
			 										<tr>
			 											<td align="center" valign="top" id="bodyCell">

			 													<table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">

			 														<tr>
			 															<td align="center" valign="top">

			 																<table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#3498db">
			 																	<tr>
			 																		<td align="center" valign="top">

			 																			<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
			 																				<tr>
			 																					<td align="center" valign="top" width="500" class="flexibleContainerCell">

			 																						<table border="0" cellpadding="30" cellspacing="0" width="100%">
			 																							<tr>
			 																								<td align="center" valign="top" class="textContent">
			 																									<h1 id="fontSizeHeader" style="color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:23px;font-weight:bold;margin-bottom:5px;text-align:center;">Webshop</h1>
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
			 															<td align="center" valign="top">
			 																<!-- CENTERING TABLE // -->
			 																<table id="borderLeftRight" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFF" style="border-left: 2px solid #3498db;border-right: 2px solid #3498db;">
			 																	<tr>
			 																		<td align="center" valign="top">
			 																			<!-- FLEXIBLE CONTAINER // -->
			 																			<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
			 																				<tr>
			 																					<td align="center" valign="top" width="500" class="flexibleContainerCell">
			 																						<table border="0" cellpadding="30" cellspacing="0" width="100%">
			 																							<tr>
			 																								<td align="center" valign="top">
			 																									<!-- CONTENT TABLE // -->
			 																									<table border="0" cellpadding="0" cellspacing="0" width="100%">

			 																										<tr>
			 																											<td valign="top" class="textContent">
			 																													<h3 id="fontSizeHeaderBody" mc:edit="header" style="color:black;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:17px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Registration</h3><br>
			 																												<div class="fontSizeBody" mc:edit="body" style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:14px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
			 																												<p>Hello</p>
			 																												<p style="margin-bottom:17px;">Thanks for your registration. Your password is <b>'.$user_password.'</b>, this password will work only after your email verification. Please click on the button below to verify your email address</p>
			 																																		<center>
			 																																											<table border="0" cellpadding="0" cellspacing="0" class="emailButton" style="background-color: #007bff;width:33.33%;">
			 																																												<tr>
			 																																													<td align="center" valign="middle" class="buttonContent">
			 																																														<a style="color:#FFFFFF;font-size:13px;text-decoration:none!important;text-decoration:none;text-underline:none;font-family:Helvetica,Arial,sans-serif;line-height:135%;" href="'.$base_url.'email_verification.php?activation_code='.$user_activation_code.'">Click here</a>
			 																																													</td>
			 																																												</tr>
			 																																											</table>
			 				</center>
			 																											<tr><td><br><p>You can change your password after you logged in successfully.</p><p class="fontSizeBody" style="color:#5F5F5F;font-size:14px;">Best regards,<br><br>Gesters Webstore</p></td></tr>
			 																											</div>
			 																											</td>
			 																										</tr>
			 																										<tr class="gmail-fix">
			 																											<td>
			 																												<table cellpadding="0" cellspacing="0" border="0" align="center" width="500">
			 																													<tr>
			 																														<td cellpadding="0" cellspacing="0" border="0" height="1"; style="line-height: 1px; min-width: 400px;">
			 																																<img src="https://gester.nl/campingReservering/img/emailSpace.png" width="400" height="1" style="display: block; max-height: 1px; min-height: 1px; min-width: 400px; width: 400px;"/>
			 																															</td>
			 																														</tr>
			 																												</table>
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
			 															<td align="center" valign="top">

			 															<table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#3498db">
			 																<tr>
			 																	<td align="center" valign="top">

			 																		<table style="margin-left:30px;margin-right:30px;" border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
			 																			<tr>
			 																				<td align="center" valign="top" width="500" class="flexibleContainerCell">

			 																					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:0px;">
			 																						<tr>
			 																							<td align="center" valign="top" class="textContent">
			 																								<h3 id="fontSizeFooterHeader" class="marginBottom marginTop" style="color:#205478;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:18px;font-weight:bold;margin-bottom:0px;margin-top:15px;text-align:center;">Contact & Service</h3>
			 																							</td>
			 																						</tr>
			 																					</table>
			 																					<table id="footerBodyTable" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:0px;margin-bottom:0px;">
			 																					<tr>
			 																						<td style="padding-bottom:20px;">
			 																						<p class="fontSizeFooterBody" class="marginBottom marginTopZero" style="color:#FFFFFF;line-height:135%;font-family:Helvetica,Arial,sans-serif;font-size:12.5px;font-weight:normal;margin-bottom:0px;margin-top:20px;text-align:center;">Openinghours: ma t/m vr: <a href="#/" style="text-decoration:underline;color:#FFFFFF;"> 8:30 - 17:00 uur</a>, zaterdag: <a href="#/" style="text-decoration:underline;color:#FFFFFF;"> 10:00 - 16:00 uur</a></p>
			 																						</td>
			 																						</tr>
			 																						<tr>
			 																						<td style="padding-bottom:20px;">
			 																								<p class="fontSizeFooterBody" class="marginBottom" style="color:#FFFFFF;line-height:135%;font-family:Helvetica,Arial,sans-serif;font-size:12.5px;font-weight:normal;margin-bottom:0px;text-align:center;margin-top:0px;">Contact us at this number: <a href="tel:0761218912" style="text-decoration:underline;border:none;color:#205478;font-weight:bold;">076 121 8912</a></p>
			 																						</td>
			 																					</tr>
			 																						<tr>
			 																							<td>
			 																							<p class="fontSizeFooterBody" class="marginBottomEnding" style="color:#FFFFFF;line-height:135%;font-family:Helvetica,Arial,sans-serif;font-size:12.5px;padding-left:20px;padding-right:20px;font-weight:normal;margin-bottom:20px;text-align:center;margin-top:0px;">To file a complaint: <a href="tel:0761598133" style="text-decoration:underline;border:none;color:#205478;font-weight:bold;">076 159 8133</a></p>
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
			 							';

       $mail = new PHPMailer(true);
             //Server settings
       $mail->SMTPDebug = 0;                                       // Enable verbose debug output
       $mail->isSMTP();                                            // Set mailer to use SMTP
			 $mail->Host       = 'mail.argewebhosting.nl';  // Specify main and backup SMTP servers
			 $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			 $mail->Username   = 'gester@gester.nl';                     // SMTP username
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
       $mail->setFrom('gester@gester.nl', "Gester's Webstore");
       $mail->addAddress($email);     // Add a recipient
       //$mail->addAddress('ellen@example.com');               // Name is optional
       $mail->addReplyTo('gester@gester.nl', "Gester's Webstore");
       //$mail->addCC('cc@example.com');
       //$mail->addBCC('bcc@example.com');

       // Attachments
       //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
       //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

       // Content
       $mail->isHTML(true);                                  // Set email format to HTML
       $mail->Subject = "Email Verification for Gester's Webstore";
       $mail->Body    = $mail_body;
       //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

       if($mail->Send())								//Send an Email. Return true on success or false on error
       {
         header('location:register-done-again.php?email='.$email.'');
         //$message = '<div style="text-align:center;"><label class="text-success">Register is done, please check your e-mail!<br>It is possible that this email will be send to your <b>junk-box</b></label></div></br>';
       }
       else {
         $message = '<div style="text-align:center;"><label class="text-danger">Mail could not be send</label></div>';
       }
		 }
	} else {
			$message = '<div style="text-align:center;"><label class="text-danger">Robot verification failed</div>';
	}
}

			include 'layout_header.php';
 ?>

	<form id="i-recaptcha" method="post" class="form-group messagesBeforeLogin" style="text-align: center;">
		<?php echo $message ?>
		<div class="alert alert-success" style="text-align:center;">
      You received an email on <b><?php echo $_GET['email']?></b> with an confirmation link.
	    Didn't receive your email?<br>Check your <b>spam-box</b> or<button class="send-again-button g-recaptcha"
			data-sitekey="<?php echo $site_key; ?>" data-callback="onSubmit">Send again</button></div>
	</form>

<?php include 'layout_footer.php'; ?>
