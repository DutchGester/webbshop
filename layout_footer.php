</div>
<!-- /row -->

</div>
<!-- /container -->

<script>

$(document).on('click','.closeLabelText,.resetAllFiltersButton' ,function() {
   $('.loading-overlay').fadeIn("fast");
   $('.loading-overlay').fadeOut("fast");
});

//Media Querie
if (window.matchMedia('(max-width: 991.98px)').matches) {
  //Mobile

        // alert(11);
        $('#search').remove();
        $('.searchInputHeader').attr('id', 'search');

       $("#show_search").css('height', screen.height);

       $('.subnav')
       .css({cursor: "pointer"})
       .on('click', function(){
         $(this).find('.subnav-content').toggle();
         // $(this).find('.subnavbtn').css("background", "grey");
       });

       $('.subnav').hover(function () {
            $(this).find('.subnav-content').css("display", "none");
            $(this).find('.subnavbtn').css("background", "darkgrey");
        });




        $('.subnavbtn').click(function(){
            this.style.backgroundColor = this.style.backgroundColor == 'darkgrey' ? 'black' : 'darkgrey';
            $(this).find('.subnav-arrow').toggleClass("up down");
        });


        $("#loginMessageModal").on("shown.bs.modal", function(){
        // $('.navbar-collapse').collapse('hide');
        // $(".navbar").removeClass('bg-light');
        // $(".navbar").removeClass('bg-grey');
        // $(".navbar-toggler").css('position', 'inherit');
        // $(".containerDropdownTogglerMenu").toggleClass("bg-lightgrey");
        // $(".searchIconForMobile").hide();
        // $(".shopping-cart-header,#cart-count").hide();
        if ($("#myNavbar").is(":visible")) {
        // alert(1);
        // $(".containerDropdownTogglerMenu").css('padding-top', '0px');
        // $(".mobiletitleheader").css('padding-top', '11px');
        // $(".searchIconForMobile").show();
        // $(".shopping-cart-header,#cart-count").show();
        $(".hideCartForDesktop").css("pointer-events", "auto");
        } else {
        // alert(2);
        // $(".containerDropdownTogglerMenu").css('padding-top', '30px');
        // $(".mobiletitleheader").css('padding-top', '6px');
        $(".hideCartForDesktop").css("pointer-events", "none");
        }
        });

        //Toggle navbar toggler background dropdown menu with IF statement for if it is open or closed
        $(".navbar-toggler").click(function () {
          $(".welcome-user-arrow").removeClass('up');
          $(".welcome-user-arrow").addClass('down');

          $(".navbar-toggler").css('position', 'inherit');

          $(".searchIconForMobile").hide();
          $(".shopping-cart-header,#cart-count").hide();
          if ($("#myNavbar").is(":visible")) {
        // alert(1);
        $(".containerDropdownTogglerMenu").css('padding-top', '0px');
        $(".mobiletitleheader").css('padding-top', '6px');
        $(".searchIconForMobile").show();
        $(".shopping-cart-header,#cart-count").show();
          $(".hideCartForDesktop").css("pointer-events", "auto");




        if ($('.dropdown-menu-login').css('display') == 'block')
      {
        setTimeout(function() {
          // alert(2);
          $(".containerDropdownTogglerMenu").removeClass("bg-lightgrey");
      }, 250);
      } else {
        setTimeout(function() {
          // alert(2);
          $(".containerDropdownTogglerMenu").removeClass("bg-lightgrey");
      }, 150);
      }



          } else {
        // alert(2);
        $(".containerDropdownTogglerMenu").css('padding-top', '30px');
        $(".mobiletitleheader").css('padding-top', '13px');
         $(".hideCartForDesktop").css("pointer-events", "none");
         $(".containerDropdownTogglerMenu").addClass("bg-lightgrey");



          }
        });

// alert(18);
        // animations for header mobile
        $("#searchIconHeaderPress").click(function () {
        $(".hideCartForDesktop").css('position', 'relative');
        $(".navbar-toggler").css('position', 'relative');
        $(".hideCartForDesktop").animate({left: '100px'}, 300);
        $('.hideCartForDesktop').fadeOut(300);
        $(".navbar-toggler").animate({left: '-100px'}, 100);

        setTimeout(function() {
                $(".mobiletitleheader").fadeOut(150);
                $(".shopping-cart-header,#cart-count,.navbar-toggler").fadeOut(300);
                }, 0);
                $(".searchIconForMobile").css('display', 'none');
                  // $(".searchIconForMobile").css('margin-top', '-10px');
                $(".searchIconForMobile").animate({left: '-5px'}, 300);

                  $("#overlay").show(0);
                  $('.searchIconForMobile').fadeIn(300);
                  $('.crossInput').fadeIn(777);
                  $('.searchInputHeader').fadeIn(777);
                  $('.searchInputHeader').focus();

        });

        //Disable button searchIcon
        $('.searchInputHeader').focus(function(){
         $(".searchIconForMobile").css("pointer-events", "none");
        });


        $('#crossForInput').click(function(){
          //Enable button searchIcon
          $(".searchIconForMobile").css("pointer-events", "auto");
          $("#overlay").hide();
          $('.searchIconForMobile').fadeOut(300);
          $('.searchInputHeader').fadeOut(300);
          $('.crossInput').fadeOut(300);
          $('#show_search').hide();

          setTimeout(function() {
            $(".searchIconForMobile").animate({left: '284px'}, 300);
            $(".searchIconForMobile").fadeIn(0);
            $(".shopping-cart-header,#cart-count").fadeIn(100);
            $(".mobiletitleheader").fadeIn(715);

            $(".navbar-toggler").fadeIn(180);
            $(".navbar-toggler").animate({left: '1px'}, 100);

        $('.hideCartForDesktop').fadeIn(180);
            $(".hideCartForDesktop").animate({left: '0px'}, 100);

          }, 500);

        });

        $(".dropdown").css('padding-left', '0.5rem');
        $(".dropdown-menu").css('margin-left', '0.5rem');
        $(".dropdown-menu").css('margin-right', '0.5rem');
        $(".dropdown-menu-welcome").css('margin-right', '1rem');

    } else {
      //Desktop
        // alert(22);
        $('.subnavbtn').hover(function () {
        $(this).find('.subnav-arrow').toggleClass("up down");
        });
    }

// if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
//
//
// }

//change quantity plus/MINUS
$(".plus").click(function(){
$(".badge-primary").text(parseInt($('#cart-count').text()) +1);
});
$(".minus").click(function(){
$(".badge-primary").text(parseInt($('#cart-count').text()) -1);
});




//Only for loginheader password input
$(".reveal2").on('click',function() {
    var $pwd = $(".pwd2");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
        $('.change-eye2').addClass( "fa-eye-slash" );
        $('.change-eye2').removeClass( "fa-eye" );
    } else {
        $pwd.attr('type', 'password');
        $('.change-eye2').removeClass( "fa-eye-slash" );
        $('.change-eye2').addClass( "fa-eye" );
    }
});

$(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
        $('.change-eye').addClass( "fa-eye-slash" );
        $('.change-eye').removeClass( "fa-eye" );
    } else {
        $pwd.attr('type', 'password');
        $('.change-eye').removeClass( "fa-eye-slash" );
        $('.change-eye').addClass( "fa-eye" );
    }
});


//change arrow also when clicked HTML (account blue dropdown)
$('html').click(function() {
  var dropdownAccount = $(".welcomeText").attr("aria-expanded");
if(typeof dropdownAccount == 'undefined' || dropdownAccount == 'false') {
  // alert(33);
}
if(dropdownAccount == 'true') {1
  // alert(44);
  // $(document).on('click', '.accountOverviewGreyBackground', function (e) {
    // alert(55);
    $(".welcome-user-arrow").removeClass('up');
    $(".welcome-user-arrow").addClass('down');
  //   e.stopPropagation();
  //   // $(".welcome-user-arrow").removeClass('up');
  //   // $(".welcome-user-arrow").addClass('down');
  // });
  //
  // $(".accountOverviewGreyBackground").click(function(e) {
  //     e.preventDefault();
  //     if (!$(this).hasClass('className')) {
  //         alert("You did not click className!");
  //     }
  // });

  $(document).on('click', '.forArrow', function (e) {
    e.stopPropagation();
      if ($(this).hasClass('dropdown-header')) {
        //
      } else if($(this).hasClass('dropdown-item')) {
        $(".welcome-user-arrow").removeClass('up');
        $(".welcome-user-arrow").addClass('down');
      }
  });


}
});

// if on same page account is clicked inside menu
if (location.pathname == '/webshop/account-overview.php') {
  $('#accountClickMenu').click(function() {
    $('#account-div').show();
    $('#change-password-div').hide();
    $('#order-history-div').hide();
    $('#accountClick').addClass("active");
    $(".dropdown-menu-welcome").removeClass("show");
    $("#changepasswordClick").removeClass("active");
    $("#orderHistoryClick").removeClass("active");
    window.history.replaceState(null, null, 'account-overview.php?account');
    var url = 'account';
    // alert(url);
    history.pushState(null, null, 'account-overview.php?account');
  });
} else {
  $('#accountClickMenu').click(function() {
    location.href='https://www.gester.nl/webshop/account-overview.php?account';
  });
}

// if on same page Change password is clicked inside menu
if (location.pathname == '/webshop/account-overview.php') {
  $('#changePasswordClickMenu').click(function() {
    $('#account-div').hide();
    $('#change-password-div').show();
    $('#order-history-div').hide();
    $('#changepasswordClick').addClass("active");
    $(".dropdown-menu-welcome").removeClass("show");
    $("#accountClick").removeClass("active");
    $("#orderHistoryClick").removeClass("active");
    window.history.replaceState(null, null, 'account-overview.php?changepassword');
    var url = 'changepassword';
    // alert(url);
    history.pushState(null, null, 'account-overview.php?changepassword');
  });
} else {
  $('#changePasswordClickMenu').click(function() {
    location.href='https://www.gester.nl/webshop/account-overview.php?changepassword';
  });
}

