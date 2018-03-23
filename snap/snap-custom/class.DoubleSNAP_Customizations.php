<?php

class DoubleSNAP_Customizations {
	private static $initiated = false;
	private static $resources_type_name = "resources";
	private static $faq_type_name = "faq";
    private static $testimonials_type_name = "testimonials";

	private static $resources_taxonomy_name = "sponsor_type";
	private static $faq_taxonomy_name = "faq_type";

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

		$resources_type_name =		self::$resources_type_name;
		$resources_type_labels =		array(
			"name"					=> _x( "Resources", "post type general name", "snap-cust" ),
			"singular_name"			=> _x( "Resource", "post type singular name", "snap-cust" ),
			"menu_name"				=> _x( "Resources", "admin menu", "snap-cust" ),
			"name_admin_bar"		=> _x( "Resources", "add new on admin bar", "snap-cust" ),
			"add_new"				=> _x( "Add Resource", "resources", "snap-cust" ),
			"add_new_item"			=> __( "Add Resource", "snap-cust" ),
			"new_item"				=> __( "New Resource", "snap-cust" ),
			"edit_item"				=> __( "Edit Resource", "snap-cust" ),
			"view_item"				=> __( "View Resource", "snap-cust" ),
			"all_items"				=> __( "All Resources", "snap-cust" ),
			"search_items"			=> __( "Search Resources", "snap-cust" ),
			"parent_item_colon"		=> __( "Parent Resource:", "snap-cust" ),
			"not_found"				=> __( "No resources found.", "snap-cust" ),
			"not_found_in_trash"	=> __( "No resources found in trash.", "snap-cust" )
		);
		$resources_type_args =		array(
			"labels"				=> $resources_type_labels,
			"exclude_from_search"	=> true,
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
			"menu_position"			=> 6,
			"menu_icon"				=> "dashicons-star-filled",
			"supports"				=> array( "title", "editor", "excerpt", "thumbnail", "revisions" )
		);

		$faq_type_name =			self::$faq_type_name;
		$faq_type_labels =			array(
			"name"					=> _x( "FAQs", "post type general name", "snap-cust" ),
			"singular_name"			=> _x( "FAQ", "post type singular name", "snap-cust" ),
			"menu_name"				=> _x( "FAQs", "admin menu", "snap-cust" ),
			"name_admin_bar"		=> _x( "FAQs", "add new on admin bar", "snap-cust" ),
			"add_new"				=> _x( "Add FAQ", "shop", "snap-cust" ),
			"add_new_item"			=> __( "Add FAQ", "snap-cust" ),
			"new_item"				=> __( "New FAQ", "snap-cust" ),
			"edit_item"				=> __( "Edit FAQ", "snap-cust" ),
			"view_item"				=> __( "View FAQ", "snap-cust" ),
			"all_items"				=> __( "All FAQs", "snap-cust" ),
			"search_items"			=> __( "Search FAQs", "snap-cust" ),
			"parent_item_colon"		=> __( "Parent FAQ:", "snap-cust" ),
			"not_found"				=> __( "No FAQs found.", "snap-cust" ),
			"not_found_in_trash"	=> __( "No FAQs found in trash.", "snap-cust" )
		);
		$faq_type_args =			array(
			"labels"				=> $faq_type_labels,
			"exclude_from_search"	=> true,
			"public"				=> true,
			"publicly_queryable"	=> true,
			"show_ui"				=> true,
			"show_in_nav_menus"		=> true,
			"show_in_menu"			=> true,
			"show_in_admin_bar"		=> true,
			"query_var"				=> true,
			"rewrite"				=> array( "slug" => $faq_type_name ),
			"capability_type"		=> "post",
			"has_archive"			=> true,
			"hierarchical"			=> false,
			"menu_position"			=> 6,
			"menu_icon"				=> "dashicons-cart",
			"supports"				=> array( "title", "editor", "excerpt", "revisions" )
		);

