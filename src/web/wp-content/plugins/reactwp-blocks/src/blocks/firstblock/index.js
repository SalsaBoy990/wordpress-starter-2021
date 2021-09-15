var registerBlockType = wp.blocks.registerBlockType;
var __ = wp.i18n.__;

var el = wp.element.createElement;

registerBlockType('reactwp-blocks/firstblock', {
  title: __('First Block', 'reactwp-blocks'),
  description: __('This Is The First Block', 'reactwp-blocks'),
  category: 'layout',
  icon: {
    src: 'admin-network',
    background: '#f03',
    foreground: '#fff',
  },
  keywords: [__('photo', 'reactwp-blocks'), __('image', 'reactwp-blocks')],
  edit: function () {
    return el('p', null, 'Editor');
  },
  save: function () {
    return el('p', null, 'Save content');
  },
});
