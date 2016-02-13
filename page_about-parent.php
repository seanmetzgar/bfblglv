<?php
/**
 * Template Name: About (Parent)
 *
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					$show_mission = get_field("show_mission");
					$project_team_image = get_field("project_team_image");
					$show_mission = is_bool($show_mission) ? $show_mission : false; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>

					<?php if ($show_mission): ?>
					<section class="mission-statement">
						<div class="content">
							<h2><?php the_field("mission_title"); ?></h2>
							<?php the_field("mission_text"); ?>
						</div>
					</section>
					<?php endif; ?>

					<section class="entry-content">
						<?php the_content(); ?>
						<?php get_template_part("bfbl", "gallery"); ?>
					</section>

					<?php get_template_part("bfbl", "page-blocks"); ?>

					<section class="team-section">
						<?php if ($project_team_image): ?>
						<div class="image">
							<?php echo wp_get_attachment_image($project_team_image, "full"); ?>
						</div>
						<?php endif; ?>

						<div class="project-leads">
							<h2><?php the_field("project_leads_title"); ?></h2>
							<?php if (have_rows("project_leads")): ?>
							<ul>
								<?php while (have_rows("project_leads")) : the_row(); ?>
								<li>
									<?php 
										echo "<span class=\"name\">" . get_sub_field("name") . "</span>";
										echo "<br>";
										echo "<span class=\"position\">" . get_sub_field("position") . "</span>";
									?>
								</li>
								<?php endwhile; ?>
							</ul>
							<?php endif; ?>
						</div>

						<div class="advisory-board">
							<h2><?php the_field("project_leads_title"); ?></h2>
							<ul>
								<?php while (have_rows("advisory_board")) : the_row(); ?>
								<li>
									<?php 
										echo "<span class=\"name\">" . get_sub_field("name") . "</span>";
										echo ", ";
										echo "<span class=\"position\">" . get_sub_field("position") . "</span>";
										echo "<br>";
										echo "<span class=\"organization\">" . get_sub_field("organization") . "</span>";
									?>
								</li>
								<?php endwhile; ?>
							</ul>
						</div>
							
					</section><!-- end section.team-section -->
					<?php get_template_part("bfbl", "sponsors"); ?>
				</article>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>