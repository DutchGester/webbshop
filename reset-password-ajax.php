<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];

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

if($_SESSION['counterNewPassword'] < 3) {
if ($captchaResponse['success'] == '1' && $captchaResponse['score'] >= 0.5) {

      /*
        Accept email of user whose password is to be reset
        Send email to user to reset their password
      */

      // ensure that the user exists on our system
      $query = "SELECT user_email FROM register_user WHERE user_email=:user_email";

      $statement = $connect->prepare($query);
      $statement->execute(array(
      ':user_email' => $_POST['email']
      ));

      $no_of_row = $statement->rowCount();

      if (empty($_POST['email'])) {
        array_push($errors, "");
        $output = json_encode(array('type' => 'error', 'text' => "Your email is required"));
        die($output);
      }else if($no_of_row == 0) {
        array_push($errors, "");
        $output = json_encode(array('type' => 'error', 'text' => "Sorry, no user exists on our system with that email"));
        die($output);
      } else if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})$/i', $_POST['email'])) {
                array_push($errors, "");
                $output = json_encode(array('type' => 'error', 'text' => "This is not a valid email address"));
                die($output);
      } else if(strlen($_POST['email']) > 250) {
              array_push($errors, "");
              $output = json_encode(array('type' => 'error', 'text' => "For Email is a max of 250 characters allowed"));
              die($output);
            }

      // generate a unique random token of length 100
      $token = bin2hex(random_bytes(50));

      if (count($errors) == 0) {

        $query = "SELECT user_email FROM register_user WHERE user_email=:user_email";

        $statement = $connect->prepare($query);
        $statement->execute(array(
        ':user_email' => $_POST['email']
        ));

        $no_of_row = $statement->rowCount();

        if($no_of_row > 0) {
        // store token in the password-reset database table against the user's email
      $query2 = "INSERT INTO password_resets(email, token) VALUES (:user_email, :token)";

      $statement2 = $connect->prepare($query2);
      $statement2->execute(array(
      ':user_email' => $_POST['email'],
      ':token' => $token
      ));

        /* Catch firstname for $mail_body */
        $query3 = "SELECT user_firstname FROM register_user WHERE user_email=:user_email";
        $statement3 = $connect->prepare($query3);
        $statement3->bindValue(':user_email', $_POST['email']);
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
                                          <p class="unusualActivityInYourAccount" style="font-size:19px;margin-top:10px;line-height:140%;color:#000000;">Click on the button below to reset your password on our site.</p>
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
          $mail->setFrom('gesternl@gester.nl', "Gester's Webstore");
          $mail->addAddress($_POST['email'], $firstname);     // Add a recipient
          //$mail->addAddress('ellen@example.com');               // Name is optional
          // $mail->addReplyTo('gester@gester.nl', "Gester's Webstore");
          //$mail->addCC('cc@example.com');
          //$mail->addBCC('bcc@example.com');

          // Attachments
          //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
          //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = "Reset your password for Gester's Webstore";
          $mail->Body    = $mail_body;
          //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          if($mail->send())								//Send an Email. Return true on success or false on error
          {
            $output = json_encode(array('type' => 'success', 'text' => "SuccessRedirectToIndex"));
            die($output);
          }
        } else {
          $output = json_encode(array('type' => 'error', 'text' => "Mail could not be send"));
          die($output);
          }
      }
     } else {
        $output = json_encode(array('type' => 'error', 'text' => "Robot verification failed. ".$response));
        die($output);
    }
  } else {
    $output = json_encode(array('type' => 'error', 'text' => "You can only reset your password for 3 times in 2 hours"));
    die($output);
  }
    // close curl resource to free up system resources
    curl_close($ch);
  // echo $response;
?>
