        <div class="clear"></div>
    </div>

    <footer class="site-footer" role="contentinfo">
        <div class="container justify-content-center">
            <div class="row">
                <div class="col-md-2 col-12 footer-logo justify-content-center">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/logos/bucks_logo_footer.png">
                </div>
                <nav class="col-md-6 col-12 footer-nav">
                    <h3>Navigate</h3>
                    <?php
                        wp_nav_menu([
                            'theme_location'  => 'main-menu',
                            'container'       => false,
                            'depth'           => 1
                        ]);
                    ?>
                </nav>
                <div class="col-md-4 col-12 footer-newsletter">
                    <h3>Connect with us</h3>
                    <p>[newsletter signup placeholder]</p>
                </div>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>