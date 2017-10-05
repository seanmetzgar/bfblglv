<?php

class BFBL_GLV_Customizations {
	private static $initiated = false;
	private static $partners_type_name = "partners";
	private static $news_type_name = "news";
	private static $events_type_name = "events";
	private static $resources_type_name = "resources";
	private static $sponsors_type_name = "sponsors";
	private static $resources_taxonomy_name = "resource_type";
	private static $resources_taxonomy_slug = "resource-type";

	private static function role_exists( $role ) {
		$rVal = false;
		if( ! empty( $role ) ) {
	    	$rVal = $GLOBALS['wp_roles']->is_role( $role );
	  	}

	  	return $rVal;
	}

	public static function tl_save_error() {
    	update_option( 'plugin_error',  ob_get_contents() );
	}


	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	private static function init_hooks() {
		self::$initiated = true;

		self::architecture_customizations();
	}

	public static function generate_download_partners_page() {
		if ( ! current_user_can( "list_users" ) ) {
            wp_die( "You're not supposed to be here..." );
        }

  		echo "<h1>Download Partner Information</h1>";
  		echo "<p>Clicking the button below will start the export and download process. Please be patient, as this may take a few minutes.</p>";
  		echo "<hr>";
  		echo "<a href=\"/wp-admin/admin-ajax.php?action=xhrGetPartnersDownload\" class=\"download-partner-data button\">Download</a>";
	}

