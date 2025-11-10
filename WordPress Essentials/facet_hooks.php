<?php

/**
 * Hide Counts in FacetWP Dropdown Facets
 *
 * Forces FacetWP to not display item counts next to options in dropdown facets.
 */
add_filter('facetwp_facet_dropdown_show_counts', '__return_false');

// ----------------------------------------------------

/**
 * FacetWP Main Query Adjustment
 *
 * Ensures FacetWP results are not treated as the main query on the homepage,
 * preventing conflicts with the default WordPress loop.
 *
 * @param bool $is_main_query Whether the query is the main query.
 * @param WP_Query $query The WP_Query object.
 * @return bool Modified main query status.
 */
function sp_custom_facetwp_query($is_main_query, $query) {
	if ($query -> is_home() || $query -> is_main_query()) {
		$is_main_query = false;
	}
	return $is_main_query;
}
add_filter('facetwp_is_main_query', 'sp_custom_facetwp_query', 10, 2);

// ----------------------------------------------------

/**
 * Use Archive Template for FacetWP Results
 *
 * Forces FacetWP to use the theme's standard archive template for displaying results.
 */
add_filter('facetwp_template_use_archive', '__return_true');

// ----------------------------------------------------
/**
 * Disable FacetWP's Default Styles
 *
 * Prevents FacetWP from loading its built-in CSS styles, allowing for custom styling.
 */
add_filter('facetwp_load_css', '__return_false');
// ----------------------------------------------------

