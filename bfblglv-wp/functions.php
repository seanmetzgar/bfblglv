<?php
require_once(dirname(__FILE__) . "/inc/_inc_uuid.php");
require_once(dirname(__FILE__) . "/inc/_inc_helpers.php");
require_once(dirname(__FILE__) . "/inc/_inc_customizations.php");
require_once(dirname(__FILE__) . "/inc/_inc_ajax.php");
require_once(dirname(__FILE__) . "/inc/_inc_ajax_getPartners.php");
require_once(dirname(__FILE__) . "/inc/_inc_shortcodes.php");

global $bfbl_custom_roles;
$bfbl_custom_roles = array(
	'farm',
	'distributor',
	'distillery',
	'farmers-market',
	'institution',
	'restaurant',
	'retail',
	'specialty',
	'vineyard',
);

add_action("after_setup_theme", "kudu_setup");
function kudu_setup() {
	load_theme_textdomain("kudu", get_template_directory() . "/languages");

	$custom_header_args = array(
        "flex-width"        => true,
        "width"             => 1280,
        "flex-height"       => true,
        "height"            => 628,
        "default-image"     => get_template_directory_uri() . "/images/header/home_header.jpg",
        "uploads"           => true,
        "header-text"       => false
    );
    add_theme_support("automatic-feed-links");
    add_theme_support("post-thumbnails");
    add_theme_support("html5");
    add_theme_support("custom-header", $custom_header_args );

	global $content_width;
	if (!isset($content_width)) $content_width = 640;

	register_nav_menus(array(
		"main-menu" => 			__("Main Menu", "kudu")
	));
	register_nav_menus(array(
		"footer-menu" => 		__("Footer Menu", "kudu")
	));

    add_image_size( "tiny", 100, 500 );
}

add_action("wp_enqueue_scripts", "kudu_load_scripts");
function kudu_load_scripts() {
	$template_path = relative_template_path();

    wp_deregister_script("jquery");
    wp_register_script("kudu-modernizr", "$template_path/scripts/vendor/modernizr/modernizr.min.js");
    wp_register_script("kudu-acf-gmaps", "//maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAC4IsuvpukJDywrNfJCTH9d-cLN9MAkgg");

    wp_register_script("jquery", "$template_path/scripts/vendor/jquery/jquery.min.js");
    wp_register_script("kudu-bootstrap", "$template_path/bootstrap/js/bootstrap.min.js");
	wp_register_script("kudu-slick", "$template_path/scripts/vendor/slick/slick.min.js");
	wp_register_script("kudu-chosen", "$template_path/scripts/vendor/chosen/chosen.jquery.min.js");
	wp_register_script("kudu-cycle", "$template_path/scripts/vendor/cycle/jquery.cycle.js");
    wp_register_script("kudu-plugins", "$template_path/scripts/plugins.min.js");
    wp_register_script("kudu-scripts", "$template_path/scripts/scripts.min.js");
    wp_localize_script("kudu-plugins", "KuduAJAX", array( "ajaxUrl" => admin_url("admin-ajax.php")));

    wp_register_style("kudu-bootstrap", "$template_path/bootstrap/css/bootstrap.min.css");
    wp_register_style("kudu-bootstrap-theme", "$template_path/bootstrap/css/bootstrap-theme.min.css");
	wp_register_style("kudu-slick-style", "$template_path/scripts/vendor/slick/slick.css");
	wp_register_style("kudu-blue-highway", "//fast.fonts.net/cssapi/b61b7b61-c691-48ed-9943-b6e4a68f75f1.css");
	wp_register_style("kudu-blue-hwy-cond", "//fast.fonts.net/cssapi/e8f90dbe-0738-494a-8ef0-584ecb35f973.css");
	wp_register_style("kudu-chosen-style", "$template_path/scripts/vendor/chosen/chosen.css");
	wp_register_style("kudu-clear-sans", "$template_path/fonts/clear_sans/font.css");
    wp_register_style("kudu-css", "$template_path/css/styles.min.css");

    wp_enqueue_style("kudu-bootstrap");
    wp_enqueue_style("kudu-bootstrap-theme", false, array("kudu-bootstrap"));
	wp_enqueue_style("wp-jquery-ui-dialog");
	wp_enqueue_style("kudu-slick-style", false, array(), '1.5.9');
	wp_enqueue_style("kudu-blue-highway");
	wp_enqueue_style("kudu-blue-hwy-cond");
	wp_enqueue_style("kudu-chosen-style");
	wp_enqueue_style("kudu-clear-sans");
	wp_enqueue_style("kudu-css", false, array("kudu-bootstrap", "kudu-bootstrap", "wp-jquery-ui-dialog", "kudu-blue-highway", "kudu-blue-hwy-cond", "kudu-clear-sans", "kudu-sean-css"));

    wp_enqueue_script("kudu-modernizr");
    wp_enqueue_script("kudu-acf-gmaps", false, array(), false, true);
    wp_enqueue_script("jquery", false, array(), false, true);
	wp_enqueue_script("jquery-ui-dialog");
    wp_enqueue_script("kudu-bootstrap", false, array("jquery"), false, true);
	wp_enqueue_script("kudu-slick", false, array("jquery"), '1.5.9', true);
	wp_enqueue_script("kudu-chosen", false, array("jquery"), '1.4.2', true);
	wp_enqueue_script("kudu-cycle", false, array("jquery"), '2.1.6', true);
    wp_enqueue_script("kudu-plugins", false, array("jquery"), false, true);
    wp_enqueue_script("kudu-scripts", false, array("jquery", "jquery-ui-dialog", "kudu-plugins", "wp-jquery-ui-dialog"), false, true);
}

