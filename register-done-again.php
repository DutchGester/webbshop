<?php

$page_title="Verify your email";

include 'layout_header.php';
?>

	<form method="post" class="form-group messagesBeforeLogin">
			<div class="alert alert-success" style="text-align:center;">
      You received an email again on <b><?php echo $_GET['email']?></b> with an confirmation link.
	    Still didn't receive your email?<br>Check your <b>spam-box</b>.</div>
	</form>


<?php
include 'layout_footer.php';
?>
