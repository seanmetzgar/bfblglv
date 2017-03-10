<section class="entry-meta">
	<?php if ($post_type !== "events"): ?>
	<span class="entry-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
	<?php else: ?>
	<span class="entry-date"><?php the_field("event_date");?></span>
	<?php endif; ?>
</section>