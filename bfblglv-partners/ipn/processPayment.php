 <?php
    ini_set("log_errors", 1);
    ini_set("error_log", "./php-error.log");
  require_once('../inc/phpmailer/PHPMailerAutoload.php');
  require_once('../inc/_inc_mysql.php');
  require_once("../inc/_inc_uuid.php");
  require_once("../inc/_inc_helpers.php");

    $uuid = isset($_POST["custom"]) ? $_POST["custom"] : false;

    $server_name = $_SERVER["SERVER_NAME"];
    $paypal_address = $server_name == "partner.buylocalglv.org" ?
      "https://www.paypal.com/cgi-bin/webscr" :
      "https://www.sandbox.paypal.com/cgi-bin/webscr";

    $valid_partner = false;
    $verified_payment = false;
    $payment_success = false;

    if ($uuid) {
        $select_query = "SELECT * FROM registrations WHERE uuid=? LIMIT 1";
        $select_statement = $mysqli->stmt_init();
        if ($select_statement->prepare($select_query)) {
            $select_statement->bind_param("s", $uuid);
            $select_statement->execute();


            $select_result = $select_statement->get_result();
            if ($partner = $select_result->fetch_assoc()) {
                $valid_partner = count($partner) > 0 ? true : false;
                if ($valid_partner) {
                  $id = $partner["id"];

                }
            }
            $select_statement->close();
        }
    }

    $verified_payment = true;
    $txn_id = isset($_POST["txn_id"]) ? $_POST["txn_id"] : false;
    error_log($txn_id);

    if ($valid_partner && $verified_payment && $txn_id) {
        $verified_payment = 1;
        $insert_statement = $mysqli->stmt_init();
        if ($insert_statement->prepare("INSERT INTO `registration_payment` (`registration_id`, `txn_id`) VALUES (?, ?)")) {

            if (!$insert_statement->bind_param("is", $id, $txn_id)) { $messages[] = "BIND-01"; }

            if (!$insert_statement->execute()) { $messages[] = "EXEC-01"; }
            $insert_id = $mysqli->insert_id;

            $payment_success = is_int($insert_id) ? true : false;

            $insert_statement->close();
        } else { $messages[] = "INSR-01"; }
    }

    if ($payment_success) {
        $update_query = "UPDATE registrations SET paid=?, agreement=? WHERE id=? AND uuid=?";
        $update_statement = $mysqli->stmt_init();
        if ($update_statement->prepare($update_query)) {
            $paid_holder = 1;
            $agree_holder = 1;
            $update_statement->bind_param("iiis", $paid_holder, $agree_holder, $id, $uuid);
            $update_statement->execute();
            $update_statement->close();
        }
    }