add_action( "admin_enqueue_scripts", "kudu_load_admin_styles" );
function kudu_load_admin_styles() {
	$template_path = relative_template_path();
	wp_register_style("kudu-admin-css", "$template_path/css/admin-styles.css");
    wp_enqueue_style("kudu-admin-css");
}

/* ORIGINAL, SIMPLIFIED VERSION (could be used on other projects):
// add the current user's role(s) as body classes on admin
add_filter("admin_body_class", "kudu_user_role_bodyclass");
function kudu_user_role_bodyclass($classes) {
	$user_ID = get_current_user_id();
	$user_data = get_userdata($user_ID);
	// $user_data->roles is an array of the current user's role(s)
	$classes .= ' ' . implode(' ', $user_data->roles);
	return $classes;
} // end kudu_user_role_bodyclass()
*/

// add the current user's role(s) as body classes on admin
add_filter("admin_body_class", "kudu_user_role_bodyclass");
function kudu_user_role_bodyclass($classes) {
	$user_ID = get_current_user_id();
	$user_data = get_userdata($user_ID);
	// $user_data->roles is an array of the current user's role(s)

	$is_partner = FALSE;
	$new_classes = array();

	global $bfbl_custom_roles; /* values set at the start of functions.php */

	foreach($user_data->roles as $the_role) {
		if(in_array($the_role, $bfbl_custom_roles)) {
			$is_partner = TRUE;
			$new_classes[] = 'bfbl-' . $the_role;
		} else {
			$new_classes[] = $the_role;
		} // end the does-the-user-have-a-custom-role test
	} // end $user_data->roles foreach

	if($is_partner) {
		array_unshift($new_classes, 'bfbl-partner');
	}

	$classes .= ' ' . implode(' ', $new_classes);
	return $classes;
} // end kudu_user_role_bodyclass()

add_action("comment_form_before", "kudu_enqueue_comment_reply_script");
function kudu_enqueue_comment_reply_script() {
	if (get_option("thread_comments")) wp_enqueue_script("comment-reply");
}

add_filter("the_title", "kudu_title");
function kudu_title($title) {

	$rVal = ($title === "") ? "&rarr;" : $title;
	return $rVal;
}

add_filter("wp_title", "kudu_filter_wp_title");
function kudu_filter_wp_title($title) {
	$rVal = $title . esc_attr(get_bloginfo( "name" ));
	return $rVal;
}

// add_action("widgets_init", "kudu_widgets_init");
// function kudu_widgets_init() {
// 	register_sidebar(array(
// 		"name" =>				__("Sidebar Widget Area", "kudu"),
// 		"id" =>					"primary-widget-area",
// 		"before_widget" =>		"<li id=\"%1$s\" class=\"widget-container %2$s\">",
// 		"after_widget" =>		"</li>",
// 		"before_title" =>		"<h3 class=\"widget-title\">",
// 		"after_title" =>		"</h3>"
// 	));
// }

add_filter("get_comments_number", "kudu_comments_number");
function kudu_comments_number( $count ) {
	if (!is_admin()) {
		global $id;
		$comments_by_type = &separate_comments( get_comments("status=approve&post_id=" . $id));
		$rVal = count($comments_by_type["comment"]);
	} else $rVal = $count;
	return $rVal;
}

add_filter( 'show_admin_bar', 'hide_admin_bar_from_front_end' );
function hide_admin_bar_from_front_end(){
	$rVal = (is_blog_admin()) ? true : false;
	return $rVal;
}

add_filter('image_size_names_choose', 'custom_image_sizes');
function custom_image_sizes($sizes) {
    $addsizes = array(
        "tiny" => __( "Tiny")
    );
    $newsizes = array_merge($sizes, $addsizes);
    return $newsizes;
}

// extract a social media username from a url (assuming standard format, where the username is after the last slash)
function bfblExtractName($url) {
	$splitUrl = explode("facebook.com/", $url);
	if (is_array($splitUrl) && count($splitUrl) > 1 ) {
		$result = $splitUrl[1];
		$result = chop($result, "/?fref=ts");
		$result = chop($result, "/");
	} else $result = $url;

	// if the string is empty, put back the url as a fallback
	if(!$result) {
		$result = $url;
	}

	return $result;
} // end bfblExtractName()


// for use during development
function showIt($string) {
	echo "<h1>$string</h1>";
} // end showIt()