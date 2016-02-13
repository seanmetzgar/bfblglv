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

function buildProductsQuery($productTypes) {
	$metaQueryArray = false;
	
	if (is_array($productTypes) && count($productTypes) > 0) {
		$metaQueryArray = array(
			"relation" => "OR"
		);
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

function xhrGetPartners() {
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

	//These will be fun to search for if FARM is not checked...
	$isCSA = isset($_REQUEST["is_csa"]) && $_REQUEST["is_csa"] === "1" ? true : false;
	$isFarmShare = isset($_REQUEST["is_farm_share"]) && $_REQUEST["is_farm_share"] === "1" ? true : false;

   	$tempPartners = array();
   	$returnPartners = array();

   	if ($locationTypes === false) {
   		$locationTypes = ($productTypes) ? array("farm") : $allLocationTypes;
   	} else {
   		$productTypes = (in_array("farm", $locationTypes)) ? $productTypes : false;
   	}

	foreach ($locationTypes as $locationType) {
		$locationTypePartners = null;
		$locationTypeQueryArgs = array(
			"role" => $locationType
		);
		if ($locationType === "farm") {
			$productsQuery = buildProductsQuery($productTypes);
			if ($productsQuery) {
				$locationTypeQueryArgs["meta_query"] = $productsQuery;
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