<?php
/**
 * Template Name: Find Local Food
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header();
$activeCounties = get_active_counties();
$specificProducts = get_specific_products();
?>
			<?php get_template_part("entry", "partner-header"); ?>
			<div class="page-block acf-map-wrap">
				<div class="acf-map results-map"></div>
			</div><!-- end div.acf-map-wrap -->
			<section class="main-content" role="main">

				<section class="map-form">
					<form id="find-local-food-form">
						<section class="form-section bfblSlider sliderOpen">
							<h2 class="greenHeader">Location</h2>
							<div class="bfblSlideWrap">

							<!-- <div class="form-inline page-block"> -->
								<div class="form-inline page-block map-county-zip">
									<?php if ($activeCounties): ?>
									<div class="county-select-wrap">

								<!-- <select name="county" aria-label="County" class="form-control"> -->
									<select name="county" aria-label="County" class="county-select">
									<!-- <option value="" default>County</option> -->
										<option value="" selected></option>
										<?php foreach ($activeCounties as $county): ?>
										<option value="<?php echo $county; ?>"><?php echo $county; ?></option>
										<?php endforeach; ?>
									</select>
									</div><!-- end div.county-select-wrap -->

									<span>or</span>
									<?php endif; ?>
									<div class="zip-input-group">
										<input class="zip-input" name="zip" placeholder="Zip Code" aria-label="Zip Code">
								    	<button class="zip-btn" type="button"><span class="screen-reader-text">Search</span></button>
									</div><!-- end div.input-group -->
								</div><!-- end div.form-inline -->
							</div><!-- end div.bfblSlideWrap -->
						</section>

						<section class="form-section bfblSlider sliderOpen">
							<h2 class="greenHeader">Location Type</h2>
							<div class="bfblSlideWrap">
								<div class="form-inline page-block map-checkboxes">
									<label><input type="checkbox" name="location_type[]" value="distillery"><span>Breweries &amp; Distilleries</span></label>
									<label><input type="checkbox" name="location_type[]" value="csa"><span>CSAs</span></label>
									<label><input type="checkbox" name="location_type[]" value="distributor"><span>Distributors</span></label>
									<label><input type="checkbox" name="location_type[]" value="farm"><span>Farms</span></label>
									<label><input type="checkbox" name="location_type[]" value="farmers-market"><span>Farmers' Markets</span></label>
									<label><input type="checkbox" name="location_type[]" value="farm-share"><span>Farm Shares</span></label>
									<label><input type="checkbox" name="location_type[]" value="institution"><span>Institutions</span></label>
									<label><input type="checkbox" name="location_type[]" value="restaurant"><span>Restaurants / Caterers</span></label>
									<label><input type="checkbox" name="location_type[]" value="specialty"><span>Specialty Products</span></label>
									<label><input type="checkbox" name="location_type[]" value="retail"><span>Stores / Retail</span></label>
									<label><input type="checkbox" name="location_type[]" value="vineyard"><span>Vineyards</span></label>
								</div><!-- end div.map-checkboxes -->
							</div><!-- end div.bfblSlideWrap -->
						</section>

						<section class="form-section bfblSlider sliderClosed initialClosed product-types-section">
							<h2 class="greenHeader">Product Type</h2>
							<div class="bfblSlideWrap">

								<div class="form-inline page-block map-checkboxes">
									<label><input type="checkbox" name="product_type[]" value="agritourism"><span>Agritourism</span></label>
									<label><input type="checkbox" name="product_type[]" value="artisinal"><span>Artisanal Products</span></label>
									<label><input type="checkbox" name="product_type[]" value="baked"><span>Baked Goods</span></label>
									<label><input type="checkbox" name="product_type[]" value="berries"><span>Berries</span></label>
									<label><input type="checkbox" name="product_type[]" value="liquids"><span>Beverages</span></label>
									<label><input type="checkbox" name="product_type[]" value="dairy"><span>Dairy</span></label>
									<label><input type="checkbox" name="product_type[]" value="educational"><span>Educational Programs</span></label>
									<label><input type="checkbox" name="product_type[]" value="flowers"><span>Flowers</span></label>
									<label><input type="checkbox" name="product_type[]" value="grains"><span>Grains</span></label>
									<label><input type="checkbox" name="product_type[]" value="greens"><span>Greens</span></label>
									<label><input type="checkbox" name="product_type[]" value="herbs"><span>Herbs</span></label>
									<label><input type="checkbox" name="product_type[]" value="syrups"><span>Honey / Syrups</span></label>
									<label><input type="checkbox" name="product_type[]" value="meat"><span>Meat</span></label>
									<label><input type="checkbox" name="product_type[]" value="melons"><span>Melons &amp; Pumpkins</span></label>
									<label><input type="checkbox" name="product_type[]" value="seeds"><span>Nuts / Seeds</span></label>
									<label><input type="checkbox" name="product_type[]" value="small_fruits"><span>Orchard &amp; Small Fruits</span></label>
									<label><input type="checkbox" name="product_type[]" value="ornamentals"><span>Ornamentals</span></label>
									<label><input type="checkbox" name="product_type[]" value="pyo"><span>Pick Your Own</span></label>
									<label><input type="checkbox" name="product_type[]" value="plants"><span>Plants</span></label>
									<label><input type="checkbox" name="product_type[]" value="poultry"><span>Poultry</span></label>
									<label><input type="checkbox" name="product_type[]" value="roots"><span>Root Crops</span></label>
									<label><input type="checkbox" name="product_type[]" value="seasonal"><span>Seasonal Vegetables</span></label>
									<label><input type="checkbox" name="product_type[]" value="value_added"><span>Value-Added</span></label>
									<label><input type="checkbox" name="product_type[]" value="fibers"><span>Wool / Fibers</span></label>

									<label><input type="checkbox" name="product_type[]" value="misc"><span>Miscellaneous [e.g. Eggs]</span></label>
								</div><!-- end div.map-checkboxes -->

								<div class="map-specific-prods page-block">
									<label>
										<span class="map-subhead">Looking for a <br />specific product?</span>
										<select name="specific_products" multiple class="chosen-specific-products">
											<?php foreach ($specificProducts as $specificProduct): if (!is_string($specificProduct) || (is_string($specificProduct) && strlen($specificProduct) < 1)) { continue; } ?>
											<option value="<?php echo $specificProduct; ?>"><?php echo $specificProduct; ?></option>
											<?php endforeach; ?>
										</select>
									</label>
								</div><!-- end div.map-specific-prods -->
							</div><!-- end div.bfblSlideWrap -->
						</section>

						<section class="form-section wholesale-section">
                            <?php if (is_user_logged_in()):
                                $wholesaleChecked = (isset($_REQUEST["wholesale"]) && ($_REQUEST["wholesale"] == "true" || $_REQUEST["wholesale"] == "1")) ? true : false; ?>
							<label class='greenHeader'><input type="checkbox" name="wholesale" value="1"<?php if ($wholesaleChecked) { echo " checked"; } ?>><span>Wholesale</span></label>
                            <?php else: ?>
							<label class='greenHeader'><input disabled type="checkbox" name="wholesale" value="1"><span>Wholesale <span class="warning">(Must be logged in<span class="hidden-xs"> for access</span>)</span></span></label>
                            <?php endif; ?>
						</section>
					</form>
				</section><!-- end section.map-form -->

				<div class="map-page-middle">
					<section class="finder-search-results page-block">
						<h2 class="map-subhead">Search Results</h2>
						<p class="results-total">Total: <span class="count"></span></p>
						<ul class="results-list"></ul><!-- end ul.results-list -->
					</section>
					<?php if (false): ?>
					<div class="map-chip page-block tan-shadow">
						<?php
							$mapChip = '';

							if(have_rows('chips', 'option')):
								while ( have_rows('chips', 'option') ) : the_row();

									$chipTitle = get_sub_field('chip_title');
									$chipDescr = get_sub_field('chip_description');
									$chipImg = get_sub_field('chip_image');
									$chipLink = get_sub_field('chip_page');
									$chipShow = get_sub_field('chip_map');

									if($chipShow) {
										$mapChip = ''; // clear out the variable; only one chip should be shown, even if multiple ones are checked off.

										$mapChip .= "<div class='chip'>";
											$mapChip .= "<span class='chipImg' style='background-image: url(" . $chipImg['sizes']['medium'] . ")'>";
												$mapChip .= "<img src='" . $chipImg['sizes']['thumbnail'] . "' alt='' />";
											$mapChip .= "</span>";
											$mapChip .= "<span class='chipTitle'>$chipTitle</span>";
											$mapChip .= "<span class='chipDescr'>$chipDescr</span>";
											$mapChip .= "<span class='chipBtnWrap'>";
												$mapChip .= "<a href='$chipLink' class='bfblButtonLink btnBlue'>";
													$mapChip .= 'Harvest Calendar';
												$mapChip .= "</a>";
											$mapChip .= "</span>";
										$mapChip .= '</div><!-- end div.chip -->';

									} // end the do-we-show-this-chip test
								endwhile;
							endif;
							echo $mapChip;
						?>
					</div><!-- end div.map-chip -->

					<div class="map-page-middle-bg page-block tan-shadow"><!-- NO CONTENT, used only for a background at certain break points --></div>
					<?php endif; ?>

				</div><!-- end div.map-page-middle -->
				<?php get_template_part("bfbl", "page-blocks"); ?>
			</section>
<?php get_footer(); ?>