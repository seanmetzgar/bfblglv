<?php
/*
Template Name: Contact
*/

get_header();
	$content_class  = array("container-fluid", "constrained", "unpadded");
	$has_callouts = have_rows("home_callouts") ? true : false;
	$page_headline_html = page_headline(get_the_title(), get_field("icon"));
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

				<?php get_template_part("tastelv-map"); ?>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>