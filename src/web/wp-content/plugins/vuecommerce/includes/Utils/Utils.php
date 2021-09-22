<?php

namespace Guland\VueCommerceBlocks\Utils;

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

trait Utils
{

  /**
   * Register custom fields for GET requests. Extend WP REST API
   *
   * Ref: https://developer.wordpress.org/reference/functions/register_rest_field/
   */
  public function extendPostsApiResponse()
  {

    register_rest_field(
      array('post'), // The post type.
      'vue_meta', // The name of the new key.
      array(
        'get_callback' => array($this, 'getPostMetaFields'),
        'update_callback' => null,
        'schema' => null,
      )
    );
  }

  /**
   * GET callback for the "vue_meta" field defined above.
   *
   * @param array $post_object Details of the current post.
   * @param string $field_name Field Name set in register_rest_field().
   * @param WP_REST_Request $request Current request.
   *
   * @return mixed
   */
  public function getPostMetaFields(array $post_object, string $field_name, \WP_REST_Request $request)
  {

    // make additional fields available in the response using an associative array.
    $additionalPostData = array();
    $termIds = array();
    $termNames = array();
    $termLinks = array();

    $postId = $post_object['id']; // get the post id.
    $postCategories = get_the_category($postId);


    foreach ($postCategories as $categoryId) {
      $termData = get_category($categoryId);
      $termName = $termData->category_nicename;
      $termUrl = get_term_link($termData->term_id, $termData->taxonomy);
      $termLink = '<a href="' . $termUrl . '">' . $termName . '</a>';

      array_push($termIds, $termData->term_id);
      array_push($termNames, $termData->name);
      array_push($termLinks, $termLink);
    }

    // add categories, custom excerpt, featured image to the api response.
    $imgId  = get_post_thumbnail_id($postId);
    $imgAlt = get_post_meta($imgId, '_wp_attachment_image_alt', true);
    $additionalPostData = array(
      'custom_excerpt' => wp_trim_words(
        $post_object['excerpt']['rendered'],
        25,
        ' &hellip;'
      ),
      'term_ids' => $termIds,
      'term_names' => $termNames,
      'term_links' => $termLinks,
      'featuredmedia_alt' => get_post_meta(
        $imgId,
        '_wp_attachment_image_alt',
        true
      ),
      'featuredmedia_url' => get_the_post_thumbnail_url(
        $postId,
        'full'
      ),
    );

    // return data to the get_callback.
    // this data will be made available in the key "vue_meta".
    return $additionalPostData;
  }
}
