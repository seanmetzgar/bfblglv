<?php
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

    $uuid = $_REQUEST["uuid"];
    $uuid = (UUID::is_valid($uuid)) ? $uuid : false;
    $id = (int)$_REQUEST["id"];
    $id = is_int($id) ? $id : false;
    $email_id = $_REQUEST["email"];
    $email_id = (is_string($email_id)) ? $email_id : false;
    $email_h_file = false;
    $email_t_file = false;

    $renewal_year = getRenewalYear($server_name);

    switch ($email_id) {
    	case "R1":
    		$email_h_file = "{$cwd}/emails/renewal/email.html";
    		$email_t_file = "{$cwd}/emails/renewal/email.txt";

    		$email_farm_h_file = "{$cwd}/emails/renewal/farm-email.html";
            $email_farm_t_file = "{$cwd}/emails/renewal/farm-email.txt";
    		$email_subject = "Partnership Renewal";
    		break;
    	case "R2":
    		$email_h_file = "{$cwd}/emails/renewal/email2.html";
    		$email_t_file = "{$cwd}/emails/renewal/email2.txt";
            $email_farm_h_file = "{$cwd}/emails/renewal/farm-email2.html";
            $email_farm_t_file = "{$cwd}/emails/renewal/farm-email2.txt";
    		$email_subject = "Partnership Renewal";
    		break;
    	case "R3":
    		$email_h_file = "{$cwd}/emails/renewal/email3.html";
    		$email_t_file = "{$cwd}/emails/renewal/email3.txt";
            $email_farm_h_file = "{$cwd}/emails/renewal/farm-email3.html";
            $email_farm_t_file = "{$cwd}/emails/renewal/farm-email3.txt";
    		$email_subject = "Partnership Renewal";
    		break;
    	case "R4":
    		$email_h_file = "{$cwd}/emails/renewal/email4.html";
    		$email_t_file = "{$cwd}/emails/renewal/email4.txt";
            $email_farm_h_file = "{$cwd}/emails/renewal/farm-email4.html";
            $email_farm_t_file = "{$cwd}/emails/renewal/farm-email4.txt";
    		$email_subject = "Partnership Renewal Overdue";
    		break;
    	case "RT":
    		$email_h_file = "{$cwd}/emails/renewal/thanks.html";
    		$email_t_file = "{$cwd}/emails/renewal/thanks.txt";
            $email_farm_h_file = "{$cwd}/emails/renewal/thanks.html";
            $email_farm_t_file = "{$cwd}/emails/renewal/thanks.txt";
    		$email_subject = "Partnership Renewed";
            $update_date_h = (strtotime("{$renewal_year}-02-04") >= time()) ? "<strong>as soon as possible</strong>" : "by <strong>February 5, {$renewal_year}</strong>";
            $update_date_t = (strtotime("{$renewal_year}-02-04") >= time()) ? "as soon as possible" : "by February 5, {$renewal_year}";
    		break;
    	default:
    		$email_h_file = false;
    		$email_t_file = false;
            $email_farm_h_file = false;
            $email_farm_t_file = false;
    }

  	$valid_partner = false;

	$renewal_link = "http://{$server_name}/renewal.php?id={$id}&uuid={$uuid}";
    $partnerData = getRenewalPartner($id, $uuid, $server_name);

    if ($partnerData && is_object($partnerData)) {

        if ($partnerData->id === $id && $partnerData->renewalUUID === $uuid) {
            $valid_partner = true;
            $renewedStatus = $partnerData->renewedStatus;
            $partner_contact_email = $partnerData->contactEmail;
            $partner_contact_name = $partnerData->contactName;
            $partner_profile_link = $partnerData->profileURL;

        }
    }

    if ($valid_partner && $email_h_file && $email_farm_h_file):
		$subject = 		"{$email_subject}: Buy Fresh Buy Local - Greater Lehigh Valley";
		$to_address = 	$server_name == "partner.buylocalglv.org" ? $partner_contact_email : "sean.metzgar@gmail.com";
		// $to_address = $server_name == "partner.buylocalglv.org" ? "sean.metzgar@wearekudu.com" : "sean.metzgar@gmail.com";
		$from_address =	"no-reply@buylocalglv.org";

		if ($partnerData->category === "farm") {
            $h_message = file_get_contents($email_farm_h_file);
        } else {
            $h_message = file_get_contents($email_h_file);
        }

	    $h_message = str_replace("%%RENEWAL_LINK%%", $renewal_link, $h_message);
	    $h_message = str_replace("%%PROFILE_LINK%%", $partner_profile_link, $h_message);
	    $h_message = str_replace("%%POC_NAME%%", $partner_contact_name, $h_message);
	    $h_message = str_replace("%%RENEWAL_YEAR%%", $renewal_year, $h_message);

        if ($partnerData->category === "farm") {
            $t_message = file_get_contents($email_farm_t_file);
        } else {
            $t_message = file_get_contents($email_t_file);
        }
        
	    $t_message = str_replace("%%RENEWAL_LINK%%", $renewal_link, $t_message);
	    $t_message = str_replace("%%PROFILE_LINK%%", $partner_profile_link, $t_message);
	    $t_message = str_replace("%%POC_NAME%%", $partner_contact_name, $t_message);
	    $t_message = str_replace("%%RENEWAL_YEAR%%", $renewal_year, $t_message);

        if ($email_id == "RT") {
            $h_message = str_replace("%%UPDATE_LISTING_DATE%%", $update_date_h, $h_message);
            $t_message = str_replace("%%UPDATE_LISTING_DATE%%", $update_date_t, $t_message);
        }

		$mail->setFrom('no-reply@buylocalglv.org', 'BuyLocalGLV');
		$mail->addAddress($to_address);     // Add a recipient
		$mail->addReplyTo('info@buylocalglv.com', 'BuyLocalGLV');

		$mail->Subject = $subject;
		$mail->Body = $h_message;
		$mail->AltBody = $t_message;
		$mail->IsHTML(true);
    	$mail->CharSet = "utf-8";

		if ($mail->send()) {
			updateRenewalPartnerEmail($id, $uuid, $email_id, true, $server_name);
		} else {
			updateRenewalPartnerEmail($id, $uuid, $email_id, false, $server_name);
		}
        // echo "Email: $partner_contact_email";
	endif;