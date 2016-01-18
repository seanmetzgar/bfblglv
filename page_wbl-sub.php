<?php
/**
 * Template Name: Why Buy Local (Child)
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					$has_video = get_field("has_video");
					$has_video = is_bool($has_video) ? $has_video : false;
					$video = $has_video ? get_field("video") : false;
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "parent-header"); ?>

					<section class="entry-content<?php if ($has_video) echo " has-video"; ?>">
						<?php if ($has_video): ?>
						<div class="video">
							<?php echo $video; ?>
						</div>
						<?php endif; ?>
						<h1><?php the_title(); ?></h1>
						<?php edit_post_link(); ?>
						<?php the_content(); ?>
					</section>

					<?php get_template_part("bfbl", "page-blocks"); ?>
				</article>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>