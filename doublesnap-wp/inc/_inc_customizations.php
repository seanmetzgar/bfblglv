<?php
function tastelv_theme_customizer($wp_customize) {
    $template_path = relative_template_path();

    /** Header Options **/
    $wp_customize->add_section("site_hero_section", array(
        "title"             => __("Hero Header", "tastelv"),
        "priority"          => 30,
        "description"       => __("Add header details.", "tastelv")
    ));
    $wp_customize->add_setting("hero_logo", array(
        "default"           => "$template_path/images/logo/logo-taste-brown.png"
    ));
    $wp_customize->add_setting("hero_logo_width", array(
        "default"           => "424"
    ));
    $wp_customize->add_setting("hero_logo_height", array(
        "default"           => "133"
    ));
    $wp_customize->add_setting("hero_left_a", array(
        "default"           => ""
    ));
    $wp_customize->add_setting("hero_left_b", array(
        "default"           => ""
    ));
    $wp_customize->add_setting("hero_right_a", array(
        "default"           => ""
    ));
    $wp_customize->add_setting("hero_right_b", array(
        "default"           => ""
    ));
    $wp_customize->add_setting("hero_right_c", array(
        "default"           => ""
    ));
    $wp_customize->add_setting("hero_right_d", array(
        "default"           => ""
    ));

    $wp_customize->add_setting("hero_host_text", array(
        "default"           => "Hosted By"
    ));
    $wp_customize->add_setting("hero_sponsor_text", array(
        "default"           => "Presented By"
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_logo", array(
        "label"             => __("Hero Logo", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_logo"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "hero_logo_width", array(
        "label"             => __("Hero Logo Width", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_logo_width",
        "type"              => "number"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "hero_logo_height", array(
        "label"             => __("Hero Logo Height", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_logo_height",
        "type"              => "number"
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_left_a", array(
        "label"             => __("Hero Image: Left A", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_left_a"
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_left_b", array(
        "label"             => __("Hero Image: Left B", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_left_b"
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_right_a", array(
        "label"             => __("Hero Image: Right A", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_right_a"
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_right_b", array(
        "label"             => __("Hero Image: Right B", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_right_b"
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_right_c", array(
        "label"             => __("Hero Image: Right C", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_right_c"
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_right_d", array(
        "label"             => __("Hero Image: Right D", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_right_d"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "hero_host_text", array(
        "label"             => __("Host Text", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_host_text",
        "type"              => "text"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "hero_sponsor_text", array(
        "label"             => __("Sponsor Text", "tastelv"),
        "section"           => "site_hero_section",
        "settings"          => "hero_sponsor_text",
        "type"              => "text"
    )));

    /** Branding Options **/
    $wp_customize->add_section("site_nav_section", array(
        "title"             => __("Navigation Bar", "tastelv"),
        "priority"          => 30,
        "description"       => __("Set navigation bar options.", "tastelv")
    ));

    $wp_customize->add_setting("nav_logo", array(
        "default"           => "$template_path/images/logo/logo-taste-white.png"
    ));
    $wp_customize->add_setting("nav_logo_width", array(
        "default"           => "170"
    ));
    $wp_customize->add_setting("nav_logo_height", array(
        "default"           => "53"
    ));
    $wp_customize->add_setting("nav_button_text", array(
        "default"           => "Tasting Room\nTickets"
    ));
    $wp_customize->add_setting("nav_button_url", array(
        "default"           => ""
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "site_logo", array(
        "label"             => __("Navigation Logo", "tastelv"),
        "section"           => "site_nav_section",
        "settings"          => "nav_logo"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "site_logo_width", array(
        "label"             => __("Navigation Logo Width", "tastelv"),
        "section"           => "site_nav_section",
        "settings"          => "nav_logo_width",
        "type"              => "number"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "site_logo_height", array(
        "label"             => __("Navigation Logo Height", "tastelv"),
        "section"           => "site_nav_section",
        "settings"          => "nav_logo_height",
        "type"              => "number"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "nav_button_text", array(
        "label"             => __("Navigation Button Text (max 2 lines)", "tastelv"),
        "section"           => "site_nav_section",
        "settings"          => "nav_button_text",
        "type"              => "textarea"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "nav_button_url", array(
        "label"             => __("Navigation Button URL", "tastelv"),
        "section"           => "site_nav_section",
        "settings"          => "nav_button_url",
        "type"              => "url"
    )));

    /** Footer Options **/
    $wp_customize->add_section("site_footer_section", array(
        "title"             => __("Footer", "tastelv"),
        "priority"          => 31,
        "description"       => __("Set footer options.", "tastelv")
    ));
    $wp_customize->add_setting("footer_about_heading", array(
        "default"           => "About [TASTE]"
    ));
    $wp_customize->add_setting("footer_about_text", array(
        "default"           => ""
    ));
    $wp_customize->add_setting("footer_instagram_heading", array(
        "default"           => "Instagram"
    ));
    $wp_customize->add_setting("footer_instagram_hashtag", array(
        "default"           => ""
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "footer_about_heading", array(
        "label"             => __("About Section Heading", "tastelv"),
        "section"           => "site_footer_section",
        "settings"          => "footer_about_heading",
        "type"              => "text"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "footer_about_text", array(
        "label"             => __("About Section Heading", "tastelv"),
        "section"           => "site_footer_section",
        "settings"          => "footer_about_text",
        "type"              => "textarea"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "footer_instagram_heading", array(
        "label"             => __("Instagram Heading", "tastelv"),
        "section"           => "site_footer_section",
        "settings"          => "footer_instagram_heading",
        "type"              => "text"
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "footer_instagram_hashtag", array(
        "label"             => __("Instagram Hashtag (Blank = Default Settings)", "tastelv"),
        "section"           => "site_footer_section",
        "settings"          => "footer_instagram_hashtag",
        "type"              => "text"
    )));
}

function tastelv_pre_get_posts($query) {
    if ($query->is_main_query() && $query->is_post_type_archive("shop") && !is_admin())
        $query->set("posts_per_page", -1);
}

add_action("customize_register", "tastelv_theme_customizer");
add_action('pre_get_posts', 'tastelv_pre_get_posts');