<?php
session_start();
// 2 hours in seconds
// $inactive = 7200;
$inactive = 7200;
ini_set('session.gc_maxlifetime', $inactive); // set the session max lifetime to 2 hours

// page header html
$page_title="Reset your password";
$errors = [];
include 'layout_header.php';

// $_SESSION['counterNewPassword'] = 2;

if($_SESSION['counterNewPassword'] == 3) {
  $message = "<div class='alert alert-danger resizeFont hideForOtherMessage' style='text-align:center;'>You can only reset your password for 3 times in 2 hours</div>";
  echo "<script>$('.disable-button').prop('disabled', true);</script>";

  if (isset($_SESSION['limitResetPassword']) && (time() - $_SESSION['limitResetPassword'] > $inactive)) {
    echo "<br>DESTROYED";
      // last request was more than 2 hours ago
      $_SESSION['limitResetPassword'] = NULL;
      $_SESSION['counterNewPassword'] = 0;
      $message = "";
      // session_unset($_SESSION['limitResetPassword']);     // unset $_SESSION variable for this page
      // session_destroy();   // destroy session data
  } else {
    echo "<br>NOT DESTROYED";
    // $_SESSION['limitResetPassword'] = time(); // Update session
  }
}

// echo " ".$_SESSION['counterNewPassword'];
//
// echo "<br>X: ".$_SESSION['limitResetPassword']." ";

// echo date('Y-m-d H:i:s', $_SESSION['limitResetPassword']);

if(isset($_SESSION['user_id']))
{
	echo "<script>window.location='products.php';</script>";
}

$previous = "javascript:history.back()";
if(isset($_SERVER['HTTP_REFERER'])) {
	$previous = $_SERVER['HTTP_REFERER'];
}
?>


          <div class="container containerResize hideForDynamicPending mobilePadding" style="width:100%; max-width:600px;margin-top:30px;">
          <br />
          <div class="card">
          <div class="card-body">
          <div id='message'></div>
          <?php echo $message; ?>
          <p class="instructionResetPasswordText">
          An e-mail will be send to you with instructions on how to reset your password.</p>
          </br>
          <form method="post" id="reset-password-form" class="recaptcha_form">
          <div class="form-group">
          <?php echo isset($_GET['email']) ? '' : '<label class="beforeLoginLabels">Enter your e-mail address</label>'; ?>
          <input id='email' class="form-control cardBodyInputFieldBeforeLogin disabled" type="text" pattern="^[^(\.)][a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[aA-zZ]{2,5}" oninvalid="setCustomValidity('This is not a valid email.')"
          oninput="setCustomValidity('')" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" required/>
          </div>
          <div class="form-group">
          <input type="hidden" name="token" id="token" />
          <button id="reset-password-button" type="submit" class="btn btn-primary resizeButtonBeforeLogin disable-button" <?php if ($_SESSION['counterNewPassword'] == 3){ ?> disabled <?php   } ?>><?php echo isset($_GET['email']) ? 'Press on send' : 'Send';?></button>
          </div>
          </form>
          <?php echo isset($_GET['email']) ? '' : '<p align="right"><a class="linksInsideCardBody beforeLoginLinks" href="'.$previous.'">Go back</a></p>';?>
          </div>
          </div>
          </div>

          <form method="post" id="pending-form" class="form-group recaptcha_form" style='display:none;'>
            <div class="alert alert-success changeDynamicText" style="text-align:center;padding:1.2rem;">
              If your email is in our database we will send an email to <b id='insertUsersEmail'></b> to help you recover your account.<br>
              Didn't receive your email?<br>Check your <b>spam-box</b> or <button id="pendingSubmitButton" type="submit" class="send-again-button">Send again</button><br><br>
              Please login into your email provider account and click on the link we sent to reset your password.</div>
              <input type="hidden" id="tokenPendingPage" />
          </form>

          <div id="pendingPageModal" class="modal" tabindex="-1" role="dialog">
    			<div class="modal-dialog" role="document">
    			<div class="modal-content">
    			<div class="modal-header">
    			<h5 class="modal-title text-center col-12">Something went wrong
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    			</button>
    			</h5>
    			</div>
    			<div class="modal-body text-center">
    			<p class="text-danger showMessageModal"></p>
    			</div>
    			<div class="modal-footer">
    			<button id="modal-button" type="button" class="btn btn-primary redirectCloseButton" data-dismiss="modal">Close</button>
    			</div>
    			</div>
    			</div>
    		</div>
<?php
if($_SESSION['counterNewPassword'] == 3) {
echo "<script>$('.disabled').prop('disabled', true);</script>";
}

include 'layout_footer.php'; ?>
