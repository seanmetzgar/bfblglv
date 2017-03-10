<?php
	set_time_limit ( 60 );

    // $environment = (isset($argv) && is_array($argv) && array_key_exists("server_name", $argv)) ? $argv["server_name"] : false;
    // $environment = (!$environment && isset($_SERVER) && array_key_exists("SERVER_NAME", $_SERVER)) ? $_SERVER["SERVER_NAME"] : false;
    // $environment = ($environment && $environment == "partner.buylocalglv.org") ? "production" : "development";
    $currentDirectory = dirname(__FILE__);
    $environment = (strpos($currentDirectory, "/bfblglv/production/")) ? "production" : "development";
    $server_name = ($environment === "production") ? "partner.buylocalglv.org" : "partner.dev.buylocalglv.org";

    $cwd = "/home/bfblglv/{$environment}/partner.buylocalglv.org";
    $include_1 = "{$cwd}/inc/phpmailer/PHPMailerAutoload.php";
    $include_2 = "{$cwd}/inc/_inc_mysql.php";
    $include_3 = "{$cwd}/inc/_inc_uuid.php";
    $include_4 = "{$cwd}/inc/_inc_helpers.php";
    $include_5 = "{$cwd}/inc/_inc_argv2request.php";
    require_once($include_1);
    require_once($include_2);
    require_once($include_3);
    require_once($include_4);
    require_once($include_5);

  	Argv2Request($argv);

  	$renewalData = getRenewalData($server_name);
  	$renewalYear = (is_object($renewalData) && property_exists($renewalData, "year")) ? $renewalData->year : false;
  	$partners = (is_object($renewalData) && property_exists($renewalData, "partners")) ? $renewalData->partners : array();
 	$email_id = $_REQUEST["email"];
    $email_id = (is_string($email_id)) ? $email_id : false;

    $smtp_limiter = 25;
    $send_counter = 0;
	if (count($partners) > 0) {
		foreach ($partners as $partner) {
			$partner_id = $partner->id;
			$partner_name = $partner->name;
			$partner_renewed_status = $partner->renewedStatus;
			$partner_uuid = $partner->renewalUUID;

			$email_status = "not-sent";
			$email_url = "http://{$server_name}/renewalMailer.php?id={$partner_id}&uuid={$partner_uuid}&email={$email_id}";

			switch($email_id) {
				case "R1":
					if ($partner->email1Sent) {
						$email_status = "sent";
						if (!$partner->email1Status) {
							$email_status = "failed";
						}
					}
					break;
				case "R2":
					if ($partner->email2Sent) {
						$email_status = "sent";
						if (!$partner->email2Status) {
							$email_status = "failed";
						}
					}
					break;
				case "R3":
					if ($partner->email3Sent) {
						$email_status = "sent";
						if (!$partner->email3Status) {
							$email_status = "failed";
						}
					}
					break;
				case "R4":
					if ($partner->email4Sent) {
						$email_status = "sent";
						if (!$partner->email4Status) {
							$email_status = "failed";
						}
					}
					break;
				case "RT":
					if ($partner->emailTSent) {
						$email_status = "sent";
						if (!$partner->emailTStatus) {
							$email_status = "failed";
						}
					}
					break;
				default:
			}
			$exec_str = "/usr/bin/php {$cwd}/renewalMailer.php id={$partner_id} uuid={$partner_uuid} email={$email_id} server_name={$server_name}";

			if (($email_status == "not-sent" || $email_status == "failed") && ((!$partner_renewed_status && $email_id != "RT") || ($partner_renewed_status && $email_id == "RT"))) {
				$send_counter++;
				if ($send_counter <= $smtp_limiter) {
					// echo $exec_str;
					$checker = shell_exec($exec_str);
					// echo $checker;
					if ($checker == "") { set_time_limit ( 60 ); }
					// set_time_limit ( 60 );
				} else {
					die();
				}
			}
		}
	}
?>