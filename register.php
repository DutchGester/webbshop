<?php
session_start();

if(isset($_SESSION['user_id']))
{
	echo "<script>window.location='products.php';</script>";
}

// page header html
$page_title="Register";

$errors = [];
include 'layout_header.php';

$message = '';

$page_title="Password reset";
?>

<div id="pageName" value="register.php"></div>
<div class="container containerResize hideForDynamicLogin mobilePadding" style="width:100%; max-width:600px;margin-top:30px;">
<br />
<div class="card">
<div class="card-body">
<form method="post" id="register_first_part" class="recaptcha_form">
<div id="message"></div>
<div class="form-group">
<label class='beforeLoginLabels' style='margin-bottom:20px;'>If your <b>new</b> you can make your account in no-time.</label>
<input id="first-email" type="text" name="user_email" class="form-control cardBodyInputFieldBeforeLogin" placeholder="Email address"
pattern="^[^(\.)][a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[aA-zZ]{2,5}" oninvalid="setCustomValidity('This is not a valid email.')"
oninput="setCustomValidity('')" required/>
</div>
<div class="form-group">
<input type="hidden" name="token" id="token" />
<button id='submitEmailRegister' type="submit" class="btn btn-primary resizeButtonBeforeLogin" name='submit_register_email'>Make new account</button>
<p align="right" id='registerUpMediaQuery'><a href="login.php" class='linksInsideCardBody beforeLoginLinks'>Login</a></p>
</div>
</form>
</div>
</div>
</div>

