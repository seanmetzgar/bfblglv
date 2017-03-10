<?php get_header(); 
	$page_header = "";
	$page_title = "";
	$page_description = "";
	$page_icon = "";

	if (in_array($post_type, array("sponsors", "play", "explore", "shop"))) {
		$header_image = get_field("header_image_{$post_type}", "option");
		$header_class = ($header_image) ? "page-header has-image" : "page-header";
		$header_title = get_field("header_title_{$post_type}", "option");
		$page_title = get_field("title_{$post_type}", "option");
		$page_location = get_field("location_{$post_type}", "option");
		$page_description = get_field("description_{$post_type}", "option");
		$page_icon = get_field("icon_{$post_type}", "option");
		$page_sponsor = get_field("sponsored_by_{$post_type}", "option");
		$page_sponsor = ($page_sponsor) ? sponsored_by($page_sponsor, false) : false;

		$page_header = "<header class=\"{$header_class}\">";
			$page_header .= ($header_image) ? "<figure class=\"image\" style=\"background-image:url('{$header_image}');\"></figure>" : "";
			$page_header .= "<h1 class=\"header-title\">{$header_title}</h1>";
		$page_header .= "</header>";
	} else {
		$page_title = "Archives";
	}

	$page_headline_html = page_headline($page_title, $page_icon, "h2", $page_sponsor, $page_location);
	$block_links_class = "block-links {$post_type}-links";

?>
			<?php echo $page_header; ?>
			<section class="main-content" role="main">
				<div class="container-fluid constrained unpadded">
					<header class="entry-header col-lg-10 col-lg-offset-1">
						<?php echo $page_headline_html; ?>
					</header>

					<?php if ($page_description): ?>
					<section class="entry-content col-lg-10 col-lg-offset-1">
						<?php echo $page_description; ?>
					</section>
					<?php endif; ?>
				</div>
				<?php if ($post_type === "sponsors"): ?>
				<?php get_template_part("tastelv-sponsors-archive-content"); ?>
				<?php elseif ( have_posts() ) : ?>
				<section class="container-fluid constrained unpadded <?php echo $block_links_class; ?>">
					<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
					<?php endwhile; ?>
				</section>
				<?php if ($post_type === "shop") echo "<h3 style=\"font-size:1em; text-align: center;\">And more...</h3>"; ?>
				<?php endif; ?>
			</section>
<?php get_footer(); ?>