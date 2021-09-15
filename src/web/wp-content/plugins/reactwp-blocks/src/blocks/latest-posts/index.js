import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import edit from './edit';
import './style.editor.scss';

registerBlockType('reactwp-blocks/latest-posts', {
  title: __('Latest Posts', 'reactwp-blocks'),
  description: __('Latest Posts Block', 'reactwp-blocks'),
  category: 'reactwp-category',
  icon: {
    src: 'admin-post',
    background: '#f03',
    foreground: '#fff',
  },
  /*attributes: {
    numberOfPosts: {
      type: 'number',
      default: 3,
    },
    postCategories: {
      type: 'string',
    },
  },*/

  edit: edit,
  // eslint-disable-next-line react/display-name
  // Dynamic block, need to return null!!!
  // The content of the block will be generated server-side
  save: function () {
    return null;
  },
});