<div class="container containerResize accountForRegister col-md-12 row" style="margin-top:0px;display:none;margin-bottom:50px;">
<div class="col-2"></div><div class="col-8"><div id="message2"></div></div>
<div class="col-12" style='margin-bottom:30px;margin-top:10px;'><div class="col-2" style='text-align:right;'>* = required field</div></div>
<div class="col-md-6">
<form method="post" id="register_second_part" class="recaptcha_form">
<div class="form-group row">
<label for="gender" style='text-align:right;' class="col-4 col-form-label">Gender*</label>
<div style="margin-top:6.5px;" class="col-8">
<input id="1" type="radio" name="gender" class="gender" value="Male" required/>  <label for="1">Male</label>
<input id="2" style="margin-left:20px;" type="radio" name="gender" class="gender"  value="Female" required/> <label for="2">Female</label>
</div>
</div>
<div class="form-group row">
<label for="name" style='text-align:right;' class="col-4 col-form-label">First name*</label>
<div class="col-8">
<input id="name" name="name" placeholder="First name" class="form-control"
type="text" pattern="^[A-Za-z\s]+$" oninvalid="setCustomValidity('Only letters and spaces allowed.')" oninput="setCustomValidity('')" required/>
</div>
</div>
<div class="form-group row">
<label for="lastname" style='text-align:right;' class="col-4 col-form-label">Last name*</label>
<div class="col-8">
<input id="lastname" name="lastname" placeholder="Last name" class="form-control"
type="text" pattern="^[A-Za-z\s]+$" oninvalid="setCustomValidity('Only letters and spaces allowed.')" oninput="setCustomValidity('')" required/>
</div>
</div>
<div class="form-group row">
<label for="country" style='text-align:right;' class="col-4 col-form-label">Country*</label>
<div class="col-8">
  <select name="country" class="form-control countrySelect" data-show-subtext="true" data-live-search="true" data-live-search-placeholder="Search your country..." required/>
	<option value="Select Country" selected=''>Select Country</option>
  <option value="United States">United States</option>
  <option value="United Kingdom">United Kingdom</option>
  <option value="Afghanistan">Afghanistan</option>
  <option value="Albania">Albania</option>
  <option value="Algeria">Algeria</option>
  <option value="American Samoa">American Samoa</option>
  <option value="Andorra">Andorra</option>
  <option value="Angola">Angola</option>
  <option value="Anguilla">Anguilla</option>
  <option value="Antarctica">Antarctica</option>
  <option value="Antigua and Barbuda">Antigua and Barbuda</option>
  <option value="Argentina">Argentina</option>
  <option value="Armenia">Armenia</option>
  <option value="Aruba">Aruba</option>
  <option value="Australia">Australia</option>
  <option value="Austria">Austria</option>
  <option value="Azerbaijan">Azerbaijan</option>
  <option value="Bahamas">Bahamas</option>
  <option value="Bahrain">Bahrain</option>
  <option value="Bangladesh">Bangladesh</option>
  <option value="Barbados">Barbados</option>
  <option value="Belarus">Belarus</option>
  <option value="Belgium">Belgium</option>
  <option value="Belize">Belize</option>
  <option value="Benin">Benin</option>
  <option value="Bermuda">Bermuda</option>
  <option value="Bhutan">Bhutan</option>
  <option value="Bolivia">Bolivia</option>
  <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
  <option value="Botswana">Botswana</option>
  <option value="Bouvet Island">Bouvet Island</option>
  <option value="Brazil">Brazil</option>
  <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
  <option value="Brunei Darussalam">Brunei Darussalam</option>
  <option value="Bulgaria">Bulgaria</option>
  <option value="Burkina Faso">Burkina Faso</option>
  <option value="Burundi">Burundi</option>
  <option value="Cambodia">Cambodia</option>
  <option value="Cameroon">Cameroon</option>
  <option value="Canada">Canada</option>
  <option value="Cape Verde">Cape Verde</option>
  <option value="Cayman Islands">Cayman Islands</option>
  <option value="Central African Republic">Central African Republic</option>
  <option value="Chad">Chad</option>
  <option value="Chile">Chile</option>
  <option value="China">China</option>
  <option value="Christmas Island">Christmas Island</option>
  <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
  <option value="Colombia">Colombia</option>
  <option value="Comoros">Comoros</option>
  <option value="Congo">Congo</option>
  <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
  <option value="Cook Islands">Cook Islands</option>
  <option value="Costa Rica">Costa Rica</option>
  <option value="Cote D'ivoire">Cote D'ivoire</option>
  <option value="Croatia">Croatia</option>
  <option value="Cuba">Cuba</option>
  <option value="Cyprus">Cyprus</option>
  <option value="Czech Republic">Czech Republic</option>
  <option value="Denmark">Denmark</option>
  <option value="Djibouti">Djibouti</option>
  <option value="Dominica">Dominica</option>
  <option value="Dominican Republic">Dominican Republic</option>
  <option value="Ecuador">Ecuador</option>
  <option value="Egypt">Egypt</option>
  <option value="El Salvador">El Salvador</option>
  <option value="Equatorial Guinea">Equatorial Guinea</option>
  <option value="Eritrea">Eritrea</option>
  <option value="Estonia">Estonia</option>
  <option value="Ethiopia">Ethiopia</option>
  <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
  <option value="Faroe Islands">Faroe Islands</option>
  <option value="Fiji">Fiji</option>
  <option value="Finland">Finland</option>
  <option value="France">France</option>
  <option value="French Guiana">French Guiana</option>
  <option value="French Polynesia">French Polynesia</option>
  <option value="French Southern Territories">French Southern Territories</option>
  <option value="Gabon">Gabon</option>
  <option value="Gambia">Gambia</option>
  <option value="Georgia">Georgia</option>
  <option value="Germany">Germany</option>
  <option value="Ghana">Ghana</option>
  <option value="Gibraltar">Gibraltar</option>
  <option value="Greece">Greece</option>
  <option value="Greenland">Greenland</option>
  <option value="Grenada">Grenada</option>
  <option value="Guadeloupe">Guadeloupe</option>
  <option value="Guam">Guam</option>
  <option value="Guatemala">Guatemala</option>
  <option value="Guinea">Guinea</option>
  <option value="Guinea-bissau">Guinea-bissau</option>
  <option value="Guyana">Guyana</option>
  <option value="Haiti">Haiti</option>
  <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
  <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
  <option value="Honduras">Honduras</option>
  <option value="Hong Kong">Hong Kong</option>
  <option value="Hungary">Hungary</option>
  <option value="Iceland">Iceland</option>
  <option value="India">India</option>
  <option value="Indonesia">Indonesia</option>
  <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
  <option value="Iraq">Iraq</option>
  <option value="Ireland">Ireland</option>
  <option value="Israel">Israel</option>
  <option value="Italy">Italy</option>
  <option value="Jamaica">Jamaica</option>
  <option value="Japan">Japan</option>
  <option value="Jordan">Jordan</option>
  <option value="Kazakhstan">Kazakhstan</option>
  <option value="Kenya">Kenya</option>
  <option value="Kiribati">Kiribati</option>
  <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
  <option value="Korea, Republic of">Korea, Republic of</option>
  <option value="Kuwait">Kuwait</option>
  <option value="Kyrgyzstan">Kyrgyzstan</option>
  <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
  <option value="Latvia">Latvia</option>
  <option value="Lebanon">Lebanon</option>
  <option value="Lesotho">Lesotho</option>
  <option value="Liberia">Liberia</option>
  <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
  <option value="Liechtenstein">Liechtenstein</option>
  <option value="Lithuania">Lithuania</option>
  <option value="Luxembourg">Luxembourg</option>
  <option value="Macao">Macao</option>
  <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
  <option value="Madagascar">Madagascar</option>
  <option value="Malawi">Malawi</option>
  <option value="Malaysia">Malaysia</option>
  <option value="Maldives">Maldives</option>
  <option value="Mali">Mali</option>
  <option value="Malta">Malta</option>
  <option value="Marshall Islands">Marshall Islands</option>
  <option value="Martinique">Martinique</option>
  <option value="Mauritania">Mauritania</option>
  <option value="Mauritius">Mauritius</option>
  <option value="Mayotte">Mayotte</option>
  <option value="Mexico">Mexico</option>
  <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
  <option value="Moldova, Republic of">Moldova, Republic of</option>
  <option value="Monaco">Monaco</option>
  <option value="Mongolia">Mongolia</option>
  <option value="Montserrat">Montserrat</option>
  <option value="Morocco">Morocco</option>
  <option value="Mozambique">Mozambique</option>
  <option value="Myanmar">Myanmar</option>
  <option value="Namibia">Namibia</option>
  <option value="Nauru">Nauru</option>
  <option value="Nepal">Nepal</option>
  <option value="Netherlands">Netherlands</option>
  <option value="Netherlands Antilles">Netherlands Antilles</option>
  <option value="New Caledonia">New Caledonia</option>
  <option value="New Zealand">New Zealand</option>
  <option value="Nicaragua">Nicaragua</option>
  <option value="Niger">Niger</option>
  <option value="Nigeria">Nigeria</option>
  <option value="Niue">Niue</option>
  <option value="Norfolk Island">Norfolk Island</option>
  <option value="Northern Mariana Islands">Northern Mariana Islands</option>
  <option value="Norway">Norway</option>
  <option value="Oman">Oman</option>
  <option value="Pakistan">Pakistan</option>
  <option value="Palau">Palau</option>
  <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
  <option value="Panama">Panama</option>
  <option value="Papua New Guinea">Papua New Guinea</option>
  <option value="Paraguay">Paraguay</option>
  <option value="Peru">Peru</option>
  <option value="Philippines">Philippines</option>
  <option value="Pitcairn">Pitcairn</option>
  <option value="Poland">Poland</option>
  <option value="Portugal">Portugal</option>
  <option value="Puerto Rico">Puerto Rico</option>
  <option value="Qatar">Qatar</option>
  <option value="Reunion">Reunion</option>
  <option value="Romania">Romania</option>
  <option value="Russian Federation">Russian Federation</option>
  <option value="Rwanda">Rwanda</option>
  <option value="Saint Helena">Saint Helena</option>
  <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
  <option value="Saint Lucia">Saint Lucia</option>
  <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
  <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
  <option value="Samoa">Samoa</option>
  <option value="San Marino">San Marino</option>
  <option value="Sao Tome and Principe">Sao Tome and Principe</option>
  <option value="Saudi Arabia">Saudi Arabia</option>
  <option value="Senegal">Senegal</option>
  <option value="Serbia and Montenegro">Serbia and Montenegro</option>
  <option value="Seychelles">Seychelles</option>
  <option value="Sierra Leone">Sierra Leone</option>
  <option value="Singapore">Singapore</option>
  <option value="Slovakia">Slovakia</option>
  <option value="Slovenia">Slovenia</option>
  <option value="Solomon Islands">Solomon Islands</option>
  <option value="Somalia">Somalia</option>
  <option value="South Africa">South Africa</option>
  <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
  <option value="Spain">Spain</option>
  <option value="Sri Lanka">Sri Lanka</option>
  <option value="Sudan">Sudan</option>
  <option value="Suriname">Suriname</option>
  <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
  <option value="Swaziland">Swaziland</option>
  <option value="Sweden">Sweden</option>
  <option value="Switzerland">Switzerland</option>
  <option value="Syrian Arab Republic">Syrian Arab Republic</option>
  <option value="Taiwan, Province of China">Taiwan, Province of China</option>
  <option value="Tajikistan">Tajikistan</option>
  <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
  <option value="Thailand">Thailand</option>
  <option value="Timor-leste">Timor-leste</option>
  <option value="Togo">Togo</option>
  <option value="Tokelau">Tokelau</option>
  <option value="Tonga">Tonga</option>
  <option value="Trinidad and Tobago">Trinidad and Tobago</option>
  <option value="Tunisia">Tunisia</option>
  <option value="Turkey">Turkey</option>
  <option value="Turkmenistan">Turkmenistan</option>
  <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
  <option value="Tuvalu">Tuvalu</option>
  <option value="Uganda">Uganda</option>
  <option value="Ukraine">Ukraine</option>
  <option value="United Arab Emirates">United Arab Emirates</option>
  <option value="United Kingdom">United Kingdom</option>
  <option value="United States">United States</option>
  <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
  <option value="Uruguay">Uruguay</option>
  <option value="Uzbekistan">Uzbekistan</option>
  <option value="Vanuatu">Vanuatu</option>
  <option value="Venezuela">Venezuela</option>
  <option value="Viet Nam">Viet Nam</option>
  <option value="Virgin Islands, British">Virgin Islands, British</option>
  <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
  <option value="Wallis and Futuna">Wallis and Futuna</option>
  <option value="Western Sahara">Western Sahara</option>
  <option value="Yemen">Yemen</option>
  <option value="Zambia">Zambia</option>
  <option value="Zimbabwe">Zimbabwe</option>
  </select>
