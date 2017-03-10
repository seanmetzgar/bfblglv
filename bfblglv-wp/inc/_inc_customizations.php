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

add_action( 'pre_get_posts', 'manage_wp_posts_be_qe_pre_get_posts', 1 );
function manage_wp_posts_be_qe_pre_get_posts( $query ) {
   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

      switch( $orderby ) {
         case 'user_last_updated':
            $query->set( 'meta_key', 'user_last_updated' );
            $query->set( 'orderby', 'meta_value' );
            break;
      }
   }
}