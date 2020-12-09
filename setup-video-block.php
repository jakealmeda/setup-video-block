<?php
/**
 * Plugin Name: Setup Video Block
 * Description: Display custom Guttenburg video block via Advanced Custom Fields.
 * Version: 1.0.3
 * Author: Jake Almeda & Mark Corpuz
 * Author URI: https://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


include 'setup-video-functions.php';


/**
 * Add a block category for "Setup" if it doesn't exist already.
 *
 * @param array $categories Array of block categories.
 *
 * @return array
 */
function setup_block_categories_fn( $categories ) {

    $category_slugs = wp_list_pluck( $categories, 'slug' );

    return in_array( 'setup', $category_slugs, true ) ? $categories : array_merge(
        $categories,
        array(
            array(
                'slug'  => 'setup',
                'title' => __( 'Setup', 'mydomain' ),
                'icon'  => null,
            ),
        )
    );

}
add_filter( 'block_categories', 'setup_block_categories_fn' );


/**
 * VIDEO (Custom Blocks)
 * 
 */
add_action( 'acf/init', 'setup_video_block_fn' );
function setup_video_block_fn() {

    $blocks = array(
        
        's_videos' => array(
            'name'                  => 'setup_video',
            'title'                 => __('Video'),
            'render_template'       => plugin_dir_path( __FILE__ ).'custom_blocks/setup_video_template.php',
            'category'              => 'setup',
            'icon'                  => 'list-view',
            'mode'                  => 'edit',
            'keywords'              => array( 'video', 'embed video' ),
            'supports'              => [
                'align'             => false,
                'anchor'            => true,
                'customClassName'   => true,
                'jsx'               => true,
            ],
        ),

    );

    // Bail out if function doesn’t exist or no blocks available to register.
    if ( !function_exists( 'acf_register_block_type' ) && !$blocks ) {
        return;
    }
    
    // this loop is broken, how do we register multiple blocks in one go?
    // Register all available blocks.
    $user = wp_get_current_user();

    $allowed_roles = array( 'administrator' ); // can also be array( 'editor', 'administrator', 'author' );

    //if( array_intersect( $allowed_roles, $user->roles ) ) {

        foreach( $blocks as $block ) {
            acf_register_block_type( $block );
        }

    //}
  
}