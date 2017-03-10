<?php
  require_once('./inc/phpmailer/PHPMailerAutoload.php');
  require_once('./inc/_inc_mysql.php');
  require_once("./inc/_inc_uuid.php");
  require_once("./inc/_inc_helpers.php");

    $uuid = $_REQUEST["uuid"];
    $uuid = (UUID::is_valid($uuid)) ? $uuid : false;
    $id = (int)$_REQUEST["id"];
    $id = is_int($id) ? $id : false;
    $valid_partner = false;
    $messages = array();

    if ($uuid  && $id) {
        $select_query = "SELECT id, paid FROM registrations WHERE id=? AND uuid=? LIMIT 1";
        $select_statement = $mysqli->stmt_init();
        if ($select_statement->prepare($select_query)) {
            if ($select_statement->bind_param("is", $id, $uuid)) {
              if ($select_statement->execute()) {
                $select_result = $select_statement->get_result();
                if ($partner = $select_result->fetch_assoc()) {
                    $valid_partner = count($partner) > 0 ? true : false;
                    $paid = $partner["paid"];
                }
                $select_statement->close();
              } else {
                $messages[] = "EXEC-01";
              }
            } else {
              $messages[] = "BIND-01";
            }
        } else {
          $messages[] = "PREP-01";
        }
    }

    if ($valid_partner && $paid):
        header("Location: /continue.php?id=$id&uuid=$uuid");
    else: ?><!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html lang="en" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <title>Internal Error | Buy Fresh Buy Local - Greater Lehigh Valley</title>

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

        <link rel="stylesheet" type="text/css" href="/css/styles.css">
    </head>

    <body>
        <div class="site-wrapper">
            <div class="container signup-wrapper">
                <p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
                <h1 class="title">Payment Processing Error</h1>

                <p style="text-align: center;">There was an internal error processing your payment. Please contact <a href="mailto:lynn@nurturenaturecenter.org">BuyLocalGLV</a> for assistance.</p>
                <?php if (count($messages) > 0): $messages = join(", ", $messages); ?>
								<p class="error-messages"><span class="caption">The following errors were received:</span><br><?php echo $messages; ?></p>
								<?php endif; ?>
                <pre>
                <?php print_r($partner); ?>
                </pre>
            </div>
        </div><!-- END: .site-wrapper -->

        <script src="/scripts/vendor/jquery/jquery.min.js"></script>
        <script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
        <script src="/scripts/plugins.min.js"></script>
        <script src="/scripts/scripts.min.js"></script>
    </body>
</html><?php endif; ?>
