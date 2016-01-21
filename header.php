<?php
	error_reporting(E_ALL);
	
	$front_page = (is_front_page()) ? true : false; 
	
	$bfblPageID = 0;
	$bfblAncestry = array();
	
	if(is_page()) {
		
		$bfblPageID = get_queried_object_id();
		$bfblAncestors = get_ancestors($bfblPageID, 'page');
	
		$bfblAncestry = array_merge($bfblAncestors,array($bfblPageID));

	}
	
	// build the contents of the menu bar / drawer
	$bfblMenuDrawer = '';
	
	$bfblMenuDrawer .= "<div class='drawerTop'>";
	
		$bfblMenuDrawer .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="drawerHomeLink">';
			$bfblMenuDrawer .= esc_html( get_bloginfo( 'name' ) );
		$bfblMenuDrawer .= '</a><!-- end a.drawerHomeLink -->';
	
		$bfblMenuDrawer .= '<button id="bfblMenuClose">Close Menu</button>';
	
	$bfblMenuDrawer .= "</div><!-- div.drawerTop -->";
	
	// manually build the menu
	$bfblMainNav = array();
	$bfblMenuName = 'main-menu';
	if (( $locations = get_nav_menu_locations() ) && isset($locations[$bfblMenuName]) ) {
		$bfblMainMenu = wp_get_nav_menu_object( $locations[$bfblMenuName] );
		$bfblMenuObjects = wp_get_nav_menu_items($bfblMainMenu->term_id);
			
		foreach($bfblMenuObjects as $thisObject) {
				
			// is this a parent or a child menu item?
			if($thisObject->menu_item_parent == 0) {
				// proceed only if this is a top-level menu item
	
					$menuID = $thisObject->ID; // this is the MENU ITEM id, not the post id
					$menuPageID = 0;
					
					if($thisObject->object == 'page') {
						$menuPageID = $thisObject->object_id;
					}
						
					$bfblMainNav[$menuID] = array(
						'name' => $thisObject->title,
						'pageID' => $menuPageID,
						'url' => $thisObject->url,
					);
	
			} // end the child-or-parent test
		} // end the $bfblFooterMenuObjects foreach
	} // end the does-this-menu-exist test 	
	
	$bfblMainNavCount = count($bfblMainNav);
	$shadeMultiplier = 1/($bfblMainNavCount+1);
	
	$k = 1;
	
	$bfblMenuDrawer .= "<nav role='navigation'>";
		$bfblMenuDrawer .= "<div class='menu-{$bfblMenuName}-container drawerNav'>";
			$bfblMenuDrawer .= "<ul class='menuColumn'>";
			
				foreach($bfblMainNav as $thisItem) {
					
					$shadeOpacity = $k * $shadeMultiplier;
					
					$currentPage = '';
					
					if(in_array($thisItem['pageID'], $bfblAncestry)) {
						$currentPage = ' currentPage';
					}
					
					$bfblMenuDrawer .= "<li class='menu-item menu-item-{$thisItem['pageID']}$currentPage'>";
						$bfblMenuDrawer .= "<a href='{$thisItem['url']}'>";
							$bfblMenuDrawer .= "<span class='shade' style='opacity: $shadeOpacity'><!-- nothing here --></span>";
							$bfblMenuDrawer .= $thisItem['name'];
						$bfblMenuDrawer .= "</a>";
					$bfblMenuDrawer .= "</li>";

					// insert a column break at the right spot
					if($k>=($bfblMainNavCount/2) && $k<(1+ $bfblMainNavCount/2)) {
			$bfblMenuDrawer .= "</ul><!-- ul.menuColumn -->";
			$bfblMenuDrawer .= "<ul class='menuColumn'>";			
					}

					$k++;
				} // end $bfblMainNav foreach
				
			$bfblMenuDrawer .= "</ul><!-- end ul.menuColumn -->";
		$bfblMenuDrawer .= "</div><!-- end div.drawerNav -->";
	$bfblMenuDrawer .= "</nav>";
	
	$bfblMenuDrawer .= "<div class='drawerLogin'>";	
		$bfblMenuDrawer .= '<button class="buttonLogin bfblButtonLink">Login</button>';
	$bfblMenuDrawer .= "</div><!-- div.drawerLogin -->";
	$bfblMenuDrawer .= "<div class='drawerNewsletter'>";	
		$bfblMenuDrawer .= '<button class="buttonNewsletter bfblButtonLink">Newsletter</button>';
	$bfblMenuDrawer .= "</div><!-- div.drawerNewsletter -->";
	
	$bfblMenuDrawer .= "<div class='drawerSearch'>";
		$bfblMenuDrawer .= "<div class='searchBtnWrap'>";
			$bfblMenuDrawer .= '<button class="buttonSearch">Find</button>';
		$bfblMenuDrawer .= "</div><!- end div.searchBtnWrap -->";
		$bfblMenuDrawer .= "<div class='searchFormWrap'>";
			$bfblMenuDrawer .= get_search_form(FALSE);
		$bfblMenuDrawer .= "</div><!- end div.searchBtnWrap -->";
	$bfblMenuDrawer .= "</div><!-- div.drawerSearch -->";
	
	
	
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

        <!-- begin wp_head() -->
        <?php wp_head(); ?>
        <!-- end wp_head() -->
        
    </head>

    <body <?php body_class(); ?>>
    	<div id="bfblDrawerWrap" class="menuActive">
	    	<div id="bfblMenuDrawer">
	    		<?php echo $bfblMenuDrawer; ?>
	    	</div><!-- end div.#bfblMenuDrawer -->
	    </div><!-- end div.#bfblDrawerWrap -->
    	<div id="bfblMenuOverlay" class="menuActive"><!-- nothing here --></div>
    	
        <div class="container-fluid site-wrapper">
            <header class="site-header">

                <div class="home-link">
                    <?php
                        $header_title_tag =     ($front_page) ? "h1" : "p";
                        $header_title =         get_bloginfo("name");
                        $header_title_attr =    esc_attr($header_title);
						$header_home_link =		esc_url( home_url( '/' ) );
                    ?>
                    <<?php echo $header_title_tag; ?>><a href="<?php echo $header_home_link; ?>" title="<?php echo $header_title_attr; ?>" rel="home"><?php echo $header_title; ?></a></<?php echo $header_title_tag; ?>>
                </div>
                
                <button id="bfblMenuBtn">Menu</button>

            </header>