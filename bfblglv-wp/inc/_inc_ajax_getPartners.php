<?php
function createMapPartners($partners, $zipBounds, $county, $productTypes, $specificProducts, $wholesale) {
	$mapPartners = array();
	$renewalYear = getRenewalYear();
	$renewalShutDownTime = getRenewalShutDown(true);
	$renewalGrandfatheredTime = getRenewalGrandfathered();

	foreach ($partners as $id) {
		if ($id = intval($id)) {
			$acf_id = "user_{$id}";
			$tempRenewedUntil = get_field("partner_renewed_until", $acf_id);
			// $tempRenewedDate = get_field("partner_renewed_date", $acf_id);
			// $tempRenewedDate = strtotime($tempRenewedDate);

			// if ($tempRenewedDate < $renewalGrandfatheredTime) {
			// 	$tempRenewedUntil = $renewalYear - 1;
			// 	update_field("partner_renewed_until", $tempRenewedUntil, "user_{$partner->ID}");
			// 	update_user_meta($partner->ID, "ja_disable_user", 1 );
			// }

			if (is_numeric($tempRenewedUntil)) {
				if (($tempRenewedUntil < $renewalYear) && (time() >= $renewalShutDownTime)) {
					update_user_meta($id, "ja_disable_user", 1 );
				} elseif (($tempRenewedUntil < $renewalYear) && (time() < $renewalShutDownTime)) {
					update_user_meta($id, "ja_disable_user", 0 );
				}
			}
			$tempDisabled = get_user_meta( $id, "ja_disable_user", true );

			if (!$tempDisabled) {
				if ((!$productTypes && !$specificProducts) || checkPartnerProducts($id, $productTypes, $specificProducts, $wholesale)) {
					$tempObj = new MapPartner;
					$tempObj->id = $id;
					$tempName = get_field("partner_name", $acf_id);
					$tempCity = get_field("partner_city", $acf_id);
					$tempCounty = get_field("partner_county", $acf_id);
					$tempMap = get_field("partner_map", $acf_id);

					$tempObj->name = strlen($tempName) > 0 ? $tempName : get_author_name($id);
					$tempObj->url = get_author_posts_url($id);

					if (!empty($tempMap)) {
						$tempObj->lat = $tempMap["lat"];
						$tempObj->lng = $tempMap["lng"];
					}
					$tempObj->city = $tempCity;
					$tempObj->county = $tempCounty;
					$tempObj->renewedUntil = $tempRenewedUntil;

					if (checkPartnerLocation($tempObj, $zipBounds, $county)) {
						$mapPartners[]=$tempObj;
					}

					//Reset temp variables
					$tempObj = null;
					$tempName = null;
					$tempCity = null;
					$tempCounty = null;
					$tempMap = null;
					$tempDisabled = false;
				}
			}
		}
	}
	return $mapPartners;
}

function checkPartnerLocation($obj, $zipBounds, $county) {
	$rVal = false;
	if (is_object($obj)) {
		if (is_object($zipBounds) && ($obj->lat && $obj->lng)) {
			if ($obj->lat < $zipBounds->maxLat && $obj->lat > $zipBounds->minLat &&
				$obj->lng < $zipBounds->maxLng && $obj->lng > $zipBounds->minLng) {
				$rVal = true;
			}
		} elseif ($county && $obj->county) {
			if ($county == $obj->county) {
				$rVal = true;
			}
		} else {
			$rVal = true;
		}
	}

	return $rVal;
}

function checkPartnerProducts($id, $productTypes, $specificProducts, $wholesale) {
	$rVal = false;
	$fm = get_field("farm_type", "user_{$id}");
	$fm = $fm === "Farm Market" ? true : false;

	if (!is_array($productTypes) || count($productTypes) == 0 && (is_array($specificProducts) && count($specificProducts) > 0)) {
		$productTypes = array(
			"greens", "roots", "seasonal",
			"melons", "herbs", "berries",
			"small_fruits", "grains", "value_added",
			"flowers", "plants", "ornamentals",
			"syrups", "dairy", "meat",
			"poultry", "eggs", "mushrooms",
			"agritourism", "fibers",
			"artisinal", "liquids", "educational",
			"baked", "seeds", "pyo", "misc"
		);
	}

	if (is_array($productTypes) && count($productTypes) > 0) {
		foreach ($productTypes as $productType) {
			$tempProductTypeField = "products_{$productType}";
			$tempProductTypeField = ($wholesale) ? "ws_$tempProductTypeField" : $tempProductTypeField;
			$tempProductTypeOtherField = "other_{$tempProductTypeField}";

			$tempProductTypeField = get_field($tempProductTypeField, "user_{$id}");
			$tempProductTypeOtherField = get_field($tempProductTypeOtherField, "user_{$id}");

			$hasProductTypeField = (is_array($tempProductTypeField) && count($tempProductTypeField) > 0) ? true : false;
			$hasProductTypeOtherField = ($tempProductTypeOtherField) ? true : false;

			if (is_array($specificProducts) && count($specificProducts) > 0 && $hasProductTypeField) {
				foreach ($specificProducts as $specificProduct) {
					if (in_array($specificProduct, $tempProductTypeField)) { $rVal = true; }
				}
			} elseif ($hasProductTypeField || $hasProductTypeOtherField) { $rVal = true; }

			//Do it again for Farm Market products
			if (!$wholesale && $fm) {
				$tempProductTypeField = "fm_products_{$productType}";
				$tempProductTypeOtherField = "other_{$tempProductTypeField}";

				$tempProductTypeField = get_field($tempProductTypeField, "user_{$id}");
				$tempProductTypeOtherField = get_field($tempProductTypeOtherField, "user_{$id}");

				$hasProductTypeField = (is_array($tempProductTypeField) && count($tempProductTypeField) > 0) ? true : false;
				$hasProductTypeOtherField = ($tempProductTypeOtherField) ? true : false;

				if (is_array($specificProducts) && count($specificProducts) > 0 && $hasProductTypeField) {
					foreach ($specificProducts as $specificProduct) {
						if (in_array($specificProduct, $tempProductTypeField)) { $rVal = true; }
					}
				} elseif ($hasProductTypeField || $hasProductTypeOtherField) { $rVal = true; }
			}
		}
	} else { $rVal = true; }

	return $rVal;
}