// if on same page Change password is clicked inside menu
if (location.pathname == '/webshop/account-overview.php') {
  $('#checkOrderHistory').click(function() {
    $('#account-div').hide();
    $('#change-password-div').hide();
    $('#order-history-div').show();
    $('#orderHistoryClick').addClass("active");
    $("#accountClick").removeClass("active");
    $("#changepasswordClick").removeClass("active");
    $(".dropdown-menu-welcome").removeClass("show");
    $("#checkOrderHistory").removeClass("active");
    window.history.replaceState(null, null, 'account-overview.php?orderhistory');
    var url = 'orderhistory';
    // alert(url);
    history.pushState(null, null, 'account-overview.php?orderhistory');
  });
} else {
  $('#checkOrderHistory').click(function() {
    location.href='https://www.gester.nl/webshop/account-overview.php?orderhistory';
  });
}

//If account account is clicked
$('#accountClick').click(function() {
  $('#account-div').show();
  $('#change-password-div').hide();
  $('#order-history-div').hide();
  $(this).addClass("active");
  $("#changepasswordClick").removeClass("active");
  $("#orderHistoryClick").removeClass("active");
  window.history.replaceState(null, null, 'account-overview.php?account');
  var url = 'account';
  // alert(url);
  history.pushState(null, null, 'account-overview.php?account');
});


//If account changepassword is clicked
$('#changepasswordClick').click(function() {
  $('#account-div').hide();
  $('#change-password-div').show();
  $('#order-history-div').hide();
  $(this).addClass("active");
  $("#accountClick").removeClass("active");
  $("#orderHistoryClick").removeClass("active");
  window.history.replaceState(null, null, 'account-overview.php?changepassword');
  var url = 'changepassword';
  // alert(url);
  history.pushState(null, null, 'account-overview.php?changepassword');
});

//If account order-history is clicked
$('#orderHistoryClick').click(function() {
  $('#account-div').hide();
  $('#change-password-div').hide();
  $('#order-history-div').show();
  $(this).addClass("active");
  $("#accountClick").removeClass("active");
  $("#changepasswordClick").removeClass("active");
  window.history.replaceState(null, null, 'account-overview.php?orderhistory');
  var url = 'orderhistory';
  // alert(url);
history.pushState(null, null, 'account-overview.php?orderhistory');
});



//Change page on page load account-overview
if (window.location.href.indexOf('?account') > 0) {
  $('#account-div').show();
  $('#change-password-div').hide();
  $('#order-history-div').hide();
  $("#accountClick").addClass("active");
  $("#changepasswordClick").removeClass("active");
  $("#orderHistoryClick").removeClass("active");
}
if (window.location.href.indexOf('?changepassword') > 0) {
  $('#account-div').hide();
  $('#change-password-div').show();
  $('#order-history-div').hide();
  $("#changepasswordClick").addClass("active");
  $("#accountClick").removeClass("active");
  $("#orderHistoryClick").removeClass("active");
}
if (window.location.href.indexOf('?orderhistory') > 0) {
  $('#account-div').hide();
  $('#change-password-div').hide();
  $('#order-history-div').show();
  $("#orderHistoryClick").addClass("active");
  $("#accountClick").removeClass("active");
  $("#changepasswordClick").removeClass("active");
}

//Working dropdown-menu not closing only with clicking link
jQuery('.dropdown-togglez').on('click', function (e) {
  $(this).next().toggle();
});
jQuery('.dropdown-menu.keep-open').on('click', function (e) {
  e.stopPropagation();
});

//submit account and password register second part (CHECKOUT)
$(document).ready(function(){ $("#finishAccountForm").on("submit", function(e){
     e.preventDefault();
     var token = $('#token').val();
     var gender = $(".gender:checked").val();
     var firstname = $('#name').val();
     var lastname = $('#lastname').val();
     var country = $(".countrySelect").find("option:selected").text();
     var streetname = $('#streetname').val();
     var streetnumber = $('#streetnumber').val();
     var zipcode = $('#zipcode').val();
     var city = $('#city').val();
     var date = $('#date').val();
     var phone = $('#phone').val();
     var email = $('#email').val();

     $.ajax({
       url: "finish_account_checkout_ajax.php",
       type: "POST",
       data: { token: token, gender:gender,email: email,name:firstname,lastname:lastname,country:country,
              streetname:streetname,streetnumber:streetnumber,zipcode:zipcode,city:city,date:date,phone:phone },
              dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {
           $('#loadingDots').hide();
           $('.firstNameLastName,.streetNameStreetNumber,.zipcodeCity').show();
           if(gender == 'Male') {
             $('.firstNameLastName').text("Mr. "+firstname+" "+lastname);
           } else {
             $('.firstNameLastName').text("Miss. "+firstname+" "+lastname);
           }
           $('.streetNameStreetNumber').text(streetname+" "+streetnumber);
           $('.zipcodeCity').text(zipcode+" "+city);

           $('.finishAccountCheckout').hide();
           $(".place-order-button").css('display', 'flex');
         } else if(data.type == 'error') {
           $("#message2").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div>");
         }
       }
     });

   });
 });

//submit account and password register second part (CHECKOUT)
$(document).ready(function(){ $("#register_checkout_second_part").on("submit", function(e){
     e.preventDefault();
     var token = $('#token').val();
     var gender = $(".gender:checked").val();
     var firstname = $('#name').val();
     var lastname = $('#lastname').val();
     var country = $(".countrySelect").find("option:selected").text();
     var streetname = $('#streetname').val();
     var streetnumber = $('#streetnumber').val();
     var zipcode = $('#zipcode').val();
     var city = $('#city').val();
     var date = $('#date').val();
     var phone = $('#phone').val();
     var email = $('#second-email').val();
    var password = $('#passwordForRegistration').val();

     $.ajax({
       url: "register_account_and_password_checkout_ajax.php",
       type: "POST",
       data: { token: token, email: email,new_password: password,gender:gender,name:firstname,lastname:lastname,country:country,
              streetname:streetname,streetnumber:streetnumber,zipcode:zipcode,city:city,date:date,phone:phone },
              dataType: 'json',
       success: function (data) {


         if(data.type == 'success') {

           $("#dynamicAjaxLogin").html("<ul class='dropdown'><a class='welcome'><a class='badge badge-pill badge-primary welcomeText arrow-toggle' data-toggle='dropdown' align='center'>Welcome "+firstname+"&nbsp;<i class='welcome-user-arrow down'></i></a></a><li class='dropdown-menu dropdown-menu-welcome'><a class='dropdown-header accountOverviewGreyBackground forArrow' href='account-overview.php?account'><b>Account overview</b></a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?account'>Account</a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?changepassword'>Change password</a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?orderhistory'>Order history</a></li></ul>");

           $('#cart-count').text(data.text);

           $(".removeForDynamicLogin").hide();
           $(".showThisDynamicLogin").show();

           $('#informationDivCheckout').hide();
           $('.hideForDynamicOverflowForCheckOutRegistration').hide();
           $('.showForDynamicOverflowForCheckOutRegistration').show();

           $('.firstNameLastName,.streetNameStreetNumber,.zipcodeCity').show();
           if(gender == 'Male') {
             $('.firstNameLastName').text("Mr. "+firstname+" "+lastname);
           } else {
             $('.firstNameLastName').text("Miss. "+firstname+" "+lastname);
           }
           $('.streetNameStreetNumber').text(streetname+" "+streetnumber);
           $('.zipcodeCity').text(zipcode+" "+city);

           $(".place-order-button").css('display', 'flex');
           window.history.replaceState(null, null, 'checkout.php?checkout-registration=success');
           $('#registerSpamMessage').modal();
           $('.hideModalCloseButton').click(function() {
             $('.accountForRegister').hide();
           });
         } else if(data.type == 'error') {
           $("#message2").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div>");
         }
       }
     });

   });
 });

//submit email register first part (email) CHECKOUT
   $(document).ready(function(){ $("#register_checkout_first_part").on("submit", function(e){
     e.preventDefault();
     var token = $('#tokenRegisterCheckout').val();
     var email = $('#first-email').val();
     $.ajax({
       url: "register_email_ajax.php",
       type: "POST",
       data: { token: token, user_email: email },
       dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {
           $('.loginFormCheckout').css('display', '');
           $('.registerFormCheckout').css('display', '');
           $('.loginFormCheckout,.registerFormCheckout').hide();
           $('#informationDivCheckout').html("<i class='fas fa-info-circle' style='color:white;margin-top:-5px;font-size:23px;margin-left:16px;'></i><h4>Continue to register in the below form</h4>");
           $('.accountForRegister').show();
           $('#second-email').val($('#first-email').val());
           $('#token').remove();
         } else if(data.type == 'error') {
           $(".secondMessageCheckout").css('visibility', 'visible');
           $(".secondMessageCheckout").html("<div class='alert alert-danger resizeFont' style='text-align:center;padding:0.37rem 0.62rem;line-height: 1.6rem;'>"+data.text+"</div>");
         }

       }
     });
   });
   });

