
            <footer class="footer container" role="contentinfo">
                <div class="copyright">
                    <?php 
                    	echo sprintf(
                    		__("%1$s %2$s %3$s. All Rights Reserved.", "kudu"),
                    			"&copy;",
                    			date("Y"),
                    			esc_html(get_bloginfo("name")));
                    	echo " " . sprintf(
                    		__("Theme By: %1$s.", "kudu" ),
                    			"<a href=\"http://wearekudu.com/\">Kudu Creative</a>");
                    ?>
                </div>
            </footer>

        </div><!-- END: .site-wrapper -->
        <?php wp_footer(); ?>
    </body>
</html>