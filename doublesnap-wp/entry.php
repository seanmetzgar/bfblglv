<?php
if (is_archive()) {
	get_template_part("entry-archive", $post_type);
} elseif (is_search()) {
	get_template_part("entry-search", $post_type);
} else {
	get_template_part("entry-content", $post_type);
} ?>