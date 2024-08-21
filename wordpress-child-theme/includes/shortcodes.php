<?php

/**
 * Contains all the shortcodes
 * 
 */


if ( ! function_exists('wordpress_child_current_year_shortcode') ) {
	/**
	 * Get the current year.
	 *
	 * @return string
	 */
	function wordpress_child_current_year_shortcode() {
		return date( "Y" );
	}
}
add_shortcode( 'wordpress_child_current_year', 'wordpress_child_current_year_shortcode' );

