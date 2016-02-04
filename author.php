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
					$current_partner_ID = $current_partner->ID;
					$acf_partner_id = "user_{$current_partner_ID}";

					$partner_map = get_field("partner_map", $acf_partner_id);
					$partner_name = get_field("partner_name", $acf_partner_id);
					$partner_name = strlen($partner_name) > 0 ? $partner_name : $current_partner->display_name;

					$partner_bio = get_field("partner_description", $acf_partner_id);
					$partner_bio = strlen($partner_bio) > 0 ? $partner_bio : false;
					
					
				?>
				<article id="partner-<?php the_ID(); ?>" class="partner-profile">
					<?php //get_template_part("entry", "parent-header"); ?>
					<?php if( !empty($partner_map) ): ?>
					<div class="acf-map-wrapper"><div class="acf-map">
						<div class="marker" data-lat="<?php echo $location['partner_map']; ?>" data-lng="<?php echo $partner_map['lng']; ?>"></div>
					</div></div>
					<?php endif; ?>
					
					<section class="entry-content">
						
						<h1 class="entry-title"><?php echo $partner_name; ?></h1>
						<?php if ($partner_bio): ?>
						<div class="partner-description">
							<?php echo $partner_bio; ?>
						</div>
						<?php endif; ?>
						
						
						
						Content area
					</section>

				</article>
			</section>
<?php get_footer(); ?>