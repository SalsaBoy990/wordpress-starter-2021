<?php

namespace Guland\CustomTaxonomyImage\API;

use WP_REST_Response;

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

trait Route
{
  public function getTaxonomyImageRoute()
  {
    register_rest_route(
      'wp-custom-taxonomy-image/v1',
      '/image/',
      array(
        'methods' => \WP_REST_Server::READABLE,
        'callback' => array($this, 'getRestOption'),
        'permission_callback' => array($this, 'permissionsCheck')
      )
    );
  }

  //?option_name=siteurl

  public function permissionsCheck()
  {
    if (!current_user_can('edit_posts')) {
      return new \WP_Error(
        'rest_unauthorized',
        esc_html__('Unauthorized.', GULAND_WP_CUSTOM_TAXONOMY_IMAGE_TEXT_DOMAIN),
        array('status' => 401)
      );
    }
    // OK
    return true;
  }

  /**
   * @param mixed $data
   * 
   * @return string
   */
  public function getRestOption(\WP_REST_Request $request): WP_REST_Response
  {
    // category image option_name have this format: '_category_image-CATEGORY_ID'
    $optionName = $request->get_param('option_name');

    // Bad request error response
    if ($optionName == '') {
      return new \WP_REST_Response(
        array(
          'status' => 400,
          'message' => 'rest_bad_request',
          'description' =>  __('Missing parameter \'option_name\'', GULAND_WP_CUSTOM_TAXONOMY_IMAGE_TEXT_DOMAIN),
          'image_url' => null
        ),
        400
      );
    }

    $optionNameExploded = explode('-', $optionName);
    $optionNamePrefixWithoutId = '';
    if ($optionNameExploded) {
      $optionNamePrefixWithoutId  = $optionNameExploded[0];
    }

    // Option OK response
    if ($optionNamePrefixWithoutId === '_category_image') {

      $opt = get_option($optionName);

      if ($opt) {
        return new \WP_REST_Response(
          array(
            'status' => 200,
            'message' => 'OK',
            'description' => __('Taxonomy image url returned successfully', GULAND_WP_CUSTOM_TAXONOMY_IMAGE_TEXT_DOMAIN),
            'image_url' => $opt
          ),
          200
        );
      } else {
        return new \WP_REST_Response(
          array(
            'status' => 404,
            'message' => 'rest_not_found',
            'description' => __('Option not found.', GULAND_WP_CUSTOM_TAXONOMY_IMAGE_TEXT_DOMAIN),
            'image_url' => null
          ),
          404
        );
      }
    } else {
      // Forbidden error response
      return new \WP_REST_Response(
        array(
          'status' => 403,
          'message' => 'rest_forbidden',
          'description' => __('Forbidden. Only taxonomy image options can be accessed through this route', GULAND_WP_CUSTOM_TAXONOMY_IMAGE_TEXT_DOMAIN),
          'image_url' => null
        ),
        403
      );
    }
  }
}
