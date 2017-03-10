<?php
if (is_front_page()) {
	$hero_html = "";
	$hero_left_a = get_relative_file_path(get_theme_mod("hero_left_a"));
	$hero_left_b = get_relative_file_path(get_theme_mod("hero_left_b"));
	$hero_right_a = get_relative_file_path(get_theme_mod("hero_right_a"));
	$hero_right_b = get_relative_file_path(get_theme_mod("hero_right_b"));
	$hero_right_c = get_relative_file_path(get_theme_mod("hero_right_c"));
	$hero_right_d = get_relative_file_path(get_theme_mod("hero_right_d"));
	$hero_logo = get_theme_mod("hero_logo");
	$hero_date = get_field("event_date", "option");
	$hero_time = get_field("event_time", "option");
	$hero_location = get_field("event_location", "option");
	$hero_host_text = get_theme_mod("hero_host_text");
	$hero_sponsor_text = get_theme_mod("hero_sponsor_text");
	$hero_sponsor = get_field("event_sponsor", "option");
	$bfbl_logo = get_field("bfbl_logo", "option");

	if (intval($hero_sponsor) && (int)$hero_sponsor > 0 && has_post_thumbnail((int)$hero_sponsor)) {
		$hero_sponsor_image = wp_get_attachment_image_url(get_post_thumbnail_id((int)$hero_sponsor), "medium");
	}

	if ($hero_left_a && $hero_left_b && $hero_right_a && $hero_right_b && $hero_right_c && $hero_right_d && $hero_logo) {

		$hero_html .= "<div class=\"hero\">";
			$hero_html .= "<div class=\"hero-left\">";
				$hero_html .= "<div class=\"hero-image left-a\" style=\"background-image:url('{$hero_left_a}');\"></div>";
				$hero_html .= "<div class=\"hero-image left-b\" style=\"background-image:url('{$hero_left_b}');\"></div>";
			$hero_html .= "</div>";

			$hero_html .= "<div class=\"hero-center\">";
				$hero_html .= "<div class=\"content\">";
					if ($hero_host_text && $bfbl_logo) {
					$hero_html .= "<div class=\"hero-sponsor\">";
						$hero_html .= "<p class=\"text\">$hero_host_text</p>";
						$hero_html .= "<figure class=\"image\"><img class=\"img-responsive\" src=\"{$bfbl_logo}\"></figure>";
					$hero_html .= "</div>";
					}
					if ($hero_sponsor_text && $hero_sponsor_image) {
					$hero_html .= "<div class=\"hero-sponsor\">";
						$hero_html .= "<p class=\"text\">$hero_sponsor_text</p>";
						$hero_html .= "<figure class=\"image\"><img class=\"img-responsive\" src=\"{$hero_sponsor_image}\"></figure>";
					$hero_html .= "</div>";
					}
					if ($hero_location && $hero_date) {
					$hero_html .= "<p class=\"hero-meta-row\">";
					$hero_html .= "<span class=\"hero-date hero-meta icon-calendar-empty\">$hero_date</span>";
					$hero_html .= "<span class=\"hero-location hero-meta icon-location-5\">$hero_location</span>";
						if ($hero_time) {
							$hero_html .= "<br><span class=\"hero-time hero-meta icon-clock\">$hero_time</span>";
						}
					$hero_html .= "</p>";
					}
					$hero_html .= "<div class=\"hero-logo\"><img class=\"img-responsive\" src=\"{$hero_logo}\"></div>";
				$hero_html .= "</div>";
			$hero_html .= "</div>";

			$hero_html .= "<div class=\"hero-right\">";
				$hero_html .= "<div class=\"hero-image right-a\" style=\"background-image:url('{$hero_right_a}');\"></div>";
				$hero_html .= "<div class=\"hero-image right-b\" style=\"background-image:url('{$hero_right_b}');\"></div>";
				$hero_html .= "<div class=\"hero-image right-c\" style=\"background-image:url('{$hero_right_c}');\"></div>";
				$hero_html .= "<div class=\"hero-image right-d\" style=\"background-image:url('{$hero_right_d}');\"></div>";
			$hero_html .= "</div>";
		$hero_html .= "</div>";
	}
	echo $hero_html;
}