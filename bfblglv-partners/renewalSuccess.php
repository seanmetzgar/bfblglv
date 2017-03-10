<?php
  require_once('./inc/phpmailer/PHPMailerAutoload.php');
  require_once('./inc/_inc_mysql.php');
  require_once("./inc/_inc_uuid.php");
  require_once("./inc/_inc_helpers.php");

    $uuid = $_REQUEST["uuid"];
    $uuid = UUID::is_valid($uuid) ? $uuid : false;
    $id = (int)$_REQUEST["id"];
    $id = is_int($id) ? $id : false;

    $valid_partner = false;
    $renewedStatus = 0;

    $server_name = $_SERVER["SERVER_NAME"];
    $renewal_year = getRenewalYear();
    $partnerData = getRenewalPartner($id, $uuid);

    if ($partnerData && is_object($partnerData)) {
        $amount_owed = get_amount_owed($partnerData->category);

        if ($partnerData->id === $id && $partnerData->renewalUUID === $uuid) {
            $valid_partner = true;
            $renewedStatus = $partnerData->renewedStatus;
        }
    }

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html lang="en" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <?php if ($valid_partner && $renewedStatus === 1): ?>
        <title>Thank you | Buy Fresh Buy Local - Greater Lehigh Valley</title>
        <?php else: ?>
        <title>Internal Error | Buy Fresh Buy Local - Greater Lehigh Valley</title>
        <?php endif; ?>

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

        <link rel="stylesheet" type="text/css" href="/css/styles.css">
    </head>

    <body>
        <div class="site-wrapper">
            <div class="container signup-wrapper">
                <p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
                <?php if ($valid_partner && $renewedStatus === 1): ?>
                <h1 class="title">Thank You</h1>
                <?php else: ?>
                <h1 class="title">Payment Processing Error</h1>
                <?php endif; ?>

                <?php if ($valid_partner && $renewedStatus === 1): ?>
                <p style="text-align: center;">Thank you for your continued partnership with Buy Fresh Buy Local Greater Lehigh Valley. Your payment has been successfully processed and recorded.</p>
                <p style="text-align: center;"><em>If you have any questions or concerns, please contact <a href="mailto:lynn@nurturenaturecenter.org">BuyLocalGLV</a> for assistance.</em></p>
                <?php else: ?>
                <p style="text-align: center;">There was an internal error processing your payment. Please contact <a href="mailto:lynn@nurturenaturecenter.org">BuyLocalGLV</a> for assistance.</p>
                <?php endif; ?>
            </div>
        </div><!-- END: .site-wrapper -->

        <script src="/scripts/vendor/jquery/jquery.min.js"></script>
        <script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
        <script src="/scripts/plugins.min.js"></script>
        <script src="/scripts/scripts.min.js"></script>
    </body>
</html>