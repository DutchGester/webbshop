<?php
include('config/database_connection.php');

$errors = [];

// page header html
$page_title="New password";

// select email address of user from the password_reset table
$query8 = "SELECT token FROM password_resets WHERE token=:token LIMIT 1";
$statement8 = $connect->prepare($query8);
$statement8->bindValue(':token', $_GET['token']);
$success8 = $statement8->execute();
$row8 = $statement8->fetch();

$tokenCompare = $row8['token'];
include 'layout_header.php';

if (isset($_GET['token']) != $tokenCompare) {
  $message = "<div class='alert alert-danger resizeFont' style='text-align:center;'>Token is not correct, try to reset your password again <a href='reset-password.php'>Click here</a></div>";
  }

if(!isset($_GET['token'])) {
    $message = "<div class='alert alert-danger resizeFont' style='text-align:center;'>There is no token, try to reset your password again <a href='reset-password.php'>Click here</a></div>";
    echo "<script>$('.disabled').prop('disabled', true);</script>";
  }
?>

     <div class="container containerResize" style="width:100%; max-width:600px;margin-top:30px;">
        <br />
        <div class="card">
          <div class="card-body">
            <div id="showInformationForPasswordDiv" style="text-align:center;width:62%;right:539px;margin-top:51.5px;">
              <div class="d-table-cell align-middle">
              <div id="length" class="glyphicon glyphicon-remove">Must be at least 6 to 40 characters</div>
            <div id="upperCase" class="glyphicon glyphicon-remove">Must have atleast 1 upper case character</div>
            <div id="lowerCase" class="glyphicon glyphicon-remove">Must have atleast 1 lower case character</div>
            <div id="numbers" class="glyphicon glyphicon-remove">Must have atleast 1 numeric character</div>
            <div id="symbols" class="glyphicon glyphicon-remove">Must have atleast 1 special character</div>
            <div class="arrow-right"></div>
            </div>
            </div>
		  <!-- form validation messages -->
		<?php echo $message; ?>
    <div id='message'></div>
		<form method="post" id="new-pass-form" class="recaptcha_form">
      <div class="form-group">
  			<label class='beforeLoginLabels'>Current password</label>
  			<input id='current_password' class="form-control disabled cardBodyInputFieldBeforeLogin" type="password">
  		</div>
		<div class="form-group">
			<label class='beforeLoginLabels'>New password</label>
			<input id='new_pass1' class="form-control disabled cardBodyInputFieldBeforeLogin passwordForNewPassword" type="password">
		</div>
		<div class="form-group">
			<label>Confirm new password</label>
			<input id='new_pass2' class="form-control disabled cardBodyInputFieldBeforeLogin passwordForNewPassword" type="password">
		</div>
		<div class="form-group">
      <input type="hidden" name="token" id="token" />
    <button id="newpassSubmitButton" type="submit" class="btn btn-primary resizeButtonBeforeLogin">Send</button>
		</div>
	</form>
</div>
</div>
</div>
<?php
if(!isset($_GET['token'])) {
echo "<script>$('.disabled').prop('disabled', true);</script>";
  }
  if (isset($_GET['token']) != $tokenCompare) {

    echo "<script>$('.disabled').prop('disabled', true);</script>";
    }
  include 'layout_footer.php';
?>
