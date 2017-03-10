<?php
	require_once('../inc/phpmailer/PHPMailerAutoload.php');
	require_once('../inc/_inc_mysql.php');
	require_once("../inc/_inc_uuid.php");
	require_once("../inc/_inc_helpers.php");

	$uuid = $_REQUEST["uuid"];
	$uuid = strlen($uuid) > 10 ? $uuid : false;
	$id = (int)$_REQUEST["id"];
	$id = is_int($id) ? $id : false;

	$email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : false;

	if ($uuid && $id && $email) {
        $select_query = "SELECT email, contact_email FROM registrations WHERE id=? AND uuid=? LIMIT 1";
        $select_statement = $mysqli->stmt_init();
        if ($select_statement->prepare($select_query)) {
            $select_statement->bind_param("is", $id, $uuid);
            $select_statement->execute();


            $select_result = $select_statement->get_result();
            if ($partner = $select_result->fetch_assoc()) {
                $valid_partner = count($partner) > 0 ? true : false;
                if ($valid_partner) {
					        $partner_email = (is_string($partner["email"]) && strlen($partner["email"]) > 0) ? $partner["email"] : false;
					        $contact_email = (is_string($partner["contact_email"]) && strlen($partner["contact_email"]) > 0) ? $partner["contact_email"] : false;

					        $to_address = ($contact_email) ? $contact_email : $partner_email;
                  $message = false;
                  $subject = false;
                  $server_name = $_SERVER["SERVER_NAME"];

                  switch ($email) {
              			case "payment":
              				$link = "http://$server_name/payment.php?id=$id&uuid=$uuid";
              				$message = "Your application to become a BuyLocalGLV Partner has been APPROVED. To continue the registration process click the link below and complete the form.\n\n";
              				$message .= "$link\n\n";
              				$message .= "Thank you,\nBuy Fresh Buy Local Greater Lehigh Valley\n";
              				$subject = "Your BuyLocalGLV Application has been Approved.";
              				break;
              			case "continue":
                      $link = "http://$server_name/continue.php?id=$id&uuid=$uuid";
              				$message = "Your payment to become a BuyLocalGLV Partner has been RECEIVED. To continue the registration process click the link below and complete the form.\n\n";
                      $message .= "$link\n\n";
                      $message .= "Thank you,\nBuy Fresh Buy Local Greater Lehigh Valley\n";
              				$subject = "Your BuyLocalGLV Application is ready for completion.";
              				break;
              		}
                  if ($to_address && $message && $subject) {
              			$mail->setFrom('no-reply@buylocalglv.org', 'BuyLocalGLV');
              			$mail->addAddress($to_address);     // Add a recipient
              			$mail->addReplyTo('info@buylocalglv.com', 'BuyLocalGLV');

              			$mail->Subject = $subject;
              			$mail->Body    = $message;

              			$mail->send();
              		}
                }
            }
            $select_statement->close();
        }
	}

	header("Location: /admin/applications.php");
