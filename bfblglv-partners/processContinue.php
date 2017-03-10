<?php
	require_once('./inc/phpmailer/PHPMailerAutoload.php');
	require_once('./inc/_inc_mysql.php');
	require_once("./inc/_inc_uuid.php");
	require_once("./inc/_inc_helpers.php");

	function getPhoto($photo_name) {
		$photo_name = is_string($photo_name) ? $photo_name : false;
		if ($photo_name) {
			$target_dir = "images/{$photo_name}s/";
			$photo_name = "{$photo_name}_photo";
			$photocheck_name = "photocheck_{$photo_name}";
			$date = new DateTime();
			$timestamp = $date->getTimestamp();
			$target_file = $target_dir . $timestamp . "-" . basename($_FILES[$photo_name]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST[$photocheck_name])) {
					$check = getimagesize($_FILES[$photo_name]["tmp_name"]);
					if($check !== false) {
							$uploadOk = 1;
					} else {
							$uploadOk = 0;
					}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
					$uploadOk = 0;
			}
			// Check file size
			if ($_FILES[$photo_name]["size"] > 5242880) {
					$uploadOk = 0;
			}
			// Allow certain file formats
			if(!in_array($imageFileType, array("jpg", "jpeg", "gif", "png"))) {
					$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			$rVal = false;
			if ($uploadOk == 1) {
					if (move_uploaded_file($_FILES[$photo_name]["tmp_name"], $target_file)) {
							$uploadOk = 1;
							$rVal = $target_file;
					} else {
							$uploadOk = 0;
					}
			}
		} else { $rVal = false; }
		return $rVal;
	}

