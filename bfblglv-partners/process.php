<?php
  require_once('./inc/phpmailer/PHPMailerAutoload.php');
  require_once('./inc/_inc_mysql.php');
  require_once("./inc/_inc_uuid.php");
  require_once("./inc/_inc_helpers.php");

	$partner_name = trim($_REQUEST["partner_name"]);
	$partner_name = strlen($partner_name) > 0 ? $partner_name : "";
	$partner_county = trim($_REQUEST["partner_county"]);
	$partner_county = strlen($partner_county) > 0 ? $partner_county : "";
	$partner_category = trim($_REQUEST["partner_category"]);
	$partner_category = strlen($partner_category) > 0 ? $partner_category : "";
	$products = $_REQUEST["products"];
	$products_array = is_array($products) ? $products : false;
	$products = is_array($products) ? implode(", ", $products) : "";
	$other_products = $_REQUEST["other_products"];
	$other_products = strlen($other_products) > 0 ? $other_products : "";
	$acres = trim($_REQUEST["acres"]);
	$acres = strlen($acres) > 0 ? $acres : "";
	$sources = $_REQUEST["sources"];
	$sources = strlen($sources) > 0 ? $sources : "";
	$partner_billing_street_address = trim($_REQUEST["partner_billing_street_address"]);
	$partner_billing_street_address = strlen($partner_billing_street_address) > 0 ? $partner_billing_street_address : "";
	$partner_billing_street_address_2 = trim($_REQUEST["partner_billing_street_address_2"]);
	$partner_billing_street_address_2 = strlen($partner_billing_street_address_2) > 0 ? $partner_billing_street_address_2 : "";
	$partner_billing_zip = trim($_REQUEST["partner_billing_zip"]);
	$partner_billing_zip = strlen($partner_billing_zip) > 0 ? $partner_billing_zip : "";
	$partner_billing_city = trim($_REQUEST["partner_billing_city"]);
	$partner_billing_city = strlen($partner_billing_city) > 0 ? $partner_billing_city : "";
	$partner_billing_state = trim($_REQUEST["partner_billing_state"]);
	$partner_billing_state = strlen($partner_billing_state) > 0 ? $partner_billing_state : "";
	$partner_contact_name = trim($_REQUEST["partner_contact_name"]);
	$partner_contact_name = strlen($partner_contact_name) > 0 ? $partner_contact_name : "";
	$partner_contact_position = trim($_REQUEST["partner_contact_position"]);
	$partner_contact_position = strlen($partner_contact_position) > 0 ? $partner_contact_position : "";
	$partner_contact_phone = trim($_REQUEST["partner_contact_phone"]);
	$partner_contact_phone = strlen($partner_contact_phone) > 0 ? $partner_contact_phone : "";
	$partner_contact_email = trim($_REQUEST["partner_contact_email"]);
	$partner_contact_email = strlen($partner_contact_email) > 0 ? $partner_contact_email : "";
	$partner_phone = trim($_REQUEST["partner_phone"]);
	$partner_phone = strlen($partner_phone) > 0 ? $partner_phone : "";
	$partner_email = trim($_REQUEST["partner_email"]);
	$partner_email = strlen($partner_email) > 0 ? $partner_email : "";
	$partner_website = trim($_REQUEST["partner_website"]);
	$partner_website = strlen($partner_website) > 0 ? $partner_website : "";
	$partner_username = trim($_REQUEST["partner_username"]);
	$partner_username = strlen($partner_username) > 0 ? $partner_username : "";
	$amount_owed = get_amount_owed($partner_category);
	$uuid = UUID::v4();

	if (!$mysqli->connect_errno) {
		if ($partner_name && $partner_county && $partner_category) {
			$insert_statement = $mysqli->stmt_init();
			if ($insert_statement->prepare("INSERT INTO `registrations` (uuid, name, primary_county, category, phone, email, website, requested_username, billing_street, billing_street_2, billing_city, billing_state, billing_zip, contact_name, contact_job, contact_phone, contact_email, acres, products, other_products,  amount_owed, sources) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
				if (!$insert_statement->bind_param("ssssssssssssssssssssis", $uuid, $partner_name, $partner_county, $partner_category, $partner_phone, $partner_email, $partner_website, $partner_username, $partner_billing_street_address, $partner_billing_street_address_2, $partner_billing_city, $partner_billing_state, $partner_billing_zip, $partner_contact_name, $partner_contact_position, $partner_contact_phone, $partner_contact_email, $acres, $products, $other_products, $amount_owed, $sources)) { $messages[] = "BIND-00"; }
				if (!$insert_statement->execute()) { $messages[] = "EXEC-00"; }
				$insert_id = $mysqli->insert_id;
				$insert_statement->close();

				if (is_int($insert_id)) {
					$server_name = $_SERVER["SERVER_NAME"];
					$approve_link = "http://$server_name/admin/approve.php?id=$insert_id&uuid=$uuid";
					$admin_link = "http://$server_name/admin";

					$subject = 		"New Partner Application: Buy Fresh Buy Local - Greater Lehigh Valley";
					$to_address = 	$server_name == "partner.buylocalglv.org" ? "lynn@nurturenaturecenter.org" : "sean.metzgar@gmail.com";
					$from_address =	"no-reply@buylocalglv.org";

					$message = 		"A new partner has started the registration process online:\n\n";
					$message .= 	"Partner: $partner_name\n";
					$message .= 	"County: $partner_county\n";
					$message .= 	"Category: $partner_category\n";

					$message .= 	"----------\n\n";

					$message .=		"To approve this application:\n$approve_link\n\n";
					$message .= 	"or view all applications:\n$admin_link\n";

					$message .= 	"----------\n\n";

					switch ($partner_category) {
						case "farm":
							$message .=	"Products:\n";
							foreach ($products_array as $tempProduct) {
								$message .= "   $tempProduct\n";
							}
							if ($other_products != "") {
								$message .= "   $other_products\n";
							}
							$message .= "Acres: $acres\n";
							$message .= "----------\n\n";
							break;
						case "vineyard":
							$message .= "Acres: $acres\n";
							$message .= "----------\n\n";
							break;
						case "farmers-market":
						default:
							break;
					}

					$message .= "Billing Address:\n";
					if ($partner_billing_street_address != "") {
						$message .= "   $partner_billing_street_address\n";
					}
					if ($partner_billing_street_address_2 != "") {
						$message .= "   $partner_billing_street_address_2\n";
					}
					if ($partner_billing_city != "" && $partner_billing_state && $partner_billing_zip) {
						$message .= "   $partner_billing_city, $partner_billing_state  $partner_billing_zip\n";
					}
					$message .= "----------\n\n";

					$message .= "Contact Person:\n";
					if ($partner_contact_name != "") {
						$message .= "   Name: $partner_contact_name\n";
					}
					if ($partner_contact_position != "") {
						$message .= "   Job Title: $partner_contact_position\n";
					}
					if ($partner_contact_phone != "") {
						$message .= "   Phone: $partner_contact_phone\n";
					}
					if ($partner_contact_email != "") {
						$message .= "   Email: $partner_contact_email\n";
					}
					$message .= "----------\n\n";

					if ($partner_phone != "" || $partner_email != "" || $partner_website != "") {
						$message .= "More Details:\n";
						if ($partner_phone != "") {
							$message .= "   Business Phone: $partner_phone\n";
						}
						if ($partner_email != "") {
							$message .= "   Business Email: $partner_email\n";
						}
						if ($partner_website != "") {
							$message .= "   Business Website: $partner_website\n";
						}
						$message .= "----------\n\n";
					}

					if ($sources != "") {
						$message .= "Buys products from these GLV farms:\n";

						$message .= "$sources\n";

						$message .= "----------\n\n";
					}

					$message .=		"To approve this application:\n$approve_link\n\n";
					$message .= 	"or view all applications:\n$admin_link\n";

					$message .= 	"----------\n\n";

					$mail->setFrom('no-reply@buylocalglv.org', 'BuyLocalGLV');
					$mail->addAddress($to_address);     // Add a recipient
					$mail->addReplyTo('info@buylocalglv.com', 'BuyLocalGLV');

					$mail->Subject = $subject;
					$mail->Body    = $message;

					$mail->send();
					header("Location: /thanks.php");
				} else { $messages[] = "NOID-00"; }
			} else { $messages[] = "INSR-00"; }
		} else { $messages[] = "RQRD-00"; }
		$mysqli->close();
	} else { $messages[] = "DBCN-00"; }
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

        <title>Internal Error | Buy Fresh Buy Local - Greater Lehigh Valley</title>

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

        <link rel="stylesheet" type="text/css" href="/css/styles.css">
    </head>

    <body>
        <div class="site-wrapper">
            <div class="container signup-wrapper">
                <p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
                <h1 class="title">New Partner Application</h1>

                <p style="text-align: center;">There was an internal error during the registration process, please try again later.</p>
                <?php if (count($messages) > 0): $messages = join(", ", $messages); ?>
                <p class="error-messages"><span class="caption">The following errors were received:</span><br><?php echo $messages; ?></p>
                <?php endif; ?>

            </div>
        </div><!-- END: .site-wrapper -->

        <script src="/scripts/vendor/jquery/jquery.min.js"></script>
        <script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
        <script src="/scripts/plugins.min.js"></script>
        <script src="/scripts/scripts.min.js"></script>
    </body>
</html>