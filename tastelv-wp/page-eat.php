<?php
/*
Template Name: Eat
*/

get_header();
	$content_class  = array("container-fluid", "constrained", "unpadded");
	$has_callouts = have_rows("home_callouts") ? true : false;
	$sponsor = get_field("sponsored_by");
	$sponsor = ($sponsor) ? sponsored_by($sponsor, false) : false;
	$page_headline_html = page_headline(get_the_title(), get_field("icon"), "h1", $sponsor);
	
?>
			<?php 
			$header_image = get_field("header_image");
			$header_class = ($header_image) ? "page-header has-image" : "page-header";
			$header_title = get_field("header_title");
			if ($header_title):
				$page_header = "<header class=\"{$header_class}\">";
					$page_header .= ($header_image) ? "<figure class=\"image\" style=\"background-image:url('{$header_image}');\"></figure>" : "";
					$page_header .= "<h1 class=\"header-title\">{$header_title}</h1>";
				$page_header .= "</header>";
				echo $page_header;
			endif; 
			?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class($content_class); ?>>
					<header class="entry-header col-lg-10 col-lg-offset-1">
						<?php echo $page_headline_html; ?>
					</header>

					<section class="entry-content col-lg-10 col-lg-offset-1">
						<?php the_content(); ?>
						<div class="entry-links"><?php wp_link_pages(); ?></div>
					</section>
				</article>

				<section class="orange-section"><div class="container-fluid constrained unpadded">
				<?php
					$orange_headline = page_headline(get_field("orange_title"), get_field("orange_icon"), "h2");
				?>
					<header class="entry-header col-lg-10 col-lg-offset-1">
						<?php echo $orange_headline; ?>
					</header>
					<section class="entry-content col-lg-10 col-lg-offset-1">
						<?php the_field("orange_content"); ?>
					</section>
				</div></section>

				<?php $block_links_class = "block-links shop-links"; 
				$eat_query = new WP_Query(array(
					"post_type"		=> "eat",
					"posts_per_page" => -1
				));
				if ($eat_query->have_posts()):
				?>
				<section class="container-fluid constrained unpadded <?php echo $block_links_class; ?>">
				<?php
					$eat_headline = page_headline(get_field("title_eat"), get_field("icon_eat"), "h2");
				?>
					<header class="entry-header col-lg-10 col-lg-offset-1">
						<?php echo $eat_headline; ?>
					</header>
					<?php while ( $eat_query->have_posts() ) : $eat_query->the_post();
						get_template_part("entry-archive", $post_type);
					endwhile; ?>
				</section>
				<?php endif; wp_reset_postdata(); ?>
				<?php endwhile; echo "<h3 style=\"text-align: center; font-size: 1em;\">And more...</h3>"; endif; ?>
			</section>
<?php get_footer(); ?>