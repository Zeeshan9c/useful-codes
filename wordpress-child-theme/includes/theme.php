<?php

/**
 * Theme setup, support and script/style enqueue
 * 
 */

if ( ! function_exists( 'wordpress_child_scripts_styles' ) ) {
	
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function wordpress_child_scripts_styles() {

		// Main Child Theme file enqueue
		wp_enqueue_style('site_name', WORDPRESS_CHILD_URI . '/style.css', [], WORDPRESS_CHILD_VERSION);

		// Enqueue swiper stylesheet
		wp_enqueue_style('site_name-main', WORDPRESS_CHILD_URI . '/assets/css/main.css', [], WORDPRESS_CHILD_VERSION);
		// Enqueue main stylesheet
		wp_enqueue_style('site_name-main', WORDPRESS_CHILD_URI . '/assets/css/swiper.css', [], WORDPRESS_CHILD_VERSION);
		// Enqueue Swiper JS
		wp_enqueue_script('swiper-js', ELEMENTOR_ASSETS_URL . 'lib/swiper/v8/swiper.min.js', ['jquery'], false, true);
		// Enqueue main JS
		wp_enqueue_script('site_name-main', WORDPRESS_CHILD_URI . '/assets/js/main.js', array( 'jquery', 'swiper-js'), WORDPRESS_CHILD_VERSION, true);

	}
}
add_action( 'wp_enqueue_scripts', 'wordpress_child_scripts_styles', 999 );

function wordpress_child_editor_assets() {
    // Enqueue styles for the editor
    wp_enqueue_style(
        'site_name-editor', WORDPRESS_CHILD_URI . '/assets/css/editor-stylesheet.css', [], WORDPRESS_CHILD_VERSION );
}
add_action('admin_init', 'wordpress_child_editor_assets');


/**
 * Register sidebars
 * 
 */
if ( ! function_exists( 'wordpress_child_widgets_init' ) ) {
	function wordpress_child_widgets_init() {
		
		// this is just a boilerplate
		/*register_sidebar( array(
			'name'          => __( 'Sidebar Name', 'site_name' ),
			'id'            => 'sidebar-id',
			'description'   => __( 'Some description', 'site_name' ),
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="heading">',
			'after_title'   => '</h2>',
		) );*/
	}
}
//add_action( 'widgets_init', 'WORDPRESS_CHILD_widgets_init' );