//submit login checkout
   $(document).ready(function(){ $("#loginFormCheckout").on("submit", function(e){
     e.preventDefault();
     var token = $('#token').val();
     var email = $('#loginEmail').val();
     var loginSubmit = $('#loginSubmitButton').val();
     var password = $('#loginPassword').val();
     $.ajax({
       url: "login_ajax.php",
       type: "POST",
       data: { user_email:email,login:loginSubmit,user_password:password,token:token},
       dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {
           values=data.text.split('||');
           firstname=values[0];
           cartNumber=values[1];
           lastname=values[2];
           streetname=values[3];
           streetnumber=values[4];
           zipcode=values[5];
           city=values[6];
           gender=values[7];

           $("#dynamicAjaxLogin").html("<ul class='dropdown'><a class='welcome'><a class='badge badge-pill badge-primary welcomeText arrow-toggle' data-toggle='dropdown' align='center'>Welcome "+firstname+"&nbsp;<i class='welcome-user-arrow down'></i></a></a><li class='dropdown-menu dropdown-menu-welcome'><a class='dropdown-header accountOverviewGreyBackground forArrow' href='account-overview.php?account'><b>Account overview</b></a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?account'>Account</a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?changepassword'>Change password</a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?orderhistory'>Order history</a></li></ul>");

           $('#cart-count').text(cartNumber);

           $(".removeForDynamicLogin").hide();
           $(".showThisDynamicLogin").show();

           $('.loginFormCheckout').css('display', '');
           $('.registerFormCheckout').css('display', '');
           $('.loginFormCheckout,.registerFormCheckout').hide();

           $(".removeForDynamicLogin").hide();
           $(".showThisDynamicLogin").show();

           $('#informationDivCheckout').hide();
           $('.hideForDynamicOverflowForCheckOutRegistration').hide();
           $('.showForDynamicOverflowForCheckOutRegistration').show();

           $('.firstNameLastName,.streetNameStreetNumber,.zipcodeCity').show();
           if(gender == 'Male') {
             $('.firstNameLastName').text("Mr. "+firstname+" "+lastname);
           } else {
             $('.firstNameLastName').text("Miss. "+firstname+" "+lastname);
           }
           $('.streetNameStreetNumber').text(streetname+" "+streetnumber);
           $('.zipcodeCity').text(zipcode+" "+city);

           $(".place-order-button").css('display', 'flex');
         } else if(data.type == 'error') {
           $(".message").html("<div class='alert alert-danger resizeFont' style='text-align:center;padding:0.37rem 0.62rem;line-height: 1.6rem;'>"+data.text+"</div>");
           $('.hideForOtherMessage').hide();
         }
       }
     });
   });
   });

//submit reset-password
   $(document).ready(function(){ $("#changepasswordAfterLoginForm").on("submit", function(e){
     e.preventDefault();
     var token = $('#tokenChangePasswordAfterLogin').val();
     var currentPassword = $('#current_password').val();
     var passwordOne = $('#new_password').val();
     var passwordTwo = $('#repeat_newpassword').val();

     $.ajax({
       url: "changepassword_ajax.php",
       type: "POST",
       data: { token:token,current_pass:currentPassword,new_pass:passwordOne,new_pass_c:passwordTwo },
       dataType: 'json',
       success: function (data) {
         if(data.type == 'success') {
           $('#changepasswordAccountSubmitButton').html(
      "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Laden..."
        );

           $("#message").html("<div class='alert alert-success resizeFont' style='text-align:center;'>Password is successfully changed</div><br>");
         } else if(data.type == 'error') {
           $("#message").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div><br>");
           if($("#message").text().length < 67) {
             $("#new_password").focusin(function() {
               $("#showInformationForPasswordDiv").css('margin-top', '138px');
             });
             $("#repeat_newpassword").focusin(function() {
               $("#showInformationForPasswordDiv2").css('margin-top', '193px');
             });
           } else {
             $("#new_password").focusin(function() {
               $("#showInformationForPasswordDiv").css('margin-top', '161px');
             });
             $("#repeat_newpassword").focusin(function() {
               $("#showInformationForPasswordDiv2").css('margin-top', '215.5px');
             });
           }
         }
       }
     });
   });
   });

//account when logged in account overview
   $(document).ready(function(){ $("#account-overview-account-form").on("submit", function(e){
     e.preventDefault();
     var token = $('#tokenAccount-account-overview').val();
     var gender = $(".gender:checked").val();
     var firstname = $('#name').val();
     var lastname = $('#lastname').val();
     var country = $(".countrySelect").find("option:selected").text();
     var streetname = $('#streetname').val();
     var streetnumber = $('#streetnumber').val();
     var zipcode = $('#zipcode').val();
     var city = $('#city').val();
     var date = $('#date').val();
     var phone = $('#phone').val();
     $.ajax({
       url: "account-overview_ajax.php",
       type: "POST",
       data: { token: token, gender:gender,name:firstname,lastname:lastname,country:country,
              streetname:streetname,streetnumber:streetnumber,zipcode:zipcode,city:city,date:date,phone:phone },
       dataType: 'json',
       success: function (data) {



         if(data.type == 'success') {

           $('#accountSubmitButton').html(
      "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Laden..."
        );

            if(firstname != data.text) {

              $(".welcomeText").html("Welcome "+firstname+"&nbsp;<i class='welcome-user-arrow down'></i>");
            }

           $("#message2").html("<div class='alert alert-success resizeFont' style='text-align:center;'>Your information is updated</div><br>");
         } else if(data.type == 'error') {
           $("#message2").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div><br>");
         }
       }
     });
   });
   });

//submit reset-password
   $(document).ready(function(){ $("#new-pass-form").on("submit", function(e){
     e.preventDefault();
//to get token parameter URL
     var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

     var token = $('#token').val();
     // var currentPassword = $('#current_password').val();
     var passwordOne = $('#new_pass1').val();
     var passwordTwo = $('#new_pass2').val();
     var submit = $('#newpassSubmitButton').val();

     $.ajax({
       url: "new-pass_ajax.php?token="+getUrlParameter('token'),
       type: "POST",
       data: { token:token,new_pass:passwordOne,new_pass_c:passwordTwo,newpassword:submit },
       dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {

           $('#newpassSubmitButton').html(
      "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Laden..."
        );
           window.location='products.php';
         } else if(data.type == 'error') {
           $("#message").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div>");
           $('.hideForOtherMessage').hide();
           //change margin-top password div for different input fields
          if($("#message").text().length < 67) {
            $("#new_pass1").focusin(function() {
              $("#showInformationForPasswordDiv").css('margin-top', '30.5px');
            });
            $("#new_pass2").focusin(function() {
              $("#showInformationForPasswordDiv2").css('margin-top', '116px');
            });
          } else {
            $("#new_pass1").focusin(function() {
              $("#showInformationForPasswordDiv").css('margin-top', '52px');
            });
            $("#new_pass2").focusin(function() {
              $("#showInformationForPasswordDiv2").css('margin-top', '137px');
            });
          }
         }
       }
     });
   });
   });

//submit reset-password pending again
   $(document).ready(function(){ $("#pending-form").on("submit", function(e){
     e.preventDefault();
     var token = $('#tokenPendingPage').val();
     var email = $('#email').val();
     $.ajax({
       url: "pending_ajax.php",
       type: "POST",
       data: { email:email,token:token},
       dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {

           $(".changeDynamicText").html("If your email is in our database you will receive an email <span style='text-decoration:underline'>again</span> on <b>"+email+"</b> to help you recover your account.<br> Didn't receive your email? Check your <b>spam-box</b>.<br> Please login into your email provider account and click on the link we sent to reset your password.");

         } else if(data.type == 'error') {
           $(document).ready(function(){ $('#pendingPageModal').modal('show'); });
           $(".showMessageModal").html(data.text);
           $('.redirectCloseButton').click(function() {
             window.location='reset-password.php';
           });
         }
       }
     });
   });
   });

//submit reset-password
   $(document).ready(function(){ $("#reset-password-form").on("submit", function(e){
     e.preventDefault();
     var token = $('#token').val();
     var email = $('#email').val();
     $.ajax({
       url: "reset-password-ajax.php",
       type: "POST",
       data: { email:email,token:token},
       dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {
           $('#reset-password-button').html(
      "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Laden..."
        );
           // window.location='pending.php?email='+email;
           $(".hideForDynamicPending").hide();
           $("#pageTitle").html("<b>Password reset</b>");
           $("#insertUsersEmail").text(email);
           $("#pending-form").show();

         } else if(data.type == 'error') {
           $("#message").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div>");
            $('.hideForOtherMessage').hide();
         }
       }
     });
   });
   });

//submit login navigation header
   $(document).ready(function(){ $("#loginFormHeader").on("submit", function(e){
     e.preventDefault();
     var token = $('#tokenLoginHeader').val();
     var email = $('#loginEmailHeader').val();
     var loginSubmit = $('#loginSubmitButtonHeader').val();
     var password = $('#loginPasswordHeader').val();
     $.ajax({
       url: "login_ajax.php",
       type: "POST",
       data: { user_email:email,login:loginSubmit,user_password:password,token:token},
       dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {

           // alert(1);

           $('#loginSubmitButtonHeader').html(
      "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Laden..."
        );

           values=data.text.split('||');
           firstname=values[0];
           cartNumber=values[1];

           $("#dynamicAjaxLogin").html("<ul class='dropdown'><a class='welcome'><a class='badge badge-pill badge-primary welcomeText arrow-toggle' data-toggle='dropdown' align='center'>Welcome "+firstname+"&nbsp;<i class='welcome-user-arrow down'></i></a></a><li class='dropdown-menu dropdown-menu-welcome'><a class='dropdown-header accountOverviewGreyBackground forArrow' href='account-overview.php?account'><b>Account overview</b></a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?account'>Account</a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?changepassword'>Change password</a><div class='dropdown-divider'></div><a class='dropdown-item forArrow' href='account-overview.php?orderhistory'>Order history</a></li></ul>");

           $('.badge').click(function(){
           $(this).children('i').toggleClass('down up');
           });

           $('#cart-count').text(cartNumber);

           $(".removeForDynamicLogin").hide();
           $(".showThisDynamicLogin").show();

           var pageName = $('#pageName').attr('value');

           if(pageName == 'login.php' || pageName == 'register.php') {
             $(".hideForDynamicLogin").hide();
             $("#pageTitle").hide();
             $(".showForDynamicLogin").show();
           }

           $(".dropdown").css('padding-left', '0.5rem');
           $(".dropdown-menu").css('margin-left', '0.5rem');
           $(".dropdown-menu").css('margin-right', '0.5rem');
           $(".dropdown-menu-welcome").css('margin-right', '1rem');




         } else if(data.type == 'error') {
           $(document).ready(function(){ $('#loginMessageModal').modal('show'); });
           $(".showMessageModal").html(data.text);
         }
       }
     });
   });
   });

