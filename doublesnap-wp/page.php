<?php get_header();
	$front_page = (is_front_page()) ? true : false;
	$content_class  = array("container-fluid", "constrained", "unpadded");
	$has_callouts = have_rows("home_callouts") ? true : false;
	$sponsor = get_field("sponsored_by");
	$sponsor = ($sponsor) ? sponsored_by($sponsor, false) : false;
	$page_headline_html = page_headline(get_the_title(), get_field("icon"), "h1", $sponsor);
?>
			<?php if (!$front_page): 
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
			endif; ?>
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

				<?php if (have_rows("navigation_blocks")) {
					$possible_post_types = array("play", "shop", "sponsors", "explore");
					$nav_blocks_html = "<section class=\"navigation-blocks block-links container-fluid constrained unpadded\">";
					while (have_rows("navigation_blocks")) {
						the_row();
						$block_url = get_sub_field("page");
						$block_object_id = url_to_postid($block_url);
						$block_name = get_sub_field("name");
						$block_attr = esc_attr($block_name);
						$block_external = false;
						$block_image = "";
						$block_class = array("block-link", "col-md-3", "col-xs-6");


						if (is_int($block_object_id) && $block_object_id > 0) {
							$block_image = get_field("block_image", $block_object_id);
							echo "<!-- $block_image -->";
						} elseif (!get_sub_field("off_site")) {
							foreach($possible_post_types as $possible_post_type) {
								if (get_post_type_archive_link($possible_post_type) == $block_url) {
									$block_archive = true;
									$block_image = get_field("block_image_{$possible_post_type}", "option");
								}
							}
						} else {
							$block_image = get_sub_field("block_image");
							$block_external = true;
						}

						if ($block_image) {
							$block_image = " style=\"background-image: url('{$block_image}');\"";
						} else {
							$block_image = "";
							$block_class[] = "no-image";
						}
						$block_class = implode(" ", $block_class);
						$block_target = $block_external ? " target=\"_blank\"" : "";
						$nav_blocks_html .= "<div class=\"{$block_class}\">";
							$nav_blocks_html .= "<a href=\"{$block_url}\" title=\"{$block_attr}\"{$block_target}>";
								$nav_blocks_html .= "<figure class=\"image\"{$block_image}></figure>";
								$nav_blocks_html .= "<div class=\"content\">{$block_name}</div>";
							$nav_blocks_html .= "</a>";
						$nav_blocks_html .= "</div>";
					}
					$nav_blocks_html .= "</section>";
					echo $nav_blocks_html;
				} ?>

				<?php if ($front_page && $has_callouts): 
					$callouts_background_img = get_field("home_callouts_image");
					$callouts_background_img = $callouts_background_img ? " style=\"background-image:url('{$callouts_background_img}');\"" : "";
				?>
				<section class="callouts-section"<?php echo $callouts_background_img; ?>>
					<div class="container-fluid constrained unpadded">
						<?php while (have_rows("home_callouts")): 
							the_row();
							$callout_number = (int)get_sub_field("number");
							$callout_number = is_integer($callout_number) ? number_format($callout_number, 0, ".", ",") : false;

							$callout_text = get_sub_field("text");
							$callout_text = strlen($callout_text) > 0 ? $callout_text : false;

							if ($callout_number && $callout_text):
								$callout_html = 			"<div class=\"col-sm-3 col-xs-6\">";
									$callout_html .=			"<div class=\"callout\">";
										$callout_html .=			"<span class=\"number countup-number\" data-number=\"$callout_number\">$callout_number</span>";
										$callout_html .=			"<span class=\"text\">$callout_text</span>";
									$callout_html .=			"</div>";
								$callout_html .=			"</div>";
								echo $callout_html;
							endif;
						endwhile ?>
					</div>
				</section>
				<?php endif; ?>

				<?php if ($front_page) get_template_part("tastelv-sponsors-archive-content"); ?>
				<?php if (!$front_page) {
					$show_sponsors = get_field("show_sponsors");
					if ($show_sponsors === "all") {
						echo "<hr>";
						get_template_part("tastelv-sponsors-archive-content"); 
					} elseif ($show_sponsors === "partial") {
						echo "<hr>";
						get_template_part("tastelv-sponsors-archive-content-partial"); 
					}
				} ?>
				<?php if ($front_page) get_template_part("tastelv-map"); ?>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>