<?php
class MapPartner {
	public $id = false;
	public $name = false;
	public $url = false;
	public $lat = false;
	public $lng = false;
	public $city = false;
}
class Hours {
	public $day = false;
	public $startTime = false;
	public $startMeridian = false;
	public $endTime = false;
	public $endMeridian = false;
	public $vendors = false;
	public $season_start_mpart = false;
	public $season_start_month = false;
	public $season_end_mpart = false;
	public $season_end_month = false;
}

add_action("wp_ajax_xhrGetPartners", "xhrGetPartners");
add_action("wp_ajax_nopriv_xhrGetPartners", "xhrGetPartners");
add_action("wp_ajax_xhrAddPartner", "xhrAddPartner");
add_action("wp_ajax_nopriv_xhrAddPartner", "xhrAddPartner");

function geocodeAddress($street = "", $city = "", $state = "", $zip = "") {
    $rVal = false;
    if ($street && (($city && $state) || ($zip))) {
		$address = $street;
		$address .= ($city && $state) ? ", {$city}, {$state}" : "";
		$address .= ($zip) ? " {$zip}" : "";

		$fields = "key=AIzaSyDKE4fWvF7yMWBqptpIbpV6msOiG1H_k-c";
	    $fields .= "&address=" . urlencode($address);

		$ch = curl_init("https://maps.googleapis.com/maps/api/geocode/json?{$fields}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($ch);
		curl_close($ch);

	    $data = json_decode($data);

	    $locationData = (is_object($data) &&
	        property_exists($data, "results") &&
	        is_array($data->results) &&
	        count($data->results) > 0) ?
	            $data->results[0] :
	            false;

	    if ($locationData !== false && is_object($locationData)) {
	    	if (property_exists($locationData, "formatted_address")) {
				$mapAddress = $locationData->formatted_address;
				$mapZoom = 15;
			}
			if (property_exists($locationData, "geometry")) {
				if (is_object($locationData->geometry)
					&& property_exists($locationData->geometry, "location")
					&& is_object($locationData->geometry->location)) {
					$mapLat = $locationData->geometry->location->lat;
					$mapLng = $locationData->geometry->location->lng;

					$rVal = array(
						"address" => $mapAddress,
						"lat" => $mapLat,
						"lng" => $mapLng,
						"zoom" => $mapZoom
					);
				}
			}
	    }
	}
	return $rVal;
}

function splitHours($hours) {
	$hours = explode("\n", $hours);
	$hoursReturn = array();
	if (is_array($hours)) {
		foreach($hours as $hoursString) {
			$dayRegex = "/^(Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday):\s*/i";
			preg_match($dayRegex, $hoursString, $tempMatch);
			if (count($tempMatch) == 2) {
				$tempDay = $tempMatch[1];
				$hoursString = preg_split($dayRegex, $hoursString);
				$hoursString = $hoursString[1];

				if (strlen($hoursString) > 0) {
					$hoursRegex = "/(\d{1,2}:\d{2})(\w{2})-(\d{1,2}:\d{2})(\w{2})\s*/i";
					preg_match_all($hoursRegex, $hoursString, $tempMatch);
					if (count($tempMatch) == 5) {
						$tempStart = $tempMatch[1];
						$tempStartMeridian = $tempMatch[2];
						$tempEnd = $tempMatch[3];
						$tempEndMeridian = $tempMatch[4];
						$hoursString = preg_split($dayRegex, $hoursString);
						$hoursString = $hoursString[1];
					}
					$seasonRegex = "/\(?(Beginning of|Middle of|End of)?\s*\b(\w*)\b to (Beginning of|Middle of|End of)?\s?\b(\w*)\b\)\s*/i";
					preg_match($seasonRegex, $hoursString, $tempMatch);
					if (count($tempMatch) == 5) {
						$tempSeasonStartMpart = $tempMatch[1];
						$tempSeasonStartMonth = $tempMatch[2];
						$tempSeasonEndMpart = $tempMatch[3];
						$tempSeasonEndMonth = $tempMatch[4];
					}
					$vendorsRegex = "/\[(.*?) Vendors\]/i";
					preg_match($vendorsRegex, $input_line, $output_array);
					if (count($tempMatch) == 2) {
						$tempVendors[1];
					}
				}
				$tempObj = new Hours;
				$tempObj->day = $tempDay;
				$tempObj->startTime = $tempStart;
				$tempObj->startTimeMeridian = $tempStartMeridian;
				$tempObj->endTime = $tempEnd;
				$tempObj->endTimeMeridian = $tempEndMeridian;
				$tempObj->season_start_mpart = $tempSeasonStartMpart;
				$tempObj->season_start_month = $tempSeasonStartMonth;
				$tempObj->season_end_mpart = $tempSeasonEndMpart;
				$tempObj->season_end_month = $tempSeasonEndMonth;
				$tempObj->vendors = $tempVendors;
			}
			$hoursReturn[] = $tempObj;
		}
	}
	return $hoursReturn;
}

function breakSeason($season) {
	$season_array = preg_split("/\s+(?=\S*+$)/", $season);
	if (is_array($season_array) && count($season_array) === 2) {
		$season_array = array("mpart" => $season_array[0], "month" => $season_array[1]);
	} else {$season_array = false; }
	return $season_array;
}

function buildProductsQuery($productTypes) {
	$metaQueryArray = false;

	if (is_array($productTypes) && count($productTypes) > 0) {
		$metaQueryArray = array();
		foreach ($productTypes as $productType) {
			$tempProductTypeField = "products_{$productType}";
			$tempProductTypeOtherField = "other_{$tempProductTypeField}";
			$tempMetaQuery = array(
				"relation" => "OR",
				array(
					"key" => $tempProductTypeField,
					"value" => serialize(strval("")),
					"compare" => "NOT LIKE"
				),
				array(
					"key" => $tempProductTypeOtherField,
					"value" => "",
					"compare" => "!="
				)
			);

			$metaQueryArray[] = $tempMetaQuery;
		}
	}

	return $metaQueryArray;
}

function addPartnerData($user_id, $partner) {
	//General Details
	$partner_map_array = geocodeAddress($partner->partner_street_1, $partner->partner_city, $partner->partner_state, $partner->partner_zip);

	$user_id = "user_{$user_id}";
		//Business Details
	update_field("field_56b352249daf2", $partner->partner_name, $user_id);
	update_field("field_566e63d7b39ac", $partner->partner_phone, $user_id);
	if ($partner->partner_website) {
		$partnerURL = $partner->partner_website;
		if (!preg_match("/^https?:\/\//i", $partnerURL)) {
			$partnerURL = "http://{$partnerURL}";
		}
		if (filter_var($partnerURL, FILTER_VALIDATE_URL)) {
			update_field("field_566e6435b39ad", $partnerURL, $user_id);
		}
	}
	update_field("field_566e64a8b39ae", $partner->partner_email, $user_id);

		//Owner Details (Not gathering this data???)
	// update_field("field_566e6376b39ab", $partner->partner_owner_name, $user_id);
	// update_field("field_566ef79524f87", $partner->partner_owner_phone, $user_id);
	// update_field("field_566ef7e824f89", $partner->partner_owner_email, $user_id);

		//Contact Details
	update_field("field_566ef83924f8b", $partner->partner_contact_name, $user_id);
	update_field("field_566e6a150417f", $partner->partner_contact_position, $user_id);
	update_field("field_566ef86424f8c", $partner->partner_contact_phone, $user_id);
	update_field("field_566ef87524f8d", $partner->partner_contact_email, $user_id);

		//Social Media
	if ($partner->partner_facebook) {
		$facebookURL = $partner->partner_facebook;
		preg_match("/^.*?facebook.com\/(.*?)$/", $facebookURL, $facebookArray);
		if (is_array($facebookArray) && count($facebookArray) > 0) {
			$facebookURL = "https://www.facebook.com/{$facebookArray[1]}";
			if (filter_var($facebookURL, FILTER_VALIDATE_URL)) {
				update_field("field_566e64f7b39af", $facebookURL, $user_id);
			}
		}
	}
	if ($partner->twitter) {
		$twitterName = $partner->twitter;
		$twitterName = trim($twitterName);
		$twitterName = trim($twitterName, "@");
		if (preg_match("/^[\w]{1,15}$/", $twitterName)) {
			update_field("field_566e6512b39b0", $twitterName, $user_id);
		}
	}
	if ($partner->instagram) {
		$instagramName = $partner->instagram;
		$instagramName = trim($instagramName);
		$instagramName = trim($instagramName, "@");
		if (preg_match("/^[\w-.]{1,30}$/", $instagramName)) {
			update_field("field_56b218e201749", $instagramName, $user_id);
		}
	}

		//Location Details
	if ($partner->partner_county) {
		update_field("field_56b4057b10d7e", $partner->partner_county, $user_id);
	}
	update_field("field_56b22479b725c", $partner->partner_street_1, $user_id);
	update_field("field_56b224d3b725d", $partner->partner_street_2, $user_id);
	update_field("field_56b225f3b725f", $partner->partner_city, $user_id);
	if ($partner->partner_state) {
		update_field("field_56b22601b7260", $partner->partner_state, $user_id);
	}
	update_field("field_56b22639b7261", $partner->partner_zip, $user_id);
	if (is_array($partner_map_array)) {
		update_field("field_56b34850dbdb6", $partner_map_array, $user_id);
	}

		//Short Description
	update_field("field_56b34d967dae0", $partner->partner_description, $user_id);

		//PHOTOS GO HERE
	if ($partner->owner_photo || $partner->business_photo) {
		update_field("field_56c438ddfe81e", false, $user_id);
		if ($partner->owner_photo) {
			$photoURL = "http://register.buylocalglv.org/{$partner->owner_photo}";
			update_field("field_56c4392cfe820", $photoURL, $user_id);
		}
		if ($partner->business_photo) {
			$photoURL = "http://register.buylocalglv.org/{$partner->business_photo}";
			update_field("field_56c43906fe81f", $photoURL, $user_id);
		}
	}
	//END General Details

	//TODO: Hours of Operation

	//FARM Details
	if ($partner->category === "farm") {

		//Acres
		update_field("field_56b2db3a86583", $partner->acres_owned, $user_id);
		update_field("field_56b2dc1186584", $partner->acres_rented, $user_id);
		update_field("field_56b2dc3286585", $partner->acres_production, $user_id);

		//CSA Details
		if ($partner->is_csa || $partner->is_farm_share) {
			update_field("field_56b2ea7bcf4fb", $partner->is_csa, $user_id);
			update_field("field_56b2ea91cf4fc", $partner->is_farm_share, $user_id);
			//Season
			$csa_details_array = array();
			if ($partner->season_start_combined && $partner->season_end_combined) {
				$seasonStart = breakSeason($partner->season_start_combined);
				$seasonEnd = breakSeason($partner->season_end_combined);
				if (is_array($seasonStart) && is_array($seasonEnd)) {
					$csa_details_array["season_start_mpart"] = $seasonStart["mpart"];
					$csa_details_array["season_start_month"] = $seasonStart["month"];
					$csa_details_array["season_end_mpart"] = $seasonEnd["mpart"];
					$csa_details_array["season_end_month"] = $seasonEnd["month"];
				}
			}
			$csa_details_array["season_weeks"] = $partner->season_weeks;
			//Shares
			$csa_details_array["full_shares"] = $partner->full_shares;
			$csa_details_array["cost_full_shares"] = $partner->cost_full_shares;
			$csa_details_array["size_full_shares"] = $partner->size_full_shares;
			$csa_details_array["size_full_shares_type"] = $partner->size_full_shares_type;
			$csa_details_array["half_shares"] = $partner->half_shares;
			$csa_details_array["cost_half_shares"] = $partner->cost_half_shares;
			$csa_details_array["size_half_shares"] = $partner->size_half_shares;
			$csa_details_array["size_half_shares_type"] = $partner->size_half_shares_type;
			//Addons
			$csa_details_array["possible_addons"] = $partner->possible_addons;

			//TODO:  PICKUP LOCATIONS

			add_row("field_56b2ddf73a3c0", $csa_details_array, $user_id);
		}

		//Products
		$partner->products_greens = explode("|", $partner->products_greens);
		update_field("field_56b2f83125877", $partner->products_greens, $user_id);
		update_field("field_56b2f8ca25878", $partner->other_products_greens, $user_id);
		$partner->products_roots = explode("|", $partner->products_roots);
		update_field("field_56b2f91725879", $partner->products_roots, $user_id);
		update_field("field_56b2f9212587a", $partner->other_products_roots, $user_id);
		$partner->products_seasonal = explode("|", $partner->products_seasonal);
		update_field("field_56b2f98c2587b", $partner->products_seasonal, $user_id);
		update_field("field_56b2f98e2587c", $partner->other_products_seasonal, $user_id);
		$partner->products_melons = explode("|", $partner->products_melons);
		update_field("field_56b2fa2b9dc34", $partner->products_melons, $user_id);
		update_field("field_56b2fa429dc35", $partner->other_products_melons, $user_id);
		$partner->products_herbs = explode("|", $partner->products_herbs);
		update_field("field_56b2fa8832a98", $partner->products_herbs, $user_id);
		update_field("field_56b2fab532a99", $partner->other_products_herbs, $user_id);
		$partner->products_berries = explode("|", $partner->products_berries);
		update_field("field_56b2fae5983e5", $partner->products_berries, $user_id);
		update_field("field_56b2faf2983e6", $partner->other_products_berries, $user_id);
		$partner->products_small_fruits = explode("|", $partner->products_small_fruits);
		update_field("field_56b2fb1c37150", $partner->products_small_fruits, $user_id);
		update_field("field_56b2fb1f37151", $partner->other_products_small_fruits, $user_id);
		$partner->products_grains = explode("|", $partner->products_grains);
		update_field("field_56b2fba45cdb9", $partner->products_grains, $user_id);
		update_field("field_56b2fcfd5cdcb", $partner->other_products_grains, $user_id);
		$partner->products_value_added = explode("|", $partner->products_value_added);
		update_field("field_56b2fbb95cdba", $partner->products_value_added, $user_id);
		update_field("field_56b2fd355cdcc", $partner->other_products_value_added, $user_id);
		$partner->products_flowers = explode("|", $partner->products_flowers);
		update_field("field_56b2fbbf5cdbb", $partner->products_flowers, $user_id);
		update_field("field_56b2fd739f715", $partner->other_products_flowers, $user_id);
		$partner->products_plants = explode("|", $partner->products_plants);
		update_field("field_56b2fbc55cdbc", $partner->products_plants, $user_id);
		update_field("field_56b2fe565cd34", $partner->other_products_plants, $user_id);
		$partner->products_ornamentals = explode("|", $partner->products_ornamentals);
		update_field("field_56b2fbcb5cdbd", $partner->products_ornamentals, $user_id);
		update_field("field_56b2fe6d5cd35", $partner->other_products_ornamentals, $user_id);
		$partner->products_syrups = explode("|", $partner->products_syrups);
		update_field("field_56b2fbd15cdbe", $partner->products_syrups, $user_id);
		update_field("field_56b2fe855cd36", $partner->other_products_syrups, $user_id);
		$partner->products_dairy = explode("|", $partner->products_dairy);
		update_field("field_56b2fbda5cdbf", $partner->products_dairy, $user_id);
		update_field("field_56b2fe9e5cd37", $partner->other_products_dairy, $user_id);
		$partner->products_meat = explode("|", $partner->products_meat);
		update_field("field_56b2fbe35cdc0", $partner->products_meat, $user_id);
		update_field("field_56b2feb15cd38", $partner->other_products_meat, $user_id);
		$partner->products_poultry = explode("|", $partner->products_poultry);
		update_field("field_56b2fbe95cdc1", $partner->products_poultry, $user_id);
		update_field("field_56b2fec25cd39", $partner->other_products_poultry, $user_id);
		$partner->products_agritourism = explode("|", $partner->products_agritourism);
		update_field("field_56b2fbf65cdc2", $partner->products_agritourism, $user_id);
		update_field("field_56b2fee45cd3a", $partner->other_products_agritourism, $user_id);
		$partner->products_fibers = explode("|", $partner->products_fibers);
		update_field("field_56b2fc695cdc3", $partner->products_fibers, $user_id);
		update_field("field_56b2ff0c51a5f", $partner->other_products_fibers, $user_id);
		$partner->products_artisinal = explode("|", $partner->products_artisinal);
		update_field("field_56b2fc765cdc4", $partner->products_artisinal, $user_id);
		update_field("field_56b2ff1151a60", $partner->other_products_artisinal, $user_id);
		$partner->products_liquids = explode("|", $partner->products_liquids);
		update_field("field_56b2fc855cdc5", $partner->products_liquids, $user_id);
		update_field("field_56b2ff1751a61", $partner->other_products_liquids, $user_id);
		$partner->products_educational = explode("|", $partner->products_educational);
		update_field("field_56b2fcab5cdc6", $partner->products_educational, $user_id);
		update_field("field_56b2ffa051a62", $partner->other_products_educational, $user_id);
		$partner->products_baked = explode("|", $partner->products_baked);
		update_field("field_56b2fcbb5cdc7", $partner->products_baked, $user_id);
		update_field("field_56b2ffc051a63", $partner->other_products_baked, $user_id);
		$partner->products_seeds = explode("|", $partner->products_seeds);
		update_field("field_56b2fcd05cdc9", $partner->products_seeds, $user_id);
		update_field("field_56b2ffdd51a64", $partner->other_products_seeds, $user_id);
		$partner->products_misc = explode("|", $partner->products_misc);
		update_field("field_56b2fcdd5cdca", $partner->products_misc, $user_id);
		update_field("field_56b2fff651a65", $partner->other_products_misc, $user_id);

		if ($partner->is_wholesaler) {
			update_field("field_56b301227c125", true, $user_id);
			update_field("field_56b301247c126", $partner->quasi_wholesale, $user_id);
			update_field("field_56b3012a7c127", $partner->small_wholesale, $user_id);
			update_field("field_56b3012f7c129", $partner->large_wholesale, $user_id);

			if ($partner->gap_certified) {
				update_field("field_56b3013a7c12a", "Yes", $user_id);
				update_field("field_56b3013e7c12b", $partner->gap_certified_since, $user_id);
			} elseif ($partner->gap_pending) {
				update_field("field_56b3013a7c12a", "Pending", $user_id);
			} else {
				update_field("field_56b3013a7c12a", "No", $user_id);
			}

			$partner->ws_products_greens = explode("|", $partner->ws_products_greens);
			update_field("field_56c1653b5566e", $partner->ws_products_greens, $user_id);
			update_field("field_56c1653e5566f", $partner->other_ws_products_greens, $user_id);
			$partner->ws_products_roots = explode("|", $partner->ws_products_roots);
			update_field("field_56c17154e540e", $partner->ws_products_roots, $user_id);
			update_field("field_56c17156e540f", $partner->other_ws_products_roots, $user_id);
			$partner->ws_products_seasonal = explode("|", $partner->ws_products_seasonal);
			update_field("field_56c1715ae5410", $partner->ws_products_seasonal, $user_id);
			update_field("field_56c1715ce5411", $partner->other_ws_products_seasonal, $user_id);
			$partner->ws_products_melons = explode("|", $partner->ws_products_melons);
			update_field("field_56c17160e5412", $partner->ws_products_melons, $user_id);
			update_field("field_56c17163e5413", $partner->other_ws_products_melons, $user_id);
			$partner->ws_products_herbs = explode("|", $partner->ws_products_herbs);
			update_field("field_56c17167e5414", $partner->ws_products_herbs, $user_id);
			update_field("field_56c1716de5415", $partner->other_ws_products_herbs, $user_id);
			$partner->ws_products_berries = explode("|", $partner->ws_products_berries);
			update_field("field_56c17173e5416", $partner->ws_products_berries, $user_id);
			update_field("field_56c17177e5417", $partner->other_ws_products_berries, $user_id);
			$partner->ws_products_small_fruits = explode("|", $partner->ws_products_small_fruits);
			update_field("field_56c17248e5418", $partner->ws_products_small_fruits, $user_id);
			update_field("field_56c1724ce5419", $partner->other_ws_products_small_fruits, $user_id);
			$partner->ws_products_grains = explode("|", $partner->ws_products_grains);
			update_field("field_56c1724fe541b", $partner->ws_products_grains, $user_id);
			update_field("field_56c1725be541c", $partner->other_ws_products_grains, $user_id);
			$partner->ws_products_value_added = explode("|", $partner->ws_products_value_added);
			update_field("field_56c1725ee541d", $partner->ws_products_value_added, $user_id);
			update_field("field_56c17261e541e", $partner->other_ws_products_value_added, $user_id);
			$partner->ws_products_flowers = explode("|", $partner->ws_products_flowers);
			update_field("field_56c17265e541f", $partner->ws_products_flowers, $user_id);
			update_field("field_56c17268e5420", $partner->other_ws_products_flowers, $user_id);
			$partner->ws_products_plants = explode("|", $partner->ws_products_plants);
			update_field("field_56c172dbe5426", $partner->ws_products_plants, $user_id);
			update_field("field_56c172d9e5425", $partner->other_ws_products_plants, $user_id);
			$partner->ws_products_ornamentals = explode("|", $partner->ws_products_ornamentals);
			update_field("field_56c172d6e5424", $partner->ws_products_ornamentals, $user_id);
			update_field("field_56c172d5e5423", $partner->other_ws_products_ornamentals, $user_id);
			$partner->ws_products_syrups = explode("|", $partner->ws_products_syrups);
			update_field("field_56c172d3e5422", $partner->ws_products_syrups, $user_id);
			update_field("field_56c172d1e5421", $partner->other_ws_products_syrups, $user_id);
			$partner->ws_products_dairy = explode("|", $partner->ws_products_dairy);
			update_field("field_56c17387e542c", $partner->ws_products_dairy, $user_id);
			update_field("field_56c17385e542b", $partner->other_ws_products_dairy, $user_id);
			$partner->ws_products_meat = explode("|", $partner->ws_products_meat);
			update_field("field_56c17384e542a", $partner->ws_products_meat, $user_id);
			update_field("field_56c17383e5429", $partner->other_ws_products_meat, $user_id);
			$partner->ws_products_poultry = explode("|", $partner->ws_products_poultry);
			update_field("field_56c17381e5428", $partner->ws_products_poultry, $user_id);
			update_field("field_56c1737fe5427", $partner->other_ws_products_poultry, $user_id);
			$partner->ws_products_agritourism = explode("|", $partner->ws_products_agritourism);
			update_field("field_56c173dce5432", $partner->ws_products_agritourism, $user_id);
			update_field("field_56c173dae5431", $partner->other_ws_products_agritourism, $user_id);
			$partner->ws_products_fibers = explode("|", $partner->ws_products_fibers);
			update_field("field_56c173d8e5430", $partner->ws_products_fibers, $user_id);
			update_field("field_56c173d7e542f", $partner->other_ws_products_fibers, $user_id);
			$partner->ws_products_artisinal = explode("|", $partner->ws_products_artisinal);
			update_field("field_56c18eefea474", $partner->ws_products_artisinal, $user_id);
			update_field("field_56c18ef3ea475", $partner->other_ws_products_artisinal, $user_id);
			$partner->ws_products_liquids = explode("|", $partner->ws_products_liquids);
			update_field("field_56c18efaea477", $partner->ws_products_liquids, $user_id);
			update_field("field_56c18ef8ea476", $partner->other_ws_products_liquids, $user_id);
			$partner->ws_products_educational = explode("|", $partner->ws_products_educational);
			update_field("field_56c18f00ea479", $partner->ws_products_educational, $user_id);
			update_field("field_56c18effea478", $partner->other_ws_products_educational, $user_id);
			$partner->ws_products_baked = explode("|", $partner->ws_products_baked);
			update_field("field_56c18fda92dc8", $partner->ws_products_baked, $user_id);
			update_field("field_56c18fd792dc7", $partner->other_ws_products_baked, $user_id);
			$partner->ws_products_seeds = explode("|", $partner->ws_products_seeds);
			update_field("field_56c18fd692dc6", $partner->ws_products_seeds, $user_id);
			update_field("field_56c18fd592dc5", $partner->other_ws_products_seeds, $user_id);
			$partner->ws_products_misc = explode("|", $partner->ws_products_misc);
			update_field("field_56c18fd392dc4", $partner->ws_products_misc, $user_id);
			update_field("field_56c18fd292dc3", $partner->other_ws_products_misc, $user_id);
			if ($partner->textWsProducts) {
				update_field("field_56b2ef08c7596", $partner->textWsProducts, $user_id);
			}
		}
		//END Products

		//Farming Practices
		if ($partner->certified_organic) {
			update_field("field_56b304c580e32", true, $user_id);
			update_field("field_56b304d580e33", $partner->certified_organic_since, $user_id);
			update_field("field_56b304f080e34", $partner->certified_organic_by, $user_id);
		}
		if ($partner->certified_naturally_grown) {
			update_field("field_56b3052e80e36", true, $user_id);
			update_field("field_56b3054780e37", $partner->certified_naturally_grown_since, $user_id);
		}
		if ($partner->certified_biodynamic) {
			update_field("field_56b305bd80e3b", true, $user_id);
			update_field("field_56b3057b80e39", $partner->certified_biodynamic_since, $user_id);
			update_field("field_56b3057d80e3a", $partner->certified_biodynamic_by, $user_id);
		}
		update_field("field_56b30645c9a0c", (bool)$partner->only_organic, $user_id);
		update_field("field_56b30664c9a0d", (bool)$partner->intergrated_pest_management, $user_id);
		update_field("field_56b30672c9a0e", (bool)$partner->non_gmo, $user_id);
		update_field("field_56b30683c9a0f", (bool)$partner->antibiotic_harmone_free, $user_id);
		update_field("field_56b306b7c9a10", (bool)$partner->pastured, $user_id);
		update_field("field_56b306cbc9a11", (bool)$partner->grass_fed, $user_id);
		update_field("field_56b306d9c9a12", (bool)$partner->extended_growing_season, $user_id);
		if ($partner->other_practices) {
			update_field("field_56b306e1c9a13", true, $user_id);
			update_field("field_56b306f2c9a14", $partner->other_practices, $user_id);
		}
		update_field("field_56b3073a9241a", (bool)$partner->accept_snap, $user_id);
		update_field("field_56b3075f9241b", (bool)$partner->accept_fmnp, $user_id);

		//Product Availability
		update_field("field_56c456f460041", (bool)$partner->appointments, $user_id);
		update_field("field_56b2c7a3c3a50", $partner->products_available_at_other, $user_id);
		if ($partner->farm_type === "Farm Market") {
			update_field("field_56b2c8a3b38cd", "Farm Market");
			update_field("field_56b2c7a3cc6e1", $partner->products_available_from_other, $user_id);
		} else { update_field("field_56b2c8a3b38cd", "Farm Stand"); }
	}

	if ($partner->category === "specialty") {
		update_field("field_56b2c52e3db8a", $partner->source_from_other, $user_id);
		update_field("field_56b2c62183261", $partner->products_available_at_other, $user_id);
	}

	if ($partner->category === "retail" || $partner->category === "distributor") {
		update_field("field_56b2c4dec3e76", $partner->source_from_other, $user_id);
	}

	if ($partner->category === "distillery" || $partner->category === "vineyard") {
		update_field("field_56b2c0b155003", $partner->products_available_at_other, $user_id);
		update_field("field_56b2c28de1a81", $partner->products_available_from_other, $user_id);
	}

	if ($partner->category === "institution" || $partner->category === "restaurant") {
		update_field("field_56b2d80b12906", $partner->source_from_other, $user_id);
		update_field("field_56b2d8ffd4302", $partner->local_stock_freq, $user_id);
		update_field("field_56b2d9ddd4304", $partner->local_stock_freq, $user_id);
	}

	if ($partner->category === "farmers-market") {
		update_field("field_56b2cb6239d12", $partner->number_of_vendors, $user_id);
		update_field("field_56b2cc4c00cb7", $partner->vendor_list_other, $user_id);
		update_field("field_56b2ccb800cb9", $partner->market_manager, $user_id);
		update_field("field_56b2ccda00cba", $partner->market_manager_email, $user_id);
		update_field("field_56b2ccf100cbb", $partner->market_manager_phone, $user_id);
		update_field("field_56c2bbece7441", $partner->market_ebt, $user_id);
		update_field("field_56c2bc73e7442", (bool)$partner->market_double_snap, $user_id);
		update_field("field_56c2bcade7443", (bool)$partner->market_fmnp, $user_id);
	}
	if ($partner->textProducts) {
		update_field("field_56b2ed22c758e", $partner->textProducts, $user_id);
	}

	//Hours
	if ($partner->hours) {
		$partnerHours = splitHours($partner->hours);
		$fieldKey = ($partner->category === "farmers-market") ? "field_56b2d6a20cc4e" : "field_56b2cddb6bd77";

		if (is_array($partnerHours)) {
			foreach($partnerHours as $partnerHoursObj) {
				$row_array = array();
				if ($partnerHoursObj->day) $row_array["day"] = $partnerHoursObj->day;
				if ($partnerHoursObj->startTime && $partnerHoursObj->startMeridian) $row_array["open_time"] = "{$partnerHoursObj->startTime} {$partnerHoursObj->startMeridian}";
				if ($partnerHoursObj->endTime && $partnerHoursObj->endMeridian) $row_array["close_time"] = "{$partnerHoursObj->endTime} {$partnerHoursObj->endMeridian}";
				if ($partnerHoursObj->season_start_mpart) {
					$row_array["season_start_mpart"] = $partnerHoursObj->season_start_mpart;
					$row_array["is_seasonal"] = true;
				}
				if ($partnerHoursObj->season_start_month) {
					$row_array["season_start_month"] = $partnerHoursObj->season_start_month;
				}
				if ($partnerHoursObj->season_end_mpart) {
					$row_array["season_end_mpart"] = $partnerHoursObj->season_end_mpart;
				}
				if ($partnerHoursObj->season_end_month) {
					$row_array["season_end_month"] = $partnerHoursObj->season_end_month;
				}
				if ($partner->category === "farmers-market") {
					if ($vendors) {
						$row_array["vendors"] = $partnerHoursObj->season_end_month;
					}
				}
				if (count($row_array) > 0) {
					add_row($fieldKey, $row_array, $user_id);
				}
			}
		}

	}


}

function xhrGetPartners() {
    $pseudoFarmSearch = false;
	$allLocationTypes = array(
		"farm", "farmers-market",
		"restaurant", "vineyard",
		"distillery", "institution",
		"distributor", "specialty",
		"retail"
	);

	$allProductTypes = array(
		"greens", "roots", "seasonal",
		"melons", "herbs", "berries",
		"small_fruits", "grains", "value_added",
		"flowers", "plants", "ornamentals",
		"syrups", "dairy", "meat",
		"poultry", "agritourism", "fibers",
		"artisinal", "liquids", "educational",
		"baked", "seeds", "misc"
	);

	$locationTypes = (isset($_REQUEST["location_type"])
		&& is_array($_REQUEST["location_type"])
		&& count($_REQUEST["location_type"] > 0)) ?
			$_REQUEST["location_type"] :
			false;

	$productTypes = (isset($_REQUEST["product_type"])
		&& is_array($_REQUEST["product_type"])
		&& count($_REQUEST["product_type"] > 0)) ?
			$_REQUEST["product_type"] :
			false;

	$wholesale = (isset($_REQUEST["wholesale"]) && ($_REQUEST["wholesale"] == "true" || $_REQUEST["wholesale"] == "1")) ? true : false;

   	$tempPartners = array();
   	$returnPartners = array();

   	if ($locationTypes === false) {
   		$locationTypes = ($productTypes || $pseudoFarmSearch) ? array("farm") : $allLocationTypes;
   	} else {
        //Clear $productTypes if not a farm search
   		$productTypes = (in_array("farm", $locationTypes)) ? $productTypes : false;
   	}

	foreach ($locationTypes as $locationType) {
		if (in_array($locationType, array("farm-share", "csa"))) {
            $locationTypePartners = null;
            $pseudoLocationType = ($locationType === "farm-share") ? "is_farm_share" : "is_csa";
            $locationTypeQueryArgs = array(
                "role" => "farm",
                "meta_query" => array(
                    "relation" => "AND",
                    array(
                        "key" => $pseudoLocationType,
                        "value" => 1,
                        "compare" => "="
                    )
                )
            );
            $productsQuery = buildProductsQuery($productTypes);
            if ($productsQuery) {
                $locationTypeQueryArgs["meta_query"][] = $productsQuery;
            }
        } else {
            $locationTypePartners = null;
            $locationTypeQueryArgs = array(
                "role" => $locationType
            );
            if ($locationType === "farm") {
                $productsQuery = buildProductsQuery($productTypes);

                if ($productsQuery) {
                    $locationTypeQueryArgs["meta_query"] = array($productsQuery);
                }
            }

        }
        if ($wholesale) {
        	$locationTypeQueryArgs["meta_query"][] = array(
        		"key" => "is_wholesaler",
        		"value" => 1,
        		"compare" => "="
        	);
        }
		$locationTypePartners = get_users($locationTypeQueryArgs);

		if (is_array($locationTypePartners) && count($locationTypePartners) > 0) {
			$tempPartners = array_merge($locationTypePartners, $tempPartners);
		}
	}

	foreach ($tempPartners as $partnerKey=>$partner) {
		$tempObj = new MapPartner;
		$tempObj->id = $partner->ID;
		$tempName = get_field("partner_name", "user_{$partner->ID}");
		$tempCity = get_field("partner_city", "user_{$partner->ID}");
		$tempObj->name = strlen($tempName) > 0 ? $tempName : $partner->display_name;
		$tempMap = get_field("partner_map", "user_{$partner->ID}");
		if (!empty($tempMap)) {
			$tempObj->lat = $tempMap["lat"];
			$tempObj->lng = $tempMap["lng"];
		}
		$tempObj->url = get_author_posts_url($partner->ID);
		$tempObj->city = $tempCity;
		$returnPartners[] = $tempObj;
		$tempObj = null;
		$tempName = null;
		$tempCity = null;
		$tempMap = null;
	}

	$returnPartners = array_unique($returnPartners, SORT_REGULAR);

	usort($returnPartners, function($a, $b) {
	    return $a->name - $b->name;
	});

	$result = json_encode($returnPartners);

// 	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// 		header('Content-Type: application/json');
//    	echo $result;
//   } else {
//      header("Location: ".$_SERVER["HTTP_REFERER"]);
//   }

	header('Content-Type: application/json');
	echo $result;

   	die();
}

function xhrAddPartner() {
	$data = file_get_contents("php://input"); //read the HTTP body.
	$partner = json_decode($data);

	$category = $partner->category;

	//Member Since
	$member_since = strtotime($partner->member_since);
	if ($member_since) {
		$member_since = date("Y-m-d H:i:s", $member_since);
	} else {
		$member_since = date("Y-m-d H:i:s");
	}

	//Get Emails
	$partner_email = is_string($partner->partner_email) ? $partner->partner_email : false;
	$contact_email = is_string($partner->contact_email) ? $partner->contact_email : false;
	$new_user_email = ($contact_email) ? $contact_email : $partner_email;

	//Prep Username
	$username = $partner->requested_username;
	if (username_exists($username)) {
		$username_sfx = 1;
		while (username_exists("{$username}_{$username_sfx}")) { $username_sfx++; }
		$username = "{$username}_{$username_sfx}";
	}

	//Prep Slug
	$slug = sanitize_title($partner->partner_name);
	if (get_user_by("slug", $slug)) {
		$slug_sfx = 2;
		while (get_user_by("slug", "{$slug}-{$slug_sfx}")) { $slug_sfx++; }
		$slug = "{$slug}-{$slug_sfx}";
	}

	//USER Last Name
	$user_last_name = "[" . niceCategoryName($category) . "]";

	//Insert User
	$new_user_pass = wp_generate_password(12, true);
	$new_user_args = array(
		"role" => $category,
		"user_login" => $username,
		"user_pass" => $new_user_pass,
		"first_name" => $partner->partner_name,
		"last_name" => $user_last_name,
		"user_nicename" => $slug,
		"display_name" => $partner->partner_name,
		/*"user_email" => $new_user_email*/
		"user_email" => "sean.metzgar+{$slug}@gmail.com",
		"user_registered" => $member_since
	);
	//$user_id = wp_insert_user($new_user_args);
	//wp_new_user_notification($user_id, null, "both");

	print_r($partner);

	// $response = array();
	// if (is_int($user_id) && $user_id > 0) {
	// 	addPartnerData($user_id, $partner);
	// 	$response["status"] = "success";
	// } else { $response["status"] = "fail"; }
	// $response = json_encode($response);

	// header('Content-Type: application/json');
	// echo $response;

   	die();
}