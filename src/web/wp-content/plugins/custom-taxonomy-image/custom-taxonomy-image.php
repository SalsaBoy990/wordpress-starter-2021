<?php
/**
 * Plugin Name: Custom Category and Taxonomy Image
 * Plugin URI: https://andrasgulacsi.hu
 * Description: Category and Taxonomy Image Plugin allow you to add image with category/taxonomy. With REST API endpoint to get image from options table for Gutenberg editor usage.
 * Version: 1.0.0
 * Author: András Gulácsi
 * Author URI: https://andrasgulacsi.hu
 * License: GPLv2
 * Text Domain: custom-taxonomy-image
 * Domain Path: /lang
 */

 // Exit if accessed directly
if (!defined('ABSPATH')) exit;

// require all requires once
require_once __DIR__ . '/requires.php';

use Guland\CustomTaxonomyImage\CustomTaxonomyImage as CustomTaxonomyImage;

add_action('plugins_loaded', 'customTaxonomyImageInit', 0);
if (!function_exists('customTaxonomyImageInit')) {
  function customTaxonomyImageInit(): void
  {
    // instantiate main plugin singleton class
    CustomTaxonomyImage::getInstance();
  }
}