//submit login
   $(document).ready(function(){ $("#loginForm").on("submit", function(e){
     e.preventDefault();
     var token = $('#token').val();
     var email = $('#loginEmail').val();
     var loginSubmit = $('#loginSubmitButton').val();
     var password = $('#loginPassword').val();
     $.ajax({
       url: "login_ajax.php",
       type: "POST",
       data: { user_email:email,login:loginSubmit,user_password:password,token:token},
       dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {
           $('#loginSubmitButton').html(
      "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Laden..."
        );
           window.location='products.php';
         } else if(data.type == 'error') {
           $("#message").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div>");
           $('.hideForOtherMessage').hide();
         }
       }
     });
   });
   });

//submit account and password register second part (account)
$(document).ready(function(){ $("#register_second_part").on("submit", function(e){
     e.preventDefault();
     var token = $('#token').val();
     var gender = $(".gender:checked").val();
     var firstname = $('#name').val();
     var lastname = $('#lastname').val();
     var country = $(".countrySelect").find("option:selected").text();
     var streetname = $('#streetname').val();
     var streetnumber = $('#streetnumber').val();
     var zipcode = $('#zipcode').val();
     var city = $('#city').val();
     var date = $('#date').val();
     var phone = $('#phone').val();
     var email = $('#second-email').val();
    var password = $('#passwordForRegistration').val();

     $.ajax({
       url: "register_account_and_password_ajax.php",
       type: "POST",
       data: { token: token, email: email,new_password: password,gender:gender,name:firstname,lastname:lastname,country:country,
              streetname:streetname,streetnumber:streetnumber,zipcode:zipcode,city:city,date:date,phone:phone },
              dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {
           $('#registerSpamMessage').modal();
           $('#registerSpamMessage').on('hidden.bs.modal', function () {
             $('#submitAccountRegister').html(
        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Laden..."
          );
             window.location='products.php';
          });
         } else if(data.type == 'error') {
           $("#message2").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div>");
         }
       }
     });

   });
 });

//submit email register first part (email)
   $(document).ready(function(){ $("#register_first_part").on("submit", function(e){
     e.preventDefault();
     var token = $('#token').val();
     var email = $('#first-email').val();
     $.ajax({
       url: "register_email_ajax.php",
       type: "POST",
       data: { token: token, user_email: email },
       dataType: 'json',
       success: function (data) {

         if(data.type == 'success') {
           $('#submitEmailRegister').html(
      "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Laden..."
        );
           $('.containerResize').hide();
           $('.accountForRegister').show();
           $('#second-email').val($('#first-email').val());
           $('#token').remove();
         } else if(data.type == 'error') {
           $("#message").html("<div class='alert alert-danger resizeFont' style='text-align:center;'>"+data.text+"</div>");
         }

       }
     });
   });
   });


/*Actual validation function*/
function ValidatePassword() {
  /*Array of rules and the information target*/
  var rules = [{
      Pattern: "[A-Z]",
      Target: "upperCase"
    },
    {
      Pattern: "[a-z]",
      Target: "lowerCase"
    },
    {
      Pattern: "[0-9]",
      Target: "numbers"
    },
    {
      Pattern: "[!@@#$%^&*]",
      Target: "symbols"
    }
  ];

  //Just grab the password once
  var password = $(this).val();

  /*Length Check, add and remove class could be chained*/
  /*I've left them seperate here so you can see what is going on */
  /*Note the Ternary operators ? : to select the classes*/
  $("#length").removeClass(password.length > 5 && password.length < 41 ? "glyphicon-remove" : "glyphicon-ok");
  $("#length").addClass(password.length > 5 && password.length < 41 ? "glyphicon-ok" : "glyphicon-remove");

  /*Iterate our remaining rules. The logic is the same as for Length*/
  for (var i = 0; i < rules.length; i++) {

    $("#" + rules[i].Target).removeClass(new RegExp(rules[i].Pattern).test(password) ? "glyphicon-remove" : "glyphicon-ok");
    $("#" + rules[i].Target).addClass(new RegExp(rules[i].Pattern).test(password) ? "glyphicon-ok" : "glyphicon-remove");
}

// if ( $("#length").hasClass("glyphicon-ok") && $("#upperCase").hasClass("glyphicon-ok") & $("#lowerCase").hasClass("glyphicon-ok") &&
// $("#numbers").hasClass("glyphicon-ok") && $("#symbols").hasClass("glyphicon-ok") ) {
// $("#submitAccountRegister").prop("disabled",false);
// } else {
//   $("#submitAccountRegister").prop("disabled",true);
// }

}

/*Actual validation function*/
function ValidatePassword2() {
  /*Array of rules and the information target*/
  var rules = [{
      Pattern: "[A-Z]",
      Target: "upperCase2"
    },
    {
      Pattern: "[a-z]",
      Target: "lowerCase2"
    },
    {
      Pattern: "[0-9]",
      Target: "numbers2"
    },
    {
      Pattern: "[!@@#$%^&*]",
      Target: "symbols2"
    }
  ];

  //Just grab the password once
  var password = $(this).val();

  /*Length Check, add and remove class could be chained*/
  /*I've left them seperate here so you can see what is going on */
  /*Note the Ternary operators ? : to select the classes*/
  $("#length2").removeClass(password.length > 5 && password.length < 41 ? "glyphicon-remove2" : "glyphicon-ok2");
  $("#length2").addClass(password.length > 5 && password.length < 41 ? "glyphicon-ok2" : "glyphicon-remove2");

  /*Iterate our remaining rules. The logic is the same as for Length*/
  for (var i = 0; i < rules.length; i++) {

    $("#" + rules[i].Target).removeClass(new RegExp(rules[i].Pattern).test(password) ? "glyphicon-remove2" : "glyphicon-ok2");
    $("#" + rules[i].Target).addClass(new RegExp(rules[i].Pattern).test(password) ? "glyphicon-ok2" : "glyphicon-remove2");
}

// if ( $("#length").hasClass("glyphicon-ok") && $("#upperCase").hasClass("glyphicon-ok") & $("#lowerCase").hasClass("glyphicon-ok") &&
// $("#numbers").hasClass("glyphicon-ok") && $("#symbols").hasClass("glyphicon-ok") ) {
// $("#submitAccountRegister").prop("disabled",false);
// } else {
//   $("#submitAccountRegister").prop("disabled",true);
// }

}

    /*Bind our event to key up for the field. It doesn't matter if it's delete or not*/
    $(document).ready(function() {
      $("#passwordForRegistration, #new_pass1,#new_password").on('keyup', ValidatePassword);
      $("#new_pass2,#repeat_newpassword").on('keyup', ValidatePassword2);
    });

//Open div when focus inside password input
$(document).ready(function() {
  $("#passwordForRegistration, #new_pass1, #new_password").focus(function() {
    $("#showInformationForPasswordDiv").css('display', 'table');
  });
  $("#new_pass2, #repeat_newpassword").focus(function() {
    $("#showInformationForPasswordDiv2").css('display', 'table');
  });
});

$(document).ready(function() {
   $("#passwordForRegistration, #new_pass1, #new_password").focusin(function() {
       $("#showInformationForPasswordDiv").css('display', 'table');
   }).focusout(function () {
       $("#showInformationForPasswordDiv").css('display', 'none');
   });
   $("#new_pass2,#repeat_newpassword").focusin(function() {
       $("#showInformationForPasswordDiv2").css('display', 'table');
   }).focusout(function () {
       $("#showInformationForPasswordDiv2").css('display', 'none');
   });
});

//change margin-top password div for different input fields
// $(document).ready(function() {
//   $("#new_pass1").focusin(function() {
//     $("#showInformationForPasswordDiv").css('margin-top', '-35.5px');
//   });
//   $("#new_pass2").focusin(function() {
//     $("#showInformationForPasswordDiv2").css('margin-top', '51px');
//   });
// });


// //hide recaptcha function
// function hideRecaptcha() {
//  const recaptcha = $(".grecaptcha-badge");
//  if (recaptcha.length) return recaptcha.css({ display: "none" });
//  requestAnimationFrame(() => this.hideRecaptcha());
// }
//
// //show on pageName names
// $(document).ready(function(){
//  var pageName = $('#pageName').attr('value');
//  if(pageName !== 'register.php' || pageName !== 'login.php') {
//    hideRecaptcha();
//  }
// });

// $(document).ready(function(){
// grecaptcha.ready(function() {
//     grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'homepage'}).then(function(token) {
//       $('#token').val(token);
//       $('#tokenLoginHeader').val(token);
//       $('#tokenPendingPage').val(token);
//       $('#tokenAccount-account-overview').val(token);
//       $('#tokenChangePasswordAfterLogin').val(token);
//     });
// });
// });

$(document).ready(function(){ $(".recaptcha_form").on("submit", function(e){
     e.preventDefault();
     console.log('blehz');
//recaptcha token code
  grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'homepage'}).then(function(token) {
        $('#token').val(token);

        $('#tokenPendingPage').val(token);
        $('#tokenAccount-account-overview').val(token);
        $('#tokenChangePasswordAfterLogin').val(token);
        $('#tokenRegisterCheckout').val(token);
      });
  });
});
});

$(document).ready(function(){ $(".recaptcha_form").on("submit", function(e){
     e.preventDefault();
     console.log('blahz');
//recaptcha token code
  grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'homepage'}).then(function(token) {
$('#tokenLoginHeader').val(token);
      });
  });
});
});



function loadCaptcha() {
  grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'homepage'}).then(function(token) {
        $('#token').val(token);
        $('#tokenLoginHeader').val(token);
        $('#tokenPendingPage').val(token);
        $('#tokenAccount-account-overview').val(token);
        $('#tokenChangePasswordAfterLogin').val(token);
        $('#tokenRegisterCheckout').val(token);
      });
  });
}

