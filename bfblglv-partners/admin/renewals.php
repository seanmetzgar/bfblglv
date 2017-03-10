<?php
  require_once('../inc/phpmailer/PHPMailerAutoload.php');
  require_once('../inc/_inc_mysql.php');
  require_once("../inc/_inc_uuid.php");
  require_once("../inc/_inc_helpers.php");

  $renewalData = getRenewalData();
  $renewalYear = (is_object($renewalData) && property_exists($renewalData, "year")) ? $renewalData->year : false;
  $partners = (is_object($renewalData) && property_exists($renewalData, "partners")) ? $renewalData->partners : array();

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
                <h1 class="title">Partner Renewals<?php if ($renewalYear) echo ": {$renewalYear}"; ?></h1>

<?php
if (count($partners) > 0) {
	$partner_table = 			"<table class=\"partners-table table\" cellspacing=\"0\" width=\"100%\">\n";
	$partner_table .= 			"    <thead>\n";
	$partner_table .=			"        <tr>\n";
	$partner_table .=			"            <th>Partner</th>\n";
	$partner_table .=			"            <th>Category</th>\n";
	$partner_table .=			"            <th>Status</th>\n";
	$partner_table .=			"            <th>Emails</th>\n";
	$partner_table .=			"            <th>Actions</th>\n";
	$partner_table .=			"        </tr>";
	$partner_table .= 			"    </thead>\n";
	$partner_table .= 			"    <tbody>\n";
	foreach ($partners as $partner) {
		$partner_id = $partner->id;
		$partner_name = $partner->name;
		$partner_category = niceCategoryName($partner->category);
		$partner_renewed_status = $partner->renewedStatus;
		$partner_uuid = $partner->renewalUUID;

		$partner_email_1 = "not-sent";
		$partner_email_2 = "not-sent";
		$partner_email_3 = "not-sent";
		$partner_email_4 = "not-sent";
		$partner_email_T = "not-sent";
		$partner_email_1_nice = "Not Sent";
		$partner_email_2_nice = "Not Sent";
		$partner_email_3_nice = "Not Sent";
		$partner_email_4_nice = "Not Sent";
		$partner_email_T_nice = "Not Sent";
		$partner_email_string = array();

		if ($partner->email1Sent) {
			$partner_email_1 = "sent";
			$partner_email_1_nice = "Sent";
			if (!$partner->email1Status) {
				$partner_email_1 = "failed";
				$partner_email_1_nice = "Error";
			}
		}
		if ($partner->email2Sent) {
			$partner_email_2 = "sent";
			$partner_email_2_nice = "Sent";
			if (!$partner->email2Status) {
				$partner_email_2 = "failed";
				$partner_email_2_nice = "Error";
			}
		}
		if ($partner->email3Sent) {
			$partner_email_3 = "sent";
			$partner_email_3_nice = "Sent";
			if (!$partner->email3Status) {
				$partner_email_3 = "failed";
				$partner_email_3_nice = "Error";
			}
		}
		if ($partner->email4Sent) {
			$partner_email_4 = "sent";
			$partner_email_4_nice = "Sent";
			if (!$partner->email4Status) {
				$partner_email_4 = "failed";
				$partner_email_4_nice = "Error";
			}
		}
		if ($partner->emailTSent) {
			$partner_email_T = "sent";
			$partner_email_T_nice = "Sent";
			if (!$partner->emailTStatus) {
				$partner_email_T = "failed";
				$partner_email_T_nice = "Error";
			}
		}

		if ($partner_email_t == "sent" || $partner_email_t == "failed" || $partner_renewed_status) {
			$partner_email_1 = ($partner_email_1) !== "sent" ? "not-required" : "sent";
			$partner_email_2 = ($partner_email_2) !== "sent" ? "not-required" : "sent";
			$partner_email_3 = ($partner_email_3) !== "sent" ? "not-required" : "sent";
			$partner_email_4 = ($partner_email_4) !== "sent" ? "not-required" : "sent";
			$partner_email_1_nice = ($partner_email_1) !== "sent" ? "Not Required" : "Sent";
			$partner_email_2_nice = ($partner_email_2) !== "sent" ? "Not Required" : "Sent";
			$partner_email_3_nice = ($partner_email_3) !== "sent" ? "Not Required" : "Sent";
			$partner_email_4_nice = ($partner_email_4) !== "sent" ? "Not Required" : "Sent";
		}

		$partner_email_string[] = "<span class=\"email-status {$partner_email_1}\" title=\"Email 1: {$partner_email_1_nice}\">1</span>";
		$partner_email_string[] = "<span class=\"email-status {$partner_email_2}\" title=\"Email 2: {$partner_email_2_nice}\">2</span>";
		$partner_email_string[] = "<span class=\"email-status {$partner_email_3}\" title=\"Email 3: {$partner_email_3_nice}\">3</span>";
		$partner_email_string[] = "<span class=\"email-status {$partner_email_4}\" title=\"Email 4: {$partner_email_4_nice}\">4</span>";
		$partner_email_string[] = "<span class=\"email-status {$partner_email_T}\" title=\"Paid Email: {$partner_email_T_nice}\">$</span>";
		$partner_email_string = implode(" ", $partner_email_string);

		$actions = array();
		switch ($partner_renewed_status) {
			case 1:
				$partner_renewed_status_str = "Renewed";
				$partner_renewed_status_class = "user-renewed";
				if ($partner_email_T === "sent") {
					$actions[] = "<a href=\"/sendRenewalEmail.php?id={$partner_id}&uuid={$partner_uuid}&email=RT\" class=\"btn btn-default btn-xs\" title=\"RESEND Payment Confirmation\"><span class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></span></a>";
				} else {
					$actions[] = "<a href=\"/sendRenewalEmail.php?id={$partner_id}&uuid={$partner_uuid}&email=RT\" class=\"btn btn-default btn-xs\" title=\"Send Payment Confirmation\"><span class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></span></a>";
				}
				break;
			case 9:
				$partner_renewed_status_str = "Disabled";
				$partner_renewed_status_class = "user-disabled";
				$actions[] = "<a href=\"/markRenewalPaid.php?id={$partner_id}&uuid={$partner_uuid}\" class=\"btn btn-default btn-xs\" title=\"Mark as Paid & Re-enable\"><span class=\"glyphicon glyphicon-check\" aria-hidden=\"true\"></span></a>";
				break;
			case 0:
			default:
				$partner_renewed_status_str = "Not Renewed";
				$partner_renewed_status_class = "user-not-renewed";
				$tempEmailCode = "R1";
				if ($partner_email_1 === "sent" && $partner_email_2 !== "sent") {
					$tempEmailCode = "R2";
				} elseif ($partner_email_2 === "sent" && $partner_email_3 !== "sent") {
					$tempEmailCode = "R3";
				} elseif ($partner_email_3 === "sent" && $partner_email_4 !== "sent") {
					$tempEmailCode = "R4";
				} else {
					$tempEmailCode = "R1";
				}

				$actions[] = "<a href=\"/sendRenewalEmail.php?id={$partner_id}&uuid={$partner_uuid}&email={$tempEmailCode}\" class=\"btn btn-default btn-xs\" title=\"Send Renewal Email\"><span class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></span></a>";
				$actions[] = "<a href=\"/markRenewalPaid.php?id={$partner_id}&uuid={$partner_uuid}\" class=\"btn btn-default btn-xs\" title=\"Mark as Paid\"><span class=\"glyphicon glyphicon-check\" aria-hidden=\"true\"></span></a>";
				break;
		}
		$actions = implode(" ", $actions);

		$partner_table .=		"        <tr>\n";
		$partner_table .=		"            <td>{$partner_name}</td>\n";
		$partner_table .=		"            <td>{$partner_category}</td>\n";
		$partner_table .=		"            <td><span class=\"status-icon {$partner_renewed_status_class}\" title=\"{$partner_renewed_status_str}\">{$partner_renewed_status_str}</span></td>\n";
		$partner_table .=		"            <td align=\"center\"><span class=\"email-statuses\">{$partner_email_string}</span></td>";
		$partner_table .=		"            <td align=\"center\"><div class=\"btn-group actions\">{$actions}</div></td>";
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