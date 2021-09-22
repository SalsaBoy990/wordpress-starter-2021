<?php

/**
 * Plugin Name: VueCommerce
 * Plugin URI: https://andrasgulacsi.hu
 * Description: Custom Gutenberg blocks that use VueJS on the frontend and making requests throught the Woocommerce REST API v3
 * Version: 1.0.0
 * Author: SalsaBoy990
 * Author URI: https://andrasgulacsi.hu
 * License: LGPL 3.0
 * Text Domain: vuecommerce-blocks
 * Domain Path: /lang
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// require all requires once
require_once __DIR__ . '/requires.php';

use Guland\VueCommerceBlocks\VueCommerceBlocks as VueCommerceBlocks;

add_action('plugins_loaded', 'vueCommerceBlocksInit', 0);
if (!function_exists('vueCommerceBlocksInit')) {
  function vueCommerceBlocksInit(): void
  {
    // instantiate main plugin singleton class
    VueCommerceBlocks::getInstance();
  }
}
