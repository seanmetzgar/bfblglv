<footer class="entry-footer">
    <?php edit_post_link(); ?>
    <?php if ( comments_open() ) {
        echo '<span class="meta-sep">|</span> <span class="comments-link"><a href="' . get_comments_link() . '">' . sprintf( __( 'Comments', 'snap-wp' ) ) . '</a></span>';
    } ?>
</footer>