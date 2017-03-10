<?php
    $front_page = (is_front_page()) ? true : false;
    $template_path = relative_template_path();
    $nav_logo = get_theme_mod("nav_logo");
    $nav_logo_width = get_theme_mod("nav_logo_width");
    $nav_logo_height = get_theme_mod("nav_logo_width");
    $nav_logo = $nav_logo ? $nav_logo : "$template_path/images/logo/logo-taste-white.png";
    $nav_logo_width = $nav_logo_width && intval($nav_logo_width) ? (int)$nav_logo_width : 170;
    $nav_logo_height = $nav_logo_height && intval($nav_logo_height) ? (int)$nav_logo_height : 53;

    $nav_mobile_logo_width = ($nav_logo_width && is_int($nav_logo_width)) ? ($nav_logo_width * .65) : 109;
    $nav_mobile_logo_height = ($nav_logo_height && is_int($nav_logo_height)) ? ($nav_logo_height * .65) : 34;
    $site_mobile_header_home_padding = 24 + $nav_mobile_logo_height;
    $site_tablet_header_home_padding = 24 + $nav_logo_height;
    $site_desktop_header_home_padding = 57 + $nav_logo_height;

    $nav_button_text = nl2br(get_theme_mod("nav_button_text"), false);
    $nav_button_url = get_theme_mod("nav_button_url");
    $nav_button_html = "";

    if ($nav_button_text && $nav_button_url) {
        $nav_button_breaks = substr_count($nav_button_text, "<br>");
        if ($nav_button_breaks > 1) {
            $nav_button_html = "";
        } elseif ($nav_button_breaks == 1) {
            $nav_button_html = "<a href=\"{$nav_button_url}\" target=\"_blank\" class=\"goal-link button header two-lines\"><span>{$nav_button_text}</span></a>";
        } else {
            $nav_button_html = "<a href=\"{$nav_button_url}\" target=\"_blank\" class=\"goal-link button header\">{$nav_button_text}</a>";
        }
    } else { $nav_button_html = ""; }

    $nav_logo_tag = $front_page ? "h1" : "span";
    $nav_logo_text = get_bloginfo( "name" );
    $nav_logo_attr = esc_attr($nav_logo_text);
    $nav_logo_html = "<{$nav_logo_tag} class=\"ir nav-logo\" style=\"background-image:url('{$nav_logo}');\">{$nav_logo_text}</{$nav_logo_tag}>";

    $custom_css = "<style type=\"text/css\">\n";
        $custom_css .= ".site-header {\n";
            $custom_css .= "padding-top: {$site_mobile_header_home_padding}px;\n";
        $custom_css .= "}\n";
        $custom_css .= ".site-navigation .nav-logo {\n";
            $custom_css .= "width: {$nav_mobile_logo_width}px;\n";
            $custom_css .= "height: {$nav_mobile_logo_height}px;\n";
        $custom_css .= "}\n";
        $custom_css .= "@media (min-width: 568px) {\n";
            $custom_css .= ".site-header {\n";
                $custom_css .= "padding-top: {$site_tablet_header_home_padding}px;\n";
            $custom_css .= "}\n";
            $custom_css .= ".site-navigation .nav-logo {\n";
                $custom_css .= "width: {$nav_logo_width}px;\n";
                $custom_css .= "height: {$nav_logo_height}px;\n";
            $custom_css .= "}\n";
        $custom_css .= "}\n";
        $custom_css .= "@media (min-width: 992px) {\n";
            $custom_css .= ".site-header {\n";
                $custom_css .= "padding-top: 0;\n";
            $custom_css .= "}\n";
            $custom_css .= "body.fixed-nav .site-header {\n";
                $custom_css .= "padding-top: {$site_desktop_header_home_padding}px;\n";
            $custom_css .= "}\n";
        $custom_css .= "}\n";
    $custom_css .= "</style>\n";

    $body_class = array();
    if (!$front_page) $body_class[] = "fixed-nav";

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php language_attributes(); ?> class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html <?php language_attributes(); ?> class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html <?php language_attributes(); ?> class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html <?php language_attributes(); ?> class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <title><?php wp_title( ' | ', true, 'right' ); ?></title>

        <?php wp_head(); ?>

        <?php echo $custom_css; ?>
    </head>

    <body <?php body_class($body_class); ?>>
        <div class="site-wrapper">
            <header class="site-header">
                <?php get_template_part("tastelv-hero"); ?>
                <nav class="site-navigation">
                    <div class="container-fluid constrained site-navigation-inner">
                        <a href="<?php home_link(true); ?>" title="<?php echo $logo_attr; ?>" class="home-link">
                            <?php echo $nav_logo_html; ?>
                        </a>
                        <div class="menu-container">
                            <div class="menu-toggler"><span class="visuallyhidden">Menu</span></div>
                            <div class="menu-wrapper">
                                <?php wp_nav_menu( array(
                                    "theme_location"    => "main-menu",
                                    "container"         => false
                                ) ); ?>
                                <?php echo $nav_button_html; ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
