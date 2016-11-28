<?php
add_action("init", "kudu_custom_post_types");
function kudu_custom_post_types() {
    if( function_exists("acf_add_options_page") ) {
        acf_add_options_page(array(
            "page_title"        => "BFBL Settings",
            "menu_title"        => "BFBL Settings",
            "menu_slug"         => "options_company",
            "capability"        => "edit_posts",
            "position"          => 9
        ));
    }
}

// remove the 'posts' and 'comments' menu items, since we're not using them
add_action( 'admin_menu', 'remove_menus' );
function remove_menus(){
  remove_menu_page( 'edit.php' ); //Posts
  remove_menu_page( 'edit-comments.php' ); //Comments
}