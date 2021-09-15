<?php
/*Plugin Name: bS5 Dark Mode
Plugin URI: https://bootscore.me/plugins/dark-mode/
Description: This plugin adds a dark mode to bootScore 5 theme. Use shortcode [bs-dark-mode] to show the switch where you want.
Version: 5.0.1.2
Author: Bastian Kreiter
Author URI: https://crftwrk.de
License: GPLv2
*/


// Register Styles and Scripts
function dm_scripts() {
    
    wp_enqueue_script( 'darkmode-js', plugins_url( '/js/dark-mode.js' , __FILE__ ), array( 'jquery' ), '1.0', true );

    wp_register_style( 'switch', plugins_url('css/switch.css', __FILE__) );
        wp_enqueue_style( 'switch' );
    
    
    wp_register_style( 'dark-theme', plugins_url('css/dark-theme.css', __FILE__) );
        wp_enqueue_style( 'dark-theme' );
        
        }
    
add_action('wp_enqueue_scripts','dm_scripts');
// Register Styles and Scripts End


// Keep dark-mode cookie on page reload
function bs_dark_mode($classes) {
    $yonkov_night_mode = isset($_COOKIE['bS-Dark-Mode']) ? $_COOKIE['bS-Dark-Mode'] : '';
    //if the cookie is stored..
    if ($yonkov_night_mode !== '') {
        // Add 'dark-theme' body class
        return array_merge($classes, array('dark-theme'));
    }
    return $classes;
}
add_filter('body_class', 'bs_dark_mode');
// Keep dark-mode cookie on page reload End



// Add Shortcode to show the switch
function dark_mode_shortcode() {
    ob_start();
    ?>

<div class="dark-mode-switch">

    <div class="form-check form-switch">
        <input class="form-check-input btn-toggle position-relative" type="checkbox" id="dark-mode">
        <label class="form-check-label" for="dark-mode"></label>
    </div>

</div>



<?php
    return ob_get_clean();
}
add_shortcode( 'bs-dark-mode', 'dark_mode_shortcode' );
// Add Shortcode to show the switch End
