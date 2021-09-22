<?php

namespace Guland\VueCommerceBlocks\Core;

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

trait Core
{

  /**
   * Renders a latest blogposts list block
   * 
   * @param array $attributes
   * 
   * @return string|null
   */
  public function renderLatestPostsBlock(array $attributes): string
  {
    $args = array(
      'post_per_page' => $attributes['numberOfPosts']
    );

    if ($attributes['postCategories']) {
      $args['cat'] = $attributes['postCategories'];
    }
    $query = new \WP_Query($args);
    $html = '';

    if ($query->have_html()) {
      $html .= '<ul class="wp-block-reactwp-blocks-latest-posts">';
      while ($query->have_html()) {
        $query->the_post();
        $html .= '<li><a href="' . esc_url(get_the_permalink()) . '" >' . esc_html(get_the_title())  . '</a></li>';
      }
      $html .= '</ul>';
      wp_reset_postdata();
      return $html;
    } else {
      return '<div>' . __('No Post Found', GULAND_REACTWP_BLOCKS_TEXT_DOMAIN) . '</div>';
    }

    return $html;
  }
}
