import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InnerBlocks } from '@wordpress/block-editor';

registerBlockType('reactwp-blocks/team-members', {
  title: __('Team Members', 'reactwp-blocks'),
  description: __(
    'Container block showing team member blocks',
    'reactwp-blocks'
  ),
  category: 'reactwp-category',
  icon: 'grid-view',
  keywords: [
    __('team', 'reactwp-blocks'),
    __('member', 'reactwp-blocks'),
    __('person', 'reactwp-blocks'),
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
