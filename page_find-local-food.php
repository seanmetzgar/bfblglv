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
			<div class="acf-map results-map"></div>
			<section class="main-content" role="main">
				<form id="find-local-food-form">
					<section class="form-section">
						<h2>Location</h2>

						<div class="form-inline">
							<select name="county" aria-label="County" class="form-control">
								<option value="" default>County</option>
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

							<span>or</span>

							<div class="input-group">
								<input class="form-control" name="zip" placeholder="Zip Code" aria-label="Zip Code">
								<span class="input-group-btn">
							    	<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span><span class="screen-reader-text">Search</span></button>
							    </span>
							</div>
						</div>
					</section>

					<section class="form-section">
						<h2>Location Type</h2>

						<div class="form-inline">
							<label><input type="checkbox" name="location_type[]" value="farm">Farms</label>
							<label><input type="checkbox" name="location_type[]" value="farm-csa">CSAs</label>
							<label><input type="checkbox" name="location_type[]" value="farm-farm_share">Farm Shares</label>
							<label><input type="checkbox" name="location_type[]" value="restaurant">Restaurants / Caterers</label>
							<label><input type="checkbox" name="location_type[]" value="retail">Stores / Retail</label>
							<label><input type="checkbox" name="location_type[]" value="vineyard">Vineyards</label>
							<label><input type="checkbox" name="location_type[]" value="distillery">Distilleries</label>
							<label><input type="checkbox" name="location_type[]" value="institution">Institution</label>
							<label><input type="checkbox" name="location_type[]" value="distributor">Distributor</label>
							<label><input type="checkbox" name="location_type[]" value="specialty">Specialty Products</label>
							<label><input type="checkbox" name="location_type[]" value="farmers-market">Farmers' Markets</label>
						</div>
					</section>

					<section class="form-section" data-active-category="farm">
						<h2>Product Type</h2>

						<div class="form-inline">
							<label><input type="checkbox" name="product_type[]" value="greens">Greens</label>
							<label><input type="checkbox" name="product_type[]" value="roots">Root Crops</label>
							<label><input type="checkbox" name="product_type[]" value="seasonal">Season Vegetables</label>
							<label><input type="checkbox" name="product_type[]" value="melons">Melons &amp; Pumpkins</label>
							<label><input type="checkbox" name="product_type[]" value="herbs">Herbs</label>
							<label><input type="checkbox" name="product_type[]" value="berries">Berries</label>
							<label><input type="checkbox" name="product_type[]" value="small_fruits">Orchard &amp; Small Fruits</label>
							<label><input type="checkbox" name="product_type[]" value="grains">Grains</label>
							<label><input type="checkbox" name="product_type[]" value="value_added">Value-Added</label>
							<label><input type="checkbox" name="product_type[]" value="flowers">Flowers</label>
							<label><input type="checkbox" name="product_type[]" value="plants">Plants</label>
							<label><input type="checkbox" name="product_type[]" value="ornamentals">Ornamentals</label>
							<label><input type="checkbox" name="product_type[]" value="syrups">Honey / Syrup</label>
							<label><input type="checkbox" name="product_type[]" value="dairy">Dairy</label>
							<label><input type="checkbox" name="product_type[]" value="meat">Meat</label>
							<label><input type="checkbox" name="product_type[]" value="poultry">Poultry</label>
							<label><input type="checkbox" name="product_type[]" value="agritourism">Agritourism</label>
							<label><input type="checkbox" name="product_type[]" value="fibers">Wool / Fibers</label>
							<label><input type="checkbox" name="product_type[]" value="artisinal">Artisanal Products</label>
							<label><input type="checkbox" name="product_type[]" value="liquids">Beverages</label>
							<label><input type="checkbox" name="product_type[]" value="educational">Educational Programs</label>
							<label><input type="checkbox" name="product_type[]" value="baked">Baked Goods</label>
							<label><input type="checkbox" name="product_type[]" value="seeds">Nuts / Seeds</label>
							<label><input type="checkbox" name="product_type[]" value="misc">Miscellaneous</label>
						</div>

						<label>
							Looking for a specific product?
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
					</section>
					<section class="form-section wholesale-section">
						<label>
							<h2>Wholesale</h2>
							<input type="checkbox" name="wholesale" value="1">
						</label>
					</section>
				</form>
				<section class="finder-search-results">
					<h2>Search Results</h2>
					<p class="results-total">Total: <span class="count"></span></p>
					<ul class="results-list"></ul>
				</section>
				<?php get_template_part("bfbl", "chips"); ?>
				<?php get_template_part("bfbl", "page-blocks"); ?>
			</section>
<?php get_footer(); ?>