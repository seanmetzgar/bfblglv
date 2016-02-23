<?php get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					$has_video = get_field("has_video");
					$has_video = is_bool($has_video) ? $has_video : false;
					$video = $has_video ? get_field("video") : false;
					$upper_gallery = (!$has_video) ? get_field("upper_gallery") : false;
					$upper_gallery = is_bool($upper_gallery) ? $upper_gallery : false; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>

					<section class="entry-content<?php if ($has_video) echo " has-video"; ?>">
						<?php if ($has_video): ?>
						<div class="video">
							<div class="videoWrap">
								<?php echo $video; ?>
							</div><!-- end div.videoWrap -->
						</div><!-- end div.video -->
						<?php elseif ($upper_gallery):
							get_template_part("bfbl", "gallery");
						endif;

						the_content();
						if (!$upper_gallery) get_template_part("bfbl", "gallery"); ?>
					</section>
					<?php get_template_part("bfbl", "page-blocks"); ?>
				</article>
				<?php endwhile; endif; ?>
			</section>


<?php get_footer(); ?>