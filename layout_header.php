<?php
$_SESSION['cart']=isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

define('RECAPTCHA_SITE_KEY','6LcsVOMbAAAAADmBAPYBgkJ0CdbUuHpUyb9uNNBu');

//Date and time catcher
$date = function()
{
    if(!isset($_COOKIE['GMT_bias']))
    {
?>

        <script type="text/javascript">
            var Cookies = {};
            Cookies.create = function (name, value, days) {
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    var expires = "; expires=" + date.toGMTString();
                }
                else {
                    var expires = "";
                }
                document.cookie = name + "=" + value + expires + "; path=/";
                this[name] = value;
            }

            var now = new Date();
            Cookies.create("GMT_bias",now.getTimezoneOffset(),1);
            window.location = "<?php echo $_SERVER['PHP_SELF'];?>";
        </script>

        <?php

    }
    else {
      $fct_clientbias = $_COOKIE['GMT_bias'];
    }

    $fct_servertimedata = gettimeofday();
    $fct_servertime = $fct_servertimedata['sec'];
    $fct_serverbias = $fct_servertimedata['minuteswest'];
    $fct_totalbias = $fct_serverbias - $fct_clientbias;
    $fct_totalbias = $fct_totalbias * 60;
    $fct_clienttimestamp = $fct_servertime + $fct_totalbias;
    $fct_time = time();
    $fct_year = strftime("%Y", $fct_clienttimestamp);
    $fct_month = strftime("%m", $fct_clienttimestamp);
    $fct_day = strftime("%d", $fct_clienttimestamp);
    $fct_hour = strftime("%I", $fct_clienttimestamp);
    $fct_minute = strftime("%M", $fct_clienttimestamp);
    $fct_second = strftime("%S", $fct_clienttimestamp);
    $fct_am_pm = strftime("%p", $fct_clienttimestamp);
    return $fct_month."/".$fct_day."/".$fct_year." ".$fct_hour.":".$fct_minute.":".$fct_second." ".$fct_am_pm."";
};
$_SESSION['date'] = $date();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title><?php echo isset($page_title) ? $page_title : ""; ?></title>

<!-- Jquery -->
<script src='libs/js/jQuery/jquery-3.4.1.js'></script>
<!-- Bootstrap -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script> -->
<script src='libs/js/bootstrap/bootstrap.bundleLAST.js'></script>
<!-- Bootstrap-select -->
<script src="libs/js/bootstrap-select/bootstrap-select.min.js"></script>
<!-- ReCaptcha -->
<script src='https://www.recaptcha.net/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>'></script>
<!-- Font awesome -->
    <script src="libs/js/fontawesome/all.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootpag/1.0.4/jquery.bootpag.min.js" type="text/javascript"></script> -->


<!-- Latest Bootstrap CSS -->
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
<link rel="stylesheet" href="libs/css/bootstrap/bootstrapLAST.css"/>
<!-- Latest Bootstrap-select CSS -->
<link rel="stylesheet" href="libs/css/bootstrap-select/bootstrap-select.min.css"/>
<!-- Font awesome -->
<link rel="stylesheet" href"libs/css/fontawesome/allLAST.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="libs/css/custom.css"/>

</head>
<?php
echo "<div style='display:none;'>".$date()."</div>";
?>
<body>
<div id="overlay"></div>
    <?php include 'navigation.php';

     ?>

    <!-- container -->
    <div class="container pageMainContainer" style="margin-top:25px;">
        <div class="row">

        <div class="col-md-12 pageTitleContainer" style="margin-top:5px;margin-bottom:70px;">
            <div class="page-header">
                <h1 id='pageTitle'><b><?php echo isset($page_title) ? $page_title : ""; ?></b></h1>
            </div>
        </div>