function loadCaptcha2() {
  grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'homepage'}).then(function(token) {
        $('#tokenLoginHeader').val(token);
      });
  });
}

// Refresh token recaptcha every 3 seconds
$(document).ready(function() {
  console.log('qqq');
  loadCaptcha();
  setTimeout(function() {
    loadCaptcha();
    setInterval(loadCaptcha, 105 * 1000); // fire every 10 sec
  }, 90 * 1000); // fire only one time after 10 sec
});

// Refresh token recaptcha every 3 seconds
$(document).ready(function() {
  console.log('xxx');
  loadCaptcha2();
  setTimeout(function() {
    loadCaptcha2();
    setInterval(loadCaptcha, 105 * 1000); // fire every 10 sec
  }, 90 * 1000); // fire only one time after 10 sec
});

$('select').selectpicker();

$(document).ready(function() {

  if ( !$(".account-for-checkout input").is(':checked') )  {
    $( "<style>.forBorder:after { content: '';display: block;width: 100%;height: 1px;border-bottom: 1.2px solid #DC143C;margin-top: 5px; }</style>" ).appendTo("head");
  }

  $('.account-for-checkout input[type=radio][name=gender]').change(function() {
    if ( !$(".account-for-checkout input").is(':checked') )  {
      $( "<style>.forBorder:after { content: '';display: block;width: 100%;height: 1px;border-bottom: 1.2px solid #DC143C;margin-top: 5px; }</style>" ).appendTo("head");
    } else {
      $( "<style>.forBorder:after { border-bottom: 0px; }</style>" ).appendTo("head");
    }
});

  //Change input borders and shadow when INPUT is empty
 $(".account-for-checkout input:not(input[type='search']):not([type='radio'])").each(function(){
   if ($(this).val().trim() == '') {
     $(this).css('border', '1.2px solid #DC143C');

     $(this).on('focus', function(){
     $(this).css('box-shadow', '0 0 0 0.2rem #f5c6cb');
      });
      $(this).focusout(function(){
          $(this).css('box-shadow', 'none');
      });
   }
 });

var selectedText = $(this).find("option:selected").text();
//If select show red border if Option is not chosen
 if (selectedText == 'Select Country') {
    $(".account-for-checkout .btn-light").css('border', '1.2px solid #DC143C');
}

//Change border and shadow while typing inside INPUT field
$('.account-for-checkout input:not(input[type="search"]):not([type="radio"])').on('input', function() {
  if($(this).val().length > 0) {
  $(this).css('box-shadow', '0 0 0 0.2rem rgba(0, 123, 255, 0.25');
      $(this).css('border', '1px solid #ced4da');
} else {
  $(this).css('border', '1.2px solid #DC143C');
$(this).css('box-shadow', '0 0 0 0.2rem #f5c6cb');
}
});

//Change border on CHANGE from red to basic
$('.countrySelect').on('change', function() {
  var selectedText = $(this).find("option:selected").text();
  if (selectedText !== 'Select Country') {
$(".account-for-checkout .btn-light").css('border', '1px solid #ced4da');
} else {
  $(".account-for-checkout .btn-light").css('border', '1.2px solid #DC143C');
}
  });
});


// $(document).ready(function() {
//       alert("document ready occurred!");
// });
//
// $(window).on('load', function () {
//       alert("window load occurred!");
// });

$(document).ready(function() {
$("b[role='presentation']").addClass('down');

$('#select2-sortBy-container').click(function() {
$("b[role='presentation']").toggleClass("down up");
});
});


//Change sorting icon next to #sortBy
$(document).ready(function() {
$('#sortBy').change(function() {
  //change icon next to SortBy dropdown select
  if ($(this).val().includes('DESC')) {
$(".fa-sort-amount-up").attr('class', 'fa-sort-amount-down');
  } else {
    $(".fa-sort-amount-down").attr('class', 'fa-sort-amount-up');
  }
});
});

// $(document).ready(function() {
//   $('#sortBy').niceSelect();
// });



//       // Show loading overlay when ajax request starts
//       $( document ).ajaxStart(function() {
//         if($("#keywords").val().length > 0) {
//       $('.loading-overlay').fadeIn("fast");
//         // $('.loading-overlay').show();
//       }
//       });
//
//       // Hide loading overlay when ajax request completes
//       $( document ).ajaxStop(function() {
//             if($("#keywords").val().length > 0) {
//       // $('.loading-overlay').fadeOut("fast");
//         // $('.loading-overlay').hide();
//         //fadeOut overlay and change showing results Info
//
//     setTimeout(function() { $('.loading-overlay').fadeOut("fast"); }, 0);
//
//   }
// });



// $(document).ready(function(){
// $('#keywords').keyup(function(){
// if($(this).val() !== ''){
// alert(1);
// }
// });
// });

//change URL if #sortBy
$(document).ready(function() {
$('#sortBy').change(function() {
  var keywords = $('#keywords').val();
  var currentPagenumber = currentPagenumber ? $('.active .page-link').text() : 1;
  var sortName = $(this).find('option:selected').attr("name");
  var sorting = "?page="+currentPagenumber+"&sort="+sortName;
 if (window.location.href.indexOf('&searchText=') > 0) {
   window.history.replaceState(null, null, 'products.php'+sorting+"&searchText="+keywords);
 } else {
   window.history.replaceState(null, null, 'products.php'+sorting);
 }
});
});

//If clicked on FIRSt or LAST pagination search page number
$(document).ready(function() {
$('.page-link').click(function() {
  var keywords = $('#keywords').val();
  var clickedPagenumber = $(this).text();
  var patternSearchWord = /First/;
  var doesWordExists = patternSearchWord.test(clickedPagenumber);
if (doesWordExists) {
  clickedPagenumber = 1;
}
var patternSearchWord = /Last/;
var doesWordExists = patternSearchWord.test(clickedPagenumber);
if (doesWordExists) {

var totalProducts = "<?php echo isset($rowCount) ? $rowCount : '' ?>";
var limitPerPage = "<?php echo isset($limit) ? $limit : '' ?>";
var lastPageNumber = totalProducts / limitPerPage;
clickedPagenumber = Math.ceil(lastPageNumber);
}
  var sortName = $('#sortBy').find('option:selected').attr("name");
  var sorting = "?page="+clickedPagenumber+"&sort="+sortName;
if($(this).closest(".active").length>0) {
  return false;
} else {
    if (window.location.href.indexOf('&searchText=') == -1 && window.location.href.indexOf('&sort=') == -1) {
    window.history.replaceState(null, null, 'products.php?page='+clickedPagenumber);
    }
    }
  });
});

$(document).ready(function() {
//Stop the loadingOverlay after user stopped typing 1300 milsecs
jQuery(function ($) {
//to store the reference to the timer
var timer;
$('#keywords').keyup(function (evt) {
//clear the previous timer
clearTimeout(timer);
var keycode = evt.charCode || evt.keyCode;
//If not hitting backspace
if (keycode !== 8) {
  //create a new timer with a delay of 2 seconds, if the keyup is fired before the 2 secs then the timer will be cleared
timer = setTimeout(function () {
  //this will be executed if there is a gap of 2 seconds between 2 keyup events
  console.log('last')
  setTimeout(function() { $('.loading-overlay').fadeOut("fast"); }, 0);
}, 550);
}


//If hitting backspace don't show overlay
if (keycode === 8) {
timer = setTimeout(function () {
  $('.loading-overlay').hide();
}, 0);
}
});
});
});

$(document).ready(function() {
//if no results found
var keywords = $('#keywords').val();
$('#keywords-result').html("<b style='font-size:30px;'>"+keywords+"</b>");
});

