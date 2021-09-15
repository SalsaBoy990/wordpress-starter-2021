import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import edit from './edit';
import './style.editor.scss';

registerBlockType('reactwp-blocks/latest-products', {
  title: __('Latest Woocommerce Products', 'reactwp-blocks'),
  description: __('Latest Woocommerce Products Block', 'reactwp-blocks'),
  category: 'reactwp-category',
  icon: (
    <svg
      xmlns='http://www.w3.org/2000/svg'
      height='24px'
      viewBox='0 0 24 24'
      width='24px'
      fill='#000000'>
      <path d='M0 0h24v24H0V0z' fill='none' />
      <path d='M19 6h-2c0-2.76-2.24-5-5-5S7 3.24 7 6H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-3c1.66 0 3 1.34 3 3H9c0-1.66 1.34-3 3-3zm7 17H5V8h14v12zm-7-8c-1.66 0-3-1.34-3-3H7c0 2.76 2.24 5 5 5s5-2.24 5-5h-2c0 1.66-1.34 3-3 3z' />
    </svg>
  ),
  keywords: [
    __('woocommerce', 'reactwp-blocks'),
    __('product', 'reactwp-blocks'),
  ],
  edit: edit,
  // eslint-disable-next-line react/display-name
  // The content of the dynamic block will be generated server-side
  save: function () {
    return null;
  },
});
