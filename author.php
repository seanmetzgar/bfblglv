<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php
					$current_partner = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

					print_r($current_partner->ID);
					
					$contentClasses = array();
					$contentClasses[] = 'entry-content';
					$contentClasses[] = 'partner-content'
					
					$contentClasses = implode(' ', $contentClasses);
					
				?>
				<article id="partner-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php //get_template_part("entry", "parent-header"); ?>

					<section class="<?php echo $contentClass; ?>">
						
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php // edit_post_link(); ?>
						
						
						
						Content area
					</section>

				</article>
			</section>
<?php get_footer(); ?>