//Core
	$uuid = $_REQUEST["uuid"];
	$uuid = strlen($uuid) > 10 ? $uuid : false;
	$id = (int)$_REQUEST["id"];
	$id = is_int($id) ? $id : false;
	$valid_partner = false;
	$needs_details = true;
	$needs_products = true;
	$needs_ws_products = true;
	$needs_practices = true;
	$details_success = false;
	$practices_success = false;
	$products_success = false;
	$ws_products_success = false;
	$messages = array();

	if (!$mysqli->connect_errno) {
		if ($uuid  && $id) {
			$select_query = "SELECT * FROM registrations WHERE id=? AND uuid=? LIMIT 1";
			$select_statement = $mysqli->stmt_init();
			if ($select_statement->prepare($select_query)) {
				$select_statement->bind_param("is", $id, $uuid);
				$select_statement->execute();


				$select_result = $select_statement->get_result();
				if ($partner = $select_result->fetch_assoc()) {
					$valid_partner = count($partner) > 0 ? true : false;
				}
				$select_statement->close();
			}
		}

		if ($valid_partner) {
			$select_1 = "SELECT COUNT(id) AS id_count FROM registration_details WHERE registration_id=?";
			$select_2 = "SELECT COUNT(id) AS id_count FROM registration_products WHERE registration_id=?";
			$select_3 = "SELECT COUNT(id) AS id_count FROM registration_practices WHERE registration_id=?";
			$select_4 = "SELECT COUNT(id) AS id_count FROM registration_ws_products WHERE registration_id=?";
			$select_statement_1 = $mysqli->stmt_init();
			$select_statement_2 = $mysqli->stmt_init();
			$select_statement_3 = $mysqli->stmt_init();
			$select_statement_4 = $mysqli->stmt_init();

			if ($select_statement_1->prepare($select_1)) {
				$select_statement_1->bind_param("i", $id);
				$select_statement_1->execute();

				$select_statement_1->bind_result($tester);
				if ($select_statement_1->fetch()) {
					$needs_details = $tester == 0 ? true : false;
				} else { $messages[] = "SEAR-01"; }
				$select_statement_1->close();
			}

			if ($select_statement_2->prepare($select_2)) {
				$select_statement_2->bind_param("i", $id);
				$select_statement_2->execute();

				$select_statement_2->bind_result($tester);
				if ($select_statement_2->fetch()) {
					$needs_products = $tester == 0 ? true : false;
				} else { $messages[] = "SEAR-02"; }
				$select_statement_2->close();
			}

			if ($select_statement_3->prepare($select_3)) {
				$select_statement_3->bind_param("i", $id);
				$select_statement_3->execute();

				$select_statement_3->bind_result($tester);
				if ($select_statement_3->fetch()) {
					$needs_practices = $tester == 0 ? true : false;
				} else { $messages[] = "SEAR-03"; }
				$select_statement_3->close();
			}

			if ($select_statement_4->prepare($select_4)) {
				$select_statement_4->bind_param("i", $id);
				$select_statement_4->execute();

				$select_statement_4->bind_result($tester);
				if ($select_statement_4->fetch()) {
					$needs_ws_products = $tester == 0 ? true : false;
				} else { $messages[] = "SEAR-03"; }
				$select_statement_4->close();
			}

			if ($needs_details && $needs_practices && $needs_products && $needs_ws_products) {
				if ($needs_details) {
					//Details
					// $hours = isset($_REQUEST["hours"]) ? $_REQUEST["hours"] : "";
					$hours = getHoursValue("hours");
					$is_farm_share = isset($_REQUEST["is_farm_share"]) ? $_REQUEST["is_farm_share"] : 0;
					$is_farm_share = $is_farm_share == "1" ? 1 : 0;
					$is_csa = isset($_REQUEST["is_csa"]) ? $_REQUEST["is_csa"] : 0;
					$is_csa = $is_csa == "1" ? 1 : 0;
					$season_weeks = isset($_REQUEST["season_weeks"]) ? $_REQUEST["season_weeks"] : "";
					$season_start_mpart = isset($_REQUEST["season_start_mpart"]) ? $_REQUEST["season_start_mpart"] : "";
					$season_start_month = isset($_REQUEST["season_start_month"]) ? $_REQUEST["season_start_month"] : "";
					$season_start = strlen($season_start_month) > 0 ? $season_start_month : "";
					$season_start = (strlen($season_start) > 0 && strlen($season_start_mpart) > 0) ? "$season_start_mpart $season_start" : $season_start;
					$season_end_mpart = isset($_REQUEST["season_end_mpart"]) ? $_REQUEST["season_end_mpart"] : "";
					$season_end_month = isset($_REQUEST["season_end_month"]) ? $_REQUEST["season_end_month"] : "";
					$season_end = strlen($season_end_month) > 0 ? $season_end_month : "";
					$season_end = (strlen($season_end) > 0 && strlen($season_end_mpart) > 0) ? "$season_end_mpart $season_end" : $season_end;					$full_shares = 			isset($_REQUEST["full_shares"]) ? $_REQUEST["full_shares"] : "";
					$cost_full_shares = 	isset($_REQUEST["cost_full_shares"]) ? $_REQUEST["cost_full_shares"] : "";
					$size_full_shares = 	isset($_REQUEST["size_full_shares"]) ? $_REQUEST["size_full_shares"] : "";
					$size_full_shares_type = isset($_REQUEST["size_full_shares_type"]) ? $_REQUEST["size_full_shares_type"] : "";
					$size_full_shares .= 	(strlen($size_full_shares_type) > 0 && strlen($size_full_shares) > 0) ? " $size_full_shares_type" : "";
					$half_shares = 			isset($_REQUEST["half_shares"]) ? $_REQUEST["half_shares"] : "";
					$cost_half_shares = 	isset($_REQUEST["cost_half_shares"]) ? $_REQUEST["cost_half_shares"] : "";
					$size_half_shares = 	isset($_REQUEST["size_half_shares"]) ? $_REQUEST["size_half_shares"] : "";
					$size_half_shares_type = isset($_REQUEST["size_half_shares_type"]) ? $_REQUEST["size_half_shares_type"] : "";
					$size_half_shares .= 	(strlen($size_half_shares_type) > 0 && strlen($size_half_shares) > 0) ? " $size_half_shares_type" : "";
					$possible_addons = 		isset($_REQUEST["possible_addons"]) ? $_REQUEST["possible_addons"] : "";
					$farm_pickup = 			isset($_REQUEST["farm_pickup"]) ? $_REQUEST["farm_pickup"] : 0;
					$farm_pickup = 			$farm_pickup == "1" ? 1 : 0;
					$farm_pickup_dt = 		isset($_REQUEST["farm_pickup_dt"]) ? $_REQUEST["farm_pickup_dt"] : "";
					$other_pickup = 		isset($_REQUEST["other_pickup"]) ? $_REQUEST["other_pickup"] : 0;
					$other_pickup = 		$other_pickup == "1" ? 1 : 0;
					$other_pickup_site = 	isset($_REQUEST["other_pickup_site"]) ? $_REQUEST["other_pickup_site"] : "";
					$other_pickup_dt = 		isset($_REQUEST["other_pickup_dt"]) ? $_REQUEST["other_pickup_dt"] : "";
					$facebook_url = 		isset($_REQUEST["facebook_url"]) ? $_REQUEST["facebook_url"] : "";
					$twitter_handle = 		isset($_REQUEST["twitter_handle"]) ? $_REQUEST["twitter_handle"] : "";
					$instagram_handle = 	isset($_REQUEST["instagram_handle"]) ? $_REQUEST["instagram_handle"] : "";
					$description = 			isset($_REQUEST["description"]) ? $_REQUEST["description"] : "";

					//Product Availability Questions
					$products_available_at = isset($_REQUEST["products_available_at"]) ? $_REQUEST["products_available_at"] : "";
					$products_available_at_other = isset($_REQUEST["products_available_at_other"]) ? $_REQUEST["products_available_at_other"] : "";
					$products_available_from = isset($_REQUEST["products_available_from"]) ? $_REQUEST["products_available_from"] : "";
					$products_available_from_other = isset($_REQUEST["products_available_from_other"]) ? $_REQUEST["products_available_from_other"] : "";
					$vendors = 				isset($_REQUEST["vendors"]) ? $_REQUEST["vendors"] : "";
					$vendor_list = 			isset($_REQUEST["vendor_list"]) ? $_REQUEST["vendor_list"] : "";
					$vendor_list_other = 	isset($_REQUEST["vendor_list_other"]) ? $_REQUEST["vendor_list_other"] : "";
					$source_from = 			isset($_REQUEST["source_from"]) ? $_REQUEST["source_from"] : "";
					$source_from_other = 	isset($_REQUEST["source_from_other"]) ? $_REQUEST["source_from_other"] : "";

					$prdocuts_available_at = is_array($products_available_at) ? implode(",", $prdocuts_available_at) : $products_available_at;					
					$prdocuts_available_from = is_array($prdocuts_available_from) ? implode(",", $prdocuts_available_from) : $products_available_from;
					$vendor_list = 			is_array($vendor_list) ? implode(",", $vendor_list) : $vendor_list;
					$source_from = 			is_array($source_from) ? implode(",", $source_from) : $source_from;

					$farm_type = 			isset($_REQUEST["farm_type"]) ? $_REQUEST["farm_type"] : "";
					$appointments = 		isset($_REQUEST["appointments"]) ? $_REQUEST["appointments"] : 0;

					//Farmer's Market Questions
					$market_manager = 		isset($_REQUEST["market_manager"]) ? $_REQUEST["market_manager"] : "";
					$market_ebt = 			isset($_REQUEST["market_ebt"]) ? $_REQUEST["market_ebt"] : "";
					$market_double_snap = 	isset($_REQUEST["market_double_snap"]) ? $_REQUEST["market_double_snap"] : 0;
					$market_double_snap = 	$market_double_snap === "1" ? 1 : 0;
					$market_fmnp = 			isset($_REQUEST["market_fmnp"]) ? $_REQUEST["market_fmnp"] : 0;
					$market_fmnp = 			$market_fmnp === "1" ? 1 : 0;

					//Photos
					$partner_photo = getPhoto("partner");
					$partner_photo = (!$partner_photo) ? "" : $partner_photo;
					$owner_photo = getPhoto("owner");
					$owner_photo = (!$owner_photo) ? "" : $owner_photo;

					$local_stock_freq = 	isset($_REQUEST["local_stock_freq"]) ? $_REQUEST["local_stock_freq"] : "";
					$local_stock_qty = 		isset($_REQUEST["local_stock_qty"]) ? $_REQUEST["local_stock_qty"] : "";

					$insert_statement = $mysqli->stmt_init();
					if ($insert_statement->prepare("INSERT INTO `registration_details` (registration_id, hours, is_farm_share, is_csa, season_weeks, season_start, season_end, full_shares, cost_full_shares, size_full_shares, half_shares, cost_half_shares, size_half_shares, possible_addons, farm_pickup, farm_pickup_dt, other_pickup, other_pickup_site, other_pickup_dt, facebook_url, twitter_handle, instagram_handle, description, partner_photo, owner_photo, local_stock_freq, local_stock_qty, products_available_at, products_available_at_other, products_available_from, products_available_from_other, vendors, vendor_list, vendor_list_other, source_from, source_from_other, farm_type, appointments, market_manager, market_ebt, market_double_snap, market_fmnp) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
						if (!$insert_statement->bind_param("isiissssssssssisissssssssssssssssssssissii", $id, $hours, $is_farm_share, $is_csa, $season_weeks, $season_start, $season_end, $full_shares, $cost_full_shares, $size_full_shares, $half_shares, $cost_half_shares, $size_half_shares, $possible_addons, $farm_pickup, $farm_pickup_dt, $other_pickup, $other_pickup_site, $other_pickup_dt, $facebook_url, $twitter_handle, $instagram_handle, $description, $partner_photo, $owner_photo, $local_stock_freq, $local_stock_qty, $products_available_at, $products_available_at_other, $products_available_from, $products_available_from_other, $vendors, $vendor_list, $vendor_list_other, $source_from, $source_from_other, $farm_type, $appointments, $market_manager, $market_ebt, $market_double_snap, $market_fmnp)) {
							$messages[] = "BIND-01";
						}
						if (!$insert_statement->execute()) { $messages[] = "EXEC-01"; }
						$insert_id = $mysqli->insert_id;

						$details_success = is_int($insert_id) ? true : false;

						$insert_statement->close();         
					} else { $messages[] = "INSR-01"; }

				}

				if ($needs_practices) {
					//Practices
					$certified_organic = $_REQUEST["certified_organic"];
					$certified_organic = ($certified_organic == "1") ? 1 : 0;
		
					$certified_organic_by = isset($_REQUEST["certified_organic_by"]) ? $_REQUEST["certified_organic_by"] : "";
					$certified_organic_since = isset($_REQUEST["certified_organic_since"]) ? $_REQUEST["certified_organic_since"] : "";

					$certified_naturally_grown = $_REQUEST["certified_naturally_grown"];
					$certified_naturally_grown = ($certified_naturally_grown == "1") ? 1 : 0;

					$certified_naturally_grown_since = isset($_REQUEST["certified_naturally_grown_since"]) ? $_REQUEST["certified_naturally_grown_since"] : "";

					$certified_biodynamic = $_REQUEST["certified_biodynamic"];
					$certified_biodynamic = ($certified_biodynamic == "1") ? 1 : 0;

					$certified_biodynamic_by = isset($_REQUEST["certified_biodynamic_by"]) ? $_REQUEST["certified_biodynamic_by"] : "";
					$certified_biodynamic_since = isset($_REQUEST["certified_biodynamic_since"]) ? $_REQUEST["certified_biodynamic_since"] : "";

					$only_organic = $_REQUEST["only_organic"];
					$only_organic = ($only_organic == "1") ? 1 : 0;
					$integrated_pest_management = $_REQUEST["integrated_pest_management"];
					$integrated_pest_management = ($integrated_pest_management == "1") ? 1 : 0;
					$non_gmo = $_REQUEST["non_gmo"];
					$non_gmo = ($non_gmo == "1") ? 1 : 0;
					$antibiotic_harmone_free = $_REQUEST["antibiotic_harmone_free"];
					$antibiotic_harmone_free = ($antibiotic_harmone_free == "1") ? 1 : 0;
					$pastured = $_REQUEST["pastured"];
					$pastured = ($pastured == "1") ? 1 : 0;
					$grass_fed = $_REQUEST["grass_fed"];
					$grass_fed = ($grass_fed == "1") ? 1 : 0;
					$extended_growing_season = $_REQUEST["extended_growing_season"];
					$extended_growing_season = ($extended_growing_season == "1") ? 1 : 0;
					$other_farming_practices_text = isset($_REQUEST["other_farming_practices_text"]) ? $_REQUEST["other_farming_practices_text"] : "";
					$accept_snap = $_REQUEST["accept_snap"];
					$accept_snap = ($accept_snap == "1") ? 1 : 0;
					$accept_fmnp = $_REQUEST["accept_fmnp"];
					$accept_fmnp = ($accept_fmnp == "1") ? 1 : 0;
					$wholesaler = $_REQUEST["wholesaler"];
					$wholesaler = ($wholesaler == "1") ? 1 : 0;
					$quasi_wholesale = $_REQUEST["quasi_wholesale"];
					$quasi_wholesale = ($quasi_wholesale == "1") ? 1 : 0;
					$small_wholesale = $_REQUEST["small_wholesale"];
					$small_wholesale = ($small_wholesale == "1") ? 1 : 0;
					$large_wholesale = $_REQUEST["large_wholesale"];
					$large_wholesale = ($large_wholesale == "1") ? 1 : 0;
					$gap_certified = $_REQUEST["gap_certified"];
					$gap_certified = ($gap_certified == "1") ? 1 : 0;

					$gap_certified_since = isset($_REQUEST["gap_certified_since"]) ? $_REQUEST["gap_certified_since"] : "";

					$gap_pending = $_REQUEST["gap_pending"];
					$gap_pending = ($gap_pending == "1") ? 1 : 0;

					$acres_owned = isset($_REQUEST["acres_owned"]) ? $_REQUEST["acres_owned"] : "";
					$acres_rented = isset($_REQUEST["acres_rented"]) ? $_REQUEST["acres_rented"] : "";
					$acres_production = isset($_REQUEST["acres_production"]) ? $_REQUEST["acres_production"] : "";

					$insert_statement = $mysqli->stmt_init();
					if ($insert_statement->prepare("INSERT INTO `registration_practices` (registration_id, certified_organic, certified_organic_by, certified_organic_since, certified_naturally_grown, certified_naturally_grown_since, certified_biodynamic, certified_biodynamic_by, certified_biodynamic_since, only_organic, integrated_pest_management, non_gmo, antibiotic_harmone_free, pastured, grass_fed, extended_growing_season, other_farming_practices_text, accept_snap, accept_fmnp, wholesaler, quasi_wholesale, small_wholesale, large_wholesale, gap_certified, gap_certified_since, gap_pending, acres_owned, acres_rented, acres_production) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
						if (!$insert_statement->bind_param("iissisissiiiiiiisiiiiiiisisss", $id, $certified_organic, $certified_organic_by, $certified_organic_since, $certified_naturally_grown, $certified_naturally_grown_since, $certified_biodynamic, $certified_biodynamic_by, $certified_biodynamic_since, $only_organic, $integrated_pest_management, $non_gmo, $antibiotic_harmone_free, $pastured, $grass_fed, $extended_growing_season, $other_farming_practices_text, $accept_snap, $accept_fmnp, $wholesaler, $quasi_wholesale, $small_wholesale, $large_wholesale, $gap_certified, $gap_certified_since, $gap_pending, $acres_owned, $acres_rented, $acres_production)) {
							$messages[] = "BIND-02";
						}
						if (!$insert_statement->execute()) { $messages[] = "EXEC-02"; }
						$insert_id = $mysqli->insert_id;

						$practices_success = is_int($insert_id) ? true : false;

						$insert_statement->close();         
					} else { $messages[] = "INSR-02"; }
				}

				if ($needs_products) {
					//Products

					//Base Product Arrays
					$products_greens  = $_REQUEST["products_greens"];
					$products_greens  = is_array($products_greens ) ? join("|", $products_greens) : "";
					$products_roots  = $_REQUEST["products_roots"];
					$products_roots  = is_array($products_roots ) ? join("|", $products_roots) : "";
					$products_seasonal  = $_REQUEST["products_seasonal"];
					$products_seasonal  = is_array($products_seasonal ) ? join("|", $products_seasonal) : "";
					$products_melons  = $_REQUEST["products_melons"];
					$products_melons  = is_array($products_melons ) ? join("|", $products_melons) : "";
					$products_herbs  = $_REQUEST["products_herbs"];
					$products_herbs  = is_array($products_herbs ) ? join("|", $products_herbs) : "";
					$products_berries  = $_REQUEST["products_berries"];
					$products_berries  = is_array($products_berries ) ? join("|", $products_berries) : "";
					$products_small_fruits  = $_REQUEST["products_small_fruits"];
					$products_small_fruits  = is_array($products_small_fruits ) ? join("|", $products_small_fruits) : "";
					$products_grains  = $_REQUEST["products_grains"];
					$products_grains  = is_array($products_grains ) ? join("|", $products_grains) : "";
					$products_value_added  = $_REQUEST["products_value_added"];
					$products_value_added  = is_array($products_value_added ) ? join("|", $products_value_added) : "";
					$products_flowers  = $_REQUEST["products_flowers"];
					$products_flowers  = is_array($products_flowers ) ? join("|", $products_flowers) : "";
					$products_plants  = $_REQUEST["products_plants"];
					$products_plants  = is_array($products_plants ) ? join("|", $products_plants) : "";
					$products_ornamentals  = $_REQUEST["products_ornamentals"];
					$products_ornamentals  = is_array($products_ornamentals ) ? join("|", $products_ornamentals) : "";
					$products_syrups  = $_REQUEST["products_syrups"];
					$products_syrups  = is_array($products_syrups ) ? join("|", $products_syrups) : "";
					$products_dairy  = $_REQUEST["products_dairy"];
					$products_dairy  = is_array($products_dairy ) ? join("|", $products_dairy) : "";
					$products_meats  = $_REQUEST["products_meats"];
					$products_meats  = is_array($products_meats ) ? join("|", $products_meats) : "";
					$products_poultry   = $_REQUEST["products_poultry"];
					$products_poultry   = is_array($products_poultry  ) ? join("|", $products_poultry ) : "";
					$products_agritourism  = $_REQUEST["products_agritourism"];
					$products_agritourism  = is_array($products_agritourism ) ? join("|", $products_agritourism) : "";
					$products_fibers  = $_REQUEST["products_fibers"];
					$products_fibers  = is_array($products_fibers ) ? join("|", $products_fibers) : "";
					$products_artisinal  = $_REQUEST["products_artisinal"];
					$products_artisinal  = is_array($products_artisinal ) ? join("|", $products_artisinal) : "";
					$products_liquids  = $_REQUEST["products_liquids"];
					$products_liquids  = is_array($products_liquids ) ? join("|", $products_liquids) : "";
					$products_educational  = $_REQUEST["products_educational"];
					$products_educational  = is_array($products_educational ) ? join("|", $products_educational) : "";
					$products_baked  = $_REQUEST["products_baked"];
					$products_baked  = is_array($products_baked ) ? join("|", $products_baked) : "";
					$products_nuts_seeds  = $_REQUEST["products_nuts_seeds"];
					$products_nuts_seeds  = is_array($products_nuts_seeds ) ? join("|", $products_nuts_seeds) : "";
					$products_extras = $_REQUEST["products_extras"];
					$products_extras = is_array($products_extras) ? join("|", $products_extras) : ""; 

					//Other Products
					$other_products_greens  = 			isset($_REQUEST["other_products_greens"]) ? $_REQUEST["other_products_greens"] : "";
					$other_products_roots  = 			isset($_REQUEST["other_products_roots"]) ? $_REQUEST["other_products_roots"] : "";
					$other_products_seasonal  = 		isset($_REQUEST["other_products_seasonal"]) ? $_REQUEST["other_products_seasonal"] : "";
					$other_products_melons  = 			isset($_REQUEST["other_products_melons"]) ? $_REQUEST["other_products_melons"] : "";
					$other_products_herbs  = 			isset($_REQUEST["other_products_herbs"]) ? $_REQUEST["other_products_herbs"] : "";
					$other_products_berries  = 			isset($_REQUEST["other_products_berries"]) ? $_REQUEST["other_products_berries"] : "";
					$other_products_small_fruits  = 	isset($_REQUEST["other_products_small_fruits"]) ? $_REQUEST["other_products_small_fruits"] : "";
					$other_products_grains  = 			isset($_REQUEST["other_products_grains"]) ? $_REQUEST["other_products_grains"] : "";
					$other_products_value_added  = 		isset($_REQUEST["other_products_value_added"]) ? $_REQUEST["other_products_value_added"] : "";
					$other_products_flowers  = 			isset($_REQUEST["other_products_flowers"]) ? $_REQUEST["other_products_flowers"] : "";
					$other_products_plants  = 			isset($_REQUEST["other_products_plants"]) ? $_REQUEST["other_products_plants"] : "";
					$other_products_ornamentals  = 		isset($_REQUEST["other_products_ornamentals"]) ? $_REQUEST["other_products_ornamentals"] : "";
					$other_products_syrups  = 			isset($_REQUEST["other_products_syrups"]) ? $_REQUEST["other_products_syrups"] : "";
					$other_products_dairy  = 			isset($_REQUEST["other_products_dairy"]) ? $_REQUEST["other_products_dairy"] : "";
					$other_products_meats  = 			isset($_REQUEST["other_products_meats"]) ? $_REQUEST["other_products_meats"] : "";
					$other_products_poultry  = 			isset($_REQUEST["other_products_poultry"]) ? $_REQUEST["other_products_poultry"] : "";
					$other_products_agritourism  = 		isset($_REQUEST["other_products_agritourism"]) ? $_REQUEST["other_products_agritourism"] : "";
					$other_products_fibers  = 			isset($_REQUEST["other_products_fibers"]) ? $_REQUEST["other_products_fibers"] : "";
					$other_products_artisinal  = 		isset($_REQUEST["other_products_artisinal"]) ? $_REQUEST["other_products_artisinal"] : "";
					$other_products_liquids  = 			isset($_REQUEST["other_products_liquids"]) ? $_REQUEST["other_products_liquids"] : "";
					$other_products_educational  = 		isset($_REQUEST["other_products_educational"]) ? $_REQUEST["other_products_educational"] : "";
					$other_products_baked  = 			isset($_REQUEST["other_products_baked"]) ? $_REQUEST["other_products_baked"] : "";
					$other_products_nuts_seeds  = 		isset($_REQUEST["other_products_nuts_seeds"]) ? $_REQUEST["other_products_nuts_seeds"] : "";
					$other_products_extras = 			isset($_REQUEST["other_products_extras"]) ? $_REQUEST["other_products_extras"] : "";
					$products_text = 					isset($_REQUEST["products_text"]) ? $_REQUEST["products_text"] : "";

					$insert_statement = $mysqli->stmt_init();
					if ($insert_statement->prepare("INSERT INTO `registration_products` (registration_id, products_greens, other_products_greens, products_roots, other_products_roots, products_seasonal, other_products_seasonal, products_melons, other_products_melons, products_herbs, other_products_herbs, products_berries, other_products_berries, products_small_fruits, other_products_small_fruits, products_grains, other_products_grains, products_value_added, other_products_value_added, products_flowers, other_products_flowers, products_plants, other_products_plants, products_ornamentals, other_products_ornamentals, products_syrups, other_products_syrups, products_dairy, other_products_dairy, products_meats, other_products_meats, products_poultry, other_products_poultry, products_agritourism, other_products_agritourism, products_fibers, other_products_fibers, products_artisinal, other_products_artisinal, products_liquids, other_products_liquids, products_educational, other_products_educational, products_baked, other_products_baked, products_nuts_seeds, other_products_nuts_seeds, products_extras, other_products_extras, products_text) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
						if (!$insert_statement->bind_param("isssssssssssssssssssssssssssssssssssssssssssssssss", $id, $products_greens, $other_products_greens, $products_roots, $other_products_roots, $products_seasonal, $other_products_seasonal, $products_melons, $other_products_melons, $products_herbs, $other_products_herbs, $products_berries, $other_products_berries, $products_small_fruits, $other_products_small_fruits, $products_grains, $other_products_grains, $products_value_added, $other_products_value_added, $products_flowers, $other_products_flowers, $products_plants, $other_products_plants, $products_ornamentals, $other_products_ornamentals, $products_syrups, $other_products_syrups, $products_dairy, $other_products_dairy, $products_meats, $other_products_meats, $products_poultry, $other_products_poultry, $products_agritourism, $other_products_agritourism, $products_fibers, $other_products_fibers, $products_artisinal, $other_products_artisinal, $products_liquids, $other_products_liquids, $products_educational, $other_products_educational, $products_baked, $other_products_baked, $products_nuts_seeds, $other_products_nuts_seeds, $products_extras, $other_products_extras, $products_text)) {
							$messages[] = "BIND-03";
						}
						if (!$insert_statement->execute()) { $messages[] = "EXEC-03"; }
						$insert_id = $mysqli->insert_id;

						$products_success = is_int($insert_id) ? true : false;

						$insert_statement->close();         
					} else { $messages[] = "INSR-03"; }
				}

				if ($needs_ws_products) {
					//Wholesale Products

					//Base Product Arrays
					$ws_products_greens  = $_REQUEST["ws_products_greens"];
					$ws_products_greens  = is_array($ws_products_greens ) ? join("|", $ws_products_greens) : "";
					$ws_products_roots  = $_REQUEST["ws_products_roots"];
					$ws_products_roots  = is_array($ws_products_roots ) ? join("|", $ws_products_roots) : "";
					$ws_products_seasonal  = $_REQUEST["ws_products_seasonal"];
					$ws_products_seasonal  = is_array($ws_products_seasonal ) ? join("|", $ws_products_seasonal) : "";
					$ws_products_melons  = $_REQUEST["ws_products_melons"];
					$ws_products_melons  = is_array($ws_products_melons ) ? join("|", $ws_products_melons) : "";
					$ws_products_herbs  = $_REQUEST["ws_products_herbs"];
					$ws_products_herbs  = is_array($ws_products_herbs ) ? join("|", $ws_products_herbs) : "";
					$ws_products_berries  = $_REQUEST["ws_products_berries"];
					$ws_products_berries  = is_array($ws_products_berries ) ? join("|", $ws_products_berries) : "";
					$ws_products_small_fruits  = $_REQUEST["ws_products_small_fruits"];
					$ws_products_small_fruits  = is_array($ws_products_small_fruits ) ? join("|", $ws_products_small_fruits) : "";
					$ws_products_grains  = $_REQUEST["ws_products_grains"];
					$ws_products_grains  = is_array($ws_products_grains ) ? join("|", $ws_products_grains) : "";
					$ws_products_value_added  = $_REQUEST["ws_products_value_added"];
					$ws_products_value_added  = is_array($ws_products_value_added ) ? join("|", $ws_products_value_added) : "";
					$ws_products_flowers  = $_REQUEST["ws_products_flowers"];
					$ws_products_flowers  = is_array($ws_products_flowers ) ? join("|", $ws_products_flowers) : "";
					$ws_products_plants  = $_REQUEST["ws_products_plants"];
					$ws_products_plants  = is_array($ws_products_plants ) ? join("|", $ws_products_plants) : "";
					$ws_products_ornamentals  = $_REQUEST["ws_products_ornamentals"];
					$ws_products_ornamentals  = is_array($ws_products_ornamentals ) ? join("|", $ws_products_ornamentals) : "";
					$ws_products_syrups  = $_REQUEST["ws_products_syrups"];
					$ws_products_syrups  = is_array($ws_products_syrups ) ? join("|", $ws_products_syrups) : "";
					$ws_products_dairy  = $_REQUEST["ws_products_dairy"];
					$ws_products_dairy  = is_array($ws_products_dairy ) ? join("|", $ws_products_dairy) : "";
					$ws_products_meats  = $_REQUEST["ws_products_meats"];
					$ws_products_meats  = is_array($ws_products_meats ) ? join("|", $ws_products_meats) : "";
					$ws_products_poultry   = $_REQUEST["ws_products_poultry"];
					$ws_products_poultry   = is_array($ws_products_poultry  ) ? join("|", $ws_products_poultry ) : "";
					$ws_products_agritourism  = $_REQUEST["ws_products_agritourism"];
					$ws_products_agritourism  = is_array($ws_products_agritourism ) ? join("|", $ws_products_agritourism) : "";
					$ws_products_fibers  = $_REQUEST["ws_products_fibers"];
					$ws_products_fibers  = is_array($ws_products_fibers ) ? join("|", $ws_products_fibers) : "";
					$ws_products_artisinal  = $_REQUEST["ws_products_artisinal"];
					$ws_products_artisinal  = is_array($ws_products_artisinal ) ? join("|", $ws_products_artisinal) : "";
					$ws_products_liquids  = $_REQUEST["ws_products_liquids"];
					$ws_products_liquids  = is_array($ws_products_liquids ) ? join("|", $ws_products_liquids) : "";
					$ws_products_educational  = $_REQUEST["ws_products_educational"];
					$ws_products_educational  = is_array($ws_products_educational ) ? join("|", $ws_products_educational) : "";
					$ws_products_baked  = $_REQUEST["ws_products_baked"];
					$ws_products_baked  = is_array($ws_products_baked ) ? join("|", $ws_products_baked) : "";
					$ws_products_nuts_seeds  = $_REQUEST["ws_products_nuts_seeds"];
					$ws_products_nuts_seeds  = is_array($ws_products_nuts_seeds ) ? join("|", $ws_products_nuts_seeds) : "";
					$ws_products_extras = $_REQUEST["ws_products_extras"];
					$ws_products_extras = is_array($ws_products_extras) ? join("|", $ws_products_extras) : ""; 
					//Other Products
					$other_ws_products_greens  = 			isset($_REQUEST["other_ws_products_greens"]) ? $_REQUEST["other_ws_products_greens"] : "";
					$other_ws_products_roots  = 			isset($_REQUEST["other_ws_products_roots"]) ? $_REQUEST["other_ws_products_roots"] : "";
					$other_ws_products_seasonal  = 			isset($_REQUEST["other_ws_products_seasonal"]) ? $_REQUEST["other_ws_products_seasonal"] : "";
					$other_ws_products_melons  = 			isset($_REQUEST["other_ws_products_melons"]) ? $_REQUEST["other_ws_products_melons"] : "";
					$other_ws_products_herbs  = 			isset($_REQUEST["other_ws_products_herbs"]) ? $_REQUEST["other_ws_products_herbs"] : "";
					$other_ws_products_berries  = 			isset($_REQUEST["other_ws_products_berries"]) ? $_REQUEST["other_ws_products_berries"] : "";
					$other_ws_products_small_fruits  = 		isset($_REQUEST["other_ws_products_small_fruits"]) ? $_REQUEST["other_ws_products_small_fruits"] : "";
					$other_ws_products_grains  = 			isset($_REQUEST["other_ws_products_grains"]) ? $_REQUEST["other_ws_products_grains"] : "";
					$other_ws_products_value_added  = 		isset($_REQUEST["other_ws_products_value_added"]) ? $_REQUEST["other_ws_products_value_added"] : "";
					$other_ws_products_flowers  = 			isset($_REQUEST["other_ws_products_flowers"]) ? $_REQUEST["other_ws_products_flowers"] : "";
					$other_ws_products_plants  = 			isset($_REQUEST["other_ws_products_plants"]) ? $_REQUEST["other_ws_products_plants"] : "";
					$other_ws_products_ornamentals  = 		isset($_REQUEST["other_ws_products_ornamentals"]) ? $_REQUEST["other_ws_products_ornamentals"] : "";
					$other_ws_products_syrups  = 			isset($_REQUEST["other_ws_products_syrups"]) ? $_REQUEST["other_ws_products_syrups"] : "";
					$other_ws_products_dairy  = 			isset($_REQUEST["other_ws_products_dairy"]) ? $_REQUEST["other_ws_products_dairy"] : "";
					$other_ws_products_meats  = 			isset($_REQUEST["other_ws_products_meats"]) ? $_REQUEST["other_ws_products_meats"] : "";
					$other_ws_products_poultry  = 			isset($_REQUEST["other_ws_products_poultry"]) ? $_REQUEST["other_ws_products_poultry"] : "";
					$other_ws_products_agritourism  = 		isset($_REQUEST["other_ws_products_agritourism"]) ? $_REQUEST["other_ws_products_agritourism"] : "";
					$other_ws_products_fibers  = 			isset($_REQUEST["other_ws_products_fibers"]) ? $_REQUEST["other_ws_products_fibers"] : "";
					$other_ws_products_artisinal  = 		isset($_REQUEST["other_ws_products_artisinal"]) ? $_REQUEST["other_ws_products_artisinal"] : "";
					$other_ws_products_liquids  = 			isset($_REQUEST["other_ws_products_liquids"]) ? $_REQUEST["other_ws_products_liquids"] : "";
					$other_ws_products_educational  = 		isset($_REQUEST["other_ws_products_educational"]) ? $_REQUEST["other_ws_products_educational"] : "";
					$other_ws_products_baked  = 			isset($_REQUEST["other_ws_products_baked"]) ? $_REQUEST["other_ws_products_baked"] : "";
					$other_ws_products_nuts_seeds  = 		isset($_REQUEST["other_ws_products_nuts_seeds"]) ? $_REQUEST["other_ws_products_nuts_seeds"] : "";
					$other_ws_products_extras = 			isset($_REQUEST["other_ws_products_extras"]) ? $_REQUEST["other_ws_products_extras"] : "";
					$ws_products_text = isset($_REQUEST["ws_products_text"]) ? $_REQUEST["ws_products_text"] : "";

					$insert_statement = $mysqli->stmt_init();
					if ($insert_statement->prepare("INSERT INTO `registration_ws_products` (registration_id, products_greens, other_products_greens, products_roots, other_products_roots, products_seasonal, other_products_seasonal, products_melons, other_products_melons, products_herbs, other_products_herbs, products_berries, other_products_berries, products_small_fruits, other_products_small_fruits, products_grains, other_products_grains, products_value_added, other_products_value_added, products_flowers, other_products_flowers, products_plants, other_products_plants, products_ornamentals, other_products_ornamentals, products_syrups, other_products_syrups, products_dairy, other_products_dairy, products_meats, other_products_meats, products_poultry, other_products_poultry, products_agritourism, other_products_agritourism, products_fibers, other_products_fibers, products_artisinal, other_products_artisinal, products_liquids, other_products_liquids, products_educational, other_products_educational, products_baked, other_products_baked, products_nuts_seeds, other_products_nuts_seeds, products_extras, other_products_extras, products_text) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
						if (!$insert_statement->bind_param("isssssssssssssssssssssssssssssssssssssssssssssssss", $id, $ws_products_greens, $other_ws_products_greens, $ws_products_roots, $other_ws_products_roots, $ws_products_seasonal, $other_ws_products_seasonal, $ws_products_melons, $other_ws_products_melons, $ws_products_herbs, $other_ws_products_herbs, $ws_products_berries, $other_ws_products_berries, $ws_products_small_fruits, $other_ws_products_small_fruits, $ws_products_grains, $other_ws_products_grains, $ws_products_value_added, $other_ws_products_value_added, $ws_products_flowers, $other_ws_products_flowers, $ws_products_plants, $other_ws_products_plants, $ws_products_ornamentals, $other_ws_products_ornamentals, $ws_products_syrups, $other_ws_products_syrups, $ws_products_dairy, $other_ws_products_dairy, $ws_products_meats, $other_ws_products_meats, $ws_products_poultry, $other_ws_products_poultry, $ws_products_agritourism, $other_ws_products_agritourism, $ws_products_fibers, $other_ws_products_fibers, $ws_products_artisinal, $other_ws_products_artisinal, $ws_products_liquids, $other_ws_products_liquids, $ws_products_educational, $other_ws_products_educational, $ws_products_baked, $other_ws_products_baked, $ws_products_nuts_seeds, $other_ws_products_nuts_seeds, $ws_products_extras, $other_ws_products_extras, $ws_products_text)) {
							$messages[] = "BIND-04";
						}
						if (!$insert_statement->execute()) { $messages[] = "EXEC-04"; }
						$insert_id = $mysqli->insert_id;

						$ws_products_success = is_int($insert_id) ? true : false;

						$insert_statement->close();         
					} else { $messages[] = "INSR-04"; }
				}

				if ($details_success && $products_success && $practices_success && $ws_products_success && count($messages) == 0) {
					$update_query = "UPDATE registrations SET status=? WHERE id=? AND uuid=?";
					$update_statement = $mysqli->stmt_init();
					if ($update_statement->prepare($update_query)) {
						$status_holder = 2;
						$update_statement->bind_param("iis", $status_holder, $id, $uuid);
						$update_statement->execute();
						$update_statement->close();
					}
				}
			} else {
				$messages[] = "DUPE-00";
			}
		}
		$mysqli->close();
	} else {$messages[] = "NODB-00"; }
	if ($details_success && $products_success && $practices_success && count($messages) == 0) {
			header("Location: thanks2.php");
	}
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html lang="en" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
		<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

				<title>Internal Error | Buy Fresh Buy Local - Greater Lehigh Valley</title>

				<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

				<link rel="stylesheet" type="text/css" href="/css/styles.css">
		</head>

		<body>
				<div class="site-wrapper">
						<div class="container signup-wrapper">
								<p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
								<h1 class="title">New Partner Application</h1>

								<p style="text-align: center;">There was an internal error during the submission process, please try again in a few minutes. If the problem persist, please contact BuyLocalGLV.</p>
								<?php if (count($messages) > 0): $messages = join(", ", $messages); ?>
								<p class="error-messages"><span class="caption">The following errors were received:</span><br><?php echo $messages; ?></p>
								<?php endif; ?>
								
						</div>
				</div><!-- END: .site-wrapper -->

				<script src="/scripts/vendor/jquery/jquery.min.js"></script>
				<script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
				<script src="/scripts/plugins.min.js"></script>
				<script src="/scripts/scripts.min.js"></script>
		</body>
</html>