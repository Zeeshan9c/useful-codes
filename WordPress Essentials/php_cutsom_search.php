<?php

/**
 * Custom Search Shortcode
 *
 * Renders a standard WordPress search form wrapped in a custom class.
 */
function is_custom_search_shortcode() { 
	ob_start();
	?>
	<form role="search" class="is-custom-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="search-field" placeholder="Search…" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
		<button type="submit" class="search-submit"><span class="elementor-button-content-wrapper">Search</span></button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode('is_custom_search', 'is_custom_search_shortcode'); 

// ----------------------------------------------------