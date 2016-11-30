<?php
ini_set("display_errors", 1);
/** Helpers **/
function niceCategoryName($slug) {
    switch($slug) {
        case "farmers-market":
            $rVal = "Producer-Only Farmers' Market";
            break;
        case "retail":
            $rVal = "Retail Operations";
            break;
        case "specialty":
            $rVal = "Specialty Products";
            break;
        default:
            $rVal = ucwords($slug);
    }
    return $rVal;
}

function niceProductTypeName($type) {
    if (is_string($type)) {
        switch($type) {
            case "greens":
                $rVal = "Greens";
                break;
            case "roots":
                $rVal = "Root Crops";
                break;
            case "seasonal":
                $rVal = "Seasonal Vegetables";
                break;
            case "melons":
                $rVal = "Melons & Pumpkins";
                break;
            case "herbs":
                $rVal = "Herbs";
                break;
            case "berries":
                $rVal = "Berries";
                break;
            case "small_fruits":
                $rVal = "Orchard & Small Fruits";
                break;
            case "grains":
                $rVal = "Grains";
                break;
            case "value_added":
                $rVal = "Value-Added";
                break;
            case "flowers":
                $rVal = "Flowers";
                break;
            case "plants":
                $rVal = "Plants";
                break;
            case "ornamentals":
                $rVal = "Ornamentals";
                break;
            case "syrups":
                $rVal = "Honey / Syrups";
                break;
            case "dairy":
                $rVal = "Dairy";
                break;
            case "meat":
                $rVal = "Meat";
                break;
            case "poultry":
                $rVal = "Poultry";
                break;
            case "agritourism":
                $rVal = "Agritourism";
                break;
            case "fibers":
                $rVal = "Wool / Fibers";
                break;
            case "artisinal":
                $rVal = "Artisanal Products";
                break;
            case "liquids":
                $rVal = "Beverages";
                break;
            case "educational":
                $rVal = "Educational Programs";
                break;
            case "baked":
                $rVal = "Baked Goods";
                break;
            case "seeds":
                $rVal = "Nuts / Seeds";
                break;
            case "pyo":
                $rVal = "Pick Your Own";
                break;
            case "misc":
                $rVal = "Miscellaneous [e.g. Eggs]";
                break;
            default:
                $rVal = $type;
        }
    } else {
        $rVal = "";
    }
    return $rVal;
}

function kudu_custom_pings($comment) {
    $GLOBALS["comment"] = $comment;
    $comment_class = comment_class("", null, null, false);
    $comment_ID = get_comment_ID();
    $comment_author_link = comment_author_link();
    $rVal = "<li $comment_class id=\"li-comment-$comment_ID\">$comment_author_link</li>";
    return $rVal;
}

function get_relative_file_path($file) {
    $file = (strlen($file) > 0) ? $file : false;
    $output = false;
    if ($file) {
        $file = parse_url($file);
        $output = (strlen($file["path"]) > 0) ? $file["path"] : false;
    }
    return $output;
}

function relative_template_path($echo = false) {
    $echo = (is_bool($echo)) ? $echo : false;
    $tempPath = parse_url(get_bloginfo("template_url"));
    $path = $tempPath["path"];
    if(substr($path, -1) == "/") {
        $path = substr($path, 0, -1);
    }
    if ($echo) {
        echo $path;
    } else {
        return $path;
    }
}

function home_path($trailingSlash = false) {
    $path = ABSPATH;
    if (file_exists(ABSPATH . "wp-config.php")) {
        if (site_url() === home_url()) {
            $path = ABSPATH;
        } else {
            $path = dirname(ABSPATH);
        }
    }

    if ($trailingSlash) {
        $path = trailingslashit($path);
    } else { $path = untrailingslashit($path); }

    return $path;
}

function home_link($echo = false) {
    $echo = (is_bool($echo)) ? $echo : false;
    $returnValue = get_option("home");
    if ($echo) {
        echo $returnValue;
    } else {
        return $returnValue;
    }
}

function indent($tabs, $spaces = 0, $echo = false) {
    $echo = (is_bool($echo)) ? $echo : false;
    $spaces = (is_int($spaces) && $spaces > 0) ? $spaces : false;
    $indent_level = (is_int($tabs)) ? $tabs : 0;
    $indent = "";

    if ($spaces !== false) {
        $indent_chars = "";
        for ($space_count = 1; $space_count <= $spaces; $space_count++) {
            $indent_chars .= " ";
        }
    } else {
        $indent_chars = "\t";
    }

    for ($indent_count = 1; $indent_count <= $indent_level; $indent_count++) {
        $indent .= $indent_chars;
    }

    if ($echo) {
        echo $indent;
    } else { return $indent; }
}