</div>
</div>
<div class="form-group row">
<label for="streetname" style='text-align:right;' class="col-4 col-form-label">Street name*</label>
<div class="col-8">
<input id="streetname" name="streetname" placeholder="Street name" class="form-control"
 type="text" pattern="^[A-Za-z\s]+$" oninvalid="setCustomValidity('Only letters and spaces allowed.')" oninput="setCustomValidity('')" required/>
</div>
</div>
<div class="form-group row">
<label for="streetnumber" style='text-align:right;' class="col-4 col-form-label">Street number*</label>
<div class="col-8">
<input id="streetnumber" name="streetnumber" placeholder="Street number" class="form-control"
 type="text" pattern="[a-zA-Z0-9-\s]+" oninvalid="setCustomValidity('Only letters, numbers, spaces and dashes allowed.')"  oninput="setCustomValidity('')" required/>
</div>
</div>

<!-- closing COL-8 -->
</div>

<div class="col-md-6">
<div class="form-group row">
<label for="zipcode" style='text-align:right;' class="col-4 col-form-label">Zipcode*</label>
<div class="col-8">
<input id="zipcode" name="zipcode" placeholder="Zipcode" class="form-control"
type="text" pattern="^[a-zA-Z 0-9 ]*$" oninvalid="setCustomValidity('Only letters, numbers and spaces allowed.')" oninput="setCustomValidity('')" required/>
</div>
</div>
<div class="form-group row">
<label for="city" style='text-align:right;' class="col-4 col-form-label">City*</label>
<div class="col-8">
<input id="city" name="city" placeholder="City" class="form-control"
type="text" pattern="^[A-Za-z\s]+$" oninvalid="setCustomValidity('Only letters and spaces allowed.')" oninput="setCustomValidity('')" required/>
<div id="showInformationForPasswordDiv" style="text-align:center;">
	<div class="d-table-cell align-middle">
	<div id="length" class="glyphicon glyphicon-remove">Must be at least 6 to 40 characters</div>
