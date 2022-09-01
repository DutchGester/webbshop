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
											|| empty($_POST['zipcode']) || empty($_POST['city']) || empty($_POST['phone']) || empty($email)) {
												array_push($errors, "");
												$output = json_encode(array('type' => 'error', 'text' => "All fields are required to fill in except your Birth date"));
												die($output);
									}

									if ( strlen($_POST['name']) > 40 || strlen($_POST['lastname']) > 40 || strlen($_POST['streetname']) > 40 || strlen($_POST['city']) > 40) {
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

				if (count($errors) == 0) {

					/* Update account info*/
					  $sql2 = "
					  UPDATE register_user SET user_phonenumber=:user_phonenumber, user_date=:user_date, user_gender=:user_gender
					         ,user_country=:user_country,user_firstname=:user_firstname, user_lastname=:user_lastname,
					         user_streetname =:user_streetname, user_streetnumber=:user_streetnumber, user_zipcode=:user_zipcode, user_city=:user_city
							 WHERE register_user_id=:id";

					  $statement2 = $connect->prepare($sql2);
					  $statement2->execute(array(
					  ':user_phonenumber' => $_POST['phone'],
					  ':user_date' => $_POST['date'],
					  ':user_gender' => $_POST['gender'],
					  ':user_country' => $_POST['country'],
					  ':user_firstname' => $_POST['name'],
					  ':user_lastname' => $_POST['lastname'],
					  ':user_streetname' => $_POST['streetname'],
					  ':user_streetnumber' => $_POST['streetnumber'],
					  ':user_zipcode' => $_POST['zipcode'],
					  ':user_city' => $_POST['city'],
					  ':id' => $_SESSION["user_id"]
					  ));

					$output = json_encode(array('type' => 'success', 'text' => "Success"));
					die($output);
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