function get_active_counties() {
    $locationTypes = array(
        "farm", "farmers-market",
        "restaurant", "vineyard",
        "distillery", "institution",
        "distributor", "specialty",
        "retail"
    );
    $allPartners = array();
    $counties = array();
    foreach ($locationTypes as $locationType) {
        $locationTypePartners = null;
        $locationTypeQueryArgs = array(
            "role" => $locationType
        );
        $locationTypePartners = get_users($locationTypeQueryArgs);
        if (is_array($locationTypePartners) && count($locationTypePartners) > 0) {
            $allPartners = array_merge($locationTypePartners, $allPartners);
        }
    }

    foreach ($allPartners as $partner) {
        $partner_id = $partner->ID;
        $acfID = "user_{$partner_id}";

        $county = get_field("partner_county", $acfID);
        if ($county) $counties[] = $county;
    }

    $counties = array_unique($counties);
    usort($counties, function($a, $b) {
        return strnatcmp($a, $b);
    });
    if (count($counties) === 0) $counties = false;
    return $counties;
}

function get_specific_products($productTypes = array()) {
    if (!is_array($productTypes) || (is_array($productTypes) && count($productTypes) === 0)) {
        //Set Defaults if productTypes not set
        $productTypes = array(
            "products_greens",
            "products_roots",
            "products_seasonal",
            "products_melons",
            "products_herbs",
            "products_berries",
            "products_small_fruits",
            "products_grains",
            "products_value_added",
            "products_flowers",
            "products_plants",
            "products_ornamentals",
            "products_syrups",
            "products_dairy",
            "products_meat",
            "products_poultry",
            "products_agritourism",
            "products_fibers",
            "products_artisinal",
            "products_liquids",
            "products_educational",
            "products_baked",
            "products_seeds",
            "products_misc",
            "products_pyo",
            "ws_products_greens",
            "ws_products_roots",
            "ws_products_seasonal",
            "ws_products_melons",
            "ws_products_herbs",
            "ws_products_berries",
            "ws_products_small_fruits",
            "ws_products_grains",
            "ws_products_value_added",
            "ws_products_flowers",
            "ws_products_plants",
            "ws_products_ornamentals",
            "ws_products_syrups",
            "ws_products_dairy",
            "ws_products_meat",
            "ws_products_poultry",
            "ws_products_agritourism",
            "ws_products_fibers",
            "ws_products_artisinal",
            "ws_products_liquids",
            "ws_products_educational",
            "ws_products_baked",
            "ws_products_seeds",
            "ws_products_misc",
            "ws_products_pyo"
        );
    }

    $productsArray = array();

    $productPartners = get_users(array(
        "role" => "farm"
    ));

    foreach ($productPartners as $partner) {
        $partner_id = $partner->ID;
        $acfID = "user_{$partner_id}";

        foreach ($productTypes as $productType) {
            $tempProducts = get_field($productType, $acfID);
            $tempProducts = (is_string($tempProducts) && strlen($tempProducts) > 0) ?
                array($tempProducts) :
                (is_array($tempProducts) && count($tempProducts) > 0) ? $tempProducts : false;
            if (is_array($tempProducts)) {
                foreach (array_keys($tempProducts, 'Other') as $key) {
                    unset($tempProducts[$key]);
                }
                $productsArray = array_merge($tempProducts, $productsArray);
            }
        }
    }

    $productsArray = array_unique($productsArray);

    return $productsArray;
}

function has_specific_product($partner_id, $product, $wholesale = false) {
    $rVal = false;
    if (is_string($partner_id) && strpos($partner_id, "user_") !== false) {
        $acf_id = $partner_id;
    } else {
        $acf_id = "user_{$partner_id}";
    }
    $productTypes = array(
        "products_greens",
        "products_roots",
        "products_seasonal",
        "products_melons",
        "products_herbs",
        "products_berries",
        "products_small_fruits",
        "products_grains",
        "products_value_added",
        "products_flowers",
        "products_plants",
        "products_ornamentals",
        "products_syrups",
        "products_dairy",
        "products_meat",
        "products_poultry",
        "products_agritourism",
        "products_fibers",
        "products_artisinal",
        "products_liquids",
        "products_educational",
        "products_baked",
        "products_seeds",
        "products_misc"
    );
    $productTypePrefix = ($wholesale === true) ? "ws_" : "";
    if (is_string($product) && strlen($product) > 0) {
        foreach ($productTypes as $productType) {
            $tempProducts = get_field(($productTypePrefix.$productType), $acf_id);
            $tempProducts = (is_string($tempProducts) && strlen($tempProducts) > 0) ?
                array($tempProducts) :
                (is_array($tempProducts) && count($tempProducts) > 0) ? $tempProducts : false;
            if (is_array($tempProducts)) {
                if (array_search($product, $tempProducts) !== false) $rVal = true;
            }
        }
    } else {
        $rVal = false;
    }

    return $rVal;
}

function isHiddenVendor($vendor) {
    $rVal = false;
    if (is_array($vendor)) {
        $vendor_data = get_userdata($vendor['ID']);
        $vendor_roles = $vendor_data->roles;
        if (in_array("hidden-vendor", $vendor_roles)) { $rVal = true; }
    }
    return $rVal;
}