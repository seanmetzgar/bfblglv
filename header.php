<?php $front_page = (is_front_page()) ? true : false; ?><!DOCTYPE html>
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

        <link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/b61b7b61-c691-48ed-9943-b6e4a68f75f1.css">
        <link type="text/css" rel="stylesheet" href="<?php relative_template_path(true); ?>/fonts/clear_sans/font.css">

        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div class="container-fluid site-wrapper">
            