//searchFilter function for #keywords
function searchFilter(page_num) {
  page_num = page_num?page_num:0;
  var keywords = $('#keywords').val();
  var sortBy = $('#sortBy').val();
  $.ajax({
    type: 'POST',
    url: 'getData.php',
    data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
    beforeSend: function () {

    },
    success: function (html) {
            $('#postContent').html(html);


    $('#keywords-result').html("<b style='font-size:30px;'>"+keywords+"</b>");

//If clicked on search label close
$('.labelTextFromSearch a').click(function() {
  var sortName = $('#sortBy').find('option:selected').attr("name");
  var sorting = "?page=1&sort="+sortName;
      $.ajax({
        type: 'POST',
        url: 'getData.php',
        success: function (html) {

          $('.labelTextFromSearch').css({"display":"none"});
          $('.resetAllFilters').css({"display":"none"});
          $('#keywords').val("");
          searchFilter(0);
          if (window.location.href.indexOf('&sort=') > 0) {
          window.history.replaceState(null, null, 'products.php'+sorting);
        } else {
          window.history.replaceState(null, null, 'products.php?page=1');
        }

        }
      });
      });

      //If clicked on .resetAllFilters
      $('.resetAllFilters a').click(function() {
        var sortBy = $('#sortBy').val("id|ASC");
            $.ajax({
              type: 'POST',
              url: 'getData.php',
              data:'&sortBy='+sortBy,
              success: function (html) {
                $('.labelTextFromSearch').css({"display":"none"});
                $('.resetAllFilters').css({"display":"none"});
                $('#keywords').val("");
                $("#sortBy").val('id|ASC').trigger('change')
                searchFilter(0);
                window.history.replaceState(null, null, 'products.php');
              }
            });
            });

      //If clicked on FIRSt or LAST pagination search page number
      $('.page-link').click(function() {
        var keywords = $('#keywords').val();
        var clickedPagenumber = $(this).text();
        var patternSearchWord = /First/;
        var doesWordExists = patternSearchWord.test(clickedPagenumber);
      if (doesWordExists) {
        clickedPagenumber = 1;
      }
      var patternSearchWord = /Last/;
      var doesWordExists = patternSearchWord.test(clickedPagenumber);
    if (doesWordExists) {
      var totalProducts = "<?php echo isset($rowCount) ? $rowCount : '' ?>";
      var limitPerPage = "<?php echo isset($limit) ? $limit : '' ?>";
      var lastPageNumber = totalProducts / limitPerPage;
      clickedPagenumber = Math.ceil(lastPageNumber);
    }
        var sortName = $('#sortBy').find('option:selected').attr("name");
        var sorting = "?page="+clickedPagenumber+"&sort="+sortName;
      if($(this).closest(".active").length>0) {
        return false;
      } else {
         if (window.location.href.indexOf('&searchText=') > 0 && window.location.href.indexOf('&sort=') > 0) {
        window.history.replaceState(null, null, 'products.php'+sorting+"&searchText="+keywords);
      } else if (window.location.href.indexOf('&searchText=') > 0) {
       window.history.replaceState(null, null, 'products.php?page='+clickedPagenumber+"&searchText="+keywords);
      } else if (window.location.href.indexOf('&sort=') > 0) {
       window.history.replaceState(null, null, 'products.php'+sorting);
      }
      if (window.location.href.indexOf('&searchText=') == -1 && window.location.href.indexOf('&sort=') == -1) {
      window.history.replaceState(null, null, 'products.php?page='+clickedPagenumber);
          }
        }
      });

      //Duplicate of add_to_cart code for when typing inside search
      $(".add_to_cart").click(function(e){
        //OPEN MODAL
        $(document).ready(function(){ $('#addedToCartModal').modal({backdrop: 'static', keyboard: false}) });
          e.preventDefault();
     var id = $(this).data('id');
     var pagenum = $(".page-number").val();

     //change button style after click
     var button = $('.change-style-after-click[data-id="' + id + '"] .btn')
     button.addClass("btn-success").text("Update Quantity");

     $.ajax({
       url: "add_to_cart.php",
       type: "GET", //send it through get method
       data: {
         id: id,
         page: pagenum,
       },
       success: function(response) {


         $('#cart-count,#added-to-cart-cart-count').text(response);


          var cart_count = $('#added-to-cart-cart-count').text();
          console.log(cart_count);
    if(cart_count < 10)
    {
    $('#added-to-cart-cart-count').css({"padding":".45em .7em"});
  } else {
     $('#added-to-cart-cart-count').css({"padding":".45em .5em"});
  }
       },
       error: function(xhr) {
         //Do Something to handle error
       }
     });

      });

      //Put keywords inside label or else hide when no letters
      if($("#keywords").val().length > 0) {
        //change Showing info top after keyup
        $('.showingResultsInformation').css({"top":"60px"});

      $('.labelTextFromSearchSpan').html("Text: <b>"+keywords+"</b>");
    } else {
      $('.labelTextFromSearch').css({"display":"none"});
      $('.resetAllFilters').css({"display":"none"});
    }
    //move Reset all filters to the right depends on key words

      // $("#keywords").keypress(function () {
      if($("#keywords").val().length == 3) {
        $(".resetAllFilters").animate({left: "+=8"}, 0);
      }
      if($("#keywords").val().length == 4) {
        $(".resetAllFilters").animate({left: "+=16"}, 0);
      }
      if($("#keywords").val().length == 5) {
        $(".resetAllFilters").animate({left: "+=24"}, 0);
      }
      if($("#keywords").val().length == 6) {
        $(".resetAllFilters").animate({left: "+=32"}, 0);
      }
      if($("#keywords").val().length == 7) {
        $(".resetAllFilters").animate({left: "+=40"}, 0);
      }
      if($("#keywords").val().length == 8) {
        $(".resetAllFilters").animate({left: "+=48"}, 0);
      }
      if($("#keywords").val().length == 9) {
        $(".resetAllFilters").animate({left: "+=56"}, 0);
      }
      if($("#keywords").val().length == 10) {
        $(".resetAllFilters").animate({left: "+=64"}, 0);
      }
      if($("#keywords").val().length == 11) {
        $(".resetAllFilters").animate({left: "+=72"}, 0);
      }
      if($("#keywords").val().length == 12) {
        $(".resetAllFilters").animate({left: "+=80"}, 0);
      }
      if($("#keywords").val().length == 13) {
        $(".resetAllFilters").animate({left: "+=88"}, 0);
      }
      if($("#keywords").val().length == 14) {
        $(".resetAllFilters").animate({left: "+=96"}, 0);
      }
      if($("#keywords").val().length == 15) {
        $(".resetAllFilters").animate({left: "+=104"}, 0);
      }
      if($("#keywords").val().length == 16) {
        $(".resetAllFilters").animate({left: "+=112"}, 0);
      }
      if($("#keywords").val().length == 17) {
        $(".resetAllFilters").animate({left: "+=120"}, 0);
      }
      if($("#keywords").val().length == 18) {
        $(".resetAllFilters").animate({left: "+=128"}, 0);
      }
      if($("#keywords").val().length == 19) {
        $(".resetAllFilters").animate({left: "+=136"}, 0);
      }
      if($("#keywords").val().length == 20) {
        $(".resetAllFilters").animate({left: "+=144"}, 0);
      }
      if($("#keywords").val().length == 21) {
        $(".resetAllFilters").animate({left: "+=152"}, 0);
      }
      if($("#keywords").val().length == 22) {
        $(".resetAllFilters").animate({left: "+=160"}, 0);
      }
      if($("#keywords").val().length == 23) {
        $(".resetAllFilters").animate({left: "+=168"}, 0);
      }
      if($("#keywords").val().length == 24) {
        $(".resetAllFilters").animate({left: "+=176"}, 0);
      }
      if($("#keywords").val().length == 25) {
        $(".resetAllFilters").animate({left: "+=184"}, 0);
      }
      if($("#keywords").val().length == 26) {
        $(".resetAllFilters").animate({left: "+=192"}, 0);
      }
      if($("#keywords").val().length == 27) {
        $(".resetAllFilters").animate({left: "+=200"}, 0);
      }
      if($("#keywords").val().length == 28) {
        $(".resetAllFilters").animate({left: "+=208"}, 0);
      }
      if($("#keywords").val().length == 29) {
        $(".resetAllFilters").animate({left: "+=216"}, 0);
      }
      if($("#keywords").val().length == 30) {
        $(".resetAllFilters").animate({left: "+=222"}, 0);
      }
      if($("#keywords").val().length == 31) {
        $(".resetAllFilters").animate({left: "+=230"}, 0);
      }
      if($("#keywords").val().length == 32) {
        $(".resetAllFilters").animate({left: "+=238"}, 0);
      }
      if($("#keywords").val().length == 33) {
        $(".resetAllFilters").animate({left: "+=246"}, 0);
      }
      if($("#keywords").val().length == 34) {
        $(".resetAllFilters").animate({left: "+=254"}, 0);
      }
      if($("#keywords").val().length == 35) {
        $(".resetAllFilters").animate({left: "+=262"}, 0);
      }
      if($("#keywords").val().length == 36) {
        $(".resetAllFilters").animate({left: "+=270"}, 0);
      }
      if($("#keywords").val().length == 37) {
        $(".resetAllFilters").animate({left: "+=278"}, 0);
      }
      if($("#keywords").val().length == 38) {
        $(".resetAllFilters").animate({left: "+=286"}, 0);
      }
      if($("#keywords").val().length == 39) {
        $(".resetAllFilters").animate({left: "+=294"}, 0);
      }
      if($("#keywords").val().length == 40) {
        $(".resetAllFilters").animate({left: "+=302"}, 0);
        $(document).ready(function(){ $('#limitInputWords').modal({})});
      }
        // });
    }
  });
}

// //Needed to do this because i couldnt activate this effect with above and below code on if 1 letter goes to backspace to 0 letters
// $(document).ready(function(){
// $("#keywords").keydown(function (evt) {
//   var keycode = evt.charCode || evt.keyCode;
//   if (keycode == 8) {
// if($("#keywords").val().length == 1) {
// $('.loading-overlay').fadeIn("fast");
// $('.loading-overlay').fadeOut("fast");
//     }
// //     if($("#keywords").val().length == 0) {
// // $('.loading-overlay').fadeOut("fast");
// //     }
//   }
// });
// });

//Block these keys also on keydown
$(document).ready(function(){
$("#keywords").keydown(function (evt) {
      var keycode = evt.charCode || evt.keyCode;
      // disabling all the keys except the letters
  if (keycode == 18 || keycode == 17 || keycode == 9 || keycode == 16 || keycode == 13 || keycode == 20 ||
    keycode == 27 || keycode == 91 || keycode == 93 || keycode == 37 || keycode == 38 || keycode == 39 || keycode == 40 ||
    keycode >= 48 && keycode <= 57 || keycode == 35 || keycode == 34 || keycode == 35 || keycode == 12 || keycode == 36 || keycode == 33
  || keycode == 192 || keycode == 187 || keycode == 219 || keycode == 221 || keycode == 220 || keycode == 186
|| keycode == 222 || keycode == 13 || keycode == 188 || keycode == 190 || keycode == 191 || keycode == 45 || keycode == 46
|| keycode == 106 || keycode == 107 || keycode == 109 || keycode == 111 || keycode == 144 || keycode == 96 || keycode == 110
|| keycode == 112 || keycode == 113 || keycode == 114 || keycode == 115 || keycode == 116 || keycode == 117 || keycode == 118
|| keycode == 119 || keycode == 120 || keycode == 121 || keycode == 122 || keycode == 123 || keycode == 19 || keycode == 45
|| keycode == 46) {
  return false;
}
});
});

