<?php
	class SimplePartner {
		public $id = false;
		public $name = false;
	}

	function niceCategoryName($slug) {
		switch($slug) {
			case "farmers-market":
				$rVal = "Producer-Only Farmers' Market";
				break;
			case "distillery":
				$rVal = "Brewery / Distillery";
				break;
			case "retail":
				$rVal = "Retail Operations";
				break;
			case "specialty":
				$rVal = "Specialty Products";
				break;
			default:
				$rVal = ucwords($slug);
		}
		return $rVal;
	}

	function nicePaymentStatus($paid) {
		$paid = ($paid == 1) ? "Yes" : "No";
		return $paid;
	}

	function get_amount_owed($slug) {
		switch($slug) {
			case "restaurant":
				$rVal = 250;
				break;
			case "institution":
			case "distributor":
				$rVal = 500;
				break;
			default:
				$rVal = 100;
		}
		return $rVal;
	}

	function niceStatusName($id) {
		switch($id) {
			case 0:
				$rVal = "Pending";
				break;
			case 1:
				$rVal = "Approved";
				break;
			case 2:
			  	$rVal = "Complete";
			 	break;
			case 3:
			  	$rVal = "Imported";
			 	break;
			case 7:
				$rVal = "Deleted";
				break;
			case 8:
				$rVal = "Import Failed";
				break;
			case 9:
				$rVal = "Declined";
				break;
			default:
				$rVal = "?";
		}
		return $rVal;
	}

	function getRegisteredPartners($server_name = false) {
		$server_name = (is_string($server_name) && strlen($server_name) > 0) ? $server_name : $_SERVER["SERVER_NAME"];
	  	$ajax_url_server = ($server_name === "partner.buylocalglv.org") ? "www.buylocalglv.org" : "dev.buylocalglv.org";
	  	$ajax_url = "http://{$ajax_url_server}/wp-admin/admin-ajax.php?action=xhrGetPartners";
		$json = file_get_contents($ajax_url);
		$data = json_decode($json);

		$rVal = false;
		$tempArray = array();

		if (is_object($data) && property_exists($data, "partners") && is_array($data->partners)) {
			foreach ($data->partners as $partner) {
				$has_fields = (is_object($partner) && property_exists($partner, "id") && property_exists($partner, "name")) ? true : false;
				if ($has_fields) {
					$partnerObj = new SimplePartner;
					$partnerObj->id = $partner->id;
					$partnerObj->name = $partner->name;

					if (is_int($partnerObj->id) && is_string($partnerObj->name) && $partnerObj->id > 0 && strlen($partnerObj->name) > 0) {
						$tempArray[] = $partnerObj;
					}
				}
			}
		}
		$rVal = (is_array($tempArray) && count($tempArray) > 0) ? $tempArray : false;
		return $rVal;
	}

	// function getRegisteredPartners() {
	// 	$rVal = false;
	// 	$tempArray = array();
	// 	global $mysqli;

	// 	if (!$mysqli->connect_errno) {
	// 		$select_query = "SELECT id, name FROM registrations WHERE status=1 OR status=2";
	// 		$select_statement = $mysqli->stmt_init();

	// 		if ($select_statement->prepare($select_query)) {
	// 			$select_statement->execute();

	// 			$select_result = $select_statement->get_result();
	// 			while ($partner = $select_result->fetch_assoc()) {
	// 				$has_fields = (is_array($partner) && count($partner) > 0) ? true : false;
	// 				if ($has_fields) {
	// 					$partnerObj = new SimplePartner;
	// 					$partnerObj->id = $partner["id"];
	// 					$partnerObj->name = $partner["name"];

	// 					if (is_int($partnerObj->id) && is_string($partnerObj->name) && $partnerObj->id > 0 && strlen($partnerObj->name) > 0) {
	// 						$tempArray[] = $partnerObj;
	// 					}
	// 				}
	// 			}
	// 			$select_statement->close();
	// 		}
	// 	}
	// 	$rVal = (is_array($tempArray) && count($tempArray) > 0) ? $tempArray : false;
	// 	return $rVal;
	// }


	function hoursInput($name, $arguments) {
		$defaultArguments = array(
			"seasonal" => false,
			"vendors" => false,
			"echo" => false
		);
		$arguments = (isset($arguments) && is_array($arguments)) ? array_merge($defaultArguments, $arguments) : $defaultArguments;

		$name = (isset($name) && strlen($name) > 0) ? $name : false;
		$seasonal = is_bool($arguments["seasonal"]) ? $arguments["seasonal"] : $defaultArguments["seasonal"];
		$vendors = is_bool($arguments["vendors"]) ? $arguments["vendors"] : $defaultArguments["vendors"];
		$echo = is_bool($arguments["echo"]) ? $arguments["echo"] : $defaultArguments["echo"];

		$output = "";
		if ($name) {
			for ($time_count = 0; $time_count < 12; $time_count++) {
                $hours_temp = ($time_count == 0) ? 12 : $time_count;
                $hours_output .= "<option value=\"$hours_temp:00\">$hours_temp:00</option>";
                $hours_output .= "<option value=\"$hours_temp:30\">$hours_temp:30</option>";
            }
			$output .=					"<div class=\"hours-input\">\n";
			$output .=					"    <fieldset class=\"hours-day\">\n";
			$output .= 					"        <div class=\"form-inline\">\n";
			$output .=					"            <select class=\"form-control\" name=\"{$name}_day_0\">\n";
			$output .=					"                <option value=\"\">Day</option>\n";
			$output .=					"                <option value=\"Monday\">Monday</option>\n";
			$output .=					"                <option value=\"Tuesday\">Tuesday</option>\n";
			$output .=					"                <option value=\"Wednesday\">Wednesday</option>\n";
			$output .=					"                <option value=\"Thursday\">Thursday</option>\n";
			$output .=					"                <option value=\"Friday\">Friday</option>\n";
			$output .=					"                <option value=\"Saturday\">Saturday</option>\n";
			$output .=					"                <option value=\"Sunday\">Sunday</option>\n";
			$output .=					"            </select>\n";

			$output .=					"            <span class=\"colon\">:&nbsp;&nbsp;</span>\n";

			$output .=					"            <select class=\"form-control\" name=\"{$name}_open_time_0\">\n";
			$output .=					"                <option value=\"\">Time</option>\n";
			$output .=					"                $hours_output\n";
			$output .=					"            </select>\n";

			$output .=					"            <select class=\"form-control\" name=\"{$name}_open_merid_0\">\n";
			$output .=					"                <option value=\"\"> </option>\n";
			$output .=					"                <option value=\"AM\">AM</option>\n";
			$output .=					"                <option value=\"PM\">PM</option>\n";
			$output .=					"            </select>\n";

			$output .=					"            <span class=\"to\">&nbsp;to&nbsp;</span>\n";

			$output .=					"            <select class=\"form-control\" name=\"{$name}_close_time_0\">\n";
			$output .=					"                <option value=\"\">Time</option>\n";
			$output .=					"                $hours_output\n";
			$output .=					"            </select>\n";

			$output .=					"            <select class=\"form-control\" name=\"{$name}_close_merid_0\">\n";
			$output .=					"                <option value=\"\"> </option>\n";
			$output .=					"                <option value=\"AM\">AM</option>\n";
			$output .=					"                <option value=\"PM\">PM</option>\n";
			$output .=					"            </select>\n";

			$output .=					"        </div>\n";

			//Start Seasonal
			if ($seasonal):
			$output .=					"        <label class=\"check-label seasonal-toggle\">\n";
			$output .=					"            <input type=\"checkbox\" class=\"reliant-toggle\" name=\"{$name}_seasonal_0\" value=\"1\">\n";
			$output .=					"            Seasonal?\n";
			$output .=					"        </label>\n";
			$output .=					"        <div class=\"reliant seasonal-info\"><div class=\"row\">\n";
			$output .= 					"            <label class=\"col-sm-6\">\n";
			$output .= 					"                <span class=\"label-text not-bold\">Start of Season:</span>\n";
			$output .= 					"                <div class=\"form-inline\">\n";
			$output .= 					"                    <div class=\"form-group\">\n";
			$output .= 					"                        <select name=\"{$name}_season_start_mpart_0\" class=\"form-control\">\n";
			$output .= 					"                            <option value=\"\" default>Select part of month</option>\n";
			$output .= 					"                            <option value=\"Beginning of\">Beginning</option>\n";
			$output .= 					"                            <option value=\"Middle of\">Middle</option>\n";
			$output .= 					"                            <option value=\"End of\">End</option>\n";
			$output .= 					"                        </select>\n";
			$output .= 					"                    </div>\n";
			$output .= 					"                    <div class=\"form-group\">\n";
			$output .= 					"                        <select name=\"{$name}_season_start_month_0\" class=\"form-control\">\n";
			$output .= 					"                            <option value=\"\" default>Select month</option>\n";
			$output .= 					"                            <option value=\"January\">January</option>\n";
			$output .= 					"                            <option value=\"February\">February</option>\n";
			$output .= 					"                            <option value=\"March\">March</option>\n";
			$output .= 					"                            <option value=\"April\">April</option>\n";
			$output .= 					"                            <option value=\"May\">May</option>\n";
			$output .= 					"                            <option value=\"June\">June</option>\n";
			$output .= 					"                            <option value=\"July\">July</option>\n";
			$output .= 					"                            <option value=\"August\">August</option>\n";
			$output .= 					"                            <option value=\"September\">September</option>\n";
			$output .= 					"                            <option value=\"October\">October</option>\n";
			$output .= 					"                            <option value=\"November\">November</option>\n";
			$output .= 					"                            <option value=\"December\">December</option>\n";
			$output .= 					"                        </select>\n";
			$output .= 					"                    </div>\n";
			$output .= 					"                </div>\n";
			$output .= 					"            </label>\n";
			$output .= 					"            <label class=\"col-sm-6\">\n";
			$output .= 					"                <span class=\"label-text not-bold\">End of Season:</span>\n";
			$output .= 					"                <div class=\"form-inline\">\n";
			$output .= 					"                    <div class=\"form-group\">\n";
			$output .= 					"                        <select name=\"{$name}_season_end_mpart_0\" class=\"form-control\">\n";
			$output .= 					"                            <option value=\"\" default>Select part of month</option>\n";
			$output .= 					"                            <option value=\"Beginning of\">Beginning</option>\n";
			$output .= 					"                            <option value=\"Middle of\">Middle</option>\n";
			$output .= 					"                            <option value=\"End of\">End</option>\n";
			$output .= 					"                        </select>\n";
			$output .= 					"                    </div>\n";
			$output .= 					"                    <div class=\"form-group\">\n";
			$output .= 					"                        <select name=\"{$name}_season_end_month_0\" class=\"form-control\">\n";
			$output .= 					"                            <option value=\"\" default>Select month</option>\n";
			$output .= 					"                            <option value=\"January\">January</option>\n";
			$output .= 					"                            <option value=\"February\">February</option>\n";
			$output .= 					"                            <option value=\"March\">March</option>\n";
			$output .= 					"                            <option value=\"April\">April</option>\n";
			$output .= 					"                            <option value=\"May\">May</option>\n";
			$output .= 					"                            <option value=\"June\">June</option>\n";
			$output .= 					"                            <option value=\"July\">July</option>\n";
			$output .= 					"                            <option value=\"August\">August</option>\n";
			$output .= 					"                            <option value=\"September\">September</option>\n";
			$output .= 					"                            <option value=\"October\">October</option>\n";
			$output .= 					"                            <option value=\"November\">November</option>\n";
			$output .= 					"                            <option value=\"December\">December</option>\n";
			$output .= 					"                        </select>\n";
			$output .= 					"                    </div>\n";
			$output .= 					"                </div>\n";
			$output .= 					"            </label>\n";
			$output .=					"        </div></div>\n";
			endif;
			//End Seasonal

			//Start Vendors
			if ($vendors):
			$output .=					"        <label class=\"form-inline\">\n";
			$output .=					"            <span># of vendors:</span>\n";
			$output .=					"            <input type=\"number\" class=\"form-control\" name=\"{$name}_vendors_0\">\n";
			$output .=					"        </label>\n";
			endif;
			//End Vendors

			$output .=					"    </fieldset>\n";
			$output .=					"    <a href=\"#\" class=\"btn btn-primary btn-xs hours-add-day\"><span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span> Add a Day</a>\n";
			$output .=					"</div>\n";
		}
		if ($echo) {
			echo $output;
		} else { return $output; }
	}

	function getHoursValue($name) {
		$name = (isset($name) && strlen($name) > 0) ? $name : false;
		$rVal = "";
		if ($name) {
			$name_set = array();
			$name_day = "{$name}_day";
			$name_open_time = "{$name}_open_time";
			$name_open_merid = "{$name}_open_merid";
			$name_close_time = "{$name}_close_time";
			$name_close_merid = "{$name}_close_merid";
			$name_seasonal = "{$name}_seasonal";
			$name_season_start_mpart = "{$name}_season_start_mpart";
			$name_season_start_month = "{$name}_season_start_month";
			$name_season_end_mpart = "{$name}_season_end_mpart";
			$name_season_end_month = "{$name}_season_end_month";
			$name_vendors = "{$name}_vendors";
			$hours_counter = 0;
			$hours_array = array();

			while(isset($_REQUEST["{$name_day}_{$hours_counter}"])) {
				$temp_day = 				$_REQUEST["{$name_day}_{$hours_counter}"];
				$temp_day = 				strlen($temp_day) > 0 ? $temp_day : false;
				$temp_open_time = 			$_REQUEST["{$name_open_time}_{$hours_counter}"];
				$temp_open_time = 			strlen($temp_open_time) > 0 ? $temp_open_time : false;
				$temp_open_merid = 			$_REQUEST["{$name_open_merid}_{$hours_counter}"];
				$temp_open_merid = 			strlen($temp_open_merid) > 0 ? $temp_open_merid : false;
				$temp_close_time = 			$_REQUEST["{$name_close_time}_{$hours_counter}"];
				$temp_close_time = 			strlen($temp_close_time) > 0 ? $temp_close_time : false;
				$temp_close_merid = 		$_REQUEST["{$name_close_merid}_{$hours_counter}"];
				$temp_close_merid = 		strlen($temp_close_merid) > 0 ? $temp_close_merid : false;
				$temp_seasonal = 			isset($_REQUEST["{$name_seasonal}_{$hours_counter}"]) ? $_REQUEST["{$name_seasonal}_{$hours_counter}"] : false;
				$temp_seasonal = 			$temp_seasonal == "1" ? true : false;

				$temp_season_start_mpart = 	isset($_REQUEST["{$name_season_start_mpart}_{$hours_counter}"]) ? $_REQUEST["{$name_season_start_mpart}_{$hours_counter}"] : "";
				$temp_season_start_mpart = 	strlen($temp_season_start_mpart) > 0 ? $temp_season_start_mpart : false;
				$temp_season_start_month = 	isset($_REQUEST["{$name_season_start_month}_{$hours_counter}"]) ? $_REQUEST["{$name_season_start_month}_{$hours_counter}"] : "";
				$temp_season_start_month = 	strlen($temp_season_start_month) > 0 ? $temp_season_start_month : false;
				$temp_season_end_mpart = 	isset($_REQUEST["{$name_season_end_mpart}_{$hours_counter}"]) ? $_REQUEST["{$name_season_end_mpart}_{$hours_counter}"] : "";
				$temp_season_end_mpart = 	strlen($temp_season_end_mpart) > 0 ? $temp_season_end_mpart : false;
				$temp_season_end_month = 	isset($_REQUEST["{$name_season_end_month}_{$hours_counter}"]) ? $_REQUEST["{$name_season_end_month}_{$hours_counter}"] : "";
				$temp_season_end_month = 	strlen($temp_season_end_month) > 0 ? $temp_season_end_month : false;

				$temp_vendors = 			isset($_REQUEST["{$name_vendors}_{$hours_counter}"]) ? $_REQUEST["{$name_vendors}_{$hours_counter}"] : "";
				$temp_vendors = 			strlen($temp_vendors) > 0 ? $temp_vendors : false;

				$temp_hours = "";
				if ($temp_day && $temp_open_time && $temp_open_merid && $temp_close_time && $temp_close_merid) {
					$temp_hours .= "{$temp_day}: {$temp_open_time}{$temp_open_merid}-{$temp_close_time}{$temp_close_merid}";
					if ($temp_seasonal && $temp_season_start_month && $temp_season_end_month) {
						$temp_hours .= " (";
						$temp_hours .= $temp_season_start_mpart ? "$temp_season_start_mpart " : "";
						$temp_hours .= $temp_season_start_month;
						$temp_hours .= " - ";
						$temp_hours .= $temp_season_end_mpart ? "$temp_season_end_mpart " : "";
						$temp_hours .= $temp_season_end_month;
						$temp_hours .= ")";
					}
					if ($temp_vendors) {
						$temp_hours .= " [{$temp_vendors} Vendors]";
					}
					$hours_array[] = $temp_hours;
				}

				$hours_counter++;
			}
			$rVal = implode("\n", $hours_array);
		}

		return $rVal;
	}

	function getRenewalYear($server_name = false) {
		$server_name = ($server_name) ? $server_name : $_SERVER["SERVER_NAME"];
	  	$ajax_url_server = ($server_name === "partner.buylocalglv.org") ? "www.buylocalglv.org" : "dev.buylocalglv.org";
	  	$ajax_url = "http://{$ajax_url_server}/wp-admin/admin-ajax.php?action=xhrGetRenewalYear";
		$json = file_get_contents($ajax_url);
		$yearData = json_decode($json);

		$year = (is_object($yearData) && property_exists($yearData, "year")) ? $yearData->year : false;

		return $year;
	}

	function getRenewalData($server_name = false) {
		$server_name = (is_string($server_name) && strlen($server_name) > 0) ? $server_name : $_SERVER["SERVER_NAME"];
	  	$ajax_url_server = ($server_name === "partner.buylocalglv.org") ? "www.buylocalglv.org" : "dev.buylocalglv.org";
	  	$ajax_url = "http://{$ajax_url_server}/wp-admin/admin-ajax.php?action=xhrGetRenewalData";
		$json = file_get_contents($ajax_url);
		$data = json_decode($json);

		return $data;
	}

	function getRenewalPartner($id, $uuid, $server_name = false) {
		if (is_int($id) && UUID::is_valid($uuid)) {
			$server_name = (is_string($server_name) && strlen($server_name) > 0) ? $server_name : $_SERVER["SERVER_NAME"];
		  	$ajax_url_server = ($server_name === "partner.buylocalglv.org") ? "www.buylocalglv.org" : "dev.buylocalglv.org";
		  	$ajax_url = "http://{$ajax_url_server}/wp-admin/admin-ajax.php?action=xhrGetRenewalPartner&id={$id}&uuid={$uuid}";
			$json = file_get_contents($ajax_url);
			$data = json_decode($json);
			if (is_object($data) && property_exists($data, "partner")) {
				$data = $data->partner;
			} else { $data = false; }
		} else { $data = false; }
		return $data;
	}

	function updateRenewalPartnerEmail($id, $uuid, $email, $sent, $server_name = false) {
		if (is_int($id) && UUID::is_valid($uuid) && $email && is_bool($sent)) {
			$sent = $sent ? 1 : 0;
			$server_name = (is_string($server_name) && strlen($server_name) > 0) ? $server_name : $_SERVER["SERVER_NAME"];
		  	$ajax_url_server = ($server_name === "partner.buylocalglv.org") ? "www.buylocalglv.org" : "dev.buylocalglv.org";
		  	$ajax_url = "http://{$ajax_url_server}/wp-admin/admin-ajax.php?action=xhrUpdateRenewalPartnerEmail&id={$id}&uuid={$uuid}&email={$email}&sent={$sent}";
			$json = file_get_contents($ajax_url);
			$data = json_decode($json);
			if (is_object($data) && property_exists($data, "status")) {
				$data = $data->status;
			} else { $data = false; }
		} else { $data = false; }
		return $data;
	}

    function addPFBRegistration($id, $uuid, $server_name = false) {
        if (is_int($id) && is_int($renewalYear) && UUID::is_valid($uuid)) {
            $server_name = (is_string($server_name) && strlen($server_name) > 0) ? $server_name : $_SERVER["SERVER_NAME"];
            $ajax_url_server = ($server_name === "partner.buylocalglv.org") ? "www.buylocalglv.org" : "dev.buylocalglv.org";
            $ajax_url = "http://{$ajax_url_server}/wp-admin/admin-ajax.php?action=xhrAddPFBRegistration&id={$id}&uuid={$uuid}";
            $json = file_get_contents($ajax_url);
            $data = json_decode($json);
            if (is_object($data) && property_exists($data, "status")) {
                $data = $data->status;
            } else { $data = false; }
        } else { $data = false; }
        return $data;
    }

	function markRenewalPaid($id, $uuid, $renewalYear, $server_name = false) {
		if (is_int($id) && is_int($renewalYear) && UUID::is_valid($uuid)) {
			$server_name = (is_string($server_name) && strlen($server_name) > 0) ? $server_name : $_SERVER["SERVER_NAME"];
		  	$ajax_url_server = ($server_name === "partner.buylocalglv.org") ? "www.buylocalglv.org" : "dev.buylocalglv.org";
		  	$ajax_url = "http://{$ajax_url_server}/wp-admin/admin-ajax.php?action=xhrMarkRenewalPaid&id={$id}&uuid={$uuid}&year={$renewalYear}";
			$json = file_get_contents($ajax_url);
			$data = json_decode($json);
			if (is_object($data) && property_exists($data, "status")) {
				$data = $data->status;
			} else { $data = false; }
		} else { $data = false; }
		return $data;
	}

	//Mailer Function
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	$mail->Host       = "mail.buylocalglv.org"; // SMTP server example
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
	$mail->Username   = "no-reply@buylocalglv.org"; // SMTP account username example
	$mail->Password   = "aadf;lkj4";        // SMTP account password example