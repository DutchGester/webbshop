<?php
session_start();
include('config/database_connection.php');

$errors = [];

// $_SESSION['counterNewPassword'] = 2;
// $_SESSION['limitResetPassword'];

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

echo $_SESSION['counterNewPassword'];
echo "F: ".$_SESSION['limitResetPassword'];


if (isset($_GET['token']) != $tokenCompare) {
  $message = "<div class='alert alert-danger resizeFont hideForOtherMessage' style='text-align:center;'>Token is not correct, try to reset your password again <a href='reset-password.php'>Click here</a></div>";
  }

if(!isset($_GET['token'])) {
    $message = "<div class='alert alert-danger resizeFont hideForOtherMessage' style='text-align:center;'>There is no token, try to reset your password again <a href='reset-password.php'>Click here</a></div>";
    echo "<script>$('.disabled').prop('disabled', true);</script>";
  }

  if(isset($_SESSION['user_id']))
  {
  	echo "<script>window.location='products.php';</script>";
  }
?>

     <div class="container containerResize" style="width:100%; max-width:600px;margin-top:30px;">
        <br />
        <div class="card">
          <div class="card-body">
            <div id="showInformationForPasswordDiv" style="text-align:center;width:62%;right:539px;margin-top:-35.5px;">
              <div class="d-table-cell align-middle">
              <div id="length" class="glyphicon glyphicon-remove">Must be at least 6 to 40 characters</div>
            <div id="upperCase" class="glyphicon glyphicon-remove">Must have atleast 1 upper case character</div>
            <div id="lowerCase" class="glyphicon glyphicon-remove">Must have atleast 1 lower case character</div>
            <div id="numbers" class="glyphicon glyphicon-remove">Must have atleast 1 numeric character</div>
            <div id="symbols" class="glyphicon glyphicon-remove">Must have atleast 1 special character</div>
            <div class="arrow-right"></div>
            </div>
            </div>
            <div id="showInformationForPasswordDiv2" style="text-align:center;width:62%;right:539px;margin-top:51px;">
              <div class="d-table-cell align-middle">
              <div id="length2" class="glyphicon2 glyphicon-remove2">Must be at least 6 to 40 characters</div>
            <div id="upperCase2" class="glyphicon2 glyphicon-remove2">Must have atleast 1 upper case character</div>
            <div id="lowerCase2" class="glyphicon2 glyphicon-remove2">Must have atleast 1 lower case character</div>
            <div id="numbers2" class="glyphicon2 glyphicon-remove2">Must have atleast 1 numeric character</div>
            <div id="symbols2" class="glyphicon2 glyphicon-remove2">Must have atleast 1 special character</div>
            <div class="arrow-right"></div>
            </div>
            </div>
		  <!-- form validation messages -->
		<?php echo $message; ?>
    <div id='message'></div>
		<form method="post" id="new-pass-form" class="recaptcha_form">
		<div class="form-group">
			<label class='beforeLoginLabels'>New password</label>
      </div>
      <div class="input-group" style='margin-bottom:1rem;'>
			<input id='new_pass1' class="form-control disabled cardBodyInputFieldBeforeLogin pwd" type="password"
      pattern="((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})" oninvalid="setCustomValidity('This is not a valid password.')"
      oninput="setCustomValidity('')" required/>
      <span class="input-group-btn">
        <button class="btn btn-default reveal" tabindex="-1" type="button"><i class="fas fa-eye change-eye"></i></button>
      </span>
		</div>
		<div class="form-group">
			<label>Confirm new password</label>
    </div>
    <div class="input-group" style='margin-bottom:1rem;'>
			<input id='new_pass2' class="form-control disabled cardBodyInputFieldBeforeLogin pwd" type="password"
      pattern="((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})" oninvalid="setCustomValidity('This is not a valid password.')"
      oninput="setCustomValidity('')" required/>
      <span class="input-group-btn">
        <button class="btn btn-default reveal" tabindex="-1" type="button"><i class="fas fa-eye change-eye"></i></button>
      </span>
		</div>
		<div class="form-group">
      <input type="hidden" name="token" id="token" />
    <button id="newpassSubmitButton" type="submit" class="btn btn-primary resizeButtonBeforeLogin" <?php if (isset($_GET['token']) != $tokenCompare || !isset($_GET['token']) ){ ?> disabled <?php   } ?>>Send</button>
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