//evt.which === 65 && evt.ctrlKey werkt raar genoeg opdat het keyUP is (control werkt alleen met keydown)
$(document).ready(function(){
$("#keywords").keyup(function (evt) {
  var keywords = $('#keywords').val();
  var currentPagenumber = currentPagenumber ? $('.active .page-link').text() : 1;
  var pathname = "?page="+currentPagenumber+"&searchText="+keywords;
      var keycode = evt.charCode || evt.keyCode;
      // disabling all the keys except the letters
      if (keycode == 18 || keycode == 17 || keycode == 9 || keycode == 16 || keycode == 13 || keycode == 20 ||
        keycode == 27 || keycode == 91 || keycode == 93 || keycode == 37 || keycode == 38 || keycode == 39 || keycode == 40 ||
        keycode >= 48 && keycode <= 57 || keycode == 35 || keycode == 34 || keycode == 35 || keycode == 12 || keycode == 36 || keycode == 33
      || keycode == 192 || keycode == 187 || keycode == 219 || keycode == 221 || keycode == 220 || keycode == 186
    || keycode == 222 || keycode == 13 || keycode == 188 || keycode == 190 || keycode == 191 || keycode == 45 || keycode == 46
    || keycode == 106 || keycode == 107 || keycode == 109 || keycode == 111 || keycode == 144 || keycode == 96 || keycode == 110
    || keycode == 112 || keycode == 113 || keycode == 114 || keycode == 115 || keycode == 116 || keycode == 117 || keycode == 118
    || keycode == 119 || keycode == 120 || keycode == 121 || keycode == 122 || keycode == 123 || keycode == 19 || keycode == 45
    || keycode == 46 || evt.which === 65 && evt.ctrlKey) {
  return false;
} else {

  searchFilter();

//Only fade in if backspace is not pressed
if (keycode !== 8) {
        if($("#keywords").val().length > 0) {
              $('.loading-overlay').fadeIn("fast");
            }
          }

  //Check if products are sorted
  var sortName = $('#sortBy').find('option:selected').attr("name");
  var pathnameWithSorting = "?page="+currentPagenumber+"&sort="+sortName+"&searchText="+keywords;
  if (window.location.href.indexOf('&sort=') > 0) {
  window.history.replaceState(null, null, 'products.php'+pathnameWithSorting);
} else {
  window.history.replaceState(null, null, 'products.php'+pathname);
}

  //add sorting parameter if searchText parameter exists
  $('#sortBy').change(function() {
    var sortName = $(this).find('option:selected').attr("name");
    var pathnameWithSorting = "?page="+currentPagenumber+"&sort="+sortName+"&searchText="+keywords;
  if ($(this).val()) {
    if (window.location.href.indexOf('&searchText=') > 0) {
      window.history.replaceState(null, null, 'products.php'+pathnameWithSorting);
    }
  }
  });

    if($(this).val().length == 0) {
        if (window.location.href.indexOf('&sort=') > 0) {
          window.history.replaceState(null, null, 'products.php?page='+currentPagenumber+"&sort="+sortName);
        } else {
          window.history.replaceState(null, null, 'products.php?page='+currentPagenumber);
        }
  }
}
});
});


// //If ON products page backpage will be just products.php
// var pageName = $('#pageName').attr('value');
// if(pageName == 'products.php') {
//   // if (window.location.href.indexOf('?searchText=') > 0) {
//     history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
//     window.addEventListener('popstate', function(event) {
//         window.location.href(document.location.protocol +"//"+ document.location.hostname + document.location.pathname);
//       });
//   }


//Hide cart menu when page is not loaded because of cart goes up then down
$(document).ready(function(){
$('#cartMenu').css({"visibility":"visible"});
});

$(document).ready(function(){
  $("body").tooltip({ selector: '[data-toggle=tooltip]',placement: 'top' });
});

// $(window).on('load', function () {
$(document).ready(function(){

 var pageName = $('#pageName').attr('value');

 if(pageName == 'index.php') {
	 $(".pageMainContainer").fadeIn(250);
 } else {
   if(pageName == 'register.php' || pageName == 'make-account-after-register.php') {
     $(".pageMainContainer").fadeIn(0);
   } else {
	 $(".pageMainContainer").fadeIn(450);
 }
 }

});

$(document).ready(function(){

	var pageName = $('#pageName').attr('value');
	var cart_count = $('#cart-count').text();
if(pageName == 'cart.php') {
	if(cart_count == 0) {
		$(".emptyCartContainer").show();
			$(".pageTitleContainer").hide();
	}
}
});

$(document).ready(function(){
//remove product from cart
					$(".delete-product-cart").click(function(){
			 var id = $(this).data('id');
			 var delete_form = $(this).closest('.update-delete-product-form');
			 var subtotal    = delete_form.siblings('.update-subtotal-price-form').find('.cart-price-subtotal-value').text();
			 var total   = $(".cart-price-total-value").text();
       $(".badge-primary").text(parseInt($('#cart-count').text()) -1);
			 $.ajax({
				 url: "remove_from_cart.php",
				 type: "GET", //send it through get method
				 data: {
					 id: id,
					 subtotal:subtotal,
					 total:total
				 },
				 	dataType : 'JSON',
				 success: function(response) {
					  // $('#cart-count').text(response['cart_total']);
						$(".item-count-for-ajax").html(response['cart_total']);
						$(".cart-price-total").html(response['totalDecimal']);
						$(".cart-price-total-value").html(response['total']);


						if(response['cart_total'] == 0) {
							//Fade out My Basket title
								$(".pageTitleContainer").delay(0).fadeOut(250);
							//Fade out product div faster if it is last product
							$('.whole-product-div[data-id="'+id+'"]').fadeOut(250, function(){ $(this).remove();});
							//Show Empty Cart icon
							$('.emptyCartContainer').delay(600).fadeIn(250);
							//Fade out total price
							$(".update-total-price-form").delay(0).fadeOut(600);
							//Fade out My Payment Logos
								$(".paymentLogos").delay(0).fadeOut(650);
						} else {
							//Fade out slower when products is above 1
							$('.whole-product-div[data-id="'+id+'"]').fadeOut(50, function(){ $(this).remove();});
						}

						var item_count = $(".item-count-for-ajax").html();

						if(item_count == 1) {
							$(".item-or-items").html('item');
						} else {
							$(".item-or-items").html('items');
						}


						if(response['total'] <= 30) {
							var plusShippingCosts = parseFloat($(".cart-price-total").html()) + 5;
							$(".cart-price-total:last").html(plusShippingCosts.toFixed(2));
							$(".freeShippingCostsOrNot").html("&#8364;<div id='borderSecondHalf'></div>5.00");
							$('.freeShippingCostsOrNot').css({"color":"black"});
						} else {
							$(".cart-price-total:last").html();
							$(".freeShippingCostsOrNot").html("<div id='borderSecondHalf'></div>Free");
							$('.freeShippingCostsOrNot').css({"color":"#019829"});
						}


				 },
				 error: function(xhr) {
					 //Do Something to handle error
				 }
			 });

				});
});


// EFFECT on disabling input after clicking quantity
$(document).ready(function(){
$(".update-quantity").click(function(){

		$('.update-quantity-form').find('.update-quantity').addClass('disableClickBetween');
		$('.cartPageContainer').addClass('changeOpacityAfterQuantityClick');
		$('.square').addClass('disablePlusAndMinusBetween');
		$('.update-total-price-form').addClass('changeOpacityAfterQuantityClick');

	setTimeout(function() {
				$('.update-quantity-form').find('.update-quantity').removeClass('disableClickBetween');
				$('.cartPageContainer').removeClass('changeOpacityAfterQuantityClick');
				$('.square').removeClass('disablePlusAndMinusBetween');
				$('.update-total-price-form').removeClass('changeOpacityAfterQuantityClick');
		 }, 300)
});
});

//Allow quantity val not to go below 1 when click
	$(".change-quantity").on("click", function() {
$(document).ready(function(){

$('.update-quantity-form').each(function () {
	var inputVal = $(this).find('.cart-quantity').text();
	// alert("a"+inputVal);
		if(inputVal == '1') {
			// alert('disabled');
			$(this).find('.disable-minus').addClass('disableClick');
				$(this).find('.minus').css({"opacity":".5"});
		} else {
				// alert('not disabled');
			$(this).find('.disable-minus').removeClass('disableClick');
			$(this).find('.minus').css({"opacity":"1"});
		}
});
});
});

// Allow quantity val not to go below 1 when document ready
$(document).ready(function(){

$('.update-quantity-form').each(function () {
	var inputVal = $(this).find('.cart-quantity').text();
	// alert("b"+inputVal);
		if(inputVal == '1') {
			// alert('disabled');
			$(this).find('.disable-minus').addClass('disableClick');
			$(this).find('.minus').css({"opacity":".5"});
		} else {
			$(this).find('.disable-minus').removeClass('disableClick');
			$(this).find('.minus').css({"opacity":"1"});
		}
});
});

 $(document).ready(function(){
//update quantity code and more
				 $(".update-quantity").click(function(){

					 // Code for adding or decreasing quantity
					 var $button = $(this);
					 var $input = $button.closest('.quantity').find(".quantity-input");

					 var beforeQuantity;
					 $input.text(function(i, value) {
						beforeQuantity = value;
							return +value + (1 * +$button.data('multi'));
					 });

					 //beginning of preparing the AJAX code
					 var quantity_form = $(this).closest('.update-quantity-form');
				   var id       = $(this).data('id');
				   var quantity = quantity_form.find('.cart-quantity').text();
				   var price    = quantity_form.siblings('.update-price-price-form').find('.cart-price-price').text();
					 var total   = $(".cart-price-total-value").text();

				$.ajax({
          url: "update_quantity.php",
          type: "GET", //send it through get method
          data: {
            id: id,
            quantity: quantity,
						price:price,
						total: total,
						beforeQuantity:beforeQuantity,
          },
					dataType : 'JSON',
          success: function(response) {
						// $("#cart-count").html(response['cart_total']);
						$(".item-count-for-ajax").html(response['cart_total']);
						quantity_form.siblings('.update-subtotal-price-form').find('.cart-price-subtotal').html(response['sub_total']);
						$(".cart-price-total").html(response['totalDecimal']);
						$(".cart-price-total-value").html(response['total']);

						var item_count = $(".item-count-for-ajax").html();
						if(item_count == 1) {
							$(".item-or-items").html('item');
						} else {
							$(".item-or-items").html('items');
						}

						if(response['total'] <= 30) {
							var plusShippingCosts = parseFloat($(".cart-price-total").html()) + 5;
							$(".cart-price-total:last").html(plusShippingCosts.toFixed(2));
							$(".freeShippingCostsOrNot").html("&#8364;<div id='borderSecondHalf'></div>5.00");
							$('.freeShippingCostsOrNot').css({"color":"black"});
						} else {
							$(".cart-price-total:last").html();
							$(".freeShippingCostsOrNot").html("<div id='borderSecondHalf'></div>Free");
							$('.freeShippingCostsOrNot').css({"color":"#019829"});
						}

          },
          error: function(xhr) {
            //Do Something to handle error
          }
        });

				 });
 });

