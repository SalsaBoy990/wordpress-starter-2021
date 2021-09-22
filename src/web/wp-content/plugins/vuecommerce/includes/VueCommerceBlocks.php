<?php

namespace Guland\VueCommerceBlocks;

use Guland\VueCommerceBlocks\Utils\Utils as Utils;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


/**
 * Implements custom Gutenberg blocks for Wordpress (Core) and Woocommerce
 */
final class VueCommerceBlocks
{
  use Utils;

  private const TEXT_DOMAIN = 'vuecommerce-blocks';

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

    add_action('wp_enqueue_scripts', array($this, 'addVueScripts'));

    //Add shortcode to WordPress
    add_shortcode('vuecommerce_filter_products', array($this, 'vuecommerceFilterProducts'));

    // Extend REST API for additional post meta
    add_action( 'rest_api_init', array($this,'extendPostsApiResponse') );
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



  public function addVueScripts()
  {
    if (is_page_template('page-vue.php')) {
      wp_enqueue_script('vuecommerce-js-chunk-vendors', 'http://localhost:8080/js/chunk-vendors.js', [], false, true);

      // register the Vue build script
      wp_register_script('vuecommerce-js-app', 'http://localhost:8080/js/app.js', [], false, true);

      // make custom data available to the Vue app with wp_localize_script.
      global $post;

      $postCategories = get_terms(array(
            'taxonomy' => 'category', // default post categories.
            'hide_empty' => true,
            'fields' => 'all',
      ));

      // get category image from options
      $postCategoryImages = [];
      $categoryImageOptionNamePrefix = '_category_image-';
      foreach($postCategories as $category) {
        $image = get_option($categoryImageOptionNamePrefix . $category->term_id);
        // only if there is an image attached to the category
        if ($image) {

          // the category's term_id as key is needed for identification
          $postCategoryImages[$category->term_id] = $image;
        }
      }


      wp_localize_script(
        'vuecommerce-js-app', // vue script handle defined in wp_register_script.
        'wpData', // js object that will made availabe to Vue.
        array( // wordpress data to be made available to the Vue app in 'wpData'
          'plugin_directory_uri' => plugin_dir_path(dirname(__FILE__, 2)), // plugin directory path.
          'rest_url' => untrailingslashit(esc_url_raw(rest_url())), // URL to the REST endpoint.
          'app_path' => $post->post_name, // page where the custom page template is loaded.
          'post_categories' => $postCategories,
          'post_category_images' => $postCategoryImages
        )
      );

      // enqueue the Vue app script with localized data.
      wp_enqueue_script('vuecommerce-js-app');
    }
  }


  // Add shortscode
  public function vuecommerceFilterProducts()
  {
    // Vue code here will goe here on the frontend
    $appContainer = '<div id="vuecommerce-filter-products"></div>';

    return $appContainer;
  }
}
