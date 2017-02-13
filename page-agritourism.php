<?php
/**
 * Template Name: Agritourism Landing Page
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.6.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					$has_video = get_field("has_video");
					$has_video = is_bool($has_video) ? $has_video : false;
					$video = $has_video ? get_field("video") : false; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>

					<section class="row entry-content<?php if ($has_video) echo " has-video"; ?>">
						<div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1">
							<?php if ($has_video): ?>
							<div class="video">
								<div class="videoWrap">
									<?php echo $video; ?>
								</div><!-- end div.videoWrap -->
							</div><!-- end div.video -->
							<?php endif; ?>
							<?php the_content(); ?>
						</div>
					</section>
					<?php get_template_part("bfbl", "page-blocks"); ?>
				</article>
				<?php endwhile; endif; ?>
			</section>


<?php get_footer(); ?>