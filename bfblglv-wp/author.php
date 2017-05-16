<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
$current_partner = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$current_partner_ID = $current_partner->ID;
$current_partner_data = get_userdata($current_partner_ID);
$partner_category = $current_partner_data->roles;
$acf_partner_id = "user_{$current_partner_ID}";

$disabled = get_user_meta($current_partner_ID, "ja_disable_user", true);
if ($disabled) {
	header("Location: /");
}

get_header(); ?>
			<section class="main-content" role="main">
				<?php

					$partner_map = get_field("partner_map", $acf_partner_id);
					$partner_name = get_field("partner_name", $acf_partner_id);
					$partner_name = strlen($partner_name) > 0 ? $partner_name : $current_partner->display_name;

					$partner_bio = get_field("partner_description", $acf_partner_id);
					$partner_bio = strlen($partner_bio) > 0 ? $partner_bio : false;

					$hasProducts = false;
					$hasWsProducts = false;
					$productsText = false;
					$wsProductsText = false;

					$is_wholesaler = get_field("is_wholesaler", $acf_partner_id);
					$quasi_wholesale = get_field("quasi_wholesale", $acf_partner_id);
					$small_wholesale = get_field("small_wholesale", $acf_partner_id);
					$large_wholesale = get_field("large_wholesale", $acf_partner_id);
					$gap_certification = get_field("gap_certification", $acf_partner_id);
					$gap_certified_since = get_field("gap_certified_since", $acf_partner_id);

					$partner_street_1 = get_field("partner_street_1", $acf_partner_id);
					$partner_street_1 = strlen($partner_street_1) > 0 ? $partner_street_1 : false;
					$partner_street_2 = get_field("partner_street_2", $acf_partner_id);
					$partner_street_2 = strlen($partner_street_2) > 0 ? $partner_street_2 : false;
					$partner_city = get_field("partner_city", $acf_partner_id);
					$partner_city = strlen($partner_city) > 0 ? $partner_city : false;
					$partner_state = get_field("partner_state", $acf_partner_id);
					$partner_state = strlen($partner_state) > 0 ? $partner_state : false;
					$partner_zip = get_field("partner_zip", $acf_partner_id);
					$partner_zip = strlen($partner_zip) > 0 ? $partner_zip : false;
					$partner_county = get_field("partner_county", $acf_partner_id);

					$partner_address = "";
					$partner_address .= $partner_street_1 ? "$partner_street_1<br>" : "";
					$partner_address .= $partner_street_2 ? "$partner_street_2<br>" : "";
					$partner_address .= $partner_city ? "$partner_city" : "";
					$partner_address .= ($partner_city && $partner_state) ? ", $partner_state" : "";
					$partner_address .= (!$partner_city && $partner_state) ? "$partner_state" : "";
					$partner_address .= ($partner_zip && ($partner_city || $partner_state)) ? " $partner_zip" : "";
					$partner_address .= ($partner_zip && !$partner_city && !$partner_state) ? $partner_zip : "";

					$partner_address = (strlen($partner_address) > 0) ? $partner_address : false;

					$partner_phone = get_field("partner_phone", $acf_partner_id);
					$partner_phone = strlen($partner_phone) > 0 ? $partner_phone : false;
					$partner_email = get_field("partner_email", $acf_partner_id);
					$partner_email = strlen($partner_email) > 0 ? $partner_email : false;
					$partner_website = get_field("partner_website", $acf_partner_id);
					$partner_website = strlen($partner_website) > 0 ? $partner_website : false;
					$partner_facebook = get_field("partner_facebook", $acf_partner_id);
					$partner_facebook = strlen($partner_facebook) > 0 ? $partner_facebook : false;
					$partner_twitter = get_field("partner_twitter", $acf_partner_id);
					$partner_twitter = strlen($partner_twitter) > 0 ? $partner_twitter : false;
					$partner_instagram = get_field("partner_instagram", $acf_partner_id);
					$partner_instagram = strlen($partner_instagram) > 0 ? $partner_instagram : false;

					$partner_owner_name = get_field("partner_owner_name", $acf_partner_id);
					$partner_owner_name = strlen($partner_owner_name) > 0 ? $partner_owner_name : false;
					$partner_contact_name = get_field("partner_contact_name", $acf_partner_id);

					$partner_owner_photo = get_field("owner_photo", $acf_partner_id);

					if (is_array($partner_owner_photo)) {
						$partner_owner_photo = wp_get_attachment_image($partner_owner_photo["ID"], "full", false, array("class" => "img-responsive"));
					} elseif (is_string($partner_owner_photo) && strlen($partner_owner_photo) > 0) {
						$partner_owner_photo = "<img src=\"$partner_owner_photo\" class=\"img-responsive\">";
					} else { $partner_owner_photo = false; }
					$partner_business_photo = get_field("business_photo", $acf_partner_id);
					if (is_array($partner_business_photo)) {
						$partner_business_photo = wp_get_attachment_image($partner_business_photo["ID"], "full", false, array("class" => "img-responsive"));
					} elseif (is_string($partner_business_photo) && strlen($partner_business_photo) > 0) {
						$partner_business_photo = "<img src=\"$partner_business_photo\" class=\"img-responsive\">";
					} else { $partner_business_photo = false; }

					$partner_hours = false;
					if (have_rows("hours", $acf_partner_id)) {
						$partner_hours = array();
						while (have_rows("hours", $acf_partner_id)) {
							the_row();
							$tempDay = get_sub_field("day");
							$tempOpenTime = get_sub_field("open_time");
							$tempCloseTime = get_sub_field("close_time");
							$tempShortDescription = get_sub_field("short_description");
							$tempIsSeasonal = get_sub_field("is_seasonal");
							if ($tempIsSeasonal) {
								$tempSeasonStartMonthPart = get_sub_field("season_start_mpart");
								$tempSeasonStartMonth = get_sub_field("season_start_month");
								$tempSeasonEndMonthPart = get_sub_field("season_end_mpart");
								$tempSeasonEndMonth = get_sub_field("season_end_month");
							}
							$tempVendors = get_sub_field("vendors");
							$tempVendors = (is_string($tempVendors) && strlen($tempVendors) > 0) ? $tempVendors : false;

							$tempHours = "<strong>$tempDay: $tempOpenTime - $tempCloseTime</strong>";
							$tempHours .= ($tempShortDescription) ? "<br><span class=\"short-description\"><em>$tempShortDescription</em></span>" : "";
							$tempHours .= ($tempIsSeasonal) ? "<br><span class=\"seasonal\">$tempSeasonStartMonthPart $tempSeasonStartMonth - $tempSeasonEndMonthPart $tempSeasonEndMonth</span>" : "";
							$tempHours .= ($tempVendors) ? "<br><span class=\"vendors\">$tempVendors Vendors</span>" : "";
							$partner_hours[] = $tempHours;
						}
					}

					$products_available_at = get_field("products_available_at", $acf_partner_id);
					$products_available_from = get_field("products_available_from", $acf_partner_id);
					$source_from = get_field("source_from", $acf_partner_id);
					$local_stock_freq = get_field("local_stock_freq", $acf_partner_id);
					$local_stock_qty = get_field("local_stock_qty", $acf_partner_id);
					$farm_type = get_field("farm_type", $acf_partner_id);
					$farm_type = ($farm_type === "false") ? false : $farm_type;

					/** Acres Info **/
					$acres_owned = get_field("acres_owned", $acf_partner_id);
					$acres_rented = get_field("acres_rented", $acf_partner_id);
					$acres_production = get_field("acres_production", $acf_partner_id);
					$has_acreage = ($acres_owned || $acres_rented || $acres_production) ? true : false;

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
						$products["eggs"] = get_field("products_eggs", $acf_partner_id);
						$products["mushrooms"] = get_field("products_mushrooms", $acf_partner_id);
						$products["fibers"] = get_field("products_fibers", $acf_partner_id);
						$products["artisinal"] = get_field("products_artisinal", $acf_partner_id);
						$products["liquids"] = get_field("products_liquids", $acf_partner_id);
						$products["educational"] = get_field("products_educational", $acf_partner_id);
						$products["baked"] = get_field("products_baked", $acf_partner_id);
						$products["seeds"] = get_field("products_seeds", $acf_partner_id);
						$products["pyo"] = get_field("products_pyo", $acf_partner_id);
						$products["misc"] = get_field("products_misc", $acf_partner_id);

						$ws_products = array();
						$ws_products["greens"] = get_field("ws_products_greens", $acf_partner_id);
						$ws_products["roots"] = get_field("ws_products_roots", $acf_partner_id);
						$ws_products["seasonal"] = get_field("ws_products_seasonal", $acf_partner_id);
						$ws_products["melons"] = get_field("ws_products_melons", $acf_partner_id);
						$ws_products["herbs"] = get_field("ws_products_herbs", $acf_partner_id);
						$ws_products["berries"] = get_field("ws_products_berries", $acf_partner_id);
						$ws_products["small_fruits"] = get_field("ws_products_small_fruits", $acf_partner_id);
						$ws_products["grains"] = get_field("ws_products_grains", $acf_partner_id);
						$ws_products["value_added"] = get_field("ws_products_value_added", $acf_partner_id);
						$ws_products["flowers"] = get_field("ws_products_flowers", $acf_partner_id);
						$ws_products["plants"] = get_field("ws_products_plants", $acf_partner_id);
						$ws_products["ornamentals"] = get_field("ws_products_ornamentals", $acf_partner_id);
						$ws_products["syrups"] = get_field("ws_products_syrups", $acf_partner_id);
						$ws_products["dairy"] = get_field("ws_products_dairy", $acf_partner_id);
						$ws_products["meat"] = get_field("ws_products_meat", $acf_partner_id);
						$ws_products["poultry"] = get_field("ws_products_poultry", $acf_partner_id);
						$ws_products["eggs"] = get_field("ws_products_eggs", $acf_partner_id);
						$ws_products["mushrooms"] = get_field("ws_products_mushrooms", $acf_partner_id);
						$ws_products["fibers"] = get_field("ws_products_fibers", $acf_partner_id);
						$ws_products["artisinal"] = get_field("ws_products_artisinal", $acf_partner_id);
						$ws_products["liquids"] = get_field("ws_products_liquids", $acf_partner_id);
						$ws_products["educational"] = get_field("ws_products_educational", $acf_partner_id);
						$ws_products["baked"] = get_field("ws_products_baked", $acf_partner_id);
						$ws_products["seeds"] = get_field("ws_products_seeds", $acf_partner_id);
						$ws_products["pyo"] = get_field("ws_products_pyo", $acf_partner_id);
						$ws_products["misc"] = get_field("ws_products_misc", $acf_partner_id);

						$productCategoryUnsets = array();
						foreach ($products as $productCategory=>$productCategoryProducts) {
							if (is_array($productCategoryProducts) && count($productCategoryProducts) > 0 && !in_array("", $productCategoryProducts)) {

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
										case "pyo":
											$productCategoryName = "Pick Your Own";
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

						$productCategoryUnsets = array();
						foreach ($ws_products as $productCategory=>$productCategoryProducts) {
							if (is_array($productCategoryProducts) && count($productCategoryProducts) > 0 && !in_array("", $productCategoryProducts)) {

								if (in_array("Other", $productCategoryProducts)) {
									while ($tempProd = current($productCategoryProducts)) {
									    if ($tempProd === "Other") {
									        $ws_products[$productCategory]["other"] = get_field("other_ws_products_{$productCategory}", $acf_partner_id);
									    }
									    next($productCategoryProducts);
									}

									if (strlen($ws_products[$productCategory]["other"]) < 1)
										unset($ws_products[$productCategory]["other"]);
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
										case "pyo":
											$productCategoryName = "Pick Your Own";
											break;
										case "misc":
											$productCategoryName = "Other Products";
											break;
										default:
											$productCategoryName = ucwords($productCategory);
									}
									$ws_products[$productCategory]["name"] = $productCategoryName;

									if (strlen($ws_products[$productCategory]["name"]) < 1)
										$ws_products[$productCategory]["name"] = ucwords($productCategory);

								}
							}	else {
								$productCategoryUnsets[] = $productCategory;
							}
						}

						foreach ($productCategoryUnsets as $productCategory) {
							unset($ws_products[$productCategory]);
						}
						$hasWsProducts = (count($ws_products) > 0) ? true : false;
					} else {
						$productsText = get_field("products_text", $acf_partner_id);
						$wsProductsText = get_field("ws_products_text", $acf_partner_id);
					}



					// NEWNEWNEW
					// turn the user role (that is, provider category) into something we can use
					$partner_category_string = '';

					global $bfbl_custom_roles;
					foreach($partner_category as $this_role) {
						if(in_array($this_role, $bfbl_custom_roles)) {
							// we're going to take only the *first* matching role, so proceed only if $partner_category_string is still empty
							if($partner_category_string == '') {
								$partner_category_string = ucwords($this_role);
							}
						} // end the is-this-a-bfbl-custom-role test
					} // end the $partner_category foreach


					// NEWNEWNEW - TEMPTEMPTEMP
					$whereToBuy = '';
					$productHours = '';


					// temporarily setting these values manually; they can later be extracted from the database
					// $whereToBuy = '<b>STRING IS SET MANUALLY</b>, needs to be hooked up to the database. Lorem ipsum dolor sit amet.';

				//
					// if(count($partner_hours) > 0) {
					// 	$prodHoursArray = $partner_hours;
					// 	array_unshift($prodHoursArray, 'STRING IS SET MANUALLY');
					// }
				//

					// $productHours = '<li>' . implode('</li><li>', $prodHoursArray) . '</li>';

				if (in_array("farmers-market", $partner_category)) {
					$market_manager = get_field("market_manager", $acf_partner_id);
					$market_vendor_count = get_field("number_of_vendors", $acf_partner_id);
					$market_vendors = get_field("vendor_list", $acf_partner_id);
					$market_practices = false;
					$market_ebt = get_field("market_ebt", $acf_partner_id);
					$market_ebt = (is_string($market_ebt) && ($market_ebt !== "no")) ? $market_ebt : false;
					$market_double_snap = get_field("market_double_snap", $acf_partner_id);
					$market_double_snap = is_bool($market_double_snap) ? $market_double_snap : false;
					$market_fmnp = get_field("market_fmnp", $acf_partner_id);
					$market_fmnp = is_bool($market_fmnp) ? $market_fmnp : false;

					if ($market_ebt || $market_double_snap || $market_fmnp) {
						$market_practices = true;
					}
				}

				$is_agritourism = false;
				if (in_array("farm", $partner_category) ||
					in_array("distillery", $partner_category) ||
					in_array("vineyard", $partner_category) ||
					in_array("specialty", $partner_category)) {
					$is_agritourism = get_field("is_agritourism", $acf_partner_id);
					$is_agritourism = is_bool($is_agritourism) ? $is_agritourism : false;

					if ($is_agritourism) {
						$agritourism_heading = "Agritourism Information";
						$agritourism_events_heading = "Agritourism Activities";
						$agritourism_photo = get_field("agritourism_photo", $acf_partner_id);
						$agritourism_products = get_field("products_agritourism", $acf_partner_id);
						$agritourism_products = (is_array($agritourism_products) && count($agritourism_products) > 0) ? $agritourism_products : false;
						$agritourism_products_string = $agritourism_products ? implode(", ", $agritourism_products) : "";

						$agritourism_event_class = ($agritourism_photo) ? "col-sm-6" : "col-sm-4";
						$agritourism_event_class .= " agritourism-event";
					}
				}


				?>
				<article id="partner-<?php the_ID(); ?>" class="partner-profile">
					<?php get_template_part("entry", "partner-header"); ?>
					<?php if( !empty($partner_map) ): ?>
					<div class="page-block acf-map-wrap">
						<div class="acf-map">
							<div class="marker" data-lat="<?php echo $partner_map['lat']; ?>" data-lng="<?php echo $partner_map['lng']; ?>"></div>
						</div>
					</div><!-- end div.acf-map-wrap -->
					<?php endif; ?>

					<?php get_template_part("entry", "partner-back"); ?>

					<section class="partner-content">

						<?php if ($hasProducts) : // This Container should be positioned BELOW MAP when visible ?>
						<div class="entry-product-categories">
							<h2 class="greenHeader">Product Categories</h2>
							<div>
								<ul class="product-categories-list page-block">
									<?php
									foreach($products as $productCategory=>$productCategoryProducts) {
										if (array_key_exists("name", $productCategoryProducts)) {
										echo "<li><span>{$productCategoryProducts["name"]}</span></li>\n";
										}
									}
									?>
								</ul>
							</div><!-- end div -->
						</div><!-- end div.entry-product-categories -->
						<?php endif; ?>

						<div class="entry-top">
							<h2 class="greenHeader">Partner Information</h2>

							<div>
								<div class="page-block partner-info-block">
									<?php if ((!in_array("farm", $partner_category) && $partner_business_photo) || $partner_owner_photo): ?><div class="partner-info-right"><?php endif; ?>

										<h1 class="entry-title"><?php echo $partner_name; ?></h1>

										<div class="partner-description entry-content">
											<?php if ($partner_bio) echo $partner_bio; ?>
											<p><small><em>Last Updated: <?php echo do_shortcode("[partner-last-updated user_id={$current_partner_ID}]"); ?></em></small></p>
										</div><!-- end div.partner-description -->

										<?php if ($partner_address): ?>
										<div class="partner-detail">
											<h4>Address</h4>
											<p><?php echo $partner_address; ?></p>
										</div><!-- end div.partner-detail -->
										<?php endif; ?>

										<?php if ($partner_county): ?>
										<div class="partner-detail">
											<h4>County</h4>
											<p><?php echo $partner_county; ?></p>
										</div><!-- end div.partner-detail -->
										<?php endif; ?>

										<?php if ($partner_hours): ?>
										<div class="partner-detail partner-hours">
											<h4>Hours</h4>
											<ul class="hours-list">
											<?php foreach ($partner_hours as $partner_hours_day) {
												echo "<li>$partner_hours_day</li>\n";
											} ?>
											</ul>
										</div><!-- end div.partner-hours -->
										<?php endif; ?>

										<?php if (!$partner_owner_photo && $partner_owner_name): ?>
										<div class="partner-detail partner-owner">
											<h4>Owner</h4>
											<p><?php echo $partner_owner_name; ?></p>
										</div><!-- end div.partner-owner -->
										<?php endif; ?>

										<?php if (in_array("farmers-market", $partner_category) && ($market_manager || $market_vendor_count || $market_vendors || $market_practices)): ?>

											<?php if ($market_manager): ?>
										<div class="partner-detail market-manager">
											<h4>Manager</h4>
											<p><?php echo $market_manager; ?></p>
										</div><!-- end div.market-manager -->
											<?php endif; ?>

											<?php if ($market_practices): ?>

										<div class="partner-detail market-practices">
											<h4>Practices</h4>
											<ul>
											<?php switch ($market_ebt) {
												case "all":
													echo "<li>Market-wide EBT program</li>";
													break;
												case "some":
													echo "<li>EBT accepted by some vendors</li>";
													break;
											}
											if ($market_double_snap) echo "<li>Double SNAP Program</li>";
											if ($market_fmnp) echo "<li>FMNP Vouchers accepted by some vendors</li>"; ?>
											</ul>
										</div><!-- end div.market-practices -->
											<?php endif; ?>

											<?php if ($market_vendor_count): ?>
										<div class="partner-detail market-vendors">
											<h4>Vendors</h4>
											<p><?php echo $market_vendor_count; ?></p>
										</div><!-- end div.market-vendors -->
											<?php endif; ?>

											<?php if (is_array($market_vendors) && count($market_vendors) > 0): ?>
										<div class="market-vendor-list">
											<h4>Our vendors include these BFBLGLV partners</h4>
											<ul class="vendor-list">
												<?php foreach ($market_vendors as $vendor):
													if (is_array($vendor)):
														$vendor_id = "user_{$vendor['ID']}";
														$vendor_name = get_field("partner_name", $vendor_id);
														if (!isHiddenVendor($vendor) || !isDisabledVendor($vendor)):
															$vendor_url = get_author_posts_url($vendor['ID']);
															$vendor_city = get_field("partner_city", $vendor_id);
															$vendor_name .= ($vendor_city) ? ", $vendor_city" : "";
															echo "<li><a href=\"$vendor_url\">$vendor_name</a></li>\n";
														elseif (isHiddenVendor($vendor) && !isDisabledVendor($vendor)):
															echo "<li>$vendor_name</li>";
														endif;
													endif;
												endforeach; ?>
											</ul>
										</div><!-- end div.partner-owner -->
											<?php endif; ?>
										<?php endif; ?>

										<?php if ($partner_phone || $partner_email || $partner_website): ?>
										<div class="partner-contact">
											<h4 class="visuallyhidden">Contact Details</h4>
											<ul>
												<?php
													if ($partner_phone) echo "<li class='partner-phone'><a href='tel:1-{$partner_phone}'>$partner_phone</a></li>";
													if ($partner_email) echo "<li class='partner-email'><a href=\"mailto:$partner_email\" target=\"_blank\">$partner_email</a></li>";
													if ($partner_website) echo "<li class='partner-website'><a href=\"$partner_website\" target=\"_blank\">$partner_website</a></li>";
												?>
											</ul>
										</div><!-- end div.partner-contact -->
										<?php endif; ?>
									<?php if (((!in_array("farm", $partner_category) && !in_array("specialty", $partner_category) && !in_array("restaurant", $partner_category) && !in_array("distillery", $partner_category) || in_array("vineyard", $partner_category)) && $partner_business_photo) || $partner_owner_photo): ?></div><!-- end div.partner-info-right --><?php endif; ?>

									<?php if (((!in_array("farm", $partner_category) && !in_array("specialty", $partner_category) && !in_array("restaurant", $partner_category) && !in_array("distillery", $partner_category) || in_array("vineyard", $partner_category)) && $partner_business_photo) || $partner_owner_photo): ?>
									<div class="partner-info-left">
										<div class="owner-details">
											<?php if (in_array("farm", $partner_category) || in_array("specialty", $partner_category) || in_array("restaurant", $partner_category) || in_array("distillery", $partner_category) || in_array("vineyard", $partner_category)) {
												if ($partner_owner_photo) {
													echo '<div class="owner-image">';
														echo $partner_owner_photo;
													echo '</div><!-- end div.owner-image -->';
												}
												if ($partner_owner_name) {
													echo "\n<h3 class=\"owner-name\">$partner_owner_name</h3>\n";
												}
											} else {
												if ($partner_business_photo) {
													echo '<div class="business-image">';
														echo $partner_business_photo;
													echo '</div><!-- end div.business-image -->';
												}
											}
											if (in_array("farmers-market", $partner_category) && $partner_owner_photo) {
												echo '<div class="owner-image">';
													echo $partner_owner_photo;
												echo '</div><!-- end div.owner-image -->';
											}
											?>
										</div><!-- end div.owner-details -->

										<?php if ($partner_facebook || $partner_twitter || $partner_instagram): ?>
										<div class="partner-social">
											<h4>Social Media</h4>
											<ul>
												<?php
													if ($partner_facebook) echo "<li class='facebook'><a href=\"$partner_facebook\" target=\"_blank\" title=\"$partner_facebook\"><span>Facebook</span></a></li>";
													if ($partner_twitter) echo "<li class='twitter'><a href=\"https://twitter.com/$partner_twitter\" target=\"_blank\" title=\"@$partner_twitter\"><span>Twitter</span></a></li>";
													if ($partner_instagram) echo "<li class='instagram'><a href=\"https://www.instagram.com/$partner_instagram\" target=\"_blank\" title=\"@$partner_instagram\"><span>Instagram</span></a></li>";
												?>
											</ul>
										</div><!-- end div.partner-social -->
										<?php endif; ?>
									</div><!-- end div.partner-info-left; -->
									<?php endif; ?>
								</div><!-- end div.parter-info-block -->
							</div><!-- end div -->
						</div><!-- end div.entry-top -->

						<?php if (!in_array("farmers-market", $partner_category)): ?>
						<div class="entry-product-information">
							<h2 class="greenHeader">Product Information</h2>

							<div>
								<div class="page-block product-info-contents">
									<div class="product-info-left">
									<?php
									if (in_array("farm", $partner_category) || in_array("specialty", $partner_category) || in_array("restaurant", $partner_category) || in_array("distillery", $partner_category) || in_array("vineyard", $partner_category)) {
										if ($partner_business_photo) {
											echo '<div class="business-image">';
												echo $partner_business_photo;
											echo '</div><!-- end div.business-image -->';
										}
									} else {
										if ($partner_owner_photo) {
											echo '<div class="owner-image">';
												echo $partner_owner_photo;
											echo '</div><!-- end div.owner-image -->';
										}
									} ?>
									</div><!-- end div.product-info-left -->

									<?php if (in_array("farm", $partner_category) || in_array("specialty", $partner_category) || in_array("restaurant", $partner_category) || in_array("distillery", $partner_category) || in_array("vineyard", $partner_category)): ?><div class="product-info-right"><?php endif; ?>
										<div class="products-detail">
											<?php if ($hasProducts || $productsText) :
												$farmTypeString = (in_array("farm", $partner_category) && $farm_type) ? "Products Available From Our {$farm_type}" : "";
											?>
											<div class="entry-product-categories entry-content">
												<h3>Products Available</h3>
												<?php
												if ($hasProducts) {
													foreach($products as $productCategory=>$productCategoryProducts) {
														if (is_array($productCategoryProducts) && count($productCategoryProducts) > 0) {
															$tempProductsList = array();
															foreach ($productCategoryProducts as $productCategoryProductKey => $productCategoryProduct) {
																if ($productCategoryProduct) {
																	if (is_int($productCategoryProductKey) && $productCategoryProduct !== "Other") {
																		$tempProductsList[] = $productCategoryProduct;
																	} elseif ($productCategoryProductKey === "other") {
																		$tempProductsList[] = strip_tags($productCategoryProduct);
																	}
																}
															}
															if (count($tempProductsList) > 0) {
																$tempProductsList = implode(", ", $tempProductsList);
																echo "<div class=\"product-group\">";
																echo "<h4>{$productCategoryProducts["name"]}</h4>";
																echo "<p>$tempProductsList</p>";
																echo "</div>";
															}
															$tempProductsList = null;
														}
													}
												} elseif ($productsText) {
													echo "<p>$productsText</p>";
												}
												if ($farmTypeString) echo "<h4 class=\"farmTypeString\">$farmTypeString</h4>";
												?>
											</div><!-- end div.entry-product-categories -->
											<?php endif; ?>


											<?php
											if (is_array($products_available_at) && count($products_available_at) > 0): ?>
											<h4>Products available at these BFBLGLV partners</h4>
											<ul class="vendor-list">
												<?php foreach ($products_available_at as $vendor):
													if (is_array($vendor)):
														$vendor_id = "user_{$vendor['ID']}";
														$vendor_name = get_field("partner_name", $vendor_id);
														if (!isHiddenVendor($vendor) || !isDisabledVendor($vendor)):
															$vendor_url = get_author_posts_url($vendor['ID']);
															$vendor_city = get_field("partner_city", $vendor_id);
															$vendor_name .= ($vendor_city) ? ", $vendor_city" : "";
															echo "<li><a href=\"$vendor_url\">$vendor_name</a></li>\n";
														elseif (isHiddenVendor($vendor) && !isDisabledVendor($vendor)):
															echo "<li>$vendor_name</li>";
														endif;
													endif;
												endforeach; ?>
											</ul>
											<?php endif; ?>

											<?php
											if (is_array($products_available_from) && count($products_available_from) > 0): ?>
											<h4>Products available from these BFBLGLV partners</h4>
											<ul class="vendor-list">
												<?php foreach ($products_available_from as $vendor):
													if (is_array($vendor)):
														$vendor_id = "user_{$vendor['ID']}";
														$vendor_name = get_field("partner_name", $vendor_id);
														if (!isHiddenVendor($vendor) || !isDisabledVendor($vendor)):
															$vendor_url = get_author_posts_url($vendor['ID']);
															$vendor_city = get_field("partner_city", $vendor_id);
															$vendor_name .= ($vendor_city) ? ", $vendor_city" : "";
															echo "<li><a href=\"$vendor_url\">$vendor_name</a></li>\n";
														elseif (isHiddenVendor($vendor) && !isDisabledVendor($vendor)):
															echo "<li>$vendor_name</li>";
														endif;
													endif;
												endforeach; ?>
											</ul>
											<?php endif; ?>

											<?php
											if (is_array($source_from) && count($source_from) > 0): ?>
											<h4>We source from these BFBLGLV partners</h4>
											<ul class="vendor-list">
												<?php foreach ($source_from as $vendor):
													if (is_array($vendor)):
														$vendor_id = "user_{$vendor['ID']}";
														$vendor_name = get_field("partner_name", $vendor_id);
														if (!isHiddenVendor($vendor) || !isDisabledVendor($vendor)):
															$vendor_url = get_author_posts_url($vendor['ID']);
															$vendor_city = get_field("partner_city", $vendor_id);
															$vendor_name .= ($vendor_city) ? ", $vendor_city" : "";
															echo "<li><a href=\"$vendor_url\">$vendor_name</a></li>\n";
														elseif (isHiddenVendor($vendor) && !isDisabledVendor($vendor)):
															echo "<li>$vendor_name</li>";
														endif;
													endif;
												endforeach; ?>
											</ul>
											<?php endif; ?>

											<?php if ($local_stock_freq && $local_stock_qty)
												echo "<h4>Local Ingredients</h4><p><em>We $local_stock_freq have $local_stock_qty locally grown ingredients in our menu items.</em></p>"; ?>

										</div><!-- end div.products-detail -->
									<?php if ($partner_business_photo): ?></div><!-- end div.product-info-right --><?php endif; ?>
								</div><!-- end div.product-info-contents -->
							</div><!-- end div -->
						</div><!-- end div.entry-product-information -->
						<?php endif; ?>

						<?php if (is_user_logged_in() && $is_wholesaler): ?>
						<div class="entry-product-information">
							<h2 class="greenHeader">Wholesale Information</h2>

							<div>
								<div class="page-block product-info-contents">
									<div class="product-info-left">
										<h3>Details</h3>
										<?php if ($quasi_wholesale) echo "<h4>Quasi-Wholesale</h4>"; ?>
										<?php if ($small_wholesale) echo "<h4>Small Wholesale Accounts</h4>"; ?>
										<?php if ($large_wholesale) echo "<h4>Large Wholesale Accounts</h4>"; ?>
										<?php if ($gap_certification === "Yes") {
											echo "<h4>GAP Certified</h4>";
										} elseif ($gap_certification === "Pending") {
											echo "<h4>Working towards GAP Certification</h4>";
										} ?>
									</div><!-- end div.product-info-left -->

									<div class="product-info-right">
										<div class="products-detail">
											<?php if ($hasWsProducts || $wsProductsText) : ?>
											<div class="entry-product-categories entry-content">
												<h3>Wholesale Products</h3>
												<?php
												if ($hasWsProducts) {
													foreach($ws_products as $productCategory=>$productCategoryProducts) {
														if (is_array($productCategoryProducts) && count($productCategoryProducts) > 0) {
															$tempProductsList = array();
															foreach ($productCategoryProducts as $productCategoryProductKey => $productCategoryProduct) {
																if ($productCategoryProduct) {
																	if (is_int($productCategoryProductKey) && $productCategoryProduct !== "Other") {
																		$tempProductsList[] = $productCategoryProduct;
																	} elseif ($productCategoryProductKey === "other") {
																		$tempProductsList[] = strip_tags($productCategoryProduct);
																	}
																}
															}
															if (count($tempProductsList) > 0) {
																$tempProductsList = implode(", ", $tempProductsList);
																echo "<div class=\"product-group\">";
																echo "<h4>{$productCategoryProducts["name"]}</h4>";
																echo "<p>$tempProductsList</p>";
																echo "</div>";
															}
															$tempProductsList = null;
														}
													}
												} elseif ($wsProductsText) {
													echo "<p>$wsProductsText</p>";
												}
												?>
											</div><!-- end div.entry-product-categories -->
											<?php endif; ?>
										</div><!-- end div.products-detail -->
									</div><!-- end div.product-info-right -->
								</div><!-- end div.product-info-contents -->
							</div><!-- end div -->
						</div><!-- end div.entry-wholesale-information -->
						<?php endif; ?>

						<?php if (in_array("farm", $partner_category)):
							$csa_section_title = "";
							$csa_loops = array();
							$is_csa = get_field("is_csa", $acf_partner_id);
							$is_csa = (is_bool($is_csa)) ? $is_csa : false;
							if ($is_csa) { $csa_loops[] = "csa"; }

							$is_fall_csa = get_field("is_fall_csa", $acf_partner_id);
							$is_fall_csa = (is_bool($is_fall_csa)) ? $is_fall_csa : false;
							if ($is_fall_csa) { $csa_loops[] = "fall_csa"; }

							$is_winter_csa = get_field("is_winter_csa", $acf_partner_id);
							$is_winter_csa = (is_bool($is_winter_csa)) ? $is_winter_csa : false;
							if ($is_winter_csa) { $csa_loops[] = "winter_csa"; }

							$is_farm_share = get_field("is_farm_share", $acf_partner_id);
							$is_farm_share = (is_bool($is_farm_share)) ? $is_farm_share : false;
							if ($is_farm_share) { $csa_loops[] = "farm_share"; }

							if (count($csa_loops) > 0) {
								$csa_data = array();
								foreach ($csa_loops as $csa_type) {
									if (have_rows("{$csa_type}_details", $acf_partner_id)) { the_row();
										$csa_data[$csa_type] = array();

										$csa_data[$csa_type]["season_weeks"] = get_sub_field("season_weeks");

										$csa_data[$csa_type]["season_start_mpart"] = get_sub_field("season_start_mpart");
										$csa_data[$csa_type]["season_start_month"] = get_sub_field("season_start_month");
										$csa_data[$csa_type]["season_end_mpart"] = get_sub_field("season_end_mpart");
										$csa_data[$csa_type]["season_end_month"] = get_sub_field("season_end_month");

										if ($csa_data[$csa_type]["season_start_month"] && $csa_data[$csa_type]["season_start_mpart"]) {
											$csa_data[$csa_type]["season_start"] = "{$csa_data[$csa_type]["season_start_mpart"]} {$csa_data[$csa_type]["season_start_month"]}";
										} elseif ($csa_data[$csa_type]["season_start_month"]) {
											$csa_data[$csa_type]["season_start"] = "{$csa_data[$csa_type]["season_start_month"]}";
										} else { $csa_data[$csa_type]["season_start"] = false; }

										if ($csa_data[$csa_type]["season_end_month"] && $csa_data[$csa_type]["season_end_mpart"]) {
											$csa_data[$csa_type]["season_end"] = "{$csa_data[$csa_type]["season_end_mpart"]} {$csa_data[$csa_type]["season_end_month"]}";
										} elseif ($csa_data[$csa_type]["season_end_month"]) {
											$csa_data[$csa_type]["season_end"] = "{$csa_data[$csa_type]["season_end_month"]}";
										} else { $csa_data[$csa_type]["season_end"] = false; }

										$csa_data[$csa_type]["has_season"] = ($csa_data[$csa_type]["season_weeks"] || $csa_data[$csa_type]["season_start"] || $csa_data[$csa_type]["season_end"]) ? true : false;

										//Full Shares
										$csa_data[$csa_type]["has_full_shares"] = false;
										$csa_data[$csa_type]["full_shares"] = get_sub_field("full_shares");
										$csa_data[$csa_type]["cost_full_shares"] = get_sub_field("cost_full_shares");
										$csa_data[$csa_type]["size_full_shares"] = get_sub_field("size_full_shares");
										$csa_data[$csa_type]["size_full_shares_type"] = get_sub_field("size_full_shares_type");
										if ($csa_data[$csa_type]["full_shares"] || $csa_data[$csa_type]["cost_full_shares"] || $csa_data[$csa_type]["size_full_shares"]) {
											$csa_data[$csa_type]["has_full_shares"] = true;
											if ($csa_data[$csa_type]["size_full_shares"]) {
												if ($csa_data[$csa_type]["size_full_shares_type"]) {
													$csa_data[$csa_type]["size_full_shares"] .= " {$csa_data[$csa_type]["size_full_shares_type"]}";
												}
											} else { $csa_data[$csa_type]["size_full_shares"] = false; }
										}

										//Half Shares
										$csa_data[$csa_type]["has_half_shares"] = false;
										$csa_data[$csa_type]["half_shares"] = get_sub_field("half_shares");
										$csa_data[$csa_type]["cost_half_shares"] = get_sub_field("cost_half_shares");
										$csa_data[$csa_type]["size_half_shares"] = get_sub_field("size_half_shares");
										$csa_data[$csa_type]["size_half_shares_type"] = get_sub_field("size_half_shares_type");
										if ($csa_data[$csa_type]["half_shares"] || $csa_data[$csa_type]["cost_half_shares"] || $csa_data[$csa_type]["size_half_shares"]) {
											$csa_data[$csa_type]["has_half_shares"] = true;
											if ($csa_data[$csa_type]["size_half_shares"]) {
												if ($csa_data[$csa_type]["size_half_shares_type"]) {
													$csa_data[$csa_type]["size_half_shares"] .= " {$csa_data[$csa_type]["size_half_shares_type"]}";
												}
											} else { $csa_data[$csa_type]["size_half_shares"] = false; }
										}

										//Possible Add-ons
										$csa_data[$csa_type]["possible_addons"] = get_sub_field("possible_addons");

										//CSA/Farm share product info
										$csa_data[$csa_type]["product_sourcing"] = get_sub_field("product_sourcing");
										$csa_data[$csa_type]["product_types"] = get_sub_field("product_types");
										if (is_array($csa_data[$csa_type]["product_types"]) && count($csa_data[$csa_type]["product_types"]) > 0) {
											$tempShareProductTypeArray = array();
											foreach ($csa_data[$csa_type]["product_types"] as $temp_type) {
												$tempShareProductTypeArray[] = niceProductTypeName($temp_type);
											}
											$csa_data[$csa_type]["product_types"] = implode(", ", $tempShareProductTypeArray);
										} elseif (is_string($csa_data[$csa_type]["product_types"]) && strlen($csa_data[$csa_type]["product_types"]) > 0) {
											$csa_data[$csa_type]["product_types"] = niceProductTypeName($csa_data[$csa_type]["product_types"]);
										} else { $csa_data[$csa_type]["product_types"] = false; }
										$csa_data[$csa_type]["has_product_info"] = ($csa_data[$csa_type]["product_types"] || $csa_data[$csa_type]["product_sourcing"]) ? true : false;

										//Farm Pickup
										$csa_data[$csa_type]["has_farm_pickup"] = false;
										$csa_data[$csa_type]["has_farm_pickup"] = get_sub_field("farm_pickup");
										if ($csa_data[$csa_type]["has_farm_pickup"]) {
											$csa_data[$csa_type]["farm_pickup_hours"] = false;
											if (have_rows("farm_pickup_hours")) {
												$csa_data[$csa_type]["farm_pickup_hours"] = array();
												while (have_rows("farm_pickup_hours")) {
													the_row();
													$tempDay = get_sub_field("day");
													$tempOpenTime = get_sub_field("open_time");
													$tempCloseTime = get_sub_field("close_time");

													$tempHours = "$tempDay";
													if (strlen($tempOpenTime) > 0 && strlen($tempOpenTime) > 0) {
														$tempHours .= ": $tempOpenTime - $tempCloseTime";
													}

													$csa_data[$csa_type]["farm_pickup_hours"][] = $tempHours;
												}
												$csa_data[$csa_type]["farm_pickup_hours"] = (count($csa_data[$csa_type]["farm_pickup_hours"]) > 0) ? implode("<br>", $csa_data[$csa_type]["farm_pickup_hours"]) : false;
											}
										}

										//Other Pickup Locations
										$csa_data[$csa_type]["has_other_pickup"] = false;
										$csa_data[$csa_type]["has_other_pickup"] = get_sub_field("other_pickup");
										if ($csa_data[$csa_type]["has_other_pickup"]) {
											$csa_data[$csa_type]["other_pickup_locations"] = false;
											if (have_rows("other_pickup_locations")) {
												$csa_data[$csa_type]["other_pickup_locations"] = array();
												while (have_rows("other_pickup_locations")) {
													the_row();
													$tempLocation = array();
													$tempLName = get_sub_field("name");
													$tempLAddress = get_sub_field("address");
													$tempLHours = false;
													$tempLHoursTBD = get_sub_field("hours_tbd");
													if (is_bool($tempLHoursTBD) && $tempLHoursTBD) {
														$tempLHours = "Hours to be determined.";
													} elseif (have_rows("hours")) {
														$tempLHours = array();
														while (have_rows("hours")) {
															the_row();
															$tempDay = get_sub_field("day");
															$tempOpenTime = get_sub_field("open_time");
															$tempCloseTime = get_sub_field("close_time");

															$tempHours = "$tempDay";
															if (strlen($tempOpenTime) > 0 && strlen($tempOpenTime) > 0) {
																$tempHours .= ": $tempOpenTime - $tempCloseTime";
															}

															$tempLHours[] = $tempHours;
														}
														$tempLHours = (count($tempLHours) > 0) ? implode("<br>", $tempLHours) : false;
													}
													if ($tempLHours && $tempLName) {
														$tempLocation["hours"] = $tempLHours;
														$tempLocation["name"] = $tempLName;
														$tempLocation["address"] = ($tempLAddress) ? $tempLAddress : false;
														$csa_data[$csa_type]["other_pickup_locations"][] = $tempLocation;
													}
												}
											}
										}

										//Home Delivery
										$csa_data[$csa_type]["has_home_delivery"] = false;
										$csa_data[$csa_type]["has_home_delivery"] = get_sub_field("home_delivery");
										if ($csa_data[$csa_type]["has_home_delivery"]) {
											$csa_data[$csa_type]["home_delivery_details"] = get_sub_field("home_delivery_details");
										}

										//Section Title
										switch ($csa_type) {
											case "csa":
												$csa_data[$csa_type]["section_title"] = "Summer CSA";
												break;
											case "fall_csa":
												$csa_data[$csa_type]["section_title"] = "Autumn CSA";
												break;
											case "winter_csa":
												$csa_data[$csa_type]["section_title"] = "Winter CSA";
												break;
											case "farm_share":
												$csa_data[$csa_type]["section_title"] = "Farm Share";
												break;
											default:
												$csa_data[$csa_type]["section_title"] = "{$csa_type}";
										}
									} else {
										${"is_{$csa_type}"} = false;
									}
								}
							}

							if ($is_farm_share && ($is_fall_csa || $is_winter_csa || $is_csa)) {
								$csa_section_title = "CSA & Farm Share Details";
							} elseif ($is_farm_share) {
								$csa_section_title = "Farm Share Details";
							} else {
								$csa_section_title = "CSA Details";
							}

							if (
								($is_csa &&
									($csa_data["csa"]["has_season"] ||
									$csa_data["csa"]["has_full_shares"] ||
									$csa_data["csa"]["has_half_shares"] ||
									$csa_data["csa"]["has_product_info"] ||
									$csa_data["csa"]["possible_addons"] ||
									$csa_data["csa"]["has_farm_pickup"] ||
									$csa_data["csa"]["has_other_pickup"] ||
									$csa_data["csa"]["has_home_delivery"])) ||
								($is_winter_csa &&
									($csa_data["winter_csa"]["has_season"] ||
									$csa_data["winter_csa"]["has_full_shares"] ||
									$csa_data["winter_csa"]["has_half_shares"] ||
									$csa_data["winter_csa"]["has_product_info"] ||
									$csa_data["winter_csa"]["possible_addons"] ||
									$csa_data["winter_csa"]["has_farm_pickup"] ||
									$csa_data["winter_csa"]["has_other_pickup"] ||
									$csa_data["winter_csa"]["has_home_delivery"])) ||
								($is_fall_csa &&
									($csa_data["fall_csa"]["has_season"] ||
									$csa_data["fall_csa"]["has_full_shares"] ||
									$csa_data["fall_csa"]["has_half_shares"] ||
									$csa_data["fall_csa"]["has_product_info"] ||
									$csa_data["fall_csa"]["possible_addons"] ||
									$csa_data["fall_csa"]["has_farm_pickup"] ||
									$csa_data["fall_csa"]["has_other_pickup"] ||
									$csa_data["fall_csa"]["has_home_delivery"])) ||
								($is_farm_share &&
									($csa_data["farm_share"]["has_season"] ||
									$csa_data["farm_share"]["has_full_shares"] ||
									$csa_data["farm_share"]["has_half_shares"] ||
									$csa_data["farm_share"]["has_product_info"] ||
									$csa_data["farm_share"]["possible_addons"] ||
									$csa_data["farm_share"]["has_farm_pickup"] ||
									$csa_data["farm_share"]["has_other_pickup"] ||
									$csa_data["farm_share"]["has_home_delivery"]))): ?>
						<div class="entry-csa-details">
							<h2 class="greenHeader"><?php echo $csa_section_title; ?></h2>

							<div>
								<div class="page-block product-info-contents">
									<?php if (is_array($csa_loops) &&
										(count($csa_loops) > 0) &&
										is_array($csa_data)): //CSA - IF:A
										foreach ($csa_loops as $csa_type): //CSA - FE:A
											if (${"is_{$csa_type}"} &&
												array_key_exists($csa_type, $csa_data) &&
												($csa_data[$csa_type]["has_season"] ||
												$csa_data[$csa_type]["has_full_shares"] ||
												$csa_data[$csa_type]["has_half_shares"] ||
												$csa_data[$csa_type]["has_product_info"] ||
												$csa_data[$csa_type]["possible_addons"] ||
												$csa_data[$csa_type]["has_farm_pickup"] ||
												$csa_data[$csa_type]["has_other_pickup"] ||
												$csa_data[$csa_type]["has_home_delivery"])): //CSA - IF:B ?>
									<div class="row">
										<h3 class="col-xs-12"><?php echo $csa_data[$csa_type]["section_title"]; ?></h3>

										<?php if ($csa_data[$csa_type]["has_season"]): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Season Details</h4>
											<ul class="farming-practices-list">
												<?php
												if ($csa_data[$csa_type]["season_weeks"]) { echo "<li>Season (# of weeks): {$csa_data[$csa_type]["season_weeks"]}</li>"; }
												if ($csa_data[$csa_type]["season_start"]) { echo "<li>Season Starts: {$csa_data[$csa_type]["season_start"]}</li>"; }
												if ($csa_data[$csa_type]["season_end"]) { echo "<li>Season Ends: {$csa_data[$csa_type]["season_end"]}</li>"; }
												?>
											</ul>
										</div>
										<?php endif;

										if ($csa_data[$csa_type]["has_full_shares"]): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Full Shares</h4>
											<ul class="farming-practices-list">
												<?php
												if ($csa_data[$csa_type]["full_shares"]) echo "<li>Number of Shares: {$csa_data[$csa_type]["full_shares"]}</li>";
												if ($csa_data[$csa_type]["cost_full_shares"]) echo "<li>Cost: \${$csa_data[$csa_type]["cost_full_shares"]}</li>";
												if ($csa_data[$csa_type]["size_full_shares"]) echo "<li>Size: {$csa_data[$csa_type]["size_full_shares"]}</li>";
												?>
											</ul>
										</div>
										<?php endif;

										if ($csa_data[$csa_type]["has_half_shares"]): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Half Shares</h4>
											<ul class="farming-practices-list">
												<?php
												if ($csa_data[$csa_type]["half_shares"]) echo "<li>Number of Shares: {$csa_data[$csa_type]["half_shares"]}</li>";
												if ($csa_data[$csa_type]["cost_half_shares"]) echo "<li>Cost: \${$csa_data[$csa_type]["cost_half_shares"]}</li>";
												if ($csa_data[$csa_type]["size_half_shares"]) echo "<li>Size: {$csa_data[$csa_type]["size_half_shares"]}</li>";
												?>
											</ul>
										</div>
										<?php endif; ?>

										<?php if ($csa_data[$csa_type]["has_product_info"]): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Products</h4>
											<?php if ($csa_data[$csa_type]["product_sourcing"]) echo "<p><strong>Products sourced from:</strong> {$csa_data[$csa_type]["product_sourcing"]}</p>"; ?>
											<?php if ($csa_data[$csa_type]["product_types"]) echo "<p><strong>Product Types:</strong><br>{$csa_data[$csa_type]["product_types"]}</p>"; ?>
										</div>
										<?php endif; ?>

										<?php if ($csa_data[$csa_type]["possible_addons"]): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Possible Add-ons</h4>
											<p><?php echo $csa_data[$csa_type]["possible_addons"]; ?></p>
										</div>
										<?php endif; ?>
									</div>

										<?php if ($csa_data[$csa_type]["has_farm_pickup"] || $csa_data[$csa_type]["has_other_pickup"] || $csa_data[$csa_type]["has_home_delivery"]): ?>
									<div class="row">
										<h4 class="col-xs-12 pickup-heading">Pick-up Locations</h3>

										<?php if ($csa_data[$csa_type]["has_farm_pickup"] && $csa_data[$csa_type]["farm_pickup_hours"]): ?>
										<div class="col-sm-4 practices-wrap">
											<h5>Farm Pick-up</h5>
											<p><?php echo $csa_data[$csa_type]["farm_pickup_hours"]; ?></p>
										</div>
										<?php endif;

										if ($csa_data[$csa_type]["has_other_pickup"] && is_array($csa_data[$csa_type]["other_pickup_locations"])):
											foreach($csa_data[$csa_type]["other_pickup_locations"] as $other_pickup_location): ?>
										<div class="col-sm-4 practices-wrap">
											<h5><?php echo $other_pickup_location["name"]; ?></h5>
											<?php
											if ($other_pickup_location["address"]) echo "<p>{$other_pickup_location["address"]}</p>";
											if ($other_pickup_location["hours"]) echo "<p>{$other_pickup_location["hours"]}</p>";
											?>
										</div>
										<?php endforeach;
										endif;

										if ($csa_data[$csa_type]["has_home_delivery"]): ?>
										<div class="col-sm-4 practices-wrap">
											<h5>Home Delivery</h5>
											<?php if ($csa_data[$csa_type]["home_delivery_details"]) echo "<p>{$csa_data[$csa_type]["home_delivery_details"]}</p>"; ?>
										</div>
										<?php endif; ?>

									</div>
										<?php endif; ?>
									<?php
											endif; //END CSA - IF:B
										endforeach; //END CSA - FE:A
									endif; //END CSA - IF:A ?>
								</div><!-- end div.product-info-contents -->
							</div><!-- end div -->
						</div><!-- end div.entry-csa-details -->
						<?php endif; endif; ?>

						<?php if ($is_agritourism && $agritourism_products): ?>
						<div class="entry-agritourism" id="agritourism">
							<h2 class="greenHeader"><?php echo $agritourism_heading; ?></h2>

							<div>
								<div class="page-block product-info-contents">
									<?php if ($agritourism_photo): ?>
									<div class="product-info-left">
										<div class="agritourism-photo">
											<img src="<?php echo $agritourism_photo; ?>" class="img-responsive">
										</div>
									</div>
									<?php endif; ?>

									<div class="<?php if ($agritourism_photo) echo "product-info-right "; ?>entry-content">
										<h3><?php echo $agritourism_events_heading; ?></h3>
										<?php
											$agritourism_events = array();
											if (have_rows("agritourism_events", $acf_partner_id)) {
												echo "<div class=\"row\">";
												while (have_rows("agritourism_events", $acf_partner_id)) {
													the_row();
													$tempEventTitle = get_sub_field("title");
													$tempEventDesc = get_sub_field("description");
													$tempHasSeason = get_sub_field("is_seasonal");
													$tempSeasonString = "";
													$tempHasHours = false;
													$tempHours = array();
													if ($tempHasSeason) {
														$tempSeasonStartMonthPart = get_sub_field("season_start_mpart");
														$tempSeasonStartMonth = get_sub_field("season_start_month");
														$tempSeasonEndMonthPart = get_sub_field("season_end_mpart");
														$tempSeasonEndMonth = get_sub_field("season_end_month");


														if ($tempSeasonStartMonth && $tempSeasonStartMonthPart) {
															$tempSeasonStart = "$tempSeasonStartMonthPart $tempSeasonStartMonth";
														} elseif ($tempSeasonStartMonth) {
															$tempSeasonStart = "$tempSeasonStartMonth";
														}

														if ($tempSeasonEndMonth && $tempSeasonEndMonthPart) {
															$tempSeasonEnd = "$tempSeasonEndMonthPart $tempSeasonEndMonth";
														} elseif ($tempSeasonEndMonth) {
															$tempSeasonEnd = "$tempSeasonEndMonth";
														}

														if ($tempSeasonStart && $tempSeasonEnd) {
															$tempSeasonString = "$tempSeasonStart - $tempSeasonEnd";
														} else {
															$tempHasSeason = false;
														}
													}

													if (have_rows("hours")) {
														while (have_rows("hours")) {
															the_row();
															$tempDay = get_sub_field("day");
															$tempOpen = get_sub_field("open_time");
															$tempClose = get_sub_field("open_time");
															if ($tempDay) {
																$tempHour = "$tempDay";
																if ($tempOpen && $tempClose) {
																	$tempHour .= ": $tempOpen - $tempClose";
																}
																$tempHours[] = $tempHour;
															}
														}
													}


													if ($tempEventTitle && ($tempEventDesc || $tempHasSeason || count($tempHours) > 0)): ?>
														<div class="<?php echo $agritourism_event_class; ?>">
															<h5><?php echo $tempEventTitle; ?></h5>
															<?php if ($tempEventDesc) echo "<p class=\"description\">$tempEventDesc</p>"; ?>
															<?php if ($tempHasSeason) echo "<p class=\"season\">$tempSeasonString</p>"; ?>
															<?php if (count($tempHours) > 0) {
																echo "<p class=\"hours\">";
																foreach($tempHours as $tempHour) {
																	echo "$tempHour<br>";
																}
																echo "</p>";
															} ?>
														</div>
													<?php endif;
												}
												echo "</div>";
											} elseif ($agritourism_products) echo "<p><em>{$agritourism_products_string}</em></p>"; ?>
									</div>
								</div>
							</div>
						</div><!-- end div.entry-agritourism -->
						<?php endif; ?>

						<?php if (in_array("farm", $partner_category)):
							$certified_organic = get_field("certified_organic", $acf_partner_id);
							$certified_naturally_grown = get_field("certified_naturally_grown", $acf_partner_id);
							$certified_biodynamic = get_field("certified_biodynamic", $acf_partner_id);

							if ($certified_organic) {
								$certified_organic_since = get_field("certified_organic_since", $acf_partner_id);
								$certified_organic_by = get_field("certified_organic_by", $acf_partner_id);
							}
							if ($certified_naturally_grown) {
								$certified_naturally_grown_since = get_field("certified_naturally_grown_since", $acf_partner_id);
							}
							if ($certified_biodynamic) {
								$certified_biodynamic_since = get_field("certified_biodynamic_since", $acf_partner_id);
								$certified_biodynamic_by = get_field("certified_biodynamic_by", $acf_partner_id);
							}

							$only_organic = get_field("only_organic", $acf_partner_id);
							$integrated_pest_management = get_field("integrated_pest_management", $acf_partner_id);
							$non_gmo = get_field("non_gmo", $acf_partner_id);
							$antibiotic_harmone_free = get_field("antibiotic_harmone_free", $acf_partner_id);
							$pastured = get_field("pastured", $acf_partner_id);
							$grass_fed = get_field("grass_fed", $acf_partner_id);
							$extended_growing_season = get_field("extended_growing_season", $acf_partner_id);
							$has_other_practices = get_field("has_other_practices", $acf_partner_id);
							$has_other_practices = (is_bool($has_other_practices) && $has_other_practices) ? $has_other_practices : false;
							$other_farming_practices_text = ($has_other_practices) ? get_field("other_practices", $acf_partner_id) : false;

							$accept_snap = get_field("accept_snap", $acf_partner_id);
							$accept_fmnp = get_field("accept_fmnp", $acf_partner_id);

							$certifications = ($certified_organic || $certified_naturally_grown || $certified_biodynamic) ? true : false;
							$practices = ($only_organic || $integrated_pest_management || $non_gmo || $antibiotic_harmone_free || $pastured || $grass_fed || $extended_growing_season || $other_farming_practices_text) ? true : false;
							$benefits = ($accept_fmnp || $accept_snap) ? true : false;

							if ($certifications ||
								$practices ||
								$benefits ||
								$has_acreage): ?>
						<div class="entry-farm-practices">
							<h2 class="greenHeader">Farm Details</h2>

							<div>
								<div class="page-block product-info-contents">
									<?php if ($certifications || $practices || $benefits || $has_acreage): ?>
									<div class="row">
										<h3 class="col-xs-12">Farming Practices</h3>
										<?php if ($certifications): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Certifications</h4>
											<ul class="farming-practices-list">
												<?php
												if ($certified_organic) {
													echo "<li>Certified Organic";
													if ($certified_organic_by || $certified_organic_since) {
														echo "<br><em>(";
														if ($certified_organic_since) {
															echo "Since: $certified_organic_since";
														}
														if ($certified_organic_since && $certified_organic_by) {
															echo " | ";
														}
														if ($certified_organic_by) {
															echo "By: $certified_organic_by";
														}
														echo ")</em>";
													}
													echo "</li>";
												}
												if ($certified_naturally_grown) {
													echo "<li>Certified Naturally Grown";
													if ($certified_naturally_grown_since) {
														echo "<br><em>(Since: $certified_naturally_grown_since)</em>";
													}
													echo "</li>";
												}
												if ($certified_biodynamic) {
													echo "<li>Certified Biodynamic";
													if ($certified_biodynamic_by || $certified_biodynamic_since) {
														echo "<br><em>(";
														if ($certified_biodynamic_since) {
															echo "Since: $certified_biodynamic_since";
														}
														if ($certified_biodynamic_since && $certified_biodynamic_by) {
															echo " | ";
														}
														if ($certified_biodynamic_by) {
															echo "By: $certified_biodynamic_by";
														}
														echo ")</em>";
													}
													echo "</li>";
												}
												?>
											</ul>
										</div>
										<?php endif;

										if ($practices): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Practices</h4>
											<ul class="farming-practices-list">
												<?php
												if ($only_organic) { echo "<li>Use Only Organic Materials</li>"; }
												if ($integrated_pest_management) { echo "<li>Integrated Pest Management (IPM)</li>"; }
												if ($non_gmo) { echo "<li>Non-GMO</li>"; }
												if ($antibiotic_harmone_free) { echo "<li>Antibiotic and Hormone Free</li>"; }
												if ($pastured) { echo "<li>Pastured</li>"; }
												if ($grass_fed) { echo "<li>100% Grass Fed</li>"; }
												if ($extended_growing_season) { echo "<li>Extended Growing Season</li>"; }
												?>
											</ul>
												<?php if ($other_farming_practices_text): ?>
											<h5 style="margin: 5px 0 0;">Other Practices</h5>
											<?php echo $other_farming_practices_text; ?>
											</p>
												<?php endif; ?>
										</div>
										<?php endif;

										if ($benefits): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Benefits Acceptance</h4>
											<ul class="farming-practices-list">
											<?php
												if ($accept_snap) { echo "<li>Accept SNAP</li>"; }
												if ($accept_fmnp) { echo "<li>Accept FMNP</li>"; }
											?>
											</ul>
										</div>
										<?php endif;

										if ($has_acreage): ?>
										<div class="col-sm-4 practices-wrap">
											<h4>Acreage</h4>
											<ul class="farming-practices-list">
											<?php
												if ($acres_owned) { echo "<li>Acres Owned: {$acres_owned}</li>"; }
												if ($acres_rented) { echo "<li>Acres Rented: {$acres_rented}</li>"; }
												if ($acres_production) { echo "<li>Acres in Production: {$acres_production}</li>"; }
											?>
											</ul>
										</div>
										<?php endif; ?>
									</div>
									<?php endif; ?>
								</div><!-- end div.product-info-contents -->
							</div><!-- end div -->
						</div><!-- end div.entry-farm-practices -->
						<?php endif; endif; ?>

					</section><!-- end section.partner-content -->

				</article><!-- end article.partner-profile -->
				<?php get_template_part("bfbl", "chips"); ?>
			</section><!-- end section.main-content -->
<?php get_footer(); ?>