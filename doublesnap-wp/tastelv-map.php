<section class="map-section">
	<?php $event_map = get_field("event_map", "option"); if (is_array($event_map)): ?>
	<div class="acf-map">
		<div id="map-location-<?php the_ID(); ?>" class="marker" data-lat="<?php echo $event_map['lat']; ?>" data-lng="<?php echo $event_map['lng']; ?>"></div>
	</div><?php endif; ?>
	<div class="event-details">
		<h2>Location</h2>
		<p class="event-location"><?php the_field("event_location", "option"); ?></p>

		<div class="event-meta icon-location-5"><?php the_field("event_address", "option"); ?></div>
		<?php if (get_field("event_email", "option")): ?>
		<div class="event-meta icon-mail-alt"><a href="mailto:<?php the_field("event_phone", "option"); ?>"><?php the_field("event_email", "option"); ?></a></div>
		<?php endif; ?>
		<?php if (get_field("event_phone", "option")): ?>
		<div class="event-meta icon-phone"><?php the_field("event_phone", "option"); ?></div>
		<?php endif; ?>
		<?php if (get_field("event_time", "option")): ?>
		<div class="event-meta icon-clock"><?php the_field("event_time", "option"); ?></div>
		<?php endif; ?>
	</div>
</section>