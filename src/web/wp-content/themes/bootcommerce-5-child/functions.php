<?php

// style and scripts
add_action('wp_enqueue_scripts', 'bootscore_5_child_enqueue_styles');
function bootscore_5_child_enqueue_styles()
{

    // style.css
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // custom.js
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/js/custom.js', false, '', true);
}

// WooCommerce
require get_template_directory() . '/woocommerce/woocommerce-functions.php';


// Dequeue parent bootstrap.min.css and enqueue child
function bootscore_remove_scripts()
{

    // Dequeue parent bootstrap.min.css
    wp_dequeue_style('bootstrap');
    wp_deregister_style('bootstrap');

    // Register your child bootstrap.min.css
    wp_enqueue_style('child-theme-bootstrap', get_stylesheet_directory_uri() . '/css/lib/bootstrap.min.css', array('parent-style'));
}
add_action('wp_enqueue_scripts', 'bootscore_remove_scripts', 20);


add_action('admin_enqueue_scripts', 'bootscore_admin_enqueue_bs5');

function bootscore_admin_enqueue_bs5() {
    // Register your child bootstrap.min.css
    wp_enqueue_style('child-theme-admin-bootstrap', get_stylesheet_directory_uri() . '/css/lib/bootstrap.min.css', array('parent-style'));
}
