<?php
  require_once('./inc/phpmailer/PHPMailerAutoload.php');
  require_once('./inc/_inc_mysql.php');
  require_once("./inc/_inc_uuid.php");
  require_once("./inc/_inc_helpers.php");

    $uuid = $_REQUEST["uuid"];
    $uuid = (UUID::is_valid($uuid)) ? $uuid : false;
    $id = (int)$_REQUEST["id"];
    $id = is_int($id) ? $id : false;

    if ($uuid  && $id) {
        $select_query = "SELECT id, paid FROM registrations WHERE id=? AND uuid=? LIMIT 1";
        $select_statement = $mysqli->stmt_init();
        if ($select_statement->prepare($select_query)) {
            $select_statement->bind_param("is", $id, $uuid);
            $select_statement->execute();


            $select_result = $select_statement->get_result();
            if ($partner = $select_result->fetch_assoc()) {
                $valid_partner = count($partner) > 0 ? true : false;
                $paid = $partner["paid"];
            }
            $select_statement->close();
        }
    }

    if ($valid_partner) {
        header("Location: /payment.php?id=$id&uuid=$uuid");
    } else { header("Locaiton: /"); }?>