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

	$locationTypes = (isset($_POST["location_type"])
		&& is_array($_POST["location_type"])
		&& count($_POST["location_type"] > 0)) ? 
			$_POST["location_type"] : 
			$allLocationTypes;

	$productTypes = (isset($_POST["product_type"])
		&& is_array($_POST["product_type"])
		&& count($_POST["product_type"] > 0)) ? 
			$_POST["product_type"] : 
			$allLocationTypes;

	//These will be fun to search for if FARM is not checked...
	$isCSA = isset($_POST["is_csa"]) && $_POST["is_csa"] === "1" ? true : false;
	$isFarmShare = isset($_POST["is_farm_share"]) && $_POST["is_farm_share"] === "1" ? true : false;

   	$tempPartners = array();
   	$returnPartners = array();

	$tempPartners = get_users(array(
		"role" => "farm",
		"meta_query" => array(
			"key" => "products_greens",
			"value" => "Arugula",
			"compare" => "IN"
		)
	));
	// $fmPartners = get_users(array(
	// 	"role" => "farmers-market"
	// ));
	// $restaurantPartners = get_users(array(
	// 	"role" => "restaurant"
	// ));
	// $vineyardPartners = get_users(array(
	// 	"role" => "vineyard"
	// ));
	// $distilleryPartners = get_users(array(
	// 	"role" => "distillery"
	// ));
	// $institutionPartners = get_users(array(
	// 	"role" => "institution"
	// ));
	// $distributorPartners = get_users(array(
	// 	"role" => "distributor"
	// ));
	// $specialtyPartners = get_users(array(
	// 	"role" => "specialty"
	// ));
	// $retailPartners = get_users(array(
	// 	"role" => "retail"
	// ));

	//$tempPartners = array_merge($farmPartners, $fmPartners, $restaurantPartners, $vineyardPartners, $distilleryPartners, $institutionPartners, $distributorPartners, $specialtyPartners, $retailPartners);
	
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