<?php 
session_start();
$mail_body = '

         <!DOCTYPE html>
         <html>
         <head>
           <title>Gesters Webshop</title>
           <style type="text/css">
             /* RESET STYLES */

             body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica,Arial,sans-serif;}
             table{border-collapse:collapse;}
             table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
             h1, h2, h3, h4, h5, h6{color:#000000; font-weight:normal; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}

             /* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */

             .emailButton{background-color:#fde45c;width:258px;margin-left:90px;}
             .buttonContent{color:#FFFFFF;line-height:100%;padding:10px;text-align:center;}
             .buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}

             .table-orderhistory {
              line-height:140%;
              border-bottom: none!important;
           }

           tr {
           border-bottom: none!important;
          }

             /* Queries for mobile */
               @media only screen and (max-width: 600px) {

                 u + .body .buttonContent {
                    padding:10px!important;
                   }

                u + .body .buttonContent a{
                 font-size:15px!important;
                }

                u + .body #fontSizeHeader{
                 font-size:25px!important;
                }

                u + .body #fontSizeFooterHeader{
                 font-size:21.5px!important;
                }

                u + .body .fontSizeFooterBody{
                 font-size:15.5px!important;
                }

                u + .body .dearFirstname {
                  font-size:23px!important;
                }

                u + .body .shippingAddressTitle {
                  font-size:21px!important;
                }

                u + .body .welcomeAt {
                  font-size:21px!important;
                }

                u + .body .shippingAdresses {
                  font-size:21px!important;
                }

                u + .body .shippingInformation {
                  font-size:18px!important;
                }

                u + .body .clickOnResetButtonText{
                 font-size:16.5px!important;
                }


                 .emailButton {
                   margin-left:0px!important;
                   width:100%!important;
                 }
                 .marginBottom {
                   margin-bottom:0px!important;
                 }
                 .marginTop {
                   margin-top:25px!important;
                 }
                 .marginBottomEnding {
                   margin-bottom:10px!important;
                 }
                 .marginTopZero {
                   margin-top:0px!important;
                 }

                 .buttonContent a{font-size:16px!important;}
                 #fontSizeHeader {font-size:28px!important;}
                 #fontSizeFooterHeader {font-size:22.5px!important;}
                 .fontSizeFooterBody {font-size:15.5px!important;}
                 #footerBodyTable {margin-top:10px!important;margin-bottom:20px!important;}
                 .buttonContent{padding:10px!important;}
                 .dearFirstname {font-size:23.5px!important;}
                 .shippingAddressTitle {font-size:21.5px!important;}
                 .welcomeAt {line-height:140%!important;font-size:21.5px!important;}
                 .shippingAdresses {line-height:150%!important;font-size:19.5px!important;}
                 .shippingInformation {line-height:140%!important;font-size:18.5px!important;}
                 .clickOnResetButtonText {font-size:16.5px!important;}
                 .contactAndService {margin-bottom:10px!important;}
                 .paddingLeftRight {padding-left:30px!important;padding-right:30px!important;}
                 .lineHeightFooter {line-height:170%!important;}
                 .removePaddingContent {padding:0px!important;}
                 .spacesBetweenDivs {height:40px!important;}
                 .hideThumbsUpImage {display:none!important;}
                 .showTumbsUpImageMobile {display:block!important;}
                 .insideBodyWidth {width:100%!important;}
                 .table-orderhistory {
                  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif,
                  "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
                  color:black;
                  font-size:16px;
                  line-height:140%;
               }

               }
           </style>
         </head>

         <body class="body">
         <center style="background-color:#FFFFFF;">
           <table border="0" cellpadding="0" cellspacing="0" height="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
             <tr>
               <td align="center" id="bodyCell">

                   <table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="100%" id="emailBody">

                     <tr>
                       <td align="center">

                         <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#71aee8">
                           <tr>
                             <td align="center">

                               <table border="0" cellpadding="0" cellspacing="0" width="100%" class="flexibleContainer">
                                 <tr>
                                   <td align="center" width="100%" class="flexibleContainerCell">

                                     <table border="0" cellpadding="18" cellspacing="0" width="100%">
                                       <tr>
                                         <td align="center" class="textContent">
                                           <b id="fontSizeHeader" style="color:#FFFFFF;line-height:100%;font-size:24px;font-weight:bold;text-align:center;">Gesters Webshop</b>
                                         </td>
                                       </tr>
                                     </table>
                                     <!-- // CONTENT TABLE -->
                                   </td>
                                 </tr>
                               </table>
                               <!-- // FLEXIBLE CONTAINER -->
                             </td>
                           </tr>
                         </table>
                         <!-- // CENTERING TABLE -->
                       </td>
                     </tr>
                     <tr>
                       <td align="center">
                         <!-- CENTERING TABLE // -->
                         <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFF">
                           <tr>
                             <td align="center">
                               <!-- FLEXIBLE CONTAINER // -->
                               <table border="0" cellpadding="0" cellspacing="0" width="100%" class="flexibleContainer">
                                 <tr>
                                   <td align="center" width="100%" class="flexibleContainerCell">
                                     <table border="0" cellpadding="35" cellspacing="0" width="100%">
                                       <tr>
                                         <td align="center" class="removePaddingContent">
                                           <!-- CONTENT TABLE // -->
                                           <table class="insideBodyWidth" border="0" cellpadding="0" cellspacing="0" width="94%">

                                             <tr>
                                               <td class="textContent">
                                                 <div mc:edit="body" style="text-align:left;font-size:14px;margin-bottom:0;line-height:135%;">
                                                 <table border="0" cellpadding="0" width="100%">
                                                 <tr class="spacesBetweenDivs" style="line-height:0px;height:0px;margin:0;padding:0;"><td style="line-height:0px;height:0px;margin:0;padding:0;"></td></tr>
                                                 </table>
                                                   <table border="0" cellpadding="35" width="100%">
                                                   <tr style="background:#fff4ba;">
                                                     <td>
                                                 <b class="dearFirstname" style="font-size:25px;color:#000000;">Dear '.$firstname.'<b>,</b></b>
                                                 <p class="welcomeAt" style="font-size:23px;margin-top:10px;line-height:140%;color:#000000;">Below are the details on your order. We will notify you when the package has been shipped.</p>
                                                 <div class="showTumbsUpImageMobile" style="text-align:center;display:none;padding-top:.5rem;">
                                                <img src="https://gester.nl/webshop/images/package.png" width="160">
                                              </div>
                                              </td>
                                              <td class="hideThumbsUpImage" style="text-align:center;padding:2rem 2rem 2rem 1.5rem;">
                                                <img src="https://gester.nl/webshop/images/package.png" width="160">
                                              </td>
                                             </tr>
                                           </table>
                                           <table border="0" cellpadding="20" width="100%">
                                           <tr><td></td></tr>
                                           </table>
                                           <table border="0" cellpadding="35" width="100%">
                                           <tr style="background:#d8fbf2;">
                                             <td style="width:100%;padding:1rem 2rem 2rem 2rem;">
                                         <p class="clickOnResetButtonText" style="margin-top:15px;font-size:17px;line-height:140%;color:#000000;"><pre> '.$output.' </pre></p>
                                       </td>
                                     </tr>
                                     </table>
                                     <table border="0" cellpadding="20" width="100%">
                                     <tr><td></td></tr>
                                     </table>
                                     <table border="0" cellpadding="35" width="100%">
                                     <tr style="background:#fff4ba;">
                                       <td>
                                   <b class="shippingAddressTitle" style="font-size:21px;color:#000000;">Shipping address</b><br><br>
                                   <p class="shippingAdresses" style="font-size:20px;margin-top:10px;line-height:125%;color:#000000;">'.$firstname.' '.$last_name.'<br>'.$street_name.' '.$street_number.'<br>'.$zip_code.' '.$city.'<br>'.$country.'</p>
                                   <div class="showTumbsUpImageMobile" style="text-align:center;display:none;padding-top:.5rem;">
                                  <img src="https://gester.nl/webshop/images/houseInformation.png" width="160">
                                </div>
                                </td>
                                <td class="hideThumbsUpImage" style="text-align:center;padding:2rem 2rem 2rem 1.5rem;">
                                  <img src="https://gester.nl/webshop/images/houseInformation.png" width="160">
                                </td>
                               </tr>
                             </table>
                                     <table border="0" cellpadding="0" width="100%">
                                     <tr class="spacesBetweenDivs" style="line-height:0px;height:0px;margin:0;padding:0;"><td style="line-height:0px;height:0px;margin:0;padding:0;"></td></tr>
                                     </table>
                                               </div>
                                               </td>
                                             </tr>
                                           </table>
                                           <!-- // CONTENT TABLE -->
                                         </td>
                                       </tr>
                                     </table>
                                   </td>
                                 </tr>
                               </table>
                               <!-- // FLEXIBLE CONTAINER -->
                             </td>
                           </tr>
                         </table>
                         <!-- // CENTERING TABLE -->
                       </td>
                     </tr>

                     <tr>
                       <td align="center">

                       <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#71aee8">
                         <tr>
                           <td align="center">

                             <table border="0" cellpadding="0" cellspacing="0" width="100%" class="flexibleContainer">
                               <tr>
                                 <td align="center" width="100%" class="flexibleContainerCell">

                                   <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:0px;">
                                     <tr>
                                       <td align="center" class="textContent">
                                         <h2 id="fontSizeFooterHeader" class="marginBottom marginTop contactAndService" style="color:#205478;line-height:100%;font-size:20.5px;font-weight:bold;margin-bottom:0px;margin-top:15px;text-align:center;">Contact & Service</h2>
                                       </td>
                                     </tr>
                                   </table>
                                   <table id="footerBodyTable" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:0px;margin-bottom:0px;">
                                   <tr>
                                     <td style="padding-bottom:15px;" class="paddingLeftRight">
                                     <p class="fontSizeFooterBody marginBottom marginTopZero lineHeightFooter" style="color:#FFFFFF;line-height:135%;font-size:15.5px;font-weight:normal;margin-bottom:0px;margin-top:15px;text-align:center;"><b>Openinghours:</b> ma t/m vr: <a style="text-decoration:underline;color:#FFFFFF;"> 8:30 - 17:00 uur</a>, zaterdag: <a style="text-decoration:underline;color:#FFFFFF;"> 10:00 - 16:00 uur</a></p>
                                     </td>
                                     </tr>
                                     <tr>
                                     <td style="padding-bottom:0px;" class="paddingLeftRight">
                                         <p class="fontSizeFooterBody marginBottom lineHeightFooter" style="color:#FFFFFF;line-height:135%;font-size:15.5px;font-weight:normal;margin-bottom:0px;text-align:center;margin-top:0px;"><b>Contact us at this number:</b> <a href="tel:0761218912" style="text-decoration:underline;border:none;color:#205478;font-weight:500;">076 121 8912</a></p>
                                     </td>
                                   </tr>
                                     <tr>
                                       <td>
                                       <p class="fontSizeFooterBody marginBottomEnding paddingLeftRight lineHeightFooter" style="color:#FFFFFF;line-height:135%;font-size:15.5px;padding-left:20px;padding-right:20px;font-weight:normal;margin-bottom:15px;text-align:center;margin-top:15px;"><b>To file a complaint:</b> <a href="tel:0761598133" style="text-decoration:underline;border:none;color:#205478;font-weight:500;">076 159 8133</a></p>
                                       </td>
                                       </tr>
                                   </table>
                                   <!-- // CONTENT TABLE -->

                                 </td>
                               </tr>
                             </table>
                             <!-- // FLEXIBLE CONTAINER -->
                           </td>
                         </tr>
                       </table>
                         <!-- // CENTERING TABLE -->
                       </td>
                     </tr>
                     <!-- // MODULE ROW -->
                   </table>
                   </td>
                   </tr>
                 </table>
               </center>
               </body>
               </html>

                      ';
					  echo $mail_body;
					  ?>
