<?php

/**
 * Plugin Name:       Virtual Experiences & COVID Resources Content
 * Plugin URI:        https://github.com/a-newcomer
 * Description:       A new set of pages to keep & organise virtual speaking articles and video and more on how to thrive with social distancing.
 * Version:           1.0.0
 * Author:            Ann Newcomer
 * Author URI:        https:/annssite.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vx-post-types
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'VX_VERSION', '1.0.0' );
define( 'VXDOMAIN', 'vx-post-types' );
define( 'VXPATH', plugin_dir_path( __FILE__ ) );

require_once( VXPATH . '/post-types/register.php');
add_action( 'init', 'vx_register_virtual_type' );

require_once( VXPATH . '/taxonomies/register.php');
add_action('init', 'vx_register_virtual_taxonomy');

// add post-formats to this 'virtual' post-type
add_post_type_support( 'virtual', 'post-formats' );

function add_vx_stylesheet() {
	wp_register_style('vx-styles', plugins_url('/vx-post-types/vx-styles/vx-styles.css') );
	wp_enqueue_style('vx-styles');
}
add_action('wp_enqueue_scripts', 'add_vx_stylesheet');