	public static function add_roles_on_plugin_activation() {
       if (!(self::role_exists("farm"))) add_role( "farm", "Farm", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("distributor"))) add_role( "distributor", "Distributor", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("distillery"))) add_role( "distillery", "Brewery / Distillery", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("farmers-market"))) add_role( "farmers-market", "Producer-Only Farmers' Market", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("institution"))) add_role( "institution", "Institution", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("restaurant"))) add_role( "restaurant", "Restaurant", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("retail"))) add_role( "retail", "Retail Operations", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("specialty"))) add_role( "specialty", "Specialty Products", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("vineyard"))) add_role( "vineyard", "Vineyard", array( "read" => true, "level_0" => true ) );
       if (!(self::role_exists("hidden-vendor"))) add_role( "hidden-vendor", "Hidden Vendor", array( "read" => true, "level_0" => true ) );
   	}

   	public static function add_admin_pages() {
   		add_users_page( "Download Partner Information", "Download Partners", "list_users", "download-partners", array( "BFBL_GLV_Customizations", "generate_download_partners_page" ) );
   	}
   	public static function admin_enqueue_scripts( $hook ) {
        // load the scripts on only the plugin admin page ##
        if ( isset( $_GET['page'] ) && ( $_GET['page'] == "download-partners" ) ) {

            wp_enqueue_script( "bfblglv-custom-scripts", plugins_url( "js/scripts.js", __FILE__ ), array('jquery'));

        }
    }

	private static function architecture_customizations() {
		global $wp_rewrite;

		$news_type_name =			self::$news_type_name;
		$news_type_labels =			array(
			"name"					=> _x( "News", "post type general name", "bfblglv-custom" ),
			"singular_name"			=> _x( "News", "post type singular name", "bfblglv-custom" ),
			"menu_name"				=> _x( "News", "admin menu", "bfblglv-custom" ),
			"name_admin_bar"		=> _x( "News", "add new on admin bar", "bfblglv-custom" ),
			"add_new"				=> _x( "Add News", "news", "bfblglv-custom" ),
			"add_new_item"			=> __( "Add News", "bfblglv-custom" ),
			"new_item"				=> __( "New Article", "bfblglv-custom" ),
			"edit_item"				=> __( "Edit Article", "bfblglv-custom" ),
			"view_item"				=> __( "View Article", "bfblglv-custom" ),
			"all_items"				=> __( "All News", "bfblglv-custom" ),
			"search_items"			=> __( "Search News", "bfblglv-custom" ),
			"parent_item_colon"		=> __( "Parent Article:", "bfblglv-custom" ),
			"not_found"				=> __( "No news found.", "bfblglv-custom" ),
			"not_found_in_trash"	=> __( "No news found in trash.", "bfblglv-custom" )
		);
		$news_type_args =			array(
			"labels"				=> $news_type_labels,
			"exclude_from_search"	=> false,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"rewrite"				=> array( "slug" => $news_type_name ),
			"capability_type"		=> "post",
			"has_archive"			=> true,
			"hierarchical"			=> false,
			"menu_position"			=> 6,
			"menu_icon"				=> "dashicons-megaphone",
			"supports"				=> array( "title", "editor", "excerpt", "thumbnail", "revisions" )
		);

		$events_type_name =			self::$events_type_name;
		$events_type_labels =		array(
			"name"					=> _x( "Events", "post type general name", "bfblglv-custom" ),
			"singular_name"			=> _x( "Event", "post type singular name", "bfblglv-custom" ),
			"menu_name"				=> _x( "Events", "admin menu", "bfblglv-custom" ),
			"name_admin_bar"		=> _x( "Events", "add new on admin bar", "bfblglv-custom" ),
			"add_new"				=> _x( "Add Events", "events", "bfblglv-custom" ),
			"add_new_item"			=> __( "Add Event", "bfblglv-custom" ),
			"new_item"				=> __( "New Event", "bfblglv-custom" ),
			"edit_item"				=> __( "Edit Event", "bfblglv-custom" ),
			"view_item"				=> __( "View Event", "bfblglv-custom" ),
			"all_items"				=> __( "All Events", "bfblglv-custom" ),
			"search_items"			=> __( "Search Events", "bfblglv-custom" ),
			"parent_item_colon"		=> __( "Parent Event:", "bfblglv-custom" ),
			"not_found"				=> __( "No events found.", "bfblglv-custom" ),
			"not_found_in_trash"	=> __( "No events found in trash.", "bfblglv-custom" )
		);
		$events_type_args =			array(
			"labels"				=> $events_type_labels,
			"exclude_from_search"	=> false,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"rewrite"				=> array( "slug" => $events_type_name ),
			"capability_type"		=> "post",
			"has_archive"			=> true,
			"hierarchical"			=> false,
			"menu_position"			=> 8,
			"menu_icon"				=> "dashicons-calendar-alt",
			"supports"				=> array( "title", "editor", "excerpt", "thumbnail", "revisions" )
		);

		$resources_type_name =		self::$resources_type_name;
		$resources_type_labels =	array(
			"name"					=> _x( "Resources", "post type general name", "bfblglv-custom" ),
			"singular_name"			=> _x( "Resource", "post type singular name", "bfblglv-custom" ),
			"menu_name"				=> _x( "Resources", "admin menu", "bfblglv-custom" ),
			"name_admin_bar"		=> _x( "Resources", "add new on admin bar", "bfblglv-custom" ),
			"add_new"				=> _x( "Add Resources", "resources", "bfblglv-custom" ),
			"add_new_item"			=> __( "Add Resource", "bfblglv-custom" ),
			"new_item"				=> __( "New Resource", "bfblglv-custom" ),
			"edit_item"				=> __( "Edit Resource", "bfblglv-custom" ),
			"view_item"				=> __( "View Resource", "bfblglv-custom" ),
			"all_items"				=> __( "All Resources", "bfblglv-custom" ),
			"search_items"			=> __( "Search Resources", "bfblglv-custom" ),
			"parent_item_colon"		=> __( "Parent Resource:", "bfblglv-custom" ),
			"not_found"				=> __( "No resources found.", "bfblglv-custom" ),
			"not_found_in_trash"	=> __( "No resources found in trash.", "bfblglv-custom" )
		);
		$resources_type_args =		array(
			"labels"				=> $resources_type_labels,
			"exclude_from_search"	=> false,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"rewrite"				=> array( "slug" => $resources_type_name ),
			"capability_type"		=> "post",
			"has_archive"			=> true,
			"hierarchical"			=> false,
			"menu_position"			=> 9,
			"menu_icon"				=> "dashicons-hammer",
			"supports"				=> array( "title", "editor", "excerpt", "thumbnail", "revisions" )
		);

		$sponsors_type_name =		self::$sponsors_type_name;
		$sponsors_type_labels =		array(
			"name"					=> _x( "Sponsors", "post type general name", "bfblglv-custom" ),
			"singular_name"			=> _x( "Sponsor", "post type singular name", "bfblglv-custom" ),
			"menu_name"				=> _x( "Sponsors", "admin menu", "bfblglv-custom" ),
			"name_admin_bar"		=> _x( "Sponsors", "add new on admin bar", "bfblglv-custom" ),
			"add_new"				=> _x( "Add Sponsors", "sponsors", "bfblglv-custom" ),
			"add_new_item"			=> __( "Add Sponsor", "bfblglv-custom" ),
			"new_item"				=> __( "New Sponsor", "bfblglv-custom" ),
			"edit_item"				=> __( "Edit Sponsor", "bfblglv-custom" ),
			"view_item"				=> __( "View Sponsor", "bfblglv-custom" ),
			"all_items"				=> __( "All Sponsors", "bfblglv-custom" ),
			"search_items"			=> __( "Search Sponsors", "bfblglv-custom" ),
			"parent_item_colon"		=> __( "Parent Sponsor:", "bfblglv-custom" ),
			"not_found"				=> __( "No sponsors found.", "bfblglv-custom" ),
			"not_found_in_trash"	=> __( "No sponsors found in trash.", "bfblglv-custom" )
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
			"has_archive"			=> false,
			"hierarchical"			=> false,
			"menu_position"			=> 9,
			"menu_icon"				=> "dashicons-universal-access",
			"supports"				=> array( "title", "thumbnail", "revisions" )
		);

		$resource_taxonomy_labels = array(
	        "name"              => _x( "Resource Type", "taxonomy general name" ),
	        "singular_name"     => _x( "Resource Type", "taxonomy singular name" ),
	        "search_items"      => __( "Search Resource Types" ),
	        "all_items"         => __( "All Resource Types" ),
	        "parent_item"       => __( "Parent Resource Type" ),
	        "parent_item_colon" => __( "Parent Resource Type:" ),
	        "edit_item"         => __( "Edit Resource Type" ),
	        "update_item"       => __( "Update Resource Type" ),
	        "add_new_item"      => __( "Add New Resource Type" ),
	        "new_item_name"     => __( "New Resource Type Name" ),
	        "menu_name"         => __( "Resource Types" ),
	    );

	    $resource_taxonomy_args = array(
	        "hierarchical"      => true,
	        "labels"            => $resource_taxonomy_labels,
	        "show_ui"           => true,
	        "show_admin_column" => true,
	        "query_var"         => true,
	        "rewrite"           => array( "slug" => self::$resources_taxonomy_slug ),
	    );

		register_post_type( $news_type_name, $news_type_args );
		// register_post_type( $events_type_name, $events_type_args );
		register_post_type( $resources_type_name, $resources_type_args );
		register_post_type( $sponsors_type_name, $sponsors_type_args );

		register_taxonomy( self::$resources_taxonomy_name, array( self::$resources_type_name ), $resource_taxonomy_args );

    	$wp_rewrite->author_base = "partners";
    	$wp_rewrite->author_structure = "/" . $wp_rewrite->author_base. "/%author%";

		// Clear the permalinks after the post type has been registered
		flush_rewrite_rules();
	}
}

?>