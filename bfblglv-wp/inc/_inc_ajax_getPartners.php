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

	$pseudoLocationTypeMetaQuery = false;
	$wholesalerMetaQuery = false;

	if ($zip) {
		$zipBounds = getZipBounds($zip);
		$hasZipBounds = (is_object($zipBounds)) ? true : false;
	} else {
		$county = (isset($_REQUEST["county"])) ? "".$_REQUEST["county"] : false;
	}

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
			"value" => 1,
			"compare" => "="
		) : false;
	$metaQuery = array("relation" => "AND");
	if ($wholesalerMetaQuery) {
		array_push($metaQuery, $wholesalerMetaQuery);
	}
	if ($pseudoLocationTypeMetaQuery) {
		array_push($metaQuery, $pseudoLocationTypeMetaQuery);
	}
	$queryArguments = array(
		"role__in" => $locationTypes;
		"meta_query" => $metaQuery;
	);

	$result = json_encode($queryArguments);

	header('Content-Type: application/json');
	echo $result;

   	die();
}



function old_xhrGetPartners() {
	set_time_limit ( 65 );
	$renewalYear = getRenewalYear();
	$renewalShutDownTime = getRenewalShutDown();
	$renewalGrandfatheredTime = getRenewalGrandfathered();

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
		"baked", "seeds", "pyo", "misc"
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

	$specificProducts = (isset($_REQUEST["specific_products"])) ?
		(is_array($_REQUEST["specific_products"]) && count($_REQUEST["specific_products"]) > 0) ?
			$_REQUEST["specific_products"] :
			(is_string($_REQUEST["specific_products"]))
		(isset($_REQUEST["specific_products"]) &&
	 	is_array($_REQUEST["specific_products"]) &&
		count($_REQUEST["specific_products"]) > 0) ?
			$_REQUEST["specific_products"] :
				(isset($_REQUEST["specific_products"]) &&
				is_string($_REQUEST["specific_products"]) &&
				strlen($_REQUEST["specific_products"]) > 0) ?
					array($_REQUEST["specific_products"]) : false;

	$wholesale = (isset($_REQUEST["wholesale"]) && ($_REQUEST["wholesale"] == "true" || $_REQUEST["wholesale"] == "1")) ? true : false;
	$updatedSpecificProductsList = get_specific_products($productTypes, $wholesale);

   	$tempPartners = array();
   	$returnPartners = array();

   	if ($locationTypes === false) {
   		$locationTypes = ($productTypes || $pseudoFarmSearch) ?
   			array("farm") :
   			(!$productTypes && $specificProducts) ?
   				array("farm") : $allLocationTypes;
   	} else {
        //Clear $productTypes if not a farm search
   		$productTypes = (in_array("farm", $locationTypes)) ? $productTypes : false;
   	}

	foreach ($locationTypes as $locationType) {
		if (in_array($locationType, array("farm-share", "csa"))) {
            $locationTypePartners = null;
            $pseudoLocationType = "is_" . str_replace("-", "_", $locationType);

            if ($locationType == "csa") {
            	$locationTypeQueryArgs = array(
	                "role" => "farm",
	                "meta_query" => array(
	                    "relation" => "AND",
	                    array(
	                    	"relation" => "OR",
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
	                    )
	                )
	            );
            } else {
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
            }

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

        if ($locationType === "farm" && !$productTypes && $specificProducts) { continue; }

		$locationTypePartners = get_users($locationTypeQueryArgs);

		if (is_array($locationTypePartners) && count($locationTypePartners) > 0) {
			$tempPartners = array_merge($locationTypePartners, $tempPartners);
		}
	}

	if (is_array($specificProducts) && count($specificProducts) > 0) {
		$specificProductsTempPartners =get_users(array("role" => "farm"));
		$specificProductsPartners = array();

		if (is_array($specificProductsTempPartners) && count($specificProductsTempPartners) > 0) {
			foreach($specificProductsTempPartners as $specificProductsPartner) {
				$addThisPartner = false;
				foreach ($specificProducts as $specificProduct) {
					if (has_specific_product($specificProductsPartner->ID, $specificProduct, $wholesale)) {
						$addThisPartner = true;
					}
				}
				if ($addThisPartner) {
					$specificProductsPartners[] = $specificProductsPartner;
				}
			}
		}

		if (count($specificProductsPartners) > 0) {
			// $tempPartners = array_merge($specificProductsPartners, $tempPartners);
			// $tempPartners = array_intersect($specificProductsPartners, $tempPartners);
			$tempPartners =  array_uintersect($specificProductsPartners, $tempPartners, function($obj1, $obj2){
			  	$md5 = function($obj){
			    	return md5(serialize($obj));
			  	};
			  	return strcmp($md5($obj1), $md5($obj2));
			});
		}
	}

	foreach ($tempPartners as $partnerKey=>$partner) {
		$tempRenewedUntil = get_field("partner_renewed_until", "user_{$partner->ID}");
		$tempRenewedDate = get_field("partner_renewed_date", "user_{$partner->ID}");
		$tempRenewedDate = strtotime($tempRenewedDate);

		// if ($tempRenewedDate < $renewalGrandfatheredTime) {
		// 	$tempRenewedUntil = $renewalYear - 1;
		// 	update_field("partner_renewed_until", $tempRenewedUntil, "user_{$partner->ID}");
		// 	update_user_meta($partner->ID, "ja_disable_user", 1 );
		// }
		if (is_numeric($tempRenewedUntil)) {
			if (($tempRenewedUntil < $renewalYear) && (time() >= $renewalShutDownTime)) {
				update_user_meta($partner->ID, "ja_disable_user", 1 );
			}
		}

		$tempDisabled = get_user_meta( $partner->ID, "ja_disable_user", true );

		if (!$tempDisabled) {
			$tempObj = new MapPartner;
			$tempObj->id = $partner->ID;
			$tempName = get_field("partner_name", "user_{$partner->ID}");
			$tempCity = get_field("partner_city", "user_{$partner->ID}");
			$tempCounty = get_field("partner_county", "user_{$partner->ID}");
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
			} elseif ($county) {
				if ($county == $tempCounty) {
					$tempObj->inbounds = true;
					$returnPartners[] = $tempObj;
				}
			} else {
				$returnPartners[] = $tempObj;
			}
		}

		$tempObj = null;
		$tempName = null;
		$tempCity = null;
		$tempMap = null;
		$tempDisabled = false;
	}

	$returnPartners = array_unique($returnPartners, SORT_REGULAR);

	usort($returnPartners, function($a, $b) {
	    return strnatcmp($a->name, $b->name);
	});

	$updatedSpecificProductsList = array_values(array_unique($updatedSpecificProductsList, SORT_REGULAR));
	$fixedSpecificProductsList = array();
	foreach ($updatedSpecificProductsList as $updatedSpecificProduct) {
		$isActive = (is_array($specificProducts)) ? in_array($updatedSpecificProduct, $specificProducts) : false;
		$tempUpdatedSpecificProduct = new SpecificProduct($updatedSpecificProduct, $isActive);
		$fixedSpecificProductsList[] = $tempUpdatedSpecificProduct;
	}
	$updatedSpecificProductsList = $fixedSpecificProductsList;
	$fixedSpecificProductsList = null;

	$result = array("specific" => $updatedSpecificProductsList, "partners" => $returnPartners);
	$result = json_encode($result);

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