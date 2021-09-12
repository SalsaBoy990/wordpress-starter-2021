<?php

/*
Registers the Isotope
Custom Post Type and Taxonomie
*/

 

// Isotope Custom Post Type
function setup_isotope_cpt(){
    $labels = array(
        'name' => _x('bS Isotopes', 'post type general name'),
        'singular_name' => _x('Isotope', 'post type singular name'),
        'add_new' => _x('Add New', 'isotope item'),
        'add_new_item' => __('Add New Isotope Item'),
        'edit_item' => __('Edit Isotope Item'),
        'new_item' => __('New Isotope Item'),
        'view_item' => __('View Isotope Item'),
        'search_items' => __('Search Isotope Items'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => '',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 4,
        'supports' => array('title','editor','thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-screenoptions',
        'rewrite' => array( 'slug' => 'isotope' ), // Change your Isotope slug here. Go to Backend - Settings - Permalinks and save
    ); 
    register_post_type( 'isotope' , $args );
}
add_action('init', 'setup_isotope_cpt');
// Isotope Custom Post Type End



// Isotope Taxonomie
function setup_isotope_taxonomies() {
    $labels = array(
        'name'              => _x( 'Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'categories' ),
    );

    register_taxonomy( 'isotope_category', array( 'isotope' ), $args );
}
add_action( 'init', 'setup_isotope_taxonomies', 0 );
// Isotope Taxonomie End



// Isotope Category Badge
if ( ! function_exists( 'isotope_category_badge' ) ) :
	function isotope_category_badge() {
		// Hide category and tag text for pages.
		if ( 'isotope' === get_post_type() ) {
            
            global $post;
            $terms = wp_get_post_terms($post->ID, 'isotope_category');
            if ($terms) {
                $output = array();
                echo '<div class="category-badge mb-2">';
                foreach ($terms as $term) {
                    $output[] = '<a class="badge bg-secondary text-white" href="' .get_term_link( $term->slug, 'isotope_category') .'">' .$term->name .'</a>';
                }
                echo join( ' ', $output );
                echo '</div>';
            };      
            
		}
	}
endif;
// Isotope Category Badge End



// Use Isotope Single Template
add_filter( 'single_template', 'isotope_post_type_template' );
function isotope_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'isotope' ) {
          $single_template = dirname( __FILE__ ) . '/cpt-single.php';
     }
     return $single_template;
  
}
// Use Isotope Single Template End



// Use the Isotope Archive Template
add_filter( 'archive_template', 'isotope_archive_type_template' );
function isotope_archive_type_template($archive_template) {
     global $post;

     if ($post->post_type == 'isotope' ) {
          $archive_template = dirname( __FILE__ ) . '/cpt-archive.php';
     }
     return $archive_template;
  
}
// Use Isotope Archive Template End
