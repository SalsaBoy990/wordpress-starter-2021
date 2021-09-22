<?php

namespace Guland\ReactWPBlocks\Core;

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

trait Core
{

  // get taxonomy/category image
  public function getWPTermImage($term_id)
  {
    return get_option('_category_image-' . $term_id);
  }

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
    $args['cat'] = $attributes['postCategory'];

    $category = get_term_by('id', $args['cat'], 'category');
    $categoryName = $category->name;
    $categoryDescription = $category->description;
    $categorySlug = $category->slug;
    $categoryImageUrl = '';


    // category image url
    $categoryImageUrl = $this->getWPTermImage($args['cat']);
    
    $query = new \WP_Query($args);
    $html = '';

    if ($query->have_posts()) {
      $html .= '<div class="wp-block-reactwp-blocks-latest-posts col">';
      $html .= '<div class="card">';

      if ($categoryImageUrl && $categoryName) {
        $html .= '<img src="' . esc_url($categoryImageUrl) . '" class="card-img card-img-darken" alt="' . esc_html($categoryName) . '">';
      }

      if ($categoryName) {
        $html .= '<a href="' . '/category/' . $categorySlug . '">';
        $html .= '<div class="card-img-overlay card-img-overlay-height d-flex flex-column align-items-center justify-content-center p-3 text-center">';
        $html .= '<h3 class="card-title text-white">' . $categoryName . '</h3>';

        if ($categoryDescription) {
          $html .= '<p class="card-text text-light">' . $categoryDescription . '</p>';
        }
        $html .= '</div>';
        $html .= '</a>';
      }


      $html .= '<div class="card-header"><b>' . __('New articles', GULAND_REACTWP_BLOCKS_TEXT_DOMAIN) . '</b></div>';
      $html .= '<ul class="list-group list-group-flush">';

      while ($query->have_posts()) {
        $query->the_post();
        $html .= '<li class="list-group-item">';
        $html .= '<a href="' . esc_url(get_the_permalink()) . '" >' . esc_html(get_the_title())  . '</a>';
        $html .= '</li>';
      }
      $html .= '</ul>';
      $html .= '</div>';
      $html .= '</div>';

      wp_reset_postdata();
      return $html;
    } else {
      return '<div>' . __('No Post Found', GULAND_REACTWP_BLOCKS_TEXT_DOMAIN) . '</div>';
    }

    return $html;
  }
}
