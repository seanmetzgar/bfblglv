<?php
	require_once('../inc/phpmailer/PHPMailerAutoload.php');
	require_once('../inc/_inc_mysql.php');
	require_once("../inc/_inc_uuid.php");
	require_once("../inc/_inc_helpers.php");

	$uuid = $_REQUEST["uuid"];
	$uuid = strlen($uuid) > 10 ? $uuid : false;
	$id = (int)$_REQUEST["id"];
	$id = is_int($id) ? $id : false;

	$paid = (int)$_REQUEST["paid"];
	$paid = is_int($paid) && $paid == 1 ? 1 : 0;
	$agree = $paid;

	if ($uuid && $id) {
        $select_query = "SELECT * FROM registrations WHERE id=? AND uuid=? LIMIT 1";
        $select_statement = $mysqli->stmt_init();
        if ($select_statement->prepare($select_query)) {
            $select_statement->bind_param("is", $id, $uuid);
            $select_statement->execute();


            $select_result = $select_statement->get_result();
            if ($partner = $select_result->fetch_assoc()) {
                $valid_partner = count($partner) > 0 ? true : false;
                if ($valid_partner) {
                	$update_query = "UPDATE registrations SET paid=?, agreement=? WHERE id=? AND uuid=?";
					$update_statement = $mysqli->stmt_init();
					if ($update_statement->prepare($update_query)) {
						$update_statement->bind_param("iiis", $paid, $agree, $id, $uuid);
						$update_statement->execute();
						$update_statement->close();
					}

					$partner_email = (is_string($partner["email"]) && strlen($partner["email"]) > 0) ? $partner["email"] : false;
					$contact_email = (is_string($partner["contact_email"]) && strlen($partner["contact_email"]) > 0) ? $partner["contact_email"] : false;

					$to_address = ($contact_email) ? $contact_email : $partner_email;
                }
            }
            $select_statement->close();
        }

        $message = false;
        $subject = false;
		switch ($paid) {
			case 1:
				$server_name = $_SERVER["SERVER_NAME"];
				$link = "http://$server_name/continue.php?id=$id&uuid=$uuid";
				$message = "Your application to become a BuyLocalGLV Partner has been listed as PAID. To complete the registration process click the link below and complete the form.\n\n";
				$message .= "$link\n\n";
				$message .= "Thank you,\nBuy Fresh Buy Local Greater Lehigh Valley\n";
				$subject = "Your BuyLocalGLV Application has been marked as Paid.";

				if ($to_address) {
					$mail->setFrom('no-reply@buylocalglv.org', 'BuyLocalGLV');
					$mail->addAddress($to_address);     // Add a recipient
					$mail->addReplyTo('info@buylocalglv.com', 'BuyLocalGLV');

					$mail->Subject = $subject;
					$mail->Body    = $message;

					$mail->send();
				}
				break;
		}
	}	

	header("Location: /admin/applications.php");