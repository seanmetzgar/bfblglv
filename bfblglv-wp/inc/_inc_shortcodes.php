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
		usort($listItems, function($a, $b) {
		    return strnatcmp($a->name, $b->name);
		});
		$rVal = "<ul>";
		foreach ($listItems as $item) {
			$rVal .= "<li><a href=\"{$item->href}\" target=\"_blank\">{$item->name}";
			$rVal .= ($item->city) ? ", {$item->city}</a></li>" : "</a></li>";
		}
		$rVal .= "</ul>";
	}

	return $rVal;
}
add_shortcode( 'partners-list', 'shortcode_getPartners' );



add_action( 'profile_update', 'partner_last_updated_save', 10, 2 );
function partner_last_updated_save($user_id){
    update_user_meta( $user_id, 'user_last_updated', time() );
}

add_shortcode( 'partner-last-updated', 'partner_last_updated_shortcode');
function partner_last_updated_shortcode($atts = []) {
	// normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $value = str_replace("<br>", " - ", partner_last_updated_print($user_id = $atts["user_id"]));
	return $value;
}
function partner_last_updated_print($user_id = null){
    $user = ($user_id === null) ? wp_get_current_user() : get_user_by("ID", $user_id);
    $last_updated = get_user_meta($user->ID,  'user_last_updated', true );
    if ( $last_updated == '' ){
        $udata = get_userdata( $user->ID );
        $registered = $udata->user_registered;

        $last_updated = strtotime( $registered );
 
    }
    $last_updated = date( "F d, Y", $last_updated );
    return $last_updated;
}


function blglv_modify_user_table( $column ) {
    $column['user_last_updated'] = 'Last Updated';
    $column['partner_name'] = 'Partner Name';
    return $column;
}
add_filter( 'manage_users_columns', 'blglv_modify_user_table' );

function blglv_modify_user_sortable( $columns ) {
	$columns['partner_name'] = 'partner_name';
    $columns['user_last_updated'] = 'user_last_updated';
    return $columns;
}
add_filter( 'manage_users_sortable_columns', 'blglv_modify_user_sortable' );

function blglv_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'user_last_updated' :
            $val = partner_last_updated_print($user_id);
            break;
        case 'partner_name':
        	$val = get_field("partner_name", "user_{$user_id}");
        	if ($val == "") {
        		$user_info = get_userdata($user_id);
				$first_name = $user_info->first_name;
				$last_name = $user_info->last_name;
				$username = $user_info->user_login;
        		$val = "$first_name $last_name ($username)";
        	}
        	break;
        default:
        	$val = $val;
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'blglv_modify_user_table_row', 10, 3 );