function getPseudoLocationTypeMetaQuery($csa, $farmShare, $agritourism) {
	$rVal = false;
	if ($csa || $farmShare || $agritourism) {
		$rVal = array("relation" => "OR");
		if ($csa) {
			array_push($rVal,
				array(
					"key" => "is_csa",
					"value" => 1,
					"compare" => "="
				),
				array(
					"key" => "is_winter_csa",
					"value" => 1,
					"compare" => "="
				),
				array(
					"key" => "is_fall_csa",
					"value" => 1,
					"compare" => "="
				)
			);
		}
		if ($farmShare) {
			array_push($rVal,
				array(
					"key" => "is_farm_share",
					"value" => 1,
					"compare" => "="
				)
			);
		}
		if ($agritourism) {
			array_push($rVal,
				array(
					"key" => "is_agritourism",
					"value" => 1,
					"compare" => "="
				)
			);
		}
	}
	return $rVal;
}

function xhrGetPartners() {
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	//Setup Location Boundry Variables
	$zip = (isset($_REQUEST["zip"])) ? "".$_REQUEST["zip"] : false;
	$zip = ($zip && strlen($zip) >= 5) ? substr($zip, 0, 5) : false;
	$zipBounds = false;
	$county = false;

	if ($zip) {
		$zipBounds = getZipBounds($zip);
	} else {
		$county = (isset($_REQUEST["county"])) ? "".$_REQUEST["county"] : false;
	}

	//Defaults
	$pseudoLocationTypeMetaQuery = false;
	$wholesalerMetaQuery = false;
	$metaQuery = false;

	//Default Location Types
	$allLocationTypes = array(
		"farm", "farmers-market",
		"restaurant", "vineyard",
		"distillery", "institution",
		"distributor", "specialty",
		"retail"
	);

	//Search Fields ($_REQUEST)
	$locationTypes =	(isset($_REQUEST["location_type"])
						&& is_array($_REQUEST["location_type"])
						&& count($_REQUEST["location_type"] > 0))
							? $_REQUEST["location_type"] : array();
	$productTypes =		(isset($_REQUEST["product_type"])
						&& is_array($_REQUEST["product_type"])
						&& count($_REQUEST["product_type"] > 0))
						? $_REQUEST["product_type"] : false;
	$specificProducts =	(isset($_REQUEST["specific_products"])
						&& is_array($_REQUEST["specific_products"])
						&& count($_REQUEST["specific_products"] > 0))
							? $_REQUEST["specific_products"] : false;

	//Other Checkboxes ($_REQUEST)
    $doublesnap =       (isset($_REQUEST["doublesnap"]) &&
                        ($_REQUEST["doublesnap"] == "true" ||
                        $_REQUEST["doublesnap"] == "1"))
                            ? true : false;
	$wholesale = 		(isset($_REQUEST["wholesale"]) &&
						($_REQUEST["wholesale"] == "true" ||
						$_REQUEST["wholesale"] == "1"))
							? true : false;
	$csa = 				(isset($_REQUEST["csa"]) &&
						($_REQUEST["csa"] == "true" ||
						$_REQUEST["csa"] == "1"))
							? true : false;
	$farmShare = 		(isset($_REQUEST["farm_share"]) &&
						($_REQUEST["farm_share"] == "true" ||
						$_REQUEST["farm_share"] == "1"))
							? true : false;
	$agritourism = 		(isset($_REQUEST["agritourism"]) &&
						($_REQUEST["agritourism"] == "true" ||
						$_REQUEST["agritourism"] == "1"))
							? true : false;

	//Add Pseudo Location Types & Meta Query
	if ($csa || $farmShare || $agritourism) {
		$doPseudoQuery = true;
	} else {
		$doPseudoQuery = false;
		$locationTypes = (count($locationTypes) > 0) ? $locationTypes : $allLocationTypes;
	}

	$doMainQuery = (count($locationTypes) > 0) ? true : false;

	$pseudoLocationTypeMetaQuery = getPseudoLocationTypeMetaQuery($csa, $farmShare, $agritourism);

	// if ($agritourism) {
	// 	if ($productTypes) {
	// 		array_push($productTypes, "agritourism");
	// 	} else { $productTypes = array("agritourism"); }
	// }


	//Wholesaler Meta Query
	$wholesalerMetaQuery = ($wholesale) ?
		array(
			"key" => "is_wholesaler",
			"value" => "1",
			"compare" => "="
		) : false;

	$doublesnapMetaQuery = ($doublesnap) ?
        array(
            "key" => "is_doublesnap",
            "value" => "1",
            "compare" => "="
        ) : false;

	//Build Full Meta Query
	if ($wholesalerMetaQuery || $doublesnapMetaQuery || $pseudoLocationTypeMetaQuery) {
		$metaQuery = array("relation" => "AND");
		$pseudoMetaQuery = array("relation" => "AND");
		if ($wholesalerMetaQuery) {
			array_push($metaQuery, $wholesalerMetaQuery);
			array_push($pseudoMetaQuery, $wholesalerMetaQuery);
		}
		if ($doublesnapMetaQuery) {
            array_push($metaQuery, $doublesnapMetaQuery);
            array_push($pseudoMetaQuery, $doublesnapMetaQuery);
        }
		if ($pseudoLocationTypeMetaQuery) {
			array_push($pseudoMetaQuery, $pseudoLocationTypeMetaQuery);
		}
	}

	//Build Query Arguments
	$queryArguments = array(
		"role__in" => $locationTypes,
		"fields" => "ID"
	);
	$pseudoQueryArguments = array(
		"fields" => "ID"
	);
	if (is_array($metaQuery) && count($metaQuery) > 1) {
		$queryArguments["meta_query"] = $metaQuery;
	}
	if (is_array($pseudoLocationTypeMetaQuery) && count($pseudoLocationTypeMetaQuery) > 1) {
		$pseudoQueryArguments["meta_query"] = $pseudoLocationTypeMetaQuery;
	}

	$partners1 = array();
	$partners2 = array();

	if ($doMainQuery) {
		$partners1 = get_users($queryArguments);
	}
	if ($doPseudoQuery) {
		$partners2 = get_users($pseudoQueryArguments);
	}
	$partners = array_merge($partners1, $partners2);
	$partners = createMapPartners($partners, $zipBounds, $county, $productTypes, $specificProducts, $wholesale);
	$partners = array_unique($partners, SORT_REGULAR);
	$partners = addAdditionalLocations($partners, $zipBounds, $county);
	usort($partners, function($a, $b) {
	    return strnatcmp($a->name, $b->name);
	});

	$updatedSpecificProductsList = get_specific_products($productTypes, $wholesale);
	$updatedSpecificProductsList = array_values(array_unique($updatedSpecificProductsList, SORT_REGULAR));
	$fixedSpecificProductsList = array();
	foreach ($updatedSpecificProductsList as $updatedSpecificProduct) {
		$isActive = (is_array($specificProducts)) ? in_array($updatedSpecificProduct, $specificProducts) : false;
		$tempUpdatedSpecificProduct = new SpecificProduct($updatedSpecificProduct, $isActive);
		$fixedSpecificProductsList[] = $tempUpdatedSpecificProduct;
	}
	$updatedSpecificProductsList = $fixedSpecificProductsList;
	$fixedSpecificProductsList = null;

	$result = array("specific" => $updatedSpecificProductsList, "partners" => $partners);

	// echo "<pre>";
	// print_r($result);
	// echo "</pre>";

	$result = json_encode($result);
	echo $result;

 	die();
}

