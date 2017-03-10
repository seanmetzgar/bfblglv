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

    if ($valid_partner) {
        header("Location: /renewal.php?id=$id&uuid=$uuid");
    } else { header("Locaiton: http://www.buylocalglv.org/"); }?>