<div id="upperCase" class="glyphicon glyphicon-remove">Must have atleast 1 upper case character</div>
<div id="lowerCase" class="glyphicon glyphicon-remove">Must have atleast 1 lower case character</div>
<div id="numbers" class="glyphicon glyphicon-remove">Must have atleast 1 numeric character</div>
<div id="symbols" class="glyphicon glyphicon-remove">Must have atleast 1 special character</div>
<div class="arrow-down"></div>
</div>
</div>
</div>
</div>
<div class="form-group row">
<label for="date" style='text-align:right;' class="col-4 col-form-label">Birth date</label>
<div class="col-8">
  <input id="date" type='text' name='date' data-date="" class='form-control' placeholder='"dd/mm/yyyy", "dd-mm-yyyy" or "dd.mm.yyyy"'
	pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d" oninvalid="setCustomValidity('This is not a valid date.')"
	oninput="setCustomValidity('')" autocomplete="off" />
</div>
</div>
<div class="form-group row">
<label for="phone" style='text-align:right;' class="col-4 col-form-label">Phone number*</label>
<div class="col-8">
<input type="text" id="phone" placeholder="Phone number" class="form-control" pattern="^[0-9 \\s-]+$" oninvalid="setCustomValidity('Only numbers, spaces and dashes.')"
   oninput="setCustomValidity('')" required/>
