<?php
/**
 * Template Name: About (Parent)
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					$show_mission = get_field("show_mission");
					$show_mission = is_bool($show_mission) ? $show_mission : false; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>

					<?php if ($show_mission): ?>
					<section class="mission-statement">
						<div class="content">
							<h2><?php the_field("mission_title"); ?></h2>
							<?php the_field("mission_text"); ?>
						</div>
					</section>
					<?php endif; ?>

					<section class="entry-content">
						<?php the_content(); ?>
					</section>
				</article>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>