        $testimonials_type_name =   self::$testimonials_type_name;
        $testimonials_type_labels =	array(
            "name"					=> _x( "Testimonials", "post type general name", "snap-cust" ),
            "singular_name"			=> _x( "Testimonial", "post type singular name", "snap-cust" ),
            "menu_name"				=> _x( "Testimonials", "admin menu", "snap-cust" ),
            "name_admin_bar"		=> _x( "Testimonials", "add new on admin bar", "snap-cust" ),
            "add_new"				=> _x( "Add Testimonial", "shop", "snap-cust" ),
            "add_new_item"			=> __( "Add Testimonial", "snap-cust" ),
            "new_item"				=> __( "New Testimonial", "snap-cust" ),
            "edit_item"				=> __( "Edit Testimonial", "snap-cust" ),
            "view_item"				=> __( "View Testimonial", "snap-cust" ),
            "all_items"				=> __( "All Testimonials", "snap-cust" ),
            "search_items"			=> __( "Search Testimonials", "snap-cust" ),
            "parent_item_colon"		=> __( "Parent Testimonial:", "snap-cust" ),
            "not_found"				=> __( "No testimonials found.", "snap-cust" ),
            "not_found_in_trash"	=> __( "No testimonials found in trash.", "snap-cust" )
        );
            $testimonials_type_args =   array(
            "labels"				=> $testimonials_type_labels,
            "exclude_from_search"	=> true,
            "public"				=> true,
            "publicly_queryable"	=> true,
            "show_ui"				=> true,
            "show_in_nav_menus"		=> true,
            "show_in_menu"			=> true,
            "show_in_admin_bar"		=> true,
            "query_var"				=> true,
            "rewrite"				=> array( "slug" => $testimonials_type_name ),
            "capability_type"		=> "post",
            "has_archive"			=> false,
            "hierarchical"			=> false,
            "menu_position"			=> 6,
            "menu_icon"				=> "dashicons-cart",
            "supports"				=> array( "title", "revisions" )
        );

		/** Taxonomy Lables **/
	    $resources_taxonomy_labels = array(
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

	    $resources_taxonomy_args = array(
	        "hierarchical"      => true,
	        "labels"            => $resources_taxonomy_labels,
	        "show_ui"           => true,
	        "show_admin_column" => true,
	        "query_var"         => true,
	    );

	    $faq_taxonomy_labels = array(
	        "name"              => _x( "FAQ Type", "taxonomy general name" ),
	        "singular_name"     => _x( "FAQ Type", "taxonomy singular name" ),
	        "search_items"      => __( "Search FAQ Types" ),
	        "all_items"         => __( "All FAQ Types" ),
	        "parent_item"       => __( "Parent FAQ Type" ),
	        "parent_item_colon" => __( "Parent FAQ Type:" ),
	        "edit_item"         => __( "Edit FAQ Type" ),
	        "update_item"       => __( "Update FAQ Type" ),
	        "add_new_item"      => __( "Add New FAQ Type" ),
	        "new_item_name"     => __( "New FAQ Type Name" ),
	        "menu_name"         => __( "FAQ Types" ),
	    );

	    $faq_taxonomy_args = array(
	        "hierarchical"      => true,
	        "labels"            => $faq_taxonomy_labels,
	        "show_ui"           => true,
	        "show_admin_column" => true,
	        "query_var"         => true,
	    );

		register_post_type( $resources_type_name, $resources_type_args );
		register_post_type( $faq_type_name, $faq_type_args );
        register_post_type( $testimonials_type_name, $testimonials_type_args );

		register_taxonomy( self::$resources_taxonomy_name, array( $resources_type_name ), $resources_taxonomy_args );
		register_taxonomy( self::$faq_taxonomy_name, array( $faq_type_name ), $faq_taxonomy_args );

		// Clear the permalinks after the post type has been registered
		flush_rewrite_rules();
	}
}