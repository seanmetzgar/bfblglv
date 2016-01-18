<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "news-events-header"); ?>

					<section class="entry-content">
						<h1><?php the_title(); ?></h1>
						<?php edit_post_link(); ?>
						<?php the_content(); ?>
					</section>

					<?php get_template_part("bfbl", "page-blocks"); ?>
				</article>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>