function addAdditionalLocations($partners, $zipBounds, $county) {
	$additionalLocations = [];
	if (is_array($partners)) {
		foreach ($partners as $partner) {

			$acf_id = "user_" . $partner->id;

			if (have_rows("additional_locations", $acf_id)) {
				while(have_rows("additional_locations", $acf_id)) {
					the_row();

					$tempObj = new MapPartner;
					$tempCity = get_sub_field("city");
					$tempCounty = get_sub_field("location_county");
					$tempMap = get_sub_field("location_map");


					$tempObj->lat = false;
					$tempObj->lng = false;

					if (!empty($tempMap) && is_array($tempMap)) {
						$tempObj->lat = $tempMap["lat"];
						$tempObj->lng = $tempMap["lng"];
					}
					$tempObj->name = $partner->name;
					$tempObj->id = $partner->id;
					$tempObj->url = $partner->url;
					$tempObj->city = $tempCity;
					$tempObj->county = $tempCounty;

					if (checkPartnerLocation($tempObj, $zipBounds, $county)) {
						array_push($additionalLocations, $tempObj);
					}

					$tempObj = null;
					$tempCity = null;
					$tempCounty = null;
					$tempMap = null;
				}
			}
		}
	}

	$partners = array_merge($partners, $additionalLocations);

	return $partners;
}