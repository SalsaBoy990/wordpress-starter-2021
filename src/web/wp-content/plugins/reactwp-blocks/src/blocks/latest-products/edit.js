import { Component } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import parse from 'html-react-parser';

import {
  RangeControl,
  PanelBody,
  SelectControl,
  ToggleControl,
} from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';

import './style.editor.scss';

class LatestProductsEdit extends Component {
  state = {
    posts: [],
    categories: [],
    limit: '',
    newestFirst: '',
    productCategorySlug: 'uncategorized',
  };

  componentDidMount() {
    // get categories first in order to be able to query products by category
    this.getCategories().then((categories) => {
      this.setState({
        categories,
        limit: this.props.attributes.limit,
        newestFirst: this.props.attributes.newestFirst,
        productCategorySlug: this.props.attributes.productCategorySlug,
      });

      this.getProducts().then((posts) => {
        this.setState({
          posts,
        });
      });
    });
  }

  componentDidUpdate(prevProps, prevState) {
    if (this.state.limit !== prevState.limit) {
      this.getProducts().then((posts) => {
        this.setState({
          posts: posts,
        });
      });
    }
    if (this.state.newestFirst !== prevState.newestFirst) {
      this.getProducts().then((posts) => {
        this.setState({
          posts: posts,
        });
      });
    }
    if (this.state.productCategorySlug !== prevState.productCategorySlug) {
      this.getProducts().then((posts) => {
        this.setState({
          posts: posts,
        });
      });
    }
  }

  onChangeLimit = (limit) => {
    const newLimit = limit;
    this.props.setAttributes({ limit: newLimit });
    this.setState({
      limit: newLimit,
    });
  };

  onChangeCategorySlug = (categorySlug) => {
    const newCategorySlug = categorySlug;
    this.props.setAttributes({
      productCategorySlug: newCategorySlug,
    });
    this.setState({
      productCategorySlug: newCategorySlug,
    });
  };

  toggleNewestFirst = (checked) => {
    const newOrder = checked;
    this.props.setAttributes({
      newestFirst: newOrder,
    });
    this.getProducts().then((posts) => {
      this.setState({
        newestFirst: newOrder,
        posts,
      });
    });
  };

  getProducts = () => {
    // Get the category ID from category slug
    // The Woocommerce REST API v3 only supports query by only one category id
    // However, the WC_Product_Query filters by category slug. Because of this,
    // the original argument is the slug of the category. It also supports
    // querying with multiple categories.
    const categoriesArray = [...this.state.categories];

    const categorySlug = this.state.productCategorySlug || '';

    const queryArgs = {
      order: this.state.newestFirst ? 'desc' : 'asc',
      orderby: 'date',
      stock_status: 'instock',
      per_page: this.state.limit,
    };

    if (categorySlug && categoriesArray.length > 0) {
      const categoryId = categoriesArray.filter(
        (cat) => categorySlug == cat.slug
      )[0].id;

      queryArgs['category'] = categoryId;
    }

    console.log(queryArgs);

    const path = '/wc/v3/products';

    return apiFetch({
      path: addQueryArgs(path, { ...queryArgs }),
    });
  };

  // Query all product categories for select filed
  getCategories = () => {
    const queryArgs = {
      per_page: -1,
    };
    return apiFetch({
      path: addQueryArgs('/wc/v3/products/categories', { ...queryArgs }),
    });
  };

  getTheTitle = () => {
    if (this.state.productCategorySlug && this.state.categories.length > 0) {
      return (
        <h2 className='mb-0 mt-5'>
          {this.state.productCategorySlug &&
            this.state.categories.length > 0 &&
            this.state.categories.filter(
              (cat) => cat.slug === this.state.productCategorySlug
            )[0].name}
        </h2>
      );
    } else {
      return (
        <h2 className='mb-0 mt-5'>
          {__('Choose a category - its name will appear here...', 'reactwp')}
        </h2>
      );
    }
  };

  render() {
    const { className, attributes } = this.props;
    const { newestFirst, limit, productCategorySlug } = attributes;

    return (
      <>
        <InspectorControls>
          <PanelBody label={__('Post Settings', 'reactwp-blocks')}>
            <SelectControl
              className='select-multiple'
              label={__('Categories', 'reactwp-blocks')}
              options={
                this.state.categories &&
                this.state.categories.map((category) => ({
                  value: category.slug,
                  label: category.name,
                }))
              }
              value={productCategorySlug}
              onChange={this.onChangeCategorySlug}></SelectControl>
            <ToggleControl
              label={__('Newest products first', 'reactwp-blocks')}
              onChange={this.toggleNewestFirst}
              checked={newestFirst}></ToggleControl>
            <RangeControl
              label={__('Number of Products to Show', 'reactwp-blocks')}
              value={limit}
              onChange={this.onChangeLimit}
              min={1}
              max={10}></RangeControl>
          </PanelBody>
        </InspectorControls>
        {this.state.posts && this.state.posts.length > 0 ? (
          <>
            {this.getTheTitle()}
            <div
              className={
                className +
                ' row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-4 g-4'
              }>
              {this.state.posts.map((post) => (
                <div className='col' key={post.id}>
                  <div className='card h-100 d-flex text-center'>
                    {post.on_sale && (
                      <span className='badge bg-danger sale'>%</span>
                    )}
                    <img
                      src={post.images[0].src}
                      className='card-img-top'
                      alt={post.name}
                    />

                    <div className='card-body d-flex flex-column'>
                      <h3 className='card-title product_title entry-title'>
                        {decodeEntities(post.name)}
                      </h3>
                      {post.rating_count && (
                        <p>
                          {__('Average rating: ', 'reactwp') +
                            post.average_rating +
                            ' (' +
                            post.rating_count +
                            ')'}
                        </p>
                      )}

                      <p className='price mb-3'>{parse(post.price_html)}</p>
                      <p className='card-text'>
                        {parse(post.short_description)}
                      </p>

                      <div className='add-to-cart-container mt-auto'>
                        <a
                          href=''
                          className='add_to_cart_button btn btn-primary'>
                          {post.button_text
                            ? post.button_text
                            : __('Add to cart', 'reactwp')}
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </>
        ) : (
          <div>{__('No Products Found', 'reactwp-blocks')}</div>
        )}
      </>
    );
  }
}

export default LatestProductsEdit;
