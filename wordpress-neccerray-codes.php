<?php
/**
 * Shortcode and Function Codes for WordPress Customizations
 * --------------------------------------------------------
 * This file contains reusable PHP and JavaScript code blocks for 
 * WordPress functionalities, including custom shortcodes, 
 * FacetWP integrations, and utility scripts.
 */

// --- PHP Code Blocks ---

/**
 * Custom Search Shortcode
 *
 * Renders a standard WordPress search form wrapped in a custom class.
 */
function sp_custom_search_shortcode() { 
	ob_start();
	?>
	<form role="search" class="sp-custom-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="search-field" placeholder="Search…" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
		<button type="submit" class="search-submit"><span class="elementor-button-content-wrapper">Search</span></button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode('sp_custom_search', 'sp_custom_search_shortcode'); 

// ----------------------------------------------------

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
 * Search Template Using FacetWP
 *
 * This section defines the parameters for a custom query and the display
 * of results, typically used for a custom search results template.
 */
?>
<?php // Custom Query Arguments for Search
return [
	"post_type" => [
		"post",
		"page"
	],
	"post_status" => [
		"publish"
	],
	"posts_per_page" => 9
];

?>
<?php
// Display search results content
if (have_posts()) {
	while (have_posts()) {
		the_post(); ?>
		<article <?php post_class(); ?>>
			<div class="elementor-post__text">
				<h3 class="elementor-post__title">
					<a href="<?php echo get_the_permalink(); ?>">
						<?php echo get_the_title(); ?>
					</a>
				</h3>
				<?php
				$excerpt = get_the_excerpt();
				if ( !empty( $excerpt ) ) : ?>
					<div class="elementor-post__excerpt">
						<?php echo wp_kses_post( wp_trim_words( $excerpt, 30 ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</article>
<?php }

	// Determine pagination sizes based on device type
	$mid_size = wp_is_mobile() ? 0 : 2;
	$end_size = 1;

	// Output standard posts pagination
	the_posts_pagination(array(
		'prev_text' => __('<', 'barrf'),
		'next_text' => __('>', 'barrf'),
		'type'      => 'plain',
		'mid_size'  => $mid_size,
		'end_size'  => $end_size,
		'class'     => 'pagination'
	));
	wp_reset_postdata();
} else { ?>
	<div class="search-noresults">
		<h3>We're sorry but there are no results for "<?php echo get_search_query(); ?>"</h3>
		<h6>Search Suggestions:</h6>
		<ul>
			<li>Check your spelling</li>
			<li>Try more general words</li>
			<li>Try searching for similar keywords</li>
		</ul>
	</div>
<?php } ?>

<!-- --- JavaScript/jQuery Code Blocks --- -->
<script>
/**
 * JavaScript Code for FacetWP Pagination
 *
 * Implements responsive pagination logic for FacetWP's Pager facet.
 */

// Window resize and load function to trigger responsive pagination
jQuery(window).on('resize load', function () {
	// Update pagination based on current screen size
	sp_responsive_pagination(); 
});

// Hook into FacetWP loading event
jQuery(document).on('facetwp-loaded', function (e) {
	if (FWP.loaded) {
		// Scroll to the top of the results on initial load
		if (jQuery('.facetwp-scroll-top').length) {
			jQuery('html,body').animate({
				scrollTop: jQuery('.facetwp-scroll-top').offset().top - jQuery('.elementor-location-header').height() + 10
			});
		}
	}
	// Facet Scroll to Top Code on Refresh/Pagination
	if (FWP.enable_scroll == true) {
		var topbar = 0;
		if (jQuery('html #wpadminbar').length > 0) {
			topbar = jQuery('html #wpadminbar').height();
		}
		jQuery('html,body').animate({
			scrollTop: jQuery('.facetwp-scroll-top').offset().top - jQuery('.elementor-location-header').height() - topbar
		});
	}

	sp_responsive_pagination(); 
})

/**
 * Custom Pagination Logic
 *
 * Manages which page numbers are visible and inserts '...' dots for mobile (mb) 
 * and desktop (dk) views based on defined limits.
 *
 * @param int mb_limit Pages visible around the active page (non-endpoint) on mobile.
 * @param int mb_endpoints_limit Pages visible around the active page (endpoint) on mobile.
 * @param int dk_limit Pages visible around the active page (non-endpoint) on desktop.
 * @param int dk_endpoints_limit Pages visible around the active page (endpoint) on desktop.
 */
function sp_pagination(mb_limit, mb_endpoints_limit, dk_limit, dk_endpoints_limit) { 
	// Target container for the FacetWP pager
	let container = '.facetwp-pager';
	
	// Exit if the FacetWP pager is not on the page
	if (!jQuery(container).length) {
		return;
	}

	let mb_hide_class = 'sp-hide-page-mb'; 
	let dk_hide_class = 'sp-hide-page-dk'; 
	
	// Dots markup for the start of the hidden range
	let dots_start = '<a role="none" class="facetwp-page dots start ' + mb_hide_class + ' ' + dk_hide_class + '">...</a>';
	// Dots markup for the end of the hidden range
	let dots_end = '<a role="none" class="facetwp-page dots end ' + mb_hide_class + ' ' + dk_hide_class + '">...</a>';

	// Get total and active pages
	let total_pages = parseInt(jQuery(container + ' a.facetwp-page.last').attr('data-page'));
	let active_page = parseInt(jQuery(container + ' a.facetwp-page.active').attr('data-page'));
	
	// Check if the current page is the first or last page
	let is_endpoint_page = (active_page === 1 || active_page === total_pages) ?
		true : false;

	// Calculate the visible page range for mobile
	let mb_range_start = is_endpoint_page ? active_page - mb_endpoints_limit : active_page - mb_limit;
	let mb_range_end = is_endpoint_page ?
		active_page + mb_endpoints_limit : active_page + mb_limit;
		
	// Calculate the visible page range for desktop
	let dk_range_start = is_endpoint_page ? active_page - dk_endpoints_limit : active_page - dk_limit;
	let dk_range_end = is_endpoint_page ? active_page + dk_endpoints_limit : active_page + dk_limit;

	let dots_mb_start, dots_mb_end, dots_dk_start, dots_dk_end = false;

	// Reset: remove existing dots and unhide all pages
	jQuery(container + ' .dots').remove();
	jQuery(container + ' a.facetwp-page:not(.prev, .next)').removeClass(mb_hide_class + ' ' + dk_hide_class);

	// Loop over all the page numbers, excluding active, 'previous', 'next', '1', and 'last'
	jQuery(container + ' a.facetwp-page:not(.active, .prev, .next, [data-page="1"], [data-page="' + total_pages + '"])').each(function (i, obj) {
		let current_page = jQuery(this).attr('data-page');
		// Mobile Logic
		if (current_page < mb_range_start) {
			jQuery(this).addClass(mb_hide_class);
			dots_mb_start = true;
		}
		if (current_page > mb_range_end) {
			jQuery(this).addClass(mb_hide_class);
			dots_mb_end = true;
		}
		// Desktop Logic
		if (current_page < dk_range_start) {
			jQuery(this).addClass(dk_hide_class);
			dots_dk_start = true;
		}
		if (current_page > dk_range_end) {
			jQuery(this).addClass(dk_hide_class);
			dots_dk_end = true;
		}
	});

	// Add '...' dots element at the start if needed
	if (dots_mb_start || dots_dk_start) {
		jQuery(container + ' a.facetwp-page[data-page="1"]').after(dots_start);
		if (dots_mb_start) {
			jQuery(container + ' .dots.start').removeClass(mb_hide_class);
		}
		if (dots_dk_start) {
			jQuery(container + ' .dots.start').removeClass(dk_hide_class);
		}
	}

	// Add '...' dots element at the end if needed
	if (dots_mb_end || dots_dk_end) {
		jQuery(container + ' a.facetwp-page[data-page="' + total_pages + '"]').before(dots_end);
		if (dots_mb_end) {
			jQuery(container + ' .dots.end').removeClass(mb_hide_class);
		}
		if (dots_dk_end) {
			jQuery(container + ' .dots.end').removeClass(dk_hide_class);
		}
	}
	
	// Update total page counter elements (if available)
	active_page = active_page ? active_page : 1;
	total_pages = total_pages ? total_pages : 1;
	jQuery('.sp-total-page-counter span.sp-current-page').html(active_page); 
	jQuery('.sp-total-page-counter span.sp-total-page').html(total_pages); 
}

/**
 * Update the Pagination Responsively
 *
 * Calls the main pagination function with different limits based on viewport width.
 */
function sp_responsive_pagination() { 

	// Screen size is less than 480 pixels (e.g., small mobile)
	if (window.innerWidth < 480) {
		sp_pagination(0, 0, 0, 0); // All pages hidden except active/first/last
	}
	// Screen size is between 481 and 767 pixels (e.g., mobile/tablet portrait)
	else if (window.innerWidth >= 481 && window.innerWidth <= 767) {
		sp_pagination(1, 1, 1, 1); // 1 page visible on each side (mobile & desktop limits set to 1)
	}
	// Screen size is bigger than 767 pixels (e.g., tablet landscape/desktop)
	else {
		sp_pagination(1, 1, 1, 2); // 1 page on each side (non-endpoint), 2 pages on each side (endpoint)
	}
}

// Hook into FacetWP refresh event (when results change)
jQuery(document).on('facetwp-refresh', function () {
	if (FWP.soft_refresh == true) {
		FWP.enable_scroll = true; // Enable scroll-to-top on soft refresh
	} else {
		FWP.enable_scroll = false; // Disable scroll-to-top on hard refresh
	}
	sp_responsive_pagination(); // Update pagination
});

// ----------------------------------------------------

/**
 * jQuery Boilerplate and Utility Functions
 *
 * Contains various general-purpose jQuery scripts for UI enhancements.
 */
(function ($) {

	// Variable to store the WordPress admin bar height
	var adminbar = 0;
	if ($('#wpadminbar').length) {
		adminbar = $('#wpadminbar').height();
	}

	/**
	 * Scroll Top for Nav Items (Hash Links)
	 *
	 * Handles smooth scrolling for links targeting an ID on the same page, 
	 * excluding the 'skip-main' link.
	 */
	$(document).on('click', 'a[href*="#"]:not(.skip-main)', function (e) {
		// Check if the href is on the same page
		if (this.pathname == window.location.pathname) {
			e.stopImmediatePropagation();
			e.preventDefault();
			let headerHeight = $('header').height();
			let targetId = $(this).attr('href').split('#')[1];
			let targetElement = $('#' + targetId);
			if (targetElement.length) {
				$('html, body').animate({
					scrollTop: targetElement.offset().top - headerHeight
				}, 500);
			}
		}
	});

	/**
	 * Smooth Scroll for Hash Links (Generic Fallback)
	 *
	 * Provides a smooth scroll animation for any hash link, adjusting for the 
	 * admin bar and header height.
	 */
	$('a[href^= "#"]').on('click', function (x) {
		x.stopImmediatePropagation();
		x.preventDefault();
		$(document).off("scroll");

		// Target element id
		var id = $(this).attr('href');
		// Target element
		var $id = $(id);
		if ($id.length === 0) {
			return;
		}

		// Prevent standard hash navigation (avoid blinking in IE)
		x.preventDefault();
		
		// Top position relative to the document
		var pos = $id.offset().top - adminbar - $('.elementor-location-header').height();
		
		// Animated top scrolling
		$('body, html').animate({ scrollTop: pos });
	});

	$(document).ready(function () {

		/**
		 * Search Visibility Toggle
		 *
		 * Toggles the 'show-search' class on the body and focuses the search input.
		 * @param bool show Whether to show or hide the search.
		 */
		function toggleSearch(show) {
			$('body').toggleClass('show-search', show);
			// Focus the search input after a slight delay if showing
			if (show) setTimeout(() => $(".search-wrapper form input").focus(), 100);
		}
		
		// Event handlers for click and Enter key to show search
		$('.search-icon .elementor-icon').on('click keypress', function (e) {
			if (e.type === 'click' || e.key === 'Enter') toggleSearch(true);
		});
		
		// Event handlers for click and Enter key to hide search
		$('.search-close .elementor-icon').on('click keypress', function (e) {
			if (e.type === 'click' || e.key === 'Enter') toggleSearch(false);
		});

		/**
		 * External Link Class Adder
		 *
		 * Adds the 'sp_external_link' class to Elementor buttons that link 
		 * to external domains (i.e., not the current hostname).
		 */
		var $buttons = $('.elementor-widget-button a.elementor-button');
		if ($buttons.length) {
			$buttons.each(function () {
				var href = $(this).attr('href');
				if (href && href.startsWith('http') && !href.includes(window.location.hostname)) {
					$(this).addClass('sp_external_link'); 
				}
			});
		}
	}); // Ready Ends

	// ----------------------------------------------------

	/**
	 * Offset Calculator for CSS Variable (Transforms/Overlaps)
	 *
	 * Calculates a dynamic CSS variable (--act-offset) based on the height 
	 * of a child element, used for complex layout overlaps on desktop screens.
	 */
	function updateActBasicsHeight() {
		if (!$('.sp_is_transform').length) return; 
		
		// Only run on desktop screens (min-width: 1025px)
		if (window.matchMedia("(min-width: 1025px)").matches) {
			$('.sp_is_transform').each(function () { 
				var $this = $(this);
				var height = $this.find('.sp_transform_body').outerHeight() || 0; 
				var paddingBottom = parseInt($this.find('.sp_transform_block').css('padding-bottom')) || 0; 

				// Calculate the total offset
				var totalOffset = height + (paddingBottom / 2);

				// Set the CSS variables
				$this.find('.sp_transform_block').css('--act-offset', + totalOffset + 'px'); 
				$this.css('--act-offset', + totalOffset + 'px');
			});
		} else {
			// Clear the CSS variables on non-desktop screens
			$('.sp_is_transform').each(function () { 
				var $this = $(this);
				$this.find('.sp_transform_block').css('--act-offset', ''); 
				$this.css('--act-offset', '');
			});
		}
	}
	
	// Recalculate offset on load and resize
	$(window).on('load resize', updateActBasicsHeight);

	// ----------------------------------------------------

	/**
	 * Mega Menu Toggle Function
	 *
	 * Toggles the visibility of the main navigation menu on mobile/tablet (max-width: 1024px).
	 */
	$('.toggle-icon .elementor-icon').on('click', function () {
		if (window.matchMedia("(max-width: 1024px)").matches) {
			const $menu = $('.site-nav-main');
			// Slide toggle the mega menu
			$menu.slideToggle(function () {
				$('body').toggleClass('header-toggled', $(this).is(':visible'));
			});
		}
	});
	
	// Add toggle arrow to mega menu items with children
	$('<span class="open-menu-arrow"></span>').appendTo($('.site-nav .mega-menu .mega-menu-item.mega-menu-item-has-children'));
	
	/**
	 * Mobile Header Sub Childs Toggle Button 
	 *
	 * Handles the click event for the custom arrow, toggling the visibility 
	 * of sub-menus and collapsing siblings' sub-menus.
	 */
	$(document).on('click', '.open-menu-arrow', function () {
		$(this).parent().toggleClass('active');
		$(this).parent().children('ul').slideToggle();
		$(this).parent().siblings('li').children('ul').slideUp();
		$(this).parent().siblings('li').removeClass('active');
	});

	// ----------------------------------------------------

	/**
	 * Elementor Frontend Initialization Hook
	 *
	 * Code to run once Elementor's frontend assets are loaded.
	 */
	$(window).on('elementor/frontend/init', function () {
		// Testimonial slider initialization
		setTimeout(function () {
			if ($(".sp-testimonials").length) { 
				// Destroy any existing Swiper instance
				var sliderInstance = document.querySelector('.sp-testimonials .elementor-main-swiper.swiper').swiper; 
				if (sliderInstance) {
					sliderInstance?.destroy();
				}
				
				// Re-wrap pagination and navigation buttons
				$('.sp-testimonials .swiper-pagination, .sp-testimonials .elementor-swiper-button').wrapAll('<div class="swiper-controllers"></div>'); 
				
				// Initialize the Swiper slider
				new Swiper('.sp-testimonials .elementor-main-swiper.swiper', { 
					slidesPerView: 1.001,
					slidesPerGroup: 1,
					spaceBetween: 16,
					watchOverflow: true,
					centeredSlides: true,
					loop: true,
					pagination: {
						el: '.sp-testimonials .swiper-pagination', 
						type: 'bullets',
						clickable: true,
					},
					navigation: {
						nextEl: '.sp-testimonials .elementor-swiper-button-next', 
						prevEl: '.sp-testimonials .elementor-swiper-button-prev', 
					},
					breakpoints: {
						1024: {
							slidesPerView: 1.001,
							spaceBetween: 24,
						}
					}
				});
			}
		}, 2000); // 2-second delay to ensure all assets are ready
	});


}(jQuery));
</script>
