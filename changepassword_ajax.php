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


if ($captchaResponse['success'] == '1' && $captchaResponse['score'] >= 0.5) {

  $current_pass = $_POST['current_pass'];
  $new_pass = $_POST['new_pass'];
  $new_pass_c = $_POST['new_pass_c'];

  // select password of user
  $query6 = "SELECT user_password FROM register_user WHERE register_user_id=:id";
  $statement6 = $connect->prepare($query6);
  $statement6->bindValue(':id', $_SESSION['user_id']);
  $success6 = $statement6->execute();
  $row6 = $statement6->fetch();

  $user_password = $row6['user_password'];

  if (empty($current_pass) || empty($new_pass_c) || empty($new_pass) ) {
        array_push($errors, "");
        $output = json_encode(array('type' => 'error', 'text' => "All fields are required fields"));
        die($output);
  }

  if ($new_pass != $new_pass_c) {
    array_push($errors, "");
    $output = json_encode(array('type' => 'error', 'text' => "New password and confirm new password should be identical"));
    die($output);
  }

  if (strlen($new_pass) > 40 || strlen($new_pass_c) > 40 || strlen($current_pass) > 40) {
        array_push($errors, "");
        $output = json_encode(array('type' => 'error', 'text' => "For all fields are a max of 40 characters allowed"));
        die($output);
  }

  if(!preg_match('@[A-Z]@', $current_pass) || !preg_match('@[a-z]@', $current_pass) || !preg_match('@[0-9]@', $current_pass) ||
  !preg_match('/[^a-zA-Z\d]/', $current_pass) || strlen($current_pass) < 6) {
    array_push($errors, "");
    $output = json_encode(array('type' => 'error', 'text' => "Current password is not a valid password. See the information box when you click inside the new password fields"));
    die($output);
  }

  if(!preg_match('@[A-Z]@', $new_pass) || !preg_match('@[a-z]@', $new_pass) || !preg_match('@[0-9]@', $new_pass) ||
  !preg_match('/[^a-zA-Z\d]/', $new_pass) || strlen($new_pass) < 6) {
    array_push($errors, "");
    $output = json_encode(array('type' => 'error', 'text' => "New password is not a valid password. See information when you click inside the new password fields"));
    die($output);
  }

  if(!preg_match('@[A-Z]@', $new_pass_c) || !preg_match('@[a-z]@', $new_pass_c) || !preg_match('@[0-9]@', $new_pass_c) ||
  !preg_match('/[^a-zA-Z\d]/', $new_pass_c) || strlen($new_pass_c) < 6) {
    array_push($errors, "");
    $output = json_encode(array('type' => 'error', 'text' => "Confirm new password is not a valid password. See information when you click inside the new password fields"));
    die($output);
  }

  if (count($errors) == 0) {

  if(password_verify($current_pass,$user_password)) {

		$user_encrypted_password = password_hash($new_pass, PASSWORD_DEFAULT);

    $query5 = "UPDATE register_user SET user_password=:user_password WHERE register_user_id=:id";

    $statement5 = $connect->prepare($query5);
    $statement5->execute(array(
    ':user_password' => $user_encrypted_password,
    ':id' => $_SESSION['user_id']
    ));

    $query4 = "DELETE FROM password_resets WHERE register_user_id=:id";

    $statement4 = $connect->prepare($query4);
    $statement4->execute(array(
    ':id' => $_SESSION['user_id']
    ));

	  // header('location: login.php?newpassword=success');
    $output = json_encode(array('type' => 'success', 'text' => 'newpasswordSuccess'));
    die($output);
    } else {
      array_push($errors, "");
      $output = json_encode(array('type' => 'error', 'text' => "Your current password is incorrect"));
      die($output);
    }
      }
} else {
     $output = json_encode(array('type' => 'error', 'text' => "Robot verification failed. ".$response));
     die($output);
 }
 // close curl resource to free up system resources
 curl_close($ch);
// echo $response;
?>
