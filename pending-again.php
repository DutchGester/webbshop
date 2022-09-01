<?php

$page_title="Password reset";

include 'layout_header.php';
?>

	<?php echo $message; ?>
	<form id="reset-password-again" method="POST" class="form-group messagesBeforeLogin">
		<div class="alert alert-success" style="text-align:center;">
			If your email is in our database you will receive an email <span style="text-decoration:underline">again</span> on <b><?php echo $_GET['email'] ?></b> to help you recover your account.<br>
			Didn't receive your email? Check your <b>spam-box</b>.<br>
	    Please login into your email account and click on the link we sent to reset your password.</div>
	</form>

<?php
include 'layout_footer.php';
?>
