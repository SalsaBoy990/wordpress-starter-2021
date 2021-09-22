<?php

namespace Guland\CustomTaxonomyImage;

use Guland\CustomTaxonomyImage\API\Route as Route;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


/**
 * Implements custom images for taxomonies
 */
final class CustomTaxonomyImage
{
  use Route;

  private const TEXT_DOMAIN = 'custom-taxonomy-image';

  // class instance
  private static $instance;

  public $options;
  public $taxonomyList;

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

    $this->options = get_option('aft_options');

    // to which taxonomies should we apply taxonomy images
    if ($this->options) {
      $this->taxonomyList = $this->options['checked_taxonomies'];
    }

    if ($this->taxonomyList && !empty($this->taxonomyList)) {

      // Add actions for add and edit forms for each taxonomy type checked by the user
      foreach ($this->taxonomyList as $tax) {
        add_action($tax . '_add_form_fields', array($this, 'addCategoryImage'));
        add_action($tax . '_edit_form_fields', array($this, 'editCategoryImage'));
      }
    }

    // edit_$taxonomy
    add_action('edit_term', array($this, 'categoryImageSave'));
    add_action('create_term', array($this, 'categoryImageSave'));


    // New menu submenu for plugin options in Settings menu
    add_action('admin_menu', array($this, 'optionsMenu'));

    // Add REST API route to GET the taxonomy image by from options table (safety measures applied!)
    add_action( 'rest_api_init', array($this, 'getTaxonomyImageRoute'));
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


  // Function to add category/taxonomy image
  public function addCategoryImage($taxonomy)
  { ?>
    <div class="form-field">
      <label for="tag-image"><?php _e('Image', SELF::TEXT_DOMAIN); ?></label>
      <input type="text" name="tag-image" id="tag-image" value="" />
      <p class="description"><?php _e('Click on the text box to add taxonomy/category image.', SELF::TEXT_DOMAIN); ?></p>
    </div>

  <?php $this->addScriptsStyles();
  }


  // Function to edit category/taxonomy image
  public function editCategoryImage($taxonomy)
  { ?>
    <tr class="form-field">
      <th scope="row" valign="top"><label for="tag-image"><?php _e('Image', SELF::TEXT_DOMAIN); ?></label></th>
      <td>
        <?php
        if (get_option('_category_image-' . $taxonomy->term_id) != '') { ?>
          <img src="<?php echo get_option('_category_image-' . $taxonomy->term_id); ?>" width="100" height="100" />
        <?php
        }
        ?><br />
        <input type="text" name="tag-image" id="tag-image" value="<?php echo get_option('_category_image-' . $taxonomy->term_id); ?>" />
        <p class="description"><?php _e('Click on the text box to add taxonomy/category image.', SELF::TEXT_DOMAIN); ?></p>
      </td>
    </tr>
  <?php $this->addScriptsStyles();
  }



  public function addScriptsStyles()
  { ?>

    <script type="text/javascript" src="<?php echo plugins_url(); ?>/wp-custom-taxonomy-image/includes/thickbox.js"></script>
    <link rel='stylesheet' id='thickbox-css' href='<?php echo includes_url(); ?>js/thickbox/thickbox.css' type='text/css' media='all' />
    <script type="text/javascript">
      jQuery(document).ready(function() {
        var fileInput = '';
        jQuery('#tag-image').on('click', null,
          function() {
            fileInput = jQuery('#tag-image');
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            return false;
          });
        window.original_send_to_editor = window.send_to_editor;
        window.send_to_editor = function(html) {
          if (fileInput) {
            fileurl = jQuery('img', html).attr('src');
            if (!fileurl) {
              fileurl = jQuery(html).attr('src');
            }
            jQuery(fileInput).val(fileurl);

            tb_remove();
          } else {
            window.original_send_to_editor(html);
          }
        };
      });
    </script>
    <?php }



  public function categoryImageSave($term_id)
  {
    if (isset($_POST['tag-image'])) {
      if (isset($_POST['tag-image']))
        update_option('_category_image-' . $term_id, $_POST['tag-image']);
    }
  }



  /**
   * Add options submenu
   * @return [type]
   */
  public function optionsMenu()
  {
    add_options_page(
      __('Taxonomy Image settings', SELF::TEXT_DOMAIN),
      __('Taxonomy Image', SELF::TEXT_DOMAIN),
      'manage_options',
      'aft-options',
      array($this, 'options')
    );
    add_action('admin_init', array($this, 'registerSettings'));
  }

  // Register plugin settings
  public function registerSettings()
  {
    register_setting('aft_options', 'aft_options', array($this, 'optionsValidate'));
    add_settings_section(
      'aft_settings',
      __('Taxonomy Image settings', SELF::TEXT_DOMAIN),
      array($this, 'sectionText'),
      'aft-options'
    );
    add_settings_field(
      'aft_checked_taxonomies',
      __('Taxonomy Image settings', SELF::TEXT_DOMAIN),
      array($this, 'checkedTaxonomies'),
      'aft-options',
      'aft_settings'
    );
  }

  // Settings section description
  public function sectionText()
  {
    echo '<p>' .
      __('Please select the taxonomies you want to include it in WP Custom Taxonomy Image')
      . '</p>';
  }


  // Included taxonomies checkboxs
  public function checkedTaxonomies()
  {
    $options = get_option('aft_options');

    $disabled_taxonomies = array('nav_menu', 'link_category', 'post_format');
    foreach (get_taxonomies() as $tax) : if (in_array($tax, $disabled_taxonomies)) continue; ?>
      <input type="checkbox" name="aft_options[checked_taxonomies][<?php echo $tax ?>]" value="<?php echo $tax ?>" <?php checked(isset($options['checked_taxonomies'][$tax])); ?> /> <?php echo $tax; ?><br />
    <?php endforeach;
  }



  // Validating options
  public function optionsValidate($input)
  {
    return $input;
  }


  // Plugin option page
  public function options()
  {
    if (!current_user_can('manage_options'))
      wp_die('You do not have sufficient permissions to access this page.');
    $options = get_option('aft_options');
    ?>
    <div class="wrap">

      <h2><?php _e('Taxonomy Image', SELF::TEXT_DOMAIN); ?></h2>
      <form method="post" action="options.php">
        <?php settings_fields('aft_options'); ?>
        <?php do_settings_sections('aft-options'); ?>
        <?php submit_button(); ?>
      </form>
    </div>
<?php
  }


  // get taxonomy/category image
  public function getWPTermImage($term_id)
  {
    return get_option('_category_image-' . $term_id);
  }
}
