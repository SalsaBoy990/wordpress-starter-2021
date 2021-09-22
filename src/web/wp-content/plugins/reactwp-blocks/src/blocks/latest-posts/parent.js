import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InnerBlocks } from '@wordpress/block-editor';

 registerBlockType('reactwp-blocks/posts-grid', {
  title: __('Posts Grid Layout', 'reactwp-blocks'),
  description: __(
    'Container block showing cards with latest posts by categories',
    'reactwp-blocks'
  ),
  category: 'reactwp-category',
  icon: 'grid-view',
  keywords: [
    __('grid', 'reactwp-blocks'),
    __('posts', 'reactwp-blocks'),
    __('card', 'reactwp-blocks'),
  ],
  // eslint-disable-next-line react/display-name
  edit: ({ className }) => {
    return (
      <div className={className}>
        <InnerBlocks />
      </div>
    );
  },
  // eslint-disable-next-line react/display-name
  save: () => {
    return (
      <div>
        <InnerBlocks.Content />
      </div>
    );
  },
});
