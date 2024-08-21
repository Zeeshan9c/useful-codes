<?php
/**
 * Theme functions and definitions
 *
 * @package SITE_NAME
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined('WORDPRESS_CHILD_VERSION') ) {
	define( 'WORDPRESS_CHILD_VERSION', '1.0.0' );
}
if ( ! defined('CUSTOMTHEME_TEXTDOMAIN') ) {
	define( 'CUSTOMTHEME_TEXTDOMAIN', 'site_name' );
}

if ( ! defined('WORDPRESS_CHILD_URI') ) {
	define( 'WORDPRESS_CHILD_URI', get_stylesheet_directory_uri() );
}

if ( ! defined('WORDPRESS_CHILD_DIR') ) {
	define( 'WORDPRESS_CHILD_DIR', get_stylesheet_directory() );
}

if ( ! defined('WORDPRESS_CHILD_INC_DIR') ) {
	define( 'WORDPRESS_CHILD_INC_DIR', WORDPRESS_CHILD_DIR . '/includes' );
}

if ( ! defined( 'ELEMENTOR_ASSETS_URL' ) ) {
	define( 'ELEMENTOR_ASSETS_URL', WORDPRESS_CHILD_URI . '/wp-content/plugins/elementor/assets' );
}


// Theme setup and script/style enqueue
require_once WORDPRESS_CHILD_INC_DIR . '/theme.php';

// Contains all the shortcodes
require_once WORDPRESS_CHILD_INC_DIR . '/shortcodes.php';
