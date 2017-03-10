<?php $type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : false; ?><!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html lang="en" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<title>Partner Application | Buy Fresh Buy Local - Greater Lehigh Valley</title>

		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

		<link rel="stylesheet" type="text/css" href="/css/styles.css">
	</head>

	<body>
		<div class="site-wrapper">
			<div class="container signup-wrapper">
				<p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
				<h1 class="title">New Partner Application</h1>
				<form class="signup-form" action="process.php" method="post">
					<ul class="signup-progress">
						<li>Business Details</li>
						<li>Business Address</li>
						<li>Point of Contact</li>
						<li>A few more details...</li>
					</ul>
					<div class="col-xs-12"><div class="row">
					<div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12" data-stage="1">
						<h2 class="section-title">Business Details</h2>
						<p class="section-subtitle">Tell us a little bit about your business.</p>

						<label>
							<span class="label-text">What is the business name?</span>
							<input type="text" name="partner_name" data-required="true" class="form-control">
						</label>

						<label>
							<span class="label-text">In which county is the business primarily located?</span>
							<select name="partner_county" data-required="true" class="form-control">
								<option default value="">Select a County</option>
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
								<option value="Philadelphia">Philadelphia</option>
								<option value="Schuylkill">Schuylkill</option>
								<option value="Warren">Warren</option>
							</select>
						</label>

						<label>
							<span class="label-text">Which type of business is it?</span>
							<select name="partner_category" data-required="true" class="form-control">
								<option default value="">Select a category</option>
								<!--<option value="csa-farm-share">CSA / Farm Share</option>-->
								<option value="distillery">Brewery / Distillery</option>
								<option value="distributor">Distributor</option>
								<option value="farm">Farm</option>
								<option value="farmers-market">Producer-Only Farmers' Market</option>
								<option value="institution">Institution</option>
								<option value="restaurant">Restaurant</option>
								<option value="retail">Retail Operations</option>
								<option value="specialty">Specialty Products</option>
								<option value="vineyard">Vineyard</option>
							</select>
						</label>

						<div class="category-specific-container"></div>

						<button type="button" class="btn next btn-primary">Next</button>
					</div>

					<div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12" data-stage="2">
						<h2 class="section-title">Business Address</h2>
						<p class="section-subtitle">Where is the business located?</p>

						<label>
							<span class="label-text">Street Address:</span>
							<input type="text" name="partner_billing_street_address" data-required="true" class="form-control">
						</label>

						<label>
							<span class="label-text">Street Address (2):</span>
							<input type="text" name="partner_billing_street_address_2" class="form-control">
						</label>

						<label>
							<span class="label-text">Zip Code:</span>
							<input type="text" name="partner_billing_zip" data-required="true" class="form-control">
						</label>

						<label>
							<span class="label-text">City:</span>
							<input type="text" name="partner_billing_city" data-required="true" class="form-control">
						</label>

						<label>
							<span class="label-text">State:</span>
							<select name="partner_billing_state" data-required="true" class="form-control">
								<option default value="">Select a State</option>
								<option value="PA">PA - Pennsylvania</option>
								<option value="NJ">NJ - New Jersey</option>
							</select>
						</label>

						<button type="button" class="btn btn-primary-outline previous">Back</button>
						<button type="button" class="btn next btn-primary">Next</button>
					</div>

					<div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12" data-stage="3">
						<h2 class="section-title">Point of Contact</h2>
						<p class="section-subtitle">Whom should we contact?</p>

						<label>
							<span class="label-text">Contact's Name:</span>
							<input type="text" name="partner_contact_name" data-required="true" class="form-control">
						</label>

						<label>
							<span class="label-text">Contact's Job Title:</span>
							<input type="text" name="partner_contact_position" class="form-control">
						</label>

						<label>
							<span class="label-text">Contact's Phone Number:</span>
							<input type="text" name="partner_contact_phone" data-required="true" class="form-control">
						</label>

						<label>
							<span class="label-text">Contact's Email Address:</span>
							<input type="text" name="partner_contact_email" data-required="true" data-type="email" class="form-control">
						</label>

						<button type="button" class="btn btn-primary-outline previous">Back</button>
						<button type="button" class="btn next btn-primary">Next</button>
					</div>

					<div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12" data-stage="4">
						<h2 class="section-title with-margin">A few more details...</h2>

						<label>
							<span class="label-text">Business Phone Number:</span>
							<input type="text" name="partner_phone" data-required="true" class="form-control">
						</label>

						<label>
							<span class="label-text">Business Email Address:</span>
							<input type="text" name="partner_email" data-required="true" data-type="email" class="form-control">
						</label>

						<label>
							<span class="label-text">Business Website:</span>
							<input type="text" name="partner_website" data-type="url" class="form-control">
						</label>

						<label>
							<span class="label-text">Requested Username (for Login):</span>
							<input type="text" name="partner_username" data-required="true" data-type="username" class="form-control">
						</label>

						<button type="button" class="btn btn-primary-outline previous">Back</button>
						<button type="submit" class="btn submit btn-primary">Submit</button>
					</div>
					</div></div>
				</form>

				<div class="extra-form-data">
					<div class="farms-questions category-specific">
						<fieldset>
							<p class="label-text pseudo-label">Which types of products do you produce?</p>
							<div class="product-types row">
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Vegetables">Vegetables</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Fruit">Fruit</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Flowers">Flowers</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Herbs">Herbs</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Dairy">Dairy</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Eggs">Eggs</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Honey">Honey</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Meat">Meat</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" value="Mushrooms">Mushrooms</label>
								<label class="check-label col-sm-4"><input type="checkbox" name="products[]" class="other-products-toggle" value="Other">Other</label>
							</div>
							<label class="other-products">
								<span class="label-text">Other Products:</span>
								<textarea type="text" name="other_products" class="form-control"></textarea>
							</label>
						</fieldset>

						<label>
							<span class="label-text">On how many acres?</span>
							<input type="text" name="acres" data-required="true" class="form-control">
						</label>
					</div>

					<div class="vineyard-questions category-specific">
						<label>
							<span class="label-text">How many acres of grapes do you grow?</span>
							<input type="text" name="acres" data-required="true" class="form-control">
						</label>
					</div>

					<div class="farmers-market-questions category-specific">
						<p>A Producer-Only Farmers' Market is one in which the vendors produce the goods that they are selling. (This is in contract to a Public Market, which may include non-farmers reselling goods produced by others).  Some producer-only farmers' markets allow producers to sell products from other farms under certain circumstances as long as farm source is clearly identified.</p>
						<label class="check-label">
							<input type="checkbox" name="farmers-market-agree" data-required="true">
							We are a producer-only farmers’ market according to the above definition.
						</label>
					</div>

					<div class="other-questions category-specific">
						<label>
							<span class="label-text">From which farm(s) in the Greater Lehigh Valley do you buy locally grown products?</span>
							<textarea name="sources" data-required="true" class="form-control"></textarea>
						</label>
					</div>
				</div>
			</div>
		</div><!-- END: .site-wrapper -->

		<script src="/scripts/vendor/jquery/jquery.min.js"></script>
		<script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
		<script src="/scripts/plugins.min.js"></script>
		<script src="/scripts/scripts.min.js"></script>
		<?php if ($type): ?>
		<script>
		$(function () {
			var type = "<?php echo $type; ?>";
			if ($("select[name=partner_category]").find("option[value=" + type + "]").length === 1) {
				$("select[name=partner_category]").val(type).trigger("blur");
				fixTabIndex(true);
			}
		});
		</script>
		<?php endif; ?>
	</body>
</html>