<?php
class SimplePartner {
	public $name = false;
	public $href = false;
	public $city = false;
}
function shortcode_getPartners( $atts ) {
    $a = shortcode_atts( array(
        "category" => ""
    ), $atts );

    $allLocationTypes = array(
		"farm", "farmers-market",
		"restaurant", "vineyard",
		"distillery", "institution",
		"distributor", "specialty",
		"retail"
	);
    $category = $a["category"];

    $locationTypeQueryArgs = false;
	if (in_array($category, $allLocationTypes)) {
		$locationTypeQueryArgs = array(
            "role" => $category
        );
	} elseif ($category === "csa") {
		$locationTypeQueryArgs = array(
            "role" => "farm",
            "meta_query" => array(
                "relation" => "AND",
                array(
                    "key" => "is_csa",
                    "value" => 1,
                    "compare" => "="
                )
            )
        );
	} elseif ($category === "farm-share") {
		$locationTypeQueryArgs = array(
            "role" => "farm",
            "meta_query" => array(
                "relation" => "AND",
                array(
                    "key" => "is_farm_share",
                    "value" => 1,
                    "compare" => "="
                )
            )
        );
	}

	$listItems = array();

	if ($locationTypeQueryArgs !== false) {
		$locationQuery = get_users($locationTypeQueryArgs);

		if (is_array($locationQuery) && count($locationQuery) > 0) {
			foreach ($locationQuery as $location) {
				$locationID = $location->ID;
				$locationName = get_field("partner_name", "user_{$locationID}");
				$locationCity = get_field("partner_city", "user_{$locationID}");
				$locationName = strlen($locationName) > 0 ? $locationName : $location->display_name;
				$locationHref = get_author_posts_url($location->ID);

				if ($locationName && $locationHref) {
					$locationObj = new SimplePartner;
					$locationObj->name = $locationName;
					$locationObj->href = $locationHref;
					$locationObj->city = ($locationCity) ? $locationCity : false;
					$listItems[] = $locationObj;
				}
				$locationObj = false;
				$locationName = false;
				$locationCity = false;
				$locationHref = false;
			}
		}
	}

	$rVal = "";
	if (count($listItems) > 0) {
		$rVal = "<ul>";
		foreach ($listItems as $item) {
			$rVal .= "<li><a href=\"{$item->href}\">{$item->name}";
			$rVal .= ($item->city) ? ", {$item->city}</a></li>" : "</a></li>";
		}
		$rVal .= "</ul>";
	}

	return $rVal;
}
add_shortcode( 'partners-list', 'shortcode_getPartners' );