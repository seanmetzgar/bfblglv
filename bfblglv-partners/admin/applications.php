<?php
  require_once('../inc/phpmailer/PHPMailerAutoload.php');
  require_once('../inc/_inc_mysql.php');
  require_once("../inc/_inc_uuid.php");
  require_once("../inc/_inc_helpers.php");

	$partners = array();
	$p = array();
	$fixes = array();


	if (!$mysqli->connect_errno) {
		$fix_statement = $mysqli->stmt_init();
		if ($fix_statement->prepare("SELECT id FROM registrations WHERE uuid = ''")) {
			$fix_statement->execute();
			$fix_statement->bind_result($tempID);
			while($fix_statement->fetch()) {
				$tempUUID = UUID::v4();


				$fixes[] = array("id" => $tempID, "uuid" => $tempUUID);
			}

			if (count($fixes > 0)) {
				$fix_query = "UPDATE `registrations` SET `uuid`=? WHERE `id`=?";
				foreach ($fixes as $fix) {
					$fix_update_statement = $mysqli->stmt_init();
					if ($fix_update_statement->prepare($fix_query)) {
						$fix_update_statement->bind_param("si", $fix["uuid"], $fix["id"]);
						$fix_update_statement->execute();
					}
					$fix_update_statement->close();
				}
			}
		}
		$fix_statement->close();

		$fix_statement = $mysqli->stmt_init();
		if ($fix_statement->prepare("SELECT id, category FROM registrations WHERE amount_owed = ''")) {
			$fix_statement->execute();
			$fix_statement->bind_result($tempID, $tempCategory);
			while($fix_statement->fetch()) {
				$tempAmountOwed = get_amount_owed($tempCategory);

				$fixes[] = array("id" => $tempID, "amount_owed" => $tempAmountOwed);
			}

			if (count($fixes > 0)) {
				$fix_query = "UPDATE `registrations` SET `amount_owed`=? WHERE `id`=?";
				foreach ($fixes as $fix) {
					$fix_update_statement = $mysqli->stmt_init();
					if ($fix_update_statement->prepare($fix_query)) {
						$fix_update_statement->bind_param("ii", $fix["amount_owed"], $fix["id"]);
						$fix_update_statement->execute();
					}
					$fix_update_statement->close();
				}
			}
		}
		$fix_statement->close();

		$select_statement = $mysqli->stmt_init();
		if ($select_statement->prepare("SELECT id, name, primary_county, category, status, paid, uuid, created_ts FROM registrations WHERE status != 7")) {
			$select_statement->execute();
			$select_statement->bind_result($p_id, $p_name, $p_county, $p_category, $p_status, $p_paid, $p_uuid, $p_created);

			while ($select_statement->fetch()) {
				$p = array();
				$p["id"] = $p_id;
				$p["name"] = $p_name;
				$p["county"] = $p_county;
				$p["category"] = $p_category;
				$p["status"] = $p_status;
				$p["paid"] = $p_paid;
				$p["uuid"] = $p_uuid;
				$p["created"] = $p_created;

				$p["link"] = (strlen($p["uuid"]) > 10) ? "approve.php?id={$p["id"]}&uuid={$p["uuid"]}" : false;
				$p["sendLink"] = (strlen($p["uuid"]) > 10) ? "send_to_wp.php?id={$p["id"]}&uuid={$p["uuid"]}" : false;
				$p["deleteLink"] = (strlen($p["uuid"]) > 10) ? "change_status.php?id={$p["id"]}&uuid={$p["uuid"]}&status=7" : false;
				$partners[] = $p;
				$p = null;
			}
			$select_statement->close();
		} else {
			echo "failed to init mysqli statement";
		}
	} else {
		echo "failed to init mysqli connection";
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

        <title>Partner Applications | Buy Fresh Buy Local - Greater Lehigh Valley</title>

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

        <link rel="stylesheet" type="text/css" href="/css/styles.css">
    </head>

    <body>
        <div class="site-wrapper">
            <div class="container">
                <p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
                <h1 class="title">Partner Applications</h1>

<?php
if (count($partners) > 0) {
	$partner_table = 			"<table class=\"partners-table table\" cellspacing=\"0\" width=\"100%\">\n";
	$partner_table .= 			"    <thead>\n";
	$partner_table .=			"        <tr>\n";
	$partner_table .=			"            <th>Partner</th>\n";
	$partner_table .=			"            <th>Category</th>\n";
	$partner_table .=			"            <th>County</th>\n";
	$partner_table .=			"            <th>Application Date</th>\n";
	$partner_table .=			"            <th>Status</th>\n";
	$partner_table .=			"            <th>Paid</th>\n";
	$partner_table .=			"            <th>Action</th>\n";
	$partner_table .=			"            <th>Delete?</th>\n";
	$partner_table .=			"        </tr>";
	$partner_table .= 			"    </thead>\n";
	$partner_table .= 			"    <tbody>\n";
	foreach ($partners as $partner) {
		$category = niceCategoryName($partner["category"]);
		$status = niceStatusName($partner["status"]);
		$paid = nicePaymentStatus($partner["paid"]);
		$partner_table .=		"        <tr>\n";
		if ($partner["link"]) {
			$partner_table .=	"            <td><a href=\"{$partner["link"]}\">{$partner["name"]}</a></td>\n";
		} else {
			$partner_table .=	"            <td>{$partner["name"]}</td>\n";
		}
		$partner_table .=		"            <td>{$category}</td>\n";
		$partner_table .=		"            <td>{$partner["county"]}</td>\n";
		$partner_table .=		"            <td>{$partner["created"]}</td>\n";
		$partner_table .=		"            <td>{$status}</td>\n";
		$partner_table .=		"            <td>{$paid}</td>\n";
		if ($partner["status"] === 2) {
			$partner_table .=	"            <td><a href=\"{$partner["sendLink"]}\">Import</a></td>\n";
		} else {
			$partner_table .=	"            <td>&nbsp;</td>\n";
		}
		if ($partner["status"] !== 3) {
			$partner_table .=	"            <td><a href=\"{$partner["deleteLink"]}\">DELETE</a></td>\n";
		} else {
			$partner_table .=	"            <td>&nbsp;</td>\n";
		}
		$partner_table .=		"        </tr>";
	}
	$partner_table .= 			"    </tbody>\n";
	$partner_table .= 			"</table>\n";

	echo $partner_table;
}
?>

            </div>
        </div><!-- END: .site-wrapper -->

        <script src="/scripts/vendor/jquery/jquery.min.js"></script>
        <script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
        <script src="/scripts/plugins.min.js"></script>
        <script src="/scripts/scripts.min.js"></script>
    </body>
</html>