<?php
function createMapPartners($partners, $zipBounds, $county, $productTypes, $specificProducts, $wholesale) {
	$mapPartners = array();
	$renewalYear = getRenewalYear();
	$renewalShutDownTime = getRenewalShutDown();
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
					$tempObj->name = strlen($tempName) > 0 ? $tempName : get_author_name($id);
					$tempMap = get_field("partner_map", $acf_id);

					if (!empty($tempMap)) {
						$tempObj->lat = $tempMap["lat"];
						$tempObj->lng = $tempMap["lng"];
					}

					$tempObj->url = get_author_posts_url($id);
					$tempObj->city = $tempCity;

					if (is_object($zipBounds) && !empty($tempMap)) {
						if ($tempMap["lat"] < $zipBounds->maxLat && $tempMap["lat"] > $zipBounds->minLat &&
							$tempMap["lng"] < $zipBounds->maxLng && $tempMap["lng"] > $zipBounds->minLng) {
							$mapPartners[] = $tempObj;
						}
					} elseif ($county) {
						if ($county == $tempCounty) {
							$mapPartners[] = $tempObj;
						}
					} else {
						$mapPartners[] = $tempObj;
					}

					//Reset temp variables
					$tempObj = null;
					$tempName = null;
					$tempCity = null;
					$tempMap = null;
					$tempDisabled = false;
				}
			}
		}
	}
	return $mapPartners;
}

function checkPartnerProducts($id, $productTypes, $specificProducts, $wholesale) {
	$rVal = false;

	if (!is_array($productTypes) || count($productTypes) == 0 && (is_array($specificProducts) && count($specificProducts) > 0)) {
		$productTypes = array(
			"greens", "roots", "seasonal",
			"melons", "herbs", "berries",
			"small_fruits", "grains", "value_added",
			"flowers", "plants", "ornamentals",
			"syrups", "dairy", "meat",
			"poultry", "agritourism", "fibers",
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
		}
	} else { $rVal = true; }

	return $rVal;
}

function addPseudoLocationTypeData($locationTypes, $csa, $farmShare, $agritourism, $farmToTable) {
	$rVal = $locationTypes;
	if (!is_array($rVal)) { $rVal = array(); }
	if ($csa || $farmShare || $agritourism || $farmToTable) {
		if ($agritourism) {
			array_push($rVal, "distillery", "vineyard", "specialty");
		}
		if ($farmToTable) {
			array_push($rVal, "restaurant");
		}
		if ($csa || $farmShare || $agritourism) {
			array_push($rVal, "farm");
		}
	}
	return array_unique($rVal, SORT_REGULAR);
}

function getPseudoLocationTypeMetaQuery($csa, $farmShare, $agritourism, $farmToTable) {
	$rVal = false;
	if ($csa || $farmShare || $agritourism || $farmToTable) {
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
		if ($farmToTable) {
			array_push($rVal,
				array(
					"key" => "is_farm_to_table",
					"value" => 1,
					"compare" => "="
				)
			);
		}
	}
	return $rVal;
}

function newGetPartners() {
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
	$wholesale = 		(isset($_REQUEST["wholesale"]) &&
						($_REQUEST["wholesale"] == "true" ||
						$_REQUEST["wholesale"] == "1"))
							? true : false;
	$csa = 				(isset($_REQUEST["csa"]) &&
						($_REQUEST["csa"] == "true" ||
						$_REQUEST["csa"] == "1"))
							? true : false;
	$farmShare = 		(isset($_REQUEST["farm-share"]) &&
						($_REQUEST["farm-share"] == "true" ||
						$_REQUEST["farm-share"] == "1"))
							? true : false;
	$agritourism = 		(isset($_REQUEST["agritourism"]) &&
						($_REQUEST["agritourism"] == "true" ||
						$_REQUEST["agritourism"] == "1"))
							? true : false;
	$farmToTable = 		(isset($_REQUEST["farm-to-table"]) &&
						($_REQUEST["farm-to-table"] == "true" ||
						$_REQUEST["farm-to-table"] == "1"))
							? true : false;

	//Add Pseudo Location Types & Meta Query
	$locationTypes = addPseudoLocationTypeData($locationTypes, $csa, $farmShare, $agritourism, $farmToTable);
	$locationTypes = (is_array($locationTypes) && count($locationTypes) > 0) ? $locationTypes : $allLocationTypes;
	$pseudoLocationTypeMetaQuery = getPseudoLocationTypeMetaQuery($csa, $farmShare, $agritourism, $farmToTable);
	if ($agritourism) {
		if ($productTypes) {
			array_push($productTypes, "agritourism");
		} else { $productTypes = array("agritourism"); }
	}

	//Wholesaler Meta Query
	$wholesalerMetaQuery = ($wholesale) ?
		array(
			"key" => "is_wholesaler",
			"value" => "1",
			"compare" => "="
		) : false;

	//Build Full Meta Query
	if ($wholesalerMetaQuery || $pseudoLocationTypeMetaQuery) {
		$metaQuery = array("relation" => "AND");
		if ($wholesalerMetaQuery) {
			array_push($metaQuery, $wholesalerMetaQuery);
		}
		if ($pseudoLocationTypeMetaQuery) {
			array_push($metaQuery, $pseudoLocationTypeMetaQuery);
		}
	}

	//Build Query Arguments
	$queryArguments = array(
		"role__in" => $locationTypes,
		"fields" => "ID"
	);
	if (is_array($metaQuery) && count($metaQuery) > 1) {
		$queryArguments["meta_query"] = $metaQuery;
	}

	$partners = get_users($queryArguments);
	$partners = createMapPartners($partners, $zipBounds, $county, $productTypes, $specificProducts, $wholesale);

	$result = array("p" => $partners);

	echo "<pre>";
	print_r($result);
	echo "</pre>";
	// $result = json_encode($result);

	// header('Content-Type: application/json');
	// echo $result;

 	// die();

}