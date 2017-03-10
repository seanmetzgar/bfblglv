<?php require_once("./inc/_inc_helpers.php"); ?><!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html lang="en" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <title>Newsletter | Buy Fresh Buy Local - Greater Lehigh Valley</title>

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

        <link rel="stylesheet" type="text/css" href="/css/styles.css">
    </head>

    <body>
        <div class="site-wrapper">
            <div class="container-fluid form-wrapper">
                <p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
                <h1 class="title">Newsletter Generator</h1>

                <div class="container-fluid">
                    <form class="email-form" action="process-newsletter.php" method="post" enctype="multipart/form-data">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="header-details panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Featured Article</h3>
                                    </div>

                                    <div class="panel-body">
                                        <label class="check-label">
                                            <input type="checkbox" name="featured_enabled" value="1" class="reliant-toggle">
                                            <strong>Enabled?</strong>
                                        </label>

                                        <div class="reliant">
                                            <label>
                                                <span class="label-text">Photo <em>(Recommended Size: 630 x 280)</em></span>
                                                <input type="file" name="featured_photo" data-required="true">
                                                <input name="photocheck_featured" value="hello" type="hidden">
                                            </label>

                                            <label>
                                                <span class="label-text">Title</span>
                                                <input type="text" name="featured_title" class="form-control" data-required="true">
                                            </label>

                                            <label>
                                                <span class="label-text">Subtitle</span>
                                                <input type="text" name="featured_subtitle" class="form-control">
                                            </label>

                                            <label>
                                                <span class="label-text">Text</span>
                                                <textarea name="featured_text" class="wysiwyg form-control"></textarea>
                                            </label>

                                            <label>
                                                <span class="label-text">Button Text</span>
                                                <input type="text" name="featured_cta" class="form-control">
                                            </label>

                                            <label>
                                                <span class="label-text">Link URL</span>
                                                <input type="text" name="featured_url" class="form-control" data-required="true">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row email-blocks">

                            </div>

                            <div class="row" style="padding-bottom: 15px;">
                                <div class="col-xs-12">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Add Email Block
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="new-email-block" data-block-type="single-two-col">Single Article: Two Column</a></li>
                                            <li><a href="#" class="new-email-block" data-block-type="single-full-width">Single Article: Full Width</a></li>
                                            <li><a href="#" class="new-email-block" data-block-type="double-chips">Double Article: Two Column / Image &amp; Title</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="footer-details panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Footer Settings</h3>
                                    </div>

                                    <div class="panel-body">
                                        <?php if (false): ?><label class="check-label">
                                            <input type="checkbox" name="sponsors_enabled" value="1">
                                            <strong>Show Sponsors?</strong>
                                        </label>

                                         <hr><?php endif; ?>


                                        <label>
                                            <span class="label-text">About Heading</span>
                                            <input type="text" name="about_title" class="form-control" data-required="true" value="About Buy Fresh Buy Local GLV">
                                        </label>

                                        <label>
                                            <span class="label-text">About Text</span>
                                            <textarea name="about_text" class="wysiwyg form-control" data-required="true">Improving direct access to locally grown foods. Building the local food economy. Educating consumers about local providers and farms. Researching local food issues. This is Buy Fresh Buy Local GLV.</textarea>
                                        </label>

                                        <label>
                                            <span class="label-text">Menu Heading</span>
                                            <input type="text" name="menu_title" class="form-control" data-required="true" value="Discover">
                                        </label>

                                        <div class="row">
                                            <label class="col-sm-6">
                                                <span class="label-text">Menu Link 1: Text</span>
                                                <input type="text" name="menu_link_1_text" class="form-control" data-required="true">
                                            </label>

                                            <label class="col-sm-6">
                                                <span class="label-text">Menu Link 1: URL</span>
                                                <input type="text" name="menu_link_1_url" class="form-control" data-required="true">
                                            </label>
                                        </div>

                                        <div class="row">
                                            <label class="col-sm-6">
                                                <span class="label-text">Menu Link 2: Text</span>
                                                <input type="text" name="menu_link_2_text" class="form-control" data-required="true">
                                            </label>

                                            <label class="col-sm-6">
                                                <span class="label-text">Menu Link 2: URL</span>
                                                <input type="text" name="menu_link_2_url" class="form-control" data-required="true">
                                            </label>

                                        </div>

                                        <div class="row">
                                            <label class="col-sm-6">
                                                <span class="label-text">Menu Link 3: Text</span>
                                                <input type="text" name="menu_link_3_text" class="form-control">
                                            </label>

                                            <label class="col-sm-6">
                                                <span class="label-text">Menu Link 3: URL</span>
                                                <input type="text" name="menu_link_3_url" class="form-control">
                                            </label>
                                        </div>

                                        <div class="row">
                                            <label class="col-sm-6">
                                                <span class="label-text">Menu Link 4: Text</span>
                                                <input type="text" name="menu_link_4_text" class="form-control">
                                            </label>

                                            <label class="col-sm-6">
                                                <span class="label-text">Menu Link 4: URL</span>
                                                <input type="text" name="menu_link_4_url" class="form-control">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="padding-bottom: 15px;">
                                <div class="col-xs-12">
                                    <input type="hidden" name="number_email_blocks" value="0">
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-7 hidden-sm hidden-xs">
                            <div class="email-preview">

                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div><!-- END: .site-wrapper -->

        <script src="/scripts/vendor/jquery/jquery.min.js"></script>
        <script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
        <script src="/scripts/plugins.min.js"></script>
        <script src="/scripts/scripts.min.js"></script>
    </body>
</html>