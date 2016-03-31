<?php
class MapPartner {
	public $id = false;
	public $name = false;
	public $url = false;
	public $lat = false;
	public $lng = false;
	public $city = false;
	public $inbounds = false;
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

class DownloadPartner {
	public $name = false;

	/** Business Details **/
	public $partner_phone = "";
	public $partner_website = "";
	public $partner_email = "";

	/** Owner Details **/
	public $owner_name = "";
	public $owner_phone = "";
	public $owner_email = "";

	/** Contact Details **/
	public $contact_name = "";
	public $contact_job = "";
	public $contact_phone = "";
	public $contact_email = "";

	/** Social Media **/
	public $facebook_page = "";
	public $instagram_username = "";
	public $twitter_username = "";

	/** Location **/
	public $county = "";
	public $location_address = "";

	/** Hours **/
	public $hours = "";

	/** Availability & Sourcing **/
	public $products_available_from = "";
	public $products_available_from_other = "";
	public $products_available_at = "";
	public $products_available_at_other = "";
	public $source_from = "";
	public $source_from_other = "";
	public $local_stock = "";
	public $appointments = false;

	/** Products **/
	public $products_greens = "";
	public $products_greens_other = "";
	public $products_roots = "";
	public $products_roots_other = "";
	public $products_seasonal = "";
	public $products_seasonal_other = "";
	public $products_melons = "";
	public $products_melons_other = "";
	public $products_herbs = "";
	public $products_herbs_other = "";
	public $products_berries = "";
	public $products_berries_other = "";
	public $products_small_fruits = "";
	public $products_small_fruits_other = "";
	public $products_grains = "";
	public $products_grains_other = "";
	public $products_value_added = "";
	public $products_value_added_other = "";
	public $products_flowers = "";
	public $products_flowers_other = "";
	public $products_plants = "";
	public $products_plants_other = "";
	public $products_ornamentals = "";
	public $products_ornamentals_other = "";
	public $products_syrups = "";
	public $products_syrups_other = "";
	public $products_dairy = "";
	public $products_dairy_other = "";
	public $products_meat = "";
	public $products_meat_other = "";
	public $products_poultry = "";
	public $products_poultry_other = "";
	public $products_agritourism = "";
	public $products_agritourism_other = "";
	public $products_fibers = "";
	public $products_fibers_other = "";
	public $products_artisinal = "";
	public $products_artisinal_other = "";
	public $products_liquids = "";
	public $products_liquids_other = "";
	public $products_educational = "";
	public $products_educational_other = "";
	public $products_baked = "";
	public $products_baked_other = "";
	public $products_seeds = "";
	public $products_seeds_other = "";
	public $products_misc = "";
	public $products_misc_other = "";
	/** Wholesale **/
	public $is_wholesaler = false;
	public $quasi_wholesale = false;
	public $small_wholesale = false;
	public $large_wholesale = false;
	public $gap_certification = false;
	public $gap_certified_since = "";
		/** Wholesale Products **/
		public $ws_products_greens = "";
		public $ws_products_greens_other = "";
		public $ws_products_roots = "";
		public $ws_products_roots_other = "";
		public $ws_products_seasonal = "";
		public $ws_products_seasonal_other = "";
		public $ws_products_melons = "";
		public $ws_products_melons_other = "";
		public $ws_products_herbs = "";
		public $ws_products_herbs_other = "";
		public $ws_products_berries = "";
		public $ws_products_berries_other = "";
		public $ws_products_small_fruits = "";
		public $ws_products_small_fruits_other = "";
		public $ws_products_grains = "";
		public $ws_products_grains_other = "";
		public $ws_products_value_added = "";
		public $ws_products_value_added_other = "";
		public $ws_products_flowers = "";
		public $ws_products_flowers_other = "";
		public $ws_products_plants = "";
		public $ws_products_plants_other = "";
		public $ws_products_ornamentals = "";
		public $ws_products_ornamentals_other = "";
		public $ws_products_syrups = "";
		public $ws_products_syrups_other = "";
		public $ws_products_dairy = "";
		public $ws_products_dairy_other = "";
		public $ws_products_meat = "";
		public $ws_products_meat_other = "";
		public $ws_products_poultry = "";
		public $ws_products_poultry_other = "";
		public $ws_products_agritourism = "";
		public $ws_products_agritourism_other = "";
		public $ws_products_fibers = "";
		public $ws_products_fibers_other = "";
		public $ws_products_artisinal = "";
		public $ws_products_artisinal_other = "";
		public $ws_products_liquids = "";
		public $ws_products_liquids_other = "";
		public $ws_products_educational = "";
		public $ws_products_educational_other = "";
		public $ws_products_baked = "";
		public $ws_products_baked_other = "";
		public $ws_products_seeds = "";
		public $ws_products_seeds_other = "";
		public $ws_products_misc = "";
		public $ws_products_misc_other = "";

	/** Farm Practices **/
	public $certified_organic = false;
	public $certified_organic_since = "";
	public $certified_organic_by = "";

	public $certified_naturally_grown = false;
	public $certified_naturally_grown_since = "";

	public $certified_biodynamic = false;
	public $certified_biodynamic_since = "";
	public $certified_biodynamic_by = "";

	public $only_organic = false;
	public $integrated_pest_management = false;
	public $non_gmo = false;
	public $antibiotic_harmone_free = false;
	public $pastured = false;
	public $grass_fed = false;
	public $extended_growing_season = false;
	public $other_practices = "";

	/** Acres **/
	public $acres_owned = "";
	public $acres_rented = "";
	public $acres_production = "";

	/** CSA / Farm Share **/
	public $is_farm_share = false;
	public $is_csa = false;
		/** Season **/
		public $season_weeks = "";
		public $season = "";

		/** Full Shares **/
		public $full_shares = "";
		public $cost_full_shares = "";
		public $size_full_shares = "";

		/** Half Shares **/
		public $half_shares = "";
		public $cost_half_shares = "";
		public $size_half_shares = "";

		/** Addons **/
		public $possible_addons = "";

