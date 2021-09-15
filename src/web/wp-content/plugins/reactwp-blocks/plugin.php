<?php

/**
 * Plugin Name: ReactWP Blocks
 * Plugin URI: https://andrasgulacsi.hu
 * Description: Custom Gutenberg blocks for wordpress and woocommerce
 * Version: 1.0.0
 * Author: SalsaBoy990
 * Author URI: https://andrasgulacsi.hu
 * License: LGPL 3.0
 * Text Domain: reactwp-blocks
 * Domain Path: /lang
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// require all requires once
require_once __DIR__ . '/requires.php';

use Guland\ReactWPBlocks\ReactWPBlocks as ReactWPBlocks;

add_action('plugins_loaded', 'reactwpBlocksInit', 0);
if (!function_exists('reactwpBlocksInit')) {
  function reactwpBlocksInit(): void
  {
    // instantiate main plugin singleton class
    ReactWPBlocks::getInstance();
  }
}
