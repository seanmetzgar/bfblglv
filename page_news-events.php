<?php
/**
 * Template Name: News & Events (Archives)
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>
					
					<section class="page-block image-split tan-shadow news-events-top">
						<div class="image"><!-- nothing here --></div>
						<div class="content">
							<h2>
								<span class="left-text">News</span>
								<span class="right-text">Events</span>
							</h2>
						</div>
					</section>
					
					<?php	
						$bfblPageContent = get_the_content();
						if($bfblPageContent) {
							echo '<section class="entry-content">';
								the_content();
							echo '</section>';
						}
					?>
				</article>
				<?php endwhile; endif; ?>
				<?php get_template_part("bfbl", "news-events-list"); ?>
			</section>
<?php get_footer(); ?>