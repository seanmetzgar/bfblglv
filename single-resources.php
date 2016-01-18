<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					$has_post_thumbnail = has_post_thumbnail();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "resources-header"); ?>

					<section class="entry-content<?php if ($has_post_thumbnail) echo " has-image"; ?>">
						<h1><?php the_title(); ?></h1>
						<p class="post-meta">
							<span class="date"><?php the_field("event_date"); ?></span>
						</p>
						<?php edit_post_link(); ?>
						<?php if ($has_post_thumbnail): ?>
						<div class="image">
							<?php the_post_thumbnail("full", array("class" => "img-responsive")); ?>
						</div>
						<?php endif; ?>
						<?php the_content(); ?>

						<?php if (have_rows("downloads")): while (have_rows("downloads")): the_row();
							echo "<pre>" . print_r(get_sub_field("file"), TRUE) . "</pre>";

						endwhile; endif; ?>
					</section>

					<?php get_template_part("bfbl", "page-blocks"); ?>
				</article>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>