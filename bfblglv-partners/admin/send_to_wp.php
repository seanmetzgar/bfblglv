<?php
	require_once('../inc/phpmailer/PHPMailerAutoload.php');
	require_once('../inc/_inc_mysql.php');
	require_once("../inc/_inc_uuid.php");
	require_once("../inc/_inc_helpers.php");
	require_once("../inc/_inc_reference_keys.php");

	$uuid = $_REQUEST["uuid"];
	$uuid = strlen($uuid) > 10 ? $uuid : false;
	$id = (int)$_REQUEST["id"];
	$id = is_int($id) ? $id : false;

	$valid_partner = false;
	$valid_practices = false;
	$valid_practices = false;
	$valid_products = false;
	$valid_ws_products = false;

    $server_name = $_SERVER["SERVER_NAME"];
    $wp_server_name = $server_name == "partner.buylocalglv.org" ? "www.buylocalglv.org" : "dev.buylocalglv.org";


	if ($uuid && $id) {
        $partner_query = "SELECT * FROM registrations WHERE id=? AND uuid=? AND status=2 LIMIT 1";
        $details_query = "SELECT * FROM registration_details WHERE registration_id=? LIMIT 1";
        $practices_query = "SELECT * FROM registration_practices WHERE registration_id=? LIMIT 1";
        $products_query = "SELECT * FROM registration_products WHERE registration_id=? LIMIT 1";
        $ws_products_query = "SELECT * FROM registration_ws_products WHERE registration_id=? LIMIT 1";

        $partner_statement = $mysqli->stmt_init();
        if ($partner_statement->prepare($partner_query)) {
            $partner_statement->bind_param("is", $id, $uuid);
            $partner_statement->execute();


            $partner_result = $partner_statement->get_result();
            if ($partner = $partner_result->fetch_assoc()) {
                $valid_partner = count($partner) > 0 ? true : false;
            }
            $partner_statement->close();
        }

        if ($valid_partner) {
        	$details_statement = $mysqli->stmt_init();
	        if ($details_statement->prepare($details_query)) {
	            $details_statement->bind_param("i", $id);
	            $details_statement->execute();


	            $details_result = $details_statement->get_result();
	            if ($details = $details_result->fetch_assoc()) {
	                $valid_details = count($details) > 0 ? true : false;
	            }
	            $details_statement->close();
	        }
        }

        if ($valid_partner) {
        	$practices_statement = $mysqli->stmt_init();
	        if ($practices_statement->prepare($practices_query)) {
	            $practices_statement->bind_param("i", $id);
	            $practices_statement->execute();


	            $practices_result = $practices_statement->get_result();
	            if ($practices = $practices_result->fetch_assoc()) {
	                $valid_practices = count($practices) > 0 ? true : false;
	            }
	            $practices_statement->close();
	        }
        }

        if ($valid_partner) {
        	$products_statement = $mysqli->stmt_init();
	        if ($products_statement->prepare($products_query)) {
	            $products_statement->bind_param("i", $id);
	            $products_statement->execute();


	            $products_result = $products_statement->get_result();
	            if ($products = $products_result->fetch_assoc()) {
	                $valid_products = count($products) > 0 ? true : false;
	            }
	            $products_statement->close();
	        }
        }

        if ($valid_partner) {
        	$ws_products_statement = $mysqli->stmt_init();
	        if ($ws_products_statement->prepare($ws_products_query)) {
	            $ws_products_statement->bind_param("i", $id);
	            $ws_products_statement->execute();


	            $ws_products_result = $ws_products_statement->get_result();
	            if ($ws_products = $ws_products_result->fetch_assoc()) {
	                $valid_ws_products = count($ws_products) > 0 ? true : false;
	            }
	            $ws_products_statement->close();
	        }
        }
    }
    if ($valid_partner && $valid_details && $valid_practices && $valid_products && $valid_ws_products) {
    	unset($partner["id"]);
		unset($partner["last_modified_ts"]);
		unset($partner["approved_ts"]);
    	unset($details["id"]);
    	unset($details["updated_ts"]);
    	unset($details["registration_id"]);
    	unset($practices["id"]);
    	unset($practices["updated_ts"]);
    	unset($practices["registration_id"]);
    	unset($products["id"]);
    	unset($products["updated_ts"]);
    	unset($products["registration_id"]);
    	unset($ws_products["id"]);
    	unset($ws_products["updated_ts"]);
    	unset($ws_products["registration_id"]);

    	//Prep and Merge all EXCEPT wholesale products array
    	$consolidated_data = array();
    	$consolidated_data = array_merge($consolidated_data, $partner);
    	$consolidated_data = array_merge($consolidated_data, $details);
    	$consolidated_data = array_merge($consolidated_data, $practices);
    	$consolidated_data = array_merge($consolidated_data, $products);

    	//Clear all EXCEPT wholesale products array
    	$partner = null;
    	$details = null;
    	$practices = null;
    	$products = null;

    	//Prep Wholesale Array with correct keys (use & clear $tempArray)
    	$tempArray = array();
    	foreach($ws_products as $ws_product_key=>$ws_product) {
    		$tempKey = str_replace("products_", "ws_products_", $ws_product_key);
    		$tempArray[$tempKey] = $ws_product;
    	}
    	$ws_products = $tempArray;
    	$tempArray = array();

    	//Merge wholesale products array in to consolidated data & clear array
    	$consolidated_data = array_merge($consolidated_data, $ws_products);
    	$ws_products = null;

    	//Update keys to match WordPress (for the most part)
    	foreach($consolidated_data as $key=>$value) {
    		$value = ($value === null) ? "" : $value;
    		$key = (array_key_exists($key, $reference_keys)) ? $reference_keys[$key] : $key;
    		$tempArray[$key] = $value;
    	}
    	$consolidated_data = null;
    	$consolidated_data = json_encode($tempArray);
    	$tempArray = null;

    	//Send to WP
        $curl_url = "http://{$wp_server_name}/wp-admin/admin-ajax.php?action=xhrAddPartner";
    	$ch = curl_init($curl_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $consolidated_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($consolidated_data))
		);
		$result = curl_exec($ch);

		$result = json_decode($result);

		if (is_object($result)) {
			if ($result->status == "success") {
				$update_query = "UPDATE registrations SET status=3 WHERE id=? AND uuid=?";
				$update_statement = $mysqli->stmt_init();
				if ($update_statement->prepare($update_query)) {
					$update_statement->bind_param("is", $id, $uuid);
					$update_statement->execute();
					$update_statement->close();
				}
			} else {
                $update_query = "UPDATE registrations SET status=8 WHERE id=? AND uuid=?";
                $update_statement = $mysqli->stmt_init();
                if ($update_statement->prepare($update_query)) {
                    $update_statement->bind_param("is", $id, $uuid);
                    $update_statement->execute();
                    $update_statement->close();
                }
            }
		}
    }

    header("Location: /admin/applications.php");