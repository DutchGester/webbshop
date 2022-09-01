<?php
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

			$query = "
			SELECT * FROM register_user
			WHERE user_email = :user_email
			";
			$stmt = $connect->prepare($query);
			$stmt->execute(
				array(
					':user_email'	=>	$_POST['user_email']
				)
			);
			$no_of_row = $stmt->rowCount();

			if($no_of_row > 0)
			{
				$output = json_encode(array('type' => 'error', 'text' => "This Email already exists"));
				die($output);
			}
			else {

				if(empty($_POST['user_email'])) {
					array_push($errors, "");
					$output = json_encode(array('type' => 'error', 'text' => "Email is a required field"));
					die($output);
				} else if(strlen($_POST['user_email']) > 250) {
					array_push($errors, "");
					$output = json_encode(array('type' => 'error', 'text' => "For Email is a max of 250 characters allowed"));
					die($output);
				} else if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})$/i', $_POST['user_email'])) {
					array_push($errors, "");
					$output = json_encode(array('type' => 'error', 'text' => "This is not a valid email address"));
					die($output);
				}

				if (count($errors) == 0) {

				$output = json_encode(array('type' => 'success', 'text' => "SuccessGoToSecondPart"));
				die($output);

			}
    }
  }
    else {
				$output = json_encode(array('type' => 'error', 'text' => "Robot verification failed. ".$response));
				die($output);
    }
    // close curl resource to free up system resources
    curl_close($ch);
?>
