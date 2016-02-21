<?php

	$bfblFooter = '';


	$bfblFooter = '<div class="row footerRowOne">';
		// about bfbl
		$bfblAboutTitle = get_field('footer_about_title', 'option');
		$bfblAboutContent = get_field('footer_about_content', 'option');

		$bfblFooter .= "<section class='footerAbout col-xs-12 col-sm-4 col-md-4 col-lg-5'>";
			if($bfblAboutTitle) {
				$bfblFooter .= "<h3>$bfblAboutTitle</h3>";
			}
			if($bfblAboutContent) {
				$bfblFooter .= "<p>$bfblAboutContent</p>";
			}

//			$bfblFooter .= "<h1>Wholesale Link goes here</h1>";

		$bfblFooter .= "</section><!-- end section.footerAbout -->";

		// build the footer menus manually
		$bfblFooterNav = array();
		$bfblFooterMenuName = 'footer-menu';
		if (( $locations = get_nav_menu_locations() ) && isset($locations[$bfblFooterMenuName]) ) {
			$bfblFooterMenu = wp_get_nav_menu_object( $locations[$bfblFooterMenuName] );
			$bfblFooterMenuObjects = wp_get_nav_menu_items($bfblFooterMenu->term_id);

			foreach($bfblFooterMenuObjects as $thisObject) {

				// is this a parent or a child menu item?
				if($thisObject->menu_item_parent == 0) {
					// if it's a parent ...

						$parentID = $thisObject->ID; // this is the parent's MENU ITEM id, not the post id
						$parentName = $thisObject->title;

						$bfblFooterNav[$parentID] = array(
							'name' => $thisObject->title,
							'children' => array()
						);

				} else {
					// if it's a child ...

					$theParent = $thisObject->menu_item_parent; // this is the parent's MENU ITEM id, not the post id

					if(isset($bfblFooterNav[$theParent])) {
						// proceed only if we've already found the parent

						$thisMenuItem = array();
						$thisMenuItem['text'] = $thisObject->title;
						$thisMenuItem['url'] = $thisObject->url;

						$bfblFooterNav[$theParent]['children'][] = $thisMenuItem;

					} // end the have-we-found-the-parent-yet test
				} // end the child-or-parent test
			} // end the $bfblFooterMenuObjects foreach
		} // end the does-this-menu-exist test

		$j = 1;
		foreach ($bfblFooterNav as $thisColumn) {
			if($j < 3) { // ensure there are never more than two columns

				$bfblFooter .= "<section class='footerNav footerNav-$j col-xs-12 col-sm-3 col-md-3 col-lg-2'>";
					if(isset($thisColumn['name'])) {
						$bfblFooter .= "<h3>{$thisColumn['name']}</h3>";
					}

					if(isset($thisColumn['children'])) {
						$bfblFooter .= "<nav>";
							$bfblFooter .= "<ul>";
								foreach ($thisColumn['children'] as $thisChild) {
									$bfblFooter .= "<li>";
										$bfblFooter .= "<a href='{$thisChild['url']}'>{$thisChild['text']}</a>";
									$bfblFooter .= "</li>";
								}

								// ALSO: if the user is logged in, AND if this is the second column,
								// add a 'My Account' link
								if($j==2 && is_user_logged_in()) {
									$bfblFooter .= "<li>";
										$bfblFooter .= "<a href='". get_edit_user_link() . "'>My Account</a>";
									$bfblFooter .= "</li>";
								}


							$bfblFooter .= "</ul>";
						$bfblFooter .= "</nav>";
					}

				$bfblFooter .= "</section><!-- end section.footerNav -->";
			} // end the test to exclude third columns
			$j++;
		} // end the $bfblFooterNav foreach

		// social media links
		$bfblSocTwitter = get_field('business_twitter', 'option');
		$bfblSocFacebook = get_field('business_facebook', 'option');
		$bfblSocYoutube = get_field('business_youtube', 'option');
		$bfblSocInstagram = get_field('business_instagram', 'option');


		$bfblFooter .= "<section class='footerSocial col-xs-12 col-sm-2 col-md-2 col-lg-3'>";
			$bfblFooter .= "<h3>Connect</h3>";
			$bfblFooter .= "<nav>";
				$bfblFooter .= "<ul>";

						if($bfblSocTwitter) {

							$bfblFooter .= "<li class='twitter'>";
								$bfblFooter .= "<a href='https://twitter.com/{$bfblSocTwitter}' target='_blank'>";
									$bfblFooter .= "<span>@{$bfblSocTwitter}</span>";
								$bfblFooter .= "</a>";
							$bfblFooter .= "</li>";

						}

						if($bfblSocFacebook) {

							$facebookPageName = bfblExtractName($bfblSocFacebook);

							$bfblFooter .= "<li class='facebook'>";
								$bfblFooter .= "<a href='{$bfblSocFacebook}' target='_blank'>";
									$bfblFooter .= "<span>$facebookPageName</span>";
								$bfblFooter .= "</a>";
							$bfblFooter .= "</li>";

						}

						if($bfblSocYoutube) {

							$youtubeName = bfblExtractName($bfblSocYoutube);

							$bfblFooter .= "<li class='youtube'>";
								$bfblFooter .= "<a href='{$bfblSocYoutube}' target='_blank'>";
									$bfblFooter .= "<span>$youtubeName</span>";
								$bfblFooter .= "</a>";
							$bfblFooter .= "</li>";

						}

						if($bfblSocInstagram) {

							$bfblFooter .= "<li class='instagram'>";
								$bfblFooter .= "<a href='https://www.instagram.com/{$bfblSocInstagram}' target='_blank'>";
									$bfblFooter .= "<span>@{$bfblSocInstagram}</span>";
								$bfblFooter .= "</a>";
							$bfblFooter .= "</li>";

						}

				$bfblFooter .= "</ul>";
			$bfblFooter .= "</nav>";
		$bfblFooter .= "</section><!-- end section.footerSocial -->";


	$bfblFooter .= '</div><!-- end div.footerRowOne -->';
	$bfblFooter .= '<div class="row footerRowTwo">';

		$bfblFooter .= "<div class='footerContact col-xs-12 col-sm-6 col-md-6'>";
			$bfblFooter .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="footerHomeLink">';
				$bfblFooter .= esc_html( get_bloginfo( 'name' ) );
			$bfblFooter .= '</a><!-- end a.footerHomeLink -->';

			$bfblAddr1 = get_field('business_street_address', 'option');
			$bfblAddr2 = get_field('business_street_address_2', 'option');
			$bfblAddrCity = get_field('business_city', 'option');
			$bfblAddrState = get_field('business_state', 'option');
			$bfblAddrZip = get_field('business_zip', 'option');
			$bfblPhone = get_field('business_phone', 'option');
			$bfblEmail = get_field('business_email', 'option');

			if($bfblAddr1 && $bfblAddrCity && $bfblAddrState && $bfblAddrZip) {
				$bfblFooter .= "<div class='footerAddress'>";
					$bfblFooter .= $bfblAddr1 . ' ';
					if($bfblAddr2) {
						$bfblFooter .= $bfblAddr2 . ' ';
					}
					$bfblFooter .= "$bfblAddrCity $bfblAddrState $bfblAddrZip";
				$bfblFooter .= "</div>";
			} // end the are-the-address-values-set test

			if($bfblPhone && $bfblEmail) {
				$bfblFooter .= "<div class='footerPhoneEmail'>";

					$bfblFooter .= "<span class='footerPhone'>";
						$bfblFooter .= $bfblPhone;
					$bfblFooter .= "</span>";

					$bfblFooter .= "<span class='footerEmail'>";
						$bfblFooter .= "<a href='mailto:{$bfblEmail}'>";
							$bfblFooter .= $bfblEmail;
						$bfblFooter .= "</a>";
					$bfblFooter .= "</span>";

				$bfblFooter .= "</div>";
			} // end the are-the-phone-and-email-values-set test

		$bfblFooter .= "</div><!-- end div.footerContact -->";

		$bfblFooter .= "<div class='footerCredits col-xs-12 col-sm-6 col-md-6'>";
			$bfblFooter .= "<div class='copyright'>&copy; " . date('Y') . ' Buy Fresh Buy Local of the Greater Lehigh Valley.';
			$bfblFooter .= "<span class='hideBreak'><br /></span>";
			$bfblFooter .= "All Rights Reserved.</div>";
			$bfblFooter .= "<div class='credit'>";
			$bfblFooter .= "Made in the wild by ";
			$bfblFooter .= "<a href='http://wearekudu.com/' target='_blank'>Kudu</a>";
			$bfblFooter .= "</div>";
		$bfblFooter .= "</div><!-- end div.footerCredits -->";

	$bfblFooter .= '</div><!-- end div.footerRowTwo -->';


	$loginArgs = array(
		'echo'	=> FALSE,
		'redirect' => site_url('/wp-admin/profile.php'), // documentation: https://codex.wordpress.org/Function_Reference/wp_login_form
	);
	$bfblLogin = wp_login_form($loginArgs);

	// add a span to the 'remember me'
	$bfblLogin = str_replace(' Remember Me', '<span>Remember me</span>', $bfblLogin);



