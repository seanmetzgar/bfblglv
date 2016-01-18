<?php
add_action("init", "kudu_custom_post_types");
function kudu_custom_post_types() {
    // $character_type_name = "character";
    // $character_type_labels = array(
    //     "name"               => _x("Characters", "post type general name", "kudu"),
    //     "singular_name"      => _x("Character", "post type singular name", "kudu"),
    //     "menu_name"          => _x("Characters", "admin menu", "kudu"),
    //     "name_admin_bar"     => _x("Character", "add new on admin bar", "kudu"),
    //     "add_new"            => _x("Add New", "character", "kudu"),
    //     "add_new_item"       => __("Add New Character", "kudu"),
    //     "new_item"           => __("New Character", "kudu"),
    //     "edit_item"          => __("Edit Character", "kudu"),
    //     "view_item"          => __("View Character", "kudu"),
    //     "all_items"          => __("All Characters", "kudu"),
    //     "search_items"       => __("Search Characters", "kudu"),
    //     "parent_item_colon"  => __("Parent Character:", "kudu"),
    //     "not_found"          => __("No characters found.", "kudu"),
    //     "not_found_in_trash" => __("No characters found in trash.", "kudu")
    // );
    // $character_type_args = array(
    //     "labels"                => $character_type_labels,
    //     "exclude_from_search"   => true,
    //     "public"                => true,
    //     "publicly_queryable"    => true,
    //     "show_ui"               => true,
    //     "show_in_nav_menus"     => true,
    //     "show_in_menu"          => true,
    //     "show_in_admin_bar"     => true,
    //     "query_var"             => true,
    //     "rewrite"               => array( "slug" => "characters" ),
    //     "capability_type"       => "post",
    //     "has_archive"           => false,
    //     "hierarchical"          => false,
    //     "menu_position"         => 20,
    //     "supports"               => array("title", "editor", "thumbnail", "excerpt", "revisions")
    // );

    // register_post_type( $adventure_type_name, $adventure_type_args );


    if( function_exists("acf_add_options_page") ) {
        acf_add_options_page(array(
            "page_title"        => "News & Events Settings",
            "menu_title"        => "News & Events Settings",
            "menu_slug"         => "options_news_events",
            "capability"        => "edit_posts"
        ));
        acf_add_options_page(array(
            "page_title"        => "Resources Settings",
            "menu_title"        => "Resources Settings",
            "menu_slug"         => "options_resources",
            "capability"        => "edit_posts", 
            "parent_slug"       => "edit.php?post_type=resources"
        ));
    }

}