<?php
/** Helpers **/
function tastelv_custom_pings($comment) {
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

function indent($tabs, $space = 0, $echo = false) {
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

function get_image_id($image_url) {
    global $wpdb;
    $rVal = false;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    if (is_array($attachment)) {
        $rVal = $attachment[0];
    }
    return $rVal;
}

function page_headline($page_headline, $page_icon, $page_headline_tag = "h1", $sponsor = false, $location = false, $echo = false) {
    $page_headline_html = "";
    $page_headline_class = "entry-title";
    $echo = (is_bool($echo)) ? $echo : false;
    $sponsor = (is_string($sponsor) && strlen($sponsor) > 0) ? $sponsor : false;
    $location = (is_string($location) && strlen($location) > 0) ? $location : false;
    $page_headline_tag = (is_string($page_headline_tag) && strlen($page_headline_tag) > 0) ? $page_headline_tag : "h1";

    if (is_front_page()) {
        $page_headline_tag = "h2";
        $page_headline_class .= " pseudo-h1";
    } elseif ($page_headline_tag !== "h1") {
        $page_headline_class .= " pseudo-h1";
    }

    if (is_string($page_icon) && strlen($page_icon) > 0) {
        $page_headline_html .= "<figure class=\"page-icon\"><img src=\"{$page_icon}\" class=\"img-responsive\" alt=\"" . the_title_attribute(array("echo" => false)) . "\"></figure>";
    }
    if ($sponsor) {
        $page_headline_html .= $sponsor;
    }
    if ($location) {
        $page_headline_html .= "<p class=\"meta\">$location</p>";
    }
    if (is_string($page_headline) && strlen($page_headline) > 0) {
        $page_headline_html .= "<{$page_headline_tag} class=\"{$page_headline_class}\">{$page_headline}</{$page_headline_tag}>";
    }

    if ($echo) {
        echo $page_headline_html;
    } else {
        return $page_headline_html;
    }
}

function page_meta($post_id, $post_type) {
    $echo = (is_bool($echo)) ? $echo : false;
    $meta_string = "";
    if ($post_type === "play" || $post_type === "explore") {
        $event_location = get_field("event_location", $post_id);
        $event_start_time = get_field("event_start_time", $post_id);
        $event_end_time = get_field("event_end_time", $post_id);
        $event_website = get_field("event_website", $post_id);

        $meta_string .= ($event_location) ? $event_location : "";
        $meta_string .= ($event_start_time && $meta_string) ? "<br>" : "";
        $meta_string .= ($event_start_time) ? $event_start_time : "";
        $meta_string .= ($event_start_time && $event_end_time) ? " - {$event_end_time}" : "";
        $meta_string .= ($meta_string && $event_website) ? "<br>" : "";
        $meta_string .= ($event_website) ? "<a href=\"{$event_website}\" target=\"_blank\">{$event_website}</a>" : "";
    }

    $meta_string = ($meta_string) ? "<p class=\"meta\">$meta_string</p>" : "";
    if ($echo) {
        echo $meta_string;
    } else {
        return $meta_string;
    }
}

function sponsored_by($sponsors, $pre = "Presented By", $echo = false) {
    $echo = (is_bool($echo)) ? $echo : false;
    $pre = (is_string($pre) && strlen($pre) > 0) ? $pre :  false;
    $sponsor_image = "";

    if (is_int($sponsors)) $sponsors = array($sponsors);
    $tempOutput = "";
    $output = "";
    if (is_array($sponsors)) {
        foreach ($sponsors as $sponsor_id) {
            $sponsor_link = "";
            $sponsor_image = "";

            if (has_post_thumbnail($sponsor_id)) {
                $sponsor_image = wp_get_attachment_image_url(get_post_thumbnail_id($sponsor_id), "medium");
            }

            $sponsor_link = get_field("link_url", $sponsor_id);

            if ($sponsor_link) {
                $sponsor_link = "href=\"{$sponsor_link}\" target=\"_blank\"";
            } else {
                $sponsor_link = "href=\"javascript:void();\"";
            }

            if ($sponsor_image) {

                    $tempOutput .= "<a {$sponsor_link}>";
                        $tempOutput .= "<figure class=\"image\"><img class=\"img-responsive\" src=\"{$sponsor_image}\"></figure>";
                    $tempOutput .= "</a>";

            }
        }
    }

    if (strlen($tempOutput) > 0) {
        $output .= "<div class=\"sp-by\">";
            if ($pre) $output .= "<p>{$pre}</p>";
            else $output .= "<p class=\"visuallyhidden\">Presented By</p>";
            $output .= $tempOutput;
        $output .= "</div>";
    }

    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

function sponsors_block($sponsor_type, $media_sponsors = false, $echo = true) {
    $media_sponsors = (is_bool($media_sponsors)) ? $media_sponsors : false;
    $echo = (is_bool($echo)) ? $echo : true;
    $media_sponsors_compare = ($media_sponsors) ? "=" : "!=";
    $rVal = "";
    $query = new WP_Query(array (
        "post_type"         => array( "sponsors" ),
        "sponsor_type"      => $sponsor_type,
        "meta_query"        => array(
            array(
                'key'           => 'media_sponsor',
                'value'         => 1,
                'compare'       => $media_sponsors_compare,
                'type'          => 'NUMERIC'
            ),
        ),
        "orderby"           => "menu_order",
        "order"             => "ASC"
    ));

    if ($query->have_posts()):
        $sponsor_tax_obj = get_term_by("slug", $sponsor_type, "sponsor_type");
        $sponsor_tax_name = (is_object($sponsor_tax_obj)) ? $sponsor_tax_obj->name : ucwords(str_replace("-", " ", $sponsor_type));

        $rVal .= "<div class=\"sp-blocks-row {$sponsor_type}\">";
            $rVal .= "<h3>$sponsor_tax_name</h3>";
        while ($query->have_posts()):
            $query->the_post();
            ob_start();
            get_template_part( "entry-archive", "sponsors" );
            $rVal .= ob_get_contents();
            ob_end_clean();
        endwhile;
        $rVal .= "</div>";
    endif;
    wp_reset_postdata();

    if ($echo) {
        echo $rVal;
    } else { return $rVal; }
}