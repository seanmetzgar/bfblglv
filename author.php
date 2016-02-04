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

					// $partner_category = get_user_role($current_partner_ID);
					print_r($current_partner->roles);

					if ($partner_category === "farm") {
						$products = array();
						$products["greens"] = get_field("products_greens", $acf_partner_id);
						$products["roots"] = get_field("products_roots", $acf_partner_id);
						$products["seasonal"] = get_field("products_seasonal", $acf_partner_id);
						$products["melons"] = get_field("products_melons", $acf_partner_id);
						$products["herbs"] = get_field("products_herbs", $acf_partner_id);
						$products["berries"] = get_field("products_berries", $acf_partner_id);
						$products["small_fruits"] = get_field("products_small_fruits", $acf_partner_id);
						$products["grains"] = get_field("products_grains", $acf_partner_id);
						$products["value_added"] = get_field("products_value_added", $acf_partner_id);
						$products["flowers"] = get_field("products_flowers", $acf_partner_id);
						$products["plants"] = get_field("products_plants", $acf_partner_id);
						$products["ornamentals"] = get_field("products_ornamentals", $acf_partner_id);
						$products["syrups"] = get_field("products_syrups", $acf_partner_id);
						$products["dairy"] = get_field("products_dairy", $acf_partner_id);
						$products["meat"] = get_field("products_meat", $acf_partner_id);
						$products["poultry"] = get_field("products_poultry", $acf_partner_id);
						$products["agritourism"] = get_field("products_agritourism", $acf_partner_id);
						$products["fibers"] = get_field("products_fibers", $acf_partner_id);
						$products["artisinal"] = get_field("products_artisinal", $acf_partner_id);
						$products["liquids"] = get_field("products_liquids", $acf_partner_id);
						$products["educational"] = get_field("products_educational", $acf_partner_id);
						$products["baked"] = get_field("products_baked", $acf_partner_id);
						$products["seeds"] = get_field("products_seeds", $acf_partner_id);
						$products["misc"] = get_field("products_misc", $acf_partner_id);
					}					
					
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
						<?php
						foreach($products as $productCategory=>$productCategoryProducts) {
							echo ($productCategory);
							echo ": ";
							print_r($productCategoryProducts);
							echo "<br><br>";
						} ?>
					</section>

				</article>
			</section>
<?php get_footer(); ?>