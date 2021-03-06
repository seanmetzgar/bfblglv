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

					<section class="entry-content<?php if (false) echo " has-image"; ?>">
						<h1 class="entry-title"><?php the_title(); ?></h1>

						<?php // edit_post_link(); ?>
						<?php if (false): ?>
						<div class="image resourceImage">
							<?php the_post_thumbnail("full", array("class" => "img-responsive")); ?>
						</div>
						<?php endif; ?>
						<?php the_content(); ?>

						<?php if (have_rows("downloads")):
						echo "<h2 class='resourceSubhead'>Downloads</h2>";
						while (have_rows("downloads")): the_row();
							$file = get_sub_field("file");
							$filesize = filesize( get_attached_file( $file["ID"] ) );
							$filesize = size_format($filesize, 2);
						?>
						<a href="<?php echo $file["url"]; ?>" class="resourceDownload bfblButtonLink btnBlue">
							<span class="filename"><?php echo $file["filename"]; ?></span>
							<span class="filesize">File Size: <span><?php echo $filesize; ?></span></span>
						</a>
						<?php endwhile; endif; ?>
					</section>

					<?php get_template_part("bfbl", "page-blocks"); ?>
				</article>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>