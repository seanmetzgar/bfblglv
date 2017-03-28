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

    $renewal_year = getRenewalYear($server_name);

    $valid_partner = false;
    $partnerData = getRenewalPartner($id, $uuid, $server_name);

    if ($partnerData && is_object($partnerData)) {
        if ($partnerData->id === $id && $partnerData->renewalUUID === $uuid) {
            $valid_partner = true;
            $renewedStatus = $partnerData->renewedStatus;
        }
    }

    if ($valid_partner && $email_h_file):
        $subject =      "{$email_subject}: Buy Fresh Buy Local - Greater Lehigh Valley";
        $to_address =   $server_name == "partner.buylocalglv.org" ? $partner_contact_email : "sean.metzgar@gmail.com";
        // $to_address = $server_name == "partner.buylocalglv.org" ? "sean.metzgar@wearekudu.com" : "sean.metzgar@gmail.com";
        $from_address = "no-reply@buylocalglv.org";

        $h_message = file_get_contents($email_h_file);
        $h_message = str_replace("%%RENEWAL_LINK%%", $renewal_link, $h_message);
        $h_message = str_replace("%%PROFILE_LINK%%", $partner_profile_link, $h_message);
        $h_message = str_replace("%%POC_NAME%%", $partner_contact_name, $h_message);
        $h_message = str_replace("%%RENEWAL_YEAR%%", $renewal_year, $h_message);

        $t_message = file_get_contents($email_t_file);
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