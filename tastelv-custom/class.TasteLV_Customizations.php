<?php

class TasteLV_Customizations {
	private static $initiated = false;
	private static $sponsors_type_name = "sponsors";
	private static $shop_type_name = "shop";
	private static $eat_type_name = "eat";
	private static $explore_type_name = "explore";
	private static $play_type_name = "play";

	private static $sponsors_taxonomy_name = "sponsor_type";
	private static $event_taxonomy_name = "event_type";

	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	private static function init_hooks() {
		self::$initiated = true;

		self::architecture_customizations();
	}

	private static function architecture_customizations() {
		global $wp_rewrite;

		$sponsors_type_name =		self::$sponsors_type_name;
		$sponsors_type_labels =		array(
			"name"					=> _x( "Sponsors", "post type general name", "tastelv-custom" ),
			"singular_name"			=> _x( "Sponsor", "post type singular name", "tastelv-custom" ),
			"menu_name"				=> _x( "Sponsors", "admin menu", "tastelv-custom" ),
			"name_admin_bar"		=> _x( "Sponsors", "add new on admin bar", "tastelv-custom" ),
			"add_new"				=> _x( "Add Sponsor", "sponsors", "tastelv-custom" ),
			"add_new_item"			=> __( "Add Sponsor", "tastelv-custom" ),
			"new_item"				=> __( "New Sponsor", "tastelv-custom" ),
			"edit_item"				=> __( "Edit Sponsor", "tastelv-custom" ),
			"view_item"				=> __( "View Sponsor", "tastelv-custom" ),
			"all_items"				=> __( "All Sponsors", "tastelv-custom" ),
			"search_items"			=> __( "Search Sponsors", "tastelv-custom" ),
			"parent_item_colon"		=> __( "Parent Sponsor:", "tastelv-custom" ),
			"not_found"				=> __( "No sponsors found.", "tastelv-custom" ),
			"not_found_in_trash"	=> __( "No sponsors found in trash.", "tastelv-custom" )
		);
		$sponsors_type_args =		array(
			"labels"				=> $sponsors_type_labels,
			"exclude_from_search"	=> true,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"rewrite"				=> array( "slug" => $sponsors_type_name ),
			"capability_type"		=> "post",
			"has_archive"			=> true,
			"hierarchical"			=> false,
			"menu_position"			=> 6,
			"menu_icon"				=> "dashicons-star-filled",
			"supports"				=> array( "title", "thumbnail", "revisions" )
		);

		$shop_type_name =			self::$shop_type_name;
		$shop_type_labels =			array(
			"name"					=> _x( "Shop", "post type general name", "tastelv-custom" ),
			"singular_name"			=> _x( "Shop", "post type singular name", "tastelv-custom" ),
			"menu_name"				=> _x( "Shop", "admin menu", "tastelv-custom" ),
			"name_admin_bar"		=> _x( "Shop", "add new on admin bar", "tastelv-custom" ),
			"add_new"				=> _x( "Add Vendor", "shop", "tastelv-custom" ),
			"add_new_item"			=> __( "Add Vendor", "tastelv-custom" ),
			"new_item"				=> __( "New Vendor", "tastelv-custom" ),
			"edit_item"				=> __( "Edit Vendor", "tastelv-custom" ),
			"view_item"				=> __( "View Vendor", "tastelv-custom" ),
			"all_items"				=> __( "All Vendors", "tastelv-custom" ),
			"search_items"			=> __( "Search Shop", "tastelv-custom" ),
			"parent_item_colon"		=> __( "Parent Vendor:", "tastelv-custom" ),
			"not_found"				=> __( "No vendors found.", "tastelv-custom" ),
			"not_found_in_trash"	=> __( "No vendors found in trash.", "tastelv-custom" )
		);
		$shop_type_args =			array(
			"labels"				=> $shop_type_labels,
			"exclude_from_search"	=> true,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"rewrite"				=> array( "slug" => $shop_type_name ),
			"capability_type"		=> "post",
			"has_archive"			=> true,
			"hierarchical"			=> false,
			"menu_position"			=> 6,
			"menu_icon"				=> "dashicons-cart",
			"supports"				=> array( "title", "thumbnail", "revisions" )
		);

		$eat_type_name =			self::$eat_type_name;
		$eat_type_labels =			array(
			"name"					=> _x( "Eat", "post type general name", "tastelv-custom" ),
			"singular_name"			=> _x( "Eat", "post type singular name", "tastelv-custom" ),
			"menu_name"				=> _x( "Eat", "admin menu", "tastelv-custom" ),
			"name_admin_bar"		=> _x( "Eat", "add new on admin bar", "tastelv-custom" ),
			"add_new"				=> _x( "Add Vendor", "eat", "tastelv-custom" ),
			"add_new_item"			=> __( "Add Vendor", "tastelv-custom" ),
			"new_item"				=> __( "New Vendor", "tastelv-custom" ),
			"edit_item"				=> __( "Edit Vendor", "tastelv-custom" ),
			"view_item"				=> __( "View Vendor", "tastelv-custom" ),
			"all_items"				=> __( "All Vendors", "tastelv-custom" ),
			"search_items"			=> __( "Search Eat", "tastelv-custom" ),
			"parent_item_colon"		=> __( "Parent Vendor:", "tastelv-custom" ),
			"not_found"				=> __( "No vendors found.", "tastelv-custom" ),
			"not_found_in_trash"	=> __( "No vendors found in trash.", "tastelv-custom" )
		);
		$eat_type_args =			array(
			"labels"				=> $eat_type_labels,
			"exclude_from_search"	=> true,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"rewrite"				=> array( "slug" => $eat_type_name ),
			"capability_type"		=> "post",
			"has_archive"			=> false,
			"hierarchical"			=> false,
			"menu_position"			=> 6,
			"menu_icon"				=> "dashicons-tickets-alt",
			"supports"				=> array( "title", "thumbnail", "revisions" )
		);

		$play_type_name =			self::$play_type_name;
		$play_type_labels =			array(
			"name"					=> _x( "Play Events", "post type general name", "tastelv-custom" ),
			"singular_name"			=> _x( "Play Event", "post type singular name", "tastelv-custom" ),
			"menu_name"				=> _x( "Play", "admin menu", "tastelv-custom" ),
			"name_admin_bar"		=> _x( "Play", "add new on admin bar", "tastelv-custom" ),
			"add_new"				=> _x( "Add Events", "play", "tastelv-custom" ),
			"add_new_item"			=> __( "Add Event", "tastelv-custom" ),
			"new_item"				=> __( "New Event", "tastelv-custom" ),
			"edit_item"				=> __( "Edit Event", "tastelv-custom" ),
			"view_item"				=> __( "View Event", "tastelv-custom" ),
			"all_items"				=> __( "All Play Events", "tastelv-custom" ),
			"search_items"			=> __( "Search Play Events", "tastelv-custom" ),
			"parent_item_colon"		=> __( "Parent Event:", "tastelv-custom" ),
			"not_found"				=> __( "No play events found.", "tastelv-custom" ),
			"not_found_in_trash"	=> __( "No play events found in trash.", "tastelv-custom" )
		);
		$play_type_args =			array(
			"labels"				=> $play_type_labels,
			"exclude_from_search"	=> false,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"capability_type"		=> "post",
			"has_archive"			=> true,
			"hierarchical"			=> false,
			"menu_position"			=> 6,
			"menu_icon"				=> "dashicons-calendar-alt",
			"supports"				=> array( "title", "editor", "thumbnail", "revisions" ),
			"rewrite"				=> array( "slug" => $play_type_name )
		);

		$explore_type_name =		self::$explore_type_name;
		$explore_type_labels =		array(
			"name"					=> _x( "Explore Events", "post type general name", "tastelv-custom" ),
			"singular_name"			=> _x( "Explore Event", "post type singular name", "tastelv-custom" ),
			"menu_name"				=> _x( "Explore", "admin menu", "tastelv-custom" ),
			"name_admin_bar"		=> _x( "Explore", "add new on admin bar", "tastelv-custom" ),
			"add_new"				=> _x( "Add Events", "explore", "tastelv-custom" ),
			"add_new_item"			=> __( "Add Event", "tastelv-custom" ),
			"new_item"				=> __( "New Event", "tastelv-custom" ),
			"edit_item"				=> __( "Edit Event", "tastelv-custom" ),
			"view_item"				=> __( "View Event", "tastelv-custom" ),
			"all_items"				=> __( "All Explore Events", "tastelv-custom" ),
			"search_items"			=> __( "Search Explore Events", "tastelv-custom" ),
			"parent_item_colon"		=> __( "Parent Event:", "tastelv-custom" ),
			"not_found"				=> __( "No explore events found.", "tastelv-custom" ),
			"not_found_in_trash"	=> __( "No explore events found in trash.", "tastelv-custom" )
		);
		$explore_type_args =		array(
			"labels"				=> $explore_type_labels,
			"exclude_from_search"	=> false,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"capability_type"		=> "post",
			"has_archive"			=> true,
			"hierarchical"			=> false,
			"menu_position"			=> 6,
			"menu_icon"				=> "dashicons-calendar-alt",
			"supports"				=> array( "title", "editor", "thumbnail", "revisions" ),
			"rewrite"				=> array( "slug" => $explore_type_name )
		);

	    $sponsors_taxonomy_labels = array(
	        "name"              => _x( "Sponsor Type", "taxonomy general name" ),
	        "singular_name"     => _x( "Sponsor Type", "taxonomy singular name" ),
	        "search_items"      => __( "Search Sponsor Types" ),
	        "all_items"         => __( "All Sponsor Types" ),
	        "parent_item"       => __( "Parent Sponsor Type" ),
	        "parent_item_colon" => __( "Parent Sponsor Type:" ),
	        "edit_item"         => __( "Edit Sponsor Type" ),
	        "update_item"       => __( "Update Sponsor Type" ),
	        "add_new_item"      => __( "Add New Sponsor Type" ),
	        "new_item_name"     => __( "New Sponsor Type Name" ),
	        "menu_name"         => __( "Sponsor Types" ),
	    );

	    $sponsors_taxonomy_args = array(
	        "hierarchical"      => true,
	        "labels"            => $sponsors_taxonomy_labels,
	        "show_ui"           => true,
	        "show_admin_column" => true,
	        "query_var"         => true,
	    );

	    $event_taxonomy_labels = array(
	        "name"              => _x( "Event Type", "taxonomy general name" ),
	        "singular_name"     => _x( "Event Type", "taxonomy singular name" ),
	        "search_items"      => __( "Search Event Types" ),
	        "all_items"         => __( "All Event Types" ),
	        "parent_item"       => __( "Parent Event Type" ),
	        "parent_item_colon" => __( "Parent Event Type:" ),
	        "edit_item"         => __( "Edit Event Type" ),
	        "update_item"       => __( "Update Event Type" ),
	        "add_new_item"      => __( "Add New Event Type" ),
	        "new_item_name"     => __( "New Event Type Name" ),
	        "menu_name"         => __( "Event Types" ),
	    );

	    $event_taxonomy_args = array(
	        "hierarchical"      => true,
	        "labels"            => $event_taxonomy_labels,
	        "show_ui"           => true,
	        "show_admin_column" => true,
	        "query_var"         => true,
	    );

		register_post_type( $sponsors_type_name, $sponsors_type_args );
		register_post_type( $shop_type_name, $shop_type_args );
		register_post_type( $eat_type_name, $eat_type_args );
		register_post_type( $play_type_name, $play_type_args );
		register_post_type( $explore_type_name, $explore_type_args );

		register_taxonomy( self::$sponsors_taxonomy_name, array( $sponsors_type_name ), $sponsors_taxonomy_args );
		register_taxonomy( self::$event_taxonomy_name, array( $play_type_name, $explore_type_name ), $event_taxonomy_args );

		if( function_exists("acf_add_options_page") ) {
			if (post_type_exists("shop")) {
				acf_add_options_page(array(
			        "page_title"        => "Shop: Archive Settings",
			        "menu_title"        => "Shop: Archive Settings",
			        "menu_slug"         => "options_shop",
			        "parent_slug"		=> "edit.php?post_type=shop",
			        "capability"        => "edit_posts",
			        "position"          => false,
			        "redirect"			=> false
			    ));
			}

			if (post_type_exists("play")) {
				acf_add_options_page(array(
			        "page_title"        => "Play: Archive Settings",
			        "menu_title"        => "Play: Archive Settings",
			        "menu_slug"         => "options_play",
			        "parent_slug"		=> "edit.php?post_type=play",
			        "capability"        => "edit_posts",
			        "position"          => false,
			        "redirect"			=> false
			    ));
			}

			if (post_type_exists("sponsors")) {
				acf_add_options_page(array(
			        "page_title"        => "Sponsors: Archive Settings",
			        "menu_title"        => "Sponsors: Archive Settings",
			        "menu_slug"         => "options_sponsors",
			        "parent_slug"		=> "edit.php?post_type=sponsors",
			        "capability"        => "edit_posts",
			        "position"          => false,
			        "redirect"			=> false
			    ));
			}

			if (post_type_exists("explore")) {
				acf_add_options_page(array(
			        "page_title"        => "Explore: Archive Settings",
			        "menu_title"        => "Explore: Archive Settings",
			        "menu_slug"         => "options_explore",
			        "parent_slug"		=> "edit.php?post_type=explore",
			        "capability"        => "edit_posts",
			        "position"          => false,
			        "redirect"			=> false
			    ));
			}
		}

		// Clear the permalinks after the post type has been registered
		flush_rewrite_rules();
	}
}

?>