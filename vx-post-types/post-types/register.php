<?php
function vx_register_virtual_type() {

    $labels = array(
        'name' => __( 'Virtual Experiences', VXDOMAIN ),
        'singular_name' => __( 'Virtual Experience', VXDOMAIN ),
        'featured_image' => __( 'Featured Image', VXDOMAIN ),
        'set_featured_image' => __( 'Set Featured Image', VXDOMAIN ),
        'remove_featured_image' => __( 'Remove Featured Image', VXDOMAIN ),
        'use_featured_image' => __( 'Use Featured Image', VXDOMAIN ),
        'archives' => __( 'Resources for Virtual Events', VXDOMAIN ),
        'add_new' => __( 'Add New Resource', VXDOMAIN ),
        'add_new_item' => __( 'Add New Resource', VXDOMAIN ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => 'virtual-resources',
        'rewrite' => array('has_front' => true),
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'post-formats'),
        'show_in_rest' => true,
    );

    register_post_type( 'virtual', $args );
}

add_action( 'pre_get_posts', 'vx_archive_random' );
/**
 * Set Random order for entries on Virtual archive page
 *
 * @author Bill Erickson
 * @author Ann Newcomer
 * @param object $query data
 *
 */

// ordering the virtual posts randomly and setting 18 per page
function vx_archive_random( $query ) {

	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'virtual' ) ) {
		$query->set( 'orderby', 'rand' );
		$query->set( 'posts_per_page', 18);
	}

}