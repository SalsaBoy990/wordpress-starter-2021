<?php

namespace Guland\VueCommerceBlocks\WooCommerce;

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

trait WooCommerce
{

  /**
   * Renders latest Woocommerce products card grid block using bs5
   * 
   * @param array $attributes
   * 
   * @return string|null
   */
  public function renderFilterProductsBlock(array $attributes): string
  {
    $args = array(
      'limit' => $attributes['limit']
    );

    if ($attributes['productCategorySlug']) {
      $args['category'] = $attributes['productCategorySlug'];
    }
    $args['orderby'] = 'date';
    $args['order'] = $attributes['newestFirst'] ? 'DESC' : 'ASC';
    $args['stock_status'] = 'instock';
    $args['return'] = 'ids';

    if (!function_exists('wc_get_products')) {
      return null;
    }

    if ($attributes['productCategorySlug']) {
      $category = get_term_by('slug', $attributes['productCategorySlug'], 'product_cat');
      $categoryName = $category->name;
    }

    $query = new \WC_Product_Query($args);
    $html = '';
    $products = $query->get_products();


    if ($products && count($products) >= 1) {
      return $this->getProductList($products, isset($categoryName) ? $categoryName : __('Choose a category - its name will appear here...', GULAND_REACTWP_BLOCKS_TEXT_DOMAIN));
    } else {
      return '<div class="wp-block-vuecommerce-blocks-latest-products row"><p>' . __('No Products Found', GULAND_REACTWP_BLOCKS_TEXT_DOMAIN) . '</p></div>';
    }

    return $html;
  }


  /**
   * @param array $products
   * 
   * @return string
   */
  public function getProductList(array $products, string $title = ''): string
  {
    $html = '';
    // parent div
    if ($title) {
      $html .= '<h2 class="mb-1 mt-5">' . $title . '</h2>';
    }
    $html .= '<div class="wp-block-vuecommerce-blocks-latest-products row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-4 g-4">';

    foreach ($products as $product) {
      global $post;
      $product = wc_get_product($product);

      // Ensure visibility.
      if (empty($product) || !$product->is_visible()) {
        continue;
      }

      $html .= '<div class="col">';
      $html .= '<div class="card h-100 d-flex text-center">';

      // add link to single product
      $html .= '<a href="' . $product->get_permalink() . '" class="woocommerce-LoopProduct-link">';

      // show discount
      if ($product->is_on_sale()) {
        $html .= apply_filters('woocommerce_sale_flash', '<span class="badge bg-danger sale">%</span>', $post, $product);
      }

      // show product image
      $html .= $product->get_image('woocommerce_thumbnail', array('class' => 'card-img-top'));
      $html .= '</a>';
      $html .= '<div class="card-body d-flex flex-column">';
      $html .= '<a href="' . $product->get_permalink() . '" class="woocommerce-LoopProduct-link">';

      // show product title
      $html .= '<h3 class="card-title product_title entry-title">' . $product->get_title() . '</h3>';

      // show ratings
      if (wc_review_ratings_enabled()) {
        $html .= wc_get_rating_html($product->get_average_rating()); // WordPress.XSS.EscapeOutput.OutputNotEscaped.
      }

      // show price
      $html .= '<p class="price mb-3">' . $product->get_price_html() . '</p>';

      // show short description
      $short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);
      if ($short_description) {
        $html .= '<div class="woocommerce-product-details__short-description card-text">' . $short_description . '</div>'; // WPCS: XSS ok.
      }
      $html .= '</a>';

      // add to cart btn
      $html .= '<div class="add-to-cart-container mt-auto">' . $this->getAddToCartButton($product) . '</div>';
      $html .= '</div>'; // .card-body
      $html .= '</div>'; // .card
      $html .= '</div>'; // .col

    }
    wp_reset_postdata();

    $html .= '</div>';
    return $html;
  }


  /**
   * Get the "add to cart" button.
   *
   * @param \WC_Product $product Product.
   * @return string Rendered product output.
   */
  public function getAddToCartButton($product)
  {
    $attributes = array(
      'aria-label'       => $product->add_to_cart_description(),
      'data-quantity'    => '1',
      'data-product_id'  => $product->get_id(),
      'data-product_sku' => $product->get_sku(),
      'rel'              => 'nofollow',
      'class'            => 'wp-block-button__link add_to_cart_button btn btn-primary',
    );

    if (
      $product->supports('ajax_add_to_cart') &&
      $product->is_purchasable() &&
      ($product->is_in_stock() || $product->backorders_allowed())
    ) {
      $attributes['class'] .= ' ajax_add_to_cart single_add_to_cart_button';
    }

    return sprintf(
      '<a href="%s" %s>%s</a>',
      esc_url($product->add_to_cart_url()),
      wc_implode_html_attributes($attributes),
      esc_html($product->add_to_cart_text())
    );
  }
}