$(document).ready(function(){
//Add to cart PRODUCT code
				$(".add_to_cart").click(function(e){
					//OPEN MODAL
					$(document).ready(function(){ $('#addedToCartModal').modal({backdrop: 'static', keyboard: false}) });
						e.preventDefault();
			 var id = $(this).data('id');
			 var pagenum = $(".page-number").val();

			 //change button style after click
			 var button = $('.change-style-after-click[data-id="' + id + '"] .btn')
			 button.addClass("btn-success").text("Update Quantity");

			 $.ajax({
				 url: "add_to_cart.php",
				 type: "GET", //send it through get method
				 data: {
					 id: id,
					 page: pagenum,
				 },
				 success: function(response) {

      $('#cart-count,#added-to-cart-cart-count').text(response);


						var cart_count = $('#added-to-cart-cart-count').text();
						console.log(cart_count);
			if(cart_count < 10)
			{
			$('#added-to-cart-cart-count').css({"padding":".45em .7em"});
		} else {
			 $('#added-to-cart-cart-count').css({"padding":".45em .5em"});
		}
				 },
				 error: function(xhr) {
					 //Do Something to handle error
				 }
			 });

				});
});

 $(document).ready(function(){
//Add to cart PRODUCT selected code
				 $(".add-to-cart").click(function(e){
					 $(document).ready(function(){ $('#addedToCartModal').modal({backdrop: 'static', keyboard: false}) });
						 e.preventDefault();
				var quantity = $(".cart-quantity").val();
				var id = $(".product-id").text();
				$.ajax({
          url: "add_to_cart.php",
          type: "GET", //send it through get method
          data: {
            id: id,
            quantity: quantity,
          },
          success: function(response) {

      $('#cart-count,#added-to-cart-cart-count').text(response);


						var cart_count = $('#added-to-cart-cart-count').text();
						console.log(cart_count);
			if(cart_count < 10)
			{
			$('#added-to-cart-cart-count').css({"padding":".45em .7em"});
		} else {
			 $('#added-to-cart-cart-count').css({"padding":".45em .5em"});
		}
          },
          error: function(xhr) {
            //Do Something to handle error
          }
        });

				 });
 });



 var sample = $('.cart-after-item-added')[0];

$(document).ready ( function () {
$("#addedToCartModal").on("shown.bs.modal", function(){
	$('.modal-backdrop').css('opacity', '.91');
    (sample.classList.contains("active")) ? sample.classList.remove("active") : sample.classList.add("active");
});
		$("#addedToCartModal").on('hide.bs.modal', function () {
(sample.classList.contains("active")) ? sample.classList.remove("active") : sample.classList.add("active");
    });
});
//
// $(document).ready ( function () {
// $("#addedToCartModal").on("shown.bs.modal", function(){
//       $('.modal-backdrop').css('opacity', '.91');
//
// 				setTimeout(function () {
// 			    function animate() {
// 			        $(".cart-after-item-added").animate({"margin-left":"105%"}, 2000, 'linear',function(){
// 							$('.cart-after-item-added').css({"margin-left":"-133%"});
// 							$(".cart-after-item-added").animate({"margin-left":"50%"}, 4000, 'linear',function(){
// 							animate();
// 					});
// 			  });
// 			}
// 			    animate();
// 				}, 250);
// 		});
// 		$("#addedToCartModal").on('hide.bs.modal', function () {
// 	$('#item').stop();
// });
// });
//
// $(document).ready(function(){
// var inputVal = $('.cart-quantity').val();
// console.log(inputVal);
// 	if(inputVal == 1) {
// 		alert('disabled');
// 		$(".remove-href-minus").removeAttr('href');
// 	}
// });
//
// $('.m-b-10px a.w-100-pct').each(function () {
//     if ($(this).text() == 'Add to Cart') {
//         $(this).css('color', 'red');
//     }
// });
//
// $(".add_to_cart").each(function() {
//     if (this.href.indexOf('add_to_cart.php?') != -1) {
//         // alert("Contains questionmark");
// 				// $(this).css('color', 'red');
// 				$(this).click(function(){
// 				// alert("Contains questionmark");
// 				$(document).ready(function(){ $('#addedToCartModal').modal({backdrop: 'static', keyboard: false}) });
// 				});
//
//     }
// });
//
// Act on clicks to a elements
// $(".add_to_cart").on('click', function(e) {
// 	//open modal if add_to_cart clicked
// 	$(document).ready(function(){ $('#addedToCartModal').modal({backdrop: 'static', keyboard: false}) });
//     HERE// prevent the default action, in this case the following of a link
//     e.preventDefault();
//     // capture the href attribute of the a element
//     var url = $(this).attr('href');
//     // perform a get request using ajax to the captured href value
//     $.get(url, function() {
//         // success
//     });
// });

$(document).ready ( function () {
$('body,#overlay').on('click', function(e) {
  if (e.target !== this)
    return;
 $(".show_search").hide();
 $("#overlay").hide();
});
});

//Other way to use click and hide show serach and overlay (see above function)
// $(document).on('click', function (e) {
//     if ($(e.target).closest("#search").length === 0 && $(e.target).closest("#show_search").length === 0) {
//         $('#show_search').hide();
// 				$("#overlay").hide();
//     }
// });

// $(document).ready ( function () {
//     $(document).on ("click", ".test", function () {
//         $(".show_search").show();
// 				alert(1);
//     });
// });

$(document).ready ( function () {
$('#search').focus(function() {
$("#overlay").show();
	});
});


//Disable hitting ENTER for SEARCH
$('.form-inline').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) {
    e.preventDefault();
    return false;
  }
});

$(document).ready(function(e){
	$("#search").keyup(function(){
		this.value ? $("#show_search").show() : $("#show_search").hide();
		var text = $(this).val();
		$.ajax({
			type: 'GET',
			url: 'search.php',
			data: 'txt=' + text,
			success: function(data){
				$("#show_search").html(data);
        $(".addHrefToFirstSearch").attr("href", "products.php?page=1&searchText="+text);
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $("#articleImage,#articleName,#priceArticle").attr('class', 'col my-auto');
        // $('#crossForInput').click(function(){
        //   $('#search').val('');
        // });
      }
			}
		});
	})
});


$(document).ready(function(){
    // add to cart button listener
    // $('.add-to-cart-form').on('submit', function(){
		//
    //     // info is in the table / single product layout
    //     var id = $(this).find('.product-id').text();
    //     var quantity = $(this).find('.cart-quantity').val();
		//
    //     // redirect to add_to_cart.php, with parameter values to process the request
    //     window.location.href = "add_to_cart.php?id=" + id + "&quantity=" + quantity;
    //     return false;
    // });


//     // update quantity button listener
// $('.update-quantity-form').on('submit', function(){
//
//     // get basic information for updating the cart
//     var id = $(this).find('.product-id').text();
//     var quantity = $(this).find('.cart-quantity').val();
//
//     // redirect to update_quantity.php, with parameter values to process the request
//     window.location.href = "update_quantity.php?id=" + id + "&quantity=" + quantity;
//     return false;
//   });

	/*

  Quantity function without button

  jQuery(function($) {
  $('.cart-quantity').on('input', function() {
    // get basic information for updating the cart
    var id = $(this).attr('rel');
    var quantity = $(this).val();

    // redirect to update_quantity.php, with parameter values to process the request
    window.location.href = "update_quantity.php?id=" + id + "&quantity=" + quantity;
    return false;
  });
});*/
  // change product image on hover
  $(document).on('mouseenter', '.product-img-thumb', function(){
      var data_img_id = $(this).attr('data-img-id');
      $('.product-img').hide();
      $('#product-img-'+data_img_id).show();
  });
});

$('.badge').click(function(){
$(this).children('i').toggleClass('down up');
});

// $(document).on('click', function() {
//   if($('.dropdown-menu').hasClass("show")) {
//     alert(1);
//   } else {
//     alert(2);
//   }
// });


  $('.dropdownMenuLogin').click(function(){
  $(this).children('i').toggleClass('down up');
  });

  $(function() {
    $('#dropdownMenuLogin').hover(function() {
      $('.arrow-loginheader').css('border', 'solid black');
      $('.arrow-loginheader').css('border-width', '0 3px 3px 0');
    }, function() {
      // on mouseout, reset the background colour
          $('.arrow-loginheader').css('border', 'solid rgba(0, 0, 0, 0.5)');
          $('.arrow-loginheader').css('border-width', '0 3px 3px 0');
    });

    $('#cart-count').hover(function() {
      $('.shopping-cart-header').css('color', 'black');
    }, function() {
      // on mouseout, reset the background colour
          $('.shopping-cart-header').css('color', 'rgba(0, 0, 0, 0.5)');
    });
  });


$(".disable").prop('disabled', true);

/* Close modal box by pressing keys */
  jQuery(document).keypress(function(e) {
    //13 is Enter, 27 is Esscape
  if (e.keyCode === 13 || e.keyCode === 27) {
   jQuery("#loginMessageModal").modal('hide');
  }
 });

/* For mobile change type text to date
$('button').on('click', function(){
if(input.prop('type') == 'text') {
    $('input[type=text]').prop('type','date');
 }
else {
    $('input[type=text]').prop('type','date');
 }
});*/

</script>

</body>
</html>
