import { Component } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';
import { withSelect } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { RangeControl, PanelBody, SelectControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';

import './style.editor.scss';

class LatestPostsEdit extends Component {
  state = {
    postCategory: '',
    categories: [],
    taxImageUrl: '',
  };

  componentDidMount() {
    this.setState({
      postCategory: this.props.attributes.postCategory,
      categories: this.props.categories,
    });

    this.getTaxonomyImageUrl().then((response) => {
      if (parseInt(response.status, 10) === 200) {
        const taxImageUrl = decodeURI(response.image_url);

        this.setState({
          taxImageUrl,
        });
      } else {
        console.error(response.description);
      }
    });
  }

  componentDidUpdate(prevProps, prevState) {
    if (prevProps.categories !== this.props.categories) {
      this.setState({
        postCategory: this.props.attributes.postCategory,
        categories: this.props.categories,
      });
    }
    if (prevState.postCategory !== this.state.postCategory)
      this.getTaxonomyImageUrl().then((response) => {
        if (parseInt(response.status, 10) === 200) {
          const taxImageUrl = decodeURI(response.image_url);

          this.setState({
            taxImageUrl,
          });
        } else {
          console.error(response.description);
        }
      });
  }

  onChangeNumberOfPosts = (numberOfPosts) => {
    this.props.setAttributes({ numberOfPosts });
  };

  onChangeCategory = (category) => {
    this.props.setAttributes({
      postCategory: category,
    });
  };

  getTaxonomyImageUrl = () => {
    const taxId = this.props.attributes.postCategory;

    if (taxId) {
      const queryArgs = {
        option_name: '_category_image-' + taxId,
      };
      const path = '/wp-custom-taxonomy-image/v1/image';
      return apiFetch({
        path: addQueryArgs(path, { ...queryArgs }),
      });
    }

    return null;
  };

  render() {
    const { posts, categories, className, attributes } = this.props;
    const { numberOfPosts, postCategory } = attributes;

    const categoryMeta =
      this.state.categories &&
      this.state.categories.filter((cat) => cat.id == this.state.postCategory);

    let categoryName = '';
    let categoryDescription = '';

    if (categoryMeta && categoryMeta.length > 0) {
      categoryName = categoryMeta[0].name;
      categoryDescription = categoryMeta[0].description;
    }

    return (
      <>
        <InspectorControls>
          <PanelBody label={__('Post Settings', 'reactwp-blocks')}>
            <SelectControl
              label={__('Category', 'reactwp-blocks')}
              options={
                categories &&
                categories.map((category) => ({
                  value: category.id,
                  label: category.name,
                }))
              }
              value={postCategory}
              onChange={this.onChangeCategory}></SelectControl>
            <RangeControl
              label={__('Number of Posts', 'reactwp-blocks')}
              value={numberOfPosts}
              onChange={this.onChangeNumberOfPosts}
              min={1}
              max={10}></RangeControl>
          </PanelBody>
        </InspectorControls>
        {posts && posts.length > 0 ? (
          <div className={className + ' col'}>
            <div className='card'>
              <img
                src={this.state.taxImageUrl ? this.state.taxImageUrl : '#'}
                className='card-img card-img-darken'
                alt={categoryName}
              />
              <div className='card-body'>
                <h3 className='card-title'>{categoryName}</h3>
                <p className='card-text'>{categoryDescription}</p>
              </div>
              <ul className='list-group list-group-flush'>
                {posts.map((post) => (
                  <li key={post.id} className='list-group-item'>
                    <a href=''>{decodeEntities(post.title.rendered)}</a>
                  </li>
                ))}
              </ul>
            </div>
          </div>
        ) : (
          <div>{__('No Posts Found', 'reactwp-blocks')}</div>
        )}
      </>
    );
  }
}

export default withSelect((select, props) => {
  const { attributes } = props;
  const { numberOfPosts, postCategory } = attributes;
  let query = { per_page: numberOfPosts };
  if (postCategory) {
    query['categories'] = postCategory;
  }

  return {
    posts: select('core').getEntityRecords('postType', 'post', query),
    categories: select('core').getEntityRecords('taxonomy', 'category', {
      per_page: -1,
    }),
  };
})(LatestPostsEdit);
