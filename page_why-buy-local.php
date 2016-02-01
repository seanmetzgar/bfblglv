<?php
/**
 * Template Name: Why Buy Local (Parent)
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					$wbl_subtitle = get_field("subtitle");
					$wbl_subtitle = strlen($wbl_subtitle) > 0 ? $wbl_subtitle : false; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>

					<?php if ($wbl_subtitle): ?>
					<section class="subtitle wbl-subtitle">
						<div class="content">
							<h2><?php echo $wbl_subtitle; ?></h2>
						</div>
					</section>
					<?php endif; ?>

					<section class="entry-content">
						<?php the_content(); ?>
					</section>

					<?php get_template_part("bfbl", "page-blocks"); ?>
				</article>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>