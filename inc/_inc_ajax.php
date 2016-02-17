<?php
class MapPartner {
	public $id = false;
	public $name = false;
	public $url = false;
	public $lat = false;
	public $lng = false;
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
	//$hours = explode("\n", $hours);
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
					"value" => "",
					"compare" => "!="
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
	echo "Executing addPartnerData()\n";
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

	//Hours of Operation
	// if ($partner->hours) {
	// 	$splitHours = splitHours($partner->hours);
	// }

	//FARM Details
	if ($partner->category === "farm") {
		
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

		$locationTypePartners = get_users($locationTypeQueryArgs);

		if (is_array($locationTypePartners) && count($locationTypePartners) > 0) {
			$tempPartners = array_merge($locationTypePartners, $tempPartners);
		}
	}

	foreach ($tempPartners as $partnerKey=>$partner) {
		$tempObj = new MapPartner;
		$tempObj->id = $partner->ID;
		$tempName = get_field("partner_name", "user_{$partner->ID}");
		$tempObj->name = strlen($tempName) > 0 ? $tempName : $partner->display_name;
		$tempMap = get_field("partner_map", "user_{$partner->ID}");
		if (!empty($tempMap)) {
			$tempObj->lat = $tempMap["lat"];
			$tempObj->lng = $tempMap["lng"];
		}
		$tempObj->url = get_author_posts_url($partner->ID);
		$returnPartners[] = $tempObj;
		$tempObj = null;
		$tempName = null;
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
	$new_user_args = array(
		"role" => $category,
		"user_login" => $username,
		"user_pass" => "password",
		"first_name" => $partner->partner_name,
		"last_name" => $user_last_name,
		"user_nicename" => $slug,
		"display_name" => $partner->partner_name,
		"user_email" => "sean.metzgar+{$slug}@gmail.com",
		"user_registered" => $member_since
	);
	$user_id = wp_insert_user($new_user_args);
	echo "<pre>";
	if (is_int($user_id) && $user_id > 0) {
		echo "New Partner Created: $user_id\n";
		addPartnerData($user_id, $partner);
	}
	echo "Execution complete\n";
	echo "</pre>";
   	die();
}