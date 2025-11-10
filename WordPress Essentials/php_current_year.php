<?php

/**
 * Shortcode for Current Year
 *
 * Outputs the current four-digit year (e.g., 2025).
 */
if (!function_exists('spcodes_current_year_shortcode')) { 
	/**
	 * Get the current year.
	 *
	 * @return string The current year (YYYY format).
	 */
	function spcodes_current_year_shortcode() { 
		return date("Y");
	}
}
add_shortcode('spcodes_current_year', 'spcodes_current_year_shortcode'); 

// ----------------------------------------------------