<?php
    $bfbl_logo = get_field("bfbl_logo", "option");
    $about_heading = trim(get_theme_mod("footer_about_heading"));
    $about_text = trim(get_theme_mod("footer_about_text"));
    $about_heading = ($about_heading) ? preg_replace("/\[(\w+)\]/", "<span class=\"accent\">$1</span>", $about_heading) : false;
    $about_text = ($about_text) ? $about_text = nl2br($about_text, false) : false;

    $instagram_heading = trim(get_theme_mod("footer_instagram_heading"));
    $instagram_hashtag = ltrim(trim(get_theme_mod("footer_instagram_hashtag")), "#");
    $instagram_heading = ($instagram_heading) ? preg_replace("/\[(\w+)\]/", "<span class=\"accent\">$1</span>", $instagram_heading) : false;
    $instagram_hashtag_code = ($instagram_hashtag) ? " hashtag=\"#{$instagram_hashtag}\"" : "";
    $instagram_sc_desktop = "[instagram-feed showheader=false showbutton=false showfollow=false num=9 cols=3 class=\"hidden-xs hidden-sm\" imageres=auto imagepadding=10 imagepaddingunit=px disablemobile=true{$instagram_hashtag_code}]";
    $instagram_sc_tablet = "[instagram-feed showheader=false showbutton=false showfollow=false num=6 cols=6 class=\"hidden-xs hidden-md hidden-lg hidden-xl\" imageres=auto imagepadding=10 imagepaddingunit=px disablemobile=true{$instagram_hashtag_code}]";
    $instagram_sc_mobile = "[instagram-feed showheader=false showbutton=false showfollow=false num=6 cols=3 class=\"hidden-sm hidden-md hidden-lg hidden-xl\" imageres=auto imagepadding=10 imagepaddingunit=px disablemobile=true{$instagram_hashtag_code}]";
?>
            <footer class="site-footer">
                <div class="footer-top">
                    <div class="container-fluid constrained unpadded">
                        <div class="col-md-4 col-sm-8 about-column">
                            <?php if ($about_text):
                                if ($about_heading) echo "<h3 class=\"footer-heading\">$about_heading</h3>";
                                echo "<p>$about_text</p>";
                                if ($bfbl_logo) echo "<p><a href=\"http://www.buylocalglv.org\" target=\"_blank\"><img src=\"{$bfbl_logo}\" class=\"footer-logo\" alt=\"Buy Fresh Buy Local Greater Lehigh Valley\"></a></p>";
                            endif; ?>
                        </div>
                        <div class="col-sm-3 col-md-offset-1 col-sm-offset-1 menu-column">
                            <h3 class="footer-heading">Navigate</h3>
                            <nav>
                                <?php wp_nav_menu( array(
                                    "theme_location"    => "footer-menu",
                                    "container"         => false
                                ) ); ?>
                            </nav>
                        </div>
                        <div class="col-md-3 col-md-offset-1 instagram-column">
                            
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="container-fluid constrained unpadded">
                        <div class="col-sm-8 col-sm-push-4">
                            <p class="copyright"><?php printf("&copy; %s %s. All Rights Reserved.", date("Y"), "Buy Fresh Buy Local of the Greater Lehigh Valley");
                            ?></p>
                        </div>
                        <div class="col-sm-4 col-sm-pull-8">
                            <a href="http://wearekudu.com" target="_blank" class="kudu-link">Made in the wild by Kudu</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div><!-- END: .site-wrapper -->
        <?php wp_footer(); ?>
    </body>
</html>