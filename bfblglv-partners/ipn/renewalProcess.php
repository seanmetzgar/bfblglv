 <?php

    ini_set("log_errors", 1);
    ini_set("error_log", "./php-error.log");

    $currentDirectory = dirname(__FILE__);
    $environment = (strpos($currentDirectory, "/bfblglv/production/")) ? "production" : "development";
    $server_name = ($environment === "production") ? "partner.buylocalglv.org" : "partner.dev.buylocalglv.org";

    $cwd = "/home/bfblglv/{$environment}/partner.buylocalglv.org";

    $include_1 = "{$cwd}/inc/phpmailer/PHPMailerAutoload.php";
    $include_2 = "{$cwd}/inc/_inc_mysql.php";
    $include_3 = "{$cwd}/inc/_inc_uuid.php";
    $include_4 = "{$cwd}/inc/_inc_helpers.php";
    require_once($include_1);
    require_once($include_2);
    require_once($include_3);
    require_once($include_4);

    $custom = isset($_POST["custom"]) ? $_POST["custom"] : false;
    $custom_parts = explode("|", $custom);
    $register_pfb = false;
    if (is_array($custom_parts) && count($custom_parts) >= 2) {
        $uuid = (UUID::is_valid($custom_parts[1])) ? $custom_parts[1] : false;
        $id = (int)$custom_parts[0];
        $id = is_int($id) ? $id : false;
        if (array_key_exists(2, $custom_parts)) {
            switch($custom_parts[2]) {
                case "pfb:true":
                    $register_pfb = true;
            }
        }
    }

    $paypal_address = $server_name == "partner.buylocalglv.org" ?
      "https://www.paypal.com/cgi-bin/webscr" :
      "https://www.sandbox.paypal.com/cgi-bin/webscr";

    $valid_partner = false;
    $verified_payment = false;
    $payment_success = false;

    $renewal_year = getRenewalYear();
    $partnerData = getRenewalPartner($id, $uuid);

    if ($partnerData && is_object($partnerData)) {
        $amount_owed = get_amount_owed($partnerData->category);

        if ($partnerData->id === $id && $partnerData->renewalUUID === $uuid) {
            $valid_partner = true;
            $renewedStatus = $partnerData->renewedStatus;
        }
    }

    $verified_payment = true;
    $txn_id = isset($_POST["txn_id"]) ? $_POST["txn_id"] : false;

    if ($valid_partner && $verified_payment && $txn_id) {
        markRenewalPaid($id, $uuid, $renewal_year);
        if ($register_pfb) {
            addPFBRegistration($id, $uuid);
        }
        $exec_str = "/usr/bin/php {$cwd}/renewalMailer.php id={$partner_id} uuid={$partner_uuid} email=RT server_name={$server_name}";
        $checker = shell_exec($exec_str);
    } else $messages[] = "PART-01";