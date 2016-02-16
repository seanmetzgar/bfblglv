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
	if (is_numeric($partner->member_since) && (int)$partner->member_since == $partner->member_since) {
		$member_since = date("Y-m-d H:i:s", (int)$partner->member_since);
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

	//Insert User
	$new_user_args = array(
		"role" => $category,
		"user_login" => $username,
		"user_nice" => $slug,
		"user_pass" => "password",
		"display_name" => $partner->partner_name,
		"user_email" => "sean.metzgar+{$slug}@gmail.com",
		"user_registered" => $member_since
	);
	//$user_id = wp_insert_user($new_user_args);

	echo "<pre>";
	echo "New User Args:\n";
	print_r($new_user_args);
	echo "</pre>";

   	die();
}