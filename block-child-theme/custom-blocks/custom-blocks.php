<?php
/**
 * Custom Blocks Registration
 *
 * Registers every custom block that has been compiled into /build/blocks/.
 * When you create a new block, just add its folder under src/blocks/ and
 * run `npm run build`. No changes needed in this file — the glob loop picks
 * it up automatically.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'block_child_register_custom_blocks' );
function block_child_register_custom_blocks() {

    $blocks_dir = BLOCK_CHILD_DIR . '/build/blocks/';

    if ( ! is_dir( $blocks_dir ) ) {
        return;
    }

    // Each subfolder in /build/blocks/ is one block (contains block.json).
    foreach ( glob( $blocks_dir . '*', GLOB_ONLYDIR ) as $block_path ) {
        if ( file_exists( $block_path . '/block.json' ) ) {
            register_block_type( $block_path );
        }
    }
}
