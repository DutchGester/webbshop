<?php
session_start();

$page_title="Email verification";
include 'layout_header.php';

include('config/database_connection.php');

$message = '';

if(isset($_GET['activation_code']))
{
	$query = "
		SELECT * FROM register_user
		WHERE user_activation_code = :user_activation_code
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':user_activation_code'			=>	$_GET['activation_code']
		)
	);
	$no_of_row = $statement->rowCount();

	if($no_of_row > 0)
	{
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			if($row['user_email_status'] == 'not verified')
			{
				$update_query = "
				UPDATE register_user
				SET user_email_status = 'verified'
				WHERE register_user_id = '".$row['register_user_id']."'
				";
				$statement = $connect->prepare($update_query);
				$statement->execute();
				$sub_result = $statement->fetchAll(PDO::FETCH_ASSOC);
				if(isset($sub_result))
				{
					$message = '<div class="alert alert-success" style="text-align:center;">
					Your email address is successfully verified <br/><br/>You can login here - <a href="login.php">Login</a></div>';
					}
				}
				else
				{
				$message = '<div class="alert alert-info" style="text-align:center;">
				Your email address is already verified <br/><br/>You can login here - <a href="login.php">Login</a></div>';
				}
			}
		}
			else
		{
		$message = '<div class="alert alert-danger" style="text-align:center;">
		Invalid Link <br/><br/> You can register here - <a href="register.php">Register</a></div>';
	}
}

?>

			<form class="email_verification messagesBeforeLogin">
			<?php echo $message; ?>
			</form>


<?php include 'layout_footer.php'; ?>
