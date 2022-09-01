<?php
session_start();

// page header html
$page_title="Login";
include 'layout_header.php';


if(isset($_SESSION['user_id']))
{
	echo "<script>window.location='products.php';</script>";
}

echo (isset($_SESSION['counter'])) ? $_SESSION['counter'] : 'empty';
?>
						<div id="pageName" value="login.php"></div>
						<div class="container containerResize hideForDynamicLogin mobilePadding" style="width:100%; max-width:600px;margin-top:30px;">
						<br/>
						<div class="card">
						<div class="card-body">
						<form method="post" id="loginForm" class="recaptcha_form">
						<div id='message'></div>
						<div class="form-group">
						<label class='beforeLoginLabels'>User Email</label>
						<input type="text" id="loginEmail" class="form-control cardBodyInputFieldBeforeLogin" pattern="^[^(\.)][a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[a-z]{2,5}"
						oninvalid="setCustomValidity('This is not a valid email.')" oninput="setCustomValidity('')" required />
						</div>
						<div class="form-group" style='margin-bottom:0px;'>
						<label class='beforeLoginLabels'>Password</label>
						</div>
						<div class="input-group" style='margin-bottom:1rem;'>
							<input id="loginPassword" type="password" class="form-control cardBodyInputFieldBeforeLogin pwd"
							pattern="((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})" oninvalid="setCustomValidity('This is not a valid password.')"
							oninput="setCustomValidity('')" required />
		<span class="input-group-btn">
			<button class="btn btn-default reveal" tabindex="-1" type="button"><i class="fas fa-eye change-eye"></i></button>
		</span>
	</div>
						<div class="form-group">
							<input type="hidden" name="token" id="token" />
						<button id="loginSubmitButton" type="submit" name="login" class="btn btn-primary resizeButtonBeforeLogin">Login</button>
						</div>
						<a href="reset-password.php" class='beforeLoginLinks'>Forgot your password?</a>
						</form>
						<p align="right" id='registerUpMediaQuery'><a href="register.php" class='beforeLoginLinks'>Register</a></p>
						</div>
						</div>
						</div>

						<div class="container showForDynamicLogin" style="width:100%;margin-top:100px;display:none;">
							<div id='informationDivLogin'><i class='fas fa-info-circle' style='color:white;font-size:26px;margin-left:18px;'></i><h5 style='width:100%;font-size:1.35rem!important;'>Your are successfully logged in!</h5></div>
						</div>


<?php include 'layout_footer.php'; ?>
