<?php
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