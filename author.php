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
					$partner_owner_name = (!$partner_owner_name && $partner_contact_name) ? $partner_contact_name : false;

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
							$tempIsSeasonal = get_sub_field("is_seasonal");
							if ($tempIsSeasonal) {
								$tempSeasonStartMonthPart = get_sub_field("season_start_mpart");
								$tempSeasonStartMonth = get_sub_field("season_start_month");
								$tempSeasonEndMonthPart = get_sub_field("season_end_mpart");
								$tempSeasonEndMonth = get_sub_field("season_end_month");
							}
							$tempVendors = get_sub_field("vendors");
							$tempVendors = (is_string($tempVendors) && strlen($tempVendors) > 0) ? $tempVendors : false;

							$tempHours = "$tempDay: $tempOpenTime - $tempCloseTime";
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
						$ws_products["agritourism"] = get_field("ws_products_agritourism", $acf_partner_id);
						$ws_products["fibers"] = get_field("ws_products_fibers", $acf_partner_id);
						$ws_products["artisinal"] = get_field("ws_products_artisinal", $acf_partner_id);
						$ws_products["liquids"] = get_field("ws_products_liquids", $acf_partner_id);
						$ws_products["educational"] = get_field("ws_products_educational", $acf_partner_id);
						$ws_products["baked"] = get_field("ws_products_baked", $acf_partner_id);
						$ws_products["seeds"] = get_field("ws_products_seeds", $acf_partner_id);
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

										<?php if ($partner_bio): ?>
										<div class="partner-description entry-content">
											<?php echo $partner_bio; ?>
										</div><!-- end div.partner-description -->
										<?php endif; ?>

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
											<ul>
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
									<?php if ((!in_array("farm", $partner_category) && $partner_business_photo) || $partner_owner_photo): ?></div><!-- end div.partner-info-right --><?php endif; ?>

									<?php if ((!in_array("farm", $partner_category) && $partner_business_photo) || $partner_owner_photo): ?>
									<div class="partner-info-left">
										<div class="owner-details">
											<?php if (in_array("farm", $partner_category)) {
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
											?>
										</div><!-- end div.owner-details -->

										<?php if ($partner_facebook || $partner_twitter || $partner_instagram): ?>
										<div class="partner-social">
											<h4>Social Media</h4>
											<ul>
												<?php
													if ($partner_twitter) echo "<li class='twitter'><a href=\"https://twitter.com/$partner_twitter\" target=\"_blank\"><span>@$partner_twitter</span></a></li>";
													if ($partner_facebook) echo "<li class='facebook'><a href=\"$partner_facebook\" target=\"_blank\"><span>" . bfblExtractName($partner_facebook) ."</span></a></li>";
													if ($partner_instagram) echo "<li class='instagram'><a href=\"https://www.instagram.com/$partner_instagram\" target=\"_blank\"><span>@$partner_instagram</span></a></li>";
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
									<?php if ($partner_business_photo): ?>
									<div class="product-info-left">
										<?php
										if ($partner_business_photo) {
											echo '<div class="business-image">';
												echo $partner_business_photo;
											echo '</div><!-- end div.business-image -->';
										}
										?>
									</div><!-- end div.product-info-left -->
									<?php endif; ?>

									<?php if ($partner_business_photo): ?><div class="product-info-right"><?php endif; ?>
										<div class="products-detail">
											<?php if ($hasProducts || $productsText) : ?>
											<div class="entry-product-categories entry-content">
												<h3>Products Available</h3>
												<?php
												if ($hasProducts) {
													$productsAvailable = array();
													foreach($products as $productCategory=>$productCategoryProducts) {
														if (is_array($productCategoryProducts) && count($productCategoryProducts) > 0) {
															foreach ($productCategoryProducts as $productCategoryProductKey => $productCategoryProduct) {
																if ($productCategoryProduct) {
																	if (is_int($productCategoryProductKey) && $productCategoryProduct !== "Other") {
																		$productsAvailable[] = $productCategoryProduct;
																	} elseif ($productCategoryProductKey === "other") {
																		$productsAvailable[] = strip_tags($productCategoryProduct);
																	}
																}
															}
														}
													}
													if (count($productsAvailable) > 0) {
														$productsAvailable = implode(", ", $productsAvailable);

														echo "<p>$productsAvailable</p>";
													}
												} elseif ($productsText) {
													echo "<p>$productsText</p>";
												}
												?>
											</div><!-- end div.entry-product-categories -->
											<?php endif; ?>


											<?php
											if (is_array($products_available_at) && count($products_available_at) > 0): ?>
											<h4>Buy our our products at these BFBLGLV partners</h4>
											<ul class="vendor-list">
												<?php foreach ($products_available_at as $vendor):
													if (is_object($vendor)):
														$vendor_id = "user_{$vendor->ID}";
														$vendor_url = get_author_posts_url($vendor_id);
														$vendor_name = get_field("partner_name", "user_{$vendor_id}");
														$vendor_city = get_field("partner_city", "user_{$vendor_id}");
														$vendor_name .= ($vendor_city) ? ", $vendor_city" : "";
														echo "<li><a href=\"$vendor_url\">$vendor_name</a></li>\n";
													endif;
												endforeach; ?>
											</ul>
											<?php endif; ?>

											<?php
											if (is_array($products_available_from) && count($products_available_from) > 0): ?>
											<h4>We also offer products from these BFBLGLV partners</h4>
											<ul class="vendor-list">
												<?php foreach ($products_available_from as $vendor):
													if (is_object($vendor)):
														$vendor_id = "user_{$vendor->ID}";
														$vendor_url = get_author_posts_url($vendor_id);
														$vendor_name = get_field("partner_name", "user_{$vendor_id}");
														$vendor_city = get_field("partner_city", "user_{$vendor_id}");
														$vendor_name .= ($vendor_city) ? ", $vendor_city" : "";
														echo "<li><a href=\"$vendor_url\">$vendor_name</a></li>\n";
													endif;
												endforeach; ?>
											</ul>
											<?php endif; ?>

											<?php
											if (is_array($source_from) && count($source_from) > 0): ?>
											<h4>We source from these BFBLGLV partners</h4>
											<ul class="vendor-list">
												<?php foreach ($source_from as $vendor):
													if (is_object($vendor)):
														$vendor_id = "user_{$vendor->ID}";
														$vendor_url = get_author_posts_url($vendor_id);
														$vendor_name = get_field("partner_name", "user_{$vendor_id}");
														$vendor_city = get_field("partner_city", "user_{$vendor_id}");
														$vendor_name .= ($vendor_city) ? ", $vendor_city" : "";
														echo "<li><a href=\"$vendor_url\">$vendor_name</a></li>\n";
													endif;
												endforeach; ?>
											</ul>
											<?php endif; ?>

											<?php if ($local_stock_freq && $local_stock_qty)
												echo "<p><em>We $local_stock_freq have $local_stock_qty locally grown ingredients in our menu items.</em></p>"; ?>

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
													$ws_productsAvailable = array();
													foreach($ws_products as $productCategory=>$productCategoryProducts) {
														if (is_array($productCategoryProducts) && count($productCategoryProducts) > 0) {
															foreach ($productCategoryProducts as $productCategoryProductKey => $productCategoryProduct) {
																if ($productCategoryProduct) {
																	if (is_int($productCategoryProductKey) && $productCategoryProduct !== "Other") {
																		$ws_productsAvailable[] = $productCategoryProduct;
																	} elseif ($productCategoryProductKey === "other") {
																		$ws_productsAvailable[] = strip_tags($productCategoryProduct);
																	}
																}
															}
														}
													}
													if (count($ws_productsAvailable) > 0) {
														$ws_productsAvailable = implode(", ", $ws_productsAvailable);

														echo "<p>$ws_productsAvailable</p>";
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
							$other_farming_practices_text = get_field("other_farming_practices_text", $acf_partner_id);

							$accept_snap = get_field("accept_snap", $acf_partner_id);
							$accept_fmnp = get_field("accept_fmnp", $acf_partner_id);

							$certifications = ($certified_organic || $certified_naturally_grown || $certified_biodynamic) ? true : false;
							$practices = ($only_organic || $integrated_pest_management || $non_gmo || $antibiotic_harmone_free || $pastured || $grass_fed || $extended_growing_season || $other_farming_practices_text) ? true : false;
							$benefits = ($accept_fmnp || $accept_snap) ? true : false;

							$is_csa = get_field("is_csa", $acf_partner_id);
							$is_farm_share = get_field("is_farm_share", $acf_partner_id);

							$csa_heading = false;
							if ($is_csa && $is_farm_share) {
								$csa_heading = "CSA &amp; Farm Share Details";
							} elseif ($is_csa && !$is_farm_share) {
								$csa_heading = "CSA Details";
							} elseif (!$is_csa && $is_farm_share) {
								$csa_heading = "Farm Share Details";
							}

							if ($is_csa || $is_farm_share) {
								$season_weeks = get_field("season_weels", $acf_partner_id);
								$season_start_mpart = get_field("season_start_mpart", $acf_partner_id);
								$season_start = get_field("season_start_month", $acf_partner_id);
								$season_end_mpart = get_field("season_end_mpart", $acf_partner_id);
								$season_end = get_field("season_end_month", $acf_partner_id);
								$season_start = ($season_start_mpart && $season_start) ? "$season_start_mpart $season_start" : $season_start;
								$season_end = ($season_end_mpart && $season_end) ? "$season_end_mpart $season_end" : $season_end;
								$season_string = ($season_start) ? $season_string : "";
								$season_string .= ($season_start && $season_end) ? " $season_end" : "";
								$season_string .= ($season_end && !$season_start) ? $season_end : "";
								$has_season = ($season_weeks || $season_string) ? true : false;

								//Full Shares
								$has_full_shares = false;
								$full_shares = get_field("full_shares", $acf_partner_id);
								$cost_full_shares = get_field("cost_full_shares", $acf_partner_id);
								$size_full_shares = get_field("size_full_shares", $acf_partner_id);
								$size_full_shares_type = get_field("size_full_shares_type", $acf_partner_id);
								if ($full_shares || $cost_full_shares || $size_full_shares) {
									$has_full_shares = true;
									$size_full_shares .= ($size_full_shares_type && $size_full_shares) ? " $size_full_shares_type" : ""; 
								}

								//Half Shares
								$has_half_shares = false;
								$half_shares = get_field("half_shares", $acf_partner_id);
								$cost_half_shares = get_field("cost_half_shares", $acf_partner_id);
								$size_half_shares = get_field("size_half_shares", $acf_partner_id);
								$size_half_shares_type = get_field("size_half_shares_type", $acf_partner_id);
								if ($half_shares || $cost_half_shares || $size_half_shares) {
									$has_half_shares = true;
									$size_half_shares .= ($size_half_shares_type && $size_half_shares) ? " $size_half_shares_type" : ""; 
								}

								//Possible Add-ons
								$possible_addons = get_field("possible_addons", $acf_partner_id);

								//Farm Pickup
								$has_farm_pickup = get_field("farm_pickup", $acf_partner_id);
								if ($has_farm_pickup) {
									$farm_pickup_hours = false;
									if (have_rows("farm_pickup_hours", $acf_partner_id)) {
										$farm_pickup_hours = array();
										while (have_rows("farm_pickup_hours", $acf_partner_id)) {
											the_row();
											$tempDay = get_sub_field("day");
											$tempOpenTime = get_sub_field("open_time");
											$tempCloseTime = get_sub_field("close_time");

											$tempHours = "$tempDay: $tempOpenTime - $tempCloseTime";
											$farm_pickup_hours[] = $tempHours;
										}
										$farm_pickup_hours = (count($farm_pickup_hours) > 0) ? implode("<br>", $farm_pickup_hours) : false;
									}
								}
								//Other Pickup Locations
								$has_other_pickup = get_field("other_pickup", $acf_partner_id);
								if ($has_other_pickup) {
									$other_pickup_locations = false;
									if (have_rows("other_pickup_locations", $acf_partner_id)) {
										$other_pickup_locations = array();
										while (have_rows("other_pickup_locations", $acf_partner_id)){
											the_row();
											$tempLocation = array();
											$tempLName = get_sub_field("name");
											$tempLAddress = get_sub_field("address");
											$tempLHours = false;
											if (have_rows("hours")) {
												$tempLHours = array();
												while (have_rows("hours")) {
													the_row();
													$tempDay = get_sub_field("day");
													$tempOpenTime = get_sub_field("open_time");
													$tempCloseTime = get_sub_field("close_time");

													$tempHours = "$tempDay: $tempOpenTime - $tempCloseTime";
													$tempLHours[] = $tempHours;
												}
												$tempLHours = (count($farm_pickup_hours) > 0) ? implode("<br>", $tempLHours) : false;
											}
											if ($tempLHours && $tempLName) {
												$tempLocation["hours"] = $tempLHours;
												$tempLocation["name"] = $tempLName;
												$tempLocation["address"] = ($tempLAddress) ? $tempLAddress : false;
												$other_pickup_locations[] = $tempLocation;
											}
										}
									}
								}
							}
						?>
						<div class="entry-farm-practices">
							<h2 class="greenHeader">Farm Details</h2>

							<div>
								<div class="page-block product-info-contents">
									<?php if ($certifications || $practices || $benefits): ?>
									<div class="row">
										<h3 class="col-xs-12">Farming Practices</h3>
										<?php if ($certifications): ?>
										<div class="col-md-4">
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
										<div class="col-md-4">
											<h4>Practices</h4>
											<ul class="farming-practices-list">
												<?php
												if ($only_organic) { echo "<li>Use Only Organic Materials</li>"; }
												if ($integrated_pest_management) { echo "<li>Intergrated Pest Management (IPM)</li>"; }
												if ($non_gmo) { echo "<li>Non-GMO</li>"; }
												if ($antibiotic_harmone_free) { echo "<li>Antibiotic and Hormone Free</li>"; }
												if ($pastured) { echo "<li>Pastured</li>"; }
												if ($grass_fed) { echo "<li>100% Grass Fed</li>"; }
												if ($extended_growing_season) { echo "<li>Extended Growing Season</li>"; }
												?>
											</ul>
												<?php if ($other_farming_practices_text): ?>
											<p><strong>Other Practices</strong><br>
											<?php echo $other_farming_practices_text; ?>
											</p>
												<?php endif; ?>
										</div>
										<?php endif;

										if ($benefits): ?>
										<div class="col-md-4">
											<h4>Benefits Acceptance</h4>
											<ul class="farming-practices-list">
											<?php
												if ($accept_snap) { echo "<li>Accept SNAP</li>"; }
												if ($accept_fmnp) { echo "<li>Accept FMNP</li>"; }
											?>
											</ul>
										</div>
										<?php endif; ?>
									</div>
									<?php endif; ?>


									<?php if (($is_csa || $is_farm_share) && ($has_season || $has_full_shares || $has_half_shares || $possible_addons || $has_farm_pickup || $has_other_pickup)): ?>
									<div class="row">
										<h3 class="col-xs-12"><?php echo $csa_heading; ?></h3>
										<?php if ($has_season): ?>
										<div class="col-md-4">
											<h4>Season Details</h4>
											<ul class="farming-practices-list">
												<?php
												if ($season_weeks) { echo "<li>Season (# of weeks): $season_weeks</li>"; }
												if ($seaon_start) { echo "<li>Season Start: $season_start"; }
												if ($seaon_end) { echo "<li>Season End: $season_end"; }
												?>
											</ul>
										</div>
										<?php endif;

										if ($has_full_shares): ?>
										<div class="col-md-4">
											<h4>Full Shares</h4>
											<ul class="farming-practices-list">
												<?php
												if ($full_shares) echo "<li>Number of Shares: $full_shares</li>";
												if ($cost_full_shares) echo "<li>Cost: \$$cost_full_shares</li>";
												if ($size_full_shares) echo "<li>Size: $size_full_shares</li>";
												?>
											</ul>
												<?php if ($other_farming_practices_text): ?>
											<p><strong>Other Practices</strong><br>
											<?php echo $other_farming_practices_text; ?>
											</p>
												<?php endif; ?>
										</div>
										<?php endif;

										if ($has_half_shares): ?>
										<div class="col-md-4">
											<h4>Half Shares</h4>
											<ul class="farming-practices-list">
												<?php
												if ($full_shares) echo "<li>Number of Shares: $half_shares</li>";
												if ($cost_full_shares) echo "<li>Cost: \$$cost_half_shares</li>";
												if ($size_full_shares) echo "<li>Size: $size_half_shares</li>";
												?>
											</ul>
										</div>
										<?php endif; ?>
									</div>
									<?php endif; ?>

									<?php if ($possible_addons): ?>
									<div class="row">
										<h4 class="col-xs-12">Possible Addons</h4>
										<div class="col-xs-12">
											<p><?php echo $possible_addons; ?></p>
										</div>
									</div>>
									<?php endif; ?>

									<?php if ($has_farm_pickup || $has_other_pickup): ?>
									<div class="row">
										<h3 class="col-xs-12">Pickup Locations</h3>

										<?php if ($has_farm_pickup && $farm_pickup_hours): ?>
										<div class="col-md-4">
											<h4>Farm Pickup</h4>
											<p><?php echo $farm_pickup_hours; ?></p>
										</div>
										<?php endif; ?>

										<?php if ($has_other_pickup && is_array($other_pickup_locations)):
											foreach($other_pickup_locations as $other_pickup_location): ?>
										<div class="col-md-4">
											<h4><?php echo $other_pickup_location["name"]; ?></h4>
											<?php if ($other_pickup_location["address"]) echo "<p>{$other_pickup_location["address"]}</p>"; ?>
											<p><?php echo $other_pickup_location["hours"]; ?></p>
										</div>
										<?php endforeach;
										endif; ?>
									</div>
									<?php endif; ?>
								</div><!-- end div.product-info-contents -->
							</div><!-- end div -->
						</div><!-- end div.entry-wholesale-information -->
						<?php endif; ?>

					</section><!-- end section.partner-content -->

				</article><!-- end article.partner-profile -->
				<?php get_template_part("bfbl", "chips"); ?>
			</section><!-- end section.main-content -->
<?php get_footer(); ?>