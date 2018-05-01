        <div class="clear"></div>
    </div>

    <footer class="site-footer" role="contentinfo">
        <div class="container justify-content-center">
            <div class="row">
                <div class="col-md-2 col-12 footer-logo justify-content-center">
                    <a href="/"><img src="<?php echo get_template_directory_uri(); ?>/img/logos/bucks_logo_footer.png"></a>
                </div>
                <nav class="col-md-6 col-12 footer-nav text-center text-md-left">
                    <h3>Navigate</h3>
                    <?php
                        wp_nav_menu([
                            'theme_location'  => 'footer-menu',
                            'container'       => false,
                            'depth'           => 1
                        ]);
                    ?>
                </nav>
                <div class="col-md-4 col-12 footer-newsletter text-center text-md-right">
                    <h3>Connect with us</h3>
                    <ul class="social-icons">
                        <li><a href="https://www.facebook.com/BuyFreshBuyLocalGreaterLehighValley" target="_blank"><i class="ti-facebook"></i><span class="sr-only">Facebook</span></a></li>
                        <li><a href="https://twitter.com/BFBLGLV" target="_blank"><i class="ti-twitter"></i><span class="sr-only">Twitter</span></a></li>
                        <li><a href="https://www.youtube.com/user/BFBLGLV" target="_blank"><i class="ti-youtube"></i><span class="sr-only">YouTube</span></a></li>
                        <li><a href="https://www.instagram.com/BFBLGLV" target="_blank"><i class="ti-instagram"></i><span class="sr-only">Instagram</span></a></li>

                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>