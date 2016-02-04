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
					$current_partner_data = get_userdata($current_partner_ID);
					$partner_category = $current_partner_data->roles;
					$acf_partner_id = "user_{$current_partner_ID}";

					$partner_map = get_field("partner_map", $acf_partner_id);
					$partner_name = get_field("partner_name", $acf_partner_id);
					$partner_name = strlen($partner_name) > 0 ? $partner_name : $current_partner->display_name;

					$partner_bio = get_field("partner_description", $acf_partner_id);
					$partner_bio = strlen($partner_bio) > 0 ? $partner_bio : false;

					$hasProducts = false;


					$products = false;
					if (in_array("farm", $partner_category)){
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

						foreach ($products as $productCategory=>$productCategoryProducts) {
							if (is_array($productCategoryProducts)) {

								if (in_array("Other", $productCategoryProducts)) {
									while ($tempProd = current($productCategoryProducts)) {
									    if ($tempProd === "Other") {
									        $products[$productCategory]["other"] = get_field("other_products_{$productCategory}", $acf_partner_id);
									    }
									    next($productCategoryProducts);
									}
									
									if (strlen($products[$productCategory]["other"]) < 1) 
										unset($products[$productCategory]["other"]);
								}

								$productCategoryUnsets = array();
								if (count($productCategoryProducts) > 0) {
									switch ($productCategory) {
										case "roots":
											$productCategoryName = "Root Crops";
											break;
										case "seasonal":
											$productCategoryName = "Seasonal Vegetables";
											break;
										case "melons":
											$productCategoryName = "Melons & Pumpkins";
											break;
										case "small_fruits":
											$productCategoryName = "Orchard & Small Fruits";
											break;
										case "value_added":
											$productCategoryName = "Value-Added";
											break;
										case "syrups":
											$productCategoryName = "Honey / Syrup";
											break;
										case "artisinal":
											$productCategoryName = "Artisinal Products";
											break;
										case "liquids":
											$productCategoryName = "Beverages";
											break;
										case "educational":
											$productCategoryName = "Educational Programs";
											break;
										case "baked":
											$productCategoryName = "Baked Goods";
											break;
										case "seeds":
											$productCategoryName = "Nuts & Seeds";
											break;
										case "misc":
											$productCategoryName = "Other Products";
											break;
										default:
											$productCategoryName = ucwords($productCategory);
									}
									$products[$productCategory]["name"] = $productCategoryName;

									if (strlen($products[$productCategory]["name"]) < 1)
										$products[$productCategory]["name"] = ucwords($productCategory);

								}
							}	else {
								$productCategoryUnsets[] = $productCategory;
							}
						}

						foreach ($productCategoryUnsets as $productCategory) {
							unset($products[$productCategory]);
						}
						$hasProducts = (count($products) > 0) ? true : false;

						print_r($products);
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
						
						<div class="entry-top">
							<h1 class="entry-title"><?php echo $partner_name; ?></h1>
							<h2>Partner Information</h2>
							<?php if ($partner_bio): ?>
							<div class="partner-description">
								<?php echo $partner_bio; ?>
							</div>
							<?php endif; ?>
						</div>
						
						<?php if ($hasProducts) : ?>
						<div class="entry-product-categories">
							<h2>Product Categories</h2>
							<ul class="product-categories-list">
							<?php
							foreach($products as $productCategory=>$productCategoryProducts) {
								echo "<li>{$productCategoryProducts["name"]}</li>\n";
							}
							?>
							</ul>
						</div>
						<?php endif; ?>
						
					</section>

				</article>
			</section>
<?php get_footer(); ?>