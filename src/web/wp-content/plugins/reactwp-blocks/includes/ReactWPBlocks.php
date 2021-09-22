<?php

namespace Guland\ReactWPBlocks;

use Guland\ReactWPBlocks\Utils\Utils as Utils;
use Guland\ReactWPBlocks\Core\Core as Core;
use Guland\ReactWPBlocks\WooCommerce\WooCommerce as WooCommerce;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


/**
 * Implements custom Gutenberg blocks for Wordpress (Core) and Woocommerce
 */
final class ReactWPBlocks
{
  use Utils;
  use Core;
  use WooCommerce;

  private const TEXT_DOMAIN = 'reactwp-blocks';

  // class instance
  private static $instance;

  /**
   * Osztálypéldány visszaadása vagy létrehozása, ha még nem létezik
   * 
   * @return self $instance
   */
  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new self();
    }
    return self::$instance;
  }


  /**
   * @return void
   */
  private function __construct()
  {

    // load translation files
    add_action('plugins_loaded', array($this, 'loadTextdomain'));

    // Adds custom block category
    add_filter('block_categories_all', array($this, 'addCustomBlocksCategory'), 10, 2);

    // Registers all custom blocks
    add_action('init', array($this, 'registerCustomBlocks'));
  }


  /**
   * @return void
   */
  public function __destruct()
  {
  }


  /**
   * Fordítás fájlok betöltése
   * 
   * @return void
   */
  public function loadTextdomain(): void
  {
    // modified slightly from https://gist.github.com/grappler/7060277#file-plugin-name-php
    $domain = self::TEXT_DOMAIN;
    $locale = apply_filters('plugin_locale', get_locale(), $domain);

    load_textdomain($domain, trailingslashit(\WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo');
    load_plugin_textdomain($domain, false, basename(dirname(__FILE__, 2)) . '/languages/');
    load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . '/lang/');
  }


  /**
   * Adds a custom category for all created custom blocks
   * @param array $categories
   * @param mixed $post
   * 
   * @return array
   */
  public function addCustomBlocksCategory(array $categories, $post): array
  {
    return array_merge($categories, array(
      array(
        'slug' => 'reactwp-category',
        'title' => __('ReactWPBlocks', SELF::TEXT_DOMAIN),
        'icon' => 'grid-view',
      )
    ));
  }


  /**
   * Register JS, CSS bundles, dependencies, and the custom blocks
   * @return void
   */
  function registerCustomBlocks(): void
  {
    // dirname to JS and CSS files (bundled into dist/ folder with Webpack, `npm run build`)
    $dirPath = dirname(__FILE__, 1);

    // --------------------------------------------
    // Admin script bundle
    wp_register_script(
      'reactwp-blocks-editor-script',
      plugins_url('dist/editor.js', $dirPath),
      array(
        'wp-blocks',
        'wp-i18n',
        'wp-element',
        'wp-editor',
        'wp-block-editor',
        'wp-components',
        'lodash', 'wp-blob',
        'wp-data',
        'wp-html-entities',
        'wp-compose'
      )
    );

    // Frontend script bundle
    wp_register_script(
      'reactwp-blocks-script',
      plugins_url('dist/script.js', $dirPath),
      array('jquery')
    );

    // --------------------------------------------
    // Admin css bundle
    wp_register_style(
      'reactwp-blocks-editor-style',
      plugins_url('dist/editor.css', $dirPath),
      array('wp-edit-blocks')
    );

    // Frontend css bundle
    wp_register_style(
      'reactwp-blocks-style',
      plugins_url('dist/style.css', $dirPath),
      array()
    );

    // --------------------------------------------
    // REGISTER ALL CUSTOM GUTENBERG BLOCKS
    // --------------------------------------------
    $this->registerCustomBlockTypes('firstblock');
    $this->registerCustomBlockTypes('secondblock');
    $this->registerCustomBlockTypes('team-member');
    $this->registerCustomBlockTypes('team-members');
    $this->registerCustomBlockTypes('redux');

    // Dynamic Blogposts List block
    $this->registerCustomBlockTypes('latest-posts', array(
      'render_callback' => array($this, 'renderLatestPostsBlock'),
      'attributes' => array(
        'numberOfPosts' => array(
          'type' => 'number',
          'default' => 3
        ),
        'postCategory' => array(
          'type' => 'string',
          'default' => 1
        )
      )
    ));

    // Grid Container for Dynamic Blogposts List blocks
    $this->registerCustomBlockTypes('posts-grid');


    // Dynamic Woocommerce Products block
    $this->registerCustomBlockTypes('latest-products', array(
      'render_callback' => array($this, 'renderLatestProductsBlock'),
      'attributes' => array(
        'limit' => array(
          'type' => 'number',
          'default' => 6
        ),
        'productCategorySlug' => array(
          'type' => 'string',
          'default' => ''
        ),
        'newestFirst' => array(
          'type' => 'boolean',
          'default' => true
        ),
      )
    ));
  }
}
