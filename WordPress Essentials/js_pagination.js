<style>

    .sp-hide-page-dk {
        display: none !important;
    }

    @media (max-width: 767px) {
        .is-hide-page-mb {
            display: none !important;
        }

        .is-hide-page-dk {
            display: block !important;
        }
    }

</style>

// Window resize and load function to trigger responsive pagination
jQuery(window).on('resize load', function () {
	// Update pagination based on current screen size
	is_responsive_pagination(); 
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

	is_responsive_pagination(); 
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
function is_pagination(mb_limit, mb_endpoints_limit, dk_limit, dk_endpoints_limit) { 
	// Target container for the FacetWP pager
	let container = '.facetwp-pager';
	
	// Exit if the FacetWP pager is not on the page
	if (!jQuery(container).length) {
		return;
	}

	let mb_hide_class = 'is-hide-page-mb'; 
	let dk_hide_class = 'is-hide-page-dk'; 
	
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
function is_responsive_pagination() { 

	// Screen size is less than 480 pixels (e.g., small mobile)
	if (window.innerWidth < 480) {
		is_pagination(0, 0, 0, 0); // All pages hidden except active/first/last
	}
	// Screen size is between 481 and 767 pixels (e.g., mobile/tablet portrait)
	else if (window.innerWidth >= 481 && window.innerWidth <= 767) {
		is_pagination(1, 1, 1, 1); // 1 page visible on each side (mobile & desktop limits set to 1)
	}
	// Screen size is bigger than 767 pixels (e.g., tablet landscape/desktop)
	else {
		is_pagination(1, 1, 1, 2); // 1 page on each side (non-endpoint), 2 pages on each side (endpoint)
	}
}

// Hook into FacetWP refresh event (when results change)
jQuery(document).on('facetwp-refresh', function () {
	if (FWP.soft_refresh == true) {
		FWP.enable_scroll = true; // Enable scroll-to-top on soft refresh
	} else {
		FWP.enable_scroll = false; // Disable scroll-to-top on hard refresh
	}
	is_responsive_pagination(); // Update pagination
});