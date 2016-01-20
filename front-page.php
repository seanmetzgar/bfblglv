<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<link rel="stylesheet" type="text/css" href=""
			<header class="animated-header" role="complementary">
				<nav class="inner">
                    <ul class="animated-blocks">
                        <li style="background-image: url(../images/header/about_photo.jpg);"><a href="#">
                            <div class="content">
                                <h3>About</h3>
                                <div class="subtext"><p>This is an excerpt of what you'll find in About.</p></div>
                            </div>
                        </a></li>
                        <li style="background-image: url(../images/header/wbl_photo.jpg);"><a href="#">
                            <div class="content">
                                <h3>Why Buy Local</h3>
                                <div class="subtext"><p>This is an excerpt of what you'll find in WBL.</p></div>
                            </div>
                        </a></li>
                        <li style="background-image: url(../images/header/ne_photo.jpg);"><a href="#">
                            <div class="content">
                                <h3>News &amp; Events</h3>
                                <div class="subtext"><p>This is an excerpt of what you'll find in N&amp;E.</p></div>
                            </div>
                        </a></li>
                        <li style="background-image: url(../images/header/res_photo.jpg);"><a href="#">
                            <div class="content">
                                <h3>Resources</h3>
                                <div class="subtext"><p>This is an excerpt of what you'll find in Resources.</p></div>
                            </div>
                        </a></li>
                        <li class="map-link"><a href="#" title="Find Local Food - View the map" class="map-link">
                            <div class="map-content">
                                <div class="badge"><img src="/images/header/badge.png"></div>
                                <h3>Find<br>Local<br>Food</h3>
                                <p class="subtext">View the map</p>
                            </div>
                        </a></li>
                    </ul>
                </nav>
			</header>

			<section class="main-content" role="main">
			
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
				<?php comments_template(); ?>
				<?php endwhile; endif; ?>

			</section>
<?php get_footer(); ?>