<?php
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

    $uuid = $_REQUEST["uuid"];
    $uuid = (UUID::is_valid($uuid)) ? $uuid : false;
    $id = (int)$_REQUEST["id"];
    $id = is_int($id) ? $id : false;
    $renewal_year = getRenewalYear();

    $partner = getRenewalPartner($id, $uuid);
    if ($uuid && $id && $partner) {
        markRenewalPaid($id, $uuid, $renewal_year);
        $exec_str = "/usr/bin/php {$cwd}/renewalMailer.php id={$partner_id} uuid={$partner_uuid} email=RT server_name={$server_name}";
        shell_exec($exec_str);
    }

    header("Location: /admin/renewals.php");