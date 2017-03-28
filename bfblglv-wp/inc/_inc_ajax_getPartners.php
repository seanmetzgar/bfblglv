<?php
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
	$renewalYear = getRenewalYear();
	$renewalShutDownTime = getRenewalShutDown();
	$renewalGrandfatheredTime = getRenewalGrandfathered();

	//Setup Location Boundry Variables
	$zip = (isset($_REQUEST["zip"])) ? "".$_REQUEST["zip"] : false;
	$zip = ($zip && strlen($zip) >= 5) ? substr($zip, 0, 5) : false;
	$hasZipBounds = false;
	$county = false;

	if ($zip) {
		$zipBounds = getZipBounds($zip);
		$hasZipBounds = (is_object($zipBounds)) ? true : false;
	} else {
		$county = (isset($_REQUEST["county"])) ? "".$_REQUEST["county"] : false;
	}

	//Defaults
	$pseudoLocationTypeMetaQuery = false;
	$wholesalerMetaQuery = false;
	$metaQuery = array(
		"relation" => "AND",
		array(
			"key" => "ja_disable_user",
			"value" => "1",
			"compare" => "!="
		)
	);

	//Default Location Types
	$allLocationTypes = array(
		"farm", "farmers-market",
		"restaurant", "vineyard",
		"distillery", "institution",
		"distributor", "specialty",
		"retail"
	);

	//Default Product Types
	$allProductTypes = array(
		"greens", "roots", "seasonal",
		"melons", "herbs", "berries",
		"small_fruits", "grains", "value_added",
		"flowers", "plants", "ornamentals",
		"syrups", "dairy", "meat",
		"poultry", "agritourism", "fibers",
		"artisinal", "liquids", "educational",
		"baked", "seeds", "pyo", "misc"
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

	//Wholesaler Meta Query
	$wholesalerMetaQuery = ($wholesale) ?
		array(
			"key" => "is_wholesaler",
			"value" => "1",
			"compare" => "="
		) : false;

	//Build Full Meta Query
	if ($wholesalerMetaQuery || $pseudoLocationTypeMetaQuery) {
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
		array_push($queryArguments, $metaQuery);
	}

	$partners = get_users($queryArguments);
	$result = array("q" => $queryArguments, "p" => $partners);
	$result = json_encode($result);

	header('Content-Type: application/json');
	echo $result;

   	die();
}