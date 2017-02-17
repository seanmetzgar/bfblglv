<?php
/**
 * Template Name: Partner Type Page
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.6.0
 */
get_header();
	$landing_type = get_field("landing_type");
	switch($landing_type) {
		case "agritourism":
			$query_meta = array(
				"relation"	=> "OR",
				array(
					"key"		=> "is_agritourism",
					"value" 	=> "1",
					"compare" 	=> "="
				)
			);
			$query_roles = array("farm", "distillery", "vineyard", "specialty");
			break;
		case "csa":
		default:
			$show_farm_share = get_field("show_farm_share");
			$query_meta = array(
				"relation"	=> "OR",
				array(
					"key"		=> "is_csa",
					"value" 	=> "1",
					"compare" 	=> "="
				),
				array(
					"key"		=> "is_winter_csa",
					"value" 	=> "1",
					"compare" 	=> "="
				),
				array(
					"key"		=> "is_fall_csa",
					"value" 	=> "1",
					"compare" 	=> "="
				)
			);
			if ($show_farm_share) {
				$query_meta[] = array(
					"key"		=> "is_farm_share",
					"value"		=> "1",
					"compare"	=> "="
				);
			}
			$query_roles = array("farm");
			break;
	}
	$partners_args = array(
		"role__in" 		=> $query_roles,
		"meta_key" 		=> "partner_name",
		"meta_query" 	=> $query_meta,
		"number"		=> -1,
		"orderby"		=> "meta_value"
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
					<section class="page-block odd">
						<ul class="partners-blocks row">
							<?php foreach ($partners as $partner):
								$partner_ID 	= $partner->ID;
								$acf_partner_id = "user_{$partner_ID}";
								$partner_url 	= get_author_posts_url($partner_ID);
								$partner_name 	= get_field("partner_name", $acf_partner_id);
								$partner_name 	= strlen($partner_name) > 0 ?
												$partner_name :
												$partner->display_name;
								$partner_city = get_field("partner_city", $acf_partner_id);
								$partner_city = strlen($partner_city) > 0 ? $partner_city : false;
								$partner_state = get_field("partner_state", $acf_partner_id);
								$partner_state = strlen($partner_state) > 0 ? $partner_state : false;
								$partner_location = ($partner_city) ? $partner_city : "";
								$partner_location = ($partner_city && $partner_state) ? ", $partner_state" : (($partner_state) ? $partner_state : "");

								//Images
									//Logo
								$partner_logo 	= get_field("logo", $acf_partner_id);
								$partner_logo  	= (is_array($partner_logo) && array_key_exists("url", $partner_logo)) ?
												$partner_logo["url"] :
												false;
								$partner_fill = ($partner_logo) ? "contain" : "cover";
									//Owner
								$partner_owner_photo = get_field("owner_photo", $acf_partner_id);
								if (is_array($partner_owner_photo) && array_key_exists("url", $partner_owner_photo)) {
									$partner_owner_photo = $partner_owner_photo["url"];
								} elseif (is_string($partner_owner_photo) && $partner_owner_photo) {
									$partner_owner_photo = trim($partner_owner_photo);
								} else { $partner_owner_photo = false; }

									//Business
								$partner_business_photo = get_field("business_photo", $acf_partner_id);

								if (is_array($partner_business_photo) && array_key_exists("url", $partner_business_photo)) {
									$partner_business_photo = $partner_business_photo["url"];
								} elseif (is_string($partner_business_photo) && $partner_business_photo) {
									$partner_business_photo = trim($partner_business_photo);
								} else { $partner_business_photo = false; }

								$partner_image = ($partner_logo) ? $partner_logo : (
												 ($partner_business_photo) ? $partner_business_photo : (
												 ($partner_owner_photo) ? $partner_owner_photo : false ));
							?>
							<li class="col-md-3 col-sm-4 col-xs-6"><a href="<?php echo $partner_url; ?>" title="<?php echo $partner_name; ?>">
								<?php if ($partner_image): ?>
								<figure class="image <?php echo $partner_fill; ?>" style="background-image: url('<?php echo $partner_image; ?>');">
									<span><?php echo $partner_name; ?><?php if ($partner_location) echo "<br><em>$partner_location</em>"; ?></span>
								</figure>
								<?php else: ?>
								<div class="pseudo-image">
									<span><?php echo $partner_name; ?><?php if ($partner_location) echo "<br><em>$partner_location</em>"; ?></span>
								</div>
								<?php endif; ?>
								<div class="overlay">
									<span><?php echo $partner_name; ?><?php if ($partner_location) echo "<br><em>$partner_location</em>"; ?></span>
								</div>
							</a></li>
							<?php endforeach; ?>
						</ul>
					</section>
					<?php endif; ?>
				</article>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>