<?php
/*Plugin Name: bS5 Isotope
Plugin URI: https://bootscore.me/plugins/bs-isotope/
Description: This plugin adds filterable Isotope custom post types to bootScore. Use [bs-isotope-equal-height type="post" tax="category" cat_parent="CATEGORY PARENT ID"] to show the Isotope grid where you want. Check the <a href="https://bootscore.me/documentation/bs-isotope/">Documentation</a> for details.
Version: 5.0.0.3
Author: Bastian Kreiter
Author URI: https://crftwrk.de
License: MIT License
*/


// Register Styles and Scripts
function isotope_scripts() {

    wp_enqueue_script( 'isotope-js', plugins_url( '/js/jquery.isotope.min.js' , __FILE__ ), array( 'jquery' ), '1.0', true );
    
    wp_register_style( 'isotope-css', plugins_url('/css/isotope.css', __FILE__) );
        wp_enqueue_style( 'isotope-css' );
        
        }
    
add_action('wp_enqueue_scripts','isotope_scripts');

//Isotope CPT
include_once('templates/cpt-isotope.php');

/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/bs5-isotope/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/bs5-isotope/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */
function bs_isotope_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	// Set variable to search in bs5-isotope folder of theme.
	if ( ! $template_path ) :
		$template_path = 'bs5-isotope/';
	endif;

	// Set default plugin templates path.
	if ( ! $default_path ) :
		$default_path = plugin_dir_path( __FILE__ ) . 'templates/'; // Path to the template folder
	endif;

	// Search template file in theme folder.
	$template = locate_template( array(
		$template_path . $template_name,
		$template_name
	) );

	// Get plugins template file.
	if ( ! $template ) :
		$template = $default_path . $template_name;
	endif;

	return apply_filters( 'bs_isotope_locate_template', $template, $template_name, $template_path, $default_path );

}


/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see bs_isotope_locate_template()
 *
 * @param string 	$template_name			Template to load.
 * @param array 	$args					Args passed for the template file.
 * @param string 	$string $template_path	Path to templates.
 * @param string	$default_path			Default path to template files.
 */
function bs_isotope_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
	endif;

	$template_file = bs_isotope_locate_template( $template_name, $tempate_path, $default_path );

	if ( ! file_exists( $template_file ) ) :
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
		return;
	endif;

	include $template_file;

}


/**
 * Templates.
 *
 * This func tion will output the templates
 * file from the /templates.
 *
 * @since 1.0.0
 */

function bs_isotope_equal_height() {

	return bs_isotope_get_template( 'sc-equal-height.php' );

}
add_action('wp_head', 'bs_isotope_equal_height');


function bs_isotope_masonry() {

    return bs_isotope_get_template( 'sc-masonry.php' );

}
add_action('wp_head', 'bs_isotope_masonry');


function bs_isotope_equal_height_overlay() {

	return bs_isotope_get_template( 'sc-equal-height-overlay.php' );

}
add_action('wp_head', 'bs_isotope_equal_height_overlay');


function bs_isotope_masonry_overlay() {

    return bs_isotope_get_template( 'sc-masonry-overlay.php' );

}
add_action('wp_head', 'bs_isotope_masonry_overlay');


function bs_isotope_product() {

    return bs_isotope_get_template( 'sc-product.php' );

}
add_action('wp_head', 'bs_isotope_product');


/*
function bs_isotope_cpt_single() {

    return bs_isotope_get_template( 'cpt-single.php' );

}
add_action('wp_head', 'bs_isotope_cpt_single');


function bs_isotope_cpt_archive() {

    return bs_isotope_get_template( 'cpt-archive.php' );

}
add_action('wp_head', 'bs_isotope_cpt_archive');
*/


/**
 * Template loader.
 *
 * The template loader will check if WP is loading a template
 * for a specific Post Type and will try to load the template
 * from out 'templates' directory.
 *
 * @since 1.0.0
 *
 * @param	string	$template	Template file that is being loaded.
 * @return	string				Template file that should be loaded.
 */

/*
function isotope_template_loader( $template ) {

	$find = array();
	$file = '';

	if ( is_singular( 'isotope' ) ) :
		$file = 'cpt-single.php';
	elseif ( is_singular( 'page' ) ) :
		$file = 'cpt-single.php';
	endif;

	if ( file_exists( bs_isotope_locate_template( $file ) ) ) :
		$template = bs_isotope_locate_template( $file );
	endif;

	return $template;

}
add_filter( 'template_include', 'isotope_template_loader' );
*/




/*
include_once('inc/cpt-isotope.php');
include_once('inc/sc-equal-height.php');
include_once('inc/sc-equal-height-overlay.php');
include_once('inc/sc-masonry.php');
include_once('inc/sc-masonry-overlay.php');
include_once('inc/sc-product.php');

*/


/**
 * Template loader.
 *
 * The template loader will check if WP is loading a template
 * for a specific Post Type and will try to load the template
 * from out 'templates' directory.
 *
 * @since 1.0.0
 *
 * @param	string	$template	Template file that is being loaded.
 * @return	string				Template file that should be loaded.
 */

/*
function ( $template ) {

	$find = array();
	$file = '';

	if ( is_singular( 'isotope' ) ) :
		$file = 'cpt-single.php';
	//elseif ( is_singular( 'page' ) ) :
		//$file = 'cpt-single.php';
	endif;

	if ( file_exists( bs_isotope_locate_template( $file ) ) ) :
		$template = bs_isotope_locate_template( $file );
	endif;

	return $template;

}
add_filter( 'template_include', 'wcpt_template_loader' );
*/









