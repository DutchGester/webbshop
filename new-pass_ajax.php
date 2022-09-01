<?php
session_start();
include('config/database_connection.php');

$errors = [];

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




        // if counter is not set, set to zero
        if(!isset($_SESSION['counterNewPassword'])) {
            $_SESSION['counterNewPassword'] = 0;
        }


if ($captchaResponse['success'] == '1' && $captchaResponse['score'] >= 0.5) {



  $new_pass = $_POST['new_pass'];
  $new_pass_c = $_POST['new_pass_c'];

    // select email address of user from the password_reset table
  $query7 = "SELECT email FROM password_resets WHERE token=:token LIMIT 1";
  $statement7 = $connect->prepare($query7);
  $statement7->bindValue(':token', $_GET['token']);
  $success7 = $statement7->execute();
  $row7 = $statement7->fetch();

  $email = $row7['email'];

  if (!empty($email)) {

  // select password of user
  $query6 = "SELECT user_password FROM register_user WHERE user_email=:user_email";
  $statement6 = $connect->prepare($query6);
  $statement6->bindValue(':user_email', $email);
  $success6 = $statement6->execute();
  $row6 = $statement6->fetch();

  $user_password = $row6['user_password'];

  if (empty($new_pass_c) || empty($new_pass) ) {
        array_push($errors, "");
        $output = json_encode(array('type' => 'error', 'text' => "All fields are required fields"));
        die($output);
  }

  if ($new_pass != $new_pass_c) {
    array_push($errors, "");
    $output = json_encode(array('type' => 'error', 'text' => "New password and confirm new password should be identical"));
    die($output);
  }

  if (strlen($new_pass) > 40 || strlen($new_pass_c) > 40) {
        array_push($errors, "");
        $output = json_encode(array('type' => 'error', 'text' => "For all fields are a max of 40 characters allowed"));
        die($output);
  }

  if(!preg_match('@[A-Z]@', $new_pass) || !preg_match('@[a-z]@', $new_pass) || !preg_match('@[0-9]@', $new_pass) ||
  !preg_match('/[^a-zA-Z\d]/', $new_pass) || strlen($new_pass) < 6) {
    array_push($errors, "");
    $output = json_encode(array('type' => 'error', 'text' => "New password is not a valid password. See the information box when you click inside the new password fields"));
    die($output);
  }

  if(!preg_match('@[A-Z]@', $new_pass_c) || !preg_match('@[a-z]@', $new_pass_c) || !preg_match('@[0-9]@', $new_pass_c) ||
  !preg_match('/[^a-zA-Z\d]/', $new_pass_c) || strlen($new_pass_c) < 6) {
    array_push($errors, "");
    $output = json_encode(array('type' => 'error', 'text' => "Confirm new password is not a valid password. See the information box when you click inside the new password fields"));
    die($output);
  }

  if (count($errors) == 0) {

    $_SESSION['limitResetPassword'] = time();

    // if button is pressed, increment counter
    if(isset($_POST["newpassword"])) {
      // echo "<br><br><br>";
      ++$_SESSION['counterNewPassword'];
    }

		$user_encrypted_password = password_hash($new_pass, PASSWORD_DEFAULT);

    $query5 = "UPDATE register_user SET user_password=:user_password WHERE user_email=:user_email";

    $statement5 = $connect->prepare($query5);
    $statement5->execute(array(
    ':user_password' => $user_encrypted_password,
    ':user_email' => $email
    ));

    $query4 = "DELETE FROM password_resets WHERE email=:email";

    $statement4 = $connect->prepare($query4);
    $statement4->execute(array(
    ':email' => $email
    ));

    //Let user login after successfully
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

    $output = json_encode(array('type' => 'success', 'text' => 'newpasswordSuccess'));
    die($output);
    }
  } else {
    $output = json_encode(array('type' => 'error', 'text' => "Your token is not in the database, try to reset your password again <a href='reset-password.php'>Click here</a>"));
    die($output);
  }
} else {
     $output = json_encode(array('type' => 'error', 'text' => "Robot verification failed. ".$response));
     die($output);
 }
 // close curl resource to free up system resources
 curl_close($ch);
// echo $response;
?>
