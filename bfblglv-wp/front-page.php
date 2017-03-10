<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/animated-header.css">
			<header class="animated-header" role="complementary">
				<nav class="inner">
                    <ul class="animated-blocks">
                	<?php for ($block_counter = 1; $block_counter <= 5; $block_counter++): 
                		$block_prefix = "block_$block_counter";
                		$block_cta = get_field("{$block_prefix}_cta");
                		$block_image = get_relative_file_path(get_field("{$block_prefix}_image"));
                		$block_href = get_field("{$block_prefix}_href");
                		$block_link_title = esc_attr($block_cta);
                		if ($block_counter == 5):
                			$block_title_small = get_field("{$block_prefix}_title_small");
                			$block_title_small = strlen($block_title_small) > 0 ? $block_title_small : false;
                			$block_title = get_field("{$block_prefix}_title");
                			$block_badge = get_field("{$block_prefix}_badge");
                			$block_badge = strlen($block_badge) > 0 ? get_relative_file_path($block_badge) : false;
                    	?>
                    	<li class="map-link" style="background-image: url('<?php echo $block_image; ?>');"><a href="<?php echo $block_href; ?>">
                            <div class="map-content">
                            	<div class="inner">
	                            	<?php if ($block_badge) echo "<div class=\"badge-icon\"><img src=\"$block_badge\"></div>"; ?>	                                
	                                <h3>
	                                	<?php if ($block_title_small) echo "<small>$block_title_small</small>"; ?>
	                                	<?php echo $block_title; ?>
	                                </h3>
	                            </div>
	                            <p class="subtext"><?php echo $block_cta; ?></p>
                            </div>
                        </a></li>
                    	<?php 
                		else:
                			$block_description = get_field("{$block_prefix}_description");
                    	?>
                        <li class="animated-link" style="background-image: url('<?php echo $block_image; ?>');"><a href="<?php echo $block_href; ?>">
                            <div class="content">
                                <h3><?php echo $block_cta; ?></h3>
                                <div class="subtext"><p><?php echo $block_description; ?></p></div>
                            </div>
                        </a></li>
                    <?php endif;
                	endfor; ?>
                    </ul>
                </nav>
			</header>

			<?php get_template_part("bfbl", "page-blocks"); ?>

			<!-- <section class="main-content" role="main">
			
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
				<?php comments_template(); ?>
				<?php endwhile; endif; ?>

			</section> -->

            <?php get_template_part("bfbl", "sponsors"); ?>
<?php get_footer(); ?>