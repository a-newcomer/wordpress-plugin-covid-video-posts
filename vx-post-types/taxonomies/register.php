<?php

function vx_register_virtual_taxonomy() {
    
    $labels = array(
        'name' => __( 'Virtual Categories', VXDOMAIN ),
        'singular_name' => __( 'Virtual Category', VXDOMAIN ),
        'add_new_item' => __('Add New Virtual Category', VXDOMAIN),
    );

    $args = array(
        'hierarchical'      => true,
        'rewrite'           => array('heirarchical' => true, 'has_front' => true),
        'labels'            => $labels,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_quick_edit' => true,
        'show_in_rest'      => true,
    );

    $post_types = array( 'virtual' );

    register_taxonomy('virtual_category', $post_types, $args);
}