</div>
</div>
<div class="form-group row">
<label for="second-email" style='text-align:right;' class="col-4 col-form-label">Email*</label>
<div class="col-8">
<input id="second-email" name="email" placeholder="Email" class="form-control"
type="text" pattern="^[^(\.)][a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[aA-zZ]{2,5}" oninvalid="setCustomValidity('This is not a valid email.')"
oninput="setCustomValidity('')" required/>
</div>
</div>
<div class="form-group row">
<label for="passwordForRegistration" style='text-align:right;' class="col-4 col-form-label">Password*</label>
<div class="input-group col-8">
<input id="passwordForRegistration" name='new_password' placeholder='Password' class='form-control pwd' type='password'
pattern="((?=.*\d)(?=.*[A-Z])(?=.*\W).{6,40})" oninvalid="setCustomValidity('This is not a valid password.')" oninput="setCustomValidity('')"
required/>
<span class="input-group-btn">
  <button class="btn btn-default reveal" tabindex="-1" type="button"><i class="fas fa-eye change-eye"></i></button>
</span>
</div>
</div>
<div class="form-group row">
<div class="offset-4 col-8">
<input type="hidden" name="token" id="token" />
<button id="submitAccountRegister" type="submit" class="btn btn-block btn-primary" name='submit_register_account'>Make new account</button>
</div>
</div>
</form>
</div>
</div>

<div id="registerSpamMessage" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
	<h5 class="modal-title text-center col-12">Information
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	</h5>
</div>
<div class="modal-body text-center">
<p class="text-success" style="font-size:1.1rem;">You received an email. It could be possible this email will come inside your <span style="text-decoration:underline;">spam-box</span>.</p>
</div>
<div class="modal-footer">
<button id="modal-button" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<div class="container showForDynamicLogin" style="width:100%;margin-top:100px;display:none;">
	<div id='informationDivLogin'><i class='fas fa-info-circle' style='color:white;font-size:26px;margin-left:18px;'></i><h5 style='width:100%;font-size:1.35rem!important;'>Your are successfully logged in!</h5></div>
</div>
		<?php include 'layout_footer.php'; ?>
