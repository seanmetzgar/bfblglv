<?php
  require_once('./inc/phpmailer/PHPMailerAutoload.php');
  require_once('./inc/_inc_mysql.php');
  require_once("./inc/_inc_uuid.php");
  require_once("./inc/_inc_helpers.php");

    $uuid = $_REQUEST["uuid"];
    $uuid = strlen($uuid) > 10 ? $uuid : false;
    $id = (int)$_REQUEST["id"];
    $id = is_int($id) ? $id : false;
    $valid_partner = false;
    $server_name = $_SERVER["SERVER_NAME"];
    $notify_url = "http://$server_name/ipn/processPayment.php";
    $return_url = "http://$server_name/paymentSuccess.php?id=$id&uuid=$uuid";
    $cancel_url = "http://$server_name/paymentCancel.php?id=$id&uuid=$uuid";
    $paypal_url = ($server_name == "partner.buylocalglv.org") ? "https://www.paypal.com/cgi-bin/webscr" : "https://www.sandbox.paypal.com/cgi-bin/webscr";
    $paypal_business = ($server_name == "partner.buylocalglv.org") ? "info@BuyLocalGreaterLehighValley.org" : "sean.metzgar-facilitator@wearekudu.com";


    if ($uuid  && $id) {
        $select_query = "SELECT * FROM registrations WHERE id=? AND uuid=? AND status != 7 LIMIT 1";
        $select_statement = $mysqli->stmt_init();
        if ($select_statement->prepare($select_query)) {
            $select_statement->bind_param("is", $id, $uuid);
            $select_statement->execute();


            $select_result = $select_statement->get_result();
            if ($partner = $select_result->fetch_assoc()) {
                $valid_partner = count($partner) > 0 ? true : false;
                if ($valid_partner) {
                    $paid = $partner["paid"];
                    $amount_owed = $partner["amount_owed"];
                }
            }
            $select_statement->close();
        }
    }

    if ($valid_partner && !$paid && is_int($amount_owed) && $amount_owed > 0):
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

        <title>Partner Application | Buy Fresh Buy Local - Greater Lehigh Valley</title>

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

        <link rel="stylesheet" type="text/css" href="/css/styles.css">
    </head>

    <body>
        <div class="site-wrapper">
            <div class="container signup-wrapper">
                <div class="col-lg-10 col-lg-offset-1">
                    <p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
                    <h1 class="title">Payment Information</h1>

                    <p>Thank you for your interest in becoming a Partner with Buy Fresh Buy Local Greater Lehigh Valley. In order to complete your registration, please view and agree to the Membership Agreement below. After you have agreed, a payment button will appear for you to continue to PayPal to complete the transaction.</p>
                    <?php if ($partner["category"] == "farm"): ?>
                    <p>No farm will be refused because of an inability to pay.  If you need to pay less than the full amount, please contact Lynn Prior (<a href="mailto:lynn@nurturenaturecenter.org">Lynn@NurtureNatureCenter.org</a> 610-703-6954) to make arrangements.</p>
                    <?php endif; ?>

                    <h2>Payment Details</h2>
                    <table class="table table-striped table-bordered" width="100%">
                        <tr>
                            <th>Amount Due:</th>
                            <td><?php echo money_format('%.2n', $amount_owed); ?></td>
                        </tr>
                        <tr>
                            <th><label for="agree-terms">Accept the <a href="/documents/BFBLGLV_Membership_Agreement.pdf" target="_blank">Membership Agreement</a>?</label></th>
                            <td><input type="checkbox" id="agree-terms" name="agree-terms" value="1"></td>
                        </tr>
                    </table>
                    <form action="<?php echo $paypal_url; ?>" method="post" target="_top" style="display: none;" id="payment-form">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="<?php echo $paypal_business; ?>">
                        <input type="hidden" name="cpp_logo_image" value="https://s24.postimg.org/pyhpelzjl/bfblglv_logo.png">
                        <input type="hidden" name="lc" value="US">
                        <input type="hidden" name="item_name" value="Buy Fresh Buy Local Greater Lehigh Valley: Annual Dues">
                        <input type="hidden" name="no_note" value="1">
                        <input type="hidden" name="no_shipping" value="1">
                        <input type="hidden" name="amount" value="<?php echo $amount_owed; ?>">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="custom" value="<?php echo $uuid; ?>">
                        <input type="hidden" name="return" value="<?php echo $return_url; ?>">
                        <input type="hidden" name="cancel_return" value="<?php echo $return_url; ?>">
                        <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>">
                        <input type="hidden" name="rm" value="2">

                        <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-medium.png" border="0" name="submit" alt="Buy Now with PayPal">
                    </form>
                </div>
            </div>
        </div><!-- END: .site-wrapper -->

        <script src="/scripts/vendor/jquery/jquery.min.js"></script>
        <script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
        <script src="/scripts/plugins.min.js"></script>
        <script src="/scripts/scripts.min.js"></script>
    </body>
</html><?php
    elseif ($valid_partner && $paid):
        header("Location: continue.php?id=$id&uuid=$uuid");
    else:
        header("Location: /");
    endif;
