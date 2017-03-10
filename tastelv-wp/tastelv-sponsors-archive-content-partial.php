				<section class="container-fluid constrained sp-blocks unpadded">
				<?php if (isset($post_type) && $post_type !== "sponsors"):
					$sponsors_title = get_field("title_sponsors", "option");
					$sponsors_description = get_field("description_sponsors", "option");
					$sponsors_icon = get_field("icon_sponsors", "option");
					$sponsors_headline_html = page_headline($sponsors_title, $sponsors_icon, "h2");
				?>
					<header class="entry-header col-lg-10 col-lg-offset-1">
						<hr class="sponsor-top">
						<?php echo $sponsors_headline_html; ?>
					</header>

					<?php if ($sponsors_description): ?>
					<section class="entry-content col-lg-10 col-lg-offset-1">
						<?php echo $sponsors_description; ?>
					</section>
					<?php endif; ?>
				<?php endif; ?>

				<?php
					$sponsor_types = array("presenting-sponsors", "tasting-room-sponsors");
					foreach($sponsor_types as $sponsor_type) {
						sponsors_block($sponsor_type);
					}
				?>
				</section>
