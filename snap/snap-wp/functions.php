<?php
require_once(dirname(__FILE__) . "/inc/bs4Navwalker.php");
require_once(dirname(__FILE__) . "/inc/_inc_helpers.php");
require_once(dirname(__FILE__) . "/inc/_inc_pll_strings.php");

add_action( 'after_setup_theme', 'snap_setup' );
function snap_setup()
{
    load_theme_textdomain( 'snap-wp', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    global $content_width;
    if ( ! isset( $content_width ) ) $content_width = 640;
    register_nav_menus(
        array(
            'main-menu' => __( 'Main Menu', 'snap-wp' ),
            'footer-menu' => __( 'Footer Menu', 'snap-wp' )
        )
    );
}
add_action( 'wp_enqueue_scripts', 'snap_load_scripts' );
function snap_load_scripts()
{
    $template_path = relative_template_path();
    wp_deregister_script( 'jquery' );
    wp_register_script("snap-acf-gmaps", "//maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAC4IsuvpukJDywrNfJCTH9d-cLN9MAkgg");
    wp_register_script('jquery', "$template_path/js/vendor/jquery/jquery.min.js", array());
    wp_register_script('snap-js', "$template_path/js/dist/all.js", array('jquery'), false, true);
    wp_register_style('snap-fonts', "$template_path/fonts/fonts.css");
    wp_register_style('snap-css', "$template_path/css/dist/all.css");

    wp_localize_script("snap-js", "SnapAJAX", array( "remoteURL" => "http://www.buylocalglv.org/wp-admin/admin-ajax.php"));


    wp_enqueue_script("snap-acf-gmaps");
    wp_enqueue_script('jquery');
    wp_enqueue_script('snap-js');

    wp_enqueue_style('snap-fonts');
    wp_enqueue_style('snap-css');
}
add_action( 'comment_form_before', 'snap_enqueue_comment_reply_script' );
function snap_enqueue_comment_reply_script()
{
    if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'snap_title' );
function snap_title( $title ) {
    if ( $title == '' ) {
        return '&rarr;';
    } else {
        return $title;
    }
}
add_filter( 'wp_title', 'snap_filter_wp_title' );
function snap_filter_wp_title( $title )
{
    return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'snap_widgets_init' );
function snap_widgets_init()
{
    register_sidebar( array (
        'name' => __( 'Sidebar Widget Area', 'snap-wp' ),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
function snap_custom_pings( $comment )
{
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
    <?php
}
add_filter( 'get_comments_number', 'snap_comments_number' );
function snap_comments_number( $count )
{
    if ( !is_admin() ) {
        global $id;
        $comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
        return count( $comments_by_type['comment'] );
    } else {
        return $count;
    }
}

add_filter( "show_admin_bar", "hide_admin_bar_from_front_end" );
function hide_admin_bar_from_front_end(){
    $rVal = (is_blog_admin()) ? true : false;
    return $rVal;
}

add_action( 'pre_get_posts', 'set_posts_per_page_for_towns_cpt' );
function set_posts_per_page_for_towns_cpt( $query ) {
    if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'faq' ) ) {
        $query->set( 'posts_per_page', '-1' );
    }
}