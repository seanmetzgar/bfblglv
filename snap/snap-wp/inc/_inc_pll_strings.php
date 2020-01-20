<?php
function ewereka_translation_strings() {
    pll_register_string( 'Not Found', 'Not Found' );
    pll_register_string( 'Nothing found for the requested page. Try a search instead?', 'Nothing found for the requested page. Try a search instead?' );
    pll_register_string( 'Frequently Asked Questions', 'Frequently Asked Questions' );
    pll_register_string( 'Resources', 'Resources' );
    pll_register_string( 'Community Partners Resources', 'Community Partners Resources' );
    pll_register_string( 'Vendor Resources', 'Vendor Resources' );
    pll_register_string( 'Archives', 'Archives' );
    pll_register_string( 'Daily Archives: %s', 'Daily Archives: %s' );
    pll_register_string( 'Monthly Archives: %s', 'Monthly Archives: %s' );
    pll_register_string( 'Yearly Archives: %s', 'Yearly Archives: %s' );
    pll_register_string( 'Author Archives', 'Author Archives' );
    pll_register_string( 'Category Archives: ', 'Category Archives: ' );
    pll_register_string( 'Navigate', 'Navigate' );
    pll_register_string( 'Connect with us', 'Connect with us' );
    pll_register_string( 'Facebook', 'Facebook' );
    pll_register_string( 'Twitter', 'Twitter' );
    pll_register_string( 'YouTube', 'YouTube' );
    pll_register_string( 'Instagram', 'Instagram' );
    pll_register_string( 'Testimonials', 'Testimonials' );
    pll_register_string( 'Previous', 'Previous' );
    pll_register_string( 'Next', 'Next' );
    pll_register_string( 'Have any questions?', 'Have any questions?' );
    pll_register_string( 'Contact Us', 'Contact Us' );
    pll_register_string( 'Search Results for: %s', 'Search Results for: %s' );
    pll_register_string( 'Nothing Found', 'Nothing Found' );
    pll_register_string( 'Sorry, nothing matched your search. Please try again.', 'Sorry, nothing matched your search. Please try again.' );
    pll_register_string( 'Tag Archives: ', 'Tag Archives: ' );
    pll_register_string( 'Return to %s', 'Return to %s' );
    pll_register_string( '%s older', '%s older' );
    pll_register_string( 'newer %s', 'newer %s' );
}
add_action('init', 'ewereka_translation_strings');
