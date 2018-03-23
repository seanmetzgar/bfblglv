<article id="post-<?php the_ID(); ?>" <?php post_class('my-3 mb-4'); ?>>
    <header>
        <?php if ( is_singular() ) { echo '<h1 class="entry-title">'; } else { echo '<h2 class="entry-title">'; } ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><span><?php the_title(); ?></span></a><?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?>
    </header>
    <?php get_template_part( 'entry', 'content' ); ?>
    <?php if ( !is_search() ) get_template_part( 'entry-footer' ); ?>
</article>