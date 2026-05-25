<?php
/**
 * Block Theme Child — functions.php
 *
 * Entry point and asset loader.
 * All other feature modules live in /inc and are loaded at the bottom.
 *
 * ⚡ Starting a new project?
 *    Global find-and-replace:  block-child-textdomain  →  your-project-slug
 *    Also update BLOCK_CHILD_ constants prefix and style.css Theme Name.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// =============================================================================
// Constants
// =============================================================================

define( 'BLOCK_CHILD_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'BLOCK_CHILD_DIR',     get_stylesheet_directory() );
define( 'BLOCK_CHILD_URI',     get_stylesheet_directory_uri() );

// =============================================================================
// Theme Setup
// =============================================================================

add_action( 'after_setup_theme', 'block_child_theme_setup' );

function block_child_theme_setup() {
    load_child_theme_textdomain(
        'block-child-textdomain',
        BLOCK_CHILD_DIR . '/languages'
    );
}

// =============================================================================
// Front-end Assets
// =============================================================================

add_action( 'wp_enqueue_scripts', 'block_child_enqueue_assets' );

function block_child_enqueue_assets() {

    wp_enqueue_style(
        'block-child-site-style',
        BLOCK_CHILD_URI . '/site-scripts/site-style.css',
        array(),
        BLOCK_CHILD_VERSION
    );

    wp_enqueue_style(
        'block-child-core-controls',
        BLOCK_CHILD_URI . '/site-scripts/core-blocks-controls.css',
        array(),
        BLOCK_CHILD_VERSION
    );

    wp_enqueue_script(
        'block-child-site-script',
        BLOCK_CHILD_URI . '/core-blocks-options/site-script.js',
        array(),
        BLOCK_CHILD_VERSION,
        true
    );
}

// =============================================================================
// Editor Assets
// =============================================================================

add_action( 'enqueue_block_editor_assets', 'block_child_editor_assets' );

function block_child_editor_assets() {

    wp_enqueue_style(
        'block-child-site-editor-style',
        BLOCK_CHILD_URI . '/site-scripts/site-editor-style.css',
        array(),
        BLOCK_CHILD_VERSION
    );

    wp_enqueue_script(
        'block-child-core-controls',
        BLOCK_CHILD_URI . '/site-scripts/core-blocks-controls.js',
        array( 'wp-hooks', 'wp-compose', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element' ),
        BLOCK_CHILD_VERSION,
        true
    );
}

// =============================================================================
// External Libraries
// =============================================================================

add_action( 'wp_enqueue_scripts', 'block_child_enqueue_libraries' );

function block_child_enqueue_libraries() {

    wp_enqueue_style(
        'swiper-css',
        BLOCK_CHILD_URI . '/external-libraries/swiper/swiper-bundle.min.css',
        array(),
        '11.2.6'  // pin the library version, not BLOCK_CHILD_VERSION
    );

    wp_enqueue_script(
        'swiper-js',
        BLOCK_CHILD_URI . '/external-libraries/swiper/swiper-bundle.min.js',
        array(),
        '11.2.6',
        true
    );
}

// =============================================================================
// Modules
// =============================================================================

require_once BLOCK_CHILD_DIR . '/includes/hooks.php';
require_once BLOCK_CHILD_DIR . '/includes/shortcode.php';
require_once BLOCK_CHILD_DIR . '/includes/general-functions.php';
require_once BLOCK_CHILD_DIR . '/custom-blocks/custom-blocks.php';
require_once BLOCK_CHILD_DIR . '/core-blocks-options/core-blocks-style-options.php';