<?php
/**
 * Plugin Name: Custom Elementor Widgets
 * Description: Auto embed any embbedable content from external URLs into Elementor.
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Elementor Developer
 * Author URI:  https://developers.elementor.com/
 * Text Domain: elementor-custom-widgets
 *
 * Elementor tested up to: 3.7.0
 * Elementor Pro tested up to: 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Widgets.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

function enqueue_custom_elementor_widget_assets() {
	wp_enqueue_style( 'custom-elementor-widget-css', plugins_url( 'widgets-assets/css/widgets-style.css', __FILE__ ), array(), '1.0.0' );
	wp_enqueue_script( 'custom-elementor-widget-js', plugins_url( 'widgets-assets/js/widgets-scripts.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
}

function register_custom_elementor_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/card-widget.php' );
	$widgets_manager->register( new \Cards_Custom_Elementor_Widgets() );

	require_once( __DIR__ . '/widgets/image-with-text.php' );
	$widgets_manager->register( new \Image_With_Text_Custom_Elementor_Widgets() );

	require_once( __DIR__ . '/widgets/repeater-cards.php' );
	$widgets_manager->register( new \Repeater_Cards_Custom_Elementor_Widgets() );

	require_once( __DIR__ . '/widgets/testimonial-slider.php' );
	$widgets_manager->register( new \Testimonial_Slider_Custom_Elementor_Widgets() );

	require_once( __DIR__ . '/widgets/counter-progress.php' );
	$widgets_manager->register( new \circular_progress_counter_Elementor_Widgets() );

	require_once( __DIR__ . '/widgets/test.php' );
	$widgets_manager->register( new \TeachingChannel_Courses_Cards() );

}

add_action( 'elementor/widgets/register', 'register_custom_elementor_widget' );

add_action( 'elementor/frontend/after_enqueue_scripts', 'enqueue_custom_elementor_widget_assets' );