?>
            <footer id="bfblFooter" class="footer container-fluid" role="contentinfo">
                <?php echo $bfblFooter; ?>
            </footer>

        </div><!-- END: .site-wrapper -->

        <div class="bfblLightboxes">
        	<div id="loginLB">
        		<h3>Partner Login</h3>
        		<?php echo $bfblLogin ?>
        	</div><!-- end div#loginLB -->
         	<div id="newsletterLB">
        		<h3>Sign up for<br />our newsletter</h3>
        		<form name="ccoptin" id="form-ccsignup" action="http://visitor.constantcontact.com/d.jsp" method="post" target="_blank">
					<fieldset class="input">
						<input type="hidden" name="m" value="1102172366972"><input type="hidden" name="p" value="oi" />
						<div class="nlEmail">
							<label for="ea">Enter your email address</label>
							<input type="text" name="ea" id="ea" size="25" class="text" placeholder="Enter your email address" value="" />
						</div><!-- end div.nlEmail -->
						<div class="nlSubmit">
							<input type="submit" name="Sign Up" class="bfblButtonLink" value="Sign Up" />
						</div><!-- end div.nlSubmit -->
					</fieldset>
				</form>


        	</div><!-- end div#newsletterLB -->
        </div><!-- end div.bfblLightboxes -->
        <?php wp_footer(); ?>
    </body>
</html>