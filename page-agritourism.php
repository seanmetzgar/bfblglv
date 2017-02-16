<?php
/**
 * Template Name: Agritourism Landing Page
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.6.0
 */
get_header();
	$partners_args = array(
		"role__in" 		=> array("farm", "distillery", "vineyard", "specialty"),
		"meta_key" 		=> "is_agritourism",
		"meta_value" 	=> "1"
	);
	$partners_query = new WP_User_Query($partners_args);
	$partners = $partners_query->get_results();
?>
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

					<?php if (!empty($partners)): ?>
					<section class="page-block odd partners-block">
						<ul class="partners-list row">
							<?php foreach ($partners as $partner): 
								$partner_ID 	= $partner->ID;
								// $partner_data = get_userdata($partner_ID);
								$acf_partner_id = "user_{$partner_ID}";
								$partner_url 	= get_author_posts_url($partner_ID);
								$partner_name 	= get_field("partner_name", $acf_partner_id);
								$partner_name 	= strlen($partner_name) > 0 ? 
												$partner_name : 
												$partner->display_name;
								//Images
									//Logo
								$partner_logo 	= get_field("logo", $acf_partner_id);
								$partner_logo  	= is_array($partner_logo) ? 
												wp_get_attachment_image_src($partner_logo["ID"], "full") :
												false;
									//Owner
								$partner_owner_photo = get_field("owner_photo", $acf_partner_id);
								if (is_array($partner_owner_photo)) {
									$partner_owner_photo = wp_get_attachment_image_src($partner_owner_photo["ID"], "full");
								} elseif (is_string($partner_owner_photo) && strlen($partner_owner_photo) > 0) {
									$partner_owner_photo = $partner_owner_photo;
								} else { $partner_owner_photo = false; }
									//Business
								$partner_business_photo = get_field("business_photo", $acf_partner_id);
								if (is_array($partner_business_photo)) {
									$partner_business_photo = wp_get_attachment_image_src($partner_business_photo["ID"], "full");
								} elseif (is_string($partner_business_photo) && strlen($partner_business_photo) > 0) {
									$partner_business_photo = $partner_business_photo;
								} else { $partner_business_photo = false; }

								$partner_image = ($partner_logo) ? $partner_logo : (
												 ($partner_business_photo) ? $partner_business_photo : (
												 ($partner_owner_photo) ? $partner_owner_photo : false ));
							?>
							<li class="col-md-3 col-sm-6"><a href="<?php echo $partner_url; ?>" title="<?php echo $partner_name; ?>">
								<?php if ($partner_image): ?>
								<figure class="image" style="background-image: url('<?php echo $partner_image; ?>');">
									<span><?php echo $partner_name; ?></span>
								</figure>
								<?php else: ?>
								<div class="pseudo-image">
									<span><?php echo $partner_name; ?></span>
								</div>
								<?php endif; ?>
							</a></li>
							<?php endforeach; ?>
						</ul>
					</section>
					<?php endif; ?>
				</article>
				<?php endwhile; endif; ?>
			</section>


<?php get_footer(); ?>