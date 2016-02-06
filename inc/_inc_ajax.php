<?php
class MapPartner {
	public $id = false;
	public $name = false;
	public $url = false;
	public $lat = false;
	public $lng = false;
}

add_action("wp_ajax_xhrGetPartners", "xhrGetPartners");

function xhrGetPartners() {
   	$tempPartners = array();
   	$returnPartners = array();
	$farmPartners = get_users(array(
		"role" => "farm"
	));
	$fmPartners = get_users(array(
		"role" => "farmers-market"
	));
	$restaurantPartners = get_users(array(
		"role" => "restaurant"
	));
	$vineyardPartners = get_users(array(
		"role" => "vineyard"
	));
	$distilleryPartners = get_users(array(
		"role" => "distillery"
	));
	$institutionPartners = get_users(array(
		"role" => "institution"
	));
	$distributorPartners = get_users(array(
		"role" => "distributor"
	));
	$specialtyPartners = get_users(array(
		"role" => "specialty"
	));
	$retailPartners = get_users(array(
		"role" => "retail"
	));
	$tempPartners = array_merge($farmPartners, $fmPartners, $restaurantPartners, $vineyardPartners, $distilleryPartners, $institutionPartners, $distributorPartners, $specialtyPartners, $retailPartners);
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

	header('Content-Type: application/json');
    	echo "hello";
    	

   	die();
}