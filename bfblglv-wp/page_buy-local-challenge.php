<?php
/**
 * Template Name: Buy Local Challenge
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.3.0
 */
get_header();
?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>

					<section class="entry-content">
						<?php the_content(); ?>
					</section>

					<?php
						$blc_shortcode = get_field("blc_shortcode");
						if ($blc_shortcode) echo do_shortcode($blc_shortcode);

						$blc_social_content = get_field("blc_social_content");
						$bfblSocTwitter = get_field('business_twitter', 'option');
						$bfblSocFacebook = get_field('business_facebook', 'option');
						$bfblSocYoutube = get_field('business_youtube', 'option');
						$bfblSocInstagram = get_field('business_instagram', 'option');
						$blc_social = "";
					?>

					<section class="entry-content blc-social-content">
						<?php echo $blc_social_content; ?>
						<ul class="blc-social">
							<?php

							if($bfblSocTwitter) {

								$blc_social .= "<li class='twitter'>";
									$blc_social .= "<a href='https://twitter.com/{$bfblSocTwitter}' target='_blank'>";
										$blc_social .= "<span>Twitter</span>";
									$blc_social .= "</a>";
								$blc_social .= "</li>";

							}

							if($bfblSocFacebook) {

								$facebookPageName = bfblExtractName($bfblSocFacebook);

								$blc_social .= "<li class='facebook'>";
									$blc_social .= "<a href='{$bfblSocFacebook}' target='_blank'>";
										$blc_social .= "<span>Facebook</span>";
									$blc_social .= "</a>";
								$blc_social .= "</li>";

							}

							// if($bfblSocYoutube) {

							// 	$youtubeName = bfblExtractName($bfblSocYoutube);

							// 	$blc_social .= "<li class='youtube'>";
							// 		$blc_social .= "<a href='{$bfblSocYoutube}' target='_blank'>";
							// 			$blc_social .= "<span>$youtubeName</span>";
							// 		$blc_social .= "</a>";
							// 	$blc_social .= "</li>";

							// }

							if($bfblSocInstagram) {

								$blc_social .= "<li class='instagram'>";
									$blc_social .= "<a href='https://www.instagram.com/{$bfblSocInstagram}' target='_blank'>";
										$blc_social .= "<span>Instagram</span>";
									$blc_social .= "</a>";
								$blc_social .= "</li>";

							}
							echo $blc_social;
						?>
						</ul>
					</section>


				</article>
				<?php endwhile; endif; ?>
			</section>


<?php get_footer(); ?>