		/** Pickup & Deliver **/
		public $farm_pickup = false;
		public $farm_pickup_hours = "";
		public $other_pickup = false;
		public $other_pickup_details = "";
		public $home_delivery = false;
		public $home_delivery_details = "";
}

add_action("wp_ajax_xhrGetPartners", "xhrGetPartners");
add_action("wp_ajax_nopriv_xhrGetPartners", "xhrGetPartners");
add_action("wp_ajax_xhrAddPartner", "xhrAddPartner");
add_action("wp_ajax_nopriv_xhrAddPartner", "xhrAddPartner");
add_action("wp_ajax_xhrGetPartnersDownload", "xhrGetPartnersDownload");

function xlsBreaks($string) {
	$rVal = preg_replace('#<br\s*/?>#i', PHP_EOL, $string);
	return $rVal;
}

function downloadParseProducts($products) {
	if (is_array($products) && count($products) > 0) {
		$products = implode(", ", $products);
	} else { $products = ""; }
	return $products;
}

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

function getZipBounds($zip, $radius = 5) {
    $rVal = false;
    $radius = is_int($radius && $radius > 0) ? $radius : 5;
    if ($zip && is_int($radius) && $radius > 0) {
		$fields = "zip=" . urlencode($zip);
		$fields .= "&radius=" . urlencode($radius);
		$url = "http://api.wearekudu.com/geolocate/?{$fields}";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($ch);
		curl_close($ch);

	    $data = json_decode($data);

	    $boundsData = (is_object($data) &&
	        property_exists($data, "data") &&
	        is_object($data->data)) ?
	            $data->data : false;

	    if ($boundsData !== false && is_object($boundsData)) {
	    	$rVal = $boundsData;
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
						$tempStart = $tempMatch[1][0];
						$tempStartMeridian = $tempMatch[2][0];
						$tempEnd = $tempMatch[3][0];
						$tempEndMeridian = $tempMatch[4][0];
						$hoursString = preg_split($dayRegex, $hoursString);
						$hoursString = $hoursString[1];
					}
					$seasonRegex = "/\(?(Beginning of|Middle of|End of)?\s*\b(\w*)\b to (Beginning of|Middle of|End of)?\s?\b(\w*)\b\)\s*/i";
					preg_match($seasonRegex, $hoursString, $tempMatch);
					if (count($tempMatch) == 5) {
						$tempSeasonStartMpart = $tempMatch[1][0];
						$tempSeasonStartMonth = $tempMatch[2][0];
						$tempSeasonEndMpart = $tempMatch[3][0];
						$tempSeasonEndMonth = $tempMatch[4][0];
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
				$tempObj->startMeridian = $tempStartMeridian;
				$tempObj->endTime = $tempEnd;
				$tempObj->endMeridian = $tempEndMeridian;
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

function buildProductsQuery($productTypes, $wholesale = false) {
	$metaQueryArray = false;
	$wholesale = (is_bool($wholesale)) ? $wholesale : false;

	if (is_array($productTypes) && count($productTypes) > 0) {
		$metaQueryArray = array("relation" => "OR");
		foreach ($productTypes as $productType) {
			$tempProductTypeField = "products_{$productType}";
			$tempProductTypeField = ($wholesale) ? "ws_$tempProductTypeField" : $tempProductTypeField;
			$tempProductTypeOtherField = "other_{$tempProductTypeField}";
			$tempMetaQuery = array(
				"relation" => "OR",
				array(
					"relation" => "AND",
					array(
						"key" => $tempProductTypeField,
						"value" => "",
						"compare" => "!="
					),
					array(
						"key" => $tempProductTypeField,
						"value" => serialize(strval("")),
						"compare" => "NOT LIKE"
					)
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
		update_field("field_56b30664c9a0d", (bool)$partner->integrated_pest_management, $user_id);
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
		update_field("field_56b2d9ddd4304", $partner->local_stock_qty, $user_id);
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
	if ($partner->hours_combined) {
		$partnerHours = splitHours($partner->hours_combined);
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
	$zip = (isset($_REQUEST["zip"])) ? "".$_REQUEST["zip"] : false;
	$zip = ($zip && strlen($zip) >= 5) ? substr($zip, 0, 5) : false;
	$hasZipBounds = false;
	if ($zip) {
		$zipBounds = getZipBounds($zip);
		$hasZipBounds = (is_object($zipBounds)) ? true : false;
	}

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
            $productsQuery = buildProductsQuery($productTypes, $wholesale);
            if ($productsQuery) {
                $locationTypeQueryArgs["meta_query"][] = $productsQuery;
            }
        } else {
            $locationTypePartners = null;
            $locationTypeQueryArgs = array(
                "role" => $locationType
            );
            if ($locationType === "farm") {
                $productsQuery = buildProductsQuery($productTypes, $wholesale);

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

		if ($hasZipBounds && !empty($tempMap)) {
			if ($tempMap["lat"] < $zipBounds->maxLat && $tempMap["lat"] > $zipBounds->minLat &&
				$tempMap["lng"] < $zipBounds->maxLng && $tempMap["lng"] > $zipBounds->minLng) {
				$tempObj->inbounds = true;
				$returnPartners[] = $tempObj;
			}
		} else {
			$returnPartners[] = $tempObj;
		}
		$tempObj = null;
		$tempName = null;
		$tempCity = null;
		$tempMap = null;
	}

	$returnPartners = array_unique($returnPartners, SORT_REGULAR);

	usort($returnPartners, function($a, $b) {
	    return strnatcmp($a->name, $b->name);
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
		"user_email" => $new_user_email,
		// "user_email" => "sean.metzgar+{$slug}@gmail.com",
		"user_registered" => $member_since
	);
	$user_id = wp_insert_user($new_user_args);
	//wp_new_user_notification($user_id, null, "both");

	$response = array();
	if (is_int($user_id) && $user_id > 0) {
		addPartnerData($user_id, $partner);
		$response["status"] = "success";
	} else { $response["status"] = "fail"; }
	$response = json_encode($response);

	header('Content-Type: application/json');
	echo $response;

   	die();
}

function xhrGetPartnersDownload() {
	$locationTypes = array(
		"farm", "farmers-market",
		"restaurant", "vineyard",
		"distillery", "institution",
		"distributor", "specialty",
		"retail"
	);
	$allPartners = array();
	$partnersArray = array();


	foreach ($locationTypes as $locationType) {
		$locationTypePartners = null;
        $locationTypeQueryArgs = array(
            "role" => $locationType
        );
        $locationTypePartners = get_users($locationTypeQueryArgs);
        if (is_array($locationTypePartners) && count($locationTypePartners) > 0) {
			$allPartners = array_merge($locationTypePartners, $allPartners);
		}
	}

	foreach ($allPartners as $partner) {
		$tempObject = new DownloadPartner;
		$partner_id = $partner->ID;
		$acfID = "user_{$partner_id}";

		/** Business Name **/
		$tempObject->name = get_field("partner_name", $acfID);

		/** Business Details **/
		$tempObject->partner_phone = get_field("partner_phone", $acfID);
		$tempObject->partner_website = get_field("partner_website", $acfID);
		$tempObject->partner_email = get_field("partner_email", $acfID);

		/** Owner Details **/
		$tempObject->owner_name = get_field("partner_owner_name", $acfID);
		$tempObject->owner_phone = get_field("partner_owner_phone", $acfID);
		$tempObject->owner_email = get_field("partner_owner_email", $acfID);

		/** Contact Details **/
		$tempObject->contact_name = get_field("partner_contact_name", $acfID);
		$tempObject->contact_job = get_field("partner_contact_position", $acfID);
		$tempObject->contact_phone = get_field("partner_contact_phone", $acfID);
		$tempObject->contact_email = get_field("partner_contact_email", $acfID);

		/** Social Media **/
		$tempObject->facebook_page = get_field("partner_facebook", $acfID);
		$tempObject->instagram_username = get_field("partner_instagram", $acfID);
		$tempObject->twitter_username = get_field("partner_twitter", $acfID);

		/** Location **/
		$tempObject->county = get_field("partner_county", $acfID);
			//Get Address Parts
			$partner_street_1 = get_field("partner_street_1", $acfID);
			$partner_street_1 = strlen($partner_street_1) > 0 ? $partner_street_1 : false;
			$partner_street_2 = get_field("partner_street_2", $acfID);
			$partner_street_2 = strlen($partner_street_2) > 0 ? $partner_street_2 : false;
			$partner_city = get_field("partner_city", $acfID);
			$partner_city = strlen($partner_city) > 0 ? $partner_city : false;
			$partner_state = get_field("partner_state", $acfID);
			$partner_state = strlen($partner_state) > 0 ? $partner_state : false;
			$partner_zip = get_field("partner_zip", $acfID);
			$partner_zip = strlen($partner_zip) > 0 ? $partner_zip : false;
			//Sanitize Address
			$partner_address = "";
			$partner_address .= $partner_street_1 ? "$partner_street_1".PHP_EOL : "";
			$partner_address .= $partner_street_2 ? "$partner_street_2".PHP_EOL : "";
			$partner_address .= $partner_city ? "$partner_city" : "";
			$partner_address .= ($partner_city && $partner_state) ? ", $partner_state" : "";
			$partner_address .= (!$partner_city && $partner_state) ? "$partner_state" : "";
			$partner_address .= ($partner_zip && ($partner_city || $partner_state)) ? " $partner_zip" : "";
			$partner_address .= ($partner_zip && !$partner_city && !$partner_state) ? $partner_zip : "";
		$tempObject->location_address = (strlen($partner_address) > 0) ? $partner_address : "";

		/** Hours **/
		$partner_hours = array();
		if (have_rows("hours", $acfID)) {
			while (have_rows("hours", $acfID)) {
				the_row();
				$tempDay = get_sub_field("day");
				$tempOpenTime = get_sub_field("open_time");
				$tempCloseTime = get_sub_field("close_time");
				$tempShortDescription = get_sub_field("short_description");
				$tempIsSeasonal = get_sub_field("is_seasonal");
				if ($tempIsSeasonal) {
					$tempSeasonStartMonthPart = get_sub_field("season_start_mpart");
					$tempSeasonStartMonth = get_sub_field("season_start_month");
					$tempSeasonEndMonthPart = get_sub_field("season_end_mpart");
					$tempSeasonEndMonth = get_sub_field("season_end_month");
				}
				$tempVendors = get_sub_field("vendors");
				$tempVendors = (is_string($tempVendors) && strlen($tempVendors) > 0) ? $tempVendors : false;

				$tempHours = "$tempDay: $tempOpenTime - $tempCloseTime";
				$tempHours .= ($tempShortDescription) ? PHP_EOL."$tempShortDescription" : "";
				$tempHours .= ($tempIsSeasonal) ? PHP_EOL."($tempSeasonStartMonthPart $tempSeasonStartMonth - $tempSeasonEndMonthPart $tempSeasonEndMonth)" : "";
				$tempHours .= ($tempVendors) ? PHP_EOL."[$tempVendors Vendors]" : "";
				$partner_hours[] = $tempHours;
			}
		}
		$tempObject->hours = (count($partner_hours) > 0) ? implode(PHP_EOL.PHP_EOL, $partner_hours) : "";

		/** Availability & Sourcing **/
		$products_available_from = "";
		$products_available_from_array = array();
		if (is_array($products_available_from) && count($products_available_from) > 0) {
			foreach ($products_available_from as $vendor) {
				$vendor_id = "user_{$vendor['ID']}";
				$products_available_from_array[] = get_field("partner_name", $vendor_id);
			}
			$products_available_from = implode(PHP_EOL, $products_available_from_array);
		}
		$tempObject->products_available_from = $products_available_from;
		$tempObject->products_available_from_other = get_field("products_available_from_other", $acfID);

		$products_available_at = "";
		if (is_array($products_available_at) && count($products_available_at) > 0) {
			foreach ($products_available_at as $vendor) {
				$vendor_id = "user_{$vendor['ID']}";
				$products_available_at_array[] = get_field("partner_name", $vendor_id);
			}
			$products_available_at = implode(PHP_EOL, $products_available_at_array);
		}
		$tempObject->products_available_at = $products_available_at;
		$tempObject->products_available_at_other = get_field("products_available_at_other", $acfID);

		$source_from = "";
		if (is_array($source_from) && count($source_from) > 0) {
			foreach ($source_from as $vendor) {
				$vendor_id = "user_{$vendor['ID']}";
				$source_from_array[] = get_field("partner_name", $vendor_id);
			}
			$source_from = implode(PHP_EOL, $source_from_array);
		}
		$tempObject->source_from = $source_from;
		$tempObject->source_from_other = get_field("source_from_other", $acfID);

		$local_stock_freq = get_field("local_stock_freq", $acfID);
		$local_stock_qty = get_field("local_stock_qty", $acfID);
		if ($local_stock_freq && $local_stock_qty) {
			$local_stock = "We {$local_stock_freq} have {$local_stock_qty} locally grown ingredients in our menu items.";
		} else { $local_stock = ""; }
		$tempObject->local_stock = $local_stock;

		$appointments = get_field("appointments", $acfID);
		$tempObject->appointments = is_bool($appointments) ? $appointments : false;

		/** Products **/
		$products_greens = get_field("products_greens", $acfID);
		$tempObject->products_greens = downloadParseProducts($products_greens);
		$tempObject->products_greens_other = get_field("other_products_greens");
		$products_roots = get_field("products_roots", $acfID);
		$tempObject->products_roots = downloadParseProducts($products_roots);
		$tempObject->products_roots_other = get_field("other_products_roots");
		$products_seasonal = get_field("products_seasonal", $acfID);
		$tempObject->products_seasonal = downloadParseProducts($products_seasonal);
		$tempObject->products_seasonal_other = get_field("other_products_seasonal");
		$products_melons = get_field("products_melons", $acfID);
		$tempObject->products_melons = downloadParseProducts($products_melons);
		$tempObject->products_melons_other = get_field("other_products_melons");
		$products_herbs = get_field("products_herbs", $acfID);
		$tempObject->products_herbs = downloadParseProducts($products_herbs);
		$tempObject->products_herbs_other = get_field("other_products_herbs");
		$products_berries = get_field("products_berries", $acfID);
		$tempObject->products_berries = downloadParseProducts($products_berries);
		$tempObject->products_berries_other = get_field("other_products_berries");
		$products_small_fruits = get_field("products_small_fruits", $acfID);
		$tempObject->products_small_fruits = downloadParseProducts($products_small_fruits);
		$tempObject->products_small_fruits_other = get_field("other_products_small_fruits");
		$products_grains = get_field("products_grains", $acfID);
		$tempObject->products_grains = downloadParseProducts($products_grains);
		$tempObject->products_grains_other = get_field("other_products_grains");
		$products_value_added = get_field("products_value_added", $acfID);
		$tempObject->products_value_added = downloadParseProducts($products_value_added);
		$tempObject->products_value_added_other = get_field("other_products_value_added");
		$products_flowers = get_field("products_flowers", $acfID);
		$tempObject->products_flowers = downloadParseProducts($products_flowers);
		$tempObject->products_flowers_other = get_field("other_products_flowers");
		$products_plants = get_field("products_plants", $acfID);
		$tempObject->products_plants = downloadParseProducts($products_plants);
		$tempObject->products_plants_other = get_field("other_products_plants");
		$products_ornamentals = get_field("products_ornamentals", $acfID);
		$tempObject->products_ornamentals = downloadParseProducts($products_ornamentals);
		$tempObject->products_ornamentals_other = get_field("other_products_ornamentals");
		$products_syrups = get_field("products_syrups", $acfID);
		$tempObject->products_syrups = downloadParseProducts($products_syrups);
		$tempObject->products_syrups_other = get_field("other_products_syrups");
		$products_dairy = get_field("products_dairy", $acfID);
		$tempObject->products_dairy = downloadParseProducts($products_dairy);
		$tempObject->products_dairy_other = get_field("other_products_dairy");
		$products_meat = get_field("products_meat", $acfID);
		$tempObject->products_meat = downloadParseProducts($products_meat);
		$tempObject->products_meat_other = get_field("other_products_meat");
		$products_poultry = get_field("products_poultry", $acfID);
		$tempObject->products_poultry = downloadParseProducts($products_poultry);
		$tempObject->products_poultry_other = get_field("other_products_poultry");
		$products_agritourism = get_field("products_agritourism", $acfID);
		$tempObject->products_agritourism = downloadParseProducts($products_agritourism);
		$tempObject->products_agritourism_other = get_field("other_products_agritourism");
		$products_fibers = get_field("products_fibers", $acfID);
		$tempObject->products_fibers = downloadParseProducts($products_fibers);
		$tempObject->products_fibers_other = get_field("other_products_fibers");
		$products_artisinal = get_field("products_artisinal", $acfID);
		$tempObject->products_artisinal = downloadParseProducts($products_artisinal);
		$tempObject->products_artisinal_other = get_field("other_products_artisinal");
		$products_liquids = get_field("products_liquids", $acfID);
		$tempObject->products_liquids = downloadParseProducts($products_liquids);
		$tempObject->products_liquids_other = get_field("other_products_liquids");
		$products_educational = get_field("products_educational", $acfID);
		$tempObject->products_educational = downloadParseProducts($products_educational);
		$tempObject->products_educational_other = get_field("other_products_educational");
		$products_baked = get_field("products_baked", $acfID);
		$tempObject->products_baked = downloadParseProducts($products_baked);
		$tempObject->products_baked_other = get_field("other_products_baked");
		$products_seeds = get_field("products_seeds", $acfID);
		$tempObject->products_seeds = downloadParseProducts($products_seeds);
		$tempObject->products_seeds_other = get_field("other_products_seeds");
		$products_misc = get_field("products_misc", $acfID);
		$tempObject->products_misc = downloadParseProducts($products_misc);
		$tempObject->products_misc_other = get_field("other_products_misc");

		/** Wholesale Products **/
		$ws_products_greens = get_field("products_greens", $acfID);
		$tempObject->ws_products_greens = downloadParseProducts($ws_products_greens);
		$tempObject->ws_products_greens_other = get_field("other_ws_products_greens");
		$ws_products_roots = get_field("products_roots", $acfID);
		$tempObject->ws_products_roots = downloadParseProducts($ws_products_roots);
		$tempObject->ws_products_roots_other = get_field("other_ws_products_roots");
		$ws_products_seasonal = get_field("products_seasonal", $acfID);
		$tempObject->ws_products_seasonal = downloadParseProducts($ws_products_seasonal);
		$tempObject->ws_products_seasonal_other = get_field("other_ws_products_seasonal");
		$ws_products_melons = get_field("products_melons", $acfID);
		$tempObject->ws_products_melons = downloadParseProducts($ws_products_melons);
		$tempObject->ws_products_melons_other = get_field("other_ws_products_melons");
		$ws_products_herbs = get_field("products_herbs", $acfID);
		$tempObject->ws_products_herbs = downloadParseProducts($ws_products_herbs);
		$tempObject->ws_products_herbs_other = get_field("other_ws_products_herbs");
		$ws_products_berries = get_field("products_berries", $acfID);
		$tempObject->ws_products_berries = downloadParseProducts($ws_products_berries);
		$tempObject->ws_products_berries_other = get_field("other_ws_products_berries");
		$ws_products_small_fruits = get_field("products_small_fruits", $acfID);
		$tempObject->ws_products_small_fruits = downloadParseProducts($ws_products_small_fruits);
		$tempObject->ws_products_small_fruits_other = get_field("other_ws_products_small_fruits");
		$ws_products_grains = get_field("products_grains", $acfID);
		$tempObject->ws_products_grains = downloadParseProducts($ws_products_grains);
		$tempObject->ws_products_grains_other = get_field("other_ws_products_grains");
		$ws_products_value_added = get_field("products_value_added", $acfID);
		$tempObject->ws_products_value_added = downloadParseProducts($ws_products_value_added);
		$tempObject->ws_products_value_added_other = get_field("other_ws_products_value_added");
		$ws_products_flowers = get_field("products_flowers", $acfID);
		$tempObject->ws_products_flowers = downloadParseProducts($ws_products_flowers);
		$tempObject->ws_products_flowers_other = get_field("other_ws_products_flowers");
		$ws_products_plants = get_field("products_plants", $acfID);
		$tempObject->ws_products_plants = downloadParseProducts($ws_products_plants);
		$tempObject->ws_products_plants_other = get_field("other_ws_products_plants");
		$ws_products_ornamentals = get_field("products_ornamentals", $acfID);
		$tempObject->ws_products_ornamentals = downloadParseProducts($ws_products_ornamentals);
		$tempObject->ws_products_ornamentals_other = get_field("other_ws_products_ornamentals");
		$ws_products_syrups = get_field("products_syrups", $acfID);
		$tempObject->ws_products_syrups = downloadParseProducts($ws_products_syrups);
		$tempObject->ws_products_syrups_other = get_field("other_ws_products_syrups");
		$ws_products_dairy = get_field("products_dairy", $acfID);
		$tempObject->ws_products_dairy = downloadParseProducts($ws_products_dairy);
		$tempObject->ws_products_dairy_other = get_field("other_ws_products_dairy");
		$ws_products_meat = get_field("products_meat", $acfID);
		$tempObject->ws_products_meat = downloadParseProducts($ws_products_meat);
		$tempObject->ws_products_meat_other = get_field("other_ws_products_meat");
		$ws_products_poultry = get_field("products_poultry", $acfID);
		$tempObject->ws_products_poultry = downloadParseProducts($ws_products_poultry);
		$tempObject->ws_products_poultry_other = get_field("other_ws_products_poultry");
		$ws_products_agritourism = get_field("products_agritourism", $acfID);
		$tempObject->ws_products_agritourism = downloadParseProducts($ws_products_agritourism);
		$tempObject->ws_products_agritourism_other = get_field("other_ws_products_agritourism");
		$ws_products_fibers = get_field("products_fibers", $acfID);
		$tempObject->ws_products_fibers = downloadParseProducts($ws_products_fibers);
		$tempObject->ws_products_fibers_other = get_field("other_ws_products_fibers");
		$ws_products_artisinal = get_field("products_artisinal", $acfID);
		$tempObject->ws_products_artisinal = downloadParseProducts($ws_products_artisinal);
		$tempObject->ws_products_artisinal_other = get_field("other_ws_products_artisinal");
		$ws_products_liquids = get_field("products_liquids", $acfID);
		$tempObject->ws_products_liquids = downloadParseProducts($ws_products_liquids);
		$tempObject->ws_products_liquids_other = get_field("other_ws_products_liquids");
		$ws_products_educational = get_field("products_educational", $acfID);
		$tempObject->ws_products_educational = downloadParseProducts($ws_products_educational);
		$tempObject->ws_products_educational_other = get_field("other_ws_products_educational");
		$ws_products_baked = get_field("products_baked", $acfID);
		$tempObject->ws_products_baked = downloadParseProducts($ws_products_baked);
		$tempObject->ws_products_baked_other = get_field("other_ws_products_baked");
		$ws_products_seeds = get_field("products_seeds", $acfID);
		$tempObject->ws_products_seeds = downloadParseProducts($ws_products_seeds);
		$tempObject->ws_products_seeds_other = get_field("other_ws_products_seeds");
		$ws_products_misc = get_field("products_misc", $acfID);
		$tempObject->ws_products_misc = downloadParseProducts($ws_products_misc);
		$tempObject->ws_products_misc_other = get_field("other_ws_products_misc");


		/** Wholesale **/
		$is_wholesaler = get_field("is_wholesaler", $acfID);
		$tempObject->is_wholesaler = is_bool($is_wholesaler) ? $is_wholesaler : false;
		$quasi_wholesale = get_field("quasi_wholesale", $acfID);
		$tempObject->quasi_wholesale = is_bool($quasi_wholesale) ? $quasi_wholesale : false;
		$small_wholesale = get_field("small_wholesale", $acfID);
		$tempObject->small_wholesale = is_bool($small_wholesale) ? $small_wholesale : false;
		$large_wholesale = get_field("large_wholesale", $acfID);
		$tempObject->large_wholesale = is_bool($large_wholesale) ? $large_wholesale : false;
		$gap_certification = get_field("gap_certification", $acfID);
		$tempObject->gap_certification = is_bool($gap_certification) ? $gap_certification : false;
		$tempObject->gap_certified_since = get_field("gap_certified_since", $acfID);

		/** Farm Practices **/
		$certified_organic = get_field("certified_organic", $acfID);
		$tempObject->certified_organic = (is_bool($certified_organic)) ? $certified_organic : false;
		$tempObject->certified_organic_since = "";
		$tempObject->certified_organic_by = "";

		$certified_naturally_grown = get_field("certified_naturally_grown", $acfID);
		$tempObject->certified_naturally_grown = (is_bool($certified_naturally_grown)) ? $certified_naturally_grown : false;
		$tempObject->certified_naturally_grown_since = "";

		$certified_biodynamic = get_field("certified_biodynamic", $acfID);
		$tempObject->certified_biodynamic = (is_bool($certified_biodynamic)) ? $certified_biodynamic : false;
		$tempObject->certified_biodynamic_since = "";
		$tempObject->certified_biodynamic_by = "";

		$only_organic = get_field("only_organic", $acfID);
		$tempObject->only_organic = (is_bool($only_organic)) ? $only_organic : false;
		$integrated_pest_management = get_field("integrated_pest_management", $acfID);
		$tempObject->integrated_pest_management = (is_bool($integrated_pest_management)) ? $integrated_pest_management : false;
		$non_gmo = get_field("non_gmo", $acfID);
		$tempObject->non_gmo = (is_bool($non_gmo)) ? $non_gmo : false;
		$antibiotic_harmone_free = get_field("antibiotic_harmone_free", $acfID);
		$tempObject->antibiotic_harmone_free = (is_bool($antibiotic_harmone_free)) ? $antibiotic_harmone_free : false;
		$pastured = get_field("pastured", $acfID);
		$tempObject->pastured = (is_bool($pastured)) ? $pastured : false;
		$grass_fed = get_field("grass_fed", $acfID);
		$tempObject->grass_fed = (is_bool($grass_fed)) ? $grass_fed : false;
		$extended_growing_season = get_field("extended_growing_season", $acfID);
		$tempObject->extended_growing_season = (is_bool($extended_growing_season)) ? $extended_growing_season : false;
		$tempObject->other_practices = get_field("other_practices", $acfID);

		/** Acres **/
		$tempObject->acres_owned = get_field("acres_owned", $acfID);
		$tempObject->acres_rented = get_field("acres_rented", $acfID);
		$tempObject->acres_production = get_field("acres_production", $acfID);

		/** CSA / Farm Share **/
		$is_farm_share = get_field("is_farm_share", $acfID);
		$tempObject->is_farm_share = (is_bool($is_farm_share)) ? $is_farm_share : false;
		$is_csa = get_field("is_csa", $acfID);
		$tempObject->is_csa = (is_bool($is_csa)) ? $is_csa : false;


		$partnersArray[] = $tempObject;
		$tempObject = null;
	}

	/** Include PHPExcel */
	require_once dirname(__FILE__) . '/../classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("BFBLGLV")
								 ->setLastModifiedBy("BFBLGLV")
								 ->setTitle("BFBLGLV Partners")
								 ->setSubject("BFBLGLV Partner Export")
								 ->setDescription("BFBLGLV Partner Export")
								 ->setKeywords("")
								 ->setCategory("");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Name')
	            ->setCellValue('B1', 'Partner Phone')
	            ->setCellValue('C1', 'Partner Website')
	            ->setCellValue('D1', 'Partner Email')
	            ->setCellValue('E1', 'Owner Name')
				->setCellValue('F1', 'Owner Phone')
				->setCellValue('G1', 'Owner Email')
	            ->setCellValue('H1', 'Contact Name')
	            ->setCellValue('I1', 'Contact Position')
				->setCellValue('J1', 'Contact Phone')
				->setCellValue('K1', 'Contact Email')
	            ->setCellValue('L1', 'Facebook URL')
				->setCellValue('M1', 'Twitter Username')
				->setCellValue('N1', 'Instagram Username')
				->setCellValue('O1', 'County')
				->setCellValue('P1', 'Address')
				->setCellValue('Q1', 'Hours')
				->setCellValue('R1', 'Products available at')
				->setCellValue('S1', 'Products also available at')
				->setCellValue('T1', 'Products available from')
				->setCellValue('U1', 'Products also available from')
				->setCellValue('V1', 'Sourced from')
				->setCellValue('W1', 'Also Sourced from')
				->setCellValue('X1', 'Local Stock')
				->setCellValue('Y1', 'Appointments')
				->setCellValue('Z1', 'Products: Greens')
				->setCellValue('AA1', 'Products: Greens Other')
				->setCellValue('AB1', 'Products: Roots')
				->setCellValue('AC1', 'Products: Roots Other')
				->setCellValue('AD1', 'Products: Seasonal')
				->setCellValue('AE1', 'Products: Seasonal Other')
				->setCellValue('AF1', 'Products: Melons')
				->setCellValue('AG1', 'Products: Melons Other')
				->setCellValue('AH1', 'Products: Herbs')
				->setCellValue('AI1', 'Products: Herbs Other')
				->setCellValue('AJ1', 'Products: Berries')
				->setCellValue('AK1', 'Products: Berries Other')
				->setCellValue('AL1', 'Products: Small Fruits')
				->setCellValue('AM1', 'Products: Small Fruits Other')
				->setCellValue('AN1', 'Products: Grains')
				->setCellValue('AO1', 'Products: Grains Other')
				->setCellValue('AP1', 'Products: Value Added')
				->setCellValue('AQ1', 'Products: Value Added Other')
				->setCellValue('AR1', 'Products: Flowers')
				->setCellValue('AS1', 'Products: Flowers Other')
				->setCellValue('AT1', 'Products: Plants')
				->setCellValue('AU1', 'Products: Plants Other')
				->setCellValue('AV1', 'Products: Ornamentals')
				->setCellValue('AW1', 'Products: Ornamentals Other')
				->setCellValue('AX1', 'Products: Syrups')
				->setCellValue('AY1', 'Products: Syrups Other')
				->setCellValue('AZ1', 'Products: Dairy')
				->setCellValue('BA1', 'Products: Dairy Other')
				->setCellValue('BB1', 'Products: Meat')
				->setCellValue('BC1', 'Products: Meat Other')
				->setCellValue('BD1', 'Products: Poultry')
				->setCellValue('BE1', 'Products: Poultry Other')
				->setCellValue('BF1', 'Products: Agritourism')
				->setCellValue('BG1', 'Products: Agritourism Other')
				->setCellValue('BH1', 'Products: Fibers')
				->setCellValue('BI1', 'Products: Fibers Other')
				->setCellValue('BJ1', 'Products: Artisinal')
				->setCellValue('BK1', 'Products: Artisinal Other')
				->setCellValue('BL1', 'Products: Liquids')
				->setCellValue('BM1', 'Products: Liquids Other')
				->setCellValue('BN1', 'Products: Educational')
				->setCellValue('BO1', 'Products: Educational Other')
				->setCellValue('BP1', 'Products: Baked')
				->setCellValue('BQ1', 'Products: Baked Other')
				->setCellValue('BR1', 'Products: Seeds')
				->setCellValue('BS1', 'Products: Seeds Other')
				->setCellValue('BT1', 'Products: Misc')
				->setCellValue('BU1', 'Products: Misc Other')
				->setCellValue('BV1', 'Wholesaler')
				->setCellValue('BW1', 'Quasi Wholesale')
				->setCellValue('BX1', 'Small Wholesale')
				->setCellValue('BY1', 'Large Wholesale')
				->setCellValue('BZ1', 'GAP Certified')
				->setCellValue('CA1', 'GAP Certified Since')
				->setCellValue('CB1', 'Wholesale Products: Greens')
				->setCellValue('CC1', 'Wholesale Products: Greens Other')
				->setCellValue('CD1', 'Wholesale Products: Roots')
				->setCellValue('CE1', 'Wholesale Products: Roots Other')
				->setCellValue('CF1', 'Wholesale Products: Seasonal')
				->setCellValue('CG1', 'Wholesale Products: Seasonal Other')
				->setCellValue('CH1', 'Wholesale Products: Melons')
				->setCellValue('CI1', 'Wholesale Products: Melons Other')
				->setCellValue('CJ1', 'Wholesale Products: Herbs')
				->setCellValue('CK1', 'Wholesale Products: Herbs Other')
				->setCellValue('CL1', 'Wholesale Products: Berries')
				->setCellValue('CM1', 'Wholesale Products: Berries Other')
				->setCellValue('CN1', 'Wholesale Products: Small Fruits')
				->setCellValue('CO1', 'Wholesale Products: Small Fruits Other')
				->setCellValue('CP1', 'Wholesale Products: Grains')
				->setCellValue('CQ1', 'Wholesale Products: Grains Other')
				->setCellValue('CR1', 'Wholesale Products: Value Added')
				->setCellValue('CS1', 'Wholesale Products: Value Added Other')
				->setCellValue('CT1', 'Wholesale Products: Flowers')
				->setCellValue('CU1', 'Wholesale Products: Flowers Other')
				->setCellValue('CV1', 'Wholesale Products: Plants')
				->setCellValue('CW1', 'Wholesale Products: Plants Other')
				->setCellValue('CX1', 'Wholesale Products: Ornamentals')
				->setCellValue('CY1', 'Wholesale Products: Ornamentals Other')
				->setCellValue('CZ1', 'Wholesale Products: Syrups')
				->setCellValue('DA1', 'Wholesale Products: Syrups Other')
				->setCellValue('DB1', 'Wholesale Products: Dairy')
				->setCellValue('DC1', 'Wholesale Products: Dairy Other')
				->setCellValue('DD1', 'Wholesale Products: Meat')
				->setCellValue('DE1', 'Wholesale Products: Meat Other')
				->setCellValue('DF1', 'Wholesale Products: Poultry')
				->setCellValue('DG1', 'Wholesale Products: Poultry Other')
				->setCellValue('DH1', 'Wholesale Products: Agritourism')
				->setCellValue('DI1', 'Wholesale Products: Agritourism Other')
				->setCellValue('DJ1', 'Wholesale Products: Fibers')
				->setCellValue('DK1', 'Wholesale Products: Fibers Other')
				->setCellValue('DL1', 'Wholesale Products: Artisinal')
				->setCellValue('DM1', 'Wholesale Products: Artisinal Other')
				->setCellValue('DN1', 'Wholesale Products: Liquids')
				->setCellValue('DO1', 'Wholesale Products: Liquids Other')
				->setCellValue('DP1', 'Wholesale Products: Educational')
				->setCellValue('DQ1', 'Wholesale Products: Educational Other')
				->setCellValue('DR1', 'Wholesale Products: Baked')
				->setCellValue('DS1', 'Wholesale Products: Baked Other')
				->setCellValue('DT1', 'Wholesale Products: Seeds')
				->setCellValue('DU1', 'Wholesale Products: Seeds Other')
				->setCellValue('DV1', 'Wholesale Products: Misc')
				->setCellValue('DW1', 'Wholesale Products: Misc Other')
				->setCellValue('DX1', 'Certified Organic')
				->setCellValue('DY1', 'Certified Organic Since')
				->setCellValue('DZ1', 'Certified Organic By')
				->setCellValue('EA1', 'Certified Naturally Grown')
				->setCellValue('EB1', 'Certified Naturally Grown Since')
				->setCellValue('EC1', 'Certified Biodynamic')
				->setCellValue('ED1', 'Certified Biodynamic Since')
				->setCellValue('EE1', 'Certified Biodynamic By')
				->setCellValue('EF1', 'Only Organic')
				->setCellValue('EG1', 'IPM')
				->setCellValue('EH1', 'Non-GMO')
				->setCellValue('EI1', 'Antibiotic and Harmone Free')
				->setCellValue('EJ1', 'Pastured')
				->setCellValue('EK1', 'Grass Fed')
				->setCellValue('EL1', 'Extended Growing Season')
				->setCellValue('EM1', 'Other Practices')
				->setCellValue('EN1', 'Acres Owned')
				->setCellValue('EO1', 'Acres Rented')
				->setCellValue('EP1', 'Acres in Production')
				->setCellValue('EQ1', 'Is Farm Share')
				->setCellValue('ER1', 'Is CSA');

	$cellCounter = "1";
	foreach ($partnersArray as $partner) {
		if (is_object($partner)) {
			$cellCounter++;
			$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A' . $cellCounter, xlsBreaks($partner->name))
	            ->setCellValue('B' . $cellCounter, xlsBreaks($partner->partner_phone))
	            ->setCellValue('C' . $cellCounter, xlsBreaks($partner->partner_website))
	            ->setCellValue('D' . $cellCounter, xlsBreaks($partner->partner_email))
	            ->setCellValue('E' . $cellCounter, xlsBreaks($partner->owner_name))
				->setCellValue('F' . $cellCounter, xlsBreaks($partner->owner_phone))
				->setCellValue('G' . $cellCounter, xlsBreaks($partner->owner_email))
	            ->setCellValue('H' . $cellCounter, xlsBreaks($partner->contact_name))
	            ->setCellValue('I' . $cellCounter, xlsBreaks($partner->contact_position))
				->setCellValue('J' . $cellCounter, xlsBreaks($partner->contact_phone))
				->setCellValue('K' . $cellCounter, xlsBreaks($partner->contact_email))
	            ->setCellValue('L' . $cellCounter, xlsBreaks($partner->facebook_page))
				->setCellValue('M' . $cellCounter, xlsBreaks($partner->twitter_username))
				->setCellValue('N' . $cellCounter, xlsBreaks($partner->instagram_username))
				->setCellValue('O' . $cellCounter, xlsBreaks($partner->county))
				->setCellValue('P' . $cellCounter, xlsBreaks($partner->location_address))
				->setCellValue('Q' . $cellCounter, xlsBreaks($partner->hours))
				->setCellValue('R' . $cellCounter, xlsBreaks($partner->products_available_at))
				->setCellValue('S' . $cellCounter, xlsBreaks($partner->products_available_at_other))
				->setCellValue('T' . $cellCounter, xlsBreaks($partner->products_available_from))
				->setCellValue('U' . $cellCounter, xlsBreaks($partner->products_available_from_other))
				->setCellValue('V' . $cellCounter, xlsBreaks($partner->source_from))
				->setCellValue('W' . $cellCounter, xlsBreaks($partner->source_from_other))
				->setCellValue('X' . $cellCounter, xlsBreaks($partner->local_stock))
				->setCellValue('Y' . $cellCounter, $partner->appointments)
				->setCellValue('Z' . $cellCounter, xlsBreaks($partner->products_greens))
				->setCellValue('AA' . $cellCounter, xlsBreaks($partner->products_greens_other))
				->setCellValue('AB' . $cellCounter, xlsBreaks($partner->products_roots))
				->setCellValue('AC' . $cellCounter, xlsBreaks($partner->products_roots_other))
				->setCellValue('AD' . $cellCounter, xlsBreaks($partner->products_seasonal))
				->setCellValue('AE' . $cellCounter, xlsBreaks($partner->products_seasonal_other))
				->setCellValue('AF' . $cellCounter, xlsBreaks($partner->products_melons))
				->setCellValue('AG' . $cellCounter, xlsBreaks($partner->products_melons_other))
				->setCellValue('AH' . $cellCounter, xlsBreaks($partner->products_herbs))
				->setCellValue('AI' . $cellCounter, xlsBreaks($partner->products_herbs_other))
				->setCellValue('AJ' . $cellCounter, xlsBreaks($partner->products_berries))
				->setCellValue('AK' . $cellCounter, xlsBreaks($partner->products_berries_other))
				->setCellValue('AL' . $cellCounter, xlsBreaks($partner->products_small_fruits))
				->setCellValue('AM' . $cellCounter, xlsBreaks($partner->products_small_fruits_other))
				->setCellValue('AN' . $cellCounter, xlsBreaks($partner->products_grains))
				->setCellValue('AO' . $cellCounter, xlsBreaks($partner->products_grains_other))
				->setCellValue('AP' . $cellCounter, xlsBreaks($partner->products_value_added))
				->setCellValue('AQ' . $cellCounter, xlsBreaks($partner->products_value_added_other))
				->setCellValue('AR' . $cellCounter, xlsBreaks($partner->products_flowers))
				->setCellValue('AS' . $cellCounter, xlsBreaks($partner->products_flowers_other))
				->setCellValue('AT' . $cellCounter, xlsBreaks($partner->products_plants))
				->setCellValue('AU' . $cellCounter, xlsBreaks($partner->products_plants_other))
				->setCellValue('AV' . $cellCounter, xlsBreaks($partner->products_ornamentals))
				->setCellValue('AW' . $cellCounter, xlsBreaks($partner->products_ornamentals_other))
				->setCellValue('AX' . $cellCounter, xlsBreaks($partner->products_syrups))
				->setCellValue('AY' . $cellCounter, xlsBreaks($partner->products_syrups_other))
				->setCellValue('AZ' . $cellCounter, xlsBreaks($partner->products_dairy))
				->setCellValue('BA' . $cellCounter, xlsBreaks($partner->products_dairy_other))
				->setCellValue('BB' . $cellCounter, xlsBreaks($partner->products_meat))
				->setCellValue('BC' . $cellCounter, xlsBreaks($partner->products_meat_other))
				->setCellValue('BD' . $cellCounter, xlsBreaks($partner->products_poultry))
				->setCellValue('BE' . $cellCounter, xlsBreaks($partner->products_poultry_other))
				->setCellValue('BF' . $cellCounter, xlsBreaks($partner->products_agritourism))
				->setCellValue('BG' . $cellCounter, xlsBreaks($partner->products_agritourism_other))
				->setCellValue('BH' . $cellCounter, xlsBreaks($partner->products_fibers))
				->setCellValue('BI' . $cellCounter, xlsBreaks($partner->products_fibers_other))
				->setCellValue('BJ' . $cellCounter, xlsBreaks($partner->products_artisinal))
				->setCellValue('BK' . $cellCounter, xlsBreaks($partner->products_artisinal_other))
				->setCellValue('BL' . $cellCounter, xlsBreaks($partner->products_liquids))
				->setCellValue('BM' . $cellCounter, xlsBreaks($partner->products_liquids_other))
				->setCellValue('BN' . $cellCounter, xlsBreaks($partner->products_educational))
				->setCellValue('BO' . $cellCounter, xlsBreaks($partner->products_educational_other))
				->setCellValue('BP' . $cellCounter, xlsBreaks($partner->products_baked))
				->setCellValue('BQ' . $cellCounter, xlsBreaks($partner->products_baked_other))
				->setCellValue('BR' . $cellCounter, xlsBreaks($partner->products_seeds))
				->setCellValue('BS' . $cellCounter, xlsBreaks($partner->products_seeds_other))
				->setCellValue('BT' . $cellCounter, xlsBreaks($partner->products_misc))
				->setCellValue('BU' . $cellCounter, xlsBreaks($partner->products_misc_other))
				->setCellValue('BV' . $cellCounter, $partner->is_wholesaler)
				->setCellValue('BW' . $cellCounter, $partner->quasi_wholesale)
				->setCellValue('BX' . $cellCounter, $partner->small_wholesale)
				->setCellValue('BY' . $cellCounter, $partner->large_wholesale)
				->setCellValue('BZ' . $cellCounter, $partner->gap_certification)
				->setCellValue('CA' . $cellCounter, xlsBreaks($partner->gap_certified_since))
				->setCellValue('CB' . $cellCounter, xlsBreaks($partner->ws_products_greens))
				->setCellValue('CC' . $cellCounter, xlsBreaks($partner->ws_products_greens_other))
				->setCellValue('CD' . $cellCounter, xlsBreaks($partner->ws_products_roots))
				->setCellValue('CE' . $cellCounter, xlsBreaks($partner->ws_products_roots_other))
				->setCellValue('CF' . $cellCounter, xlsBreaks($partner->ws_products_seasonal))
				->setCellValue('CG' . $cellCounter, xlsBreaks($partner->ws_products_seasonal_other))
				->setCellValue('CH' . $cellCounter, xlsBreaks($partner->ws_products_melons))
				->setCellValue('CI' . $cellCounter, xlsBreaks($partner->ws_products_melons_other))
				->setCellValue('CJ' . $cellCounter, xlsBreaks($partner->ws_products_herbs))
				->setCellValue('CK' . $cellCounter, xlsBreaks($partner->ws_products_herbs_other))
				->setCellValue('CL' . $cellCounter, xlsBreaks($partner->ws_products_berries))
				->setCellValue('CM' . $cellCounter, xlsBreaks($partner->ws_products_berries_other))
				->setCellValue('CN' . $cellCounter, xlsBreaks($partner->ws_products_small_fruits))
				->setCellValue('CO' . $cellCounter, xlsBreaks($partner->ws_products_small_fruits_other))
				->setCellValue('CP' . $cellCounter, xlsBreaks($partner->ws_products_grains))
				->setCellValue('CQ' . $cellCounter, xlsBreaks($partner->ws_products_grains_other))
				->setCellValue('CR' . $cellCounter, xlsBreaks($partner->ws_products_value_added))
				->setCellValue('CS' . $cellCounter, xlsBreaks($partner->ws_products_value_added_other))
				->setCellValue('CT' . $cellCounter, xlsBreaks($partner->ws_products_flowers))
				->setCellValue('CU' . $cellCounter, xlsBreaks($partner->ws_products_flowers_other))
				->setCellValue('CV' . $cellCounter, xlsBreaks($partner->ws_products_plants))
				->setCellValue('CW' . $cellCounter, xlsBreaks($partner->ws_products_plants_other))
				->setCellValue('CX' . $cellCounter, xlsBreaks($partner->ws_products_ornamentals))
				->setCellValue('CY' . $cellCounter, xlsBreaks($partner->ws_products_ornamentals_other))
				->setCellValue('CZ' . $cellCounter, xlsBreaks($partner->ws_products_syrups))
				->setCellValue('DA' . $cellCounter, xlsBreaks($partner->ws_products_syrups_other))
				->setCellValue('DB' . $cellCounter, xlsBreaks($partner->ws_products_dairy))
				->setCellValue('DC' . $cellCounter, xlsBreaks($partner->ws_products_dairy_other))
				->setCellValue('DD' . $cellCounter, xlsBreaks($partner->ws_products_meat))
				->setCellValue('DE' . $cellCounter, xlsBreaks($partner->ws_products_meat_other))
				->setCellValue('DF' . $cellCounter, xlsBreaks($partner->ws_products_poultry))
				->setCellValue('DG' . $cellCounter, xlsBreaks($partner->ws_products_poultry_other))
				->setCellValue('DH' . $cellCounter, xlsBreaks($partner->ws_products_agritourism))
				->setCellValue('DI' . $cellCounter, xlsBreaks($partner->ws_products_agritourism_other))
				->setCellValue('DJ' . $cellCounter, xlsBreaks($partner->ws_products_fibers))
				->setCellValue('DK' . $cellCounter, xlsBreaks($partner->ws_products_fibers_other))
				->setCellValue('DL' . $cellCounter, xlsBreaks($partner->ws_products_artisinal))
				->setCellValue('DM' . $cellCounter, xlsBreaks($partner->ws_products_artisinal_other))
				->setCellValue('DN' . $cellCounter, xlsBreaks($partner->ws_products_liquids))
				->setCellValue('DO' . $cellCounter, xlsBreaks($partner->ws_products_liquids_other))
				->setCellValue('DP' . $cellCounter, xlsBreaks($partner->ws_products_educational))
				->setCellValue('DQ' . $cellCounter, xlsBreaks($partner->ws_products_educational_other))
				->setCellValue('DR' . $cellCounter, xlsBreaks($partner->ws_products_baked))
				->setCellValue('DS' . $cellCounter, xlsBreaks($partner->ws_products_baked_other))
				->setCellValue('DT' . $cellCounter, xlsBreaks($partner->ws_products_seeds))
				->setCellValue('DU' . $cellCounter, xlsBreaks($partner->ws_products_seeds_other))
				->setCellValue('DV' . $cellCounter, xlsBreaks($partner->ws_products_misc))
				->setCellValue('DW' . $cellCounter, xlsBreaks($partner->ws_products_misc_other))
				->setCellValue('DX' . $cellCounter, $partner->certified_organic)
				->setCellValue('DY' . $cellCounter, xlsBreaks($partner->certified_organic_since))
				->setCellValue('DZ' . $cellCounter, xlsBreaks($partner->certified_organic_by))
				->setCellValue('EA' . $cellCounter, $partner->certified_naturally_grown)
				->setCellValue('EB' . $cellCounter, xlsBreaks($partner->certified_naturally_grown_since))
				->setCellValue('EC' . $cellCounter, $partner->certified_biodynamic)
				->setCellValue('ED' . $cellCounter, xlsBreaks($partner->certified_biodynamic_since))
				->setCellValue('EE' . $cellCounter, xlsBreaks($partner->certified_biodynamic_by))
				->setCellValue('EF' . $cellCounter, $partner->only_organic)
				->setCellValue('EG' . $cellCounter, $partner->integrated_pest_management)
				->setCellValue('EH' . $cellCounter, $partner->non_gmo)
				->setCellValue('EI' . $cellCounter, $partner->antibiotic_harmone_free)
				->setCellValue('EJ' . $cellCounter, $partner->pastured)
				->setCellValue('EK' . $cellCounter, $partner->grass_fed)
				->setCellValue('EL' . $cellCounter, $partner->extended_growing_season)
				->setCellValue('EM' . $cellCounter, xlsBreaks($partner->other_practices))
				->setCellValue('EN' . $cellCounter, xlsBreaks($partner->acres_owned))
				->setCellValue('EO' . $cellCounter, xlsBreaks($partner->acres_rented))
				->setCellValue('EP' . $cellCounter, xlsBreaks($partner->acres_production))
				->setCellValue('EQ' . $cellCounter, $partner->is_farm_share)
				->setCellValue('ER' . $cellCounter, $partner->is_csa);
		}
	}

	// $objPHPExcel->getActiveSheet()
	// 			->getStyle('A2:ER500')
 //    			->getAlignment()
 //    			->setWrapText(true);

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Partners');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="partner_export.xls"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}