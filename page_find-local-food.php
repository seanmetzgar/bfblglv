<?php
/**
 * Template Name: Find Local Food
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header();
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

									<div class="county-select-wrap">

								<!-- <select name="county" aria-label="County" class="form-control"> -->
									<select name="county" aria-label="County" class="county-select">
									<!-- <option value="" default>County</option> -->
										<option value='' selected="selected"></option>
										<option value="Berks">Berks</option>
										<option value="Bucks">Bucks</option>
										<option value="Carbon">Carbon</option>
										<option value="Chester">Chester</option>
										<option value="Hunterdon">Hunterdon</option>
										<option value="Lancaster">Lancaster</option>
										<option value="Lebanon">Lebanon</option>
										<option value="Lehigh">Lehigh</option>
										<option value="Monroe">Monroe</option>
										<option value="Montgomery">Montgomery</option>
										<option value="Northampton">Northampton</option>
										<option value="Schuylkill">Schuylkill</option>
										<option value="Warren">Warren</option>
									</select>
									</div><!-- end div.county-select-wrap -->

									<span>or</span>

									<div class="zip-input-group">
										<input class="zip-input" name="zip" placeholder="Zip Code" aria-label="Zip Code">
								    	<button class="zip-btn" type="button"><span class="screen-reader-text">Search</span></button>
									</div><!-- end div.input-group -->
								</div><!-- end div.form-inline -->
							</div><!-- end div.bfblSlideWrap -->
						</section>

						<section class="form-section bfblSlider sliderClosed initialClosed">
							<h2 class="greenHeader">Location Type</h2>
							<div class="bfblSlideWrap">
								<div class="form-inline page-block map-checkboxes">
									<label><input type="checkbox" name="location_type[]" value="farm"><span>Farms</span></label>
									<label><input type="checkbox" name="is_csa" value="1"><span>CSAs</span></label>
									<label><input type="checkbox" name="is_farm_share" value="1"><span>Farm Shares</span></label>
									<label><input type="checkbox" name="location_type[]" value="restaurant"><span>Restaurants / Caterers</span></label>
									<label><input type="checkbox" name="location_type[]" value="retail"><span>Stores / Retail</span></label>
									<label><input type="checkbox" name="location_type[]" value="vineyard"><span>Vineyards</span></label>
									<label><input type="checkbox" name="location_type[]" value="distillery"><span>Distilleries</span></label>
									<label><input type="checkbox" name="location_type[]" value="institution"><span>Institutions</span></label>
									<label><input type="checkbox" name="location_type[]" value="distributor"><span>Distributors</span></label>
									<label><input type="checkbox" name="location_type[]" value="specialty"><span>Specialty Products</span></label>
									<label><input type="checkbox" name="location_type[]" value="farmers-market"><span>Farmers' Markets</span></label>
								</div><!-- end div.map-checkboxes -->
							</div><!-- end div.bfblSlideWrap -->
						</section>

						<section class="form-section bfblSlider sliderClosed initialClosed" data-active-category="farm">
							<h2 class="greenHeader">Product Type</h2>
							<div class="bfblSlideWrap">

								<div class="form-inline page-block map-checkboxes">
									<label><input type="checkbox" name="product_type[]" value="greens"><span>Greens</span></label>
									<label><input type="checkbox" name="product_type[]" value="roots"><span>Root Crops</span></label>
									<label><input type="checkbox" name="product_type[]" value="seasonal"><span>Season Vegetables</span></label>
									<label><input type="checkbox" name="product_type[]" value="melons"><span>Melons &amp; Pumpkins</span></label>
									<label><input type="checkbox" name="product_type[]" value="herbs"><span>Herbs</span></label>
									<label><input type="checkbox" name="product_type[]" value="berries"><span>Berries</span></label>
									<label><input type="checkbox" name="product_type[]" value="small_fruits"><span>Orchard &amp; Small Fruits</span></label>
									<label><input type="checkbox" name="product_type[]" value="grains"><span>Grains</span></label>
									<label><input type="checkbox" name="product_type[]" value="value_added"><span>Value-Added</span></label>
									<label><input type="checkbox" name="product_type[]" value="flowers"><span>Flowers</span></label>
									<label><input type="checkbox" name="product_type[]" value="plants"><span>Plants</span></label>
									<label><input type="checkbox" name="product_type[]" value="ornamentals"><span>Ornamentals</span></label>
									<label><input type="checkbox" name="product_type[]" value="syrups"><span>Honey / Syrups</span></label>
									<label><input type="checkbox" name="product_type[]" value="dairy"><span>Dairy</span></label>
									<label><input type="checkbox" name="product_type[]" value="meat"><span>Meat</span></label>
									<label><input type="checkbox" name="product_type[]" value="poultry"><span>Poultry</span></label>
									<label><input type="checkbox" name="product_type[]" value="agritourism"><span>Agritourism</span></label>
									<label><input type="checkbox" name="product_type[]" value="fibers"><span>Wool / Fibers</span></label>
									<label><input type="checkbox" name="product_type[]" value="artisinal"><span>Artisanal Products</span></label>
									<label><input type="checkbox" name="product_type[]" value="liquids"><span>Beverages</span></label>
									<label><input type="checkbox" name="product_type[]" value="educational"><span>Educational Programs</span></label>
									<label><input type="checkbox" name="product_type[]" value="baked"><span>Baked Goods</span></label>
									<label><input type="checkbox" name="product_type[]" value="seeds"><span>Nuts / Seeds</span></label>
									<label><input type="checkbox" name="product_type[]" value="misc"><span>Miscellaneous</span></label>
								</div><!-- end div.map-checkboxes -->

								<div class="map-specific-prods page-block">
									<label>
										<span class="map-subhead">Looking for a <br />specific product?</span>
										<select name="specific_products" multiple class="chosen-specific-products">
											<option value="Product A">Product A</option>
											<option value="Product B">Product B</option>
											<option value="Product C">Product C</option>
											<option value="Product D">Product D</option>
											<option value="Product E">Product E</option>
											<option value="Product F">Product F</option>
											<option value="Product G">Product G</option>
											<option value="Product H">Product H</option>
											<option value="Product I">Product I</option>
											<option value="Product J">Product J</option>
											<option value="Product K">Product K</option>
											<option value="Product L">Product L</option>
											<option value="Product M">Product M</option>
											<option value="Product N">Product N</option>
											<option value="Product O">Product O</option>
											<option value="Product P">Product P</option>
											<option value="Product Q">Product Q</option>
											<option value="Product R">Product R</option>
											<option value="Product S">Product S</option>
											<option value="Product T">Product T</option>
											<option value="Product U">Product U</option>
											<option value="Product V">Product V</option>
											<option value="Product W">Product W</option>
											<option value="Product X">Product X</option>
											<option value="Product Y">Product Y</option>
											<option value="Product Z">Product Z</option>
										</select>
									</label>
								</div><!-- end div.map-specific-prods -->
							</div><!-- end div.bfblSlideWrap -->
						</section>
                        
						<section class="form-section wholesale-section">
                            <?php if (is_user_logged_in()):
                                $wholesaleChecked = ($_REQUEST["wholesale"] === "true" || $_REQUEST["wholesale" === "1"]) ? true : false; ?>
							<label class='greenHeader'><input type="checkbox" name="wholesale" value="1"<?php if ($wholesaleChecked) { echo " checked"; } ?>><span>Wholesale</span></label>
                            <?php else: ?>
							<a href="/become-a-partner" class='greenHeader'><span>Wholesale</span></a>
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

				</div><!-- end div.map-page-middle -->
				<?php get_template_part("bfbl", "page-blocks"); ?>
			</section>
<?php get_footer(); ?>