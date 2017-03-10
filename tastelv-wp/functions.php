<?php
require_once(dirname(__FILE__) . "/inc/_inc_helpers.php");
require_once(dirname(__FILE__) . "/inc/_inc_customizations.php");

add_action("after_setup_theme", "tastelv_setup");
function tastelv_setup() {
	load_theme_textdomain("tastelv", get_template_directory() . "/languages");

    add_theme_support("automatic-feed-links");
    add_theme_support("post-thumbnails");
    add_theme_support("html5");

	global $content_width;
	if (!isset($content_width)) $content_width = 640;

	register_nav_menus(array(
		"main-menu" => 			__("Main Menu", "tastelv"),
		"footer-menu" =>		__("Footer Menu", "tastelv")
	));

	add_image_size( "hero-image", 320, 320, array("center", "center") );

	if( function_exists('acf_add_options_page') ) {
		$option_page = acf_add_options_page(array(
			'page_title' 	=> 'Event Details',
			'menu_title' 	=> 'Event Details',
			'menu_slug' 	=> 'event_details',
			'capability' 	=> 'edit_posts',
			'redirect' 	=> false
		));
	}
}

add_action("wp_enqueue_scripts", "tastelv_load_scripts");
function tastelv_load_scripts() {
	$template_path = relative_template_path();
    wp_deregister_script("jquery");

    wp_enqueue_style("tastelv-fonts", "//fonts.googleapis.com/css?family=PT+Sans+Caption:400,700|Roboto:300,300italic,400,400italic,700,700italic");
    wp_enqueue_style("tastelv-fontello", "$template_path/fonts/fontello/css/tastelv-icons.css");
    wp_enqueue_style("tastelv-css", "$template_path/css/styles.css");

    wp_enqueue_script("kudu-acf-gmaps", "//maps.googleapis.com/maps/api/js?v=3.exp");
    wp_enqueue_script("jquery", "$template_path/scripts/vendor/jquery/jquery.min.js", array(), false, true);
    wp_enqueue_script("tastelv-scripts", "$template_path/scripts/scripts.min.js", array("jquery"), false, true);
}

add_action("comment_form_before", "tastelv_enqueue_comment_reply_script");
function tastelv_enqueue_comment_reply_script() {
	if (get_option("thread_comments")) wp_enqueue_script("comment-reply");
}

add_filter("the_title", "tastelv_title");
function tastelv_title($title) {
	$rVal = ($title === "") ? "&rarr;" : $title;
	return $rVal;
}

add_filter("wp_title", "tastelv_filter_wp_title");
function tastelv_filter_wp_title($title) {
	$rVal = $title . esc_attr(get_bloginfo( "name" ));
	return $rVal;
}

add_action("widgets_init", "tastelv_widgets_init");
function tastelv_widgets_init() {
	register_sidebar(array(
		"name" =>				__("Sidebar Widget Area", "tastelv"),
		"id" =>					"primary-widget-area",
		"before_widget" =>		"<li id=\"%1$s\" class=\"widget-container %2$s\">",
		"after_widget" =>		"</li>",
		"before_title" =>		"<h3 class=\"widget-title\">",
		"after_title" =>		"</h3>"
	));
}

add_filter("get_comments_number", "tastelv_comments_number");
function tastelv_comments_number( $count ) {
	if (!is_admin()) {
		global $id;
		$comments_by_type = &separate_comments( get_comments("status=approve&post_id=" . $id));
		$rVal = count($comments_by_type["comment"]);
	} else $rVal = $count;
	return $rVal;
}

add_filter( "show_admin_bar", "hide_admin_bar_from_front_end" );
function hide_admin_bar_from_front_end(){
	$rVal = (is_blog_admin()) ? true : false;
	return $rVal;
}

add_filter( "image_size_names_choose", "tastelv_image_size_names" );
function tastelv_image_size_names( $sizes ) {
	return array_merge( $sizes, array(
		"hero-image" => __( "Hero Image" ),
	) );
}

add_action('admin_init', 'remove_posts_menu');
function remove_posts_menu() {
    remove_menu_page('edit.php');
}

add_action('do_meta_boxes', 'remove_thumbnail_box');
function remove_thumbnail_box() {
    remove_meta_box( 'postimagediv','page','side' );
}