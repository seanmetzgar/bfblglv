<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary site-header">
        <a class="navbar-brand" href="/">
            <img src="<?php echo get_template_directory_uri(); ?>/img/logos/bucks_logo.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
           wp_nav_menu([
             'theme_location'  => 'main-menu',
             'container'       => 'div',
             'container_id'    => 'bs4navbar',
             'container_class' => 'collapse navbar-collapse',
             'menu_id'         => false,
             'menu_class'      => 'navbar-nav ml-auto',
             'depth'           => 2,
             'fallback_cb'     => 'bs4navwalker::fallback',
             'walker'          => new bs4navwalker()
           ]);
        ?>
        <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'menu_class' =>'navbar-nav ml-auto', 'container' => false ) ); ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Locations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">How it Works</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Resources</a>
                </li>
            </ul>
        </div> -->
    </nav>

    <div id="container">
