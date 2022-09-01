<?php
session_start();

$page_title="Account overview";
include 'layout_header.php';

if(isset($_SESSION['user_id']))
{
?>
<div class="container">
  </br>
<div class="row">
<div class="col-md-3 accountlist">
<div class="list-group ">
<a href="account-overview.php" class="list-group-item list-group-item-action">Account</a>
<a href="changepassword.php" class="list-group-item list-group-item-action active">Change password</a>
<a href="order-history.php" class="list-group-item list-group-item-action">Order history</a>
</div>
</div>


<div class="col-md-9" style="margin-bottom:50px;">
<div class="card">
<div class="card-body">
  <div id="showInformationForPasswordDiv" style="text-align:center;width:40%;right:558.5px;margin-top:49px;z-index:3;">
    <div class="d-table-cell align-middle">
    <div id="length" class="glyphicon glyphicon-remove">Must be at least 6 to 40 characters</div>
  <div id="upperCase" class="glyphicon glyphicon-remove">Must have atleast 1 upper case character</div>
  <div id="lowerCase" class="glyphicon glyphicon-remove">Must have atleast 1 lower case character</div>
  <div id="numbers" class="glyphicon glyphicon-remove">Must have atleast 1 numeric character</div>
  <div id="symbols" class="glyphicon glyphicon-remove">Must have atleast 1 special character</div>
  <div class="arrow-right"></div>
  </div>
  </div>

  <div id="showInformationForPasswordDiv2" style="text-align:center;width:40%;right:558.5px;margin-top:104.5px;z-index:3;">
    <div class="d-table-cell align-middle">
    <div id="length2" class="glyphicon2 glyphicon-remove2">Must be at least 6 to 40 characters</div>
  <div id="upperCase2" class="glyphicon2 glyphicon-remove2">Must have atleast 1 upper case character</div>
  <div id="lowerCase2" class="glyphicon2 glyphicon-remove2">Must have atleast 1 lower case character</div>
  <div id="numbers2" class="glyphicon2 glyphicon-remove2">Must have atleast 1 numeric character</div>
  <div id="symbols2" class="glyphicon2 glyphicon-remove2">Must have atleast 1 special character</div>
  <div class="arrow-right"></div>
  </div>
  </div>
<div class="row">
<div class="col-md-12">
<h4>Change password</h4>
<hr>
</div>
</div>
<div class="row">
<div class="col-md-12">
  <div style="text-align:center;">
  <div id='message'></div>
</div>
<form method="post" id="changepasswordAfterLoginForm" class="recaptcha_form">
  <div class="form-group row">
  <label for="currentpassword" class="col-4 col-form-label">Current password</label>
  <div class="col-8">
<input id='current_password' placeholder="Current password" class="form-control" type="password"
pattern="((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})" oninvalid="setCustomValidity('This is not a valid password.')"
oninput="setCustomValidity('')" required/>
  </div>
  </div>
<div class="form-group row">
<label for="newpassword" class="col-4 col-form-label">New password</label>
<div class="col-8">
<input id="new_password" placeholder="New password" class="form-control" type="password"
pattern="((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})" oninvalid="setCustomValidity('This is not a valid password.')"
oninput="setCustomValidity('')" required/>
</div>
</div>
<div class="form-group row">
<label for="repeat-newpassword" class="col-4 col-form-label">Repeat new password</label>
<div class="col-8">
<input id="repeat_newpassword" placeholder="Repeat new password" class="form-control" type="password"
pattern="((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})" oninvalid="setCustomValidity('This is not a valid password.')"
oninput="setCustomValidity('')" required/>
</div>
</div>
<div class="form-group row">
<div class="offset-4 col-8">
<input type="hidden" name="token" id="tokenChangePasswordAfterLogin" />
<button type="submit" class="btn btn-primary">Change</button>
</div>
</div>
</form>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
<?php }
else {
echo $message = "<label class='text-danger dangertext'>You need to login to watch your account</label>";
} ?>

<?php include 'layout_footer.php'; ?>
