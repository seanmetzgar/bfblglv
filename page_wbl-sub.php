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

					$page_icon = get_field('page_icon'); // if the page does not have this field, get_field() will return an empty string

					$contentClasses = array();
					$contentClasses[] = 'entry-content';
					if($has_video) {
						$contentClasses[] = 'has-video';
					}
					if($page_icon && $page_icon != 'none') {
						$contentClasses[] = 'has-icon';
						$contentClasses[] = "icon-$page_icon";
					}

					$contentClass = implode(' ', $contentClasses);


				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "parent-header"); ?>

					<section class="<?php echo $contentClass; ?>">

						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php // edit_post_link(); ?>

						<?php if ($has_video): ?>
						<div class="video">
							<div class="videoWrap">
								<?php echo $video; ?>
							</div><!-- end div.videoWrap -->
						</div><!-- end div.video -->
						<?php endif; ?>

						<?php the_content(); ?>
						<?php get_template_part("bfbl", "gallery"); ?>
					</section>

					<?php get_template_part("bfbl", "page-blocks"); ?>
				</article>
				<?php get_template_part("bfbl", "chips"); ?>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>