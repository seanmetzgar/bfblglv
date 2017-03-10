<?php
    require_once('./inc/phpmailer/PHPMailerAutoload.php');
    require_once('./inc/_inc_mysql.php');
    require_once("./inc/_inc_uuid.php");
    require_once("./inc/_inc_helpers.php");

    $partnerList = getRegisteredPartners();

    $uuid = $_REQUEST["uuid"];
    $uuid = strlen($uuid) > 10 ? $uuid : false;
    $id = (int)$_REQUEST["id"];
    $id = is_int($id) ? $id : false;
    $valid_partner = false;

    if ($uuid  && $id) {
        $select_query = "SELECT * FROM registrations WHERE id=? AND uuid=? AND status != 7 LIMIT 1";
        $select_statement = $mysqli->stmt_init();
        if ($select_statement->prepare($select_query)) {
            $select_statement->bind_param("is", $id, $uuid);
            $select_statement->execute();

            $select_result = $select_statement->get_result();
            if ($partner = $select_result->fetch_assoc()) {
                $valid_partner = count($partner) > 0 ? true : false;
            }
            $select_statement->close();
        }
    }

    if ($valid_partner):
?><!DOCTYPE html>
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
                <h1 class="title">Finalize Details</h1>
                <form class="signup-form" action="processContinue.php" data-category="<?php echo $partner["category"]; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="uuid" value="<?php echo $uuid; ?>">
                    <ul class="signup-progress">
                        <li>Partner Information</li>
                        <?php if ($partner["category"] == "farm"): ?><li>Farming Practices</li><?php endif; ?>
                        <?php if ($partner["category"] == "farm"): ?><li>Products</li><?php endif; ?>
                        <?php if ($partner["category"] == "farm"): ?><li>Wholesale</li><?php endif; ?>
                        <li>Additional Details</li>
                    </ul>
                    <div class="col-xs-12"><div class="row">
                    <div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12">
                        <h2 class="section-title">Partner Information</h2>
                        <p class="section-subtitle"><?php echo $partner["name"]; ?></p>

                        <div class="product-availability-questions">
                            <?php if (in_array($partner["category"], array("specialty", "retail", "restaurant", "institution", "distributor"))): ?>
                            <div class="paq-1 question row">
                                <?php if ($partnerList && is_array($partnerList) && count($partnerList) > 0): ?>
                                <label class="col-sm-6">
                                    <span class="label-text">We source from:</span>
                                    <select class="form-control" name="source_from" multiple>
                                    <?php foreach ($partnerList as $tempPartner): ?>
                                        <option value="<?php echo $tempPartner->id; ?>"><?php echo $tempPartner->name; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </label>
                                <label class="col-sm-6">
                                    <span class="label-text not-bold">Other:</span>
                                    <textarea type="text" name="source_from_other" class="form-control"></textarea>
                                </label>   
                                <?php else: ?>
                                <label class="col-sm-12">
                                    <span class="label-text">We source from:</span>
                                    <textarea type="text" name="source_from_other" class="form-control"></textarea>
                                </label>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if (in_array($partner["category"], array("farm", "vineyard", "distillery", "specialty"))): ?>
                            <div class="paq-2 question row">
                                <?php if ($partnerList && is_array($partnerList) && count($partnerList) > 0): ?>
                                <label class="col-sm-6">
                                    <span class="label-text">Products also available at:</span>
                                    <select class="form-control" name="products_available_at" multiple>
                                    <?php foreach ($partnerList as $tempPartner): ?>
                                        <option value="<?php echo $tempPartner->id; ?>"><?php echo $tempPartner->name; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </label>
                                <label class="col-sm-6">
                                    <span class="label-text not-bold">Other:</span>
                                    <textarea type="text" name="products_available_at_other" class="form-control"></textarea>
                                </label>   
                                <?php else: ?>
                                <label class="col-sm-12">
                                    <span class="label-text">Products also available at:</span>
                                    <textarea type="text" name="products_available_at_other" class="form-control"></textarea>
                                </label>
                                <?php endif; ?>                    
                            </div>
                            <?php endif; ?>
                            <?php if (in_array($partner["category"], array("vineyard", "distillery"))): ?>
                            <div class="paq-3 question row">
                                <?php if ($partnerList && is_array($partnerList) && count($partnerList) > 0): ?>
                                <label class="col-sm-6">
                                    <span class="label-text">We also offer products from:</span>
                                    <select class="form-control" name="products_available_from" multiple>
                                    <?php foreach ($partnerList as $tempPartner): ?>
                                        <option value="<?php echo $tempPartner->id; ?>"><?php echo $tempPartner->name; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </label>
                                <label class="col-sm-6">
                                    <span class="label-text not-bold">Other:</span>
                                    <textarea type="text" name="products_available_from_other" class="form-control"></textarea>
                                </label>   
                                <?php else: ?>
                                <label class="col-sm-12">
                                    <span class="label-text">We also offer products from:</span>
                                    <textarea type="text" name="products_available_from_other" class="form-control"></textarea>
                                </label>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if (in_array($partner["category"], array("farm"))): ?>
                            <div class="paq-4 question row">
                                <label class="check-label col-sm-4">
                                    <input type="radio" name="farm_type" value="Farm Stand">
                                    Farm stand (We only sell our own products)
                                </label>
                                <label class="check-label col-sm-4">
                                    <input type="radio" class="reliant-toggle" name="farm_type" value="Farm Market">
                                    Farm Market
                                </label>
                                <label class="check-label col-sm-4">
                                    <input type="checkbox" name="appointments" value="1">
                                    Available by Appointment
                                </label>
                                <div class="reliant">
                                    <?php if ($partnerList && is_array($partnerList) && count($partnerList) > 0): ?>
                                    <label class="col-sm-6">
                                        <span class="label-text">We also offer products from:</span>
                                        <select class="form-control" name="products_available_from" multiple>
                                        <?php foreach ($partnerList as $tempPartner): ?>
                                            <option value="<?php echo $tempPartner->id; ?>"><?php echo $tempPartner->name; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </label>
                                    <label class="col-sm-6">
                                        <span class="label-text not-bold">Other:</span>
                                        <textarea type="text" name="products_available_from_other" class="form-control"></textarea>
                                    </label>   
                                    <?php else: ?>
                                    <label class="col-sm-12">
                                        <span class="label-text">We also offer products from:</span>
                                        <textarea type="text" name="products_available_from_other" class="form-control"></textarea>
                                    </label>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($partner["category"] == "farmers-market"): ?>
                            <div class="paq-5 question row">
                                <label class="col-sm-4">
                                    <span class="label-text">Number of vendors:</span>
                                    <input type="text" name="vendors" class="form-control">
                                </label>
                                <?php if ($partnerList && is_array($partnerList) && count($partnerList) > 0): ?>
                                <label class="col-sm-4">
                                    <span class="label-text">Our vendors include:</span>
                                    <select class="form-control" name="vendor_list" multiple>
                                    <?php foreach ($partnerList as $tempPartner): ?>
                                        <option value="<?php echo $tempPartner->id; ?>"><?php echo $tempPartner->name; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </label>
                                <label class="col-sm-4">
                                    <span class="label-text not-bold">Other:</span>
                                    <textarea type="text" name="vendor_list_other" class="form-control"></textarea>
                                </label>   
                                <?php else: ?>
                                <label class="col-sm-8">
                                    <span class="label-text">Our vendors include:</span>
                                    <textarea type="text" name="vendor_list_other" class="form-control"></textarea>
                                </label>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($partner["category"] === "farmers-market"): ?>
                        <div class="row">
                            <label class="col-sm-12">
                                <span class="label-text">Farmer's Market Manager:</span>
                                <input type="text" class="form-control" data-required="true" name="market_manager">
                            </label>
                        </div>
                        <?php endif; ?>

                        <?php if ($partner["category"] !== "institution"): ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="pseudo-label label-text">Hours of Operation:</p>
                                <?php if ($partner["category"] === "farmers-market") { hoursInput("hours", array("seasonal" => true, "vendors" => true, "echo" => true)); } 
                                else { hoursInput("hours", array("seasonal" => true, "echo" => true)); }?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($partner["category"] == "farm"): ?>
                        <div class="row">
                            <fieldset class="col-sm-12">
                                <p class="label-text pseudo-label">What's your farm's total acreage?</p>
                                <div class="row">
                                    <label class="col-sm-6">
                                        <span class="label-text">Owned:</span>
                                        <input type="text" name="acres_owned" class="form-control">
                                    </label>
                                    <label class="col-sm-6">
                                        <span class="label-text">Rented:</span>
                                        <input type="text" name="acres_rented" class="form-control">
                                    </label>
                                </div>
                                <label>
                                    <span class="label-text">How many acres do you currently have in production?</span>
                                    <input type="text" name="acres_production" class="form-control">
                                </label>
                            </fieldset>
                        </div>

                        <div class="row">     
                            <fieldset class="col-sm-12">
                                <p class="label-text pseudo-label">Are you a CSA / Farm Share?</p>
                                <div class="farm-types row">
                                    <label class="check-label col-sm-4"><input type="checkbox" class="csa-toggle-1" name="is_csa" value="1">CSA</label>
                                    <label class="check-label col-sm-4"><input type="checkbox" class="csa-toggle-2" name="is_farm_share" value="1">Farm Share</label>
                                </div>
                            </fieldset>
                        </div>
                        <?php elseif ($partner["category"] == "restaurant" || $partner["category"] == "institution"): ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-inline label-text sentence-label">
                                    <div class="form-group">
                                        <span>We</span> 
                                        <select name="local_stock_freq" data-required="true" class="form-control">
                                            <option value="" default> </option>
                                            <option value="always">always</option>
                                            <option value="frequently">frequently</option>
                                            <option value="occasionally">occasionally</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <span>have</span>
                                        <select name="local_stock_qty" data-required="true" class="form-control">
                                            <option value="" default> </option>
                                            <option value="1 or more">1 or more</option>
                                            <option value="several">several</option>
                                        </select>
                                        <span>locally grown ingredients in our menu items.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="csa-specific-container"></div>

                        <button type="button" class="btn next btn-primary">Next</button>
                    </div>

                    <?php if ($partner["category"] == "farm"): ?>
                    <div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12">
                        <h2 class="section-title">Farming Practices</h2>

                        <div class="row">
                            <fieldset class="col-md-4">
                                <p class="label-text pseudo-label">Certified Organic?</p>
                                <div>
                                    <label class="check-label"><input type="checkbox" class="reliant-toggle" name="certified_organic" value="1">Yes</label>
                                    <div class="reliant">
                                        <label>
                                            <span class="label-text">Certified By:</span>
                                            <input type="text" name="certified_organic_by" class="form-control">
                                        </label>
                                        <label>
                                            <span class="label-text">Since (year):</span>
                                            <input type="text" name="certified_organic_since" class="form-control">
                                        </label>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="col-md-4">
                                <p class="label-text pseudo-label">Certified Naturally Grown?</p>
                                <div>
                                    <label class="check-label"><input type="checkbox" class="reliant-toggle" name="certified_naturally_grown" value="1">Yes</label>
                                    <div class="reliant">
                                        <label>
                                            <span class="label-text">Since (year):</span>
                                            <input type="text" name="certified_naturally_grown_since" class="form-control">
                                        </label>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="col-md-4">
                                <p class="label-text pseudo-label">Certified Biodynamic?</p>
                                <div>
                                    <label class="check-label"><input type="checkbox" class="reliant-toggle" name="certified_biodynamic" value="1">Yes</label>
                                    <div class="reliant">
                                        <label>
                                            <span class="label-text">Certified By:</span>
                                            <input type="text" name="certified_biodynamic_by" class="form-control">
                                        </label>
                                        <label>
                                            <span class="label-text">Since (year):</span>
                                            <input type="text" name="certified_biodynamic_since" class="form-control">
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <fieldset>
                            <p class="label-text pseudo-label">Other practices</p>
                            <div class="row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="only_organic" value="1">Use Only Organic Materials</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="integrated_pest_management" value="1">Intergrated Pest Management (IPM)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="non_gmo" value="1">Non-GMO</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="antibiotic_harmone_free" value="1">Antibiotic- and Hormone-Free</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="pastured" value="1">Pastured</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="grass_fed" value="1">100% Grass-Fed</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="extended_growing_season" value="1">Extended Growing Season</label>
                                <label class="check-label col-sm-4"><input type="checkbox" class="reliant-toggle">Other</label>
                                <div class="reliant">
                                    <label>
                                        <span class="label-text">Other Farming Practices:</span>
                                        <textarea type="text" name="other_farming_practices_text" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Benefits Acceptance</p>
                            <div>
                                <label class="check-label col-sm-4"><input type="checkbox" name="accept_snap" value="1">Accept SNAP Benefits</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="accept_fmnp" value="1">Accept FMNP Vouchers (Senior &amp; WIC)</label>
                            </div>
                        </fieldset>

                        <button type="button" class="btn btn-primary-outline previous">Back</button>
                        <button type="button" class="btn next btn-primary">Next</button>
                    </div>
                    <?php endif; ?>

                    <?php if ($partner["category"] == "farm"): ?>
                    <div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12">
                        <h2 class="section-title">Products</h2>

                        <fieldset>
                            <p class="label-text pseudo-label">Greens</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Arugula">Arugula</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Asian Greens">Asian Greens</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Bok Choy">Bok Choy</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Pac Choi">Pac Choi</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Collards">Collards</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Endive">Endive</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Escarole">Escarole</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Kale">Kale</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Lettuce">Lettuce</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Mache">Mache</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Micro Greens">Micro Greens</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Mizuna">Mizuna</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Mustard Greens">Mustard Greens</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Radicchio">Radicchio</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Salad Mixes">Salad Mixes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Spinach">Spinach</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Swiss Chard">Swiss Chard</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" value="Tatsoi">Tatsoi</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_greens[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_greens" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                            
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Root Crops</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Beets">Beets</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Carrots">Carrots</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Celeriac">Celeriac</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Daikon ">Daikon </label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Fennel">Fennel</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Garlic">Garlic</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Ginger">Ginger</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Horseradish">Horseradish</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Kohlrabi">Kohlrabi</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Onions">Onions</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Parsnips">Parsnips</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Potatoes">Potatoes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Radishes">Radishes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Ramps">Ramps</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Rutabaga">Rutabaga</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Shallots">Shallots</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Sunchokes">Sunchokes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Sweet Potatoes">Sweet Potatoes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" value="Turnips">Turnips</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_roots[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_roots" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Season Vegetables</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Artichokes">Artichokes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Asparagus">Asparagus</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Beans (Fresh)">Beans (Fresh)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Beans (Dried)">Beans (Dried)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Beans (Fava)">Beans (Fava)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Broccoli">Broccoli</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Broccoli Raab">Broccoli Raab</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Brussels Sprouts">Brussels Sprouts</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Cabbage">Cabbage</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Cauliflower">Cauliflower</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Celery">Celery</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Cucumber">Cucumber</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Eggplant">Eggplant</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Garlic Scapes">Garlic Scapes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Leeks">Leeks</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Okra">Okra</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Peas">Peas</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Peppers (Sweet)">Peppers (Sweet)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Peppers (Hot)">Peppers (Hot)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Popcorn">Popcorn</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Rhubarb">Rhubarb</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Scallions">Scallions</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Sweet Corn">Sweet Corn</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Squash (Summer)">Squash (Summer)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Squash (Winter)">Squash (Winter)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Tomatillos">Tomatillos</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Tomatoes">Tomatoes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" value="Zucchini">Zucchini</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_seasonal[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_seasonal" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Melons &amp; Pumpkins</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_melons[]" value="Cantaloupes">Cantaloupes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_melons[]" value="Honeydew">Honeydew</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_melons[]" value="Pumpkins (Pie)">Pumpkins (Pie)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_melons[]" value="Watermelons">Watermelons</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_melons[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_melons" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Herbs</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_herbs[]" value="Herbs (Fresh)">Herbs (Fresh)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_herbs[]" value="Herbs (Dried)">Herbs (Dried)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_herbs[]" value="Herbs (Plants)">Herbs (Plants)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_herbs[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_herbs" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Berries</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" value="Blackberries">Blackberries</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" value="Blueberries">Blueberries</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" value="Currants">Currants</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" value="Gooseberries">Gooseberries</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" value="Kiwi Berries">Kiwi Berries</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" value="Raspberries (Red)">Raspberries (Red)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" value="Raspberries (Black)">Raspberries (Black)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" value="Strawberries">Strawberries</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_berries[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_berries" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Orchard &amp; Small Fruits</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Apples">Apples</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Apricots">Apricots</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Asian Pears">Asian Pears</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Cherries">Cherries</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Figs">Figs</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Grapes">Grapes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Nectarines">Nectarines</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Peaches">Peaches</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Pears">Pears</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Persimmons">Persimmons</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" value="Plums">Plums</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_small_fruits[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_small_fruits" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Grains</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_grains[]" value="Wheat Flour">Wheat Flour</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_grains[]" value="Wheat Berries">Wheat Berries</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_grains[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_grains" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Value-Added</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Apple Sauce">Apple Sauce</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Beeswax">Beeswax</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Cider (Apple)">Cider (Apple)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Cider (Pear)">Cider (Pear)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Dried Fruits">Dried Fruits</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Hot Sauce">Hot Sauce</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Jams, Jellies">Jams, Jellies</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Salsas">Salsas</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Tomato Sauce">Tomato Sauce</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" value="Vinegars">Vinegars</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_value_added[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_value_added" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Flowers</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_flowers[]" value="Flowers (Cut)">Flowers (Cut)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_flowers[]" value="Flowers (Dried)">Flowers (Dried)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_flowers[]" value="Flowers (Edible)">Flowers (Edible)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_flowers[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_flowers" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Plants</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_plants[]" value="Bedding Plants">Bedding Plants</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_plants[]" value="Mums">Mums</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_plants[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_plants" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Ornamentals</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_ornamentals[]" value="Corn Shocks">Corn Shocks</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_ornamentals[]" value="Gourds">Gourds</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_ornamentals[]" value="Pumpkins">Pumpkins</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_ornamentals[]" value="Ornamental Corn">Ornamental Corn</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_ornamentals[]" value="Straw Bales">Straw Bales</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_ornamentals[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_ornamentals" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Honey / Syrup</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_syrups[]" value="Fruit Syrup">Fruit Syrup</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_syrups[]" value="Honey ">Honey </label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_syrups[]" value="Honey (Raw)">Honey (Raw)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_syrups[]" value="Maple Syrup">Maple Syrup</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_syrups[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_syrups" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Dairy</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Butter">Butter</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Cheese (Cow)">Cheese (Cow)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Cheese (Goat)">Cheese (Goat)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Milk (Cow, Pasteurized)">Milk (Cow, Pasteurized)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Milk (Goat, Pasteurized)">Milk (Goat, Pasteurized)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Milk (Cow, Raw)">Milk (Cow, Raw)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Milk (Goat, Raw)">Milk (Goat, Raw)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Yogurt (Cow)">Yogurt (Cow)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" value="Yogurt (Goat)">Yogurt (Goat)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_dairy[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_dairy" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Meat</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_meats[]" value="Beef">Beef</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_meats[]" value="Goat">Goat</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_meats[]" value="Lamb">Lamb</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_meats[]" value="Pork">Pork</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_meats[]" value="Veal (Rose)">Veal (Rose)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_meats[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_meats" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Chicken &amp; Other Poultry</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_poultry[]" value="Chicken">Chicken</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_poultry[]" value="Duck">Duck</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_poultry[]" value="Turkey">Turkey</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_poultry[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_poultry" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Agritourism</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_agritourism[]" value="Corn Maze">Corn Maze</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_agritourism[]" value="Hay Rides">Hay Rides</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_agritourism[]" value="Pick-Your-Own (PYO)">Pick-Your-Own (PYO)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_agritourism[]" value="Pumpkin Patch">Pumpkin Patch</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_agritourism[]" value="Tours">Tours</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_agritourism[]" value="Weddings">Weddings</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_agritourism[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_agritourism" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Wool, Fibers</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_fibers[]" value="Alpaca">Alpaca</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_fibers[]" value="Wool">Wool</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_fibers[]" value="Yarn">Yarn</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_fibers[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_fibers" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Artisanal Products</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_artisinal[]" value="Candles">Candles</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_artisinal[]" value="Gift Baskets">Gift Baskets</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_artisinal[]" value="Soap">Soap</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_artisinal[]" value="Wreaths">Wreaths</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_artisinal[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_artisinal" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Wine, Spirits, Cider</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_liquids[]" value="Cider">Cider</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_liquids[]" value="Gin">Gin</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_liquids[]" value="Rum">Rum</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_liquids[]" value="Vodka">Vodka</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_liquids[]" value="Wine">Wine</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_liquids[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_liquids" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Educational Programs</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_educational[]" value="Workshops">Workshops</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_educational[]" value="School Tours">School Tours</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_educational[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_educational" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
    
                        <fieldset>
                            <p class="label-text pseudo-label">Baked Goods</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_baked[]" value="Bread">Bread</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_baked[]" value="Cakes">Cakes</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_baked[]" value="Cookies">Cookies</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_baked[]" value="Muffins">Muffins</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_baked[]" value="Pies">Pies</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_baked[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_baked" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
    
                        <fieldset>
                            <p class="label-text pseudo-label">Nuts, Seeds</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_nuts_seeds[]" value="Chestnuts">Chestnuts</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_nuts_seeds[]" value="Sunflower Seeds">Sunflower Seeds</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_nuts_seeds[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_nuts_seeds" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <p class="label-text pseudo-label">Other Products</p>
                            <div class="product-types row">
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_extras[]" value="Mushrooms">Mushrooms</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_extras[]" value="Eggs">Eggs</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_extras[]" value="Christmas Trees">Christmas Trees</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_extras[]" value="Firewood">Firewood</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_extras[]" value="Hay">Hay</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="products_extras[]" class="reliant-toggle" value="Other">Other</label>
                                <div class="reliant">
                                    <label clas="col-sm-12">
                                        <span class="label-text">Other Products:</span>
                                        <textarea type="text" name="other_products_extras" class="form-control"></textarea>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <button type="button" class="btn btn-primary-outline previous">Back</button>
                        <button type="button" class="btn next btn-primary">Next</button>
                    </div>
                    <?php endif; ?>

                    <?php if ($partner["category"] == "farm"): ?>
                    <div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12">
                        <h2 class="section-title">Wholesale</h2>
                        <div class="row">
                            <label class="check-label col-sm-12"><input type="checkbox" class="reliant-toggle" name="wholesaler" value="1">We sell to wholesale buyers</label>
                            <div class="reliant">
                                <label class="check-label col-sm-4"><input type="checkbox" name="quasi_wholesale" value="1">Quasi-Wholesale (Restaurants)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="small_wholesale" value="1">Small Wholesale Accounts (Boxes weekly)</label>
                                <label class="check-label col-sm-4"><input type="checkbox" name="large_wholesale" value="1">Large Wholesale Accounts (Pallets weekly)</label>
                                <div class="col-sm-4">
                                    <label class="check-label"><input type="checkbox" class="reliant-toggle" name="gap_certified" value="1">GAP Certified</label>
                                    <div class="reliant">
                                        <label>
                                            <span class="label-text">Since (year):</span>
                                            <input type="text" name="gap_certified_since" class="form-control">
                                        </label>
                                    </div>
                                </div>
                                <label class="check-label col-sm-4"><input type="checkbox" name="gap_pending" value="1">Working towards GAP Certification</label>

                                <hr style="clear:both;">

                                <h3 style="text-align: center;">Wholesale Products</h3>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Greens</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Arugula">Arugula</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Asian Greens">Asian Greens</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Bok Choy">Bok Choy</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Pac Choi">Pac Choi</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Collards">Collards</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Endive">Endive</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Escarole">Escarole</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Kale">Kale</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Lettuce">Lettuce</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Mache">Mache</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Micro Greens">Micro Greens</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Mizuna">Mizuna</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Mustard Greens">Mustard Greens</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Radicchio">Radicchio</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Salad Mixes">Salad Mixes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Spinach">Spinach</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Swiss Chard">Swiss Chard</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" value="Tatsoi">Tatsoi</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_greens[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_greens" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Root Crops</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Beets">Beets</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Carrots">Carrots</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Celeriac">Celeriac</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Daikon ">Daikon </label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Fennel">Fennel</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Garlic">Garlic</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Ginger">Ginger</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Horseradish">Horseradish</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Kohlrabi">Kohlrabi</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Onions">Onions</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Parsnips">Parsnips</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Potatoes">Potatoes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Radishes">Radishes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Ramps">Ramps</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Rutabaga">Rutabaga</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Shallots">Shallots</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Sunchokes">Sunchokes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Sweet Potatoes">Sweet Potatoes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" value="Turnips">Turnips</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_roots[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_roots" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Season Vegetables</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Artichokes">Artichokes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Asparagus">Asparagus</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Beans (Fresh)">Beans (Fresh)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Beans (Dried)">Beans (Dried)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Beans (Fava)">Beans (Fava)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Broccoli">Broccoli</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Broccoli Raab">Broccoli Raab</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Brussels Sprouts">Brussels Sprouts</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Cabbage">Cabbage</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Cauliflower">Cauliflower</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Celery">Celery</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Cucumber">Cucumber</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Eggplant">Eggplant</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Garlic Scapes">Garlic Scapes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Leeks">Leeks</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Okra">Okra</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Peas">Peas</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Peppers (Sweet)">Peppers (Sweet)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Peppers (Hot)">Peppers (Hot)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Popcorn">Popcorn</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Rhubarb">Rhubarb</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Scallions">Scallions</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Sweet Corn">Sweet Corn</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Squash (Summer)">Squash (Summer)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Squash (Winter)">Squash (Winter)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Tomatillos">Tomatillos</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Tomatoes">Tomatoes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" value="Zucchini">Zucchini</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_seasonal[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_seasonal" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Melons &amp; Pumpkins</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_melons[]" value="Cantaloupes">Cantaloupes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_melons[]" value="Honeydew">Honeydew</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_melons[]" value="Pumpkins (Pie)">Pumpkins (Pie)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_melons[]" value="Watermelons">Watermelons</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_melons[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_melons" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Herbs</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_herbs[]" value="Herbs (Fresh)">Herbs (Fresh)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_herbs[]" value="Herbs (Dried)">Herbs (Dried)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_herbs[]" value="Herbs (Plants)">Herbs (Plants)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_herbs[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_herbs" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Berries</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" value="Blackberries">Blackberries</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" value="Blueberries">Blueberries</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" value="Currants">Currants</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" value="Gooseberries">Gooseberries</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" value="Kiwi Berries">Kiwi Berries</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" value="Raspberries (Red)">Raspberries (Red)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" value="Raspberries (Black)">Raspberries (Black)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" value="Strawberries">Strawberries</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_berries[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_berries" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Orchard &amp; Small Fruits</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Apples">Apples</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Apricots">Apricots</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Asian Pears">Asian Pears</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Cherries">Cherries</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Figs">Figs</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Grapes">Grapes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Nectarines">Nectarines</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Peaches">Peaches</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Pears">Pears</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Persimmons">Persimmons</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" value="Plums">Plums</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_small_fruits[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_small_fruits" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Grains</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_grains[]" value="Wheat Flour">Wheat Flour</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_grains[]" value="Wheat Berries">Wheat Berries</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_grains[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_grains" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Value-Added</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Apple Sauce">Apple Sauce</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Beeswax">Beeswax</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Cider (Apple)">Cider (Apple)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Cider (Pear)">Cider (Pear)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Dried Fruits">Dried Fruits</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Hot Sauce">Hot Sauce</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Jams, Jellies">Jams, Jellies</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Salsas">Salsas</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Tomato Sauce">Tomato Sauce</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" value="Vinegars">Vinegars</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_value_added[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_value_added" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Flowers</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_flowers[]" value="Flowers (Cut)">Flowers (Cut)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_flowers[]" value="Flowers (Dried)">Flowers (Dried)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_flowers[]" value="Flowers (Edible)">Flowers (Edible)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_flowers[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_flowers" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Plants</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_plants[]" value="Bedding Plants">Bedding Plants</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_plants[]" value="Mums">Mums</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_plants[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_plants" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Ornamentals</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_ornamentals[]" value="Corn Shocks">Corn Shocks</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_ornamentals[]" value="Gourds">Gourds</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_ornamentals[]" value="Pumpkins">Pumpkins</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_ornamentals[]" value="Ornamental Corn">Ornamental Corn</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_ornamentals[]" value="Straw Bales">Straw Bales</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_ornamentals[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_ornamentals" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Honey / Syrup</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_syrups[]" value="Fruit Syrup">Fruit Syrup</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_syrups[]" value="Honey ">Honey </label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_syrups[]" value="Honey (Raw)">Honey (Raw)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_syrups[]" value="Maple Syrup">Maple Syrup</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_syrups[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_syrups" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Dairy</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Butter">Butter</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Cheese (Cow)">Cheese (Cow)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Cheese (Goat)">Cheese (Goat)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Milk (Cow, Pasteurized)">Milk (Cow, Pasteurized)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Milk (Goat, Pasteurized)">Milk (Goat, Pasteurized)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Milk (Cow, Raw)">Milk (Cow, Raw)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Milk (Goat, Raw)">Milk (Goat, Raw)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Yogurt (Cow)">Yogurt (Cow)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" value="Yogurt (Goat)">Yogurt (Goat)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_dairy[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_dairy" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Meat</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_meats[]" value="Beef">Beef</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_meats[]" value="Goat">Goat</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_meats[]" value="Lamb">Lamb</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_meats[]" value="Pork">Pork</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_meats[]" value="Veal (Rose)">Veal (Rose)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_meats[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_meats" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Chicken &amp; Other Poultry</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_poultry[]" value="Chicken">Chicken</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_poultry[]" value="Duck">Duck</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_poultry[]" value="Turkey">Turkey</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_poultry[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_poultry" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Agritourism</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_agritourism[]" value="Corn Maze">Corn Maze</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_agritourism[]" value="Hay Rides">Hay Rides</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_agritourism[]" value="Pick-Your-Own (PYO)">Pick-Your-Own (PYO)</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_agritourism[]" value="Pumpkin Patch">Pumpkin Patch</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_agritourism[]" value="Tours">Tours</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_agritourism[]" value="Weddings">Weddings</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_agritourism[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_agritourism" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Wool, Fibers</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_fibers[]" value="Alpaca">Alpaca</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_fibers[]" value="Wool">Wool</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_fibers[]" value="Yarn">Yarn</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_fibers[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_fibers" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Artisanal Products</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_artisinal[]" value="Candles">Candles</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_artisinal[]" value="Gift Baskets">Gift Baskets</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_artisinal[]" value="Soap">Soap</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_artisinal[]" value="Wreaths">Wreaths</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_artisinal[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_artisinal" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Wine, Spirits, Cider</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_liquids[]" value="Cider">Cider</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_liquids[]" value="Gin">Gin</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_liquids[]" value="Rum">Rum</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_liquids[]" value="Vodka">Vodka</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_liquids[]" value="Wine">Wine</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_liquids[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_liquids" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Educational Programs</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_educational[]" value="Workshops">Workshops</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_educational[]" value="School Tours">School Tours</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_educational[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_educational" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
            
                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Baked Goods</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_baked[]" value="Bread">Bread</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_baked[]" value="Cakes">Cakes</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_baked[]" value="Cookies">Cookies</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_baked[]" value="Muffins">Muffins</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_baked[]" value="Pies">Pies</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_baked[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_baked" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
            
                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Nuts, Seeds</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_nuts_seeds[]" value="Chestnuts">Chestnuts</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_nuts_seeds[]" value="Sunflower Seeds">Sunflower Seeds</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_nuts_seeds[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_nuts_seeds" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-sm-12">
                                    <p class="label-text pseudo-label">Other Products</p>
                                    <div class="product-types row">
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_extras[]" value="1">Mushrooms</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_extras[]" value="1">Eggs</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_extras[]" value="Christmas Trees">Christmas Trees</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_extras[]" value="Firewood">Firewood</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_extras[]" value="Hay">Hay</label>
                                        <label class="check-label col-sm-4"><input type="checkbox" name="ws_products_extras[]" class="reliant-toggle" value="Other">Other</label>
                                        <div class="reliant">
                                            <label class="col-sm-12">
                                                <span class="label-text">Other Products:</span>
                                                <textarea type="text" name="other_ws_products_extras" class="form-control"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </fieldset> 
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary-outline previous">Back</button>
                        <button type="button" class="btn next btn-primary">Next</button>
                    </div>
                    <?php endif; ?>

                    <div class="signup-stage col-sm-10 col-sm-offset-1 col-xs-12">
                        <h2 class="section-title">Additional Details</h2>

                        <label>
                            <?php if ($partner["category"] === "institution"): ?>
                            <span class="label-text">Short Description of use of local foods (ex, cafeteria, farm, workplace CSAs)</span>
                            <?php else: ?>
                            <span class="label-text">Short Description:</span>
                            <?php endif; ?>
                            <textarea name="description" class="form-control"></textarea>
                        </label>

                        <?php if (in_array($partner["category"], array("vineyard", "distillery", "specialty"))): ?>
                        <label>
                            <span class="label-text">Products:</span>
                            <textarea name="products_text" class="form-control" data-required="true"></textarea>
                        </label>

                        <label class="check-label col-sm-12"><input type="checkbox" class="reliant-toggle" name="wholesaler" value="1">We sell to wholesale buyers</label>
                        <div class="reliant">
                            <label class="check-label col-sm-4"><input type="checkbox" name="quasi_wholesale" value="1">Quasi-Wholesale (Restaurants)</label>
                            <label class="check-label col-sm-4"><input type="checkbox" name="small_wholesale" value="1">Small Wholesale Accounts (Boxes weekly)</label>
                            <label class="check-label col-sm-4"><input type="checkbox" name="large_wholesale" value="1">Large Wholesale Accounts (Pallets weekly)</label>
                            <div class="col-sm-4">
                                <label class="check-label"><input type="checkbox" class="reliant-toggle" name="gap_certified" value="1">GAP Certified</label>
                                <div class="reliant">
                                    <label>
                                        <span class="label-text">Since (year):</span>
                                        <input type="text" name="gap_certified_since" class="form-control">
                                    </label>
                                </div>
                            </div>
                            <label class="check-label col-sm-4"><input type="checkbox" name="gap_pending" value="1">Working towards GAP Certification</label>

                            <hr style="clear:both;">

                            <label>
                                <span class="label-text">Wholesale Products:</span>
                                <textarea name="ws_products_text" class="form-control" data-required="true"></textarea>
                            </label>
                        </div>
                        <?php endif; ?>

                        <?php if ($partner["category"] === "farmers-market"): ?>
                        <fieldset>
                            <label class="check-label col-sm-6"><input type="radio" name="market_ebt" value="all">Market-wide EBT program</label>
                            <label class="check-label col-sm-6"><input type="radio" name="market_ebt" value="some">EBT accepted by some vendors</label>
                            <label class="check-label col-sm-6"><input type="checkbox" name="market_double_snap" value="1">Double SNAP program</label>
                            <label class="check-label col-sm-6"><input type="checkbox" name="market_fmnp" value="1">FMNP vouchers accepted by some vendors</label>
                        </fieldset>
                        <?php endif; ?>

                        <label>
                            <span class="label-text">Facebook URL:</span>
                            <input type="text" name="facebook_url" class="form-control" placeholder="https://www.facebook.com/name/">
                        </label>

                        <label>
                            <span class="label-text">Twitter Account:</span>
                            <div class="input-group">
                                <div class="input-group-addon"><span>@</span></div>
                                <input type="text" name="twitter_handle" class="form-control" placeholder="username">
                            </div>
                        </label>

                        <label>
                            <span class="label-text">Instagram Account:</span>
                            <div class="input-group">
                                <div class="input-group-addon"><span>@</span></div>
                                <input type="text" name="instagram_handle" class="form-control" placeholder="username">
                            </div>
                        </label>

                        <label>
                            <span class="label-text">Owner Photo:</span>
                            <input type="file" name="owner_photo">
                            <input name="photocheck_owner" value="hello" type="hidden">
                        </label>

                        <label>
                            <span class="label-text">Business Photo:</span>
                            <input type="file" name="partner_photo">
                            <input name="photocheck_partner" value="hello" type="hidden">
                        </label>

                        <button type="button" class="btn btn-primary-outline previous">Back</button>
                        <button type="submit" class="btn submit btn-primary">Submit</button>
                    </div>
                    </div></div>
                </form>

                <div class="extra-form-data">
                    <div class="csa-questions csa-specific">
                        <div class="row">
                            <label class="col-sm-12">
                                <span class="label-text">Season (# of weeks):</span>
                                <input type="text" name="season_weeks" class="form-control">
                            </label>
                            <label class="col-sm-6">
                                <span class="label-text">Start of Season:</span>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <select name="season_start_mpart" class="form-control">
                                            <option value="" default>Select part of month</option>
                                            <option value="Beginning of">Beginning</option>
                                            <option value="Middle of">Middle</option>
                                            <option value="End of">End</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="season_start_month" class="form-control">
                                            <option value="" default>Select month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>
                                </div>
                            </label>
                            <label class="col-sm-6">
                                <span class="label-text">End of Season:</span>
                                <div class="form-inline">
                                    <div class="form-group">
                                        <select name="season_end_mpart" class="form-control">
                                            <option value="" default>Select part of month</option>
                                            <option value="Beginning of">Beginning</option>
                                            <option value="Middle of">Middle</option>
                                            <option value="End of">End</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="season_end_month" class="form-control">
                                            <option value="" default>Select month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-6">
                                <label>
                                    <span class="label-text">Number of Full Shares Offered:</span>
                                    <input type="text" name="full_shares" class="form-control">
                                </label>
                                <label>
                                    <span class="label-text">Cost of Full Shares:</span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span>$</span></div>
                                        <input type="text" name="cost_full_shares" class="form-control">
                                    </div>
                                </label>
                                <label class="no-margin">
                                    <span class="label-text">Size of Full Shares (ex. 5-7 items):</span>
                                </label>
                                <div class="input-group double-input has-margin">
                                    <input type="text" class="form-control" name="size_full_shares">
                                    <input type="text" readonly="readonly" class="form-control dropdown-value" name="size_full_shares_type">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Select Share Type</span></button>
                                        <ul class="dropdown-menu pseudo-select" data-reliant-value="other" data-value-name="size_full_shares_type">
                                            <li><a href="#" class="dropdown-item" data-value="Items">Items</a></li>
                                            <li><a href="#" class="dropdown-item" data-value="Bags">Bags</a></li>
                                            <li><a href="#" class="dropdown-item" data-value="other">Other</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>
                                    <span class="label-text">Number of Half Shares Offered:</span>
                                    <input type="text" name="half_shares" class="form-control">
                                </label>
                                <label>
                                    <span class="label-text">Cost of Half Shares:</span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span>$</span></div>
                                        <input type="text" name="cost_half_shares" class="form-control">
                                    </div>
                                </label>
                                <label class="no-margin">
                                    <span class="label-text">Size of Half Shares (ex. 5-7 items):</span>
                                </label>
                                <div class="input-group double-input has-margin">
                                    <input type="text" class="form-control" name="size_half_shares">
                                    <input type="text" readonly="readonly" class="form-control dropdown-value" name="size_half_shares_type">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Select Share Type</span></button>
                                        <ul class="dropdown-menu pseudo-select" data-reliant-value="other" data-value-name="size_half_shares_type">
                                            <li><a href="#" class="dropdown-item" data-value="Items">Items</a></li>
                                            <li><a href="#" class="dropdown-item" data-value="Bags">Bags</a></li>
                                            <li><a href="#" class="dropdown-item" data-value="other">Other</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <label class="col-sm-12">
                                <span class="label-text">Possible Add-Ons:</span>
                                <textarea name="possible_addons" class="form-control"></textarea>
                            </label>
                        </div>

                        <fieldset>
                            <p class="label-text pseudo-label">Pick-Up Site:</p>
                            <div class="pick-up-sites row">
                                <fieldset class="col-sm-6">
                                    <label class="check-label"><input type="checkbox" class="reliant-toggle" name="farm_pickup" value="1">Farm</label>
                                    <div class="reliant">
                                        <label class="farm-pickup-dt">
                                            <span class="label-text">Farm Pick-Up Day &amp; Time:</span>
                                            <textarea type="text" name="farm_pickup_dt" class="form-control"></textarea>
                                        </label>
                                    </div>
                                </fieldset>
                                <fieldset class="col-sm-6">
                                    <label class="check-label"><input type="checkbox" class="reliant-toggle" name="other_pickup" value="1">Other Location</label>
                                    <div class="reliant"> 
                                        <fieldset class="other-site-repeater">
                                            <label class="other-pickup-site">
                                                <span class="label-text">Other Pick-Up Site Address:</span>
                                                <textarea type="text" name="other_pickup_site" class="form-control"></textarea>
                                            </label>
                                            <label class="other-pickup-site-dt">
                                                <span class="label-text">Other Pick-Up Site Day &amp; Time:</span>
                                                <textarea type="text" name="other_pickup_dt" class="form-control"></textarea>
                                            </label>
                                        </fieldset>
                                    </div>
                                </fieldset>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div><!-- END: .site-wrapper -->

        <script src="/scripts/vendor/jquery/jquery.min.js"></script>
        <script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
        <script src="/scripts/plugins.min.js"></script>
        <script src="/scripts/scripts.min.js"></script>
    </body>
</html><?php else: header("Location: /"); endif; ?>