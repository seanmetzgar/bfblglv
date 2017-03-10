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
        <link rel="stylesheet" type="text/css" href="/css/vendor/dragula/dragula.css">
    </head>

    <body>
        <div class="site-wrapper">
            <div class="container form-wrapper">
                <h1 class="title">Newsletter Output</h1>
                <div class="text-center">
                    <div class="toggler-wrap btn-group">
                        <button class="btn btn-primary toggler toggle-preview">Preview</button>
                        <button class="btn toggler toggle-code">HTML</button>
                    </div>
                </div>
            </div>

            <div class="output-wrapper">
                <div class="email-display display-layer active">
                    <iframe src="html-out.html" frameborder="0"></iframe>
                </div>

                <div class="code-display display-layer">
                    <textarea><?php echo file_get_contents("html-out.html"); ?></textarea>
                </div>
            </div>
        </div><!-- END: .site-wrapper -->

        <script src="/scripts/vendor/jquery/jquery.min.js"></script>
        <script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
        <script src="/scripts/plugins.min.js"></script>
        <script src="/scripts/scripts.min.js"></script>
    </body>
</html>